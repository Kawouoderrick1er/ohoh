<?php
session_start(); // Très important pour la sécurité !
// Vérifier si l'administrateur est connecté
// if (!isset($_SESSION['admin_id'])) {
    // Si non connecté, rediriger vers la page de connexion
    // header("Location: admin_login.php");
    // exit(); // Arrêter l'exécution du script
// }

// Optionnel: Récupérer le nom de l'admin pour l'afficher
$admin_name = $_SESSION['admin_name'] ?? 'Admin';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa; /* Couleur de fond plus douce */
            margin: 0;
            display: flex; /* Utiliser flexbox pour la disposition */
            min-height: 100vh;
        }
        .sidebar {
            width: 250px; /* Largeur fixe pour la sidebar */
            background-color: #343a40; /* Couleur sombre standard */
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column; /* Organiser les éléments verticalement */
            position: fixed; /* Fixer la sidebar */
            height: 100%; /* Prendre toute la hauteur */
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1); /* Ombre légère */
        }
        .sidebar .admin-info {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #495057;
        }
        .sidebar .admin-info i {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .sidebar h2 {
            font-size: 1.2rem; /* Taille ajustée */
            margin-bottom: 0;
        }
        .sidebar .menu {
            flex-grow: 1; /* Permet au menu de prendre l'espace restant */
        }
        .sidebar a {
            color: #adb5bd; /* Couleur de lien plus douce */
            text-decoration: none;
            display: block;
            padding: 12px 15px; /* Padding ajusté */
            margin-bottom: 8px;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }
        .sidebar a i {
            margin-right: 10px; /* Espace entre icône et texte */
            width: 20px; /* Largeur fixe pour l'alignement */
            text-align: center;
        }
        .sidebar a:hover, .sidebar a.active { /* Style pour lien actif */
            background-color: #495057;
            color: white;
        }
        .sidebar .logout-link {
            margin-top: auto; /* Pousse le lien de déconnexion en bas */
            padding-top: 15px;
            border-top: 1px solid #495057;
        }
        .sidebar .logout-link a {
             background-color: #dc3545; /* Rouge pour la déconnexion */
             color: white;
             text-align: center;
        }
         .sidebar .logout-link a:hover {
             background-color: #c82333; /* Rouge plus foncé au survol */
         }

        .content {
            margin-left: 250px; /* Marge pour laisser la place à la sidebar */
            padding: 30px; /* Plus de padding */
            flex-grow: 1; /* Prend l'espace restant */
            background-color: #f8f9fa; /* Assurer la couleur de fond */
        }
        .content-area {
            background-color: white;
            padding: 30px; /* Padding interne */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); /* Ombre plus subtile */
            min-height: calc(100vh - 60px); /* Hauteur minimale pour remplir l'écran */
        }
        /* Style pour le chargement */
        .loading-indicator {
            text-align: center;
            padding: 50px;
            font-size: 1.2rem;
            color: #6c757d;
        }
        .loading-indicator i {
            margin-right: 10px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="admin-info">
             <i class="fas fa-user-shield"></i> <!-- Icône Admin -->
            <h2><?php echo htmlspecialchars($admin_name); ?></h2>
        </div>
        <div class="menu">
            <!-- Liens utilisant gestion_generique.php -->
            <a href="#" data-url="gestion_generique.php?table=utilisateurs" onclick="loadContent(this, event)">
                <i class="fas fa-users"></i>Gestion Apprenants
            </a>
            <a href="#" data-url="gestion_generique.php?table=formations" onclick="loadContent(this, event)">
                <i class="fas fa-book-open"></i>Gestion Formations
            </a>
            <a href="#" data-url="gestion_generique.php?table=administrateurs" onclick="loadContent(this, event)">
                <i class="fas fa-user-cog"></i>Gestion Admins
            </a>
            <!-- Lien pour la gestion des emails (si vous l'implémentez) -->
            <a href="#" data-url="gestion_emails.php" onclick="loadContent(this, event)">
                <i class="fas fa-envelope"></i>Gestion Emails
            </a>
            <!-- Vous pouvez ajouter d'autres liens ici si nécessaire -->
        </div>
         <div class="logout-link">
            <a href="admin_logout.php">
                <i class="fas fa-sign-out-alt"></i>Déconnexion
            </a>
        </div>
    </div>

    <div class="content">
        <div id="content-area" class="content-area">
            <!-- Contenu initial ou chargé dynamiquement -->
            <h3>Bienvenue sur le tableau de bord</h3>
            <p>Cliquez sur un menu à gauche pour gérer les différentes sections.</p>
        </div>
    </div>

    <script>
        const contentArea = document.getElementById('content-area');
        const sidebarLinks = document.querySelectorAll('.sidebar .menu a');

        function setActiveLink(element) {
            // Enlever la classe 'active' de tous les liens
            sidebarLinks.forEach(link => link.classList.remove('active'));
            // Ajouter la classe 'active' au lien cliqué
            if(element) {
                element.classList.add('active');
            }
        }

        function loadContent(element, event) {
            // Empêcher la navigation par défaut du lien "#"
            if(event) {
                event.preventDefault();
            }

            const url = element.getAttribute('data-url');
            setActiveLink(element); // Marquer le lien comme actif

            // Afficher un indicateur de chargement
            contentArea.innerHTML = `<div class="loading-indicator"><i class="fas fa-spinner"></i> Chargement en cours...</div>`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erreur HTTP! statut: ${response.status} - ${response.statusText}`);
                    }
                    return response.text();
                })
                .then(data => {
                    contentArea.innerHTML = data;
                    // Ré-attacher les gestionnaires d'événements si nécessaire (ex: pour les modales Bootstrap dans le contenu chargé)
                    reinitializeBootstrapComponents();
                })
                .catch(error => {
                    contentArea.innerHTML = `<div class="alert alert-danger" role="alert"><strong>Erreur lors du chargement du contenu :</strong> ${error.message}. Vérifiez l'URL (${url}) et la console pour plus de détails.</div>`;
                    console.error('Erreur de chargement:', error);
                });
        }

        // Fonction pour réinitialiser les composants Bootstrap (si nécessaire après chargement AJAX)
        function reinitializeBootstrapComponents() {
            // Exemple pour réinitialiser les modales (si vous en utilisez dans le contenu chargé)
            var modalElement = document.getElementById('editModal'); // Assurez-vous que l'ID correspond
             if (modalElement) {
                 // Il faut potentiellement recréer l'instance si elle est perdue
                 // Ou s'assurer que les déclencheurs fonctionnent toujours.
                 // Pour l'instant, on s'assure que les boutons peuvent ouvrir la modale.
                 // Le script dans gestion_generique.php devrait gérer l'instance.
             }
             // Ajoutez ici d'autres réinitialisations si besoin (tooltips, popovers, etc.)
        }


        // Charger le contenu du premier lien au chargement de la page
        document.addEventListener('DOMContentLoaded', () => {
            const firstLink = document.querySelector('.sidebar .menu a');
            if (firstLink) {
                loadContent(firstLink, null); // Pas d'événement au chargement initial
            } else {
                 contentArea.innerHTML = "Aucun module de gestion n'est configuré dans la barre latérale.";
            }
        });
    </script>
    <!-- Assurez-vous que Bootstrap JS est inclus (requis pour les modales, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
