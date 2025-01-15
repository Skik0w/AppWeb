<?php

// Rozpoczęcie sesji dla przechowywania danych koszyka
session_start();
include('db_connect.php');

// Obsługa akcji w koszyku
if (isset($_GET['action'])) {
    $koszyk = new Koszyk();

    // Dodanie produktu do koszyka
    if ($_GET['action'] == 'add' && isset($_GET['id'])) {
        $koszyk->DodajDoKoszyka(intval($_GET['id']));
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    // Usunięcie produktu z koszyka
    } elseif ($_GET['action'] == 'remove' && isset($_GET['id'])) {
        $koszyk->UsunZKoszyka(intval($_GET['id']));
        header('Location: index.php?idp=11&view=koszyk');
        exit;
    // Zmiana ilości produktu w koszyku
    } elseif ($_GET['action'] == 'update' && isset($_GET['id']) && isset($_GET['change'])) {
        $koszyk->ZmienIloscProduktu(intval($_GET['id']), intval($_GET['change']));
        header('Location: index.php?idp=11&view=koszyk');
        exit;
    }
}

// Widok koszyka
if (isset($_GET['view']) && $_GET['view'] == 'koszyk') {
    echo "<div class='koszyk-container'>";
    echo "<h1 class='koszyk-tytul'>Twój Koszyk</h1>";
    $koszyk = new Koszyk();
    $koszyk->PokazKoszyk($link);
    echo "<a href='index.php?idp=11' class='koszyk-powrot'>Powrót do sklepu</a>";
    echo "</div>";
// Widok sklepu (główna strona z kategoriami)
} else {
    echo "<div class='sklep-container'>";
    echo "<h1 class='sklep-tytul'>Sklep internetowy</h1>";
    echo "<div class='sklep-przyciski'>";
    echo "<a href='index.php?idp=11' class='sklep-przycisk-powrotu'>Powrót do głównych kategorii</a>";
    echo "<a href='index.php?idp=11&view=koszyk' class='sklep-przycisk-koszyka'>Przejdź do koszyka</a>";
    echo "</div>";
    $sklep = new Sklep($link);
    $sklep->PokazKategorie();
    echo "</div>";
}

// Klasa obsługująca sklep (kategorie i produkty)
class Sklep {
    private $db;

    // Konstruktor, przypisanie połączenia z bazą danych
    public function __construct($db) {
        $this->db = $db;
    }

    // Wyświetlanie głównych kategorii
    public function PokazKategorie() {
        if (!isset($_GET['kategoria'])) {
            $query = "SELECT * FROM kategorie WHERE matka = 0";
            $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    
            echo '<div class="sklep-kategorie-grid">';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="sklep-kategoria-glowna">
                        <a href="index.php?idp=11&kategoria=' . $row['id'] . '">
                            <h4 class="sklep-kategoria-tytul">' . htmlspecialchars($row['nazwa']) . '</h4>
                        </a>
                      </div>';
            }
            echo '</div>';
        } else {
            $this->PokazPodkategorie($_GET['kategoria']);
        }
    }

    // Wyświetlanie podkategorii
    public function PokazPodkategorie($kategoria_id) {
        $query = "SELECT * FROM kategorie WHERE matka = " . intval($kategoria_id);
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="sklep-kategorie-grid">';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="sklep-kategoria">
                        <a href="index.php?idp=11&kategoria=' . $row['id'] . '">
                            <h4 class="sklep-kategoria-tytul">' . htmlspecialchars($row['nazwa']) . '</h4>
                        </a>
                      </div>';
            }
            echo '</div>';
        } else {
            $this->PokazProduktyWKategoriach($kategoria_id);
        }
    }

    // Wyświetlanie produktów w danej kategorii
    public function PokazProduktyWKategoriach($kategoria_id) {
        $query = "SELECT p.*, k.nazwa AS kategoria FROM produkty p 
                  JOIN kategorie k ON p.kategoria_id = k.id 
                  WHERE p.kategoria_id = " . intval($kategoria_id) . " AND p.status = 'dostępny'";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));

        if (mysqli_num_rows($result) == 0) {
            echo '<p class="sklep-brak-produktow">Brak produktów w tej kategorii.</p>';
            return;
        }

        echo '<div class="sklep-produkty-grid">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="sklep-produkt">
                    <img src="' . htmlspecialchars($row['zdjecie']) . '" alt="' . htmlspecialchars($row['tytul']) . '" class="sklep-produkt-zdjecie">
                    <h4 class="sklep-produkt-tytul">' . htmlspecialchars($row['tytul']) . '</h4>
                    <p class="sklep-produkt-opis">' . htmlspecialchars($row['opis']) . '</p>
                    <p class="sklep-produkt-waga"><strong>Waga:</strong> ' . htmlspecialchars($row['gabaryt']) . '</p>
                    <p class="sklep-produkt-cena">Cena netto: ' . number_format($row['cena_netto'], 2) . ' zł</p>
                    <a href="index.php?idp=11&action=add&id=' . $row['id'] . '" class="sklep-produkt-przycisk">Dodaj do koszyka</a>
                  </div>';
        }
        echo '</div>';
    }
}

// Klasa obsługująca koszyk
class Koszyk {

    // Dodawanie produktu do koszyka
    public function DodajDoKoszyka($id, $ilosc = 1) {
        global $link;
        
        $query = "SELECT ilosc FROM produkty WHERE id = $id";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        $produkt = mysqli_fetch_assoc($result);
    
        if (!$produkt) {
            return;
        }
    
        $iloscWKoszyku = isset($_SESSION['koszyk'][$id]) ? $_SESSION['koszyk'][$id]['ilosc'] : 0;
        if ($iloscWKoszyku + $ilosc > $produkt['ilosc']) {
            return;
        }
    
        if (!isset($_SESSION['koszyk'])) {
            $_SESSION['koszyk'] = [];
        }
    
        if (isset($_SESSION['koszyk'][$id])) {
            $_SESSION['koszyk'][$id]['ilosc'] += $ilosc;
        } else {
            $_SESSION['koszyk'][$id] = ['id' => $id, 'ilosc' => $ilosc];
        }
    }

    // Usuwanie produktu z koszyka
    public function UsunZKoszyka($id) {
        unset($_SESSION['koszyk'][$id]);
    }

    // Zmiana ilości produktu w koszyku
    public function ZmienIloscProduktu($id, $change) {
        global $link;
        
        $query = "SELECT ilosc FROM produkty WHERE id = $id";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        $produkt = mysqli_fetch_assoc($result);
    
        if (!$produkt) {
            return;
        }
    
        if (isset($_SESSION['koszyk'][$id])) {
            $iloscWKoszyku = $_SESSION['koszyk'][$id]['ilosc'] + $change;

            if ($iloscWKoszyku > $produkt['ilosc']) {
                return;
            } elseif ($iloscWKoszyku <= 0) {
                $this->UsunZKoszyka($id);
                return;
            }
            $_SESSION['koszyk'][$id]['ilosc'] = $iloscWKoszyku;
        }
    }

    // Wyświetlanie zawartości koszyka
    public function PokazKoszyk($db) {
        if (empty($_SESSION['koszyk'])) {
            echo "<p class='koszyk-brak-produktow'>Koszyk jest pusty.</p>";
            return;
        }

        $ids = array_keys($_SESSION['koszyk']);
        $query = "SELECT * FROM produkty WHERE id IN (" . implode(',', $ids) . ")";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));

        $suma = 0;
        echo "<table class='koszyk-tabela'>
                <tr><th>Produkt</th><th>Cena netto</th><th>Ilość</th><th>Cena brutto</th><th>Akcje</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $ilosc = $_SESSION['koszyk'][$row['id']]['ilosc'];
            $wartosc_brutto = ($row['cena_netto'] * (1 + $row['vat'] / 100)) * $ilosc;
            $suma += $wartosc_brutto;

            echo "<tr>
                    <td>" . htmlspecialchars($row['tytul']) . "</td>
                    <td>" . number_format($row['cena_netto'], 2) . " zł</td>
                    <td>
                        <a href='index.php?idp=11&action=update&id=" . $row['id'] . "&change=-1' class='koszyk-ilosc-przycisk'>-</a>
                        " . $ilosc . "
                        <a href='index.php?idp=11&action=update&id=" . $row['id'] . "&change=1' class='koszyk-ilosc-przycisk'>+</a>
                    </td>
                    <td>" . number_format($wartosc_brutto, 2) . " zł</td>
                    <td>
                        <a href='index.php?idp=11&action=remove&id=" . $row['id'] . "' class='koszyk-usun-przycisk'>Usuń</a>
                    </td>
                  </tr>";
        }
        echo "</table><p class='koszyk-suma'><strong>Łączna cena brutto: " . number_format($suma, 2) . " zł</strong></p>";
    }
}

?>
