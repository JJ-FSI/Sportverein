<?php
    $affectedrows = "";
    if (!empty($_POST)) {

        if (isset($_POST["Telefon"]) && isset($_POST["Firma"])) {
        
        
            $servername = "localhost";
            $username = "root";
            $password = null;
            $dbname = "nordwind";
        
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }

            if ($stmt = $conn->prepare("INSERT INTO versandfirmen (Telefon, Firma) VALUES (?, ?)")) {
                $stmt->bind_param("ss", $_POST["Telefon"], $_POST["Firma"]);
                $stmt->execute();
                $affectedrows =$stmt->affected_rows;
                $stmt->close();
            }
            else {
                $affectedrows = "Fehler";
            }
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <input type=text name=Firma value=Musterfirma>
        <input type=text name=Telefon value=1234>
        <input type=submit>
    </form>
    <?php
    echo $affectedrows;
    ?>
</body>
</html>