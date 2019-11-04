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
            'expiration_date' => '2019-11-06'
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

    function getDateRange($expDate)
    {
        $lotTime = strtotime($expDate);
        $curDate = time();
        $diff = ($lotTime - $curDate);

        if ($diff > 0) {
            $hours = floor($diff / 3600);
            $minutes = (floor($diff / 60)) - ($hours * 60);

        } else {
            $hours = 0;
            $minutes = 0;
        }

        return (
        $exp_time = [
            'hours' => $hours,
            'minutes' => $minutes
        ]
        );
    }

    require_once('helpers.php');

    $main_content = include_template('main.php', ['categories' => $categories, 'advertisements' => $advertisements]);
    $layout_content = include_template('layout.php',['categories' => $categories, 'main_content' => $main_content, 'page_title' => 'Главная']);
    print($layout_content);
?>