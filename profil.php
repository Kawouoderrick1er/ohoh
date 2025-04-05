<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-container {
            display: flex;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            width: 60%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-info, .profile-image {
            flex: 1;
            margin: 10px;
        }
        .profile-info h2, .profile-image h2 {
            margin-top: 0;
        }
        .profile-info input, .profile-info button {
            display: block;
            margin: 10px 0;
            width: 100%;
        }
        .profile-info .input-container {
            display: flex;
            align-items: center;
        }
        .profile-info .input-container input {
            flex: 1;
        }
        .profile-info .input-container i {
            margin-left: 10px;
            cursor: pointer;
        }
        .profile-image img {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }
        .profile-image input[type="file"] {
            display: none;
        }
        .profile-image label {
            display: block;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .profile-info button {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .profile-info button i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-info">
            <h2>Informations Utilisateur</h2>
            <div class="input-container">
                <input type="text" id="username" placeholder="Nom d'utilisateur">
                <i class="fas fa-edit" onclick="editInfo('username')"></i>
                <i class="fas fa-trash-alt" onclick="deleteInfo('username')"></i>
            </div>
            <div class="input-container">
                <input type="email" id="email" placeholder="Email">
                <i class="fas fa-edit" onclick="editInfo('email')"></i>
                <i class="fas fa-trash-alt" onclick="deleteInfo('email')"></i>
            </div>
            <div class="input-container">
                <input type="text" id="phone" placeholder="Téléphone">
                <i class="fas fa-edit" onclick="editInfo('phone')"></i>
                <i class="fas fa-trash-alt" onclick="deleteInfo('phone')"></i>
            </div>
            <button onclick="saveInfo()"><i class="fas fa-save"></i> Enregistrer</button>
            <button onclick="deleteAllInfo()"><i class="fas fa-trash-alt"></i> Supprimer</button>
        </div>
        <div class="profile-image">
            <h2>Image de Profil</h2>
            <img src="default-profile.png" id="profilePic" alt="Profile Picture">
            <input type="file" id="fileInput" accept="image/*" onchange="loadFile(event)">
            <label for="fileInput"><i class="fas fa-camera"></i> Changer Image</label>
        </div>
    </div>

    <script>
        function saveInfo() {
            // Code pour sauvegarder les informations utilisateur
            alert("Informations sauvegardées.");
        }

        function deleteInfo(field) {
            // Code pour supprimer l'information utilisateur spécifique
            document.getElementById(field).value = '';
            alert(field.charAt(0).toUpperCase() + field.slice(1) + " supprimé.");
        }

        function deleteAllInfo() {
            // Code pour supprimer toutes les informations utilisateur
            document.getElementById('username').value = '';
            document.getElementById('email').value = '';
            document.getElementById('phone').value = '';
            alert("Toutes les informations supprimées.");
        }

        function editInfo(field) {
            // Code pour éditer l'information utilisateur spécifique
            document.getElementById(field).focus();
        }

        var loadFile = function(event) {
            var image = document.getElementById('profilePic');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
</body>
</html>