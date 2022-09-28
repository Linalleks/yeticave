<?php 
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

if ($is_auth) {
    header("Location: 403.php");
}

$categories = get_categories();

$page_content = include_template('sign-up.php', [
    "categories" => $categories,
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ["email", "password", "name", "contacts"];
    $errors = [];

    $rules = [
        "email" => function($value) {
            return validate_email($value);
        },
        "password" => function($value) {
            return validate_length($value, 6, 8);
        },
        "contacts" => function($value) {
            return validate_length($value, 7, 1000);
        },
    ];

    $user = filter_input_array(INPUT_POST, [
        "email" => FILTER_DEFAULT, 
        "password" => FILTER_DEFAULT, 
        "name" => FILTER_DEFAULT,
        "contacts" => FILTER_DEFAULT,
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
        $page_content = include_template('sign-up.php', [
            "categories" => $categories,
            "user" => $user,
            "errors" => $errors
        ]);
    } else {
        $users = get_users();
        $emails = array_column($users, "email");
        $names = array_column($users, "user_name");
        if (in_array($user["email"], $emails)) {
            $errors["email"] = "Пользователь с таким е-mail уже зарегистрирован";
        }
        if (in_array($user["name"], $names)) {
            $errors["name"] = "Пользователь с таким именем уже зарегистрирован";
        }

        if (count($errors)) {
            $page_content = include_template("sign-up.php", [
                "categories" => $categories,
                "user" => $user,
                "errors" => $errors
            ]);
        } else {
            $user["password"] = password_hash($user["password"], PASSWORD_DEFAULT);
            if (insert_user($user)) {
                $lot_id = mysqli_insert_id($db);
                header("Location: /page-login.php");
            } else {
                $error = mysqli_error($db);
            }
        }
    }
}

$layout_content = include_template('layout.php', [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Регистрация",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
