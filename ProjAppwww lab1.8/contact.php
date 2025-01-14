<?php

// Funkcja ta generuje formularz kontaktowy
// w celu wysłania wiadomości do administratora strony.

function PokazKontakt() {
    echo '
    <h2>Formularz Kontaktowy</h2>
    <form method="post" action="contact.php">
        <label>Imię i nazwisko: <input type="text" name="name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Temat: <input type="text" name="subject" required></label><br>
        <label>Treść wiadomości: <textarea name="message" required></textarea></label><br>
        <input type="submit" name="send_contact" value="Wyślij">
    </form>
    ';
}


// Ta funkcja obsługuje wysyłanie wiadomości kontaktowej do administratora.

function WyslijMailKontakt() {
    if (isset($_POST['send_contact'])) {
        // Pobranie danych z formularza kontaktowego
        $name    = $_POST['name'];       // Imię i nazwisko użytkownika
        $email   = $_POST['email'];      // Email użytkownika
        $subject = $_POST['subject'];    // Temat wiadomości
        $message = $_POST['message'];    // Treść wiadomości

        // Definicja adresu email do wysyłania wiadomości
        $admin_email = "admin@example.com"; // Adres e-mail administratora

        // Treść wiadomości do administratora
        $mail_content = "Wiadomość od: $name\nEmail: $email\n\nTreść wiadomości:\n$message";

        // Nagłówki wiadomości e-mail
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Próba wysyłania wiadomości e-mail
        if (mail($admin_email, $subject, $mail_content, $headers)) {
            echo "<p>Twoja wiadomość została wysłana pomyślnie.</p>";
        } else {
            echo "<p>Wystąpił błąd przy wysyłaniu wiadomości. Spróbuj ponownie później.</p>";
        }
    }
}

// Funkcja ta umożliwia użytkownikowi przypomnienie hasła do panelu admina,
function PrzypomnijHaslo() {
    if (isset($_POST['remind_password'])) {
        // Pobranie adresu e-mail użytkownika
        $email = $_POST['email'];

        // Prosta metoda przypomnienia hasła
        $admin_email = "admin@example.com"; // Adres e-mail administratora
        $subject = "Przypomnienie hasła";
        $message = "Witaj,\n\nTwoje hasło do panelu admina: kopytko\n\nPozdrawiamy, Zespół.";

        // Nagłówki wiadomości e-mail
        $headers = "From: no-reply@example.com\r\n";
        $headers .= "Reply-To: no-reply@example.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Próba wysyłania wiadomości e-mail z przypomnieniem hasła
        if (mail($email, $subject, $message, $headers)) {
            echo "<p>Twoje hasło zostało wysłane na podany adres email.</p>";
        } else {
            echo "<p>Wystąpił problem z wysłaniem maila. Spróbuj ponownie później.</p>";
        }
    }
}

// Sprawdzamy, czy formularz został wysłany i odpowiednio wywołujemy funkcje
// do wysyłania maila lub przypomnienia hasła.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['send_contact'])) {
        WyslijMailKontakt(); // Jeśli formularz kontaktowy został wysłany, wyślij maila
    } elseif (isset($_POST['remind_password'])) {
        PrzypomnijHaslo(); // Jeśli formularz przypomnienia hasła został wysłany, wyślij przypomnienie
    }
} else {
    PokazKontakt();
    echo '
    <h2>Przypomnienie hasła</h2>
    <form method="post" action="contact.php">
        <label>Podaj swój email: <input type="email" name="email" required></label><br>
        <input type="submit" name="remind_password" value="Przypomnij hasło">
    </form>
    ';
}
?>
