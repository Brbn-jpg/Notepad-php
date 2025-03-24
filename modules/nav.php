<?php
    $nav = "<nav class = 'nav nav-open'>";
    $nav .= "<a href=\"index.php\" class=\"main-page\"><h1>Notatnik.php</h1></a>";
    $nav .= "<ul class=\"login\">";
    $nav .= "<li class=\"list-link\"><a href=\"login.php\" class=\"link\">zaloguj</a></li>";
    $nav .= "<li class=\"list-link\">";
    $nav .= "<a href=\"register.php\" class=\"link\">zarejestruj</a>";
    $nav .= "</li>";
    $nav .= "</ul>";
    $nav .= "<button class='btn-mobile-nav'>";
    $nav .=  "<ion-icon class='icon-mobile-nav' name='menu-outline'></ion-icon>";
    $nav .=  "<ion-icon class='icon-mobile-nav' name='close-outline'></ion-icon>";
    $nav .=  "</button>";
    $nav .= "</nav>";
    

    echo $nav;
?>