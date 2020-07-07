<?php
header("Content-type: application/pdf");
$fichier = "uploads/kcfinder/upload/file/" . $_GET["pdf"];
$name_fichier = $_GET['pdf'];
header("Content-Disposition: attachment; filename=$name_fichier");
readfile($fichier);
