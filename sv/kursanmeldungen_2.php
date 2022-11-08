<?php
    ###GLOBALE DATEN###
    $meineEingaben = array(
        "anrede" => array(
            "validiert" => false,
            "wert" => "",
            "fehlermeldung" => "Bitte Anrede auswählen"
        ),
        "vorname" => array(
            "validiert" => false,
            "wert" => "",
            "fehlermeldung" => "Bitte Vornamen eingeben"
        ),
        "nachname" => array(
            "validiert" => false,
            "wert" => "",
            "fehlermeldung" => "Bitte Vornamen eingeben"
        ),
        "telefon" => array(
            "validiert" => false,
            "wert" => "",
            "fehlermeldung" => "Bitte Telefonnummer eingeben"
        ),
        "email" => array(
            "validiert" => false,
            "wert" => "",
            "fehlermeldung" => "Bitte eine gültige E-Mail eingeben"
        ),
        "geburtsdatum" => array(
            "validiert" => false,
            "wert" => "",
            "fehlermeldung" => "Bitte ihr Geburtsdatum eingeben"
        ),
        "wochentage" => array(
            "validiert" => false,
            "wert" => array(),
            "fehlermeldung" => "Bitte gewünschte Wochentage auswählen"
        ),
        "kurs" => array(
            "validiert" => false,
            "wert" => "",
            "fehlermeldung" => "Bitte Kurs auswählen"
        ),
        "nachricht" => array(
            "validiert" => true,
            "wert" => "",
            "fehlermeldung" => "Bitte Vornamen eingeben"
        ),
    );
    function formausgeben($meineEingaben)
    {
        global $meineEingaben;

        include 'sv_header.php';

        // var_dump($meineEingaben);

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
        // var_dump($meineEingaben);
        if (!empty($_POST)) {
            foreach ($meineEingaben as $einSchluessel => $einWert) {
                // var_dump($meineEingaben[$einSchluessel]);
                if ($einWert["validiert"] == false) {
                    $HTMLErrorString .= "<p><b class=fehler>" . $einWert["fehlermeldung"] . "</b></p>";
                }
            } 
        }

        /*     var_dump($KurslisteArray); */
        ?>
            <div class=contentLeft>

                <h1>Kursanmeldung für Nichtmitglieder</h1>
                <br>
                <?php
                    echo $HTMLErrorString;
                ?>
                <p>Bitte Füllen Sie die nachfolgenden Eingabefelder aus:</p>   
                <br>
                <form class="myForm" action="kursanmeldungen_2.php" method="POST">
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
                    <input type="text" id="vorname" name="vorname" value=
                    <?php
                        echo "\"" . $meineEingaben["vorname"]["wert"] . "\"";
                        ?>
                    required>
                    <label for="nachname">Nachname *</label>
                    <input type="text" id="nachname" name="nachname" value=
                    <?php
                        echo "\"" . $meineEingaben["nachname"]["wert"] . "\"";
                    ?>
                    required>
                    <label for="telefon">Telefon</label>
                    <input type="tel" id="telefon" name="telefon" value=
                    <?php
                        echo "\"" . $meineEingaben["telefon"]["wert"] . "\"";
                    ?>
                    >
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value=
                    <?php
                        echo "\"" . $meineEingaben["email"]["wert"] . "\"";
                    ?>
                    required>
                    <label for="geburtsdatum">Geburtsdatum *</label>
                    <input type="date" id="geburtsdatum"  name="geburtsdatum" required value=
                    <?php
                        echo "\"" . $meineEingaben["geburtsdatum"]["wert"] . "\"";
                    ?>
                    >
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
                    <textarea id="nachricht"  name="nachricht" value=
                    <?php
                        echo "\"" . $meineEingaben["nachricht"]["wert"] . "\"";
                    ?>
                    ></textarea>
                    <p>* Pflichtfelder</p>

                    <input type="submit">
                    <input type="reset">
                </form>
            </div>
        <?php
            include 'sv_footer.php';
        ?>
        <?php
    }
    function formverarbeiten($meineEingaben)
    {
        foreach ($_POST as $key => $value) {
            $meineEingaben[$key]["wert"] = $value;
        }
        if (prüfe_eingaben($meineEingaben)) {
            include "formular_verarbeiten.php";
        }
        else {
            formausgeben($meineEingaben);
        }
    }
    function prüfe_eingaben($meineEingaben)
    {
        global $meineEingaben;

        // echo "prüfeEingaben";
        if ($_POST["anrede"] == "Herr" ||
            $_POST["anrede"] == "Frau" )
        {
            $meineEingaben["anrede"]["wert"] = $_POST["anrede"];
            $meineEingaben["anrede"]["validiert"] = true;
        }

        $bRückgabewert = true;
        foreach ($meineEingaben as $key => $value) {
            if ($value["validiert"] == false)
            {
                $bRückgabewert = false;
            }

        }
        return true;
        return $bRückgabewert;
    }

    // var_dump($_POST);
    if(isset($_POST["vorname"])) 
    {
        formverarbeiten($meineEingaben);
    }
    else {
        formausgeben($meineEingaben);
    }

?>