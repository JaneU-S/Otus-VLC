<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Query;
use Otus\Orm\BookTable;

if (!Loader::includeModule('iblock')) {
    return;
}

$q = new Query(BookTable::class);
$q->setSelect([
    'ID',
    'TITLE',
    'YEAR',
    'PUBLISH_DATE',
    'PAGES',
    'DOCTOR_NAME' => 'DOCTOR_RECOMMENDS.NAME',
    'SPEC_NAME' => 'BOOK_SPECIALIZATION.NAME',
    'AUTHOR_NAME' => 'AUTHORS.FIRST_NAME',
    'AUTHOR_LAST_NAME' => 'AUTHORS.LAST_NAME',
    'AUTHOR_SECOND_NAME' => 'AUTHORS.SECOND_NAME',
    'PUBLISHER_NAME' => 'PUBLISHER.TITLE',
]);

$result = $q->exec();
$books = [];

while ($arItem = $result->Fetch()) {
    $bookId = $arItem['ID'];
    
    if (!isset($books[$bookId])) {
        $books[$bookId] = [
            'TITLE' => $arItem['TITLE'],
            'YEAR' => $arItem['YEAR'],
            'PUBLISH_DATE' => $arItem['PUBLISH_DATE'],
            'PAGES' => $arItem['PAGES'],
            'DOCTORS' => [],
            'SPECS' => [],
            'AUTHORS' => [],
            'PUBLISHER_NAME' => $arItem['PUBLISHER_NAME'],
        ];
    }
    
    // Добавляем доктора, если он есть и еще не добавлен
    if ($arItem['DOCTOR_NAME'] && !in_array($arItem['DOCTOR_NAME'], $books[$bookId]['DOCTORS'])) {
        $books[$bookId]['DOCTORS'][] = $arItem['DOCTOR_NAME'];
    }

    // Добавляем специализацию, если она есть и еще не добавлена
    if ($arItem['SPEC_NAME'] && !in_array($arItem['SPEC_NAME'], $books[$bookId]['SPECS'])) {
        $books[$bookId]['SPECS'][] = $arItem['SPEC_NAME'];
    }

    // Добавляем автора, если он есть и еще не добавлен
    if ($arItem['AUTHOR_NAME'] && !in_array(sprintf(
            '%s %s %s',
            $arItem['AUTHOR_LAST_NAME'],
            $arItem['AUTHOR_NAME'],
            $arItem['AUTHOR_SECOND_NAME'],
        ), $books[$bookId]['AUTHORS'])) {
        $books[$bookId]['AUTHORS'][] = sprintf(
            '%s %s %s',
            $arItem['AUTHOR_LAST_NAME'],
            $arItem['AUTHOR_NAME'],
            $arItem['AUTHOR_SECOND_NAME'],
        );
    }
}

dump($books);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
