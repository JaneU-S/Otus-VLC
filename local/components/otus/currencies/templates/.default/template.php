<?php 
// показ элемента инфоблока.
// содержит шаблон по умолчанию и определяет внешний вид страницы вывода

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;

if ($arResult['CURRENCY_RATE']) {
	echo 'Курс выбранной валюты: '.round($arResult['CURRENCY_RATE'], 2);
	echo '</br><a href="javascript:history.back()">Назад</a>';
}else{
?>

	<h2>Выберите валюту:</h2>
	<form method="get">
		<select name="CURRENCY_ID" onchange="this.form.submit()">
			<?php foreach ($arResult['CURRENCIES'] as $currencyId => $currencyName): ?>
				<option value="<?php echo htmlspecialcharsbx($currencyId); ?>"><?php echo htmlspecialcharsbx($currencyName); ?></option>
			<?php endforeach; ?>
		</select>
	</form>


<?php
}
?>

