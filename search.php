<?php
    require_once('init.php');
    require_once('helpers.php');
    require_once('functions.php');
    require_once('dataBaseQueries.php');

    $search = $_GET['search'] ?? '';
    $user_name = $_SESSION['user']['user_name'] ?? '';

    $PAGE_ITEMS = 9;
    $CURRENT_PAGE = 1;
    $offset = ($CURRENT_PAGE - 1) * $PAGE_ITEMS;

    if (!empty($search)) {
        $search = trim($search);

        $countSql = mysqli_query($connect,'SELECT COUNT(*) as cnt FROM advertisements WHERE MATCH(adv_name, description) AGAINST("' . $search . '") AND expiration_date > NOW()');

        $itemsCount = mysqli_fetch_assoc($countSql)['cnt'];

        $sql = 'SELECT id, adv_name, cost, img_url, rate_step, expiration_date FROM advertisements WHERE MATCH(adv_name, description) AGAINST(?) AND expiration_date > NOW() ORDER BY dt_add ASC LIMIT ' . $PAGE_ITEMS . ' OFFSET ' . $offset;

        $stmt = db_get_prepare_stmt($connect, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : die('Ошибка соединения с БД');

    } else {
        $result = '';
    }

    $main_content = include_template('searchTmp.php', [
        'search' => $search,
        'advertisements' => $result
    ]);

    $layoutContent = include_template('layout.php', [
        'main_content' => $main_content,
        'title' => 'Результаты поиска',
        'categories' => $categories,
        'user_name' => $user_name
    ]);

    print ($layoutContent);
?>