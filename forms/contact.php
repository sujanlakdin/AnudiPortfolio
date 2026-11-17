<?php
  /**
  * Requires the "PHP Email Form" library
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Real receiving email address for Anudi Weerasinghe
  $receiving_email_address = 'anudimudara@gmail.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    // Graceful fallback for static hosting
    $name = isset($_POST['name']) ? strip_tags($_POST['name']) : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $subject = isset($_POST['subject']) ? strip_tags($_POST['subject']) : '';
    $message = isset($_POST['message']) ? strip_tags($_POST['message']) : '';

    if (!empty($name) && !empty($email) && !empty($message)) {
      $headers = "From: " . $email . "\r\n";
      $headers .= "Reply-To: " . $email . "\r\n";
      $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
      $body = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
      
      @mail($receiving_email_address, "Portfolio Contact: $subject", $body, $headers);
      echo "OK";
      exit;
    } else {
      die("Please fill in all required fields.");
    }
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];

  $contact->add_message( $_POST['name'], 'From');
  $contact->add_message( $_POST['email'], 'Email');
  $contact->add_message( $_POST['message'], 'Message', 10);

  echo $contact->send();
?>
