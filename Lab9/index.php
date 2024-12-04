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
include('./admin/admin.php'); // Panel administracyjny
include('contact.php'); // Obsługa formularza kontaktowego

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
if($_GET['idp'] == '10') $strona = '10';
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
        <link rel="stylesheet" href="css/style2.css">
        <link rel="stylesheet" href="css/style3.css">
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
            </nav>
        </header>

        <?php
            // Obsługa panelu administracyjnego
            if ($_GET['idp'] == '9') {
                echo '<div class="admin-panel">';
                if ($_SESSION["is_logged"] == 0) {
                    PrzetwarzanieFormularza(); // Obsługa formularza logowania
                    if ($_SESSION["is_logged"] == 0) {
                        echo FormularzLogowania(); // Wyświetlenie formularza logowania
                    }
                }
            
                if ($_SESSION["is_logged"] == 1) {
                    include('./html/admin.html'); // Wyświetlenie strony administracyjnej
                    if ($_GET['action'] == 'list') {
                        ListaPodstron(); // Wyświetlenie listy podstron
                    }
                    if ($_GET['action'] == 'add') {
                        echo DodajNowaPodstrone(); // Dodanie nowej podstrony
                    }
                    PrzetwarzajEdycje(); // Obsługa edycji podstron
                    PrzetwarzajDodanie(); // Obsługa dodawania podstron
                }
                echo '</div>';
            }
            else {
                echo PokazPodstrone($strona); // Wyświetlenie wybranej podstrony
            }

            // Obsługa formularza kontaktowego PHP
            if($_GET['idp'] == '10') {
                echo('<h2 class="heading">Przypomnij haslo:</h2>');
                echo('<form method="post" name="PasswordForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
                    <input type="text" name="email" id="email" class="formField" placeholder="Wpisz adres email"> 
                    <br>
                    <input type="submit" name="password_submit" class="remind-password-button" value="Przypomnij hasło">
                    </form>');
                if (isset($_POST['password_submit'])) {
                    $email = $_POST['email'];
                    PrzypomnijHaslo($email); // Obsługa przypominania hasła
                }
                if (isset($_POST['contact_submit'])) {
                    $email = $_POST['email'];
                    WyslijMailaKontakt($email); // Obsługa wysyłania wiadomości
                } else {
                    echo(PokazKontakt()); // Wyświetlenie formularza kontaktowego
                }
            }
        ?>

        <footer>
            <!-- Stopka strony -->
            <u>Największe budynki świata wersja v1.8</u>
        </footer>

        <?php
        // Informacje o autorze
        $nr_indeksu = '169271';
        $nrGrupy = 'ISI2';
        echo 'Autor: Bartosz Kowalski '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
        ?>
    </body>
</html>
