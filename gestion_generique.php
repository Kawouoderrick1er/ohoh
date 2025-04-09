<?php
// Démarrer la session pour la sécurité et la gestion de l'état
session_start();

// --- Vérification de Sécurité Essentielle ---
// S'assurer qu'un administrateur est connecté
if (!isset($_SESSION['admin_id'])) {
    // Si non connecté, renvoyer vers la page de connexion avec un message d'erreur
    // Vous pouvez aussi simplement faire un die() ou afficher un message ici si le chargement AJAX échoue
    // header("Location: admin_login.php?error=auth_required");
    http_response_code(403); // Forbidden
    die("Accès refusé. Veuillez vous connecter en tant qu'administrateur.");
    // exit(); // Arrêter l'exécution
}

// --- Configuration des Tables Gérables ---
// Décrit comment chaque section du tableau de bord interagit avec la base de données.
$config_tables = [
    // Gestion des Apprenants (basée sur la table 'utilisateurs')
    'apprenants' => [
        'table_name' => 'utilisateurs',      // Table SQL réelle
        'display_name' => 'Apprenants',      // Nom affiché dans l'interface
        'primary_key' => 'id',              // Clé primaire de la table
        'columns' => [                      // Colonnes à gérer
            'nom' => ['label' => 'Nom', 'type' => 'text', 'required' => true],
            'email' => ['label' => 'Email', 'type' => 'email', 'required' => true],
            'telephone' => ['label' => 'Téléphone', 'type' => 'tel', 'required' => false], // type 'tel' pour sémantique HTML5
            'adresse' => ['label' => 'Adresse', 'type' => 'textarea', 'required' => false],
            'date_inscription' => ['label' => 'Inscrit le', 'type' => 'datetime', 'readonly' => true], // Lecture seule
            // 'mot_de_passe' est géré séparément ou lors de la création initiale si nécessaire
            // 'type_utilisateur' est géré par list_condition et insert_values
        ],
        'list_condition' => "type_utilisateur = 'etudiant'", // Condition pour lister uniquement les étudiants
        'insert_values' => ['type_utilisateur' => 'etudiant'] // Définit automatiquement le type lors de l'ajout
    ],

    // Gestion des Formateurs (basée sur la table 'utilisateurs')
    'formateurs' => [
        'table_name' => 'utilisateurs',
        'display_name' => 'Formateurs',
        'primary_key' => 'id',
        'columns' => [
            'nom' => ['label' => 'Nom', 'type' => 'text', 'required' => true],
            'email' => ['label' => 'Email', 'type' => 'email', 'required' => true],
            'telephone' => ['label' => 'Téléphone', 'type' => 'tel', 'required' => false],
            'adresse' => ['label' => 'Adresse', 'type' => 'textarea', 'required' => false],
            'date_inscription' => ['label' => 'Inscrit le', 'type' => 'datetime', 'readonly' => true],
        ],
        'list_condition' => "type_utilisateur = 'formateur'",
        'insert_values' => ['type_utilisateur' => 'formateur']
    ],

    // Gestion des Administrateurs (basée sur la table 'utilisateurs')
    'administrateurs' => [
        'table_name' => 'utilisateurs',
        'display_name' => 'Administrateurs',
        'primary_key' => 'id',
        'columns' => [
            'nom' => ['label' => 'Nom', 'type' => 'text', 'required' => true],
            'email' => ['label' => 'Email', 'type' => 'email', 'required' => true],
            'mot_de_passe' => ['label' => 'Mot de passe', 'type' => 'password', 'required' => true, 'edit_optional' => true, 'no_list' => true], // Requis à l'ajout, optionnel à l'édition, non listé
            'date_inscription' => ['label' => 'Inscrit le', 'type' => 'datetime', 'readonly' => true],
        ],
        'list_condition' => "type_utilisateur = 'administrateur'",
        'insert_values' => ['type_utilisateur' => 'administrateur']
    ],

    // Gestion des Cours/Formations (basée sur la table 'cours')
    'cours' => [
        'table_name' => 'cours',
        'display_name' => 'Formations / Cours',
        'primary_key' => 'id',
        'columns' => [
            'titre' => ['label' => 'Titre', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'textarea', 'required' => true],
            'formateur_id' => ['label' => 'ID Formateur', 'type' => 'number', 'required' => false], // Champ numérique simple pour l'ID
            'date_creation' => ['label' => 'Créé le', 'type' => 'datetime', 'readonly' => true],
            // Amélioration future: Remplacer 'formateur_id' par une liste déroulante des formateurs
        ]
        // Pas de list_condition ou insert_values spécifiques ici par défaut
    ],

     // Gestion des Leçons (basée sur la table 'lecons')
    'lecons' => [
        'table_name' => 'lecons',
        'display_name' => 'Leçons',
        'primary_key' => 'id',
        'columns' => [
            'titre' => ['label' => 'Titre', 'type' => 'text', 'required' => true],
            'contenu' => ['label' => 'Contenu', 'type' => 'textarea', 'required' => true],
            'cours_id' => ['label' => 'ID Cours Parent', 'type' => 'number', 'required' => true], // ID du cours auquel la leçon appartient
            'date_creation' => ['label' => 'Créé le', 'type' => 'datetime', 'readonly' => true],
             // Amélioration future: Remplacer 'cours_id' par une liste déroulante des cours
        ]
    ],

    // Ajoutez d'autres configurations ici (ex: inscriptions, evaluations) si nécessaire
];

// --- Connexion à la Base de Données ---
// Assurez-vous que les identifiants sont corrects
$db_host = "localhost";
$db_name = "formation_professionnelle";
$db_user = "root";
$db_pass = ""; // Mettez votre mot de passe si vous en avez un

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optionnel: Empêche PDO d'émuler les requêtes préparées (meilleure sécurité si supporté par le driver)
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    // En production, logguez l'erreur au lieu de l'afficher directement
    error_log("Erreur de connexion à la base de données: " . $e->getMessage());
    // Afficher un message générique à l'utilisateur
    die("Erreur de connexion à la base de données. Veuillez contacter l'administrateur.");
}

// --- Logique Générique ---
$message = ''; // Pour les messages de succès ou d'erreur
$message_type = 'info'; // 'success', 'error', 'info'
$table_key = $_GET['table'] ?? null; // La clé de configuration (ex: 'apprenants', 'cours')
$config = null; // Contiendra la configuration de la table actuelle
$data_list = []; // Liste des enregistrements à afficher
$columns_to_display = []; // Colonnes à afficher dans le tableau HTML
$columns_for_form = []; // Colonnes pour les formulaires d'ajout/modif

// Vérifier si la clé de table demandée existe dans la configuration
if ($table_key && isset($config_tables[$table_key])) {
    $config = $config_tables[$table_key];
    $table_name = $config['table_name']; // Nom réel de la table SQL
    $pk_name = $config['primary_key'];   // Nom de la clé primaire

    // Filtrer les colonnes pour l'affichage et les formulaires
    $columns_to_display = array_filter($config['columns'], function($col) {
        return !isset($col['no_list']) || !$col['no_list']; // Exclure les colonnes marquées 'no_list'
    });
     $columns_for_form = array_filter($config['columns'], function($col) {
        return !isset($col['readonly']) || !$col['readonly']; // Exclure les colonnes readonly des formulaires
    });

    // --- Traitement des Actions POST (Ajouter, Modifier, Supprimer) ---
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        $action = $_POST['action'];
        $id = $_POST[$pk_name] ?? null; // ID pour modification/suppression

        try {
            // Action: Ajouter
            if ($action === 'add' && isset($_POST['addData'])) {
                $sql_cols = [];
                $sql_placeholders = [];
                $bind_params = [];

                // Ajouter les valeurs fixes définies dans la config (ex: type_utilisateur)
                if (isset($config['insert_values']) && is_array($config['insert_values'])) {
                    foreach ($config['insert_values'] as $col => $val) {
                        $sql_cols[] = "`" . $col . "`";
                        $sql_placeholders[] = ":" . $col;
                        $bind_params[":" . $col] = $val;
                    }
                }

                // Parcourir les colonnes du formulaire
                foreach ($columns_for_form as $col_name => $col_config) {
                    if (isset($_POST[$col_name])) {
                        $value = $_POST[$col_name];

                        // Traitement spécial pour le mot de passe (hashage)
                        if ($col_name === 'mot_de_passe' && !empty($value)) {
                            // Vérifier si la colonne existe bien dans la table cible
                            if (isset($config['columns']['mot_de_passe'])) {
                                $value = password_hash($value, PASSWORD_DEFAULT);
                            } else {
                                continue; // Ne pas essayer d'insérer un mdp si la colonne n'est pas prévue
                            }
                        } elseif ($col_name === 'mot_de_passe' && empty($value) && ($col_config['required'] ?? false)) {
                             // Si le mot de passe est requis mais vide, générer une erreur ou ignorer ?
                             // Pour l'instant, on l'ignore s'il est vide, mais la validation HTML devrait l'attraper
                             continue;
                        }

                        // Ajouter seulement si la colonne n'est pas déjà dans les valeurs fixes
                        if (!isset($bind_params[":" . $col_name])) {
                            $sql_cols[] = "`" . $col_name . "`";
                            $sql_placeholders[] = ":" . $col_name;
                            $bind_params[":" . $col_name] = ($value === '' && !($col_config['required'] ?? false)) ? null : $value; // Insérer NULL si vide et non requis
                        }
                    }
                }

                if (!empty($sql_cols)) {
                    $sql = "INSERT INTO `$table_name` (" . implode(', ', $sql_cols) . ") VALUES (" . implode(', ', $sql_placeholders) . ")";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute($bind_params);
                    $message = htmlspecialchars($config['display_name']) . " ajouté(e) avec succès.";
                    $message_type = 'success';
                } else {
                     $message = "Aucune donnée valide à ajouter.";
                     $message_type = 'warning';
                }
            }
            // Action: Modifier
            elseif ($action === 'edit' && isset($_POST['editData']) && $id) {
                $sql_updates = [];
                $bind_params = [];

                foreach ($columns_for_form as $col_name => $col_config) {
                     // Ignorer la clé primaire elle-même dans SET
                    if ($col_name === $pk_name) continue;
                    // Ignorer si la colonne n'est pas modifiable
                    if (isset($col_config['no_edit']) && $col_config['no_edit']) continue;

                    // Vérifier si la donnée est présente dans POST
                    if (isset($_POST[$col_name])) {
                        $value = $_POST[$col_name];

                        // Traitement spécial pour le mot de passe (hashage si fourni)
                        if ($col_name === 'mot_de_passe') {
                            // Mettre à jour seulement si un nouveau mot de passe est fourni
                            if (!empty($value)) {
                                 // Vérifier si la colonne existe bien dans la table cible
                                if (isset($config['columns']['mot_de_passe'])) {
                                    $value = password_hash($value, PASSWORD_DEFAULT);
                                    $sql_updates[] = "`" . $col_name . "` = :" . $col_name;
                                    $bind_params[":" . $col_name] = $value;
                                }
                            }
                            // Si le champ mdp est laissé vide, on ne fait rien (ne pas l'ajouter à $sql_updates)
                        } else {
                            // Pour les autres champs
                            $sql_updates[] = "`" . $col_name . "` = :" . $col_name;
                            $bind_params[":" . $col_name] = ($value === '' && !($col_config['required'] ?? false)) ? null : $value; // Mettre NULL si vide et non requis
                        }
                    }
                }

                if (!empty($sql_updates)) {
                    $bind_params[":" . $pk_name] = $id; // Ajouter l'ID pour la clause WHERE
                    $sql = "UPDATE `$table_name` SET " . implode(', ', $sql_updates) . " WHERE `$pk_name` = :$pk_name";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute($bind_params);
                    $message = htmlspecialchars($config['display_name']) . " modifié(e) avec succès.";
                    $message_type = 'success';
                } else {
                     $message = "Aucune modification détectée ou fournie.";
                     $message_type = 'info';
                }
            }
            // Action: Supprimer
            elseif ($action === 'delete' && isset($_POST['deleteData']) && $id) {
                // Optionnel: Ajouter une vérification pour empêcher la suppression de l'admin actuellement connecté
                if ($table_key === 'administrateurs' && $id == $_SESSION['admin_id']) {
                     throw new Exception("Vous ne pouvez pas supprimer votre propre compte administrateur.");
                }

                $sql = "DELETE FROM `$table_name` WHERE `$pk_name` = :$pk_name";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":$pk_name", $id, PDO::PARAM_INT); // Assumer que PK est INT
                $stmt->execute();

                // Vérifier si la suppression a réussi
                if ($stmt->rowCount() > 0) {
                    $message = htmlspecialchars($config['display_name']) . " supprimé(e) avec succès.";
                    $message_type = 'success';
                } else {
                    $message = "L'élément n'a pas pu être trouvé ou supprimé.";
                    $message_type = 'warning';
                }
            }
        } catch (PDOException $e) {
            $message = "Erreur base de données lors de l'opération : " . $e->getMessage();
            // En production, logguer $e->getMessage() et afficher un message plus générique
            // $message = "Une erreur technique est survenue. Code: PDO";
            $message_type = 'error';
        } catch (Exception $e) { // Capturer d'autres exceptions (ex: auto-suppression admin)
             $message = "Erreur : " . $e->getMessage();
             $message_type = 'error';
        }
    }

    // --- Récupération des données pour affichage ---
    try {
        $sql = "SELECT * FROM `$table_name`";
        // Ajouter la condition de listage si définie
        if (!empty($config['list_condition'])) {
            $sql .= " WHERE " . $config['list_condition'];
        }
        // Optionnel: Ajouter un tri par défaut
        $sql .= " ORDER BY `$pk_name` DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $data_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Erreur lors de la récupération des données: " . $e->getMessage();
        $message_type = 'error';
        // En production, logguer $e->getMessage()
        // $message = "Erreur technique lors de la récupération des données. Code: FETCH";
        $data_list = []; // Assurer que data_list est un tableau vide en cas d'erreur
    }

} else {
    // Si aucune table valide n'est spécifiée dans l'URL
    if ($table_key) {
        $message = "Erreur : La section de gestion '$table_key' n'est pas configurée.";
        $message_type = 'error';
    } else {
         $message = "Veuillez sélectionner une section à gérer dans le menu.";
         $message_type = 'info';
    }
    // Ne pas afficher de formulaire ou de tableau si la config n'est pas chargée
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre dynamique basé sur la section gérée -->
    <title>Gestion des <?php echo $config ? htmlspecialchars($config['display_name']) : 'Entités'; ?></title>
    <!-- Utilisation de Bootstrap et FontAwesome via CDN (Assurez-vous d'avoir une connexion internet) -->
    <!-- Si vous travaillez hors ligne, téléchargez ces fichiers et liez-les localement -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour améliorer l'interface de gestion */
        .message { margin-bottom: 1.5rem; padding: 1rem; border-radius: 0.3rem; border: 1px solid transparent; }
        .message.success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .message.error { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
        .message.warning { color: #664d03; background-color: #fff3cd; border-color: #ffecb5; }
        .message.info { color: #055160; background-color: #cff4fc; border-color: #b6effb; }
        .action-icons i { cursor: pointer; margin-right: 0.75rem; font-size: 1.1rem; transition: opacity 0.2s ease-in-out; }
        .action-icons i.fa-edit { color: #0d6efd; } /* Bleu Bootstrap */
        .action-icons i.fa-trash-alt { color: #dc3545; } /* Rouge Bootstrap */
        .action-icons i:hover { opacity: 0.7; }
        th { background-color: #e9ecef; } /* Gris clair pour les en-têtes */
        .form-label .text-danger { font-size: 0.9em; margin-left: 2px; }
        #addFormContainer { display: none; /* Caché par défaut */ margin-top: 1rem; }
        .table-responsive { margin-top: 1.5rem; }
        /* Rendre les champs readonly visuellement distincts */
        input[readonly], textarea[readonly] {
            background-color: #e9ecef;
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4"> <!-- Utiliser container-fluid pour plus d'espace -->

        <?php if ($config): // Afficher le titre et les contrôles seulement si une table valide est sélectionnée ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                 <h2 class="mb-0">Gestion des <?php echo htmlspecialchars($config['display_name']); ?></h2>
                 <button class="btn btn-primary" onclick="toggleAddForm()">
                     <i class="fas fa-plus me-1"></i> Ajouter
                 </button>
            </div>

             <!-- Affichage des messages (succès, erreur, etc.) -->
            <?php if ($message): ?>
                <div class="message <?php echo htmlspecialchars($message_type); ?>" role="alert">
                    <?php echo $message; // Le message est déjà échappé lors de sa création si nécessaire ?>
                </div>
            <?php endif; ?>


            <!-- Formulaire d'Ajout (initiallement caché) -->
            <div id="addFormContainer" class="card card-body mb-4">
                 <h4>Ajouter un(e) nouveau/nouvelle <?php echo htmlspecialchars($config['display_name']); ?></h4>
                 <hr>
                <form action="gestion_generique.php?table=<?php echo htmlspecialchars($table_key); ?>" method="post" id="addForm">
                    <input type="hidden" name="action" value="add">
                    <div class="row g-3"> <!-- Utiliser une grille pour mieux organiser les champs -->
                        <?php foreach ($columns_for_form as $col_name => $col_config): ?>
                            <?php if ($col_name === $pk_name) continue; // Ne pas afficher la PK auto-incrémentée ?>
                            <div class="col-md-6"> <!-- Mettre 2 champs par ligne sur écran moyen/large -->
                                <label for="add_<?php echo $col_name; ?>" class="form-label">
                                    <?php echo htmlspecialchars($col_config['label']); ?>
                                    <?php echo (isset($col_config['required']) && $col_config['required']) ? '<span class="text-danger">*</span>' : ''; ?>
                                </label>
                                <?php $input_type = htmlspecialchars($col_config['type']); ?>
                                <?php if ($input_type === 'textarea'): ?>
                                    <textarea class="form-control" id="add_<?php echo $col_name; ?>" name="<?php echo $col_name; ?>" rows="3" <?php echo (isset($col_config['required']) && $col_config['required']) ? 'required' : ''; ?>></textarea>
                                <?php else: ?>
                                    <input type="<?php echo $input_type; ?>" class="form-control" id="add_<?php echo $col_name; ?>" name="<?php echo $col_name; ?>" <?php echo (isset($col_config['required']) && $col_config['required']) ? 'required' : ''; ?>>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-3">
                        <button type="submit" name="addData" class="btn btn-success">
                             <i class="fas fa-check me-1"></i> Ajouter
                        </button>
                         <button type="button" class="btn btn-secondary" onclick="toggleAddForm()">Annuler</button>
                    </div>
                </form>
            </div>

            <!-- Tableau des Données Existantes -->
            <h4>Liste existante</h4>
            <div class="table-responsive shadow-sm"> <!-- Ajout d'une ombre légère -->
                <table class="table table-striped table-hover table-bordered mt-2"> <!-- Ajout de bordures -->
                    <thead class="table-light"> <!-- En-tête légèrement différentié -->
                        <tr>
                            <?php foreach ($columns_to_display as $col_name => $col_config): ?>
                                <th><?php echo htmlspecialchars($col_config['label']); ?></th>
                            <?php endforeach; ?>
                            <th style="width: 100px;">Actions</th> <!-- Largeur fixe pour la colonne Actions -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_list)): ?>
                            <tr>
                                <td colspan="<?php echo count($columns_to_display) + 1; ?>" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle me-2"></i>Aucun enregistrement trouvé pour "<?php echo htmlspecialchars($config['display_name']); ?>".
                                    <?php if (!empty($config['list_condition'])): ?>
                                        <small>(Filtre appliqué: <?php echo htmlspecialchars($config['list_condition']); ?>)</small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data_list as $row): ?>
                                <tr>
                                    <?php foreach ($columns_to_display as $col_name => $col_config): ?>
                                        <td>
                                            <?php
                                                // Tronquer les textes longs (ex: description, contenu) pour l'affichage
                                                $cell_value = $row[$col_name] ?? '';
                                                if (strlen($cell_value) > 75 && ($col_config['type'] ?? 'text') === 'textarea') {
                                                    echo htmlspecialchars(substr($cell_value, 0, 75)) . '...';
                                                } else {
                                                    echo htmlspecialchars($cell_value);
                                                }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class='action-icons text-center'>
                                        <?php
                                            // Préparer les données pour le modal de modification (sérialisées en JSON)
                                            // Exclure explicitement le mot de passe des données passées au JS
                                            $edit_data = [];
                                            foreach ($config['columns'] as $cn => $cc) {
                                                 if ($cn !== 'mot_de_passe') {
                                                     $edit_data[$cn] = $row[$cn] ?? '';
                                                 } else {
                                                      $edit_data[$cn] = ''; // Toujours passer une chaîne vide pour le mdp au modal
                                                 }
                                            }
                                        ?>
                                        <i class='fas fa-edit' title="Modifier" onclick='showEditModal(<?php echo json_encode($edit_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>)'></i>
                                        <i class='fas fa-trash-alt' title="Supprimer" onclick='deleteItem(<?php echo json_encode($row[$pk_name]); ?>)'></i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal pour la Modification -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg"> <!-- Modal plus large -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Modifier <?php echo htmlspecialchars($config['display_name']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" action="gestion_generique.php?table=<?php echo htmlspecialchars($table_key); ?>" method="post">
                                <input type="hidden" name="action" value="edit">
                                <!-- La clé primaire sera remplie par JavaScript -->
                                <input type="hidden" name="<?php echo $pk_name; ?>" id="edit_<?php echo $pk_name; ?>">

                                <div class="row g-3">
                                    <?php foreach ($columns_for_form as $col_name => $col_config): ?>
                                         <?php if ($col_name === $pk_name) continue; // Ne pas afficher la PK ?>
                                         <?php if (isset($col_config['no_edit']) && $col_config['no_edit']) continue; // Ne pas afficher si non modifiable ?>
                                        <div class="col-md-6">
                                            <label for="edit_<?php echo $col_name; ?>" class="form-label">
                                                <?php echo htmlspecialchars($col_config['label']); ?>
                                                <?php echo (isset($col_config['required']) && $col_config['required'] && !(isset($col_config['edit_optional']) && $col_config['edit_optional'])) ? '<span class="text-danger">*</span>' : ''; ?>
                                                <?php if (isset($col_config['edit_optional']) && $col_config['edit_optional']): ?>
                                                    <small class="text-muted">(Laisser vide pour ne pas changer)</small>
                                                <?php endif; ?>
                                            </label>
                                            <?php $input_type = htmlspecialchars($col_config['type']); ?>
                                            <?php if ($input_type === 'textarea'): ?>
                                                <textarea class="form-control" id="edit_<?php echo $col_name; ?>" name="<?php echo $col_name; ?>" rows="3" <?php echo (isset($col_config['required']) && $col_config['required'] && !(isset($col_config['edit_optional']) && $col_config['edit_optional'])) ? 'required' : ''; ?>></textarea>
                                            <?php else: ?>
                                                <input type="<?php echo $input_type; ?>" class="form-control" id="edit_<?php echo $col_name; ?>" name="<?php echo $col_name; ?>" <?php echo (isset($col_config['required']) && $col_config['required'] && !(isset($col_config['edit_optional']) && $col_config['edit_optional'])) ? 'required' : ''; ?>>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="modal-footer mt-3"> <!-- Placer les boutons dans le footer du modal -->
                                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                     <button type="submit" name="editData" class="btn btn-primary">
                                         <i class="fas fa-save me-1"></i> Enregistrer
                                     </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire caché pour la suppression (soumis par JavaScript) -->
            <form id="deleteForm" action="gestion_generique.php?table=<?php echo htmlspecialchars($table_key); ?>" method="post" style="display: none;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="<?php echo $pk_name; ?>" id="delete_id">
                <input type="hidden" name="deleteData" value="1"> <!-- Juste pour confirmer l'intention -->
            </form>

        <?php else: // Afficher le message d'erreur/info si aucune config n'est chargée ?>
             <?php if ($message): ?>
                <div class="message <?php echo htmlspecialchars($message_type); ?>" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
             <p class="text-center text-muted mt-5">Sélectionnez une section dans le menu latéral pour commencer.</p>
        <?php endif; // Fin de la condition if($config) ?>

    </div> <!-- Fin container-fluid -->

    <!-- Scripts JavaScript (Bootstrap requis pour les Modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Garder une référence globale à l'instance du modal Bootstrap pour pouvoir l'ouvrir/fermer par JS
        var editModalInstance = null;
        var addFormContainer = null; // Référence au conteneur du formulaire d'ajout

        document.addEventListener('DOMContentLoaded', function() {
             var modalElement = document.getElementById('editModal');
             if (modalElement) {
                editModalInstance = new bootstrap.Modal(modalElement);
             }
             addFormContainer = document.getElementById('addFormContainer');

             // Optionnel: Fermer le formulaire d'ajout si on clique en dehors (peut être gênant)
             // document.addEventListener('click', function(event) {
             //    if (addFormContainer && addFormContainer.style.display === 'block') {
             //       const addForm = document.getElementById('addForm');
             //       const addButton = document.querySelector('button[onclick="toggleAddForm()"]');
             //       if (!addForm.contains(event.target) && !addButton.contains(event.target)) {
             //          addFormContainer.style.display = 'none';
             //       }
             //    }
             // });
        });

        // Fonction pour afficher/masquer le formulaire d'ajout
        function toggleAddForm() {
            if (addFormContainer) {
                if (addFormContainer.style.display === 'none' || addFormContainer.style.display === '') {
                    addFormContainer.style.display = 'block';
                    // Optionnel: Mettre le focus sur le premier champ du formulaire
                    const firstInput = addFormContainer.querySelector('input:not([type=hidden]), textarea');
                    if(firstInput) firstInput.focus();
                } else {
                    addFormContainer.style.display = 'none';
                }
            } else {
                 console.error("Le conteneur du formulaire d'ajout (addFormContainer) n'a pas été trouvé.");
            }
        }

        // Fonction pour afficher le modal de modification et pré-remplir les champs
        function showEditModal(data) {
            // Récupérer le nom de la clé primaire dynamiquement depuis PHP
            const pk_name = <?php echo json_encode($pk_name ?? 'id'); ?>;

            // Remplir le formulaire du modal avec les données fournies
            for (const key in data) {
                const inputElement = document.getElementById('edit_' + key);
                if (inputElement) {
                    // Gérer le cas spécial du mot de passe: toujours l'afficher vide dans le formulaire
                    if (inputElement.type === 'password') {
                        inputElement.value = '';
                        // Rendre le champ non-requis s'il est marqué comme optionnel à l'édition
                        const colConfig = <?php echo json_encode($config['columns'] ?? []); ?>;
                        if(colConfig[key] && colConfig[key].edit_optional) {
                             inputElement.required = false;
                        }
                    } else {
                        inputElement.value = data[key];
                    }
                } else {
                    // Si l'élément est la clé primaire (cachée), la remplir aussi
                    if (key === pk_name) {
                         const pkInput = document.getElementById('edit_' + pk_name);
                         if(pkInput) pkInput.value = data[key];
                    }
                }
            }

             // S'assurer que l'instance du modal est prête avant de l'afficher
            if (editModalInstance) {
                editModalInstance.show();
            } else {
                 console.error("L'instance du modal de modification (editModalInstance) n'est pas initialisée.");
                 alert("Erreur: Impossible d'ouvrir le formulaire de modification.");
            }
        }

        // Fonction pour demander confirmation et soumettre le formulaire de suppression
        function deleteItem(id) {
            // Utiliser une boîte de dialogue de confirmation native du navigateur
            if (confirm("Êtes-vous sûr de vouloir supprimer cet enregistrement ?\nCette action est irréversible.")) {
                const deleteIdInput = document.getElementById('delete_id');
                const deleteForm = document.getElementById('deleteForm');
                if (deleteIdInput && deleteForm) {
                    deleteIdInput.value = id;
                    deleteForm.submit();
                } else {
                     console.error("Le formulaire de suppression ou le champ ID caché est introuvable.");
                     alert("Erreur: Impossible d'initier la suppression.");
                }
            }
            // Si l'utilisateur clique sur "Annuler", rien ne se passe.
        }
    </script>
</body>
</html>
