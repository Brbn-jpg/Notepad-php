<?php
    $nav = "<nav>";
    $nav .= "<a href=\"index.php\" class=\"main-page\"><h1>Notatnik.php</h1></a>";
    $nav .= "<ul class=\"login\">";
    $nav .= "<li class=\"list-link\"><a href=\"notes.php\" class=\"link\">notatki</a></li>";
    $nav .= "<li class=\"list-link\"><a href=\"deleted_notes.php\" class=\"link\">usunięte notatki</a></li>";
    $nav .= "<li class=\"list-link\"><a href=\"logout.php\" class=\"link\">wyloguj</a></li>";
    $nav .= "</ul>";
    $nav .= "</nav>";
    
    echo $nav;
?>