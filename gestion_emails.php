<?php
// Démarrer la session pour la sécurité
session_start();

// --- Vérification de Sécurité Essentielle ---
// if (!isset($_SESSION['admin_id'])) {
//     http_response_code(403); // Forbidden
//     die("Accès refusé. Veuillez vous connecter en tant qu'administrateur.");
// }

// --- Inclusion de PHPMailer ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Charger l'autoloader de Composer (Assurez-vous que le chemin est correct)
// Si vendor est dans le même dossier que gestion_emails.php:
require 'vendor/autoload.php';
// Si vendor est un niveau au-dessus:
// require __DIR__ . '/../vendor/autoload.php';


// Initialiser les variables pour les messages d'affichage
$message_display = '';
$message_type = 'info'; // Types possibles: 'success', 'danger', 'warning', 'info'

// --- Traitement de la soumission du formulaire ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_email'])) {

    // Récupérer et valider/nettoyer les données du formulaire
    $recipient_email = filter_input(INPUT_POST, 'recipient_email', FILTER_VALIDATE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
    // Pour le corps, on autorise le HTML simple, mais on échappe pour l'affichage si besoin.
    // nl2br sera utilisé plus tard pour convertir les sauts de ligne en <br> pour le corps HTML.
    $body = $_POST['body'] ?? '';

    // Validation simple des champs requis
    if (!$recipient_email) {
        $message_display = "Erreur : L'adresse email du destinataire n'est pas valide.";
        $message_type = 'danger';
    } elseif (empty($subject)) {
        $message_display = "Erreur : Le sujet ne peut pas être vide.";
        $message_type = 'danger';
    } elseif (empty($body)) {
        $message_display = "Erreur : Le corps de l'email ne peut pas être vide.";
        $message_type = 'danger';
    } else {
        // Si la validation de base est OK, on tente d'envoyer l'email

        // Créer une nouvelle instance de PHPMailer; `true` active les exceptions
        $mail = new PHPMailer(true);

        try {
            // --- Paramètres Serveur (À CONFIGURER CORRECTEMENT AVEC VOS INFOS) ---
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Active le débogage détaillé - À METTRE À 0 ou DEBUG_OFF en production
            $mail->SMTPDebug = SMTP::DEBUG_OFF;      // Désactiver le débogage pour l'interface utilisateur
            $mail->isSMTP();                         // Utiliser SMTP
            $mail->Host       = 'smtp.gmail.com';    // !! METTRE VOTRE SERVEUR SMTP (ex: smtp.gmail.com) !!
            $mail->SMTPAuth   = true;                // Activer l'authentification SMTP
            $mail->Username   = 'kawouoderrick@gmail.com'; // !! METTRE VOTRE ADRESSE EMAIL SMTP !!
            $mail->Password   = 'hkebszfedxvgynis'; // !! METTRE VOTRE MOT DE PASSE SMTP (ou mot de passe d'application pour Gmail/2FA) !!
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Activer le chiffrement TLS implicite (souvent SMTPS)
            $mail->Port       = 465;                 // Port TCP; 465 pour SMTPS, 587 pour STARTTLS
            $mail->CharSet    = 'UTF-8';             // Spécifier l'encodage UTF-8 pour les caractères spéciaux

            // --- Destinataires ---
            // Utiliser l'adresse configurée comme expéditeur
            // !! METTRE VOTRE VRAIE ADRESSE D'EXPÉDITEUR ET NOM !!
            $mail->setFrom('kawouoderrick@gmail.com', 'Admin D-X-T'); // Qui envoie l'email
            // Ajouter le destinataire du formulaire
            $mail->addAddress($recipient_email);     // À qui envoyer l'email
            // $mail->addReplyTo('info@example.com', 'Information'); // Optionnel: Adresse de réponse différente
            // $mail->addCC('cc@example.com'); // Optionnel: Copie Carbone
            // $mail->addBCC('bcc@example.com'); // Optionnel: Copie Carbone Invisible

            // --- Pièces Jointes (Non implémenté dans ce formulaire simple) ---
            // Pour ajouter une pièce jointe, il faudrait un champ <input type="file"> et du code PHP pour gérer l'upload.
            // Exemple:
            // if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            //     $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
            // }

            // --- Contenu de l'Email ---
            $mail->isHTML(true); // Définir le format de l'email en HTML
            $mail->Subject = $subject; // Utiliser le sujet du formulaire

            // Préparer le corps : nl2br convertit les sauts de ligne en <br> pour le HTML
            // htmlspecialchars est utilisé ici pour la sécurité si on réaffiche $body ailleurs,
            // mais pour l'email lui-même, on veut potentiellement du HTML simple.
            $mail->Body    = nl2br(htmlspecialchars($body)); // Corps de l'email en HTML

            // Créer une version texte simple pour les clients mail qui ne lisent pas le HTML
            $mail->AltBody = $body; // Corps en texte brut (sans HTML)

            // Envoyer l'email
            $mail->send();
            $message_display = 'Email envoyé avec succès à ' . htmlspecialchars($recipient_email);
            $message_type = 'success';

        } catch (Exception $e) {
            // En cas d'erreur lors de l'envoi
            $message_display = "L'email n'a pas pu être envoyé. Erreur PHPMailer: " . htmlspecialchars($mail->ErrorInfo);
            $message_type = 'danger';
            // En production, il est préférable de logguer l'erreur détaillée plutôt que de l'afficher directement
            error_log("Mailer Error [gestion_emails.php]: {$mail->ErrorInfo}");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Emails</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour améliorer l'interface de gestion */
        .message { margin-bottom: 1.5rem; padding: 1rem; border-radius: 0.3rem; border: 1px solid transparent; }
        .message.success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .message.danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
        .message.warning { color: #664d03; background-color: #fff3cd; border-color: #ffecb5; }
        .message.info { color: #055160; background-color: #cff4fc; border-color: #b6effb; }
        .container {
            max-width: 800px; /* Limiter la largeur pour une meilleure lisibilité */
            margin-top: 2rem; /* Ajouter un peu d'espace en haut */
            margin-bottom: 2rem; /* Ajouter un peu d'espace en bas */
        }
        textarea {
            min-height: 200px; /* Augmenter la hauteur minimale pour le corps de l'email */
        }
        .form-label .text-danger { font-size: 0.9em; margin-left: 2px; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
             <h2 class="mb-0"><i class="fas fa-envelope-open-text me-2"></i>Gestion des Emails</h2>
             <!-- Optionnel: Bouton retour ou autre action -->
        </div>
        <hr>

        <!-- Zone d'affichage des messages (succès, erreur, etc.) -->
        <?php if (!empty($message_display)): ?>
            <div class="message alert alert-<?php echo htmlspecialchars($message_type); ?>" role="alert">
                <?php echo $message_display; // Le message contient déjà les échappements nécessaires ?>
            </div>
        <?php endif; ?>

        <!-- Avertissement important sur la configuration SMTP -->
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Attention :</strong> La configuration du serveur d'envoi (SMTP : Host, Username, Password, Port, etc.) doit être correctement définie dans le code PHP de ce fichier pour que l'envoi fonctionne. Les paramètres actuels sont ceux de `kawouoderrick@gmail.com` et nécessitent peut-être un mot de passe d'application si la 2FA est activée sur ce compte.
        </div>

        <!-- Formulaire d'envoi d'email -->
        <form action="gestion_emails.php" method="post">
            <div class="mb-3">
                <label for="recipient_email" class="form-label">Destinataire <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="recipient_email" name="recipient_email" placeholder="adresse.destinataire@exemple.com" required value="<?php echo isset($_POST['recipient_email']) ? htmlspecialchars($_POST['recipient_email']) : ''; ?>">
                <!-- Garder la valeur saisie en cas d'erreur -->
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Sujet <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Sujet de votre email" required value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Corps de l'email <span class="text-danger">*</span></label>
                <textarea class="form-control" id="body" name="body" rows="10" placeholder="Écrivez votre message ici..." required><?php echo isset($_POST['body']) ? htmlspecialchars($_POST['body']) : ''; ?></textarea>
                <div class="form-text">Vous pouvez utiliser du HTML simple si nécessaire (ex: &lt;b&gt;gras&lt;/b&gt;). Les sauts de ligne seront automatiquement convertis en &lt;br&gt;.</div>
            </div>

            <!-- Champ pour pièce jointe (non fonctionnel sans code PHP supplémentaire pour l'upload) -->
            <!--
            <div class="mb-3">
                <label for="attachment" class="form-label">Pièce jointe (Optionnel)</label>
                <input type="file" class="form-control" id="attachment" name="attachment">
                 <div class="form-text">Note: L'envoi de pièce jointe n'est pas activé dans cette version.</div>
            </div>
            -->

            <button type="submit" name="send_email" class="btn btn-primary">
                <i class="fas fa-paper-plane me-1"></i> Envoyer l'Email
            </button>
        </form>
    </div>

    <!-- Scripts JavaScript (Bootstrap requis) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
