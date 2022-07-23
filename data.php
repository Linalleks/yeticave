<?php 

$db = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($db, "utf8");

/**
* Получает массив в результате sql-запроса на получение данных
* @param $con - результт соединения
* @param string $sql - sql запрос
* @return void - или массив данных, или ошибку
*/
function db_query($sql = '') {
    global $db;
    if (!$db) {
        $error = mysqli_connect_error();
        return $error;
    } 
    if (empty($sql)) return false;
    $res = mysqli_query($db, $sql);
    if (!$res) return mysqli_error($db);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

/**
* Получает массив категорий
* @return void - или массив данных, или ошибка
*/
function get_categories() {
    return db_query("SELECT character_code, name_category FROM categories");   
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
    WHERE lots.id = $id");
}