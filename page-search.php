<?php 
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

$categories = get_categories();
$search = $_GET["search"];
if ($search) {
    $items_count = get_count_lots($search);
    $cur_page = $_GET["page"] ?? 1;
    $page_items = 9;
    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;
    $pages = range(1, $pages_count);

    $lots = get_found_lots($search, $page_items, $offset);
}

$page_content = include_template("search.php", [
    "categories" => $categories,
    "search" => $search,
    "lots" => $lots,
    "pagination" => $pagination,
    "pages_count" => $pages_count,
    "pages" => $pages,
    "cur_page" => $cur_page
]);

$layout_content = include_template('layout.php', [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Результаты поиска",
    "search" => $search,
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
