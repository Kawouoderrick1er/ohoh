<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Formation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input {
            width: 300px;
            padding: 10px;
            margin-right: 10px;
        }
        .filter-section {
            margin-bottom: 20px;
        }
        .filter-section select {
            padding: 10px;
            margin-right: 10px;
        }
        .training-list {
            margin-top: 20px;
        }
        .training-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h1>Page de Formation</h1>

    <!-- Barre de recherche -->
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Rechercher des formations...">
        <button onclick="searchTraining()">Rechercher</button>
    </div>

    <!-- Section de filtrage -->
    <div class="filter-section">
        <label for="categorySelect">Catégorie :</label>
        <select id="categorySelect">
            <option value="">Toutes</option>
            <option value="developpement">Développement</option>
            <option value="design">Design</option>
            <option value="marketing">Marketing</option>
        </select>

        <label for="levelSelect">Niveau :</label>
        <select id="levelSelect">
            <option value="">Tous</option>
            <option value="debutant">Débutant</option>
            <option value="intermediaire">Intermédiaire</option>
            <option value="avance">Avancé</option>
        </select>

        <button onclick="filterTraining()">Filtrer</button>
    </div>

    <!-- Liste des formations proposées -->
    <div class="training-list" id="trainingList">
        <!-- Les éléments de formation seront ajoutés ici dynamiquement -->
    </div>

    <script>
        const trainings = [
            { title: "Formation en Développement Web", category: "developpement", level: "debutant" },
            { title: "Formation en Design Graphique", category: "design", level: "intermediaire" },
            { title: "Formation en Marketing Digital", category: "marketing", level: "avance" },
            // Ajoutez d'autres formations ici
        ];

        function displayTrainings(filteredTrainings) {
            const trainingList = document.getElementById('trainingList');
            trainingList.innerHTML = '';
            filteredTrainings.forEach(training => {
                const div = document.createElement('div');
                div.className = 'training-item';
                div.textContent = training.title;
                trainingList.appendChild(div);
            });
        }

        function searchTraining() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const filteredTrainings = trainings.filter(training =>
                training.title.toLowerCase().includes(searchInput)
            );
            displayTrainings(filteredTrainings);
        }

        function filterTraining() {
            const categorySelect = document.getElementById('categorySelect').value;
            const levelSelect = document.getElementById('levelSelect').value;
            const filteredTrainings = trainings.filter(training =>
                (categorySelect === '' || training.category === categorySelect) &&
                (levelSelect === '' || training.level === levelSelect)
            );
            displayTrainings(filteredTrainings);
        }

        // Afficher toutes les formations au chargement de la page
        displayTrainings(trainings);
    </script>

</body>
</html>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Page de Formation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Formations</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <form class="d-flex ms-auto">
        <input class="form-control me-2" type="search" placeholder="Rechercher une formation..." aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Rechercher</button>
      </form>
    </div>
  </div>
</nav>

<!-- Filtres -->
<div class="container mt-4">
  <div class="row mb-3">
    <div class="col-md-4">
      <label for="filiereSelect" class="form-label">Filtrer par Filière</label>
      <select class="form-select" id="filiereSelect">
        <option value="">Toutes les filières</option>
        <option value="informatique">Informatique</option>
        <option value="gestion">Gestion</option>
        <option value="mecanique">Mécanique</option>
      </select>
    </div>
  </div>

  <!-- Formations -->
  <div id="formationsList">

    <!-- Filière Informatique -->
    <div class="mb-4">
      <h3>Informatique</h3>

      <!-- Discipline 1 -->
      <div class="ms-3">
        <h5>Développement Web</h5>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
          <div class="col">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h6 class="card-title">HTML & CSS</h6>
                <p class="card-text">Introduction aux bases du développement web.</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h6 class="card-title">JavaScript</h6>
                <p class="card-text">Dynamiser les sites web avec JS.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Discipline 2 -->
      <div class="ms-3 mt-4">
        <h5>Réseaux</h5>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
          <div class="col">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Cisco CCNA</h6>
                <p class="card-text">Configuration des réseaux informatiques.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filière Gestion -->
    <div class="mb-4">
      <h3>Gestion</h3>

      <!-- Discipline 1 -->
      <div class="ms-3">
        <h5>Comptabilité</h5>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
          <div class="col">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Compta Générale</h6>
                <p class="card-text">Les bases de la comptabilité pour entreprise.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Discipline 2 -->
      <div class="ms-3 mt-4">
        <h5>Marketing</h5>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
          <div class="col">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Stratégies Digitales</h6>
                <p class="card-text">Promouvoir vos produits sur les réseaux.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Ajoutez d'autres filières et disciplines au besoin -->

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
