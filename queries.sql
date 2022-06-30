INSERT INTO
    categories (character_code, name_category)
VALUES
    ('boards', 'Доски и лыжи'),
    ('attachment', 'Крепления'),
    ('boots', 'Ботинки'),
    ('clothing', 'Одежда'),
    ('tools', 'Инструменты'),
    ('other', 'Разное');

INSERT INTO
    users (email, user_name, user_password, contacts)
VALUES
    ('user1@mail.ru', 'Аня', 'pass1', '8636'),
    (
        'user2@mail.ru',
        'Андрей',
        'pass2',
        '88887777887'
    );

INSERT INTO
    lots (
        title,
        lot_description,
        img,
        start_price,
        date_finish,
        step,
        user_id,
        category_id
    )
VALUES
    (
        '2014 Rossignol District Snowboard',
        'Легкий сноуборд',
        'img/lot-1.jpg',
        10999,
        '2022-06-15',
        500,
        1,
        1
    ),
    (
        'DC Ply Mens 2016/2017 Snowboard',
        'Легкий сноуборд',
        'img/lot-2.jpg',
        159999,
        '2022-06-27',
        1000,
        2,
        1
    ),
    (
        'Крепления Union Contact Pro 2015 года размер L/XL',
        'Хорошие крепления}',
        'img/lot-3.jpg',
        8000,
        '2022-06-13',
        500,
        2,
        2
    ),
    (
        'Ботинки для сноуборда DC Mutiny Charocal',
        'Ботинки супер',
        'img/lot-4.jpg',
        10999,
        '2022-06-23',
        600,
        1,
        3
    ),
    (
        'Куртка для сноуборда DC Mutiny Charocal',
        'Куртка бу',
        'img/lot-5.jpg',
        7500,
        '2022-07-13',
        500,
        1,
        4
    ),
    (
        'Маска Oakley Canopy',
        'Маска збс',
        'img/lot-6.jpg',
        5400,
        '2022-06-13',
        100,
        2,
        6
    );

INSERT INTO
    bets (price_bet, user_id, lot_id)
VALUES
    (8500, 1, 4);

INSERT INTO
    bets (price_bet, user_id, lot_id)
VALUES
    (9000, 1, 4);

SELECT
    name_category AS 'Категория'
FROM
    categories;

SELECT
    lots.title,
    lots.start_price,
    lots.img,
    categories.name_category
FROM
    lots
    JOIN categories ON lots.category_id = categories.id;

SELECT
    lots.id,
    lots.date_creation,
    lots.title,
    lots.lot_description,
    lots.start_price,
    lots.img,
    categories.name_category
FROM
    lots
    JOIN categories ON lots.category_id = categories.id
WHERE
    lots.id = 4;

UPDATE
    lots
SET
    title = 'Ботинки обычные'
WHERE
    id = 4;

SELECT
    bets.date_bet,
    bets.price_bet,
    lots.title,
    users.user_name
FROM
    bets
    JOIN lots ON bets.lot_id = lots.id
    JOIN users ON bets.user_id = users.id
WHERE
    lots.id = 4
ORDER BY
    bets.date_bet DESC;