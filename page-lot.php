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

$history = get_bets_history($id);
$current_price = max($lot["start_price"], $history[0]["price_bet"]);
$min_bet = $current_price + $lot["step"];

$page_content = include_template('lot.php', [
    "categories" => $categories,
    "lot" => $lot,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "current_price" => $current_price,
    "min_bet" => $min_bet,
    "id" => $id,
    "history" => $history
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = filter_input(INPUT_POST, "cost", FILTER_VALIDATE_INT);

    if ($bet < $min_bet) {
        $error = "Ставка не может быть меньше $min_bet";
    }
    if (empty($bet)) {
        $error = "Ставка должна быть целым числом больше нуля";
    }

    if ($error) {
        $page_content = include_template("lot.php", [
            "categories" => $categories,
            "lot" => $lot,
            "is_auth" => $is_auth,
            "user_name" => $user_name,
            "current_price" => $current_price,
            "min_bet" => $min_bet,
            "error" => $error,
            "id" => $id,
            "history" => $history
        ]);
    } else {
        $res = insert_bet($bet, $_SESSION["id"], $id);
        header("Location: /page-lot.php?id=" . $id);
    }
}

$layout_content = include_template('layout.php', [
    "content" => $page_content,
    "categories" => $categories,
    "title" => $lot['title'],
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
