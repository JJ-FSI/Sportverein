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



    if ($stmt = $conn->prepare("INSERT INTO kursanmeldung (anrede, vorname, nachname, telefon, email, geburtsdatum, wochentage, kurs, nachricht) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
        $stmt->bind_param($statementListString, ...$parameterArray);
        $stmt->execute();
        $affectedrows =$stmt->affected_rows;
        $stmt->close();
    }
    else {
        $affectedrows = "Fehler";
    }
    // var_dump($affectedrows);
    return $affectedrows;
}

function HTMLtableFrom2DAssocArray($my2DArray)
{
    $TabellenInhaltString = "<table>";
    foreach($my2DArray[0] as $schlüssel => $wert)
    {
        $TabellenInhaltString .= "<th>$schlüssel</th>";
    }
    foreach ($my2DArray as $eineVeranstaltung)
    {
        $TabellenInhaltString .= "<tr>";
        foreach($eineVeranstaltung as $schlüssel => $wert)
        {
            $TabellenInhaltString .= "<td>$wert</td>";
        }
        $TabellenInhaltString .= "</tr>";   
    }
    $TabellenInhaltString .= "</table>";
    return $TabellenInhaltString;
}

function SQLQuery2DAssocArray($dbname, string $sql, $servername = "localhost", $username= "root", $password = null)
{
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($sql);
    $resultArray = [];
    $resultRowIndex = 0;

    if ($result->num_rows > 0) 
    {
    // output data of each row
        while($row = $result->fetch_assoc()) 
        {
            $resultArray[$resultRowIndex] = $row;
            $resultRowIndex++;
        }
    }
    $conn->close();
    return $resultArray;
}

?>