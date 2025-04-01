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
        while ($row = mysqli_fetch_assoc($result)) {
            $this->UsunKategorie($row['id']);
        }
        $query = "DELETE FROM kategorie WHERE id = $id";
        mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }

    // Funkcja edytuje dane istniejącej kategorii
    public function EdytujKategorie($id, $dane) {
        $set = [];
        foreach ($dane as $klucz => $wartosc) {
            $set[] = "$klucz = '$wartosc'";
        }
        $query = "UPDATE kategorie SET " . implode(", ", $set) . " WHERE id = $id";
        mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }

    // Funkcja wyświetla kategorie w tabeli HTML
    public function PokazKategorie() {
        $query = "SELECT k1.*, k2.nazwa AS nadrzędna_kategoria 
                  FROM kategorie k1 
                  LEFT JOIN kategorie k2 ON k1.matka = k2.id";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));

        echo '<h3>Lista kategorii</h3>
            <table border="1">
                <tr>
                    <th>ID</th><th>Nazwa</th><th>Nadrzędna kategoria</th><th>Akcje</th>
                </tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>" . htmlspecialchars($row['nazwa']) . "</td>
                <td>" . htmlspecialchars($row['nadrzędna_kategoria'] ?? 'Brak') . "</td>
                <td>
                    <a href=\"index.php?idp=9&action=categories&subcategory=edit&id={$row['id']}\">Edytuj</a> | 
                    <a href=\"index.php?idp=9&action=categories&subcategory=delete&id={$row['id']}\">Usuń</a>
                </td>
            </tr>";
        }
        echo '</table>';
    }

    // Formularz do dodawania kategorii
    public function FormDodajKategorie() {
        $query = "SELECT id, nazwa FROM kategorie";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));

        echo '<h3>Dodaj kategorię</h3>
            <form method="post">
                <label for="nazwa">Nazwa kategorii:</label><br>
                <input type="text" id="nazwa" name="nazwa" placeholder="Nazwa kategorii" required><br><br>
                
                <label for="matka">Nadrzędna kategoria:</label><br>
                <select id="matka" name="matka">
                    <option value="0">Brak</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nazwa']) . '</option>';
        }
        echo '</select><br><br>
                
                <button type="submit" name="dodaj">Dodaj kategorię</button>
            </form>';
    }

    // Formularz do edycji kategorii
    public function FormEdytujKategorie() {
        if (!isset($_GET['id'])) {
            echo '<p style="color:red;">Brak ID kategorii do edycji.</p>';
            return;
        }

        $id = intval($_GET['id']);
        $query = "SELECT * FROM kategorie WHERE id = $id";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));

        if ($row = mysqli_fetch_assoc($result)) {
            echo '<h3>Edytuj kategorię</h3>
                <form method="post">
                    <label for="nazwa">Nazwa kategorii:</label><br>
                    <input type="text" id="nazwa" name="nazwa" value="' . htmlspecialchars($row['nazwa']) . '" required><br><br>
                    
                    <label for="matka">Nadrzędna kategoria:</label><br>
                    <select id="matka" name="matka">
                        <option value="0">Brak</option>';
            $kategorieQuery = "SELECT id, nazwa FROM kategorie";
            $kategorieResult = mysqli_query($this->db, $kategorieQuery) or die(mysqli_error($this->db));
            while ($kategoria = mysqli_fetch_assoc($kategorieResult)) {
                $selected = $kategoria['id'] == $row['matka'] ? 'selected' : '';
                echo '<option value="' . $kategoria['id'] . '" ' . $selected . '>' . htmlspecialchars($kategoria['nazwa']) . '</option>';
            }
            echo '</select><br><br>
                    
                    <button type="submit" name="edytuj">Zapisz zmiany</button>
                </form>';
        } else {
            echo '<p style="color:red;">Nie znaleziono kategorii o ID: ' . $id . '</p>';
        }
    }

    // Przetwarzanie danych z formularzy
    public function PrzetwarzajFormularze() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['dodaj'])) {
                $this->DodajKategorie($_POST['nazwa'], $_POST['matka']);
                echo '<p style="color:green;">Kategoria została dodana.</p>';
            }

            if (isset($_POST['edytuj'])) {
                $id = intval($_GET['id']);
                $this->EdytujKategorie($id, [
                    'nazwa' => $_POST['nazwa'],
                    'matka' => $_POST['matka']
                ]);
                echo '<p style="color:green;">Kategoria została zaktualizowana.</p>';
            }
        }
    }
}

?>

