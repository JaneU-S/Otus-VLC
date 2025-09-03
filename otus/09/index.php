<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->SetTitle('Many To Many. Привязка сертификатов к ИС');
echo "<link rel='stylesheet' href='style.css'>";

use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Query;
use Models\Lists\CertificatesTable;

if (!Loader::includeModule('iblock')) {
    return;
}

$q = new Query(CertificatesTable::class);
$q->setSelect([
    'ID',
    'NUM_CERT',
    'TYPE_CERT',
    'DATE_OUT',
    'ACIVE',
    'Is_Name' => 'is_certificates.NAME', // Название информационной системы к которй прикреплен сертификат
    'Is_UserName' => 'users_cert.NAME',  // Пользователь от имени которого выпущен сертификат

    //'ACT_NAME'  => 'is_certificates.ELEMENT.NOTE',
]);

$q->setOrder('Is_Name');  // Группируем по названию ИС
$q->setCacheTtl(3600); // Включает кеш
$q->cacheJoins(true);
$result = $q->exec();

echo '<table class=\'table\'>
<thead>
<tr>
<th>Информационная система</th>
<th>SN сертификата</th>
<th>Дата окончания</th>
<th>Тип сертификата</th>
</tr>
</thead>
<tbody>';
while ($arItem = $result->fetch()) {
    // определяем тип сертификата
    if ($arItem['TYPE_CERT']==1) {
        $typeCert='TLS';
    } elseif  ($arItem['TYPE_CERT']==2) {
        $typeCert='ЭП-ОВ';
    } else {
        $typeCert='ЭП-ФЛ';
    }

    // $typeCert= ($a ==1 ? 'TLS' : (($a ==2 ? 'ЭП-ОВ' : 'ЭП-ФЛ')));

    echo '<tr :nth-child><td>'.$arItem['Is_Name'].'</td><td>'.$arItem['NUM_CERT'].'<br>Прикреплен к '.$arItem['Is_UserName'].'</td><td>'.$arItem['DATE_OUT'].'</td><td>'.$typeCert.'</td></tr>';
}
echo '</tbody></table>';




require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');

?>