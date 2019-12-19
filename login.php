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

        $sql = "SELECT * FROM users WHERE email = '" . $form['email'] . "'";
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

    $menu = include_template('nav_menu.php', ['
        categories' => $categories
    ]);

    $addContent = include_template('loginTmp.php', ['
        nav_menu' => $menu,
        'errors' => $errors
    ]);

    $layoutContent = include_template('layout.php', [
        'main_content' => $addContent,
        'page_title' => 'Вход',
        'categories' => $categories,
        'user_name' => $user_name
    ]);

    print ($layoutContent);
?>