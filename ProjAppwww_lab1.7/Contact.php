<?php
session_start();
require_once 'includes/cfg.php';

function PokazKontakt() {
    $form = '
    <div class="contact-section">
        <div class="contact-form">
            <h2>Kontakt</h2>
            <form method="POST" action="contact.php?action=send">
                <div class="form-group">
                    <label for="nadawca">Email:</label>
                    <input type="email" id="nadawca" name="nadawca" required>
                </div>

                <div class="form-group">
                    <label for="temat">Temat:</label>
                    <input type="text" id="temat" name="temat" required>
                </div>

                <div class="form-group">
                    <label for="tresc">Wiadomo��:</label>
                    <textarea id="tresc" name="tresc" rows="5" required></textarea>
                </div>

                <button type="submit" name="wyslij_mail">Wy�lij wiadomo��</button>
            </form>
        </div>
    </div>';

    return $form;
}

function WyslijMailKontakt($odbiorca) {
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['nadawca'])) {
        echo '[nie_wypelniles_pola]';
        echo PokazKontakt();
        return;
    }

    $mail['subject'] = $_POST['temat'];
    $mail['body'] = $_POST['tresc'];
    $mail['sender'] = $_POST['nadawca'];
    $mail['recipient'] = $odbiorca;

    $header = "From: Formularz kontaktowy <".$mail['sender'].">\r\n";
    $header .= "MIME-Version: 1.0\r\nContent-Type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: 8bit\r\n";
    $header .= "X-Sender: <".$mail['sender'].">\r\n";
    $header .= "X-Mailer: PRapWWW mail 1.2\r\n";
    $header .= "X-Priority: 3\r\n";
    $header .= "Return-Path: <".$mail['sender'].">\r\n";

    if(mail($mail['recipient'], $mail['subject'], $mail['body'], $header)) {
        echo '[wiadomosc_wyslana]';
    } else {
        echo '[blad_wysylania]';
    }
}

function PrzypomnijHaslo() {
    if (isset($_POST['przypomnij'])) {
        if ($_POST['login'] === ADMIN_LOGIN) {
            $tempPass = substr(md5(rand()), 0, 8);

            $odbiorca = "asd@asd.asd";
            $temat = "Reset has�a do panelu administracyjnego";
            $tresc = "Twoje tymczasowe has�o to: " . $tempPass . "\n\n";
            $tresc .= "Ze wzgl�d�w bezpiecze�stwa zmie� je po zalogowaniu.";

            $naglowki = "From: system@" . $_SERVER['HTTP_HOST'] . "\r\n";
            $naglowki .= "X-Mailer: PHP/" . phpversion();

            if (mail($odbiorca, $temat, $tresc, $naglowki)) {
                return "Link do resetowania has�a zosta� wys�any na adres email administratora.";
            }
        }
        return "Podano nieprawid�owy login.";
    }

    return '
    <div class="reset-form">
        <h2>Resetowanie has�a administratora</h2>
        <form method="POST">
            <div class="form-group">
                <label for="login">Login administratora:</label>
                <input type="text" id="login" name="login" required>
            </div>
            <button type="submit" name="przypomnij">Zresetuj has�o</button>
        </form>
    </div>';
}

if (isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'send':
            WyslijMailKontakt("admin@example.com");
            break;
        case 'remind':
            echo PrzypomnijHaslo();
            break;
        default:
            echo PokazKontakt();
    }
} else {
    echo PokazKontakt();
}
?>