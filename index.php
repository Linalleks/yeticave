<?php 
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

if (!$db) {
    $error = mysqli_connect_error();
    echo $error;
} else {
    $categories = get_categories();
    $lots = get_last_lots(6);
}

$page_content = include_template('main.php', [
    "categories" => $categories,
    "lots" => $lots
]);
$layout_content = include_template('layout.php', [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Главная"
]);

print($layout_content);
