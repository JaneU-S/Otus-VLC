<?php

namespace Otus\Orm;

use Bitrix\Main\Entity\ReferenceField;
use Models\AbstractIblockPropertyValuesTable;
use Bitrix\Main\ORM\Data;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock\Elements\ElementISTable;
use Bitrix\Iblock\Elements\ElementUSERSTable;

class is_certificates extends DataManager
{
    public static function getTableName()
    {
        return 'is_certificates';
    }

    public static function getMap()
    {
        return [
            (new IntegerField('ID_IS'))
                ->configurePrimary(),
            
            (new IntegerField('ID_CERT'))
                ->configurePrimary(),
            
            // Связи с ИС и Сертификатами
            (new \Bitrix\Main\ORM\Fields\Relations\Reference(
                'IS',
                ORMIS::class,
                \Bitrix\Main\ORM\Query\Join::on('this.ID_IS', 'ref.ID')
            )),
            
            (new \Bitrix\Main\ORM\Fields\Relations\Reference(
                'Sertificates',
                ORMSertificates::class,
                \Bitrix\Main\ORM\Query\Join::on('this.ID_CERT', 'ref.ID_CERT')
            ))
        ];
    }
}

?>