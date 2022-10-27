<?php
    include 'sv_header.php';
?>
    <div class=contentLeft>
        <h2>Unsere Aktivitäten</h2>
        <ul>
            <li class=text2>Fussball</li>
            <li class=text2>Basketball</li>
            <li class=text2>Hockey</li>
            <li class=text2>Klettern</li>
            <li class=text2><a href=/sv/kursanmeldungen.php class=link1>Kurse für Nichtmitglieder</a></li>
            <li class=text2><a href=/sv/sportfest.php class=link1>Unser Sportfest 
                <?php
                    echo $momentanesJahr;
                ?>
            </a></li>
        </ul>
    </div>
    <!-- <div class=contentCenter></div> -->
    <div class=contentRight>
        <img class=bild src="/sv/img/bild1.jpg"/>
        <img class=bild src="/sv/img/bild2.jpg"/>
        <img class=bild src="/sv/img/bild3.jpg"/>
        <img class=bild src="/sv/img/bild4.jpg"/>
    </div>
<?php
    include 'sv_footer.php';
?>