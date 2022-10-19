<?php
require_once "vendor/autoload.php";

use iutnc\location\db\ConnectionFactory;
//require_once "src/classes/db/AccessData.php";
/*
try {
    $pdo = new PDO('mysql:host=localhost;dbname=s3_location', 'root', '');
}
catch (PDOException $e)
{
    exit('Database error.');
}*/

ConnectionFactory::setConfig('./config/db.config.ini');
ConnectionFactory::makeConnection();

$rend = "";
$action = $_GET['action'] ?? "";

$ad = new \iutnc\location\db\AccessData();

switch ($action)
{
    case 'listVehic' :
        break;
    case 'majCal':
        break;
    case 'locAmount':
        break;
    case 'categAgencies':
        break;
    case 'cliModels':
        break;
    default:
        $rend .= "Bienvenue !";
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SQL - Location Project</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="./">Accueil</a></li>
            <li><a href="./?action=listVehic">Ajouter un utilisateur</a></li>
            <li><a href="./?action=majCal">Ajouter une playlist</a></li>
            <li><a href="./?action=locAmount">Ajouter un podcast</a></li>
            <li><a href="./?action=categAgencies">Ajouter un podcast</a></li>
            <li><a href="./?action=cliModels">Ajouter un podcast</a></li>
        </ul>
    </nav>
    <main>
        <?php echo $rend; ?>
    </main>
</body>
</html>