<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @global $APPLICATION */
$APPLICATION->SetTitle('Врачи');
$APPLICATION->SetAdditionalCSS('/doctors/style.css');

use Models\Lists\DoctorsPropertyValuesTable as DoctorsTable;
use Models\Lists\ProceduresPropertyValuesTable as ProceduresTable;

  $docId = 53; // идентификатор доктора из инфоблока Доктора

$doctors=[];

$doctors = DoctorsTable::query() 
    ->setSelect([  
        '*',
        'ID'=>'ELEMENT.ID',
        'NAME'=>'ELEMENT.NAME',
 		  'FIRST_NAME',
 		  'MIDDLE_NAME',
  		  'LAST_NAME',
          'PROC_ID_M',
    ])
    ->where('ID', $docId)
    ->fetch();
     echo ($doctors['FIRST_NAME'].'  '.$doctors['MIDDLE_NAME'].'  '.$doctors['LAST_NAME']).'<br>';
 
     if (is_array($doctors['PROC_ID_M'])){
        echo '======';
     }

// foreach ($doctors as $doctor) {
//     echo ($doctors['FIRST_NAME'].'  '.$doctors['MIDDLE_NAME'].'  '.$doctors['LAST_NAME']).'<br>';
//     // foreach($procedure->getColors()->getAll() as $color) {
//     //         pr($color->getValue());
//     // }
// }


 pr($doctors);

    if (is_array($doctors)){
            //if ($doctors['PROC_ID_M']) {
                echo (' ---- ');
                pr($doctors['PROC_ID_M']);

                $procedures = ProceduresTable::query()
                    ->setSelect([
                        'NAME' => 'ELEMENT.NAME', 
                        'ID' => 'ELEMENT.ID'
                    ])
                    //->setFilter(array('ID'=>59, 'ID'=>35))
                    //->where(['ID'], "in", '59')
                    ->fetchAll();
            //}
        }
   pr($procedures);

// \Bitrix\Main\Loader::includeModule('iblock');
// \Bitrix\Iblock\Iblock::wakeUp(23)->getEntityDataClass();


// $procedureId = 35; // идентификатор процедуры из инфоблока Процедуры
// $dbResult = CarsTable::add([
//         'NAME'=>'TEST',
//         'MANUFACTURER_ID'=>130,
//         'CITY_ID'=>126,
//         'MODEL'=>'X5',
//         'ENGINE_VOLUME'=>'4',
//         'PRODUCTION_DATE'=>date('d.m.Y'),
// ]);

//pr($procedures);



// для редактирования доктора
        // <select multiple name="PROC_ID_M[]">
        // <?php foreach ($procedures as $procedure) { ?>
        <!-- //     <option value="<?=$procedure['ID']?>"> -->
        //         <?php 
        //             if (isset($data['PROC_ID_M']) && in_array ($procedure['ID'],$procedure['PROC_ID_M'])) {
        //                 echo "selected";
        //             }
        //         echo $procedure['NAME'];
        //         echo "</option>";    
        //     };       
        // ?>        
        //     </select>

?>


