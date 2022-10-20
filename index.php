<?php
require_once "vendor/autoload.php";

use iutnc\location\db\ConnectionFactory;

ConnectionFactory::setConfig('./config/db.config.ini');
//ConnectionFactory::makeConnection();

$ad = new \iutnc\location\db\AccessData();

$rend = "";
$action = $_GET['action'] ?? "";
$error = "";
$method = $_SERVER['REQUEST_METHOD'];


switch ($action)
{
    case 'listVehic' :
        $checkfields = (!isset($_POST['categ'], $_POST['startD'], $_POST['endD']) || ($_POST['categ'] == "" || $_POST['startD'] == "" || $_POST['endD'] == ""));
        $error = $checkfields && $method == "POST" ? "Veuillez remplir tous les champs !<br>" : "";

        $rend .= <<<END
        <form method='post' action='?action=listVehic'>
            Catégory : <input type='text' name='categ'>
            Start date : <input type='date' name='startD'>
            End date : <input type='date' name='endD'>
            <input type='submit' value='Confirm'>
        </form>
        <br>
        <small>$error</small>
        END;

        if (!$checkfields)
        {
            $c = filter_var($_POST['categ'], FILTER_SANITIZE_SPECIAL_CHARS);
            $sD = filter_var($_POST['startD'], FILTER_SANITIZE_SPECIAL_CHARS);
            $eD = filter_var($_POST['endD'], FILTER_SANITIZE_SPECIAL_CHARS);
            $rend .= $ad->listVehic($c, $sD, $eD);
        }
        break;
    case 'majCal':
        $checkfields = (!isset($_POST['plate'], $_POST['startD'], $_POST['endD']) || ($_POST['plate'] == "" || $_POST['startD'] == "" || $_POST['endD'] == ""));
        $error = $checkfields && $method == "POST" ? "Veuillez remplir tous les champs !<br>" : "";

        $rend .= <<<END
        <form method='post' action='?action=majCal'>
            Plate : <input type='text' name='plate'>
            Start date : <input type='date' name='startD'>
            End date : <input type='date' name='endD'>
            Unfree : <input type="checkbox" name="loc">
            <input type='submit' value='Confirm'>
        </form>
        <small>$error</small>
        END;

        if (!$checkfields)
        {
            $p = filter_var($_POST['plate'], FILTER_SANITIZE_SPECIAL_CHARS);
            $sD = filter_var($_POST['startD'], FILTER_SANITIZE_SPECIAL_CHARS);
            $eD = filter_var($_POST['endD'], FILTER_SANITIZE_SPECIAL_CHARS);
            $l = isset($_POST['loc']) ? filter_var($_POST['loc'], FILTER_SANITIZE_SPECIAL_CHARS) : false;
            $rend .= $ad->majCal($p, $sD, $eD, $l);
        }
        break;
    case 'locAmount':
        $checkfields = (!isset($_POST['model'], $_POST['duration']) || ($_POST['model'] == "" || $_POST['duration'] == ""));
        $error = $checkfields && $method == "POST" ? "Veuillez remplir tous les champs !<br>" : "";

        $rend .= <<<END
        <form method='post' action='?action=locAmount'>
            Model : <input type='text' name='model'>
            Duration : <input type='number' name='duration'> days
            <input type='submit' value='Confirm'>
        </form>
        <small>$error</small>
        END;

        if (!$checkfields)
        {
            $m = filter_var($_POST['model'], FILTER_SANITIZE_SPECIAL_CHARS);
            $d = filter_var($_POST['duration'], FILTER_SANITIZE_SPECIAL_CHARS);
            $rend .= $ad->locAmount($m, $d);
        }
        break;
    case 'categAgencies':
        $rend .= $ad->allCategsAgencies();
        break;
    case 'cliModels':
        $rend .= $ad->cliList2Models();
        break;
    default:
        $rend .= "Welcome ! Please choose an action above.";
}

echo <<<END
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SQL - Location Project</title>
    </head>
    <body>
    <header>
        <h1>Hugo COLLIN - S3A</h1>
        <h4>21/10/2022 - IUT Nancy-Charlemagne</h4>
    </header>
        <nav>
            <ul>
                <li><a href="./">Home</a></li>
                <li><a href="./?action=listVehic">List of available vehicles</a></li>
                <li><a href="./?action=majCal">Update booking calendar</a></li>
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

