<?php
require_once('init.php');
require_once('helpers.php');
require_once('functions.php');
require_once('dataBaseQueries.php');

$user_name = $_SESSION['user']['user_name'] ?? '';

if (isset($_SESSION['user'])) {
    $sql = 'SELECT adv.id lotid, adv.img_url lot_image, adv.adv_name lot_title, adv.expiration_date lot_end_date, adv.winner_id winner, adv.dt_add, cat.categor_name category_title, rts.dt_add creation_rate, rts.rate_value rate_price, u.contacts user_contacts from rates rts
                INNER JOIN advertisements adv ON adv.id = rts.advert_id
                INNER JOIN categories cat ON adv.category_id = cat.id
                INNER JOIN users u ON rts.user_id = u.id
                WHERE rts.user_id =' . $_SESSION['user']['id'];

    $stmt = db_get_prepare_stmt($connect, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : die('Ошибка соединения с БД');

    if ($result) {
        $menu = include_template('navMenu.php', ['categories' => $categories]);

        $rates_content = include_template('myBetsTmp.php', [
            'rates_result' => $result,
            'nav_menu' => $menu
        ]);

        $layout_content = include_template('layout.php', [
            'main_content' => $rates_content,
            'title' => 'Мои ставки',
            'categories' => $categories,
            'user_name' => $user_name
        ]);
        print ($layout_content);
    }
} else {
    http_response_code(404);
}
?>