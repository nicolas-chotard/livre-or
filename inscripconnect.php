<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inscripconnect.css">
    <title>Document</title>
</head>
<body>
<?php

$host = 'localhost';
$db_name = 'livreor';
$username = 'root';
$password = '1234';

try {
    $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['inscription'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $query = "SELECT COUNT(*) as count FROM user WHERE login = :login";
        $statement = $db->prepare($query);
        $statement->execute([':login' => $login]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            $message = 'Ce nom d\'utilisateur est déjà utilisé.';
        } else {
            $query = "INSERT INTO user (login, password) VALUES (:login, :password)";
            $statement = $db->prepare($query);
            $statement->execute([':login' => $login, ':password' => $password]);
            $message = 'Inscription réussie !';
        }
    } elseif (isset($_POST['connexion'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $query = "SELECT COUNT(*) as count FROM user WHERE login = :login AND password = :password";
        $statement = $db->prepare($query);
        $statement->execute([':login' => $login, ':password' => $password]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            $message = 'Connexion réussie !';
        } else {
            $message = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    }
}
?>
<header>
        <h1>Mon site</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="inscripconnect.php">Inscription</a>
            <a href="profil.php">Profil</a>
        </nav>
    </header>
<div class="main">
    <h2>Inscription</h2>
    <form action="inscripconnect.php" method="POST">
        <div class="form-group">
            <label for="inscription-login">Nom d'utilisateur :</label>
            <input type="text" id="inscription-login" name="login" required>

            <label for="inscription-password">Mot de passe :</label>
            <input type="password" id="inscription-password" name="password" required>

            <input type="submit" name="inscription" value="S'inscrire">
        </div>
        <div class="form-group message">
            <?= $message ?>
        </div>
    </form>

    <h2>Connexion</h2>
    <form action="inscripconnect.php" method="POST">
        <div class="form-group">
            <label for="connexion-login">Nom d'utilisateur :</label>
            <input type="text" id="connexion-login" name="login" required>
        </div>
        <div class="form-group">
            <label for="connexion-password">Mot de passe :</label>
            <input type="password" id="connexion-password" name="password" required>
        </div>
        <div class="form-group">
            <input type="submit" name="connexion" value="Se connecter">
        </div>
        <div class="form-group message">
            <?= $message ?>
        </div>
    </form>
</div>
<footer>
    <p>&copy; 2023 Mon site. Tous droits réservés.</p>
</footer>
</body>
</html>