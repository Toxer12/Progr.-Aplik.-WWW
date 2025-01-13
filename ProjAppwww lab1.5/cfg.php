<?php
$servername = "localhost";
$username = "root"; // Domyślny użytkownik MySQL w XAMPP
$password = ""; // Puste hasło dla domyślnego użytkownika w XAMPP
$dbname = "moja_strona";

// Połączenie z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}
?>
