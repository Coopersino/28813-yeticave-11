<?php
    $advertId = filter_input(INPUT_GET, 'id');

    if (isset($advertId)) {
        require_once('init.php');
        require_once('helpers.php');
        require_once('functions.php');
        require_once('dataBaseQueries.php');

        $advertQueryById = "SELECT advs.adv_name, advs.cost, advs.img_url, advs.description, advs.expiration_date, cat.categor_name
                        FROM advertisements advs
                        INNER JOIN categories cat
                        ON advs.category_id = cat.id
                        WHERE advs.id = ?";

        $stmt = mysqli_prepare($connect, $advertQueryById);
        mysqli_stmt_bind_param($stmt, 'i', $advertId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $advertisement = mysqli_fetch_assoc($result);
        } else {
            printf("Ошибка: %s\n", mysqli_error($connect));
        }

        if ($advertisement) {
            $mainContent = include_template('lotTmp.php', ['advertisement' => $advertisement, 'categories' => $categories]);
            $layoutContent = include_template('layout.php', ['categories' => $categories, 'main_content' => $mainContent, 'page_title' => 'Главная']);
            print($layoutContent);
        } else {
            http_response_code(404);
            print('Объявление не найдено');
        }

    } else {
        http_response_code(404);
        print('Неверный параметр в запросе');
    }
?>