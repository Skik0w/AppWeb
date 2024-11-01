<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

    if($_GET['idp'] == '') $strona = 'html/glowna.html';
    if($_GET['idp'] == '2') $strona = 'html/ranking.html';
    if($_GET['idp'] == '3') $strona = 'html/ciekawostki.html';
    if($_GET['idp'] == '4') $strona = 'html/galeria.html';
    if($_GET['idp'] == '5') $strona = 'html/kontakt.html';
    if($_GET['idp'] == '6') $strona = 'html/js.html';
    if($_GET['idp'] == '7') $strona = 'html/jq.html';
    if($_GET['idp'] == '8') $strona = 'html/filmy.html';
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
            if (file_exists($strona) == false) {
                echo "The file $strona does not exist";
            }

            include($strona);
        ?>

        <footer>
            <u>Największe budynki świata wersja 1.4</u>
        </footer>

        <?php
 		$nr_indeksu = '169271';
 		$nrGrupy = 'ISI2';
 		echo 'Autor: Bartosz Kowalski '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
	    ?>

    </body>
</html>