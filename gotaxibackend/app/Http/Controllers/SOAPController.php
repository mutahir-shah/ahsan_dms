<?php

namespace App\Http\Controllers;

use DOMDocument;
use Exception;
use Illuminate\Http\Request;
use RobRichards\WsePhp\WSSESoap;
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;

class SOAPController extends Controller
{
    public function test()
    {
        // Establece el límite de tiempo a 300 segundos (5 minutos)
        set_time_limit(300);

        $soap_request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:vtc="http://mfom.com/vtc">
        <soapenv:Header></soapenv:Header>
        <soapenv:Body>
            <vtc:qaltavtc>
                <header fecha="2019-01-01T12:29:00" version="1.0" versionsender="1.0"/>
                <body>
                <vtcservicio cgmunicontrato="079" cgmunifin="079" cgmuniinicio="079" cgmunilejano="079" cgprovcontrato="28" cgprovfin="28" cgprovinicio="28" cgprovlejano="28" direccionfin="destino" direccioninicio="origen" direccionlejano="lejano" fcontrato="2023-01-01T13:00:00" ffin="2023-12-31" fprevistainicio="2023-12-30T15:00:00" matricula="9890-GCF" nif="B44796696" niftitular="99999999R" nom="INTERMEDIARIO" nombtitular="TITULAR" veraz="S"/>
                </body>
            </vtc:qaltavtc>
        </soapenv:Body>
        </soapenv:Envelope>';

        // Carga el documento SOAP en un DOMDocument.
        $doc = new DOMDocument();
        $doc->loadXML($soap_request);

        // Crea un objeto WSSESoap.
        $wsse = new WSSESoap($doc);


        // Carga la clave privada.
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type' => 'private'));
        $objKey->loadKey(asset('certificadodigital/clave_privada.pem'), true);


        // Añade la firma.
        $options = array(
            'insertBefore' => false,
            'canonical' => true,
            'prefix' => 'wsse'
        );
        $wsse->signSoapDoc($objKey, $options);


        $token = $wsse->addBinaryToken(file_get_contents(asset('certificadodigital/certificado.pem')));


        // Obtén los valores de 'URI' y 'wsu:Id' del BinarySecurityToken.
        $binarySecurityTokenURI = $token->getAttribute('URI');
        $binarySecurityTokenId = $token->getAttribute('wsu:Id');


        // Guarda el mensaje SOAP firmado.
        $signedSoapRequest = $wsse->saveXML();

        // Carga el mensaje SOAP firmado en un nuevo DOMDocument.
        $doc = new DOMDocument();
        $doc->loadXML($signedSoapRequest);

        // Crea un nuevo objeto XMLSecurityDSig.
        $objDSig = new XMLSecurityDSig();

        // Utiliza el método estático para localizar la firma en el documento.
        $sigElement = $objDSig->locateSignature($doc);
        if ($sigElement == NULL) {
            throw new Exception("No se puede localizar el elemento de la firma en el documento.");
        }

        $objDSig->add509Cert(file_get_contents(asset('certificadodigital/certificado.pem')));

        // Obtener el URI del ds:Reference (Signature) y setearlo a wsu:id del soapen:Body

        $elemento = $doc->getElementsByTagNameNS('http://www.w3.org/2000/09/xmldsig#', 'Reference')->item(0);

        $uri = $elemento->getAttribute('URI');


        $bodyElement = $doc->getElementsByTagNameNS('http://schemas.xmlsoap.org/soap/envelope/', 'Body')->item(0);
        $bodyElement->setAttributeNS('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd', 'wsu:Id', ltrim($uri, '#')); //CH: he quitado la amohadilla del URI, que la estaba trasladando al Body wsu:id


        // Extraemos el wsu:id del Binary Security Token para setearlo en el URI del wsse.Refrence (dentro de wsse:SecurityTokenReference)

        $binarySecurityTokenElement = $doc->getElementsByTagNameNS('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'BinarySecurityToken')->item(0);
        $binarySecurityTokenId = $binarySecurityTokenElement->getAttributeNS('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd', 'Id');


        // Encuentra el nodo KeyInfo existente.
        $keyInfoElement = $doc->getElementsByTagNameNS('http://www.w3.org/2000/09/xmldsig#', 'KeyInfo')->item(0);

        // Crea un nuevo nodo SecurityTokenReference.
        $securityTokenReferenceElement = $doc->createElementNS('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'wsse:SecurityTokenReference');
        $securityTokenReferenceElement->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:wsu', 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd');
        $securityTokenReferenceElement->setAttribute('wsu:Id', 'STR' . $binarySecurityTokenId);

        // Crea un nuevo nodo Reference.
        $referenceElement = $doc->createElementNS('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'wsse:Reference');
        $referenceElement->setAttribute('URI', '#' . $binarySecurityTokenId);
        $referenceElement->setAttribute('ValueType', 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3');

        // Añade el nodo Reference al nodo SecurityTokenReference.
        $securityTokenReferenceElement->appendChild($referenceElement);

        // Añade el nodo SecurityTokenReference al nodo KeyInfo.
        $keyInfoElement->appendChild($securityTokenReferenceElement);

        $soapRequestWithReference = $doc->saveXML();
        echo 'Soap Request With Reference: ' . $soapRequestWithReference;
        echo '<br/>';

        $url = 'https://presede.mitma.gob.es/MFOM.Services.VTC.Server/VTCPort?wsdl';  // URL del servicio SOAP.
        // $url = 'https://sede.mitma.gob.es/MFOM.Services.VTC.Server/VTCPort?wsdl';  // URL del servicio SOAP.

        // Inicializa cURL.
        $ch = curl_init($url);

        // Habilita la depuración de cURL.
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        // Configura las opciones de cURL.
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soapRequestWithReference);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Aumenta el tiempo de espera a, por ejemplo, 60 segundos.
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);

        // Desactiva la verificación del certificado SSL.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Ejecuta la solicitud.
        $response = curl_exec($ch);
        if ($response === false) {
            // cURL retornó un error.
            $error = curl_error($ch);
            echo "Error en cURL: $error";
            echo '<br/>';
        } else {
            // cURL no retornó un error. Imprime la respuesta.
            echo 'Response: ' . $response;
            echo '<br/>';
        }

        // Cierra cURL.
        curl_close($ch);
    }
}
