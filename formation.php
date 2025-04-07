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
            background: url('Images/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            padding: 20px;
        }
        .hero {
            text-align: center;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .hero p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input[type="search"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .filter-buttons {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .filter-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease-in-out;
        }
        .filter-buttons button:hover {
            background-color: #0056b3;
        }
        .theme-filters {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .theme-filters button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease-in-out;
        }
        .theme-filters button:hover {
            background-color: #0056b3;
        }
        .carousel {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
        }
        .carousel::-webkit-scrollbar {
            display: none;
        }
        .carousel .training-item {
            min-width: 200px;
            margin-right: 10px;
        }
        .carousel .training-item:last-child {
            margin-right: 0;
        }
        .category {
            margin-bottom: 30px;
        }
        .category h2 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        .training-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: transform 0.3s ease-in-out;
        }
        .training-item:hover {
            transform: scale(1.02);
        }
        .training-item img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .training-item .info {
            text-align: center;
        }
        .training-item .info h3 {
            margin: 0;
            font-size: 1.2em;
        }
        .training-item .info p {
            margin: 5px 0 0;
            font-size: 0.9em;
        }
        .training-item .details {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
        .training-item .details span {
            font-size: 0.9em;
            color: #555;
        }
        .training-item .details button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease-in-out;
        }
        .training-item .details button:hover {
            background-color: #0056b3;
        }
        .carousel-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .carousel-buttons i {
            font-size: 2em;
            cursor: pointer;
            color: #007bff;
        }
        .carousel-buttons i:hover {
            color: #0056b3;
        }
        @media (max-width: 768px) {
            .training-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .training-item img {
                margin-bottom: 10px;
            }
            .filter-buttons {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>
    <div class="overlay">
        <h1>Message important ici</h1>
    </div>
    <div class="container">
        <!-- Titre d’accroche -->
        <div class="hero">
            <h1>🚀 Développez vos compétences. Boostez votre carrière.</h1>
            <p>Formations en ligne certifiantes, flexibles et adaptées à vos besoins.</p>
            <p>+1000 apprenants formés | Partenaires certifiés | Plateforme 100% en ligne</p>
        </div>
        <!-- Barre de recherche -->
        <div class="search-bar">
            <input type="search" placeholder="🔍 Rechercher une formation">
        </div>
        <!-- Filtres par catégories -->
        <div class="filter-buttons">
            <button data-filter="all">Toutes</button>
            <button data-filter="business">Business</button>
            <button data-filter="tech">Technologie</button>
            <button data-filter="management">Management</button>
        </div>
        <!-- Filtres dynamiques par thème ou domaine -->
        <!-- <div class="theme-filters">
            <button>🌐 Développement Web</button>
            <button>📈 Marketing & Communication</button>
            <button>🧮 Finance & Comptabilité</button>
            <button>🎨 Design & Créativité</button>
            <button>💼 Management & RH</button>
            <button>⚙️ Industrie & Technique</button>
            <button>🇬🇧 Langues & Soft Skills</button>
        </div> -->
        <!-- Catégorie Business -->
        <div class="category" data-category="business">
            <h2>Business</h2>
            <div class="carousel-buttons">
                <i class="fas fa-chevron-left" onclick="scrollCarousel('business', 'left')"></i>
                <i class="fas fa-chevron-right" onclick="scrollCarousel('business', 'right')"></i>
            </div>
            <div class="carousel" id="business-carousel">
                <div class="training-item">
                    <img src="Images/IMG-20250318-WA0005.jpg" alt="Formation Business 1">
                    <div class="info">
                        <h3>Formation Business 1</h3>
                        <p>Description de la formation Business 1</p>
                    </div>
                    <div class="details">
                        <span>Niveau : Débutant</span>
                        <span>Prix : Gratuit</span>
                        <span>Durée : 4 semaines</span>
                        <button onclick="location.href='formations.php'">Découvrir</button>
                    </div>
                </div>
                <div class="training-item">
                    <img src="Images/business2.png" alt="Formation Business 2">
                    <div class="info">
                        <h3>Formation Business 2</h3>
                        <p>Description de la formation Business 2</p>
                    </div>
                    <div class="details">
                        <span>Niveau : Intermédiaire</span>
                        <span>Prix : 200€</span>
                        <span>Durée : 6 semaines</span>
                        <button onclick="location.href='formations.php'">Découvrir</button>
                    </div>
                </div>
                <!-- Ajoutez plus de formations ici -->
            </div>
        </div>
        <!-- Catégorie Technologie -->
        <div class="category" data-category="tech">
            <h2>Technologie</h2>
            <div class="carousel-buttons">
                <i class="fas fa-chevron-left" onclick="scrollCarousel('tech', 'left')"></i>
                <i class="fas fa-chevron-right" onclick="scrollCarousel('tech', 'right')"></i>
            </div>
            <div class="carousel" id="tech-carousel">
                <div class="training-item">
                    <img src="Images/tech1.png" alt="Formation Technologie 1">
                    <div class="info">
                        <h3>Formation Technologie 1</h3>
                        <p>Description de la formation Technologie 1</p>
                    </div>
                    <div class="details">
                        <span>Niveau : Avancé</span>
                        <span>Prix : 300€</span>
                        <span>Durée : 8 semaines</span>
                        <button onclick="location.href='formations.php'">Découvrir</button>
                    </div>
                </div>
                <div class="training-item">
                    <img src="Images/tech2.png" alt="Formation Technologie 2">
                    <div class="info">
                        <h3>Formation Technologie 2</h3>
                        <p>Description de la formation Technologie 2</p>
                    </div>
                    <div class="details">
                        <span>Niveau : Débutant</span>
                        <span>Prix : 150€</span>
                        <span>Durée : 5 semaines</span>
                        <button onclick="location.href='formations.php'">Découvrir</button>
                    </div>
                </div>
                <!-- Ajoutez plus de formations ici -->
            </div>
        </div>
    </div>
    <script>
        // JavaScript pour les filtres
        document.querySelectorAll('.filter-buttons button').forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');
                document.querySelectorAll('.category').forEach(category => {
                    if (filter === 'all' || category.getAttribute('data-category') === filter) {
                        category.style.display = 'block';
                    } else {
                        category.style.display = 'none';
                    }
                });
            });
        });

        // JavaScript pour la barre de recherche
        document.querySelector('.search-bar input[type="search"]').addEventListener('input', (event) => {
            const query = event.target.value.toLowerCase();
            document.querySelectorAll('.training-item').forEach(item => {
                const title = item.querySelector('h3').textContent.toLowerCase();
                if (title.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // JavaScript pour le défilement des carrousels
        function scrollCarousel(category, direction) {
            const carousel = document.getElementById(`${category}-carousel`);
            if (direction === 'left') {
                carousel.scrollBy({ left: -200, behavior: 'smooth' });
            } else {
                carousel.scrollBy({ left: 200, behavior: 'smooth' });
            }
        }
    </script>
    <?php include 'foote.php'; ?>
</body>
</html>