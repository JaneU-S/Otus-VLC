<?php
if (php_sapi_name() != 'cli')
{
    die();
}

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_NO_ACCELERATOR_RESET", true);
define("BX_CRONTAB", true);
define("STOP_STATISTICS", true);
define("NO_AGENT_STATISTIC", "Y");
define("DisableEventsCheck", true);
define("NO_AGENT_CHECK", true);

$_SERVER['DOCUMENT_ROOT'] = realpath('/home/bitrix/www');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

//title: Создание таблицы на основе ORM класса

use Bitrix\Main\Entity\Base;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Otus\Orm\BookTable;
use Otus\Orm\AuthorTable;
use Otus\Orm\PublisherTable;

$entities = [
	AuthorTable::class,
	BookTable::class,
	PublisherTable::class,
];

foreach ($entities as $entity) {
	if (!Application::getConnection($entity::getConnectionName())->isTableExists($entity::getTableName())) {
		Base::getInstance($entity)->createDbTable();
	}
}

$connection = Application::getConnection();

$tableName = 'aholin_book_author';

if (!$connection->isTableExists($tableName)) {
	$connection->queryExecute("
		CREATE TABLE {$tableName} (
			BOOK_ID int NOT NULL,
			AUTHOR_ID int NOT NULL,
			PRIMARY KEY (BOOK_ID, AUTHOR_ID)
		)
	");
}
$tableName = 'aholin_doctor_recommends';

if (!$connection->isTableExists($tableName)) {
	$connection->queryExecute("
		CREATE TABLE {$tableName} (
			BOOK_ID int NOT NULL,
			DOCTOR_ID int NOT NULL,
			PRIMARY KEY (BOOK_ID, DOCTOR_ID)
		)
	");
}
$tableName = 'aholin_book_specialization';

if (!$connection->isTableExists($tableName)) {
	$connection->queryExecute("
		CREATE TABLE {$tableName} (
			BOOK_ID int NOT NULL,
			SPEC_ID int NOT NULL,
			PRIMARY KEY (BOOK_ID, SPEC_ID)
		)
	");
}
