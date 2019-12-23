<?php
require_once('init.php');
require_once('helpers.php');
require_once('functions.php');
require_once('dataBaseQueries.php');

if (isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['email', 'password', 'name', 'message'];
    $rules = [
        'email' => function ($value) {
            return emailIsValid($value);
        },
        'password' => function ($value) {
            return lengthIsValid($value, 5, 10);
        },
        'name' => function ($value) {
            return lengthIsValid($value, 3, 15);
        },
        'message' => function ($value) {
            return lengthIsValid($value, 10, 300);
        }
    ];

    $newUser = filter_input_array(INPUT_POST, [
        'email' => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT,
        'name' => FILTER_DEFAULT,
        'message' => FILTER_DEFAULT
    ], true);

    foreach ($newUser as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Заполните это поле";
        }
    }
    $safeEmail = mysqli_real_escape_string($connect, $newUser['email']);
    $sql = "SELECT id FROM users WHERE email = '" . $safeEmail . "'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
    }

    $errors = array_filter($errors);

    if (!count($errors)) {
        $newUser['password'] = password_hash($newUser['password'], PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (email, user_password, user_name, contacts)
                    VALUES (?, ?, ?, ?)';
        insertDataInDb($connect, $sql, $newUser);
        header("Location: login.php");
    }
}

$menu = include_template('navMenu.php', ['categories' => $categories]);

$addContent = include_template('signUpUser.php', [
    'errors' => $errors,
    'categories' => $categories,
    'navMenu' => $menu
]);

$layoutContent = include_template('layout.php', [
    'mainContent' => $addContent,
    'pageTitle' => 'Регистрация',
    'categories' => $categories,
    'user_name' => $userName
]);

print ($layoutContent);
?>