<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
echo "<link rel='stylesheet' href='style.css'>";
$APPLICATION->SetTitle('ДЗ Связывание моделей OTUS ');

use Models\Lists\DoctorsPropertyValuesTable as DoctorsTable;
use Models\Lists\ProceduresPropertyValuesTable as ProceduresTable;

\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Iblock\Iblock::wakeUp(23)->getEntityDataClass();

$doctors=[];

?>
<h1> Врачи </h1>

<?php

//=======================
//Выводим список докторов
//=======================
if (empty($_POST) && empty($_GET['action']) && empty($_GET['id_doctor'])) {

?>
<div> <a href="?action=newdoc"  class='button-style'>Добавить врача</a>
    <a href="?action=newproc" class='button-style'>Добавить процедуру</a>
</div>

<?php

    $doctors = DoctorsTable::getList([       
            'select'=>[
            'ID'=>'IBLOCK_ELEMENT_ID',
            'NAME'=>'ELEMENT.NAME',
            'FIRST_NAME'=>'FIRST_NAME',
            'MIDDLE_NAME'=>'MIDDLE_NAME',
            'LAST_NAME'=>'LAST_NAME'
        ]
    ])->fetchAll();

    foreach ($doctors as $doctors) {
            echo ('<a href="?id_doctor='.$doctors['ID'].'" class="card">'.$doctors['FIRST_NAME'].' '.$doctors['MIDDLE_NAME'].' '.$doctors['LAST_NAME'].'</a>');
        }
}

//=============================================
// Выводим список процедур у выбранного доктора
//=============================================
if (isset($_GET['id_doctor'])) {
    $id_doctor=$_GET['id_doctor'];
    //echo $id_doctor;

    $doctors = DoctorsTable::query() 
    ->setSelect([  
        '*',
        'ID'=>'ELEMENT.ID',
        'NAME'=>'ELEMENT.NAME',
 		  'FIRST_NAME',
 		  'MIDDLE_NAME',
  		  'LAST_NAME',
          'PROC_ID_M',
    ])
    ->where('ID', $id_doctor)
    ->fetch();
     echo ('<h2>'.$doctors['FIRST_NAME'].'  '.$doctors['MIDDLE_NAME'].'  '.$doctors['LAST_NAME']).'</h2>';

    $doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::query() 
    ->setSelect([  
        'NAME',
        'PROC_ID_M.ELEMENT.NAME',
    ])
    ->setFilter(array('ID' => $id_doctor))
    ->fetchCollection();
  
    echo '<h3>Процедуры</h3>';
    foreach ($doctors as $doctor){
        echo '<ul>';
        foreach($doctor->getProcIdM()->getAll() as $prItem) {
            echo ('<li>'.$prItem->getElement()->getName().'</li>');
       	}
        echo '</ul>';
    }

}

//====================
//Добавляем врача
//====================
if (isset($_POST['add_doctor'])) {
    if (DoctorsTable::add($_POST)) {
       echo "<div>Доктор добавлен</div>";

    }

}

//====================
//Добавляем процедуру
//====================
if (isset($_POST['new_proc'])) {
    //pr ($_POST);
    if (ProceduresTable::add(['NAME'=>$_POST['NAME'],])) {
        echo "<div>Процедура добавлена</div>";
        echo "Список процедур:";

        $procedures = ProceduresTable::getList([ // получение списка всех существующих процедур
        'select' => [
                'ID'=>'IBLOCK_ELEMENT_ID',
                'NAME'=>'ELEMENT.NAME',
        ],
        'filter' => [
            'ELEMENT.ACTIVE' => 'Y'
        ],
        ])->fetchAll();
        echo '<ul>';
        foreach ($procedures as $procedure) {
            echo ('<li>'.$procedure['NAME'].'</li>');
        }
        echo '</ul>';

    }

}


//=================================
// выводим форму добавления доктора
//=================================
if (empty($_POST) && ($_GET['action']=='newdoc')) {
    echo '<h3>Добавляем доктора</h3>';
    echo "<form method='POST'>";
        $procedures = ProceduresTable::getList([ // получение списка всех существующих процедур
        'select' => [
                'ID'=>'IBLOCK_ELEMENT_ID',
                'NAME'=>'ELEMENT.NAME',
        ],
        'filter' => [
            'ELEMENT.ACTIVE' => 'Y'
        ],
        ])->fetchAll();

?>
    
        <div class="doctor-add-form">
        
        <Input type="text" name="NAME" required placeholder="код латиницей" />
        <Input type="text" name="FIRST_NAME" required placeholder="Имя" />
        <Input type="text" name="MIDDLE_NAME" required placeholder="Отчество" />
        <Input type="text" name="LAST_NAME" required placeholder="Фамилия" />

        <p>Процедуры</p>
        
        <select multiple name="PROC_ID_M[]">
        <?php foreach ($procedures as $procedure) { ?>
            <option value="<?=$procedure['ID']?>">
                <?php 
                    if (isset($data['PROC_ID_M']) && in_array ($procedure['ID'],$procedure['PROC_ID_M'])) {
                        echo "selected";
                    }
                echo $procedure['NAME'];
                echo "</option>";    
            };       
        ?>        
            </select>

    <input type="submit" name="add_doctor" value="Сохранить"/>

<?
    
}

//====================================
// выводим форму добавления процедуры
//====================================
if (empty($_POST) && ($_GET['action']=='newproc')) {
        echo '<h3>Добавляем процедуру</h3>';

?>
    <form method="POST">
        <div class="doctor-add-form">
            <input type="text" name="NAME" required placeholder="Название процедуры"/>
            <input type="submit" name="new_proc" value="сохранить"/>
        </div>
</form>
<?php } 

if (!empty($_POST) || !empty($_GET['action']) || !empty($_GET['id_doctor'])) {
?>

<div> <a href="index.php"  class='button-style'>Назад</a> </div>
<?php } ?>