<?php

function loginWasSuccessfull($email)
{
    $dbData = SQLQuery2DAssocArray("sportverein", "SELECT userid FROM user WHERE email=\"" . $email . "\";");
    var_dump($email);
    var_dump($dbData);
    $userid = $dbData[0]["userid"];

    session_start();
    $_SESSION["isLoggedIn"] = true;
    $_SESSION["userid"] = $userid;

    header("Location: kursdaten.php");
}

function SQL_Insert_Prepared(
    array $meineEingaben, 
    string $table,
    string $dbname = "sportverein",
    string $servername = "localhost",
    string $username = "root",
    string $password = null)
{
    


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
    // var_dump($affectedrows);
    return $affectedrows;
}

function HTMLtableFrom2DAssocArray($my2DArray)
{
    
    $TabellenInhaltString = "<script src=https://www.kryogenix.org/code/browser/sorttable/sorttable.js></script>
    <table class=sortable>";
    foreach($my2DArray[0] as $schlüssel => $wert)
    {
        $TabellenInhaltString .= "<th>" . strtoupper($schlüssel)."</th>";
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

function SQLQuery2DAssocArray(string $dbname, string $sql, $servername = "localhost", $username= "root", $password = null)
{
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    // var_dump($conn);
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($sql);
    $resultArray = [];
    $resultRowIndex = 0;

    if ($result === false) {
        return $resultArray;
    }

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