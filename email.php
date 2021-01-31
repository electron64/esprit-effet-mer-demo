<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors = [];
$errorMessage = '';



if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (empty($name)) {
        $errors[] = 'Le champ est Nom vide';
    }
    //secure email
    if ( preg_match( "/[\r\n]/", $name ) || preg_match( "/[\r\n]/", $email ) ) {
        header("location : http://www.example.com/mail-error.php");
    }

    if (empty($email)) {
        $errors[] = 'Email non renseigné';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email invalide';
    }

    if (empty($message)) {
        $errors[] = 'Le champ Message est vide';
    }


    if (empty($errors)) {
        $toEmail = 'example@example.com';
        $emailSubject = 'Nouvel email de votre site web';
        $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=iso-8859-1'];

        $bodyParagraphs = ["Name: {$name}", "Email: {$email}", "Message:", $message];
        $body = join(PHP_EOL, $bodyParagraphs);

        if (mail($toEmail, $emailSubject, $body, $headers)) {
            header('Location: thank-you.html');
        } else {
            $errorMessage = 'Oops, il y a eu une erreur.';
        }
    } else {
        $allErrors = join('<br/>', $errors);
        $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
    }
}

?>