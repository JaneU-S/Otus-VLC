<?php
namespace Otus\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock\Elements\ElementISTable;
use Bitrix\Iblock\Elements\ElementUsersTable;

/**
 * Class SertificatesTables
 * 
 * Fields:
 * <ul>
 * <li> ID_CERT int mandatory
 * <li> NUM_CERT string(100) optional
 * <li> TYPE_CERT int optional
 * <li> DATE_OUT date optional
 * <li> ACIVE int optional
 * </ul>
 *
 * @package Bitrix\Table
 **/

class SertificatesTables extends DataManager
{
	public static function getTableName()
	{
		return 'certificates_table';
	}

	public static function getMap()
	{
		return [
			(new IntegerField('ID'))
			->configurePrimary(true)
			->configureAutocomplete(true),

			(new StringField('NUM_CERT'))
			->configureSize(255),
					
			(new IntegerField('TYPE_CERT'))
			->configureSize(1),

			(new DateField('DATE_OUT')),

			(new IntegerField('ACIVE'))
			->configureSize(1),

			(new ManyToMany('is_certificates', ElementISTable::class))
                ->configureTableName('is_sertificates')
                ->configureLocalPrimary('ID', 'ID_CERT')
                ->configureRemotePrimary('ID', 'ID_IS'),

			(new ManyToMany('users_cert', ElementUsersTable::class))
                ->configureTableName('users_certificates ')
                ->configureLocalPrimary('ID', 'ID_CERT')
                ->configureRemotePrimary('ID', 'ID_USER'),

		];
	}
}


?>