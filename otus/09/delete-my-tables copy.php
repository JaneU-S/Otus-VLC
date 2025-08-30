<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('ДЗ Создание своих таблиц БД и написание модели данных к ним');


//use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Application;
use \Bitrix\Main\Lib\DB\Connection;

$connect = Application::getConnection();

//удаление таблиц
$tableName = 'certificates_table';
if ($connect->isTableExists($tableName)) {
    $connect->dropTable($tableName);
    echo ('Таблица '.$tableName.' удалена.');
}
$tableName = 'user_certificates';
if ($connect->isTableExists($tableName)) {
    $connect->dropTable($tableName);
    echo ('Таблица '.$tableName.' удалена.');
}
$tableName = 'is_certificates';
if ($connect->isTableExists($tableName)) {
    $connect->dropTable($tableName);
    echo ('Таблица '.$tableName.' удалена.');
}
?>