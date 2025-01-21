<?php

// Inicjalizuje sesję, aby przechowywać informacje o logowaniu użytkownika
session_start();


// Parametry połączenia z bazą danych
$servername = "localhost";  // Adres serwera bazy danych
$username = "root";         // Nazwa użytkownika bazy danych
$password = "";             // Hasło do bazy danych (puste w przypadku XAMPP)
$dbname = "moja_strona";    // Nazwa bazy danych, do której się łączymy


// Ustawienia domyślnego loginu i hasła administratora
$login = "admin";    // Login administratora
$pass = "kopytko";   // Hasło administratora

// Połączenia z bazą danych i sprawdzamy, czy połączenie jest udane
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzamy, czy połączenie się powiodło
if ($conn->connect_error) {
    // Jeśli wystąpił błąd połączenia, wyświetlamy komunikat o błędzie
    die("Błąd połączenia: " . $conn->connect_error);
}

?>
