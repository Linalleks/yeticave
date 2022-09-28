<?php
/**
* Форматирование цены
* @param number $price - изначальная цена
* @return string - отформатированная цена
*/
function format_price ($price) {
    $price = ceil($price);
    $format = $price . ' ₽';
    if ($price >= 1000) {
        $price = substr($price,0,strlen($price)-3) . ' ' .  substr($price,-3,3);
    }
    return "$price&nbsp;₽";
}

/**
 * Получает остаток времени до переданной даты в формате массива [ЧЧ, ММ]
 * @param date $date - дата в будущем в формате ['гггг-мм-дд']
 */
function get_dt_range($date) {
    date_default_timezone_set('Europe/Moscow');
    $diff = date_diff(date_create('now'), date_create($date));
    $format_diff = explode(" ", date_interval_format($diff, "%d %H %I"));
    $hours = $format_diff[0] * 24 + $format_diff[1];
    $min = intval($format_diff[2]);
    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $min = str_pad($min, 2, "0", STR_PAD_LEFT);
    
    return [$hours, $min];
}

/**
 * Валидирует поле категории, если такой категории нет в списке
 * возвращает сообщение об этом
 * @param int $id - ID категории, которую пользователь выбрал в списке (или ввел)
 * @param array $cat_list - Список существующих категорий
 * @return string - Текст сообщения об ошибке/ничего
 */
function validate_category ($id, $cat_list) {
    if (!in_array($id, $cat_list)) {
        return "Указана несуществующая категория";
    }
}
/**
 * Проверяет что содержимое поля является числом больше нуля
 * @param string $num число которое ввел пользователь в форму
 * @return string Текст сообщения об ошибке
 */
function validate_number ($num) {
    if (!empty($num)) {
        $num *= 1;
        if (!(is_int($num) && $num > 0)) {
            return "Содержимое поля должно быть целым числом больше нуля";
        }
    }
};

/**
 * Проверяет что дата окончания торгов не меньше одного дня
 * @param string $date дата которую ввел пользователь в форму
 * @return string Текст сообщения об ошибке
 */
function validate_date ($date) {
    if (is_date_valid($date)) {
        $now = date_create("now");
        $d = date_create($date);
        $diff = date_diff($d, $now);
        $interval = date_interval_format($diff, "%d");

        if ($interval < 1) {
            return "Дата должна быть больше текущей не менее чем на один день";
        };
    } else {
        return "Формат даты должен соответствовать «ГГГГ-ММ-ДД»";
    }
};

/**
 * Проверяет что содержимое поля является корректным адресом электронной почты
 * @param string $email - адрес электронной почты
 * @return string - Текст сообщения об ошибке
 */
function validate_email ($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "E-mail должен быть корректным";
    }
}

/**
 * Проверяет что содержимое поля укладывается в допустимый диапазон
 * @param string $text - содержимое поля
 * @param int $min - минимальное количество символов
 * @param int $max - максимальное количество символов
 * @return string - Текст сообщения об ошибке
 */
function validate_length ($text, $min, $max) {
    if ($text) {
        $len = mb_strlen($text);
        if ($len < $min or $len > $max) {
            return "Введите коректное количество символов (от $min до $max символов)";
        }
    }
}
