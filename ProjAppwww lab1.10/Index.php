<?php
// Ignorujemy notyfikacje i ostrzeżenia,
// aby kod działał płynnie w środowisku produkcyjnym.
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Ładowanie pliku konfiguracyjnego, który zawiera ustawienia połączenia z bazą danych
include('cfg.php');

// Jeśli parametr 'page' jest ustawiony w URL, dołączamy odpowiednią stronę,
// w przeciwnym razie ustawiamy domyślną stronę (np. strona o ID 1)
if (isset($_GET['page'])) {
    include('showpage.php');  // Załadowanie strony wskazanej w parametrze 'page'
} else {
    $_GET['page'] = 1;
    include('showpage.php');  // Załadowanie strony domyślnej
}
?>

<!-- ============================== -->
<!-- Struktura HTML strony -->
<!-- ============================== -->

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="pl" />
    <meta name="author" content="Mateusz Derbin" />
    <title>Samoloty - moja pasja</title>
    
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="css/style.css" />
</head>

<body onload="startclock()">

</body>

</html>
