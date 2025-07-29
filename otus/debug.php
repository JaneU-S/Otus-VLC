<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
//IncludeModuleLangFile($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/intranet/public/index.php');

$a = date('Y-m-d H:i:s');

//$b=1/0;

// Bitrix\Main\Diag\Debug::dump('ДЗ Отладка и логирование '.$a, 'OTUS ДЗ: дата/время', false);
// Bitrix\Main\Diag\Debug::dumpToFile(['ID' => $a, 'fields'=>$fields ],"","__log.log"); 

Bitrix\Main\Diag\Debug::writeToFile($a, 'DZ: Date/Time writeToFile', 'otus/logs/logOtus.log');
Bitrix\Main\Diag\Debug::dumpToFile($a, 'DZ: Date/Time dumpToFile', 'otus/logs/logOtus.log');
echo $a;

// echo "Имя сервера - ".$_SERVER['SERVER_NAME']."<br />";
//  echo "IP-адрес сервера - ".$_SERVER['SERVER_ADDR']."<br />";
//  echo "Порт сервера - ".$_SERVER['SERVER_PORT']."<br />";
//  echo "Web-сервер - ".$_SERVER['SERVER_SOFTWARE']."<br />";
//  echo "Версия HTTP-протокола - ".$_SERVER['SERVER_PROTOCOL']."<br />";


require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');

?>