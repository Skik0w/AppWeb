<?php
include("cfg.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  

// Sprawdzanie, czy parametr 'idp' jest równy '10'
if ($_GET['idp'] == '10') {
    // Wyświetlanie formularza przypomnienia hasła
    echo('<h2 class="heading">Przypomnij haslo:</h2>');
    echo('<form method="post" name="PasswordForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
        <input type="text" name="email" id="email" class="formField" placeholder="Wpisz adres email"> 
        <br>
        <input type="submit" name="password_submit" class="remind-password-button" value="Przypomnij hasło">
    </form>');

    // Obsługa wysłania formularza "Przypomnij hasło"
    if (isset($_POST['password_submit'])) {
        $email = $_POST['email'];
        PrzypomnijHaslo($email);
    }

    // Wyświetlanie formularza kontaktowego
    echo('<h2 class="naglowek-kontaktowy">Formularz kontaktowy:</h2>');
    echo('<form method="post" name="FormularzKontaktowy" enctype="multipart/form-data" action="' . htmlspecialchars($_SERVER['REQUEST_URI']) . '">
        <input type="text" name="temat" id="temat" class="pole-formularza" placeholder="Wpisz temat wiadomości"> 
        <br>
        <input type="email" name="email" id="email" class="pole-formularza" placeholder="Wpisz adres e-mail"> 
        <br>
        <textarea style="width: 100%; height: 150px;" id="tresc" name="tresc" placeholder="Treść wiadomości"></textarea>
        <br>
        <button type="submit" name="contact_submit" class="przycisk-wyslij">Wyślij</button>
    </form>');

    // Obsługa wysłania formularza kontaktowego
    if (isset($_POST['contact_submit'])) {
        $email = $_POST['email'];
        WyslijMailaKontakt($email);
    }
}

// Przetwarza formularz i wysyła wiadomość email.
function WyslijMailaKontakt($odbiorca)
{
    global $email_pass; // Globalna zmienna przechowująca hasło e-mail

    // Sprawdzanie, czy wszystkie pola formularza są wypełnione
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[nie_wypelniles_pola]'; // Komunikat błędu w przypadku brakujących danych
        echo PokazKontakt(); // Ponownie wyświetla formularz z komunikatem
    } else {
        $mail = new PHPMailer(true); // Tworzenie instancji PHPMailer
        try {
            // Konfiguracja serwera SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.wp.pl';  
            $mail->SMTPAuth = true;
            $mail->Username = 'bartek.web@wp.pl'; 
            $mail->Password = $email_pass;  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;  

            // Ustawienia adresata i nadawcy
            $mail->setFrom('bartek.web@wp.pl', 'Formularz kontaktowy');
            $mail->addAddress($odbiorca); // Adres odbiorcy

            // Treść wiadomości
            $mail->isHTML(true); 
            $mail->Subject = htmlspecialchars($_POST['temat']); // Usunięcie znaków specjalnych
            $mail->Body    = htmlspecialchars($_POST['tresc']); // Usunięcie znaków specjalnych
            $mail->AltBody = htmlspecialchars(strip_tags($_POST['tresc'])); // Usunięcie znaków specjalnych

            // Wysyłanie wiadomości
            $mail->send();
            echo '[Wiadomosc Wyslana]'; // Komunikat sukcesu
        } catch (Exception $e) {
            echo "Wiadomość nie mogła zostać wysłana. Błąd: {$mail->ErrorInfo}"; // Komunikat błędu
        }
    }
}

// Przypomina hasło użytkownikowi poprzez email.
function PrzypomnijHaslo($odbiorca)
{
    // Globalne zmienne przechowujące hasło i dane logowania
    global $pass;
    global $email_pass;

    // Sprawdzenie, czy hasło jest ustawione
    if (empty($pass)) {
        echo '[brak_hasla]';  // Wyświetlenie komunikatu o braku hasła
        return; // Zakończenie działania funkcji
    }

    $mail = new PHPMailer(true); // Tworzenie instancji PHPMailer
    try {
        // Konfiguracja serwera SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.wp.pl';  
        $mail->SMTPAuth = true;
        $mail->Username = 'bartek.web@wp.pl'; 
        $mail->Password =  $email_pass;  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = 465; 

        // Ustawienia wiadomości e-mail
        $mail->setFrom('bartek.web@wp.pl', 'Formularz przypomnienia hasła');
        $mail->addAddress($odbiorca);  // Adres odbiorcy

        // Treść wiadomości
        $mail->isHTML(true); 
        $mail->Subject = "Przypomnienie hasła";
        $mail->Body    = "Twoje hasło to: " . $pass;
        $mail->AltBody = "Twoje hasło to: " . $pass; 

        // Wysyłanie wiadomości
        $mail->send();
        echo '[Haslo wyslane]'; // Komunikat sukcesu
    } catch (Exception $e) {
        echo "Wiadomość nie mogła zostać wysłana. Błąd: {$mail->ErrorInfo}"; // Komunikat błędu
    }
}
?>
