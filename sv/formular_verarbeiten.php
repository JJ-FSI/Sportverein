
<?php

    function SQL_Insert_Prepared(array $meineEingaben)
    {
        
        $servername = "localhost";
        $username = "root";
        $password = null;
        $dbname = "sportverein";
        $table = "kursanmeldung";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $statementListString = "";
        $preparedStatementString = "INSERT INTO ". $table ." (";
        $valuesString = ") VALUES (";
        $parameterArray = [];

        foreach ($meineEingaben as $key => $value) {
            $preparedStatementString .= $key . ",";
            $statementListString .= "s";
            $valuesString .= "?,";
            if (is_array($value["wert"])) {
                array_push($parameterArray, json_encode( $value["wert"]));
            }
            else {
                array_push($parameterArray, $value["wert"]);
            }
        }

        #remove last char
        $preparedStatementString = substr($preparedStatementString, 0, -1);
        $valuesString = substr($valuesString, 0, -1);

        $valuesString .= ")";

        $preparedStatementString .= $valuesString;

        // var_dump($preparedStatementString);
        // var_dump($parameterArray);



        if ($stmt = $conn->prepare($preparedStatementString)) {
            $stmt->bind_param($statementListString, ...$parameterArray);
            $stmt->execute();
            $affectedrows =$stmt->affected_rows;
            $stmt->close();
        }
        else {
            $affectedrows = "Fehler";
        }
        var_dump($affectedrows);
        return $affectedrows;
    }

    # Wenn _POST nicht leer ist schreibe in Datei
    if (! empty($_POST )) 
    {

        ### CSV ###

        $FormularCSV_Zeile = "";
        $BenutzerDatenDatei = fopen("benutzerdaten.txt", "a") or die("Unable to open file!");
        foreach ($meineEingaben as $key => $value) 
        {
            $ÜberprüfterAusgabeString = "";
            #konvertiere array in json
            if (is_array($value["wert"]))
            {
               $ÜberprüfterAusgabeString = json_encode($meineEingaben[$key]["wert"]);
            }
            else {
                $ÜberprüfterAusgabeString = $value["wert"];
            }
            $FormularCSV_Zeile .= $ÜberprüfterAusgabeString . ";";
        }
        $FormularCSV_Zeile .= "\n";
        fwrite($BenutzerDatenDatei, $FormularCSV_Zeile);
        fclose($BenutzerDatenDatei);

        ### SQL ###

        session_start();
        var_dump($_SESSION);
        if (isset ( $_SESSION["userid"])) {
            $meineEingaben["userid"]["wert"] = $_SESSION["userid"];
        }
        SQL_Insert_Prepared($meineEingaben);

        #maskiere HTML im POST Array
        foreach ($_POST as $key => $value) 
        {
            if (!is_array($value)) {
                $_POST[$key] = htmlspecialchars($_POST[$key]);
            }
        }

        // mail(
        //     $meineEingaben["email"]["wert"],
        //     "Vielen Dank für ihre Anmeldung",
        //     "Vielen Dank ". $meineEingaben["anrede"]["wert"] . " " . $meineEingaben["nachname"]["wert"] . "Sie wurden erfolgreich registriert",
        //     'From: postmaster@localhost.com' . "\r\n" .
        //     'Reply-To: postmaster@localhost.com' . "\r\n" .
        //     'X-Mailer: PHP/' . phpversion()
        // );

        

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
    // var_dump($_POST)
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
