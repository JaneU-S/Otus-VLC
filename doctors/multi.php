<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @global $APPLICATION */
$APPLICATION->SetTitle('Врачи');
$APPLICATION->SetAdditionalCSS('/doctors/style.css');

\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Iblock\Iblock::wakeUp(23)->getEntityDataClass();

 $docId = 53; // идентификатор доктора из инфоблока Доктора
// $doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([ // получение списка процедур у врачей
//     'select' => [
//         'ID', 
//         'NAME', 
//         'PROC_ID_M.ELEMENT.NAME',
//         'PROC_ID_M.ELEMENT.DESCRIPTION' // PROC_IDS_MULTI - множественное поле Процедуры у элемента инфоблока Доктора 
//     ], 
//     'filter' => [
//         'ID' => $docId, // можно закоментить, тогда по всем
//         'ACTIVE' => 'Y',
//     ],
// ])
// ->fetchCollection(); 

// foreach ($doctors as $doctor) {
//     pr($doctor->getName().' - - -');
//     foreach($doctor->getProcIdM()->getAll() as $prItem) {
//         // получаем значение у процедуры 
//         if($prItem->getElement()->getDescription()!== null){
//             pr($prItem->getId().' - '.$prItem->getElement()->getName().' - '.$prItem->getElement()->getDescription()->getValue());
//         }
//     }
// }

// получение списка процедур у врачей с использованием метода query()
/* $doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::query() 
->setSelect([  
    'NAME',
    'PROC_ID_M.ELEMENT.NAME',
    'PROC_ID_M.ELEMENT.DESCRIPTION' // PROC_IDS_MULTI - множественное поле инфоблока Доктора 
])
->setFilter(array('ACTIVE' => 'Y'))
->fetchCollection();

// затем обходим коллекцию и получаем процедуры
$procedures = []; 
foreach ($doctors as $doctor){
    foreach($doctor->getProcIdM()->getAll() as $prItem) {
        $procedures[] = [
            'name'=> $prItem->getElement()->getName(),                
            'id' => $prItem->getElement()->getId()
        ];
    }
}
 pr($procedures); */

// $procedureId = 35; // идентификатор процедуры из инфоблока Процедуры
// $procedures = \Bitrix\Iblock\Elements\ElementProceduresTable::getList([ // получение списка значений свойства цвет у  элемента Процедура
//     'select' => [
//         'ID', 
//         'NAME', 
//         'DESCRIPTION',
//         'COLORS',
//     ],
//     'filter' => [
//         'ID' => $procedureId,
//         'ACTIVE' => 'Y'
//     ],
// ])->fetchCollection();
// foreach ($procedures as $procedure) {
//     foreach($procedure->getColors()->getAll() as $color) {
//             pr($color->getValue());
//     }
// }



// получение списка городов у элемента инфоблока Страна 
// $countryId = 46; // идентификатор процедуры из инфоблока Процедуры
// $country = \Bitrix\Iblock\Elements\ElementCountryTable::getByPrimary(46, array(
//     'select' => ['*', 'CITIES.ELEMENT.NAME', 'CITIES.ELEMENT.ENGLISH'] 
//     //'select' => ['ID', 'NAME'],
// ))->fetchObject();
// foreach($country->getCities()->getAll() as $prItem) {
//     pr($prItem->getElement()->get('ENGLISH')->getValue().' '.$prItem->getElement()->getName());
// }

// $res = \Bitrix\Iblock\Elements\ElementCountryTable::getByPrimary(46, array(
//     'select' => ['*', 'CITIES.ELEMENT.NAME', 'CITIES.ELEMENT.ENGLISH'] 
// ))->fetch();

// // var_dump ('    - '.$res);

// pr($res);
// pr($res['NAME']);
?>

