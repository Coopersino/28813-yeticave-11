<?php
    function getFinancialFormat($cost) {
        return number_format(ceil($cost), 0, ".", " ") . ' ₽';
    }

    function getDateRange($expDate) {
        $lotTime = strtotime($expDate);
        $curDate = time();
        $diff = ($lotTime - $curDate);

        if ($diff > 0) {
            $hours = floor($diff / 3600);
            $minutes = (floor($diff / 60)) - ($hours * 60);

        } else {
            $hours = 0;
            $minutes = 0;
        }

        return (['hours' => $hours, 'minutes' => $minutes, 'seconds'=> $seconds]);
    }

    function numberIsValid($value) {
        return (!empty($value) && $value <= 0) ? 'Введите значение больше нуля' : null;
    }

    function dateIsValid($value) {
        $daySeconds = 86400;
        if ($value) {
            if (date('Y-m-d', strtotime($value)) !== $value) {
                return "Неверная дата";
            }
            $timeStampDiff = strtotime($value) - time();
            if ($timeStampDiff < $daySeconds) {
                return "Введенная дата меньше текущей даты";
            }
        }

        return null;
    }

    function lengthIsValid($value, $min, $max) {
        return (strlen($value) < $min or strlen($value) > $max) ? 'Введите значение от '.$min.'до'.$max.' символов' : null;
    }

    function categoryIsValid($id, $allowedList) {
        return !in_array($id, $allowedList) ? 'Неверная категория' : null;
    }

    function emailIsValid($value) {
        return !filter_var($value, FILTER_VALIDATE_EMAIL) ? 'Введите корректный email' : null;
    }

    function getFirstElementOnDb($link, $sqlQuery, $data = []) {
        $stmt = db_get_prepare_stmt($link, $sqlQuery, $data);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return ($result) ? mysqli_fetch_assoc($result) : die('Ошибка соединения с БД');
    }

    function getAllDataOnDb($link, $sqlQuery, $data = []) {
        $stmt = db_get_prepare_stmt($link, $sqlQuery, $data);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return ($result) ? mysqli_fetch_all($result, MYSQLI_ASSOC) : die('Ошибка соединения с БД');
    }

    function insertDataInDb($link, $sqlQuery, $data = []) {
        $stmt = db_get_prepare_stmt($link, $sqlQuery, $data);
        $result = mysqli_stmt_execute($stmt);
        return ($result) ? mysqli_insert_id($link) : die('Ошибка соединения с БД');
    }

    function dateToHumanFormat($value) {
        setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
        $hourSecond = 3600;
        $timestampDiff = time() - strtotime($value);
        $minutes = ltrim(strftime('%M ', $timestampDiff), '0');

        if (($timestampDiff > 60) && ($timestampDiff < $hourSecond)) {
            return $minutes . get_noun_plural_form(strftime('%M', $timestampDiff), 'минута', 'минуты', 'минут') . ' назад';
        } else {

            if ($timestampDiff < 60) {
                return 'только что';
            } else {

                if ($timestampDiff === $hourSecond) {
                    return 'Час назад';
                }
            }
        }

        return strftime('%d.%m.%y в %H:%M', strtotime($value));
    }
?>
