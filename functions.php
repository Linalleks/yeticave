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