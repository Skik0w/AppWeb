<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

    include('cfg.php');
    include('showpage.php');

    if($_GET['idp'] == '') $strona = '1';
    if($_GET['idp'] == '2') $strona = '2';
    if($_GET['idp'] == '3') $strona = '3';
    if($_GET['idp'] == '4') $strona = '4';
    if($_GET['idp'] == '5') $strona = '5';
    if($_GET['idp'] == '6') $strona = '6';
    if($_GET['idp'] == '7') $strona = '7';
    if($_GET['idp'] == '8') $strona = '8';
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
    </head>

    <body onload="startclock()">
        <header>
            <h1>NAJWIĘKSZE BUDYNKI ŚWIATA</h1>
            <nav>
                <a href="index.php?idp=">Start</a>
                <a href="index.php?idp=2">Ranking</a>
                <a href="index.php?idp=3">Ciekawostki</a>
                <a href="index.php?idp=4">Galeria</a>
                <a href="index.php?idp=5">Kontakt</a>
                <a href="index.php?idp=6">JS</a>
                <a href="index.php?idp=7">JQ</a>
                <a href="index.php?idp=8">Filmy</a>   
            </nav>
        </header>


        <?php
            echo(PokazPodstrone($strona));
        ?>

        <footer>
            <u>Największe budynki świata wersja 1.5</u>
        </footer>

        <?php
 		$nr_indeksu = '169271';
 		$nrGrupy = 'ISI2';
 		echo 'Autor: Bartosz Kowalski '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
	    ?>

    </body>
</html>