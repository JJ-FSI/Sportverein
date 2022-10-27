<?php
    $TabellenInhaltString = "";
    $Veranstaltungen = array
    (
        array
        (
            "Beginn" => "09.30 Uhr",
            "Disziplin"=> "Diskuswurf",
            "Ort" => "Nebenplatz",
            "Bemerkung" => "Jugendmeisterschaften",
        ),       
        array
        (
            "Beginn" => "12 Uhr",
            "Disziplin"=> "Nichts",
            "Ort" => "Nebenplatz",
            "Bemerkung" => "Jugendmeisterschaften",
        ),       
        array
        (
            "Beginn" => "09.30 Uhr",
            "Disziplin"=> "Diskuswurf",
            "Ort" => "Nebenplatz",
            "Bemerkung" => "Jugendmeisterschaften",
        ),       
        array
        (
            "Beginn" => "09.30 Uhr",
            "Disziplin"=> "Diskuswurf",
            "Ort" => "Nebenplatz",
            "Bemerkung" => "Jugendmeisterschaften",
        ), 
        array
        (
            "Beginn" => "09.30 Uhr",
            "Disziplin"=> "Diskuswurf",
            "Ort" => "Nebenplatz",
            "Bemerkung" => "Jugendmeisterschaften",
        ),       
    );
    foreach($Veranstaltungen[0] as $schlüssel => $wert)
    {
        $TabellenInhaltString .= "<th>$schlüssel</th>";
    }
    foreach ($Veranstaltungen as $eineVeranstaltung)
    {
        $TabellenInhaltString .= "<tr>";
        foreach($eineVeranstaltung as $schlüssel => $wert)
        {
            $TabellenInhaltString .= "<td>$wert</td>";
        }
        $TabellenInhaltString .= "</tr>";   
    }
?>

<?php
    include 'sv_header.php';
?>
<div class=contentLeft>
    <h1>Sportfest: Startzeiten und Veranstaltungen</h1>
    <table>
        <?php
            echo $TabellenInhaltString
        ?>
    </table>
</div>
<?php
    include 'sv_footer.php';
?>