<?php
require_once('vendor/autoload.php');
require_once('init.php');
require_once('functions.php');

$transport = new Swift_SmtpTransport('phpdemo.ru', 25);
$transport->setUsername('keks@phpdemo.ru');
$transport->setPassword('htmlacademy');
$mailer = new Swift_Mailer($transport);
$message = new Swift_Message();
$message->setSubject('Ваша ставка победила');
$message->setFrom(['keks@phpdemo.ru']);

$sql = 'SELECT adv.id, adv.adv_name, rts.user_id winner_id, u.user_name winner_name, u.email winner_email FROM advertisements adv
                INNER JOIN (SELECT advert_id, MAX(rate_value) max_rate FROM rates GROUP BY advert_id) rates
                    ON adv.id = rates.advert_id
                INNER JOIN rates rts
                    ON adv.id = rts.advert_id AND rts.rate_value = rates.max_rate
                INNER JOIN users u
                    ON u.id = rts.user_id
                WHERE adv.expiration_date <= NOW()
                    AND adv.winner_id IS NULL
                    AND rates.max_rate IS NOT null';

$winnersResult = getAllDataOnDb($connect, $sql);

foreach ($winnersResult as $item) {
    $updateLot = 'UPDATE advertisements SET winner_id = ' . $item['winner_id'] . ' WHERE id = ' . $item['id'];
    mysqli_query($connect, $updateLot);

    $message->addTo($item['winner_email'], $item['winner_name']);
    $mailData = include_template('email.php', [
        'winnerName' => $item['winner_name'],
        'lotUrl' => 'lot.php?id=' . $item['id'],
        'ratesUrl' => 'myBets.php',
        'lotTitle' => $item['title']
    ]);
    $message->setBody($mailData, 'text/html');
    $mailer->send($message);
}
?>