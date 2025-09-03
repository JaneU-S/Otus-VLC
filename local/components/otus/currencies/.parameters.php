<?php 
// описание входных параметров компонента.
// определяет, какие настройки компонента будут доступны в визуальном редакторе.
// содержит массив $arComponentParameters, который описывает входные параметры компонента. 
// зыковой файл должен лежать в папке /lang/<язык>/.parameters.php, относительно папки компонента

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule("iblock"))
	return;

$arComponentParameters = array(
	"GROUPS" => array(
		"LIST" => array(
			"NAME" => "Параметры",
			"SORT" => "300"
		)
	),
		"NUM_PAGE" =>  array(
			"PARENT" => "LIST",
			"NAME" => "Количество записей на странице",
			"TYPE" => "STRING",
			"DEFAULT" => "1"
		)	
);


?>