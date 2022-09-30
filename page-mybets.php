<?php 
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

if (!$is_auth) {
    header("Location: 403.php");
}

$categories = get_categories();

$bets = get_bets($_SESSION["id"]);

$page_content = include_template('my-bets.php', [
    "categories" => $categories,
    "bets" => $bets,
    "is_auth" => $is_auth
]);

$layout_content = include_template('layout.php', [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Мои ставки",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
