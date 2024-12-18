<?php

// Inicjalizacja sesji
session_start();

// Dołączenie pliku konfiguracyjnego
include("cfg.php");

// Dołączenie pliku z klasą kategorii
include("kategorie.php");

// Dołącznie pliku z klasą produktów
include("produkty.php");

// Sprawdzenie, czy użytkownik jest na stronie panelu administracyjnego
if ($_GET['idp'] == '9') {
    echo '<div class="admin-panel">';

    // Sprawdzenie, czy użytkownik jest zalogowany
    if ($_SESSION["is_logged"] == 0) {
        // Przetwarzanie formularza logowania
        PrzetwarzanieFormularza();

        // Wyświetlenie formularza logowania, jeśli użytkownik nie jest zalogowany
        if ($_SESSION["is_logged"] == 0) {
            echo FormularzLogowania();
        }
    }

    // Jeżeli użytkownik jest zalogowany
    if ($_SESSION["is_logged"] == 1) {
        // Wyświetlenie opcji w panelu administracyjnym, jeśli nie wybrano konkretnej akcji
        if (!isset($_GET['action'])) {
            echo '
            <h1>Panel CMS</h1>
            <br>
            <div class="admin-options">
                <a href="index.php?idp=9&action=pages">Zarządzaj podstronami</a>
                <br><br>
                <a href="index.php?idp=9&action=categories">Zarządzaj kategoriami</a>
                <br><br>
                <a href="index.php?idp=9&action=products">Zarządzaj produktami</a>
            </div>';
        }

        // Sekcja zarządzania kategoriami
        if ($_GET['action'] == 'categories') {
            echo '
            <h1>Zarządzaj kategoriami</h1>
            <br>
            <div class="topnav">
                <a href="index.php?idp=9&action=categories&subcategory=list">Lista kategorii</a>
                <br><br>
                <a href="index.php?idp=9&action=categories&subcategory=add">Dodaj kategorię</a>
                <br><br>
            </div>';

            // Inicjalizacja obiektu do zarządzania kategoriami
            $kategorieManager = new ZarzadzajKategoriami($link);

            // Przetwarzanie formularzy zarządzania kategoriami
            $kategorieManager->PrzetwarzajFormularze();

            // Obsługa podkategorii
            if ($_GET['subcategory'] == 'list') {
                $kategorieManager->PokazKategorie();
            } elseif ($_GET['subcategory'] == 'add') {
                $kategorieManager->FormDodajKategorie();
            } elseif ($_GET['subcategory'] == 'edit' && isset($_GET['id'])) {
                $kategorieManager->FormEdytujKategorie();
            } elseif ($_GET['subcategory'] == 'delete' && isset($_GET['id'])) {
                $kategorieManager->UsunKategorie(intval($_GET['id']));
                echo '<p style="color:green;">Kategoria została usunięta.</p>';
                echo '<a href="index.php?idp=9&action=categories&subcategory=list">Powrót do listy kategorii</a>';
            }
        }

        // Sekcja zarządzania produktami
        if ($_GET['action'] == 'products') {
            echo '
            <h1>Zarządzaj produktami</h1>
            <br>
            <div class="topnav">
                <a href="index.php?idp=9&action=products&subcategory=list">Lista produktów</a>
                <br><br>
                <a href="index.php?idp=9&action=products&subcategory=add">Dodaj produkt</a>
                <br><br>
            </div>';
        
            // Inicjalizacja obiektu do zarządzania produktami
            $produktyManager = new ZarzadzajProduktami($link);
        
            // Przetwarzanie formularzy zarządzania produktami
            $produktyManager->PrzetwarzajFormularze();
        
            // Obsługa podkategorii
            if ($_GET['subcategory'] == 'list') {
                $produktyManager->PokazProdukty();
            } elseif ($_GET['subcategory'] == 'add') {
                $produktyManager->FormDodajProdukt();
            } elseif ($_GET['subcategory'] == 'edit' && isset($_GET['id'])) {
                $produktyManager->FormEdytujProdukt();
            } elseif ($_GET['subcategory'] == 'delete' && isset($_GET['id'])) {
                $produktyManager->UsunProdukt(intval($_GET['id']));
                echo '<p style="color:green;">Produkt został usunięty.</p>';
                echo '<a href="index.php?idp=9&action=products&subcategory=list">Powrót do listy produktów</a>';
            }
        }

        // Sekcja zarządzania podstronami
        if ($_GET['action'] == 'pages') {
            echo '
            <h1>Zarządzaj podstronami</h1>
            <br>
            <div class="topnav">
                <a href="index.php?idp=9&action=pages&subcategory=list">Lista podstron</a>
                <br><br>
                <a href="index.php?idp=9&action=pages&subcategory=add">Dodaj nową podstronę</a>
                <br><br>
            </div>';

            // Wyświetlenie listy podstron
            if ($_GET['subcategory'] == 'list') {
                ListaPodstron();
            }

            // Formularz dodawania nowej podstrony
            elseif ($_GET['subcategory'] == 'add') {
                echo DodajNowaPodstrone();
            }

            // Przetwarzanie edycji i dodawania podstron
            PrzetwarzajEdycje();
            PrzetwarzajDodanie();
        }
        
    }
}

// Funkcja wyświetla formularz logowania, jeśli użytkownik nie jest zalogowany.
function FormularzLogowania()
{
    if ($_SESSION["is_logged"] == 0) {
        $wynik = '
        <div class="logowanie">
            <h2 class="heading">Panel CMS:</h2>
            <div class="logowanie">
                <form method="post" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URL'].'">
                    <table class="logowanie">
                        <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
                        <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie" /></td></tr>
                        <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="Zaloguj" /></td></tr>
                    </table>
                </form>
            </div>
        </div>';
        return $wynik;
    }
}

// Funkcja obsługuje dane przesłane w formularzu logowania i weryfikuje dane użytkownika.
function PrzetwarzanieFormularza()
{
    global $login, $pass;

    if (isset($_POST['x1_submit'])) {
        $log = trim($_POST['login_email'] ?? '');
        $password = trim($_POST['login_pass'] ?? '');

        if ($log === $login && $password === $pass) {
            $_SESSION["is_logged"] = 1; // Ustawienie sesji jako zalogowanej
        } else {
            echo '<p style="color:red;">Niepoprawne dane logowania. Spróbuj ponownie.</p>';
        }
    }
}

// Funkcja wyświetla listę podstron z opcjami edycji i usuwania.
function ListaPodstron()
{
    global $link;

    $query = "SELECT * FROM page_list ORDER BY id LIMIT 100";
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "{$row['id']} {$row['page_title']}
        <form method='post'>
            <input type='submit' name='delete{$row['id']}' value='Usuń'/>
            <input type='submit' name='edit{$row['id']}' value='Edytuj'/>
        </form>";
    }

    foreach ($_POST as $key => $value) {
        if (str_starts_with($key, 'delete')) {
            UsunPodstrone($key); // Obsługa usuwania podstron
        } elseif (str_starts_with($key, 'edit')) {
            echo EdytujPodstrone($key); // Wyświetlenie formularza edycji
        }
    }
}

// Funkcja wyświetla formularz do edycji wybranej podstrony.
function EdytujPodstrone($key)
{
    $page_id = preg_replace('/\D/', '', $key);

    return "
    <div class='edytowanie'>
        <form method='post' action='{$_SERVER['REQUEST_URI']}'>
            <input type='text' name='title' placeholder='Tytuł'>
            <br>
            <textarea style='width: 1200px; height: 200px' name='content' placeholder='Treść strony'></textarea>
            <br>
            Czy aktywna? <input type='checkbox' name='check'>
            <br>
            <input type='hidden' name='page_id' value='$page_id'/>
            <input type='submit' name='edit_submit' value='Wyślij'/>
        </form>
    </div>";
}

// Funkcja aktualizuje dane podstrony na podstawie przesłanych danych z formularza edycji.
function PrzetwarzajEdycje()
{
    if (isset($_POST['edit_submit'])) {
        global $link;

        $title = $_POST['title'];
        $content = $_POST['content'];
        $status = isset($_POST['check']) ? 1 : 0;
        $page_id = $_POST['page_id'];

        $query = "UPDATE `page_list` SET `page_title` = '$title', `page_content` = '$content', `status` = $status WHERE `id` = $page_id";
        mysqli_query($link, $query);
    }
}

// Funkcja wyświetla formularz do dodania nowej podstrony.
function DodajNowaPodstrone()
{
    return "
    <div class='dodawanie'>
        <form method='post' action='{$_SERVER['REQUEST_URI']}'>
            <input type='text' name='title' placeholder='Tytuł'>
            <br>
            <textarea style='width: 1200px; height: 200px' name='content' placeholder='Treść strony'></textarea>
            <br>
            Czy aktywna? <input type='checkbox' name='check'>
            <br>
            <input type='text' name='alias' placeholder='Alias'>
            <br>
            <input type='submit' name='add_submit' value='Wyślij'/>
        </form>
    </div>";
}

// Funkcja dodaje nową podstronę do bazy danych na podstawie danych z formularza.
function PrzetwarzajDodanie()
{
    if (isset($_POST['add_submit'])) {
        global $link;

        $title = $_POST['title'];
        $content = $_POST['content'];
        $status = isset($_POST['check']) ? 1 : 0;
        $alias = $_POST['alias'];

        $query = "INSERT INTO `page_list` (`page_title`, `page_content`, `status`, `alias`) VALUES ('$title', '$content', $status, '$alias')";
        mysqli_query($link, $query);
    }
}

// Funkcja usuwa podstronę z bazy danych na podstawie jej ID.
function UsunPodstrone($key)
{
    global $link;

    $page_id = preg_replace('/\D/', '', $key);
    $query = "DELETE FROM `page_list` WHERE `id` = $page_id";
    mysqli_query($link, $query);
}
?>
