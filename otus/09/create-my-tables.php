<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('ДЗ Создание своих таблиц БД и написание модели данных к ним');


use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Application;
use \Bitrix\Main\Lib\DB\Connection;

// define("NO_KEEP_STATISTIC", true);
// define("NOT_CHECK_PERMISSIONS",true);
// define("BX_NO_ACCELERATOR_RESET", true);
// define("BX_CRONTAB", true);
// define("STOP_STATISTICS", true);
// define("NO_AGENT_STATISTIC", "Y");
// define("DisableEventsCheck", true);
// define("NO_AGENT_CHECK", true);


$connect = Application::getConnection();
//$tableName = 'my_table_scorecars';
$tableName = 'certificates_table';

//Создание таблицы сертификатов
 $sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (
    ID int NOT NULL AUTO_INCREMENT,
    NUM_CERT varchar(100), 
    TYPE_CERT tinyint,
    DATE_OUT Date,
    ACIVE bool,
    PRIMARY KEY (ID_CERT)
    );';
if ($connect) {
    $connect->queryExecute($sql);
    echo ('Таблица '.$tableName.' создана');
} else {
    echo ('Ошибка создания таблицы '.$tableName);
} 

//Создание таблицы связи ManyToMany ИС-сертификаты
$tableName = 'is_certificates';
$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (
    ID_IS int NOT NULL,
    ID_CERT int NOT NULL,
    PRIMARY KEY (ID_IS, ID_CERT)
    );';
if ($connect) {
    $connect->queryExecute($sql);
    echo ('Таблица '.$tableName.' создана');
} else {
    echo ('Ошибка создания таблицы '.$tableName);
} 

//Создание таблицы связи ManyToMany Пользователи-сертификаты
$tableName = 'users_certificates';
$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (
    ID_USER int NOT NULL,
    ID_CERT int NOT NULL,
    PRIMARY KEY (ID_USER, ID_CERT)
    );';
if ($connect) {
    $connect->queryExecute($sql);
    echo ('Таблица '.$tableName.' создана');
} else {
    echo ('Ошибка создания таблицы '.$tableName);
} 

?>