<?php
    include 'sv_header.php';
    include 'usefullFunctions.php';
?>
<?php
    // var_dump($_SESSION);
    $dbAssocArray = SQLQuery2DAssocArray("sportverein", "SELECT anrede, vorname, nachname, telefon, email, geburtsdatum, wochentage, kurs FROM kursanmeldung WHERE userid=\"" . $_SESSION["userid"] . "\";");
    // $dbAssocArray = SQLQuery2DAssocArray("sportverein", "SELECT anrede, vorname, nachname, telefon, email, geburtsdatum, wochentage, kurs FROM kursanmeldung;");
    // var_dump($dbAssocArray);
    if ($dbAssocArray == []) {
        $ihreKurseHTML = "Leider noch keine Kurse";
    }
    else {
        $ihreKurseHTML = HTMLtableFrom2DAssocArray($dbAssocArray);
    }
?>
    <div class=contentLeft>
        <h2>Ihre Kurse</h2>
<?php
    echo $ihreKurseHTML;
?>

    </div>
<?php
    include 'sv_footer.php';
?>