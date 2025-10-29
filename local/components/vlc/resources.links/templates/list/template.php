<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

//pr($arResult); 
?>


<?

	$id='';

    foreach ($arResult as $IS) {
            //echo ('<a href="'.$IS['IBLOCK_ELEMENTS_ELEMENT_RESOURCES_LINK_IS_VALUE'].'>'.$IS['NAME'].'</a>'.' '.$IS['IBLOCK_ELEMENTS_ELEMENT_RESOURCES_TYPE_IS_VALUE'].'</br>');
			if ($id!=$IS['TYPE_IS_ID']){
				echo ('<h2>'.$IS['TYPE_IS_VALUE'].'</h2>');
				$id=$IS['TYPE_IS_ID'];
			}
 			
            $fileLink = CFile::GetPath($IS['PREVIEW_PICTURE']);
            $fileLink  = isset($fileLink) ? $fileLink : $templateFolder."/img/logo.png";

			echo ('<p><figure class="aligncenter size-large">
			<a href="'.$IS['LINK_IS_VALUE'].'" target="_blank"> 
			<img src="'.$fileLink.'" alt="" width="80" height="80"></a>
			<figcaption><mark style="background-color:#ffffff" class="has-inline-color">'.$IS['NAME'].'</mark>
			</figcaption></figure></p>');
        }


?>
