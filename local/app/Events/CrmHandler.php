<?php

namespace Events;

use CIblockElement; 
use Bitrix\Main\Loader;

class CrmHandler
{
    public static function OnAfterDealUpdate(&$arFields) 
    {
        //получаем ID текущей сделки
  		$dealObject = new \CCrmDeal();

        $factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory(\CCrmOwnerType::Deal); 
        $item = $factory->getItem($arFields['ID']);

//        if ($item != NULL){
        if (!empty($item)){
            
            // полчучаем значение поля, где хранится ID заказа
            $elementID = $item->get('UF_CRM_1758168507');

            $propertyCode = "SUM"; // код свойства Суммы
            $propertyValue = $arFields['OPPORTUNITY_ACCOUNT'].'|'.$arFields['ACCOUNT_CURRENCY_ID'];  // присваиваем значение 
            
            // изменяем только одно поле
            
           if(Loader::IncludeModule('iblock')) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', '1) id zakaz -: '.var_export($elementID, true).' сумма '.var_export($propertyValue, true).PHP_EOL, FILE_APPEND);
    
                //CIBlockElement::SetPropertyValues($elementID, 30,  $propertyValue, $propertyCode);
                //CIBlockElement::SetPropertyValuesEx($elementID, 30,  array($propertyCode => $propertyValue));
                //self::$handlerDisallow = true; 
                CIBlockElement::SetPropertyValuesEx($elementID, 30,  [$propertyCode => $propertyValue]);
                //self::$handlerDisallow = false;

                file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', '2) id zakaz -: '.var_export($elementID, true).' сумма '.var_export($propertyValue, true).PHP_EOL, FILE_APPEND);
            }
        
        }

      

    }
}
