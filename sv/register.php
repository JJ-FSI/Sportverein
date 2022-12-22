<?php

    include "usefullFunctions.php";
    ###GLOBALE DATEN###
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
        "passwort" => array(
            "validiert" => false,
            "wert" => "geheim",
            "fehlermeldung" => "Passwörter müssen übereinstimmen"
        ),
        "passwort2" => array(
            "validiert" => true,
            "wert" => "geheim",
            "fehlermeldung" => "Bitte geben sie ihr Passwort ein"
        ),
        "email" => array(
            "validiert" => false,
            "wert" => "max@mustermail.com",
            "fehlermeldung" => "Bitte eine gültige E-Mail eingeben"
        ),
    );

    function EmailIstNochNichtVergeben(string $email)
    {   
        $returnValue = false;

        $servername = "localhost";
        $username = "root";
        $password = null;
        $dbname = "sportverein";

        $dbfetchsuccess = false;
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        if ($stmt = $conn->prepare("SELECT email FROM user WHERE email=?")) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $dbfetchsuccess = $stmt->fetch();
            var_dump($stmt);
            $stmt->close();
        }
        $conn->close();

        if ($dbfetchsuccess == null) {
            $returnValue = true;
        }

        return $returnValue;

    }


    function formausgeben($meineEingaben)
    {
        global $meineEingaben;

        include 'sv_header.php';


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

                <?php
                    echo $HTMLErrorString;
                ?>
                <br>
                <form class="myForm" action="register.php" method="POST">
                    <h2>Benutzer registrieren</h2>
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

                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value=
                    <?php
                        echo "\"" . $meineEingaben["email"]["wert"] . "\"";
                    ?>
                    required>
                    <label for="passwort">Passwort *</label>
                    <input type="passwor" id="passwort"  name="passwort" required value=
                    <?php
                        echo "\"" . $meineEingaben["passwort"]["wert"] . "\"";
                    ?>
                    >
                    <label for="passwort2">Passwort wiederholen *</label>
                    <input type="passwor" id="passwort2"  name="passwort2" required value=
                    <?php
                        echo "\"" . $meineEingaben["passwort2"]["wert"] . "\"";
                    ?>
                    >                    
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
    function formverarbeiten()
    {
        global $meineEingaben;
        foreach ($_POST as $key => $value) {
            $meineEingaben[$key]["wert"] = $value;
        }
        if (prüfe_eingaben($meineEingaben)) {
            unset($meineEingaben["passwort2"]);
            var_dump($meineEingaben);
            $affectedrows = SQL_Insert_Prepared($meineEingaben, "user");
            if ($affectedrows == -1 || $affectedrows == "Fehler") {
                $meineEingaben["passwort"]["wert"] = $meineEingaben["passwort"]["alterWert"];
                formausgeben($meineEingaben);
            }

            else {
                loginWasSuccessfull($meineEingaben["email"]["wert"]);
                // header("Location: kursdaten.php");
            }
        }
        else {
            formausgeben($meineEingaben);
        }
    }
    function prüfe_eingaben()
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
        if (is_string($_POST["email"]))
        {
            $meineEingaben["email"]["wert"] = trim(htmlspecialchars($_POST["email"]));
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) && EmailIstNochNichtVergeben($_POST["email"])){
                $meineEingaben["email"]["validiert"] = true;
            }
            else {
                $meineEingaben["email"]["validiert"] = false;
            }
        }
        if (is_string($_POST["passwort"]))
        {
            if ($_POST["passwort"] == $_POST["passwort2"]){
                $meineEingaben["passwort"]["wert"] = password_hash($_POST["passwort"], PASSWORD_DEFAULT);
                $meineEingaben["passwort"]["alterWert"] =  htmlspecialchars($_POST["passwort"]);
                
                $meineEingaben["passwort"]["validiert"] = true;
            }
            else {
                $meineEingaben["passwort"]["wert"] = htmlspecialchars($_POST["passwort"]);
                $meineEingaben["passwort"]["validiert"] = false;
            }
        }



        // var_dump($meineEingaben);


        $bRückgabewert = true;
        foreach ($meineEingaben as $key => $value) {
            if ($meineEingaben[$key]["validiert"] == false)
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