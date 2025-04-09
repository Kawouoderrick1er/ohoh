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

// Ajouter un administrateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addAdmin'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    try {
        $sql = "INSERT INTO administrateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $stmt->execute();
        $message = "Administrateur ajouté avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de l'ajout de l'administrateur: " . $e->getMessage();
    }
}

// Modifier un administrateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editAdmin'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    try {
        $sql = "UPDATE administrateurs SET nom = :nom, email = :email, mot_de_passe = :mot_de_passe WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $message = "Administrateur modifié avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de la modification de l'administrateur: " . $e->getMessage();
    }
}

// Supprimer un administrateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteAdmin'])) {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM administrateurs WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $message = "Administrateur supprimé avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de la suppression de l'administrateur: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Administrateurs</title>
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
        <h2>Gestion des Administrateurs</h2>
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <button class="btn btn-primary" onclick="showAddAdminForm()">Ajouter un Administrateur</button>
        <div id="addAdminForm" style="display:none;" class="mt-3">
            <form action="admin_gestion.php" method="post">
                <input type="text" name="nom" placeholder="Nom" class="form-control mb-2" required>
                <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
                <input type="text" name="mot_de_passe" placeholder="Mot de passe" class="form-control mb-2" required>
                <button type="submit" name="addAdmin" class="btn btn-success">Ajouter</button>
            </form>
        </div>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Mot de passe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $sql = "SELECT * FROM administrateurs";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($admins as $admin) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($admin['nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['mot_de_passe']) . "</td>";
                        echo "<td class='action-icons'>";
                        echo "<i class='fas fa-edit' onclick=\"showEditAdminForm(" . $admin['id'] . ", '" . htmlspecialchars($admin['nom']) . "', '" . htmlspecialchars($admin['email']) . "', '" . htmlspecialchars($admin['mot_de_passe']) . "')\"></i>";
                        echo "<i class='fas fa-trash-alt' onclick=\"deleteAdmin(" . $admin['id'] . ")\"></i>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='4'>Erreur de connexion à la base de données: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal pour la modification des administrateurs -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminModalLabel">Modifier Administrateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAdminForm" action="admin_gestion.php" method="post">
                        <input type="hidden" name="id" id="editAdminId">
                        <div class="mb-3">
                            <label for="editAdminNom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="editAdminNom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAdminEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editAdminEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAdminMotDePasse" class="form-label">Mot de passe</label>
                            <input type="text" class="form-control" id="editAdminMotDePasse" name="mot_de_passe" required>
                        </div>
                        <button type="submit" name="editAdmin" class="btn btn-primary">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showAddAdminForm() {
            document.getElementById('addAdminForm').style.display = 'block';
        }

        function showEditAdminForm(id, nom, email, motDePasse) {
            document.getElementById('editAdminId').value = id;
            document.getElementById('editAdminNom').value = nom;
            document.getElementById('editAdminEmail').value = email;
            document.getElementById('editAdminMotDePasse').value = motDePasse;
            var editAdminModal = new bootstrap.Modal(document.getElementById('editAdminModal'));
            editAdminModal.show();
        }

        function deleteAdmin(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet administrateur ?")) {
                var form = document.createElement("form");
                form.method = "post";
                form.action = "admin_gestion.php";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "id";
                input.value = id;
                form.appendChild(input);

                var submit = document.createElement("input");
                submit.type = "hidden";
                submit.name = "deleteAdmin";
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