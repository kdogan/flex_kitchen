<?php
include 'dbutility.php';

$to = 'user@example.com';
$subject = "Rechung von Getränke für Monat ".date('M');

$htmlContent = '
    <html>
    <head>
        <title>Welcome to CodexWorld</title>
    </head>
    <body style="width: 100%;">
      <h3>Hallo Max,</h3>
      <p>hiermit senden wir Dir die Rechnung von Getränke im Monat Mai.</p>
      <table style="width: 98%;border: 2px slid #FB4314; height: 200px; padding-right:10px;">
            <tr>
                <th>Getränk</th> <th>Anzhal</th> <th>Preis</th>
            </tr>
            <tr style="background-color: #e0e0e0;">
                <td>Cola 800 ml</td><td>20</td><td>12 euro</td>
            </tr>
            <tr>
               <td>Cola 800 ml</td><td>20</td><td>12 euro</td>
            </tr>
      </table>
      <hr style="width:98%; float:left"/>
      <table style="float:right; margin-right:20px">
        <th>Total:</th><th>200 Euro</th>
      </table><br/><br/>
      <p>Du kannst beim Admin bar bezahlen</p>
      <p>Dies ist eine automatisch erstellte E-Mail. Bitte ANTWORTEN SIE NICHT auf diese Mail</p>
    </body>
    </html>';

// Set content-type header for sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Additional headers
$headers .= 'From: CodexWorld<sender@example.com>' . "\r\n";
$headers .= 'Cc: welcome@example.com' . "\r\n";
$headers .= 'Bcc: welcome2@example.com' . "\r\n";

// Send email
if(mail($to,$subject,$htmlContent,$headers)):
    $successMsg = 'Email has sent successfully.';
else:
    $errorMsg = 'Email sending fail.';
endif;
?>