<?php
    session_start(); // Inicjalizacja sesji

    // Konfiguracja bazy danych
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';
    $login = 'login';
    $pass = 'haslo';

    // Nawiązanie połączenia z bazą danych
    $link = mysqli_connect($dbhost,$dbuser,$dbpass);
    if (!$link) echo '<b>przerwane połączenie </b>'; // Komunikat o błędzie połączenia
    if(!mysqli_select_db($link, $baza)) echo 'nie wybrano bazy'; // Komunikat o niewybraniu bazy danych
?>