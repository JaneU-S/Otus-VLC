<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

// use Bitrix\Main\Context,	
// 	Bitrix\Main\Application,
// 	Bitrix\Main\Localization\Loc,
// 	Bitrix\Main\Engine\Contract\Controllerable,
// 	Bitrix\Iblock;
// use Bitrix\Main\Engine\Contract;
// use Models\ClientsTable as Clients;

use Bitrix\Main\Type,
    Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
    Bitrix\Main\Entity\Query;
use Bitrix\Iblock\Iblock,
    Bitrix\Iblock\SectionTable;

class VlcLinksComponent extends \CBitrixComponent
{

    protected $request;

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return mixed
    */
    public function onPrepareComponentParams($arParams) {
       return $arParams;
    }

    private function getLinks()
    {

        $IBLOCK_ID=33;
        \Bitrix\Main\Loader::includeModule('iblock');
        
        // Инициализация класса инфоблока
        $iblockClass = Iblock::wakeUp($IBLOCK_ID)->getEntityDataClass();

        $links=[];

        if (!Loader::includeModule('iblock')) {
            return;
        }

        //Получаем список информационных ресурсов, доступных пользователю
        $links = $iblockClass::getList([       
                'select'=>[
                'ID',
                'NAME',
                'PREVIEW_PICTURE',
                'LINK_IS_'=>'LINK_IS',
                'TYPE_IS_'=>'TYPE_IS.ITEM',
                //'TYPE_ID_'=>'TYPE_IS',
                'SHOW_IS_'=>'SHOW_IS',
                //'TYPE_SORT_'=>'TYPE_IS.ITEM',			
                ],
                'filter' =>[
                'SHOW_IS_VALUE' => '64',	
                ],
                'group' => [
                    'TYPE_IS_VALUE' 
                ],
                'order' => [
                    'TYPE_IS_SORT',
                ],

        ])->fetchAll();

        return $links;
    }


    /**
     * Точка входа в компонент
     * Должна содержать только последовательность вызовов вспомогательых ф-ий и минимум логики
     * всю логику стараемся разносить по классам и методам 
     */
    public function executeComponent() {

        try
        {

            // получаем параметры методов GET и POST, из обьекта request который позволяет получить данные о текущем запросе: метод и протокол, запрошенный URL, переданные параметры
            //$this->$request = Application::getInstance()->getContext()->getRequest();

            $this->arResult = $this->getLinks(); // получаем записи таблицы

            // подключаем шаблон
            $this->IncludeComponentTemplate();

        }
        catch (SystemException $e)
        {
            ShowError($e->getMessage());
        }

    }


} 