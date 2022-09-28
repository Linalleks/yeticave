<?php 
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

$categories = get_categories();

$page_content = include_template('login.php', [
    "categories" => $categories,
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ["email", "password"];
    $errors = [];

    $rules = [
        "email" => function($value) {
            return validate_email($value);
        },
        "password" => function($value) {
            return validate_length($value, 6, 8);
        },
    ];

    $user = filter_input_array(INPUT_POST, [
        "email" => FILTER_DEFAULT,
        "password" => FILTER_DEFAULT,
    ], true);

    foreach ($user as $field => $value) {
        if (isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field] = $rule($value);
        }
        if (in_array($field, $required) && empty($value)) {
            $errors[$field] = "Поле $field необходимо заполнить";
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('login.php', [
            "categories" => $categories,
            "user" => $user,
            "errors" => $errors
        ]);
    } else {
        $user_data = get_login ($user["email"]);
        if ($user_data) {
            if (password_verify($user["password"], $user_data["user_password"])) {
                $is_session = session_start();
                $_SESSION['name'] = $user_data["user_name"];
                $_SESSION['id'] = $user_data["id"];

                header("Location: /index.php");
            } else {
                $errors["password"] = "Вы ввели неверный пароль или email";
            }
        } else {
            $errors["email"] = "Вы ввели неверный пароль или email";
        }
        if (count($errors)) {
            $page_content = include_template("login.php", [
                "categories" => $categories,
                "user" => $user,
                "errors" => $errors
            ]);
        }
    }
}

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Вход",
    "is_auth" => $is_auth,
    "user_name" => $user_name
 ]);

print($layout_content);
