<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @global $APPLICATION */
$APPLICATION->SetTitle('Врачи');
$APPLICATION->SetAdditionalCSS('/doctors/style.css');

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
Loader::includeModule('iblock');

 $docId = 24; // идентификатор доктора из инфоблока Доктора
// $doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([ // получение списка процедур у врачей
//     'select' => [
//         'ID', 
//         'NAME', 
//         'PROC_ID_M.ELEMENT.NAME',
//         'PROC_ID_M.ELEMENT.DESCRIPTION' // PROC_IDS_MULTI - множественное поле Процедуры у элемента инфоблока Доктора 
//     ], 
//     'filter' => [
//         'ID' => $docId,
//         'ACTIVE' => 'Y',
//     ],
// ])
// ->fetchCollection(); 

// foreach ($doctors as $doctor) {
//     pr($doctor->getName().' - - -');
//     foreach($doctor->getProcIdsMulti()->getAll() as $prItem) {
//         // получаем значение у процедуры 
//         if($prItem->getElement()->getDescription()!== null){
//             pr($prItem->getId().' - '.$prItem->getElement()->getName().' - '.$prItem->getElement()->getDescription()->getValue());
//         }
//     }
// }

// получение списка процедур у врачей с использованием метода query()
// $doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::query() 
// ->setSelect([  
//     'NAME',
//     'PROC_ID_M.ELEMENT.NAME',
//     'PROC_ID_M.ELEMENT.DESCRIPTION' // PROC_IDS_MULTI - множественное поле инфоблока Доктора 
// ])
// ->setFilter(array('ACTIVE' => 'Y'))
// ->fetchCollection();

// // затем обходим коллекцию и получаем процедуры
// $procedures = []; 
// foreach ($doctors as $doctor){
//     foreach($doctor->getProcIdsMulti()->getAll() as $prItem) {
//         $procedures[] = [
//             'name'=> $prItem->getElement()->getName(),                
//             'id' => $prItem->getElement()->getId()
//         ];
//     }
// }
// pr($procedures);

/*$procedureId = 56; // идентификатор процедуры из инфоблока Процедуры
$procedures = \Bitrix\Iblock\Elements\ElementProceduresTable::getList([ // получение списка значений свойства цвет у  элемента Процедура
    'select' => [
        'ID', 
        'NAME', 
        'DESCRIPTION',
        'COLORS',
    ],
    'filter' => [
        'ID' => $procedureId,
        'ACTIVE' => 'Y'
    ],
])->fetchCollection();
foreach ($procedures as $procedure) {
    foreach($procedure->getColors()->getAll() as $color) {
            pr($color->getValue());
    }
}
*/


// получение списка городов у элемента инфоблока Страна 
$countryId = 23; // идентификатор процедуры из инфоблока Процедуры
// $country = \Bitrix\Iblock\Elements\ElementCountryTable::getByPrimary($countryId, array(
//     'select' => ['*', 'CITIES.ELEMENT.NAME', 'CITIES.ELEMENT.ENGLISH'] 
// ))->fetchObject();

// foreach($country->getCities()->getAll() as $prItem) {
//     pr($prItem->getElement()->get('ENGLISH')->getValue().' '.$prItem->getElement()->getName());
// }

// $country = \Bitrix\Iblock\Elements\ElementCountryTable::getByPrimary($countryId, array(
//     'select' => ['*', 'CITIES.ELEMENT.NAME', 'CITIES.ELEMENT.ENGLISH'] 
// ))->fetchObject();


// получение списка городов у элемента инфоблока Страна 2
$countryId = 23; // идентификатор процедуры из инфоблока Процедуры
// $country = \Bitrix\Iblock\Elements\ElementCountryTable::getByPrimary($countryId, array(
//     'select' => ['*', 'CITIES.ELEMENT.NAME', 'CITIES.ELEMENT.ENGLISH'] 
// ))->fetchObject();

// foreach($country->getCities()->getAll() as $prItem) {
//     pr($prItem->getElement()->get('ENGLISH')->getValue().' '.$prItem->getElement()->getName());
// }

$elements = \Bitrix\Iblock\Elements\ElementCountryTable::getList([ // car - cимвольный код API инфоблока
     'select' => ['*', 'CITIES' ,'CITIES.ELEMENT.NAME', 'CITIES.ELEMENT.English'] 
 ])->fetchCollection();


foreach($elements as $element) {
    $citiesList =$element->getCities();
    foreach ($citiesList as $citiesProp){
        $cityId = $citiesProp->getValue();
        pr($cityId);
        // $cityName = $citiesProp->getName();
        $cityEn = $citiesProp->getEnglish();
        pr($cityEn);
        // pr($cityName);
    }
}

$country = \Bitrix\Iblock\Elements\ElementCountryTable::getByPrimary($countryId, array(
    'select' => ['*', 'CITIES.ELEMENT.NAME', 'CITIES.ELEMENT.ENGLISH'] 
))->fetchObject();
foreach($country->getCities()->getAll() as $prItem) {
    pr($prItem->getElement()->get('ENGLISH')->getValue().' '.$prItem->getElement()->getName());
}

 //  foreach ($elements as $element) {
//      pr('CITIES - '.$element->getCities()->getAll()); // получение значения свойства MODEL
//  }


// $iblockId = 20;
// $elements = \Bitrix\Iblock\Elements\ElementCarsTable::getList([ // car - cимвольный код API инфоблока
//     'select' => ['MODEL'], // имя свойства 
// ])->fetchCollection();

// foreach ($elements as $element) {
//     pr('MODEL - '.$element->getModel()->getValue()); // получение значения свойства MODEL
// }




?>

