<?php
   $Bilder = array
   (
        array
        (
            "Sportart" => "Basketball",
            "Dateipfad"=> "/sv/img/bild1.jpg"
        ),
        array
        (
            "Sportart" => "Bouldern",
            "Dateipfad"=> "/sv/img/bild2.jpg"
        ),
        array
        (
            "Sportart" => "Fußball",
            "Dateipfad"=> "/sv/img/bild3.jpg"
        ), 
       array
        (
            "Sportart" => "Hockey",
            "Dateipfad"=> "/sv/img/bild4.jpg"
        ),        
    ); 
?>

<?php
    include 'sv_header.php';
?>
<div>
<?php
    //var_dump($Bilder);
    foreach($Bilder as $einBild)
    {
        $AusgabeSportart = $einBild["Sportart"];
        $AusgabePfad = $einBild["Dateipfad"];
        
        echo "<img src=$AusgabePfad alt=$AusgabeSportart title=$AusgabeSportart>";
    };
?>
</div>
<?php
    include 'sv_footer.php';
?>