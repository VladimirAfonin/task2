<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'Shortener.php';

define('PATH', 'localhost');

$shortObj = Shortener::getInstance();

if(isset($_POST['url']) && !empty($_POST['url'])) {

    $url = $shortObj->cleanInput($_POST['url']);
    $userAlias = $shortObj->cleanInput($_POST['shortUrl']);

    if(!empty($userAlias)) {
        $userAlias = $shortObj->checkAlias($userAlias, $url);
        if($userAlias) {
            echo   "Ваш short url: <a href='" . "/{$userAlias}'>" . PATH . "/" .  $userAlias .  "</a>";
        } else  {
            echo  "Error: Данный 'short url' уже используется, либо для '{$url}' уже установлен 'short url', попробуйте снова.";
        }
    } else {
        if($alias = $shortObj->createAlias($url)) {
            echo  "Создан! Ваш short url: <a href='" . "/{$alias}'>" . PATH . "/" .  $alias .  "</a>";
        } else {
            echo  "Error: Что-то пошло не так, возможно не корректный Url.";
        }
    }
} else {
    echo "Error: Не заполнено поле Url, повторите попытку.";
}
