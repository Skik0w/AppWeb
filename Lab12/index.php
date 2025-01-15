<?php
// Inicjalizacja sesji
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany; ustawienie domyślnej wartości
if (!isset($_SESSION["is_logged"])) {
    $_SESSION["is_logged"] = 0; 
}

// Ustawienia raportowania błędów
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Dołączenie wymaganych plików zewnętrznych
include('cfg.php'); // Plik konfiguracyjny
include('showpage.php'); // Obsługa wyświetlania stron

// Logika przypisywania podstrony na podstawie parametru GET
if($_GET['idp'] == '') $strona = '1';
if($_GET['idp'] == '2') $strona = '2';
if($_GET['idp'] == '3') $strona = '3';
if($_GET['idp'] == '4') $strona = '4';
if($_GET['idp'] == '5') $strona = '5';
if($_GET['idp'] == '6') $strona = '6';
if($_GET['idp'] == '7') $strona = '7';
if($_GET['idp'] == '8') $strona = '8';
if($_GET['idp'] == '9') $strona = '9';
if($_GET['idp'] == '10') $strona ='10';
if($_GET['idp'] == '11') $strona ='11';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Language" content="pl" />
        <meta name="Author" content="Bartosz Kowalski" />
        <title>Największe budynki świata</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/kolorujtlo.js" type="text/javascript"></script>
        <script src="js/timedate.js" type="text/javascript"></script> 
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="css/kontakt.css">
        <link rel="stylesheet" href="css/sklep.css">
    </head>

    <body onload="startclock()">
        <header>
            <h1>NAJWIĘKSZE BUDYNKI ŚWIATA</h1>
            <nav>
                <!-- Nawigacja między podstronami -->
                <a href="index.php?idp=">Start</a>
                <a href="index.php?idp=2">Ranking</a>
                <a href="index.php?idp=3">Ciekawostki</a>
                <a href="index.php?idp=4">Galeria</a>
                <a href="index.php?idp=5">Kontakt</a>
                <a href="index.php?idp=6">JS</a>
                <a href="index.php?idp=7">JQ</a>
                <a href="index.php?idp=8">Filmy</a>   
                <a href="index.php?idp=9">Admin</a> 
                <a href="index.php?idp=10">Kontakt PHP</a>
                <a href="index.php?idp=11">Sklep</a>      
            </nav>
        </header>

        <?php
            if ($_GET['idp'] == '9') {
                include('./admin/admin.php');
            }
            elseif ($_GET['idp'] == '10') {
                include('contactSMTP.php');
            }
            elseif ($_GET['idp'] == '11') {
                include('sklep.php');
            }
            else {
                echo PokazPodstrone($strona);
            }
        ?>

        <footer>
            <!-- Stopka strony -->
            <u>Największe budynki świata wersja v1.10</u>
        </footer>

        <?php
        // Informacje o autorze
        $nr_indeksu = '169271';
        $nrGrupy = 'ISI2';
        echo 'Autor: Bartosz Kowalski '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
        ?>
    </body>
</html>
