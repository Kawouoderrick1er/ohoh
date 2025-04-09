<?php
// session_start();
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: admin_login.php");
//     exit();
// }

// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=localhost;dbname=formation_professionnelle", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Ajouter un apprenant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addApprenant'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'] ?? ''; // Utilisation de l'opérateur NULL coalescent pour éviter des erreurs
    $adresse = $_POST['adresse'] ?? '';     // Utilisation de l'opérateur NULL coalescent pour éviter des erreurs

    try {
        $sql = "INSERT INTO utilisateurs (nom, email, telephone, adresse, type_utilisateur) VALUES (:nom, :email, :telephone, :adresse, 'etudiant')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->execute();
        $message = "Apprenant ajouté avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de l'ajout de l'apprenant: " . $e->getMessage();
    }
}

// Modifier un apprenant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editApprenant'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'] ?? ''; // Utilisation de l'opérateur NULL coalescent pour éviter des erreurs
    $adresse = $_POST['adresse'] ?? '';     // Utilisation de l'opérateur NULL coalescent pour éviter des erreurs

    try {
        $sql = "UPDATE utilisateurs SET nom = :nom, email = :email, telephone = :telephone, adresse = :adresse WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $message = "Apprenant modifié avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de la modification de l'apprenant: " . $e->getMessage();
    }
}

// Supprimer un apprenant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteApprenant'])) {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $message = "Apprenant supprimé avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de la suppression de l'apprenant: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Apprenants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
        }
        .message {
            margin-bottom: 20px;
            color: green;
        }
        .action-icons i {
            cursor: pointer;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gestion des Apprenants</h2>
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <button class="btn btn-primary" onclick="showAddApprenantForm()">Ajouter un Apprenant</button>
        <div id="addApprenantForm" style="display:none;" class="mt-3">
            <form action="admin_gestion_apprenants.php" method="post">
                <input type="text" name="nom" placeholder="Nom" class="form-control mb-2" required>
                <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
                <input type="text" name="telephone" placeholder="Téléphone" class="form-control mb-2">
                <textarea name="adresse" placeholder="Adresse" class="form-control mb-2"></textarea>
                <button type="submit" name="addApprenant" class="btn btn-success">Ajouter</button>
            </form>
        </div>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Date d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $sql = "SELECT * FROM utilisateurs WHERE type_utilisateur = 'etudiant'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $apprenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($apprenants as $apprenant) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($apprenant['nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($apprenant['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($apprenant['telephone']) . "</td>";
                        echo "<td>" . htmlspecialchars($apprenant['adresse'] ?? '') . "</td>"; // Utilisation de l'opérateur NULL coalescent pour éviter des erreurs
                        echo "<td>" . htmlspecialchars($apprenant['date_inscription']) . "</td>";
                        echo "<td class='action-icons'>";
                        echo "<i class='fas fa-edit' onclick=\"showEditApprenantForm(" . $apprenant['id'] . ", '" . htmlspecialchars($apprenant['nom']) . "', '" . htmlspecialchars($apprenant['email']) . "', '" . htmlspecialchars($apprenant['telephone']) . "', '" . htmlspecialchars($apprenant['adresse'] ?? '') . "')\"></i>";
                        echo "<i class='fas fa-trash-alt' onclick=\"deleteApprenant(" . $apprenant['id'] . ")\"></i>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='6'>Erreur de connexion à la base de données: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal pour la modification des apprenants -->
    <div class="modal fade" id="editApprenantModal" tabindex="-1" aria-labelledby="editApprenantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editApprenantModalLabel">Modifier Apprenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editApprenantForm" action="admin_gestion_apprenants.php" method="post">
                        <input type="hidden" name="id" id="editApprenantId">
                        <div class="mb-3">
                            <label for="editApprenantNom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="editApprenantNom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="editApprenantEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editApprenantEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editApprenantTelephone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="editApprenantTelephone" name="telephone">
                        </div>
                        <div class="mb-3">
                            <label for="editApprenantAdresse" class="form-label">Adresse</label>
                            <textarea class="form-control" id="editApprenantAdresse" name="adresse"></textarea>
                        </div>
                        <button type="submit" name="editApprenant" class="btn btn-primary">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showAddApprenantForm() {
            document.getElementById('addApprenantForm').style.display = 'block';
        }

        function showEditApprenantForm(id, nom, email, telephone, adresse) {
            document.getElementById('editApprenantId').value = id;
            document.getElementById('editApprenantNom').value = nom;
            document.getElementById('editApprenantEmail').value = email;
            document.getElementById('editApprenantTelephone').value = telephone;
            document.getElementById('editApprenantAdresse').value = adresse;
            var editApprenantModal = new bootstrap.Modal(document.getElementById('editApprenantModal'));
            editApprenantModal.show();
        }

        function deleteApprenant(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet apprenant ?")) {
                var form = document.createElement("form");
                form.method = "post";
                form.action = "admin_gestion_apprenants.php";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "id";
                input.value = id;
                form.appendChild(input);

                var submit = document.createElement("input");
                submit.type = "hidden";
                submit.name = "deleteApprenant";
                submit.value = "1";
                form.appendChild(submit);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>