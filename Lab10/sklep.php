<?php

class ZarzadzajKategoriami {
    private $db;

    // Konstruktor przyjmuje obiekt bazy danych
    public function __construct($db) {
        $this->db = $db;
    }

    // Funkcja dodaje nową kategorię
    public function DodajKategorie($nazwa, $matka = 0) {
        $query = "INSERT INTO kategorie (nazwa, matka) VALUES ('$nazwa', $matka)";
        mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }

    // Funkcja usuwa kategorię, rekurencyjnie usuwając także jej podkategorie
    public function UsunKategorie($id) {
        $query = "SELECT id FROM kategorie WHERE matka = $id";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
        // Rekurencja: usuwamy wszystkie podkategorie
        while ($row = mysqli_fetch_assoc($result)) {
            $this->UsunKategorie($row['id']);
        }
        // Usuwamy kategorię z bazy
        $query = "DELETE FROM kategorie WHERE id = $id";
        mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }

    // Funkcja edytuje dane istniejącej kategorii
    public function EdytujKategorie($id, $nazwa, $matka) {
        $query = "UPDATE kategorie SET nazwa = '$nazwa', matka = $matka WHERE id = $id";
        mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }

    // Funkcja wyświetla hierarchię kategorii w formie listy HTML
    public function PokazKategorie($matka = 0, $poziom = 0) {
        $query = "SELECT * FROM kategorie WHERE matka = $matka";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            // Iteracja przez kategorie
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>" . str_repeat('', $poziom) . htmlspecialchars($row['nazwa']) . "</li>";
                // Rekurencyjne wywołanie dla podkategorii
                $this->PokazKategorie($row['id'], $poziom + 1);
            }
            echo "</ul>";
        }
    }

    // Formularz do dodawania nowej kategorii
    public function FormDodajKategorie() {
        $query = "SELECT id, nazwa FROM kategorie";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
        
        echo '
        <h3>Dodaj kategorię</h3>
        <form method="post">
            <input type="text" name="nazwa" placeholder="Nazwa kategorii" required>
            <select name="matka">
                <option value="0">Główna kategoria</option>';
        // Iteracja przez istniejące kategorie
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nazwa']) . '</option>';
        }
        echo '</select>
            <button type="submit" name="dodaj">Dodaj kategorię</button>
        </form>';
    }

    // Formularz do usuwania kategorii
    public function FormUsunKategorie() {
        echo '
        <h3>Usuń kategorię</h3>
        <form method="post">
            <input type="number" name="id" placeholder="ID kategorii do usunięcia" required>
            <button type="submit" name="usun">Usuń kategorię</button>
        </form>';
    }

    // Formularz do edytowania kategorii
    public function FormEdytujKategorie() {
        $query = "SELECT id, nazwa FROM kategorie";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    
        echo '
        <h3>Edytuj kategorię</h3>
        <form method="post">
            <input type="number" name="id" placeholder="ID kategorii do edycji" required>
            <input type="text" name="nazwa" placeholder="Nowa nazwa kategorii" required>
            <select name="matka">
                <option value="0">Główna kategoria</option>';
        // Iteracja przez istniejące kategorie
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nazwa']) . '</option>';
        }
        echo '</select>
            <button type="submit" name="edytuj">Edytuj kategorię</button>
        </form>';
    }

    // Przetwarzanie danych z formularzy
    public function PrzetwarzajFormularze() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['dodaj'])) {
                // Dodanie nowej kategorii
                $this->DodajKategorie($_POST['nazwa'], $_POST['matka']);
            } elseif (isset($_POST['usun'])) {
                // Usunięcie kategorii
                $this->UsunKategorie($_POST['id']);
            } elseif (isset($_POST['edytuj'])) {
                // Edycja istniejącej kategorii
                $this->EdytujKategorie($_POST['id'], $_POST['nazwa'], $_POST['matka']);
            }
        
            // Przekierowanie po zakończeniu operacji
            header("Location: $redirectUrl");
            exit;
        }
    }
}
?>

