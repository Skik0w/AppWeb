<?php

class ZarzadzajProduktami {
    private $db;

    // Konstruktor przyjmuje obiekt bazy danych
    public function __construct($db) {
        $this->db = $db;
    }

    // Funkcja dodaje nowy produkt
    public function DodajProdukt($tytul, $opis, $data_utworzenia, $data_modyfikacji, $data_wygasniecia, $cena_netto, $vat, $ilosc, $kategoria_id, $gabaryt, $zdjecie) {
        if (!$this->CzyKategoriaKoncowa($kategoria_id)) {
            die('Nie można dodać produktu do kategorii nadrzędnej. Wybierz kategorię końcową.');
        }

        $status = $this->ObliczStatus($ilosc, $data_wygasniecia);
        $query = "INSERT INTO produkty (tytul, opis, data_utworzenia, data_modyfikacji, data_wygasniecia, cena_netto, vat, ilosc, status, kategoria_id, gabaryt, zdjecie) 
                  VALUES ('$tytul', '$opis', '$data_utworzenia', '$data_modyfikacji', '$data_wygasniecia', $cena_netto, $vat, $ilosc, '$status', $kategoria_id, '$gabaryt', '$zdjecie')";
        mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }

    // Funkcja edytuje dane produktu
    public function EdytujProdukt($id, $dane) {
        if (!$this->CzyKategoriaKoncowa($dane['kategoria_id'])) {
            die('Nie można przypisać produktu do kategorii nadrzędnej. Wybierz kategorię końcową.');
        }

        $dane['status'] = $this->ObliczStatus($dane['ilosc'], $dane['data_wygasniecia']);
        $set = [];
        foreach ($dane as $klucz => $wartosc) {
            $set[] = "$klucz = '$wartosc'";
        }
        $query = "UPDATE produkty SET " . implode(", ", $set) . " WHERE id = $id";
        mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }

    // Funkcja usuwa produkt z bazy danych na podstawie jego ID
    public function UsunProdukt($id) {
        $query = "DELETE FROM produkty WHERE id = $id";
        mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }


    // Funkcja obliczająca status produktu
    private function ObliczStatus($ilosc, $data_wygasniecia) {
        $dzisiaj = date('Y-m-d');
    
        if ($ilosc > 0 && $data_wygasniecia >= $dzisiaj) {
            return 'dostępny';
        }
    
            return 'niedostępny';
        }

            // Funkcja sprawdzająca, czy kategoria jest końcowa
    private function CzyKategoriaKoncowa($kategoria_id) {
        $query = "SELECT COUNT(*) AS liczba_podkategorii FROM kategorie WHERE matka = $kategoria_id";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
        $row = mysqli_fetch_assoc($result);

        return $row['liczba_podkategorii'] == 0;
    }
    
        // Funkcja sprawdzająca dostępność produktu
        public function SprawdzDostepnosc($produkt) {
            return $produkt['status'] === 'dostępny';
        }

    // Funkcja wyświetla produkty w tabeli HTML
    public function PokazProdukty() {
        $query = "SELECT p.*, k.nazwa AS kategoria FROM produkty p LEFT JOIN kategorie k ON p.kategoria_id = k.id";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));

        echo '<h3>Lista produktów</h3>
            <table border="1">
                <tr>
                    <th>ID</th><th>Tytuł</th><th>Opis</th><th>Data utworzenia</th><th>Data modyfikacji</th><th>Data wygaśnięcia</th><th>Cena</th><th>Ilość</th><th>Kategoria</th><th>Status</th><th>Zdjęcie</th><th>Akcje</th>
                </tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>" . htmlspecialchars($row['tytul']) . "</td>
                <td>" . htmlspecialchars($row['opis']) . "</td>
                <td>{$row['data_utworzenia']}</td>
                <td>{$row['data_modyfikacji']}</td>
                <td>{$row['data_wygasniecia']}</td>
                <td>{$row['cena_netto']}</td>
                <td>{$row['ilosc']}</td>
                <td>" . htmlspecialchars($row['kategoria']) . "</td>
                <td>" . htmlspecialchars($row['status']) . "</td>
                <td><a href='" . htmlspecialchars($row['zdjecie']) . "' target='_blank'>Zobacz zdjęcie</a></td>
                <td>
                    <a href=\"index.php?idp=9&action=products&subcategory=edit&id={$row['id']}\">Edytuj</a> | 
                    <a href=\"index.php?idp=9&action=products&subcategory=delete&id={$row['id']}\">Usuń</a>
                </td>
            </tr>";
        }
        echo '</table>';
    }

    // Formularz do dodawania produktu
    public function FormDodajProdukt() {
        $query = "SELECT id, nazwa FROM kategorie WHERE id NOT IN (SELECT matka FROM kategorie WHERE matka IS NOT NULL)";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    
        echo '<h3>Dodaj produkt</h3>
            <form method="post">
                <label for="tytul">Tytuł:</label><br>
                <input type="text" id="tytul" name="tytul" placeholder="Tytuł" required><br><br>
                
                <label for="opis">Opis:</label><br>
                <textarea id="opis" name="opis" placeholder="Opis" required></textarea><br><br>
                
                <label for="data_utworzenia">Data utworzenia:</label><br>
                <input type="date" id="data_utworzenia" name="data_utworzenia" required><br><br>
                
                <label for="data_modyfikacji">Data modyfikacji:</label><br>
                <input type="date" id="data_modyfikacji" name="data_modyfikacji" required><br><br>
                
                <label for="data_wygasniecia">Data wygaśnięcia:</label><br>
                <input type="date" id="data_wygasniecia" name="data_wygasniecia" required><br><br>
                
                <label for="cena_netto">Cena netto:</label><br>
                <input type="number" id="cena_netto" name="cena_netto" step="0.01" placeholder="Cena netto" required><br><br>
                
                <label for="vat">VAT:</label><br>
                <input type="number" id="vat" name="vat" placeholder="VAT" required><br><br>
                
                <label for="ilosc">Ilość:</label><br>
                <input type="number" id="ilosc" name="ilosc" placeholder="Ilość" required><br><br>
                
                <label for="kategoria_id">Kategoria:</label><br>
                <select id="kategoria_id" name="kategoria_id" required>
                    <option value="">Wybierz kategorię</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nazwa']) . '</option>';
        }
        echo '</select><br><br>
                
                <label for="gabaryt">Gabaryt:</label><br>
                <input type="text" id="gabaryt" name="gabaryt" placeholder="Gabaryt" required><br><br>
                
                <label for="zdjecie">Link do zdjęcia:</label><br>
                <input type="text" id="zdjecie" name="zdjecie" placeholder="Link do zdjęcia" required><br><br>
                
                <button type="submit" name="dodaj">Dodaj produkt</button>
            </form>';
    }
    

// Formularz do edycji produktu
public function FormEdytujProdukt() {
    if (!isset($_GET['id'])) {
        echo '<p style="color:red;">Brak ID produktu do edycji.</p>';
        return;
    }

    $id = intval($_GET['id']);
    $query = "SELECT * FROM produkty WHERE id = $id";
    $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));

    if ($row = mysqli_fetch_assoc($result)) {
        echo '<h3>Edytuj produkt</h3>
            <form method="post">
                <label for="tytul">Tytuł:</label><br>
                <input type="text" id="tytul" name="tytul" value="' . htmlspecialchars($row['tytul']) . '" required><br><br>
                
                <label for="opis">Opis:</label><br>
                <textarea id="opis" name="opis" required>' . htmlspecialchars($row['opis']) . '</textarea><br><br>
                
                <label for="data_utworzenia">Data utworzenia:</label><br>
                <input type="date" id="data_utworzenia" name="data_utworzenia" value="' . $row['data_utworzenia'] . '" required><br><br>
                
                <label for="data_modyfikacji">Data modyfikacji:</label><br>
                <input type="date" id="data_modyfikacji" name="data_modyfikacji" value="' . $row['data_modyfikacji'] . '" required><br><br>
                
                <label for="data_wygasniecia">Data wygaśnięcia:</label><br>
                <input type="date" id="data_wygasniecia" name="data_wygasniecia" value="' . $row['data_wygasniecia'] . '" required><br><br>
                
                <label for="cena_netto">Cena netto:</label><br>
                <input type="number" id="cena_netto" name="cena_netto" value="' . $row['cena_netto'] . '" step="0.01" required><br><br>
                
                <label for="vat">VAT:</label><br>
                <input type="number" id="vat" name="vat" value="' . $row['vat'] . '" required><br><br>
                
                <label for="ilosc">Ilość:</label><br>
                <input type="number" id="ilosc" name="ilosc" value="' . $row['ilosc'] . '" required><br><br>
                
                <label for="kategoria_id">Kategoria:</label><br>
                <select id="kategoria_id" name="kategoria_id" required>';
        $kategorieQuery = "SELECT id, nazwa FROM kategorie WHERE id NOT IN (SELECT matka FROM kategorie WHERE matka IS NOT NULL)";
        $kategorieResult = mysqli_query($this->db, $kategorieQuery) or die(mysqli_error($this->db));
        while ($kategoria = mysqli_fetch_assoc($kategorieResult)) {
            $selected = $kategoria['id'] == $row['kategoria_id'] ? 'selected' : '';
            echo '<option value="' . $kategoria['id'] . '" ' . $selected . '>' . htmlspecialchars($kategoria['nazwa']) . '</option>';
        }
        echo '</select><br><br>
                
                <label for="gabaryt">Gabaryt:</label><br>
                <input type="text" id="gabaryt" name="gabaryt" value="' . htmlspecialchars($row['gabaryt']) . '" required><br><br>
                
                <label for="zdjecie">Link do zdjęcia:</label><br>
                <input type="text" id="zdjecie" name="zdjecie" value="' . htmlspecialchars($row['zdjecie']) . '" required><br><br>
                
                <button type="submit" name="edytuj">Zapisz zmiany</button>
            </form>';
    } else {
        echo '<p style="color:red;">Nie znaleziono produktu o ID: ' . $id . '</p>';
    }
}

    // Przetwarzanie danych z formularzy
    public function PrzetwarzajFormularze() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['dodaj'])) {
                $this->DodajProdukt(
                    $_POST['tytul'],
                    $_POST['opis'],
                    $_POST['data_utworzenia'],
                    $_POST['data_modyfikacji'],
                    $_POST['data_wygasniecia'],
                    $_POST['cena_netto'],
                    $_POST['vat'],
                    $_POST['ilosc'],
                    $_POST['kategoria_id'],
                    $_POST['gabaryt'],
                    $_POST['zdjecie']
                );
                echo '<p style="color:green;">Produkt został dodany.</p>';
            }

            if (isset($_POST['edytuj'])) {
                $id = intval($_GET['id']);
                $this->EdytujProdukt($id, [
                    'tytul' => $_POST['tytul'],
                    'opis' => $_POST['opis'],
                    'data_modyfikacji' => $_POST['data_modyfikacji'],
                    'cena_netto' => $_POST['cena_netto'],
                    'vat' => $_POST['vat'],
                    'ilosc' => $_POST['ilosc'],
                    'kategoria_id' => $_POST['kategoria_id'],
                    'gabaryt' => $_POST['gabaryt'],
                    'zdjecie' => $_POST['zdjecie'],
                    'data_wygasniecia' => $_POST['data_wygasniecia']
                ]);
                echo '<p style="color:green;">Produkt został zaktualizowany.</p>';
            }
        }
    }
}
?>
