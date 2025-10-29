<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Выгрузка в эксель');
$APPLICATION->IncludeComponent('otus:book.grid', '', []);

// $APPLICATION->IncludeComponent('bitrix:u i.sidepanel.wrapper', '', [
//     'POPUP_COMPONENT_NAME' => 'otus:book.grid',
//     'POPUP_COMPONENT_TEMPLATE_NAME' => '',
//     'POPUP_COMPONENT_PARAMS' => [
//         'BOOK_PREFIX' => 'TEST ',
//     ],
// ]);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
