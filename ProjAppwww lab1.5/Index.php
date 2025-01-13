<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);

include('cfg.php');

if (isset($_GET['page'])) {
    include('showpage.php');
} else {
    // Wyświetlenie strony domyślnej (np. z ID 1)
    $_GET['page'] = 1;
    include('showpage.php');
}
?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
    <meta http-equiv="content-language" content="pl" />
    <meta name="author" content="Mateusz Derbin" />
    <title>Samoloty moj  pasj </title>
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
</head>

    <body onload="startclock()">

        
    </body>
</html>
