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