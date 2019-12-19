<?php
    $is_auth = rand(0, 1);

    require_once('init.php');
    require_once('dataBaseQueries.php');
    require_once('functions.php');
    require_once('helpers.php');

    $main_content = include_template('main.php', [
        'categories' => $categories,
        'advertisements' => $advertisements
    ]);

    $layoutContent = include_template('layout.php', [
        'categories' => $categories,
        'main_content' => $main_content,
        'page_title' => 'Главная',
        'user_name' => $user_name
    ]);

    print($layoutContent);
?>