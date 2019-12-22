<?php
    $advertId = filter_input(INPUT_GET, 'id');

    if (isset($advertId)) {
        require_once('init.php');
        require_once('helpers.php');
        require_once('functions.php');
        require_once('dataBaseQueries.php');

        $advertQueryById = 'SELECT advs.adv_name, advs.cost, advs.rate_step, advs.img_url, advs.description, advs.expiration_date, cat.categor_name
                        FROM advertisements advs
                        INNER JOIN categories cat
                        ON advs.category_id = cat.id
                        WHERE advs.id = ' . $advertId;

        $advertisement = getFirstElementOnDb($connect, $advertQueryById);

        $ratesQueryMax = 'SELECT MAX(rate_value) FROM rates WHERE advert_id = ' . $advertId;
        $result = mysqli_query($connect, $ratesQueryMax);
        $maxRate = $result ? mysqli_fetch_array($result, MYSQLI_NUM) : null;
        $minRate = empty($maxRate[0]) ? ($advertisement['cost'] + $advertisement['rate_step']) : ($maxRate[0] + $advertisement['rate_step']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newRate = $_POST;

            if (empty($newRate['cost'])) {
                $errors['cost'] = 'Сделайте ставку';
            } elseif (!filter_var($newRate['cost'], FILTER_VALIDATE_INT)) {
                $errors['cost'] = 'Введите целое число';
            } elseif ($newRate['cost'] < $minRate) {
                $errors['cost'] = 'Значение должно быть больше';
            } else {
                $errors['cost'] = numberIsValid($newRate['cost']);
            }

            $errors = array_filter($errors);
            $newRate['cost'] = trim($newRate['cost']);
            $newRate['lot_id'] = $advertId;
            $newRate['user_id'] = $_SESSION['user']['id'];

            if (!count($errors)) {
                $insertRate = 'INSERT INTO rates (rate_value, advert_id, user_id)
                VALUES (?, ?, ?)';
                insertDataInDb($connect, $insertRate, $newRate);
            }
        }

        $sql = 'SELECT rts.dt_add, rts.rate_value, u.user_name
            FROM rates rts
            INNER JOIN users u
            ON rts.user_id = u.id
            WHERE rts.advert_id = ' . $advertId . ' ORDER BY rts.dt_add DESC';

        $rate_data = getAllDataOnDb($connect, $sql);
        $count_rates = count($rate_data);

        $sql = 'SELECT adv.id, rts.user_id FROM advertisements adv
            INNER JOIN (SELECT advert_id, MAX(rate_value) max_rate FROM rates GROUP BY advert_id) rates
            ON adv.id = rates.advert_id
            INNER JOIN rates rts
            ON adv.id = rts.advert_id AND rts.rate_value = rates.max_rate
            where adv.id = ' . $advertId;

        $lastRate = getFirstElementOnDb($connect, $sql);

        if ($advertisement) {
            $mainContent = include_template('lotTmp.php', [
                'advertisement' => $advertisement,
                'categories' => $categories,
                'min_rate' => $minRate,
                'max_rate' => $maxRate[0],
                'rate_data' => $rate_data,
                'errors' => $errors,
                'count_rates' => $count_rates,
                'last_rate' => $lastRate
            ]);

            $layoutContent = include_template('layout.php', [
                'categories' => $categories,
                'main_content' => $mainContent,
                'page_title' => 'Главная',
                'user_name' => $user_name
            ]);

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