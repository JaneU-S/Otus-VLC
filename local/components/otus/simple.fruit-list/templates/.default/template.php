<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

/**
 * @var array $arResult
 */

\Bitrix\Main\UI\Extension::load('otus.fruits');
?>
<div id="fruits">

</div>
<script>
    BX.ready(() => {
        const container = document.getElementById('fruits');
        const fruits = <?=\Bitrix\Main\Web\Json::encode($arResult)?>;
        new BX.Otus.Fruits({
            container,
            fruits
        });
    });
</script>
