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