<?php
    $momentanesDatum = date_create();
    $gründungsDatum = date_create("2021-1-1");
    $zeitDifferenz = date_diff($momentanesDatum, $gründungsDatum);
    $momentanesJahr = date_format($momentanesDatum, "Y");
    $formatierteZeitDifferenz = date_interval_format($zeitDifferenz, "   ...   seit %y Jahren");
    $formatierteZeitDifferenzJahre = date_interval_format($zeitDifferenz, "%y");
    $formatierteZeitDifferenzMonate = date_interval_format($zeitDifferenz, "%m");
    $formatierteZeitDifferenzTage = date_interval_format($zeitDifferenz, "%d");
    $ZeitDifferenzAusgabeString = "";
    if ($formatierteZeitDifferenzJahre != "0")
    {
        if ($formatierteZeitDifferenzJahre == "1")
        {
            $ZeitDifferenzAusgabeString .= "einem Jahr ";
        }
        else
        {
            $ZeitDifferenzAusgabeString .= "$formatierteZeitDifferenzJahre Jahren ";
        }
    }
    if ($formatierteZeitDifferenzMonate != "0")
    {
        if ($formatierteZeitDifferenzMonate == "1")
        {
            $ZeitDifferenzAusgabeString .= "einem Monat ";
        }
        else
        {
            $ZeitDifferenzAusgabeString .= "$formatierteZeitDifferenzMonate Monaten ";
        }
        if ($formatierteZeitDifferenzTage != "0")
        {
            $ZeitDifferenzAusgabeString .= "und ";
        }
    }
    if ($formatierteZeitDifferenzTage != "0")
    {
        if ($formatierteZeitDifferenzTage == "1")
        {
            $ZeitDifferenzAusgabeString .= "einem Tag ";
        }
        else
        {
            $ZeitDifferenzAusgabeString .= "$formatierteZeitDifferenzTage Tagen ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportverein</title>
    <link rel="stylesheet" type="text/css" href="/sv/styles.css">
</head>
<body>
<nav>
    <ul>
        <li><a href=/sv>Home</a></li>
        <li><a href=#>News</a></li>
        <li><a href=#>Contact</a></li>
        <li class=floatright><a class=active href=#>Login</a></li>

    </ul>
</nav>
<header>
    <a href=/sv><img src="/sv/img/svLogo.jpg" class=Bild></a>
    <h2>TV 1996 BFSI Sport</h2>
    Wir bringen Menschen in Bewegung    ...   seit 

<?php
    echo $ZeitDifferenzAusgabeString;
?>

</header>