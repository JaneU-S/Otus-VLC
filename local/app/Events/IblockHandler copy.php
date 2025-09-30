<?php

namespace Events;

use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;

class IblockHandler
{
    //public static $restrictHour = 21;

    public static function onElementAfterUpdate(&$arFields)
    {
        
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'IBLOCK_ID: '.var_export($arFields, true).PHP_EOL, FILE_APPEND);

       if ($arFields["IBLOCK_ID"] != 30){
            return $arFields;
        }
        $arFields['NAME'] = 'Изменен в обработчике события ' . date('d.m.Y H:i:s');
      
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'FIELDS: '.var_export($arFields, true).PHP_EOL, FILE_APPEND);

        //$el = new CIBlockElement;
        //$PROP = array();
        //$PROP[12] = "Белый";  // свойству с кодом 12 присваиваем значение "Белый"
        //$PROP[3] = 38;        // свойству с кодом 3 присваиваем значение 38
        // $arLoadProductArray = Array(
        //    // "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
        //    // "IBLOCK_SECTION" => false,          // элемент лежит в корне раздела
        //    // "PROPERTY_VALUES"=> $PROP,
        //     "NAME"           => "Элемент",
        // );
        // $PRODUCT_ID = 2;  // изменяем элемент с кодом (ID) 2
        // $res = $el->Update($PRODUCT_ID, $arFields['NAME']);

    }

    // public static function onElementAfterUpdate(&$arFields)
    // {
    //     file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'FIELDS: '.var_export($arFields, true).PHP_EOL, FILE_APPEND);

    //     if (!Loader::includeModule('im')) // отправляем пользователю сообщение в чат
    //         return;

    //     $messageId = \CIMMessage::Add([
    //         'TO_USER_ID' => 1,
    //         'FROM_USER_ID' => 1, // Анна Делова
    //         'MESSAGE' => 'Привет'.' '.$arFields['NAME'],
    //     ]);

    //    if (!$messageId) {
    //        if ($exception = $GLOBALS['APPLICATION']->GetException()) {
    //            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'ERROR: '.var_export($exception->GetString(), true).PHP_EOL, FILE_APPEND);
    //        } else {
    //            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logIAU.txt', 'UNKNOWN_ERROR'.PHP_EOL, FILE_APPEND);
    //        }
    //    }
    // }

    // public static function onElementBeforeDelete(&$id)
    // {
    //     if (date('H') == self::$restrictHour)
    //     {
    //         global $APPLICATION;
    //         $APPLICATION->throwException("Нельзя удалять в ".self::$restrictHour." часов");
    //         return false;
    //     }
    // }
}
