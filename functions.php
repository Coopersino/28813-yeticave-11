<?php
/**
 * Преобразует цену в финансовый формат
 * @param int $cost Значение цены
 * @return string Преобразованная цена
 */
function getFinancialFormat($cost)
{
    return number_format(ceil($cost), 0, ".", " ") . ' ₽';
}

/**
 * Возвращает оставшееся время
 * @param int $expDate дата истечения срока
 * @return array возвращает оставшееся время
 */
function getDateRange($expDate)
{
    $lotTime = strtotime($expDate);
    $curDate = time();
    $diff = ($lotTime - $curDate);

    if ($diff > 0) {
        $hours = floor($diff / 3600);
        $minutes = (floor($diff / 60)) - ($hours * 60);
        $seconds = $diff % 60;

    } else {
        $hours = 0;
        $minutes = 0;
        $seconds = 0;
    }

    return (['hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds]);
}

/**
 * Проверяет значение (значение должно быть больше ноля)
 * @param int $number Число
 * @return string Возвращает ошибку
 */
function numberIsValid($number)
{
    return (!empty($number) && $number <= 0) ? 'Введите значение больше ноля' : null;
}

/**
 * Проверяет веденное значение даты (введенная дата должна быть больше текущей даты)
 * @param string $date Строка
 * @return string Возвращает ошибку
 */
function dateIsValid($date)
{
    $daySeconds = 86400;
    if ($date) {
        if (date('Y-m-d', strtotime($date)) !== $date) {
            return "Неверный формат даты";
        }
        $timeStampDiff = strtotime($date) - time();
        if ($timeStampDiff < $daySeconds) {
            return "Введенная дата меньше текущей даты";
        }
    }

    return null;
}

/**
 * Проверяет длину введенной строки (в диапазоное от min до max)
 * @param string $strLength Строка
 * @param int $min Минимальное число символов
 * @param int $max Максимальное число символов
 * @return string Возвращает ошибку
 */
function lengthIsValid($strLength, $min, $max)
{
    return (strlen($strLength) < $min or strlen($strLength) > $max) ? 'Введите значение в диапазоне от ' . $min . 'до' . $max . ' символов' : null;
}

/**
 * Проверяет правильность категории
 * @param int $categoryID категория (id)
 * @param array $categoriesList массив категорий
 * @return string возвращает ошибку
 */
function categoryIsValid($categoryID, $categoriesList)
{
    return !in_array($categoryID, $categoriesList) ? 'Неверная категория' : null;
}

/**
 * Проверяет введенный email на соответствие формату
 * @param string $email
 * @return string возвращает ошибку
 */
function emailIsValid($email)
{
    return !filter_var($email, FILTER_VALIDATE_EMAIL) ? 'Введите корректный email' : null;
}

/**
 * Выполняет запрос к БД через подготовленные выражения и возвращает результат
 * @param mysqli $link ресурс соединения
 * @param string $sqlQuery запрос с плейсхолдерами
 * @param array $data значения для плейсхолдеро
 * @return array возвращает ассоциативный массив
 */
function getFirstElementOnDb($link, $sqlQuery, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sqlQuery, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return ($result) ? mysqli_fetch_assoc($result) : die('Ошибка соединения с БД');
}

/**
 * Выполняет запрос к БД через подготовленные выражения и возвращает результат
 * @param mysqli $link ресурс соединения
 * @param string $sqlQuery запрос с плейсхолдерами
 * @param array $data значения для плейсхолдеров
 * @return array возвращает все полученные данные по запросу
 */
function getAllDataOnDb($link, $sqlQuery, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sqlQuery, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return ($result) ? mysqli_fetch_all($result, MYSQLI_ASSOC) : die('Ошибка соединения с БД');
}

/**
 * Выполняет запрос к БД через подготовленные выражения и возвращает id запроса
 * @param mysqli $link ресурс соединения
 * @param string $sqlQuery запрос с плейсхолдерами
 * @param array $data значения для плейсхолдеров
 * @return int возвращает id запроса
 */
function insertDataInDb($link, $sqlQuery, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sqlQuery, $data);
    $result = mysqli_stmt_execute($stmt);
    return ($result) ? mysqli_insert_id($link) : die('Ошибка соединения с БД');
}

/**
 * Преобразует введенную дату в строковый формат
 * @param string $date Дата
 * @return string возвращает отформатированную дату
 */
function dateToStringFormat($date)
{
    setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
    $hourSecond = 3600;
    $timestampDiff = time() - strtotime($date);
    $minutes = ltrim(strftime('%M ', $timestampDiff), '0');

    if ($timestampDiff < 60) {
        return 'только что';
    }

    if (($timestampDiff > 60) && ($timestampDiff < $hourSecond)) {
        return $minutes . get_noun_plural_form(strftime('%M', $timestampDiff), 'минута', 'минуты', 'минут') . ' назад';
    }

    if ($timestampDiff === $hourSecond) {
        return 'Час назад';
    }

    return strftime('%d.%m.%y в %H:%M', strtotime($date));
}

?>