<?php
/*-----------------------------------------------
	# Variables
	---------------------------------------------*/

$class = isset($_POST['radio_group']) && !empty($_POST['radio_group']) ? $_POST['radio_group'] : '';
$name = $_POST['name'];
$sdestination = $_POST['sdestination'];
$edestination = $_POST['edestination'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$type = $_POST['type'];
$toMail = 'KwendaZM <drive@kwendazm.com>'; // Your name & mail address here example 'Your Name <contact@domain.com>'.

/*-----------------------------------------------
	# Error Reporting need first
	---------------------------------------------*/
$error = false;
$msg = '';
$body = '';


// Check Name
if (empty($class)) {
    $error = true;
    $msg .= '<strong>Required:</strong> Please enter your class.';
    $msg .= '<br>';
} else {
    $body .= '<strong>Class:</strong> ' . $class;
    $body .= '<br><br>';
}


// Check Name
if (empty($name)) {
    $error = true;
    $msg .= '<strong>Required:</strong> Please enter your name.';
    $msg .= '<br>';
} else {
    $body .= '<strong>Name:</strong> ' . $name;
    $body .= '<br><br>';

    // Body Content
    $body .= '<strong>Phone:</strong> ' . $phone;
    $body .= '<br><br>';
}

// Check Content
if (empty($name)) {
    $error = false;
    $msg .= '<strong>Required: </strong> Please write something. Can\'t here you from our home';
    $msg .= '<br>';
} else {
    // Date
    $body .= '<strong>Date:</strong> ' . $date;
    $body .= '<br><br>';
}


// Check Start Destination
if (empty($sdestination)) {
    $error = true;
    $msg .= '<strong>Required:</strong> Please enter your Start destination.';
    $msg .= '<br>';
} else {
    $body .= '<strong>Start Destination:</strong> ' . $sdestination;
    $body .= '<br><br>';
}

// Check End Destination
if (empty($edestination)) {
    $error = true;
    $msg .= '<strong>Required:</strong> Please enter your End destination.';
    $msg .= '<br>';
} else {
    $body .= '<strong>End Destination:</strong> ' . $edestination;
    $body .= '<br><br>';
}

// Check Date And Time
if (empty($type)) {
    $error = true;
    $msg .= '<strong>Required:</strong> Please enter Car Type.';
    $msg .= '<br>';
} else {
    $body .= '<strong>Car Type:</strong> ' . $type;
    $body .= '<br><br>';
}


/*-----------------------------------------------
	# Prepare send mail
	---------------------------------------------*/
if ($error == true) {
    $msg .= '<strong>Error:</strong> Please fill form with above info requirement.';
} else {
    $body .= $_SERVER['HTTP_REFERER'] ? '<br><br><br>This form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';
    $error = false;
    $msg .= '<strong>Success:</strong> Your message has been send.';

    // Mail Headers
    $headers = array();
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type: text/html; charset=iso-8859-1";
    // $headers[] = "From: {$name} <{$email}>";
    // $headers[] = "Reply-To: {$name} <{$email}>";
    $headers[] = "Class: {$class}";
    $headers[] = "X-Mailer: PHP/" . phpversion();

    mail($toMail, $date, $body, implode("\r\n", $headers));
}

// Make as json obj
$dataReturn = array(
    'error' => $error,
    'message' => $msg,
    'data' => array(
        'class' => $class,
        'name' => $name,
        'email' => $phone,
        'date' => $date,
        'sdestination' => $sdestination,
        'edestination' => $edestination,
        'type' => $type,
    )
);
header('Content-type: application/json');
echo json_encode($dataReturn);