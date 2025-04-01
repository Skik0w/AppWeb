<?php
// Inicjalizacja sesji
session_start();

// Dołączenie pliku konfiguracyjnego
include('cfg.php');

// Funkcja pobiera zawartość podstrony z bazy danych na podstawie jej ID.
function PokazPodstrone($id)
{
    global $link;

    // Sprawdzenie, czy ID jest null
    if ($id == null) {
        return "Nie znaleziono strony";
    } else {
        // Oczyszczanie danych wejściowych
        $id_clear = htmlspecialchars($id);

        // Przygotowanie zapytania SQL
        $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
        $result = mysqli_query($link, $query);

        // Pobranie wyniku zapytania
        $row = mysqli_fetch_array($result);

        // Sprawdzenie, czy strona istnieje
        if (empty($row['id'])) {
            $web = '[nie_znaleziono_strony]'; // Komunikat, gdy strona nie istnieje
        } else {
            $web = $row['page_content']; // Pobranie treści podstrony
        }

        return $web;
    }
}
?>
