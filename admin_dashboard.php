<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            position: fixed;
            width: 250px;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="#" onclick="showSection('apprenants')">Gestion des Apprenants</a>
        <a href="#" onclick="showSection('formations')">Gestion des Formations</a>
        <a href="#" onclick="showSection('administrateurs')">Gestion des Administrateurs</a>
        <a href="#" onclick="showSection('emails')">Gestion des Emails</a>
        <a href="admin_logout.php">Déconnexion</a>
    </div>
    <div class="content">
        <div id="apprenants" class="table-container">
            <h3>Gestion des Apprenants</h3>
            <!-- Tableau de gestion des apprenants -->
        </div>
        <div id="formations" class="table-container" style="display:none;">
            <h3>Gestion des Formations</h3>
            <!-- Tableau de gestion des formations -->
        </div>
        <div id="administrateurs" class="table-container" style="display:none;">
            <h3>Gestion des Administrateurs</h3>
            <!-- Tableau de gestion des administrateurs -->
        </div>
        <div id="emails" class="table-container" style="display:none;">
            <h3>Gestion des Emails</h3>
            <!-- Tableau de gestion des emails -->
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            document.getElementById('apprenants').style.display = 'none';
            document.getElementById('formations').style.display = 'none';
            document.getElementById('administrateurs').style.display = 'none';
            document.getElementById('emails').style.display = 'none';
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</body>
</html>