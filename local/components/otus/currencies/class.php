<?php

// Файл class.php — основной файл логики компонента. 

namespace Local\Components\Otus\Currencies;

use Bitrix\Currency\CurrencyTable;
use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Currency;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

// Проверяем загрузку модуля валют
if (!Loader::includeModule('currency')) {
    die('Модуль валют не установлен');
}

class CurrencyRateComponent extends \CBitrixComponent
{
    /**
     * Выводим курс валюты или список полученных валют
     *
     * @return void
     */
    public function executeComponent()
    {
        // Получаем выбранный идентификатор валюты из параметров компонента
    
		if (isset($_REQUEST['CURRENCY_ID'])) {
			$currencyId = $_REQUEST['CURRENCY_ID'];
		} else {
			$currencyId = null;
		}

        // Проверяем, выбрана ли какая нибудь валюта
        if ($currencyId) {
            // Получаем текущий курс выбранной валюты
			// Метод ORM для получения таблицы курсов валют

            $currencyRate = $this->getCurrencyRate($currencyId);

            // Если курс найден, то сохраняем его в переменные шаблона
            if ($currencyRate) {
                $this->arResult['CURRENCY_RATE'] = $currencyRate;
                $this->includeComponentTemplate();
            } else {
                // Если курс не найден, то выводим сообщение об ошибке
                ShowError('Курс не найден.');
            }
        } else {
            // Если идентификатор валюты не выбран, то выводим список существующих валют, полученный из функции
            $this->arResult['CURRENCIES'] = $this->getCurrencies();
            $this->includeComponentTemplate();
        }
    }


    /**
     * Получаем список всех доступных валют в Модуле Валюты
     *
     * @return void
     */
    protected function getCurrencies()
    {
        $currencies = CurrencyTable::getList([
            'select' => ['CURRENCY'],
        ]);

        $result = [];
        while ($currency = $currencies->fetch()) {
            $result[$currency['CURRENCY']] = $currency['CURRENCY'];
			
        }

        return $result;
    }

   
    //  Получаем курс выбранной валюты
 
    protected function getCurrencyRate(string $currencyId)
    {
        $currency = CurrencyTable::getByPrimary($currencyId)->fetch();

        if ($currency) {
            return $currency['CURRENT_BASE_RATE'];
        }

        return null;
    }
}

?>