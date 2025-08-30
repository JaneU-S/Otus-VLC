<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

//title: Чтение элементов смарт-процесса с фильтрацией по родительской сделке
use Bitrix\Crm\Service\Container;
use Bitrix\Crm\Model\Dynamic\TypeTable;
use Bitrix\Main\Loader;

Loader::includeModule('crm');

$parentDealId = 14;
$filterFields = [
	'PARENT_ID_' . \CCrmOwnerType::Deal => $parentDealId,
];
$selectFields = [
    'ID',
];

/**
* Для сделок, контактов, лидов, компаний, предложений, счетов - \CCrmOwnerType::Company
* Bitrix\Crm\Model\Dynamic\TypeTable - класс для чтения смарт-процесса по его коду (для актов мы создали код - SMART_PROCESS_ACTS)
*/

$entityTypeId = TypeTable::getList([
	'filter' => [
		'CODE' => 'SMART_PROCESS_ACTS',
	],
])->fetch()['ENTITY_TYPE_ID'];

if (!isset($entityTypeId)) {
	return;
}

$factory = Container::getInstance()->getFactory($entityTypeId);

$items = $factory->getItems([
    'filter' => $filterFields,
    'select' => $selectFields,
]);

// FIELD -> getField; SOME_FIELD -> getSomeField; EXTRA_NEW_SUPER_FIELD -> getExtraNewSuperField
// getData() -> преобразует все поля, доступные в выборке в массив
foreach ($items as $item) {
    dump($item->getData());
}

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');