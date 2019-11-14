<?php
    $is_auth = rand(0, 1);
    $user_name = 'Виталий'; // укажите здесь ваше имя

    require_once('dataBaseQueries.php');

    function getFinancialFormat($cost)
    {
        return number_format(ceil($cost), 0, ".", " ") . ' ₽';
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

        return (['hours' => $hours, 'minutes' => $minutes]);
    }

    require_once('helpers.php');

    $main_content = include_template('main.php', ['categories' => $categories, 'advertisements' => $advertisements]);
    $layout_content = include_template('layout.php', ['categories' => $categories, 'main_content' => $main_content, 'page_title' => 'Главная']);
    print($layout_content);
?>