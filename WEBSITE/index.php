<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat de Menu</title>
    <meta name="description" content="Page d'achat de menu pour les clients">
</head>

<body>
    <h1>Achat de Menu pour le client 1</h1>

    <form id="menuForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="menu">Choisir un menu :</label>
        <select name="menu" id="menu" onchange="this.form.submit();">
            <option value="0">Sélectionnez un menu</option>
            <?php
            require_once 'inc/config.php';

            // Récupérer les menus disponibles
            $sql = "SELECT id_menu, nom_menu, prix_menu FROM menu";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = (isset($_POST['menu']) && $_POST['menu'] == $row['id_menu']) ? 'selected' : '';
                    echo '<option value="' . $row['id_menu'] . '" ' . $selected . '>';
                    echo $row['nom_menu'] . ' - ' . $row['prix_menu'] . ' €';
                    echo '</option>';
                }
            }
            ?>
        </select>

        <?php
        // Affichage des détails du menu sélectionné
        if (isset($_POST['menu']) && $_POST['menu'] != 0) {
            $idMenu = $_POST['menu'];
            $sqlMenuDetails = "SELECT m.nom_menu, m.prix_menu, f.nom_focaccia, f.prix_focaccia, b.nom_boisson, 
                GROUP_CONCAT(DISTINCT i.nom_ingredient SEPARATOR ', ') AS ingredients
                FROM menu m
                JOIN boisson b ON m.id_boisson = b.id_boisson
                JOIN menu_focaccia mf ON m.id_menu = mf.id_menu
                JOIN focaccia f ON mf.id_focaccia = f.id_focaccia
                JOIN focaccia_ingredient fi ON f.id_focaccia = fi.id_focaccia
                JOIN ingredient i ON fi.id_ingredient = i.id_ingredient
                WHERE m.id_menu = ?
                GROUP BY m.id_menu";

            $stmt = $conn->prepare($sqlMenuDetails);
            $stmt->bind_param("i", $idMenu);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $menuDetails = $result->fetch_assoc();
                echo '<h2>Détails du Menu :</h2>';
                echo '<p>Nom du Menu : ' . $menuDetails['nom_menu'] . '</p>';
                echo '<p>Prix de la Focaccia seule : ' . $menuDetails['prix_focaccia'] . ' €</p>';
                echo '<p>Prix du Menu (avec Focaccia et boisson) : ' . $menuDetails['prix_menu'] . ' €</p>';
                echo '<p>Boisson incluse : ' . $menuDetails['nom_boisson'] . '</p>';
                echo '<h3>Pizzas incluses :</h3>';
                echo '<p>' . $menuDetails['nom_focaccia'] . '</p>';
                echo '<h3>Ingrédients :</h3>';
                echo '<p>' . $menuDetails['ingredients'] . '</p>';
                echo '<input type="hidden" name="menu_id" value="' . $idMenu . '">';
            }
        }
        ?>

        <?php
        // Affichage du bouton "Commander" uniquement si un menu est sélectionné
        if (isset($_POST['menu']) && $_POST['menu'] != 0) {
            echo '<button type="submit" name="commander_menu">Commander</button>';
        }
        ?>

    </form>

    <?php
    // Traitement de l'insertion dans achat et paye
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["commander_menu"])) {
        $idClient = 1; // ID du client
        $idMenu = $_POST['menu_id'];
        $jour = date("Y-m-d");

        // Insertion dans la table achete
        $sqlInsertAchat = "INSERT INTO achete (id_client, id_menu, jour) VALUES (?, ?, ?)";
        $stmtAchat = $conn->prepare($sqlInsertAchat);
        $stmtAchat->bind_param("iis", $idClient, $idMenu, $jour);
        $stmtAchat->execute();

        // Insertion dans la table paye
        $sqlInsertPaye = "INSERT INTO paye (id_client, id_menu, jour) VALUES (?, ?, ?)";
        $stmtPaye = $conn->prepare($sqlInsertPaye);
        $stmtPaye->bind_param("iis", $idClient, $idMenu, $jour);
        $stmtPaye->execute();

        echo '<p>Commande passée avec succès pour le Menu : ' . $idMenu . '</p>';

        // Réinitialiser la sélection de la liste déroulante
        echo '<script>document.getElementById("menu").value = "0";</script>';
    }
    ?>

    <?php
    // Affichage des commandes du client
    $idClient = 1; // ID du client
    $sqlCommandes = "SELECT m.nom_menu, a.jour
                     FROM achete a
                     JOIN menu m ON a.id_menu = m.id_menu
                     WHERE a.id_client = ?";

    $stmtCommandes = $conn->prepare($sqlCommandes);
    $stmtCommandes->bind_param("i", $idClient);
    $stmtCommandes->execute();
    $resultCommandes = $stmtCommandes->get_result();

    if ($resultCommandes->num_rows > 0) {
        echo '<h2>Commandes passées :</h2>';
        echo '<ul>';
        while ($row = $resultCommandes->fetch_assoc()) {
            echo '<li>' . $row['nom_menu'] . ' - ' . $row['jour'] . '</li>';
        }
        echo '</ul>';
    }
    ?>

    <script>
        // JavaScript pour conserver la sélection après l'envoi du formulaire
        const menuSelect = document.getElementById('menu');
        const selectedValue = '<?php echo isset($_POST['menu']) ? $_POST['menu'] : ''; ?>';
        if (selectedValue) {
            menuSelect.value = selectedValue;
        }
    </script>

</body>

</html>