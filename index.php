<?php 
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

$categories = get_categories();
$lots = get_last_lots(6);

$page_content = include_template('main.php', [
    "categories" => $categories,
    "lots" => $lots
]);
$layout_content = include_template('layout.php', [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
