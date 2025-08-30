<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

// время кеширования
if (!isset($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 3600;
} else {
    $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
}

// если нет валидного кеша — получаем данные из БД
if ($this->StartResultCache()) {

    // проверяем, установлен ли модуль «Информационные блоки»
    if (!CModule::IncludeModule('iblock')) {
        return;
    }

    // получаем данные из базы
    $res1 = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array("IBLOCK_ID" => $arParams["IBLOCK_ID"], 'ACTIVE' => 'Y'),
        false,
        array(),
        array("ID", "IBLOCK_ID", "NAME", "PROPERTY_ID_2_ZAGOLOVOK", "PROPERTY_ID_2_TEXT", "PROPERTY_ID_2_ZAGOLOVOKHOVER", "PROPERTY_ID_2_TEXTHOVER", "PROPERTY_ID_2_KARTINKA", "PREVIEW_PICTURE", "PROPERTY_ID_2_HREF"),
    );

    // формируем массив arResult
    while ($arr = $res1->GetNext()) {
        $arr["PROPERTY_ID_2_KARTINKA_VALUE"] = CFile::GetFileArray($arr["PROPERTY_ID_2_KARTINKA_VALUE"]);
        $arr["PREVIEW_PICTURE"] = CFile::GetFileArray($arr["PREVIEW_PICTURE"]);
        $arResult[] = $arr;
    };

    // кэш не затронет весь код ниже, он будут выполняться на каждом хите, но здесь работаем уже с другим $arResult — будут доступны только те ключи массива, которые перечислены в вызове SetResultCacheKeys()
    if (isset($arResult)) {
        // ключи $arResult, перечисленные при вызове этого метода, будут доступны в component_epilog.php и ниже по коду. Обратите внимание, там уже будет другой $arResult
        $this->SetResultCacheKeys(
            array()
        );
        // подключаем шаблон и сохраняем кеш
        $this->IncludeComponentTemplate();
    } else { // если выяснилось что кешировать данные не требуется, прерываем кеширование и выдаем сообщение, что такой страницы нет
        $this->AbortResultCache();
        \Bitrix\Iblock\Component\Tools::process404(
            'Страница не найдена',
            true,
            true
        );
    }
};
