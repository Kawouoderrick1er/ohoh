<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Formation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .navbar-custom {
            background-color: #343a40;
        }
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: bold;
        }
        .navbar-custom .navbar-brand img {
            height: 40px;
        }
        .navbar-custom .navbar-nav .nav-link {
            color: white;
            margin: 0 10px;
        }
        .navbar-custom .navbar-nav .nav-link:hover {
            color: #007bff;
        }
        .navbar-custom .search-bar {
            position: relative;
        }
        .navbar-custom .search-bar input[type="search"] {
            border-radius: 20px;
            padding: 8px 15px 8px 40px;
            border: 1px solid #ccc;
        }
        .navbar-custom .search-bar .fa-search {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #ccc;
        }
        .navbar-custom .auth-buttons button {
            margin-left: 10px;
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease-in-out;
        }
        .navbar-custom .auth-buttons button:hover {
            background-color: #0056b3;
        }
        .navbar-custom .auth-buttons a {
            color: white;
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .navbar-custom .search-bar, .navbar-custom .auth-buttons {
                display: block;
                width: 100%;
                margin: 10px 0;
                text-align: center;
            }
            .navbar-custom .search-bar input[type="search"] {
                width: 80%;
            }
            .navbar-custom .auth-buttons button {
                width: 40%;
                margin: 5px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="Images/digi.jpg" alt="D-X-T Logo"> D-X-T
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="navbar.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="A_propos.php">A propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="formation.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="search" placeholder="Rechercher...">
                </div>
                <div class="auth-buttons">
                    <button><a href="inscription.php">Inscription</a></button>
                    <button><a href="connexion.php">Connexion</a></button>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>