<?php
    session_start();
    $_SESSION["userid"] = 0;
    $_SESSION["isLoggedIn"] = false;
    header("Location: index.php");
?>