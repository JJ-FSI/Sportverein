<?php
    include "usefullFunctions.php";

    ###GLOBALE DATEN###
    $meineEingaben = array(
        "passwort" => array(
            "validiert" => false,
            "wert" => "geheim",
            "fehlermeldung" => "Bitte geben sie ihr Passwort ein"
        ),
        "email" => array(
            "validiert" => false,
            "wert" => "max@mustermail.com",
            "fehlermeldung" => "Bitte eine gültige E-Mail eingeben"
        ),
    );
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
                <form class="myForm" action="login.php" method="POST">
                    <h2>Login</h2>
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value=
                    <?php
                        echo "\"" . $meineEingaben["email"]["wert"] . "\"";
                    ?>
                    required>
                    <label for="passwort">Passwort *</label>
                    <input type="password" id="passwort"  name="passwort" required value=
                    <?php
                        echo "\"" . $meineEingaben["passwort"]["wert"] . "\"";
                    ?>
                    >
                    
                    <p>* Pflichtfelder</p>

                    <input type="submit">
                    <input type="reset">
                </form>

                <a href="register.php">Noch nicht registriert?</a>
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
            loginWasSuccessfull($meineEingaben["email"]["wert"]);
            // header("Location: kursdaten.php");
        }
        else {
            formausgeben($meineEingaben);
        }
    }

    function isPasswordCorrect(string $email, string $password)
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

        if ($stmt = $conn->prepare("SELECT * FROM user WHERE email=? AND passwort=?")) {
            $stmt->bind_param("ss", $email, $password);
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

    function prüfe_eingaben($meineEingaben)
    {
        global $meineEingaben;

        // echo "prüfeEingaben";
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
        if ($meineEingaben["email"]["validiert"] && is_string($_POST["passwort"]))
        {
            if (isPasswordCorrect($meineEingaben["email"]["wert"], $_POST["passwort"])){
                $meineEingaben["passwort"]["validiert"] = true;
            }
            else {
                $meineEingaben["passwort"]["validiert"] = false;
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
    if(isset($_POST["email"])) 
    {
        formverarbeiten($meineEingaben);
    }
    else {
        formausgeben($meineEingaben);
    }

?>