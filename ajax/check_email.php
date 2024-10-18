<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        $data = json_decode(file_get_contents('php://input'), true);

        $email = $data['email'];

        if (empty($email)) {
            echo json_encode(
                [
                    'status' => 300,
                    'errorText' => "Email is not valid",
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

                echo json_encode(
                    [
                        'status' => 200,
                        'exist' => false,
                    ]
                );
            }
        }
    } catch (Exception $e) {
        echo json_encode(
            [
                'status' => $e->getCode(),
                'errorText' => $e->getMessage(),
            ]
        );
    }
}