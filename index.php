<?php
require_once "vendor/autoload.php";

use iutnc\location\db\ConnectionFactory;

ConnectionFactory::setConfig('./config/db.config.ini');
ConnectionFactory::makeConnection();

$rend = "";
$action = $_GET['action'] ?? "";
$error = "";

$ad = new \iutnc\location\db\AccessData();

switch ($action)
{
    case 'listVehic' :
        $method = $_SERVER['REQUEST_METHOD'];
        $checkfields = (!isset($_POST['categ'], $_POST['startD'], $_POST['endD']) || ($_POST['categ'] == "" || $_POST['startD'] == "" || $_POST['endD'] == "")) && $method == "POST";
        if ($method == "GET" || $checkfields)
        {
            $error = $checkfields ? "Veuillez remplir tous les champs !" : "";

            $rend .= <<<END
            <form method='post' action='?action=listVehic'>
                Catégorie : <input type='text' name='categ'>
                Date de début : <input type='date' name='startD'>
                Date de fin : <input type='date' name='endD'>
                <input type='submit' value='Valider'>
            </form>
            <small>$error</small>
            END;
        }

        else
            //$rend .= $ad->listVehic($_POST['categ'], $_POST['startD'], $_POST['endD']);
            $rend .= $ad->testQuery();

        $test = $_POST['categ'] != "" ? "vrai" : "faux";
        echo $test;


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

echo <<<END
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
                <li><a href="./?action=listVehic">List of available vehicles</a></li>
                <li><a href="./?action=majCal">MAJ booking calendar</a></li>
                <li><a href="./?action=locAmount">Locations amount</a></li>
                <li><a href="./?action=categAgencies">Agencies with all vehicles' categories</a></li>
                <li><a href="./?action=cliModels">Clients who have located 2 different models</a></li>
            </ul>
        </nav>
        <main>
            $rend
        </main>
    </body>
    </html>
END;

?>

