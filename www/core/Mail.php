<?php 

namespace carsery\core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

class Mail {
    /*    private $sujet;
    private $message;
    private $email;
     */
    public function sendmail($sujet, $message, $email_send, bool $piece = NULL) {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->CharSet = 'utf-8';                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.office365.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'service.carsery@outlook.com';                     // SMTP username
            $mail->Password   = 'marwaneyoucef9392';                     // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('service.carsery@outlook.com', 'Carsery');
            $mail->addAddress($email_send);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            /*  $mail->addReplyTo('contact@relax.com', 'Information'); */
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            if($piece) {
                $tab = [];
                $maxSize = 500000;
                $validExt = ['.jpg', '.jpeg', '.png', '.pdf'];

                foreach ($_FILES['file']['error'] as $fichier) {
                    if ($fichier > 0) {
                        $tab[] = "transfert";
                        return $tab;
                    }
                }


                foreach ($_FILES['file']['size'] as $fichier) {
                    if ($fichier > $maxSize) {
                        $tab[] = "lourd";
                        return $tab;
                    }
                }


                foreach ($_FILES['file']['name'] as $fichier) {
                    $fileExt = "." . strtolower(substr(strrchr($fichier, '.'), 1));
                    if (!in_array($fileExt, $validExt)) {
                        $tab[] = "image";
                        return $tab;
                    }
                }

                for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                    $mail->addAttachment($_FILES['file']['tmp_name'][$i], $_FILES['file']['name'][$i]);
                }
            }

            /* $mail->addAttachment($piece);   */       // Add attachments
            /* $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); */    // Optional name
            /* $mail->AddEmbeddedImage("public/images/logomark_relax_white.png", "logo-white", "logomark_relax_white.png"); */
            
            
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $sujet;
            $mail->Body    = $message;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if($mail->send()){
                $tab[] = "success";
                return $tab;
            }else {
                $tab[] = "error";
                return $tab;
            }

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
