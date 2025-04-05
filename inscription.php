<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscrire'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirmer_mot_de_passe = $_POST['confirmer_mot_de_passe'];

    if ($mot_de_passe === $confirmer_mot_de_passe) {
        // Hash du mot de passe
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Connexion à la base de données
        try {
            $conn = new PDO("mysql:host=localhost;dbname=formation_professionnelle", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insertion des données dans la table utilisateurs
            $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, type_utilisateur) VALUES (:nom, :email, :mot_de_passe, 'etudiant')";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mot_de_passe', $mot_de_passe_hash);

            if ($stmt->execute()) {
                $message = "Inscription réussie!";
            } else {
                $message = "Erreur lors de l'inscription.";
            }
        } catch (PDOException $e) {
            $message = "Erreur de connexion: " . $e->getMessage();
        }
    } else {
        $message = "Les mots de passe ne correspondent pas.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .inscription-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .inscription-container h2 {
            margin-bottom: 20px;
        }
        .inscription-container input, .inscription-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .inscription-container button {
            background-color: #007bff;
            color: white;
            border: none;
            transition: background-color 0.3s ease-in-out;
        }
        .inscription-container button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-bottom: 20px;
            color: red;
        }
        .message.success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="inscription-container">
        <h2>Inscription</h2>
        <?php if (isset($message)): ?>
            <p class="message <?php echo $message === 'Inscription réussie!' ? 'success' : ''; ?>"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="inscription.php" method="post">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <input type="password" name="confirmer_mot_de_passe" placeholder="Confirmer le mot de passe" required>
            <button type="submit" name="inscrire">S'inscrire</button>
        </form>
    </div>
</body>
</html>