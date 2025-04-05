<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['connexion'])) {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Connexion à la base de données
    try {
        $conn = new PDO("mysql:host=localhost;dbname=formation_professionnelle", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérification des informations de connexion
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];
            $message = "Connexion réussie!";
        } else {
            $message = "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        $message = "Erreur de connexion à la base de données: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
        .connexion-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .connexion-container h2 {
            margin-bottom: 20px;
        }
        .connexion-container input, .connexion-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .connexion-container button {
            background-color: #007bff;
            color: white;
            border: none;
            transition: background-color 0.3s ease-in-out;
        }
        .connexion-container button:hover {
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
    <div class="connexion-container">
        <h2>Connexion</h2>
        <?php if (isset($message)): ?>
            <p class="message <?php echo $message === 'Connexion réussie!' ? 'success' : ''; ?>"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="connexion.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit" name="connexion">Connexion</button>
        </form>
    </div>
</body>
</html>