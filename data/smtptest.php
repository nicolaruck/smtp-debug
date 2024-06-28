<?php
error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
$response = ['success' => false, 'message' => '', 'debug' => ''];
$debugOutput = '';

// Eigener Debug-Output-Handler
$mail->SMTPDebug = 2; // Vollständiges Debugging einschalten
$mail->Debugoutput = function($str, $level) use (&$debugOutput) {
    $debugOutput .= htmlspecialchars($str)."\n"; // Debug-Informationen sammeln und HTML-sicher machen
};

try {
    $mail->isSMTP();
    $mail->Host = $_POST['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $_POST['username'];
    $mail->Password = $_POST['password'];
    $mail->SMTPSecure = $_POST['security'];
    $mail->Port = $_POST['port'];

    $mail->setFrom($_POST['sender'], 'SMTP Tester');
    $mail->addAddress($_POST['recipient']);

    $mail->isHTML(true);
    $mail->Subject = 'SMTP Testnachricht';
    $mail->Body = 'Das ist eine SMTP-Testnachricht.';
    //$mail->addAttachment('eicar_com.zip');
    $mail->send();
    $response['success'] = true;
    $response['message'] = 'Nachricht wurde erfolgreich versendet.';
} catch (Exception $e) {
    $response['message'] = "Nachricht konnte nicht versendet werden. Mailer Error: {$mail->ErrorInfo}";
}

$response['debug'] = $debugOutput;

header('Content-Type: application/json');
echo json_encode($response);
?>
