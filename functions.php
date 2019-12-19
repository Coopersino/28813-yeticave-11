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

        return (['hours' => $hours, 'minutes' => $minutes]);
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
?>