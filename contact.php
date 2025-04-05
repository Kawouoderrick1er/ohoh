<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Contactez-nous</h2>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                Votre message a été envoyé avec succès.
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                Une erreur s'est produite lors de l'envoi de votre message. Veuillez réessayer.
            </div>
        <?php endif; ?>
        <form action="send_contact.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" name="envoyer" value="envoyer" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>