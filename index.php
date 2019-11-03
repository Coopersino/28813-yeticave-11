<?php
    $is_auth = rand(0, 1);
    $user_name = 'Виталий'; // укажите здесь ваше имя
    $categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
    $advertisements = [
        [
            'name' => '2014 Rossignol District Snowboard',
            'category' => 'Доски и лыжи',
            'cost' => 10999,
            'img_url' => 'img/lot-1.jpg',
            'expiration_date' => '2019-11-05'
        ],
        [
            'name' => 'DC Ply Mens 2016/2017 Snowboard',
            'category' => 'Доски и лыжи',
            'cost' => 159999,
            'img_url' => 'img/lot-2.jpg',
            'expiration_date' => '2019-11-03'
        ],
        [
            'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
            'category' => 'Крепления',
            'cost' => 8000,
            'img_url' => 'img/lot-3.jpg',
            'expiration_date' => '2019-11-04'
        ],
        [
            'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
            'category' => 'Ботинки',
            'cost' => 10999,
            'img_url' => 'img/lot-4.jpg',
            'expiration_date' => '2019-11-07'
        ],
        [
            'name' => 'Куртка для сноуборда DC Mutiny Charocal',
            'category' => 'Одежда',
            'cost' => 7500,
            'img_url' => 'img/lot-5.jpg',
            'expiration_date' => '2019-11-08'
        ],
        [
            'name' => 'Маска Oakley Canopy',
            'category' => 'Разное',
            'cost' => 5400,
            'img_url' => 'img/lot-6.jpg',
            'expiration_date' => '2019-11-01'
        ]
    ];

    function getFinancialFormat($cost){
        return number_format(ceil($cost), 0 , "." , " "  ). ' ₽';
    }

    function getDateRange($exp_date) {
        date_default_timezone_set('Europe/Moscow');
        $lot_time = strtotime($exp_date);
        $cur_date = time();
        $diff = ($lot_time - $cur_date);

        if ($diff > 0) {
            $hours = floor($diff / 3600);
            $minutes = (floor($diff / 60)) - ($hours * 60);

            if ($hours == 0) {
                $exp_time = [
                    'time' => '00'.':'.$minutes,
                    'use_timer_finishing' => true
                ];
            }
            else {
                $exp_time = [
                    'time' => $hours.':'.$minutes,
                    'use_timer_finishing' => false
                ];
            }
        } else {
            $exp_time = [
                'time' => '00'.':'.'00',
                'use_timer_finishing' => true
            ];
        }
        return($exp_time);
    }

    require_once('helpers.php');

    $main_content = include_template('main.php', ['categories' => $categories, 'advertisements' => $advertisements]);
    $layout_content = include_template('layout.php',['categories' => $categories, 'main_content' => $main_content, 'page_title' => 'Главная']);
    print($layout_content);
?>