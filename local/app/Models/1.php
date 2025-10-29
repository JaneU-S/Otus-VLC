<?php
namespace Bitrix\Iblock;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;

/**
 * Class ElementPropS33Table
 * 
 * Fields:
 * <ul>
 * <li> IBLOCK_ELEMENT_ID int mandatory
 * <li> PROPERTY_143 text optional
 * <li> PROPERTY_144 text optional
 * <li> PROPERTY_145 int optional
 * <li> PROPERTY_146 text optional
 * <li> PROPERTY_147 text optional
 * <li> PROPERTY_148 int optional
 * <li> PROPERTY_149 int optional
 * </ul>
 *
 * @package Bitrix\Iblock
 **/

class ElementPropS33Table extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_iblock_element_prop_s33';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			'IBLOCK_ELEMENT_ID' => (new IntegerField('IBLOCK_ELEMENT_ID',
					[]
				))->configureTitle(Loc::getMessage('ELEMENT_PROP_S33_ENTITY_IBLOCK_ELEMENT_ID_FIELD'))
						->configurePrimary(true)
			,
			'PROPERTY_143' => (new TextField('PROPERTY_143',
					[]
				))->configureTitle(Loc::getMessage('ELEMENT_PROP_S33_ENTITY_PROPERTY_143_FIELD'))
			,
			'PROPERTY_144' => (new TextField('PROPERTY_144',
					[]
				))->configureTitle(Loc::getMessage('ELEMENT_PROP_S33_ENTITY_PROPERTY_144_FIELD'))
			,
			'PROPERTY_145' => (new IntegerField('PROPERTY_145',
					[]
				))->configureTitle(Loc::getMessage('ELEMENT_PROP_S33_ENTITY_PROPERTY_145_FIELD'))
			,
			'PROPERTY_146' => (new TextField('PROPERTY_146',
					[]
				))->configureTitle(Loc::getMessage('ELEMENT_PROP_S33_ENTITY_PROPERTY_146_FIELD'))
			,
			'PROPERTY_147' => (new TextField('PROPERTY_147',
					[]
				))->configureTitle(Loc::getMessage('ELEMENT_PROP_S33_ENTITY_PROPERTY_147_FIELD'))
			,
			'PROPERTY_148' => (new IntegerField('PROPERTY_148',
					[]
				))->configureTitle(Loc::getMessage('ELEMENT_PROP_S33_ENTITY_PROPERTY_148_FIELD'))
			,
			'PROPERTY_149' => (new IntegerField('PROPERTY_149',
					[]
				))->configureTitle(Loc::getMessage('ELEMENT_PROP_S33_ENTITY_PROPERTY_149_FIELD'))
			,
		];
	}
}