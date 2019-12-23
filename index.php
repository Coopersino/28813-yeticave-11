<?php
require_once('init.php');
require_once('dataBaseQueries.php');
require_once('functions.php');
require_once('helpers.php');
require_once('getWinner.php');

$PAGE_ITEMS = 9;

$sql = 'SELECT id, categor_name, categor_code FROM categories';
$categoryIds = array_column(getAllDataOnDb($connect, $sql), 'id');

if(isset($_GET['id'])) {
    $safeSId = mysqli_real_escape_string($connect, $_GET['id']);
    $ids = $safeSId ?? implode(', ', $categoryIds);
}
else {
    $ids = (implode(', ', $categoryIds));
}

$CURRENT_PAGE = $_GET['page'] ?? 1;

$offset = ($CURRENT_PAGE - 1) * $PAGE_ITEMS;

$filename = basename(__FILE__);

if (isset($_GET['id'])) {
    $result = mysqli_query($connect, 'SELECT COUNT(*) AS cnt FROM advertisements WHERE expiration_date > NOW() AND category_id =' . $safeSId);
} else {
    $result = mysqli_query($connect, 'SELECT COUNT(*) AS cnt FROM advertisements WHERE expiration_date > NOW()');
}

$itemsCount = mysqli_fetch_assoc($result)['cnt'];

$sql = 'SELECT adv.id, adv.adv_name, adv.cost, adv.img_url, adv.rate_step, adv.expiration_date, cat.categor_name
FROM advertisements adv
    INNER JOIN categories cat
    ON adv.category_id = cat.id
WHERE adv.category_id in (' . $ids . ')
AND expiration_date > NOW()
LIMIT ' . $PAGE_ITEMS . '
OFFSET ' . $offset;

$advertisements = getAllDataOnDb($connect, $sql);
$pagesCount = ceil($itemsCount / $PAGE_ITEMS);
$pages = range(1, $pagesCount);

$parameters = [
    'pages' => $pages,
    'pagesCount' => $pagesCount,
    'currentPage' => $CURRENT_PAGE,
    'filename' => $filename
];

if (isset($_GET['id'])) {
    $parameters['categoryId'] = $_GET['id'];
}

$pagination = include_template('pagination.php', $parameters);

$pageContent = include_template('main.php', [
    'categories' => $categories,
    'advertisements' => $advertisements,
    'categoryId' => isset($_GET['id']),
    'pagination' => $pagination
]);

$layoutContent = include_template('layout.php', [
    'categories' => $categories,
    'mainContent' => $pageContent,
    'pageTitle' => 'Главная',
    'userName' => $userName
]);

print($layoutContent);
?>