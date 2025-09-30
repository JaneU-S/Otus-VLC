<?php

namespace Events;

use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
        use Bitrix\Crm\Service;
        use Bitrix\Crm\Item;

class IblockHandler
{
 
    public static function onElementBeforeUpdate(&$arFields)
    {
        
       if ($arFields["IBLOCK_ID"] != 30){
            return $arFields;
        }
        $arFields['NAME'] = 'Изменено '.date('d.m.Y H:i:s');
      
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'IBLOCK_ID: '.var_export($arFields["IBLOCK_ID"].' PROP[247] '.$arFields["PROPERTY_VALUES"]["247"], true).PHP_EOL, FILE_APPEND);
        // file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', '127: '.var_export($arFields, true).PHP_EOL, FILE_APPEND);
        // file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', '132: '.var_export($arFields["PROPERTY_VALUES"]["132"], true).PHP_EOL, FILE_APPEND);
        

    }

    public static function onElementAfterUpdate(&$arFields)
    {
 
       if ($arFields["IBLOCK_ID"] != 30){
            return $arFields;
        }
    
       if ($arFields["PROPERTY_SDELKA"]){
            return $arFields;
        }
     
    
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'after -: '.var_export($arFields, true).PHP_EOL, FILE_APPEND);
     
        $sum=[];
        $sum = explode('|', end(end($arFields["PROPERTY_VALUES"]["127"])));
        $dealID = end(end($arFields["PROPERTY_VALUES"]["132"]));
        $sumS = $sum[0];
        $sumCur = $sum[1];

        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'AfterUpdate iBlock  SUM-: '.$sumS.' | SUMCUR: '.$sumCur.' | DEAL: '.$dealID.PHP_EOL, FILE_APPEND);


        \Bitrix\Main\Loader::includeModule("crm");

        $factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory(\CCrmOwnerType::Deal);

        // //получить элемент
        $item = $factory->getItem($dealID);
 
       if (!empty($item)){
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'DEAL -: '.$dealID.PHP_EOL, FILE_APPEND);
        
            // //получить значения полей
            $title = $item->get('TITLE');
            $title = preg_replace("/[0-9]/", "", $item['TITLE']);

            // $item->get('OPPORTUNITY');

           file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'IBLOCK DEAL OLD -: '.$title.' | SUM'.$item['OPPORTUNITY'].PHP_EOL, FILE_APPEND);
    
            $item->set('TITLE', $title);
            $item->set('OPPORTUNITY', $sumS);
            $item->set('CURRENCY_ID', $sumCur);

            $item->save();

        }

    }

    
}
