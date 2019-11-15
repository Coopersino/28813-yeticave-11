<?php
    require_once('init.php');

    $categorQuery = 'SELECT `id`, `categor_name`, `categor_code` FROM categories ';
    $result = mysqli_query($connect, $categorQuery);
    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        printf("Ошибка: %s\n", mysqli_error($connect));
    }

    $advertQuery = 'SELECT advs.id, advs.adv_name, advs.cost, advs.img_url, advs.dt_add, advs.expiration_date, categories.categor_name FROM advertisements advs JOIN categories ON categories.id = advs.category_id ORDER BY dt_add DESC LIMIT 9';
    $result = mysqli_query($connect, $advertQuery);
    if ($result) {
        $advertisements = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        printf("Ошибка: %s\n", mysqli_error($connect));
    }
?>