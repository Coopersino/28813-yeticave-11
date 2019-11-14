<?php
    $connect = mysqli_connect("localhost", "root", "", "yeticave_base");
    mysqli_set_charset($connect, "utf-8");

    if ($connect) {
        $categorQuery = 'SELECT `id`, `categor_name`, `categor_code` FROM categories ';
        $result = mysqli_query($connect, $categorQuery);
        if ($result) {
            $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            printf("Ошибка: %s\n", mysqli_error($connect));
        }
        $advertQuery = 'SELECT adv_name, cost, img_url, dt_add, expiration_date, categories.categor_name FROM advertisements JOIN categories ON categories.id = advertisements.category_id ORDER BY dt_add DESC LIMIT 9';
        $result = mysqli_query($connect, $advertQuery);
        if ($result) {
            $advertisements = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            printf("Ошибка: %s\n", mysqli_error($connect));
        }
    } else {
        printf("Соединение не удалось: %s\n", mysqli_connect_error());
        exit();
    }
?>