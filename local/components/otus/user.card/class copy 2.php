<?php

use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Currency;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * Класс компонента для отображения курсов валют.
 */
class CurrencyRatesComponent extends \CBitrixComponent
{

	private function fetchDbRates(): array
	{

		// $currency = Currency\CurrencyTable::getList([
		// 	'select' => ['CURRENCY', 'AMOUNT_CNT'],
		// 	'order'  => ['CURRENCY' => 'ASC']
		// ]);

		$rsCurrency = Currency\CurrencyTable::getList();

		while($currency=$rsCurrency->fetch())

		{

			print_r($currency);

		}



		while ($row = $iterator->fetch())
		{
			$currencyList[$row['CURRENCY']] = $row['CURRENCY'];

			$rate = \CCurrencyRates::ConvertCurrency(
				$row['AMOUNT_CNT'],
				$row['CURRENCY'],
				$this->arParams['CURRENCY_BASE'],
				$this->arParams['RATE_DAY']
			);


		}

		return $currencyList;
	}


}