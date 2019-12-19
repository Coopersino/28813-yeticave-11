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

    $catIds = [];
    $catIds = array_column($categories, 'id');

    function dbInsertData($link, $sql, $data = []) {
        $stmt = db_get_prepare_stmt($link, $sql, $data);
        $result = mysqli_stmt_execute($stmt);
        return ($result) ? mysqli_insert_id($link) : mysqli_error($link);
    }

    function dbFetchFirstElement($link, $sql, $data = []) {
        $stmt = db_get_prepare_stmt($link, $sql, $data);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        return ($res) ? mysqli_fetch_assoc($res) : mysqli_error($link);
    }

?>