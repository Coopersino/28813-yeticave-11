<?php
    $is_auth = rand(0, 1);
    $user_name = 'Виталий'; // укажите здесь ваше имя

    $connect = mysqli_connect("localhost", "root", "", "yeticave_base");
    mysqli_set_charset($connect, "utf-8");

    if ($connect) {
        $categorQuery = 'SELECT `id`, `categor_name`, `categor_code` FROM categories ';
        $result = mysqli_query($connect, $categorQuery);
        if ($result) {
            $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        else {
            printf("Ошибка: %s\n", mysqli_error($connect));
        }
        $advertQuery = 'SELECT adv_name, cost, img_url, dt_add, expiration_date, categories.categor_name FROM advertisements JOIN categories ON categories.id = advertisements.category_id ORDER BY dt_add DESC LIMIT 9';
        $result = mysqli_query($connect, $advertQuery);
        if ($result) {
            $advertisements = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        else {
            printf("Ошибка: %s\n", mysqli_error($connect));
        }
    }
    else {
        printf("Соединение не удалось: %s\n", mysqli_connect_error());
        exit();
    }

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