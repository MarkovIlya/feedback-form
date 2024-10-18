<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/dbconn.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $phone = $data['phone'];
    $email = $data['email'];
    $message = $data['message'];

    $errors = [];

    if (empty($name) || preg_match('/\d/', $name)) {
        $errors[] = 'Please enter a valid name without numbers.';
    }

    if (!preg_match('/^\d{10,12}$/', $phone)) {
        $errors[] = 'Please enter a valid phone number (10-12 digits).';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (empty($message)) {
        $errors[] = 'Please enter your message.';
    }

    if (!empty($errors)) {
        echo json_encode(
            [
                'status' => 300,
                'errorText' => "Form is not valid",
                'errors' => $errors
            ]
        );
    } else {

        $stmt = $pdo->prepare('SELECT * FROM contacts WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            echo json_encode(
                [
                    'status' => 200,
                    'exist' => true,
                ]
            );
        } else {
            $stmt = $pdo->prepare('INSERT INTO contacts (name, phone, email, message) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $phone, $email, $message]);

            $to = 'kudruavcev@aisol.ru';
            $subject = 'New Contact Form Submission';
            $body = "Name: $name\nPhone: $phone\nE-mail: $email\nMessage:\n$message";
            $headers = 'From: no-reply@yourdomain.com' . "\r\n";

            mail($to, $subject, $body, $headers);

            echo json_encode(
                [
                    'status' => 200,
                    'exist' => false,
                ]
            );
        }


    }
}
?>