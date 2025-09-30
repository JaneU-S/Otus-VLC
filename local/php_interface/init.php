<?
// автолоадер проекта
include_once __DIR__ . '/../app/autoload.php';

// вывод данных 
function pr($var, $type = false) {
    echo '<pre style="font-size:10px; border:1px solid #000; background:#FFF; text-align:left; color:#000;">';
    if ($type)
        var_dump($var);
    else
        print_r($var);
    echo '</pre>';
}

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();


// обработчик событий инфоблока// 
$eventManager->addEventHandler("iblock", "OnBeforeIBlockElementUpdate", ['Events\IblockHandler', 'onElementBeforeUpdate']);
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", ['Events\IblockHandler', 'onElementAfterUpdate']);


// обработчик событий CRM
$eventManager->addEventHandler("crm", "OnAfterCrmDealUpdate", ['Events\CrmHandler', 'OnAfterDealUpdate']);
//$eventManager->addEventHandler("crm", "OnBeforeCrmDealUpdate", ['Events\CrmHandler', 'OnBeforeDealUpdate']);
