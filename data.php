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

/**
 * Возвращает массив лотов, соответствующих поисковому запросу
 * @param string $words ключевые слова, введенные пользователем в форму поиска
 * @return [Array | String] - или массив данных, или ошибка
 */
function get_found_lots($words, $limit, $offset) {
    global $db;
    $sql = "SELECT lots.id, lots.title, lots.start_price, lots.img, lots.date_finish, categories.name_category FROM lots
    JOIN categories ON lots.category_id=categories.id
    WHERE MATCH(title, description) AGAINST(?) ORDER BY date_creation DESC LIMIT $limit OFFSET $offset;";

    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $words);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return mysqli_error($db);
}

/**
 * Возвращает количество лотов, соответствующих поисковым словам
 * @param string $words ключевые слова введенные пользователем в форму поиска
 * @return [int | String] Количество лотов, в названии или описании которых есть такие слова
 * или описание последней ошибки подключения
 */
function get_count_lots($words) {
    global $db;
    $sql = "SELECT COUNT(*) as cnt FROM lots
    WHERE MATCH(title, description) AGAINST(?);";
    
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $words);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        return mysqli_fetch_assoc($res)["cnt"];
    }
    return mysqli_error($db);
}

/**
 * Записывает в БД сделанную ставку
 * @param int $sum Сумма ставки
 * @param int $user_id ID пользователя
 * @param int $lot_id ID лота
 * @return bool $res Возвращает true в случае успешной записи
 */
function insert_bet($sum, $user_id, $lot_id) {
    global $db;
    $sql = "INSERT INTO bets (date_bet, price_bet, user_id, lot_id) VALUE (NOW(), ?, $user_id, $lot_id);";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $sum);
    $res = mysqli_stmt_execute($stmt);
    if ($res) {
        return $res;
    }
    return mysqli_error($db);
}

/**
 * Возвращает массив из десяти последних ставок на этот лот
 * @param int $id_lot Id лота
 * @return [Array | String] $list_bets Ассоциативный массив со списком ставок на этот лот из базы данных
 * или описание последней ошибки подключения
 */
function get_bets_history ($id_lot) {
    return db_query("SELECT users.user_name, bets.price_bet, DATE_FORMAT(bets.date_bet, '%d.%m.%y %H:%i') AS date_bet
        FROM bets
        JOIN lots ON bets.lot_id = lots.id
        JOIN users ON bets.user_id = users.id
        WHERE lots.id = $id_lot
        ORDER BY bets.date_bet DESC LIMIT 10;");
}
/**
 * Возвращает массив ставок пользователя
 * @param int $id Id пользователя
 * @return [Array | String] $list_bets Ассоциативный массив ставок
 *  пользователя из базы данных
 * или описание последней ошибки подключения
 */
function get_bets ($id) {
    return db_query("SELECT DATE_FORMAT(bets.date_bet, '%d.%m.%y %H:%i') AS date_bet, bets.price_bet, lots.title, lots.description, lots.img, lots.date_finish, lots.id, categories.name_category
        FROM bets
        JOIN lots ON bets.lot_id = lots.id
        JOIN users ON bets.user_id = users.id
        JOIN categories ON lots.category_id = categories.id
        WHERE bets.user_id = $id
        ORDER BY bets.date_bet DESC;");
}