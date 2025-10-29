<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Ссылки на веб-страницы и информационные ресурсы");

// use Bitrix\Main\Type;
// use Bitrix\Main\Loader;
// use Bitrix\Iblock\Iblock;
// use Bitrix\Iblock\SectionTable;
// use Bitrix\Main\Entity\Query;
// use Models\Lists\CertificatesTable;

// $IBLOCK_ID=33;
// \Bitrix\Main\Loader::includeModule('iblock');

// // Инициализация класса инфоблока
// $iblockClass = Iblock::wakeUp($IBLOCK_ID)->getEntityDataClass();
// //\Bitrix\Iblock\Iblock::wakeUp($IBLOCK_ID)->getEntityDataClass();

// $IS=[];

// if (!Loader::includeModule('iblock')) {
//     return;
// }

//     $res = $iblockClass::getList([       
//             'select'=>[
//             'ID',
//             'NAME',
// 			'PREVIEW_PICTURE',
//             'LINK_IS_'=>'LINK_IS',
//             'TYPE_IS_'=>'TYPE_IS.ITEM',
//             //'TYPE_ID_'=>'TYPE_IS',
// 			'SHOW_IS_'=>'SHOW_IS',
// 			//'TYPE_SORT_'=>'TYPE_IS.ITEM',			
// 			],
// 			'filter' =>[
// 			'SHOW_IS_VALUE' => '64',	
// 			],
// 			'group' => [
// 				'TYPE_IS_VALUE' 
// 			],
// 			'order' => [
// 				'TYPE_IS_SORT',
// 			],

//     ])->fetchAll();

// 	pr($res);

	// $id='';

    // foreach ($res as $IS) {
    //         //echo ('<a href="'.$IS['IBLOCK_ELEMENTS_ELEMENT_RESOURCES_LINK_IS_VALUE'].'>'.$IS['NAME'].'</a>'.' '.$IS['IBLOCK_ELEMENTS_ELEMENT_RESOURCES_TYPE_IS_VALUE'].'</br>');
	// 		if ($id!=$IS['TYPE_IS_ID']){
	// 			echo ('<h2>'.$IS['TYPE_IS_VALUE'].'</h2>');
	// 			$id=$IS['TYPE_IS_ID'];
	// 		}
 	// 		$fileLink['PREVIEW_PICTURE'] = CFile::GetPath($IS['PREVIEW_PICTURE']);
	// 		echo ('<p><figure class="aligncenter size-large">
	// 		<a href="'.$IS['LINK_IS_VALUE'].'" target="_blank"> 
	// 		<img src="'.$fileLink['PREVIEW_PICTURE'].'" alt="" width="80" height="80"></a>
	// 		<figcaption><mark style="background-color:#ffffff" class="has-inline-color">'.$IS['NAME'].'</mark>
	// 		</figcaption></figure></p>');
    //     }


?>

<?
$APPLICATION->IncludeComponent(
	"otus:vlc.links", 
	"list", 
	[
		"COMPONENT_TEMPLATE" => "list",
	],
	false
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>