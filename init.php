<?php
    $connect = mysqli_connect("localhost", "root", "", "yeticave_base");
    mysqli_set_charset($connect, "utf-8");

    if (!$connect) {
        printf("Соединение не удалось: %s\n", mysqli_connect_error());
        exit();
    }
?>