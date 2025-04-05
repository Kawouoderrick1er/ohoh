<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=localhost;dbname=formation_professionnelle", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Ajouter une formation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addFormation'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $video_url = $_POST['video_url'];
    $pdf_url = $_POST['pdf_url'];

    try {
        $sql = "INSERT INTO formations (nom, description, video_url, pdf_url) VALUES (:nom, :description, :video_url, :pdf_url)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':video_url', $video_url);
        $stmt->bindParam(':pdf_url', $pdf_url);
        $stmt->execute();
        $message = "Formation ajoutée avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de l'ajout de la formation: " . $e->getMessage();
    }
}

// Modifier une formation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editFormation'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $video_url = $_POST['video_url'];
    $pdf_url = $_POST['pdf_url'];

    try {
        $sql = "UPDATE formations SET nom = :nom, description = :description, video_url = :video_url, pdf_url = :pdf_url WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':video_url', $video_url);
        $stmt->bindParam(':pdf_url', $pdf_url);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $message = "Formation modifiée avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de la modification de la formation: " . $e->getMessage();
    }
}

// Supprimer une formation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteFormation'])) {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM formations WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $message = "Formation supprimée avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de la suppression de la formation: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Formations</title>
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
        <h2>Gestion des Formations</h2>
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <button class="btn btn-primary" onclick="showAddFormationForm()">Ajouter une Formation</button>
        <div id="addFormationForm" style="display:none;" class="mt-3">
            <form action="admin_gestion_formations.php" method="post">
                <input type="text" name="nom" placeholder="Nom" class="form-control mb-2" required>
                <textarea name="description" placeholder="Description" class="form-control mb-2" required></textarea>
                <input type="text" name="video_url" placeholder="URL Vidéo" class="form-control mb-2">
                <input type="text" name="pdf_url" placeholder="URL PDF" class="form-control mb-2">
                <button type="submit" name="addFormation" class="btn btn-success">Ajouter</button>
            </form>
        </div>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>URL Vidéo</th>
                    <th>URL PDF</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $sql = "SELECT * FROM formations";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($formations as $formation) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($formation['nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($formation['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($formation['video_url']) . "</td>";
                        echo "<td>" . htmlspecialchars($formation['pdf_url']) . "</td>";
                        echo "<td class='action-icons'>";
                        echo "<i class='fas fa-edit' onclick=\"showEditFormationForm(" . $formation['id'] . ", '" . htmlspecialchars($formation['nom']) . "', '" . htmlspecialchars($formation['description']) . "', '" . htmlspecialchars($formation['video_url']) . "', '" . htmlspecialchars($formation['pdf_url']) . "')\"></i>";
                        echo "<i class='fas fa-trash-alt' onclick=\"deleteFormation(" . $formation['id'] . ")\"></i>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='5'>Erreur de connexion à la base de données: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <h3>Personnes Suivant une Formation</h3>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Formation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $sql = "SELECT utilisateurs.nom AS utilisateur_nom, utilisateurs.email, formations.nom AS formation_nom 
                            FROM utilisateurs 
                            JOIN formations ON utilisateurs.formation_id = formations.id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $inscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($inscriptions as $inscription) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($inscription['utilisateur_nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($inscription['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($inscription['formation_nom']) . "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='3'>Erreur de connexion à la base de données: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal pour la modification des formations -->
    <div class="modal fade" id="editFormationModal" tabindex="-1" aria-labelledby="editFormationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFormationModalLabel">Modifier Formation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editFormationForm" action="admin_gestion_formations.php" method="post">
                        <input type="hidden" name="id" id="editFormationId">
                        <div class="mb-3">
                            <label for="editFormationNom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="editFormationNom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFormationDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editFormationDescription" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editFormationVideoUrl" class="form-label">URL Vidéo</label>
                            <input type="text" class="form-control" id="editFormationVideoUrl" name="video_url">
                        </div>
                        <div class="mb-3">
                            <label for="editFormationPdfUrl" class="form-label">URL PDF</label>
                            <input type="text" class="form-control" id="editFormationPdfUrl" name="pdf_url">
                        </div>
                        <button type="submit" name="editFormation" class="btn btn-primary">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showAddFormationForm() {
            document.getElementById('addFormationForm').style.display = 'block';
        }

        function showEditFormationForm(id, nom, description, videoUrl, pdfUrl) {
            document.getElementById('editFormationId').value = id;
            document.getElementById('editFormationNom').value = nom;
            document.getElementById('editFormationDescription').value = description;
            document.getElementById('editFormationVideoUrl').value = videoUrl;
            document.getElementById('editFormationPdfUrl').value = pdfUrl;
            var editFormationModal = new bootstrap.Modal(document.getElementById('editFormationModal'));
            editFormationModal.show();
        }

        function deleteFormation(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette formation ?")) {
                var form = document.createElement("form");
                form.method = "post";
                form.action = "admin_gestion_formations.php";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "id";
                input.value = id;
                form.appendChild(input);

                var submit = document.createElement("input");
                submit.type = "hidden";
                submit.name = "deleteFormation";
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