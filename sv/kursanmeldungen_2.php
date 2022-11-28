<?php
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    ###GLOBALE DATEN###
    $verfügbareWochentage = ["montag", "dienstag", "mittwoch", "donnerstag", "freitag", "samstag"];

    $meineEingaben = array(
        "anrede" => array(
            "validiert" => false,
            "wert" => "Herr",
            "fehlermeldung" => "Bitte Anrede auswählen"
        ),
        "vorname" => array(
            "validiert" => false,
            "wert" => "Max",
            "fehlermeldung" => "Bitte Vornamen eingeben"
        ),
        "nachname" => array(
            "validiert" => false,
            "wert" => "Mustermann",
            "fehlermeldung" => "Bitte Vornamen eingeben"
        ),
        "telefon" => array(
            "validiert" => false,
            "wert" => "09171 818400",
            "fehlermeldung" => "Bitte Telefonnummer eingeben"
        ),
        "email" => array(
            "validiert" => false,
            "wert" => "max@mustermail.com",
            "fehlermeldung" => "Bitte eine gültige E-Mail eingeben"
        ),
        "geburtsdatum" => array(
            "validiert" => false,
            "wert" => "2000-01-02",
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
            $KurslisteHTMLString .= "<option value=\"" . $einKurs . "\"";
            if (in_array($meineEingaben["kurs"]["wert"], $KurslisteArray)) {
                $KurslisteHTMLString .= " selected ";
            }
            $KurslisteHTMLString .= ">" . $einKurs . "</option>";
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
                        <input type="radio" id="frau" name="anrede" value="Frau"
                        <?php
                            if ($meineEingaben["anrede"]["wert"] == "Frau" ) {
                                echo " checked ";
                            }
                        ?>>
                        <label for="frau">Frau</label>
                        <input type="radio" id="herr" name="anrede" value="Herr" 
                        <?php
                            if ($meineEingaben["anrede"]["wert"] == "Herr" ) {
                                echo " checked ";
                            }
                        ?>>
                        <label for="ohneAnrede">Herr</label>
                        <input type="radio" id="ohneAnrede" name="anrede" value="ohneAnrede"
                        <?php
                            if ($meineEingaben["anrede"]["wert"] == "ohneAnrede" ) {
                                echo " checked ";
                            }
                        ?>>
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
                        <input type="checkbox" id="montag" name="wochentag[]" value="montag"
                        <?php
                            if (in_array("montag", $meineEingaben["wochentage"]["wert"])) {
                                echo "checked";
                            }
                        ?>
                        >
                        <label for="montag">Montag</label>
                        <input type="checkbox" id="dienstag" name="wochentag[]" value="dienstag"
                        <?php
                            if (in_array("dienstag", $meineEingaben["wochentage"]["wert"])) {
                                echo "checked";
                            }
                        ?>>
                        <label for="dienstag">Dienstag</label>
                        <input type="checkbox" id="mittwoch" name="wochentag[]" value="mittwoch"
                        <?php
                            if (in_array("mittwoch", $meineEingaben["wochentage"]["wert"])) {
                                echo "checked";
                            }
                        ?>>
                        <label for="mittwoch">Mittwoch</label>
                        <input type="checkbox" id="donnerstag" name="wochentag[]" value="donnerstag"
                        <?php
                            if (in_array("donnerstag", $meineEingaben["wochentage"]["wert"])) {
                                echo "checked";
                            }
                        ?>>
                        <label for="donnerstag">Donnerstag</label>
                        <input type="checkbox" id="freitag" name="wochentag[]" value="freitag"
                        <?php
                            if (in_array("freitag", $meineEingaben["wochentage"]["wert"])) {
                                echo "checked";
                            }
                        ?>>
                        <label for="freitag">Freitag</label>
                        <input type="checkbox" id="samstag" name="wochentag[]" value="samstag"
                        <?php
                            if (in_array("samstag", $meineEingaben["wochentage"]["wert"])) {
                                echo "checked";
                            }
                        ?>>
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
        else {
            $meineEingaben["anrede"]["validiert"] = false;
        }
        if (is_string($_POST["vorname"]))
        {
            $meineEingaben["vorname"]["wert"] = trim(htmlspecialchars($_POST["vorname"]));
            $meineEingaben["vorname"]["validiert"] = true;
        }
        if (is_string($_POST["nachname"]))
        {
            $meineEingaben["nachname"]["wert"] = trim(htmlspecialchars($_POST["nachname"]));
            $meineEingaben["nachname"]["validiert"] = true;
        }
        if (is_string($_POST["telefon"]))
        {
            $meineEingaben["telefon"]["wert"] = trim(htmlspecialchars($_POST["telefon"]));
            if (preg_match("/^(\+[0-9]{2,3}|0+[0-9]{2,5}).+[\d\s\/\(\)-]/", $meineEingaben["telefon"]["wert"]) ){
                $meineEingaben["telefon"]["validiert"] = true;
            }
            else {
                $meineEingaben["telefon"]["validiert"] = false;
            }
        }
        if (is_string($_POST["email"]))
        {
            $meineEingaben["email"]["wert"] = trim(htmlspecialchars($_POST["email"]));
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                $meineEingaben["email"]["validiert"] = true;
            }
            else {
                $meineEingaben["email"]["validiert"] = false;
            }
        }
        if (is_string($_POST["geburtsdatum"]))
        {
            $meineEingaben["geburtsdatum"]["wert"] = trim(htmlspecialchars($_POST["geburtsdatum"]));
            if (strtotime($meineEingaben["geburtsdatum"]["wert"])){
                $meineEingaben["geburtsdatum"]["validiert"] = true;
            }
            else {
                $meineEingaben["geburtsdatum"]["validiert"] = false;
            }
        }

        if (!isset($_POST["wochentag"])) {
            $meineEingaben["wochentage"]["validiert"] = true;
        }

        else if (is_array($_POST["wochentag"]))
        {
            global $verfügbareWochentage;
            
            $meineEingaben["wochentage"]["wert"] = $_POST["wochentag"];
            
            if (0 == count(array_diff($meineEingaben["wochentage"]["wert"], $verfügbareWochentage)) ||
                0 == count($meineEingaben["wochentage"]["wert"])
            ){
                $meineEingaben["wochentage"]["validiert"] = true;
            }
            else {
                $meineEingaben["wochentage"]["validiert"] = false;
            }
        }

        

        if (is_string($_POST["kurs"]))
        {
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

            $meineEingaben["kurs"]["wert"] = trim(htmlspecialchars($_POST["kurs"]));
            if (in_array($_POST["kurs"], $KurslisteArray)){
                $meineEingaben["kurs"]["validiert"] = true;
            }
            else {
                $meineEingaben["kurs"]["validiert"] = false;
            }
        }






        $bRückgabewert = true;
        foreach ($meineEingaben as $key => $value) {
            if ($value["validiert"] == false)
            {
                $bRückgabewert = false;
            }

        }
        // return true;
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