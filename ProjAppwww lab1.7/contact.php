<?php
session_start();

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

function WyslijMailKontakt() {
    if (isset($_POST['send_contact'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $admin_email = "admin@example.com";

        $mail_content = "Wiadomość od: $name\nEmail: $email\n\nTreść wiadomości:\n$message";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($admin_email, $subject, $mail_content, $headers)) {
            echo "<p>Twoja wiadomość została wysłana pomyślnie.</p>";
        } else {
            echo "<p>Wystąpił błąd przy wysyłaniu wiadomości. Spróbuj ponownie później.</p>";
        }
    }
}

function PrzypomnijHaslo() {
    if (isset($_POST['remind_password'])) {
        $email = $_POST['email'];

        $admin_email = "admin@example.com";
        $subject = "Przypomnienie hasła";
        $message = "Witaj,\n\nTwoje hasło do panelu admina: 12345\n\nPozdrawiamy, Zespół.";

        $headers = "From: no-reply@example.com\r\n";
        $headers .= "Reply-To: no-reply@example.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo "<p>Twoje hasło zostało wysłane na podany adres email.</p>";
        } else {
            echo "<p>Wystąpił problem z wysłaniem maila. Spróbuj ponownie później.</p>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['send_contact'])) {
        WyslijMailKontakt();
    } elseif (isset($_POST['remind_password'])) {
        PrzypomnijHaslo();
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
