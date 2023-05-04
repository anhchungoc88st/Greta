<h1>Testst unitaires helpers</h1>
<?php
require_once('../controllers/helpers.php');

/*
$date_fr = '20/03/2021';
$date_en = '2021-03-02';
$email = 'aaaa@ffff.net';
$phone = '0606200330';
$zip_code = '06400';
*/

$date_fr = '20-03-2021';
$date_en = '20/03/2021';
$email = 'aaaa@ffff.net.';
$phone = '06062003301';
$zip_code = '064005';


echo $date_fr.' => '.date_fr_to_en($date_fr);
echo '<br>';
echo $date_en.' => '.date_en_to_fr($date_en);

echo '<br>';
if(is_email($email)) echo $email.' est valide'; else echo $email.' est invalide';

echo '<br>';
if(is_phone_number($phone)) echo $phone.' est un numéro valide'; else echo $phone.' est un numéro invalide';

echo '<br>';
if(is_zip_code($zip_code)) echo $zip_code.' est valide'; else echo $zip_code.' est invalide';

?>
