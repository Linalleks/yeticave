<?php 
session_start();
$is_auth = isset($_SESSION["name"]);
$user_name = $_SESSION["name"];

$db = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($db, "utf8");

/**
* Получает массив в результате sql-запроса на получение данных
* @param $con - результт соединения
* @param string $sql - sql запрос
* @return void - или массив данных, или ошибку
*/
function db_query($sql = '', $all = true) {
    global $db;
    if (!$db) {
        $error = mysqli_connect_error();
        return $error;
    } 
    if (empty($sql)) return false;
    $res = mysqli_query($db, $sql);
    if (!$res) return mysqli_error($db);
    if (!$all) {
        return mysqli_fetch_assoc($res);
    }
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

/**
* Получает массив категорий
* @return void - или массив данных, или ошибка
*/
function get_categories() {
    return db_query("SELECT * FROM categories");   
}

/**
* Получает массив последних лотов
* @param number $count - количество лотов
* @return void - или массив данных, или ошибка
*/
function get_last_lots($count) {  
    return db_query("SELECT lots.id, lots.title, lots.img, lots.start_price, lots.date_finish, categories.name_category
    FROM lots JOIN categories ON lots.category_id = categories.id
    ORDER BY lots.date_creation DESC
    LIMIT $count");
}

/**
* Получает массив последних лотов
* @param number $id - идентификатор лота
* @return void - или массив данных, или ошибка
*/
function get_lot($id) {  
    return db_query("SELECT lots.title, lots.img, lots.description, lots.start_price, lots.date_finish, categories.name_category
    FROM lots JOIN categories ON lots.category_id = categories.id 
    JOIN users ON lots.user_id = users.id
    WHERE lots.id = $id", false);
}

/**
 * Выполняет SQL-запрос для создания нового лота
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function insert_lot ($user_id, $data = []) {
    global $db;
    $sql = "INSERT INTO lots (title, category_id, description, start_price, step, date_finish, img, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, $user_id);";
    $stmt = db_get_prepare_stmt($db, $sql, $data);
    return mysqli_stmt_execute($stmt);
}

/**
 * Возвращает массив данных пользователей: адресс электронной почты и имя
 * @return [Array | String] - или массив данных, или ошибка
 */
function get_users() {
    return db_query("SELECT email, user_name FROM users");  
}

/**
 * Выполняет SQL-запрос для создания нового лота
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function insert_user ($data = []) {
    global $db;
    $sql = "INSERT INTO users (email, user_password, user_name, contacts) VALUES (?, ?, ?, ?);";
    $stmt = db_get_prepare_stmt($db, $sql, $data);
    return mysqli_stmt_execute($stmt);
}

/**
 * Возвращает массив данных пользователя: id, адресс электронной почты, имя, хеш пароля
 * @param $email - введенный адрес электронной почты
 * @return [Array | String] - или массив данных, или ошибка
 */
function get_login($email) {
    return db_query("SELECT id, email, user_name, user_password FROM users WHERE email = '$email'", false);
}
