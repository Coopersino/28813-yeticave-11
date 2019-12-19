<?php
    require_once('init.php');
    require_once('helpers.php');
    require_once('functions.php');
    require_once('dataBaseQueries.php');

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-date', 'lot-step'];
        $validMime = ['image/jpeg', 'image/png'];
        $rules = [
            'lot-name' => function ($value) {
                return lengthIsValid($value, 3, 200);
            },
            'category' => function ($value) use ($catIds) {
                return categoryIsValid($value, $catIds);
            },
            'message' => function ($value) {
                return lengthIsValid($value, 3, 3000);
            },
            'lot-rate' => function ($value) {
                return numberIsValid($value);
            },
            'lot-date' => function ($value) {
                return dateIsValid($value);
            },
            'lot-step' => function ($value) {
                return numberIsValid($value);
            }
        ];

        $newLot = filter_input_array(INPUT_POST, [
            'lot-name' => FILTER_DEFAULT,
            'message' => FILTER_DEFAULT,
            'category' => FILTER_DEFAULT,
            'lot-date' => FILTER_DEFAULT,
            'lot-rate' => FILTER_DEFAULT,
            'lot-step' => FILTER_DEFAULT
        ], true);

        foreach ($newLot as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $errors[$key] = $rule($value);
            }

            if (in_array($key, $required) && empty($value)) {
                $errors[$key] = "Поле не заполнено";
            }
        }

        $errors = array_filter($errors);
        if (!empty($_FILES['jpg_img']['name'])) {
            $tmpName = $_FILES['jpg_img']['tmp_name'];
            $fileName = $_FILES['jpg_img']['name'];
            $fileType = mime_content_type($tmpName);

            if (!in_array($fileType, $validMime)) {
                $errors['jpg_img'] = 'Поддерживаются форматы картинок JPG, JPEG, PNG';
            }

        } else {
            $errors['jpg_img'] = 'Файл не загружен';
        }

        if (count($errors)) {
            $addContent = include_template('add_template.php', ['errors' => $errors, 'categories' => $categories]);
        } else {
            move_uploaded_file($_FILES['jpg_img']['tmp_name'], 'uploads/' . $fileName);
            $newLot['path'] = $fileName;
            $sql = "SELECT id FROM categories WHERE categor_name = '" . $newLot['category']."'";
            $cat_id = dbFetchFirstElement($connect, $sql);
            $newLot['username'] = 1;
            $newLot['winer'] = 100;
            $sql = 'INSERT INTO advertisements (adv_name, description, category_id, expiration_date , cost, rate_step, img_url, autor_id, winner_id ) VALUES (?,?,?,?,?,?,?,?,?)';
            $result = dbInsertData($connect, $sql, $newLot);

            if ($result) {
                $lotId = mysqli_insert_id($connect);
                header("Location: lot.php?id=" . $lotId);
            }
        }
    }

    $addContent = include_template('addLot.php', ['errors' => $errors, 'categories' => $categories]);

    $layoutContent = include_template('layout.php', [
        'main_content' => $addContent,
        'page_title' => 'Добавление лота',
        'categories' => $categories,
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

    print($layoutContent);
?>