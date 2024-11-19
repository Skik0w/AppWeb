<?php
session_start();
include("cfg.php");
function FormularzLogowania()
{
  if ($_SESSION["is_logged"]==0)
  {
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
    </div>
    ';

    return $wynik;
  }
}

function PrzetwarzanieFormularza()
{
    global $login, $pass;

    if (isset($_POST['x1_submit'])) {
        $log = trim($_POST['login_email'] ?? '');
        $password = trim($_POST['login_pass'] ?? '');

        if ($log === $login && $password === $pass) {
            $_SESSION["is_logged"] = 1;
        } else {
            echo '<p style="color:red;">Niepoprawne dane logowania. Spróbuj ponownie.</p>';
        }
    }
}

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
            UsunPodstrone($key);
        } elseif (str_starts_with($key, 'edit')) {
            echo EdytujPodstrone($key);
        }
    }
}

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

function UsunPodstrone($key)
{
    global $link;

    $page_id = preg_replace('/\D/', '', $key);
    $query = "DELETE FROM `page_list` WHERE `id` = $page_id";
    mysqli_query($link, $query);
}

?>