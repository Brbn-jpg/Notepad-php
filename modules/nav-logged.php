<?php
    $nav = "<nav class='nav nav-open'>";
    $nav .= "<a href=\"index.php\" class=\"main-page\"><h1>Notatnik.php</h1></a>";
    $nav .= "<ul class=\"login\">";
    $nav .= "<li class=\"list-link\"><a href=\"notes.php\" class=\"link\">notatki</a></li>";
    $nav .= "<li class=\"list-link\"><a href=\"deleted_notes.php\" class=\"link\">usunięte notatki</a></li>";
    $nav .= "<li class=\"list-link\"><a href=\"logout.php\" class=\"link\">wyloguj</a></li>";
    $nav .= "</ul>";
    $nav .= "</nav>";
    $nav .= "<button class='btn-mobile-nav'>";
    $nav .=  "<ion-icon class='icon-mobile-nav' name='menu-outline'></ion-icon>";
    $nav .=  "<ion-icon class='icon-mobile-nav' name='close-outline' style='display: none;'></ion-icon>";
    $nav .=  "</button>";

    echo $nav;
?>
