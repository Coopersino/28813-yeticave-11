<?php
require_once('init.php');
require_once('helpers.php');
require_once('functions.php');
require_once('dataBaseQueries.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = ['email', 'password'];

    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Заполните это поле';
        }
        $form[$field] = trim($form[$field]);
    }

    $safeEmail = mysqli_real_escape_string($connect, $form['email']);

    $sql = "SELECT * FROM users WHERE email = '" . $safeEmail . "'";
    $result = mysqli_query($connect, $sql);
    $user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;

    if (!count($errors)) {

        if (password_verify($form['password'], $user['user_password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Вы ввели неправильный логин/пароль';
        }

        if (mysqli_num_rows($result) === 0) {
            $errors['email'] = 'Такой пользователь не найден';
        }
    }
}

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit();
}

$menu = include_template('navMenu.php', ['categories' => $categories]);

$addContent = include_template('loginTmp.php', [
    'navMenu' => $menu,
    'errors' => $errors
]);

$layoutContent = include_template('layout.php', [
    'mainContent' => $addContent,
    'pageTitle' => 'Вход',
    'categories' => $categories,
    'userName' => $userName
]);

print ($layoutContent);
?>