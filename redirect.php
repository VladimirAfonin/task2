<?php
require_once 'Shortener.php';

if(isset($_GET['alias'])) {
    $shortObj = Shortener::getInstance();
    $alias = $_GET['alias'];

    if($url = $shortObj->getUrl($alias)) {
        header("Location: $url");
        exit();
    }
}

header("Location: index.php");