<?php
require_once('init.php');
require_once('dataBaseQueries.php');
require_once('functions.php');
require_once('helpers.php');
require_once('getWinner.php');

$PAGE_ITEMS = 9;

$sql = 'SELECT id, categor_name, categor_code FROM categories';
$category_ids = array_column(getAllDataOnDb($connect, $sql), 'id');

$ids = $_GET['id'] ?? implode(', ', $category_ids);

$CURRENT_PAGE = $_GET['page'] ?? 1;

$offset = ($CURRENT_PAGE - 1) * $PAGE_ITEMS;

$filename = basename(__FILE__);

if (isset($_GET['id'])) {
    $result = mysqli_query($connect, 'SELECT COUNT(*) AS cnt FROM advertisements WHERE expiration_date > NOW() AND category_id =' . $_GET['id']);
} else {
    $result = mysqli_query($connect, 'SELECT COUNT(*) AS cnt FROM advertisements WHERE expiration_date > NOW()');
}

$items_count = mysqli_fetch_assoc($result)['cnt'];

$sql = 'SELECT adv.id, adv.adv_name, adv.cost, adv.img_url, adv.rate_step, adv.expiration_date, cat.categor_name adv_title
FROM advertisements adv
    INNER JOIN categories cat
    ON adv.category_id = cat.id
WHERE adv.category_id in (' . $ids . ')
AND expiration_date > NOW()
LIMIT ' . $PAGE_ITEMS . '
OFFSET ' . $offset;

$goods = getAllDataOnDb($connect, $sql);
$pages_count = ceil($items_count / $PAGE_ITEMS);
$pages = range(1, $pages_count);

$parameters = [
    'pages' => $pages,
    'pages_count' => $pages_count,
    'CURRENT_PAGE' => $CURRENT_PAGE,
    'filename' => $filename
];

if (isset($_GET['id'])) {
    $parameters[category_id] = $_GET['id'];
}

$pagination = include_template('pagination.php', $parameters);

$page_content = include_template('main.php', [
    'categories' => $categories,
    'advertisements' => $goods,
    'categoryId' => isset($_GET['id']),
    'pagination' => $pagination
]);

$layoutContent = include_template('layout.php', [
    'categories' => $categories,
    'main_content' => $page_content,
    'page_title' => 'Главная',
    'user_name' => $user_name
]);

print($layoutContent);
?>