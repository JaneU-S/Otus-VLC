<?php
namespace Otus\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\TextField;
//use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
//use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock\Elements\ElementcarsTable;
use Bitrix\Iblock\Elements\ElementautoclientsTable;
use Bitrix\Main\ORM\Query\Join;

//Loc::loadMessages(__FILE__);


class autoClients extends DataManager
{
    public static function getTableName()
    {
        return 'my_table_autoclients';
    }

    public static function getMap()
    {
        return [
            (new IntegerField('ID_AUTOCLIENT'))
                ->configurePrimary(),
            
            (new IntegerField('ID_CAR'))
                ->configurePrimary(),
            
            // Связи с cars и autoclients
            (new \Bitrix\Main\ORM\Fields\Relations\Reference(
                'AUTOCLIENTS',
                autoclientsTable::class,
                \Bitrix\Main\ORM\Query\Join::on('this.ID_AUTOCLIENTS', 'ref.ID')
            )),
            
            (new \Bitrix\Main\ORM\Fields\Relations\Reference(
                'CARS',
                carsTable::class,
                \Bitrix\Main\ORM\Query\Join::on('this.ID_CARS', 'ref.ID')
            ))
        ];
    }
}




?>