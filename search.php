<?php
require_once('init.php');
require_once('helpers.php');
require_once('functions.php');
require_once('dataBaseQueries.php');

$search = $_GET['search'] ?? '';
$userName = $_SESSION['user']['user_name'] ?? '';
$filename = basename(__FILE__);
$itemsCount = 0;
$PAGE_ITEMS = 9;
$CURRENT_PAGE = $_GET['page'] ?? 1;
$offset = ($CURRENT_PAGE - 1) * $PAGE_ITEMS;

if (!empty($search)) {
    $search = trim($search);
    $safeSearch = mysqli_real_escape_string($connect, $search);
    $countSql = mysqli_query($connect, 'SELECT COUNT(*) as cnt FROM advertisements WHERE MATCH(adv_name, description) AGAINST("' . $safeSearch . '") AND expiration_date > NOW()');

    $itemsCount = mysqli_fetch_assoc($countSql)['cnt'];

    $sql = 'SELECT id, adv_name, cost, img_url, rate_step, expiration_date FROM advertisements WHERE MATCH(adv_name, description) AGAINST(?) AND expiration_date > NOW() ORDER BY dt_add ASC LIMIT ' . $PAGE_ITEMS . ' OFFSET ' . $offset;

    $stmt = db_get_prepare_stmt($connect, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : die('Ошибка соединения с БД');

} else {
    $result = '';
}
$pagesCount = ceil($itemsCount / $PAGE_ITEMS);
$pages = range(1, $pagesCount);

$menu = include_template('navMenu.php', ['categories' => $categories]);

$pagination = include_template('pagination.php', [
    'pages' => $pages,
    'pagesCount' => $pagesCount,
    'currentPage' => $CURRENT_PAGE,
    'filename' => $filename,
    'search' => $search
]);

$mainContent = include_template('searchTmp.php', [
    'search' => $search,
    'advertisements' => $result,
    'navMenu' => $menu,
    'pagination' => $pagination
]);

$layoutContent = include_template('layout.php', [
    'mainContent' => $mainContent,
    'title' => 'Результаты поиска',
    'categories' => $categories,
    'userName' => $userName
]);

print ($layoutContent);
?>