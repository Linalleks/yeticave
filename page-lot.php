<?php 
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

$categories = get_categories();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    $lot = get_lot($id);
} 
if (!$id || empty($lot)) {
    http_response_code(404);
    die();
}

$page_content = include_template('lot.php', [
    "categories" => $categories,
    "lot" => $lot[0]
]);

$layout_content = include_template('layout.php', [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Главная"
]);

print($layout_content);
