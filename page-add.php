<?php 
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

$categories = get_categories();
$cat_id = array_column($categories, "id");

$page_content = include_template('add.php', [
    "categories" => $categories,
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ["title", "category", "description", "start_price", "step", "date_finish"];
    $errors = [];

    $rules = [
        "category" => function($value) use ($cat_id) {
            return validate_category($value, $cat_id);
        },
        "start_price" => function($value) {
            return validate_number($value);
        },
        "step" => function($value) {
            return validate_number($value);
        },
        "date_finish" => function($value) {
            return validate_date($value);
        },
    ];

    $lot = filter_input_array(INPUT_POST, [
        "title" => FILTER_DEFAULT, 
        "category" => FILTER_DEFAULT, 
        "description" => FILTER_DEFAULT,
        "start_price" => FILTER_DEFAULT, 
        "step" => FILTER_DEFAULT, 
        "date_finish" => FILTER_DEFAULT
    ], true);

    foreach ($lot as $field => $value) {
        if (isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field] = $rule($value);
        }
        if (in_array($field, $required) && empty($value)) {
            $errors[$field] = "Поле $field необходимо заполнить";
        }

    }

    $errors = array_filter($errors);

    if (!empty($_FILES["img"]["name"])) {
        $tmp_name = $_FILES["img"]["tmp_name"];
        $path = $_FILES["img"]["name"];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type === "image/jpeg") {
            $ext = ".jpg";
        } else if ($file_type ==="image/png") {
            $ext = ".png";
        }
        if ($ext) {
            $file_name = uniqid() . $ext;
            $lot["path"] = "uploads/" . $file_name;
            move_uploaded_file($tmp_name, $lot["path"]);
        } else {
            $errors["img"] = "Допустимые форматы файлов: jpg, jpeg, png";
        }
    } else {
        $errors["img"] = "Загрузите изображение";
    }

    if (count($errors)) {
        $page_content = include_template('add.php', [
            "categories" => $categories,
            "lot" => $lot,
            "errors" => $errors
        ]);
    } else {
        if (insert_lot(3, $lot)) {
            $lot_id = mysqli_insert_id($db);
            header("Location: /page-lot.php?id=$lot_id");
        } else {
            $error = mysqli_error($db);
        }
    }
}

$layout_content = include_template('layout.php', [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Добавление лота"
]);

print($layout_content);
