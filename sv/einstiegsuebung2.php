<?php

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

// $servername = "localhost";
// $username = "root";
// $password = null;
// $dbname = "nordwind";
// $sql = "SELECT Firma, Plz, Ort, Strasse, Telefon FROM kunden";

// Create connection


// var_dump($resultArray);

$SQLAntwortArray = SQLQuery2DAssocArray("nordwind", "
    SELECT 
        artikel.Artikelname, 
        lieferanten.Firma,
        kategorien.Kategoriename,
        artikel.Lagerbestand 
    FROM
    (
        (
            artikel
            INNER JOIN lieferanten ON artikel.LieferantenNr = lieferanten.LieferantenNr
        )
        INNER JOIN kategorien ON artikel.KategorieNr = kategorien.KategorieNr
        )
    ;");
// SELECT Artikelname, lieferanten.Firma, kategorien.Kategoriename, Lagerbestand FROM artikel;
echo HTMLtableFrom2DAssocArray($SQLAntwortArray);

?>