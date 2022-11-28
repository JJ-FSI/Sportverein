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



$servername = "localhost";
$username = "root";
$password = null;
$dbname = "nordwind";
$sql = "SELECT Firma, Plz, Ort, Strasse, Telefon FROM kunden";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query($sql);
$resultArray = [];
$resultRowIndex = 0;

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
      $resultArray[$resultRowIndex] = $row;
      $resultRowIndex++;
  }
}

// var_dump($resultArray);

echo HTMLtableFrom2DAssocArray($resultArray);

$conn->close();
?>