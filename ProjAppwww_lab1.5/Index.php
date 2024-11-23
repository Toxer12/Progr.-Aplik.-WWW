<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);

//include(cfg.php);
//include(showpage.php);

PokazPodstrone($_get'idp');

if($_GET['idp']=='')
{
    $strona='./html/glowna.html';
    include($strona);
}

if($_GET['idp']=='Records')
{
    $strona='./html/Records.html';
    include($strona);
}

if($_GET['idp']=='History')
{
    $strona='./html/History.html';
    include($strona);
}

if($_GET['idp']=='galeria')
{
    $strona='./html/galeria.html';
    include($strona);
}

if($_GET['idp']=='Form')
{
    $strona='./html/Form.html';
    include($strona);
}

if($_GET['idp']=='Exp')
{
    $strona='./html/Exp.html';
    include($strona);
}

if($_GET['idp']=='Filmy')
{
    $strona='./html/Filmy.html';
    include($strona);
}

if (file_exists($strona)) {
    
} else {
    $strona='./html/glowna.html';
    include($strona);
}
?>

<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
    <meta http-equiv="content-language" content="pl" />
    <meta name="author" content="Mateusz Derbin" />
    <title>Samoloty moj¹ pasj¹</title>
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
</head>

    <body onload="startclock()">

        
    </body>
</html>
