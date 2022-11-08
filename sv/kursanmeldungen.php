
<?php
    include 'sv_header.php';
?>
<?php
    $i = 0;
    $KurslisteArray = array();
    $myfile = fopen("kursliste.txt", "r") or die("Unable to open file!");
    #lese die gesamte Datei aus (EOF) und schreibe sie in ein Array
    while(!feof($myfile))
    {
        $KurslisteArray[$i] = fgets($myfile);
        $KurslisteArray[$i] = str_replace("\n", "", $KurslisteArray[$i]);
        $KurslisteArray[$i] = str_replace("\r", "", $KurslisteArray[$i]);
        $i++;
    }      
    fclose($myfile);
    #füge die Inhalte des Arrays in Option Elementen zusammen
    $KurslisteHTMLString = "";
    foreach ($KurslisteArray as $key => $einKurs) {
        $KurslisteHTMLString .= "<option value=\"" . $einKurs . "\">" . $einKurs . "</option>";
    }

    $HTMLErrorString = "";
    // foreach ($meineEingaben as $einSchluessel => $einWert) {
    //     if ($einWert["validiert"] == false) {
    //         $HTMLErrorString .= "<p><b class=fehler>" . $einWert["Fehlermeldung"] . "</b></p>";
    //     }
    // } 

/*     var_dump($KurslisteArray); */
?>
    <div class=contentLeft>
        <?php
            echo $HTMLErrorString;
        ?>
        <h1>Kursanmeldung für Nichtmitglieder</h1>
        <br>
        <p>Bitte Füllen Sie die nachfolgenden Eingabefelder aus:</p>   
        <br>
        <form class="myForm" action="formular_verarbeiten.php" method="POST">
            <fieldset>
                <legend>Anrede</legend>
                <input type="radio" id="frau" name="anrede" value="Frau">
                <label for="frau">Frau</label>
                <input type="radio" id="herr" name="anrede" value="Herr" checked>
                <label for="ohneAnrede">Herr</label>
                <input type="radio" id="ohneAnrede" name="anrede" value="ohneAnrede">
                <label for="ohneAnrede">ohne Anrede</label>
            </fieldset>
            <label for="vorname">Vorname *</label>
            <input type="text" id="vorname" name="vorname" value="Max" required>
            <label for="nachname">Nachname *</label>
            <input type="text" id="nachname" name="nachname" value="Mustermann" required>
            <label for="telefon">Telefon</label>
            <input type="tel" id="telefon" name="telefon" value="1234">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="max.mustermann@mustermail.de" required>
            <label for="geburtsdatum">Geburtsdatum *</label>
            <input type="date" id="geburtsdatum"  name="geburtsdatum" required value="2000-01-02">
            <fieldset>
                <legend>Bevorzugte Tage</legend>
                <input type="checkbox" id="montag" name="wochentag[]" value="montag" checked>
                <label for="montag">Montag</label>
                <input type="checkbox" id="dienstag" name="wochentag[]" value="dienstag" checked>
                <label for="dienstag">Dienstag</label>
                <input type="checkbox" id="mittwoch" name="wochentag[]" value="mittwoch">
                <label for="mittwoch">Mittwoch</label>
                <input type="checkbox" id="donnerstag" name="wochentag[]" value="donnerstag">
                <label for="donnerstag">Donnerstag</label>
                <input type="checkbox" id="freitag" name="wochentag[]" value="freitag">
                <label for="freitag">Freitag</label>
                <input type="checkbox" id="samstag" name="wochentag[]" value="samstag">
                <label for="samstag">Samstag</label>
            </fieldset>
            <label for="Kurs">Kursart *</label>
            <select name="kurs" required>
                <?php
                    echo $KurslisteHTMLString;
                ?>
            </select>
            <label for="nachricht">Nachricht</label>
            <textarea type="date" id="nachricht"  name="nachricht" vale></textarea>
            <p>* Pflichtfelder</p>

            <input type="submit">
            <input type="reset">
        </form>
    </div>
<?php
    include 'sv_footer.php';
?>
