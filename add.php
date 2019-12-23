<?php
require_once('init.php');
require_once('helpers.php');
require_once('functions.php');
require_once('dataBaseQueries.php');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-date', 'lot-step', 'jpg-img'];
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

        $newLot['path'] = 'uploads/' . $fileName;
        $sql = "SELECT id FROM categories WHERE categor_name = '" . $newLot['category'] . "'";
        $catId = getFirstElementOnDb($connect, $sql);
        $newLot['username'] = $_SESSION['user']['id'];
        $sql = 'INSERT INTO advertisements (adv_name, description, category_id, expiration_date , cost, rate_step, img_url, autor_id ) VALUES (?,?,?,?,?,?,?,?)';
        $result = insertDataInDb($connect, $sql, $newLot);

        if ($result) {
            $lotId = mysqli_insert_id($connect);
            header("Location: lot.php?id=" . $lotId);
        }
    }
}

$menu = include_template('navMenu.php', ['categories' => $categories]);

$addContent = include_template('addLot.php', [
    'errors' => $errors,
    'categories' => $categories,
    'navMenu' => $menu
]);

$layoutContent = include_template('layout.php', [
    'mainContent' => $addContent,
    'pageTitle' => 'Добавление лота',
    'categories' => $categories,
//    'isAuth' => $isAuth,
    'userName' => $userName
]);

print($layoutContent);
?>