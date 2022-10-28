
<?php
    # Wenn _POST nicht leer ist schreibe in Datei
    if (! empty($_POST )) 
    {
        $FormularCSV_Zeile = "";
        $BenutzerDatenDatei = fopen("benutzerdaten.txt", "a") or die("Unable to open file!");
        foreach ($_POST as $key => $value) 
        {
            $ÜberprüfterAusgabeString = "";
            #konvertiere array in json
            if (is_array($value))
            {
               $ÜberprüfterAusgabeString = json_encode($_POST[$key]);
               $_POST[$key] = json_encode($_POST[$key]);

            }
            else {
                $ÜberprüfterAusgabeString = $value;
            }
            $FormularCSV_Zeile .= $ÜberprüfterAusgabeString . ";";
        }
        $FormularCSV_Zeile .= "\n";
        fwrite($BenutzerDatenDatei, $FormularCSV_Zeile);
        fclose($BenutzerDatenDatei);

        #maskiere HTML im POST Array
        foreach ($_POST as $key => $value) 
        {
            $_POST[$key] = htmlspecialchars($_POST[$key]);
        }
        

        $FormatiertesMomentanesDatumString = date_format(date_create(), "d.m.y");
        if ($_POST["anrede"] == "ohneAnrede")
        {
            $_POST["anrede"] = $_POST["vorname"];
        }
        $ÜbertrageneDatenBestätigungsHTMLstring = 
        "<p>Herzlichen Glückwunsch " . $_POST["anrede"] . " " . $_POST["nachname"] . "!</p><br>
        <p>Sie haben sich am " .  $FormatiertesMomentanesDatumString . " erfolgreich für den Kurs<br>
        <b>" . $_POST["kurs"] . "</b><br>
        angemeldet.</p>";
    }
    else {
        header("kursanmeldungen.php");
    }

?>
<?php
    include 'sv_header.php';
    var_dump($_POST)
?>
<div class=contentCenter>
    <h1>Kursanmeldung für Nichtmitglieder</h1>
    <br>
    <h1>Übertragene Daten</h1>
    <br>
    <?php
        echo $ÜbertrageneDatenBestätigungsHTMLstring;
    ?>    
</div>
<?php
    include 'sv_footer.php';
?>
