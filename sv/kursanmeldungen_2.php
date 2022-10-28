<?php
    ###KLASSEN UND OBJEKTE###
    $meineEingaben = array(
        "anrede" => array(
            "validiert" => false,
            "wert" => "",
            "fehlermeldung" => "Bitte Anrede auswählen"
        ),
        "vorname" => array(
            "validiert" => false,
            "wert" => "",
            "fehlermeldung" => "Bitte Vornamen eingeben"
        ),
        "nachname" => array(
            "validiert" => false,
            "wert" => "",
        ),
        "telefon" => array(
            "validiert" => false,
            "wert" => "",
        ),
        "email" => array(
            "validiert" => false,
            "wert" => "",
        ),
        "geburtsdatum" => array(
            "validiert" => false,
            "wert" => "",
        ),
        "wochentage" => array(
            "validiert" => false,
            "wert" => array(),
        ),
        "kurs" => array(
            "validiert" => false,
            "wert" => "",
        ),
        "notiz" => array(
            "validiert" => false,
            "wert" => "",
        ),
    );
    function formausgeben()
    {
        include "kursanmeldungen.php";
    }
    function formverarbeiten($zuprüfendeEingabenArray)
    {
        if (prüfe_eingaben($zuprüfendeEingabenArray)) {
            
        }
        else {
            formausgeben();
        }
    }
    function prüfe_eingaben($zuprüfendeEingabenArray)
    {

        $bRückgabewert = true;
        foreach ($zuprüfendeEingabenArray as $key => $value) {
            if ($zuprüfendeEingabenArray[$key]["validiert"] = false)
            {
                $bRückgabewert = false;
            }
        }
        return $bRückgabewert;
    }

    if(empty($_POST)) 
    {
        formausgeben();
    }
    else {
        formverarbeiten($meineEingaben);
    }

?>