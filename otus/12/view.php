<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Bitrix\Main\Type,
    Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
    Bitrix\Main\Entity\Query;
use Bitrix\Iblock\Iblock,
    Bitrix\Iblock\SectionTable;
use Bitrix\Js\Main;

//use \Bitrix\Iblock\Elements\ElementResourcesTable as ResourcesTable;

$APPLICATION->SetTitle("Ресурсы");

$IBLOCK_ID=33;
$iblockClass = Iblock::wakeUp($IBLOCK_ID)->getEntityDataClass();


        if (!Loader::includeModule('iblock')) {
            return;
        }

        //Получаем список всех информационных ресурсов
$limit=10;
$page=10;
        $offset = $limit * ($page-1);
        $rows = [];
 
        $is = $iblockClass::getList([       
                'select'=>[
                'ID',
                'NAME',
                //'PREVIEW_PICTURE',
                //'ABOUT_IS_R' => 'ABOUT_IS.VALUE',
                //'ACT_R' => 'ACT.VALUE',
                //'OWNER_IS_R' => 'OWNER_IS.VALUE',  
                //'IBLOCK_ELEMENTS_ELEMENT_RESOURCES_TYPE_IS_ITEM_VALUE',   
                //'LINK_IS_' => 'LINK_IS.DESCRIPTION',
                //'TYPE_IS_R' => 'TYPE_IS.VALUE',
                //'NOTE_R' => 'NOTE.VALUE',
            ],
          //'limit' => $limit,
            // 'offset' =>$offset


        ]);//->fetchAll();

        while ($item = $is->fetch()) {
            $rows[] = array('data' => $item);
        }

         //pr ($is);

    // Значения столбцов
    $rsProperty = \Bitrix\Iblock\PropertyTable::getList(array(     
        'filter' => array(
            'IBLOCK_ID'=>$IBLOCK_ID,
            'CODE' => array ('ABOUT_IS', 'TYPE_IS', 'ACT', 'OWNER_IS', 'NOTE'),
            //'ACTIVE'=>'Y',
            //'=PROPERTY_TYPE'=>\Bitrix\Iblock\PropertyTable::TYPE_LIST
        ),
        'select' => array(
            'ID',
            //'CODE',
            'NAME',
        ),
    ));

// PROPERTY_TYPE: 
// \Bitrix\Iblock\PropertyTable::TYPE_STRING - строка
// \Bitrix\Iblock\PropertyTable::TYPE_NUMBER - число
// \Bitrix\Iblock\PropertyTable::TYPE_LIST - список
// \Bitrix\Iblock\PropertyTable::TYPE_ELEMENT - привязка к элементу
// \Bitrix\Iblock\PropertyTable::TYPE_SECTION - привязка к разделу
// \Bitrix\Iblock\PropertyTable::TYPE_FILE - файл

$arProperty=$rsProperty->fetchAll();

  $columns = array(
    [
        'id' => 'ID',
        'name' => 'ID',
    ],
    [
        'id' => 'NAME',
        'name' => 'Наименование ресурса',
    ],
   );

//$columns = array_merge($columns, $arProperty);
 pr($columns);
 pr($rows);

$APPLICATION->includeComponent(
	"bitrix:main.ui.grid",
	"",
	[
		"GRID_ID" => "MY_GRID_ID",
		"COLUMNS" => $columns,
		"ROWS" => $rows,
		//"NAV_OBJECT" => $nav,
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		//"SHOW_ROW_CHECKBOXES" =>$arResult['SHOW_ROW_CHECKBOXES'],
		//"SHOW_SELECTED_COUNTER" => false,
		//"SHOW_PAGESIZE" => false,
		//"TOTAL_ROWS_COUNT" =>$arResult['COUNT']
	]
);


require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';