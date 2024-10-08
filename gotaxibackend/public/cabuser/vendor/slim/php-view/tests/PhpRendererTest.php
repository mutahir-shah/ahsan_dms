<?php

use Slim\Http\Body;
use Slim\Http\Headers;
use Slim\Http\Response;

/**
 * Created by PhpStorm.
 * User: Glenn
 * Date: 2015-11-12
 * Time: 1:19 PM
 */
class PhpRendererTest extends PHPUnit_Framework_TestCase
{

    public function testRenderer()
    {
        $renderer = new \Slim\Views\PhpRenderer("tests/");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        $newResponse = $renderer->render($response, "testTemplate.php", array("hello" => "Hi"));

        $newResponse->getBody()->rewind();

        $this->assertEquals("Hi", $newResponse->getBody()->getContents());
    }

    public function testRenderConstructor()
    {
        $renderer = new \Slim\Views\PhpRenderer("tests");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        $newResponse = $renderer->render($response, "testTemplate.php", array("hello" => "Hi"));

        $newResponse->getBody()->rewind();

        $this->assertEquals("Hi", $newResponse->getBody()->getContents());
    }

    public function testAttributeMerging()
    {

        $renderer = new \Slim\Views\PhpRenderer("tests/", [
            "hello" => "Hello"
        ]);

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        $newResponse = $renderer->render($response, "testTemplate.php", [
            "hello" => "Hi"
        ]);
        $newResponse->getBody()->rewind();
        $this->assertEquals("Hi", $newResponse->getBody()->getContents());
    }

    public function testExceptionInTemplate()
    {
        $renderer = new \Slim\Views\PhpRenderer("tests/");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        try {
            $newResponse = $renderer->render($response, "testException.php");
        } catch (Throwable $t) { // PHP 7+
            // Simulates an error template
            $newResponse = $renderer->render($response, "testTemplate.php", [
                "hello" => "Hi"
            ]);
        } catch (\Exception $e) { // PHP < 7
            // Simulates an error template
            $newResponse = $renderer->render($response, "testTemplate.php", [
                "hello" => "Hi"
            ]);
        }

        $newResponse->getBody()->rewind();

        $this->assertEquals("Hi", $newResponse->getBody()->getContents());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExceptionForTemplateInData()
    {

        $renderer = new \Slim\Views\PhpRenderer("tests/");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        $renderer->render($response, "testTemplate.php", [
            "template" => "Hi"
        ]);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testTemplateNotFound()
    {

        $renderer = new \Slim\Views\PhpRenderer("tests/");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        $renderer->render($response, "adfadftestTemplate.php", []);
    }

    public function testLayout()
    {
        $renderer = new \Slim\Views\PhpRenderer("tests/", ["title" => "My App"]);
        $renderer->setLayout("testLayout.php");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        $newResponse = $renderer->render($response, "testTemplate.php", array("title" => "Hello - My App", "hello" => "Hi"));

        $newResponse->getBody()->rewind();

        $this->assertEquals("<html><head><title>Hello - My App</title></head><body>Hi</body></html>", $newResponse->getBody()->getContents());
    }

    public function testLayoutConstructor()
    {
        $renderer = new \Slim\Views\PhpRenderer("tests", ["title" => "My App"], "testLayout.php");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        $newResponse = $renderer->render($response, "testTemplate.php", array("title" => "Hello - My App", "hello" => "Hi"));

        $newResponse->getBody()->rewind();

        $this->assertEquals("<html><head><title>Hello - My App</title></head><body>Hi</body></html>", $newResponse->getBody()->getContents());
    }

    public function testExceptionInLayout()
    {
        $renderer = new \Slim\Views\PhpRenderer("tests/");
        $renderer->setLayout("testException.php");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        try {
            $newResponse = $renderer->render($response, "testTemplate.php");
        } catch (Throwable $t) { // PHP 7+
            // Simulates an error template
            $renderer->setLayout(null);
            $newResponse = $renderer->render($response, "testTemplate.php", [
                "hello" => "Hi"
            ]);
        } catch (\Exception $e) { // PHP < 7
            // Simulates an error template
            $renderer->setLayout(null);
            $newResponse = $renderer->render($response, "testTemplate.php", [
                "hello" => "Hi"
            ]);
        }

        $newResponse->getBody()->rewind();

        $this->assertEquals("Hi", $newResponse->getBody()->getContents());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testLayoutNotFound()
    {

        $renderer = new \Slim\Views\PhpRenderer("tests/");
        $renderer->setLayout("adfadftestLayout.php");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        $renderer->render($response, "testTemplate.php", []);
    }

    public function testContentDataKeyShouldBeIgnored()
    {
        $renderer = new \Slim\Views\PhpRenderer("tests/");
        $renderer->setLayout("testLayout.php");

        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);

        $newResponse = $renderer->render($response, "testTemplate.php", array("title" => "Hello - My App", "hello" => "Hi", "content" => "Ho"));

        $newResponse->getBody()->rewind();

        $this->assertEquals("<html><head><title>Hello - My App</title></head><body>Hi</body></html>", $newResponse->getBody()->getContents());
    }
}
