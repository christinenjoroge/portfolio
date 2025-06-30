<?php
use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $firstname = htmlspecialchars(trim($_POST['firstname']));
      $lastname =htmlspecialchars(trim($_POST['lastname']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

          $message =htmlspecialchars(trim($_POST['message']));

          if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            echo "Invalid email address.";
            
            header("Location:index.php"); // replace with your actual URL
    exit;
          }

          $mail = new PHPMailer (true);

          try{
            $mail ->isSMTP();
            $mail ->Host='smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username='designchristine84@gmail.com';
            $mail->Password ='hxhl txnl atmy myel';
            $mail->SMTPSecure= PHPMailer :: ENCRYPTION_STARTTLS;
            $mail->Port =587;

           


            $mail->setFrom('designchristine84@gmail.com', 'Christine');
             $mail->addAddress('designchristine84@gmail.com', 'Christine');
          $mail->addReplyTo($email, "$firstname $lastname");


            $mail->Subject="New message from submission";
            $mail->Body="First Name: $firstname\n";
            $mail->Body.=  "Last Name: $lastname\n";
            $mail->Body.="Email: $email\n";
            $mail->Body.= "Message: $message\n";



            // === 2. Send confirmation to CLIENT ===
        $clientMail = new PHPMailer(true);
        $clientMail->isSMTP();
        $clientMail->Host       = 'smtp.gmail.com';
        $clientMail->SMTPAuth   = true;
        $clientMail->Username   = 'designchristine84@gmail.com';
        $clientMail->Password   = 'hxhl txnl atmy myel'; // Your app password
        $clientMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $clientMail->Port       = 587;

        $clientMail->setFrom('designchristine84@gmail.com', 'Christine');
        $clientMail->addAddress($email, "$firstname $lastname");
        
        $clientMail->isHTML(true);
        $clientMail->Subject = "Thank you for contacting me";
        $clientMail->Body = "<p>Hi <strong>$firstname</strong>,<br>
        Thank you for getting in touch. I have received your message and will get back to you shortly.<br> Best regards,<br>ChristineNjoroge </p>";

        $clientMail->send();


        if($mail -> send ()){
            echo "Message sent successfully";
        }else{
            echo"message not sent";
        }
    }catch (Exception $e) {
      echo "Error sending message: " . $mail->ErrorInfo;
    }


          }

?>