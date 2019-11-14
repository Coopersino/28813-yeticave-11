INSERT INTO categories (categor_name, categor_code)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

INSERT INTO users (email, user_name, user_password, contacts, advert_id, rate_id)
VALUES ('vs-mailbox@ya.ru', 'Тарас Телищев', 'qvrE43@', '+79516792941', '1', '1'),
       ('vs-mailbox@yandex.ru', 'Константин Константинопольский', '@nP9*yE', '+79516667766', '2','2');

INSERT INTO advertisements (adv_name, description, img_url, cost, expiration_date, rate_step, autor_id, category_id)
VALUES ('2014 Rossignol District Snowboard', 'Классный сноуборд', 'img/lot-1.jpg', '10999', '2019-11-30', '50', '1', '1'),
       ('DC Ply Mens 2016/2017 Snowboard', 'Очень классный сноуборд', 'img/lot-2.jpg', '159999', '2019-11-09', '100', '1', '1'),
       ('Крепления Union Contact Pro 2015 года размер L/XL', 'Отличное крепление', 'img/lot-3.jpg', '8000', '2019-11-18', '150', '1', '2'),
       ('Ботинки для сноуборда DC Mutiny Charocal', 'Отличные ботинки', 'img/lot-4.jpg', '10999', '2019-11-28', '75',  '2', '3'),
       ('Куртка для сноуборда DC Mutiny Charocal', 'Отличная куртка', 'img/lot-5.jpg', '7500', '2019-12-01', '25', '2', '4'),
       ('Маска Oakley Canopy', 'Описание маски', 'img/lot-6.jpg', '5400', '2019-12-31', '25', '2', '6');

INSERT INTO rates (rate_value, user_id, advert_id)
VALUES ('5425', '1', '4'),
       ('11049', '2', '1');

/*получить все категории*/
SELECT id, categor_name FROM categories;

/*получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории*/
SELECT adv_name, cost, img_url, cat.categor_name, rate_value, adv.dt_add, adv.winner_id FROM advertisements adv
JOIN categories cat ON cat.id = adv.category_id
JOIN rates ON rates.advert_id = adv.id
WHERE adv.winner_id = 0
ORDER BY adv.dt_add;

 /*показать лот по его id. Получить также название категории, к которой принадлежит лот*/
SELECT adv.id, adv_name, categor_name FROM advertisements adv
JOIN categories cat ON adv.id = cat.id
WHERE adv.id = 1;

/*обновить название лота по его идентификатору*/
UPDATE advertisements SET adv_name = 'Rossignol District Snowboard 2012' WHERE id = 1;

/*получить список ставок для лота по его идентификатору с сортировкой по дате*/
SELECT id, rate_value, dt_add FROM rates WHERE id = 6 ORDER BY dt_add;