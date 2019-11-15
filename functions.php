<?php
    function getFinancialFormat($cost)
    {
        return number_format(ceil($cost), 0, ".", " ") . ' ₽';
    }

    function getDateRange($expDate)
    {
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

?>