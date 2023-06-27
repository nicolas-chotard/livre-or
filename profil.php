<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profil.css">
    <title>Document</title>
</head>
<body>
<header>
        <h1>Mon site</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="inscripconnect.php">Inscription</a>
            <a href="profil.php">Profil</a>
        </nav>
    </header>

    <?php

require_once "config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newLogin = $_POST["new_login"];


    if (!empty($newLogin)) {

        $sql = "UPDATE user SET login = :login WHERE id = :id";

        if ($stmt = $pdo->prepare($sql)) {

            $stmt->bindParam(":login", $newLogin, PDO::PARAM_STR);
            $stmt->bindParam(":id", $_SESSION["user_id"], PDO::PARAM_INT);


            if ($stmt->execute()) {

                echo "Votre login a été mis à jour avec succès.";
            } else {
                echo "Une erreur est survenue lors de la mise à jour du login.";
            }
        }
        unset($stmt);
    } else {
        echo "Veuillez saisir un nouvel identifiant de connexion.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier le profil</title>
</head>
<body>
    <h2>Modifier le profil</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="new_login">Nouvel identifiant de connexion :</label>
        <input type="text" name="new_login" id="new_login" required>
        <br>
        <input type="submit" value="Modifier">
    </form>
</body>
</html>


    <footer>
        <p>&copy; 2023 Mon site. Tous droits réservés.</p>
    </footer>
</body>
</html>