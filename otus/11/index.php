<?

use Bitrix\Currency\CurrencyTable;
use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;


require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->SetTitle('11. Компоненты');
// echo "<link rel='stylesheet' href='style.css'>";

//         $currencies = CurrencyTable::getList([
//             'select' => ['CURRENCY'],
//         ]);

//         $result = [];

// while ($currency = $currencies->fetch()) {
//     echo $currency['CURRENCY'];
	
// 		$currency = CurrencyTable::getByPrimary($currency['CURRENCY'])->fetch();
	
// 		if ($currency) {
//             echo ' - '.$currency['CURRENT_BASE_RATE']. '<br>';
//         }	
// }


$APPLICATION->IncludeComponent(
    "otus:currencies",
    ".default",
    false
);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');

?>

