<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->IncludeComponent(
    'otus:currencies',
    '.default',
    [
        'CACHE_TIME' => '3600',
        'CACHE_TYPE' => 'A',
        'CURRENCY' => 'USD',
    ]


);
?>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
?>