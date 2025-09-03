<?php 
// задаем имя, описание и расположение компонента в визуальном редакторе.
//.description.php содержит массив $arComponentDescription с основными характеристиками компонента. 
// В массив передается название компонента, описание и расположение в дереве компонентов.

$arComponentDescription = array(

    "NAME" => "Currensies",
    "DESCRIPTION" => "Компонент для вывода текущей даты и времени в заданном формате",
	"ICON" => "/images/list_cur.gif",
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID" => "otus",
    ),

);

?>