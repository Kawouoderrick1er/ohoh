<?php
// Importer les classes PHPMailer dans l’espace global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Charger l'autoload généré par Composer
require 'vendor/autoload.php';

// Fonction d'envoi d'email
function sendEmail($to, $from, $message) {
    $mail = new PHPMailer(true); // Crée une instance de PHPMailer avec gestion des exceptions

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();                                // Utiliser SMTP
        $mail->Host       = 'smtp.gmail.com';           // Adresse du serveur SMTP
        $mail->SMTPAuth   = true;                       // Activer l'authentification SMTP
        $mail->Username   = 'kawouoderrick@gmail.com';      // Ton adresse Gmail
        $mail->Password   = '237@derrick';         // Le mot de passe de ton application Gmail (voir explication ci-dessous)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;// Activer le chiffrement SSL/TLS
        $mail->Port       = 465;                         // Port sécurisé pour SMTP

        // Expéditeur et destinataire
        $mail->setFrom($from, 'Formulaire de contact'); // Email de l’expéditeur (celui qui remplit le formulaire)
        $mail->addAddress($to);                         // Email du destinataire (ex: toi-même)

        // Contenu de l’email
        $mail->isHTML(true);                            // Format HTML
        $mail->Subject = 'BIENVENUE CHEZ DIGITAL TECHNOLOGY';  // Sujet de l'email
        $mail->Body    = 'Message : <b>' . nl2br($message) . '</b>'; // Corps HTML
        $mail->AltBody = 'Message : ' . $message;       // Version texte brut (fallback)

        $mail->send();
        return true; // Succès
    } catch (Exception $e) {
        return false; // Erreur
    }
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['envoyer'])) {
    $email = $_POST['email'];    // Email de l'expéditeur
    $message = $_POST['message'];

    // Adresse à laquelle tu veux recevoir tous les messages
    $destinataire = 'ton_email@gmail.com'; 

    if (sendEmail($destinataire, $email, $message)) {
        header("Location: contact.php?success=1"); // Succès
    } else {
        header("Location: contact.php?error=1");   // Erreur
    }
} else {
    header("Location: contact.php"); // Rediriger si mauvaise requête
    exit();
}
