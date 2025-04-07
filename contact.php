<?php
use PHPMailer\PHPMailer\PHPMailer;
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
$mailtosend = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$btn = filter_input(INPUT_POST, 'envoyer', FILTER_SANITIZE_SPECIAL_CHARS);
require_once "send_contact.php";
if(isset($btn) && $btn =="envoyer"){
    $mail = new PHPMailer(true);
        envoiemail($mail, $mailtosend, $message);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .form-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }
        .submit-btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
    <!-- include 'navigation.php'; -->
</head>
<body>
    <div class="form-container">
        <h2>formulaire de contact</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="email">Adresse email:</label>
                <input type="email" id="email" name="email" placeholder="votre email" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="message">votre message:</label>
                <input type="text" id="message" name="message" placeholder="votre message" autocomplete="off" required>
            </div>
            <button type="submit" name="envoyer" value="envoyer" class="submit-btn">Envoyer</button>
        </form>
    </div>
</body>
</html>