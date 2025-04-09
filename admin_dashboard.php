<?php // c:\xampp\htdocs\ohoh\admin_dashboard.php
session_start(); // Très important pour la sécurité !
// Vérifier si l'administrateur est connecté (DÉCOMMENTER EN PRODUCTION)
/*
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
*/

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
        /* Styles copiés depuis la version précédente - OK */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; margin: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #343a40; padding: 20px; color: white; display: flex; flex-direction: column; position: fixed; height: 100%; top: 0; left: 0; box-shadow: 2px 0 5px rgba(0,0,0,0.1); overflow-y: auto; /* Permet le défilement si menu long */ }
        .sidebar .admin-info { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #495057; }
        .sidebar .admin-info i { font-size: 2.5rem; margin-bottom: 10px; }
        .sidebar h2 { font-size: 1.2rem; margin-bottom: 0; }
        .sidebar .menu { flex-grow: 1; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 12px 15px; margin-bottom: 8px; border-radius: 5px; transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out; }
        .sidebar a i { margin-right: 10px; width: 20px; text-align: center; }
        .sidebar a:hover, .sidebar a.active { background-color: #495057; color: white; }
        .sidebar .logout-link { margin-top: auto; padding-top: 15px; border-top: 1px solid #495057; }
        .sidebar .logout-link a { background-color: #dc3545; color: white; text-align: center; }
        .sidebar .logout-link a:hover { background-color: #c82333; }
        .content { margin-left: 250px; padding: 30px; flex-grow: 1; background-color: #f8f9fa; }
        .content-area { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); min-height: calc(100vh - 60px); }
        .loading-indicator { text-align: center; padding: 50px; font-size: 1.2rem; color: #6c757d; }
        .loading-indicator i { margin-right: 10px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="admin-info">
             <i class="fas fa-user-shield"></i>
            <h2><?php echo htmlspecialchars($admin_name); ?></h2>
        </div>
        <div class="menu">
            <!-- Lien Tableau de Bord (Aperçu) -->
            <a href="#" data-url="admin_dashboard_overview.php" onclick="loadContent(this, event)" class="active"> <!-- Actif par défaut -->
                <i class="fas fa-tachometer-alt"></i>Tableau de Bord
            </a>
            <hr class="text-secondary opacity-50 my-2">

            <!-- Liens de Gestion Principaux -->
            <a href="#" data-url="gestion_generique.php?table=apprenants" onclick="loadContent(this, event)">
                <i class="fas fa-users"></i>Apprenants
            </a>
             <a href="#" data-url="gestion_generique.php?table=formateurs" onclick="loadContent(this, event)">
                <i class="fas fa-chalkboard-teacher"></i>Formateurs
            </a>
            <a href="#" data-url="gestion_generique.php?table=cours" onclick="loadContent(this, event)">
                <i class="fas fa-book-open"></i>Cours
            </a>
            <a href="#" data-url="gestion_generique.php?table=lecons" onclick="loadContent(this, event)">
                <i class="fas fa-file-alt"></i>Leçons
            </a>
             <a href="#" data-url="gestion_generique.php?table=inscriptions" onclick="loadContent(this, event)">
                <i class="fas fa-user-check"></i>Inscriptions
            </a>

             <hr class="text-secondary opacity-50 my-2">

             <!-- Autres Outils -->
             <a href="#" data-url="gestion_generique.php?table=messages_contact" onclick="loadContent(this, event)">
                <i class="fas fa-envelope-open-text"></i>Messages Contact
            </a>
            <a href="#" data-url="gestion_emails.php" onclick="loadContent(this, event)">
                <i class="fas fa-paper-plane"></i>Envoyer Email
            </a>

             <hr class="text-secondary opacity-50 my-2">

             <!-- Administration Système -->
            <a href="#" data-url="gestion_generique.php?table=administrateurs" onclick="loadContent(this, event)">
                <i class="fas fa-user-cog"></i>Administrateurs
            </a>
            <!-- Ajouter d'autres liens admin ici (ex: paramètres, logs...) -->
        </div>
         <div class="logout-link">
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>Déconnexion
            </a>
        </div>
    </div>

    <div class="content">
        <div id="content-area" class="content-area">
            <!-- Contenu chargé dynamiquement ici -->
            <div class="loading-indicator"><i class="fas fa-spinner"></i> Chargement initial...</div>
        </div>
    </div>

    <script>
        const contentArea = document.getElementById('content-area');
        // Sélectionner TOUS les liens cliquables dans la sidebar pour la gestion de l'état actif
        const sidebarLinks = document.querySelectorAll('.sidebar .menu a[data-url]');

        function setActiveLink(element) {
            sidebarLinks.forEach(link => link.classList.remove('active'));
            if(element && element.hasAttribute('data-url')) { // Assurer que c'est un lien gérable
                element.classList.add('active');
            } else {
                // Si on charge l'overview via un élément non-menu, on active le lien du menu correspondant
                 const overviewMenuLink = document.querySelector('.sidebar .menu a[data-url="admin_dashboard_overview.php"]');
                 if (overviewMenuLink) overviewMenuLink.classList.add('active');
            }
        }

        function loadContent(element, event) {
            if(event) {
                event.preventDefault();
            }
            const url = element.getAttribute('data-url');
            if (!url) return; // Ne rien faire si pas d'URL

            setActiveLink(element);

            contentArea.innerHTML = `<div class="loading-indicator"><i class="fas fa-spinner"></i> Chargement en cours...</div>`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        // Tenter de lire le message d'erreur du serveur si possible
                        return response.text().then(text => {
                             throw new Error(`Erreur HTTP ${response.status}: ${response.statusText}. Réponse: ${text}`);
                        });
                    }
                    return response.text();
                })
                .then(data => {
                    contentArea.innerHTML = data;
                    reinitializeBootstrapComponents();
                    // Faire remonter la page en haut après chargement
                    window.scrollTo(0, 0);
                })
                .catch(error => {
                    contentArea.innerHTML = `<div class="alert alert-danger" role="alert"><strong>Erreur lors du chargement :</strong> ${error.message}. Vérifiez l'URL (${url}) et la console.</div>`;
                    console.error('Erreur Fetch:', error);
                });
        }

        function reinitializeBootstrapComponents() {
            // Réinitialiser les modales Bootstrap si présentes dans le contenu chargé
            var modalElement = document.getElementById('editModal');
             if (modalElement && typeof bootstrap !== 'undefined') {
                 // Tenter de détruire une instance précédente si elle existe
                 var existingModal = bootstrap.Modal.getInstance(modalElement);
                 if (existingModal) {
                     // Ne rien faire ou détruire ? Pour l'instant on laisse le JS de gestion_generique gérer
                 }
                 // Le JS dans gestion_generique.php devrait créer l'instance via new bootstrap.Modal()
             }
             // Réinitialiser les tooltips Bootstrap s'ils sont utilisés
             var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
             var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                 return new bootstrap.Tooltip(tooltipTriggerEl);
             });
        }

        // Charger l'aperçu du tableau de bord par défaut au chargement de la page
        document.addEventListener('DOMContentLoaded', () => {
            const overviewUrl = 'admin_dashboard_overview.php';
            const overviewLinkElement = document.querySelector(`.sidebar .menu a[data-url="${overviewUrl}"]`);

            if (overviewLinkElement) {
                loadContent(overviewLinkElement, null); // Charger via le lien du menu
            } else {
                // Fallback si le lien n'existe pas (charge directement l'URL)
                const tempElement = document.createElement('a');
                tempElement.setAttribute('data-url', overviewUrl);
                loadContent(tempElement, null);
                console.warn("Lien du menu pour l'aperçu non trouvé, chargement direct.");
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
