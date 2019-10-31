<?php
    $is_auth = rand(0, 1);
    $user_name = 'Виталий'; // укажите здесь ваше имя
    $categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
    $advertisements = [
        [
            'name' => '2014 Rossignol District Snowboard',
            'category' => 'Доски и лыжи',
            'cost' => 10999,
            'img_url' => 'img/lot-1.jpg'
        ],
        [
            'name' => 'DC Ply Mens 2016/2017 Snowboard',
            'category' => 'Доски и лыжи',
            'cost' => 159999,
            'img_url' => 'img/lot-2.jpg'
        ],
        [
            'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
            'category' => 'Крепления',
            'cost' => 8000,
            'img_url' => 'img/lot-3.jpg'
        ],
        [
            'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
            'category' => 'Ботинки',
            'cost' => 10999,
            'img_url' => 'img/lot-4.jpg'
        ],
        [
            'name' => 'Куртка для сноуборда DC Mutiny Charocal',
            'category' => 'Одежда',
            'cost' => 7500,
            'img_url' => 'img/lot-5.jpg'
        ],
        [
            'name' => 'Маска Oakley Canopy',
            'category' => 'Разное',
            'cost' => 5400,
            'img_url' => 'img/lot-6.jpg'
        ]
    ];

    function getFinancialFormat($cost){
        return number_format(ceil($cost), 0 , "." , " "  ). ' ₽';
    }

    require_once('helpers.php');

    $main_content = include_template('main.php', ['categories' => $categories, 'advertisements' => $advertisements]);
    $layout_content = include_template('layout.php',['categories' => $categories, 'main_content' => $main_content, 'page_title' => 'Главная']);
    print($layout_content);
?>