<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D-X-T</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles CSS personnalisés */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .navbar {
            background-color: #f0f0f0;
            padding: 20px 0;
        }

        .navbar-brand img {
            height: 40px;
        }

        .navbar-nav .nav-link {
            color: #333;
            margin: 0 15px;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .hero {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            text-align: left;
            padding: 100px 20px;
            position: relative;
            overflow: visible; /* Permet au contenu de déborder */
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease-in-out;
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 30px;
            animation: fadeInDown 1.5s ease-in-out;
        }

        .services {
            position: relative;
            padding: 50px 20px;
        }

        .service-item {
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .service-item:hover {
            transform: scale(1.05);
        }

        .service-item img {
            height: 50px;
            margin-bottom: 20px;
        }

        .about {
            background-color: #f8f9fa;
            padding: 50px 20px;
        }

        .about img {
            max-width: 100%;
            height: auto;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .arrow-left, .arrow-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2em;
            color: #007bff;
            cursor: pointer;
            user-select: none;
        }

        .arrow-left {
            left: 10px;
        }

        .arrow-right {
            right: 10px;
        }

        .search-bar {
            margin-right: 20px;
        }

        .search-bar input[type="search"] {
            border-radius: 20px;
            padding: 8px 15px;
            border: 1px solid #ccc;
        }

        .auth-buttons button {
            margin-left: 10px;
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease-in-out;
        }

        .auth-buttons button:hover {
            background-color: rgba(15, 14, 14, 0.73);
        }

        .auth-buttons button:active {
            transform: scale(0.95);
        }

        /* Styles responsives */
        @media (max-width: 768px) {
            .search-bar, .auth-buttons {
                display: block;
                width: 100%;
                margin: 10px 0;
                text-align: center;
            }

            .search-bar input[type="search"] {
                width: 80%;
            }

            .auth-buttons button {
                width: 40%;
                margin: 5px;
            }
        }

        /* Styles pour les cartes de formation */
        .formation-cards {
            display: flex;
            justify-content: center;
            position: absolute;
            bottom: -50px; /* Ajustez cette valeur pour le débordement */
            left: 0;
            right: 0;
            padding: 0 20px;
        }

        .formation-card {
            background-color: white;
            padding: 20px;
            margin: 0 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1;
        }

        .formation-card img {
            height: 80px;
            margin-bottom: 10px;
        }

        .formation-card h3 {
            font-size: 1.2em;
        }

        .container-categories {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .category {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 10px;
        }

        .icon-inner {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .icon img {
            max-width: 40px;
            max-height: 40px;
        }

        .label {
            font-size: 0.9em;
            color: #333;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="Images/digi.jpg" alt="ItFirm Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <div class="search-bar">
                    <input type="search" placeholder="Rechercher...">
                </div>
                <div class="auth-buttons">
                    <button>Inscription</button>
                    <button>Connexion</button>
                </div>
            </div>
        </div>
    </nav>
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Développez vos compétences. Nous vous aidons à atteindre vos objectifs !</h1>
                    <p>Nous vous offrons un accès à un réseau global de formation pour avancer vos carrières et atteindre vos objectifs stratégiques.</p>
                    <button class="btn btn-primary">Nos Services</button>
                </div>
                <div class="col-md-6">
                    <img src="Images/png/etu.png" alt="Hero Image" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <section class="about">
        <div class="container">
            <div class="row align-items-center">
                <p class="text-center fw-bold text-uppercase fs-3">À propos de nous</p>
                <div class="col-md-6">
                    <img src="Images/IMG-20250319-WA0029.jpg" alt="About Us" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2>Bienvenue à D-X-T !</h2>
                    <p>Nous sommes spécialisés dans les technologies numériques. Notre mission est de vous aider à développer vos compétences et à réussir dans le monde 
                    numérique. Nous proposons des formations de haute qualité, accessibles en ligne, pour vous aider à atteindre vos objectifs professionnels. Rejoignez notre communauté d'apprenants et de professionnels pour partager
                    vos connaissances et vos expériences.</p>
                    <button class="btn btn-primary">Nous Rejoindre</button>
                </div>
            </div>
        </div>
    </section>
    <section class="services">
        <div class="container">
            <p class="text-center fw-bold text-uppercase fs-3">NOS SERVICES</p>
            <div class="row">
                <div class="col-md-4 service-item">
                    <a href="uiux-design.html">
                        <img src="Images/IMG-20250318-WA0017.jpg" alt="Service 1">
                        <h3>UI/UX Design</h3>
                    </a>
                </div>
                <div class="col-md-4 service-item">
                    <a href="business-consultation.html">
                        <img src="Images/IMG-20250318-WA0017.jpg" alt="Service 2">
                        <h3>Business Consultation</h3>
                    </a>
                </div>
                <div class="col-md-4 service-item">
                    <a href="website-development.html">
                        <img src="Images/IMG-20250318-WA0017.jpg" alt="Service 3">
                        <h3>Website Development</h3>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 service-item">
                    <a href="formation4.html">
                        <img src="Images/IMG-20250318-WA0017.jpg" alt="Service 4">
                        <h3>Infographie</h3>
                    </a>
                </div>
                <div class="col-md-4 service-item">
                    <a href="formation5.html">
                        <img src="Images/IMG-20250318-WA0017.jpg" alt="Service 5">
                        <h3>Marketing digital</h3>
                    </a>
                </div>
                <div class="col-md-4 service-item">
                    <a href="formation6.html">
                        <img src="Images/IMG-20250318-WA0017.jpg" alt="Service 6">
                        <h3>Audit SI</h3>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 service-item">
                    <a href="formation7.html">
                        <img src="Images/IMG-20250318-WA0017.jpg" alt="Service 7">
                        <h3>Sécurité informatique</h3>
                    </a>
                </div>
                <div class="col-md-4 service-item">
                    <a href="formation8.html">
                        <img src="Images/IMG-20250318-WA0017.jpg" alt="Service 8">
                        <h3>Réseau</h3>
                    </a>
                </div>
                <div class="col-md-4 service-item">
                    <a href="formation9.html">
                        <img src="Images/IMG-20250318-WA0017.jpg" alt="Service 9">
                        <h3>Gestion d'entreprise</h3>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center">
            <a href="#" class="btn btn-primary"><strong>+</strong> Voir toutes les catégories</a>
        </div>
        <div class="arrow-left">&#8249;</div>
        <div class="arrow-right">&#8250;</div>
    </section>
    
    <style>
        .contact {
            padding: 50px 20px;
            background-color: #e9ecef;
        }

        .contact-image img {
            max-width: 100%;
            height: auto;
        }

        .contact-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
    <section class="contact">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="contact-image">
                        <img src="Images/IMG-20250319-WA0028.jpg" alt="Image de contact">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-form">
                        <h2>Contactez-nous</h2>
                        <form action="#" method="post">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom :</label>
                                <input type="text" id="nom" name="nom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message :</label>
                                <textarea id="message" name="message" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
            require_once 'foote.php';
        ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript pour les flèches de défilement des services
        document.querySelector('.arrow-left').addEventListener('click', function() {
            document.querySelector('.services .container').scrollLeft -= 300;
        });

        document.querySelector('.arrow-right').addEventListener('click', function() {
            document.querySelector('.services .container').scrollLeft += 300;
        });
    </script>
</body>
</html>