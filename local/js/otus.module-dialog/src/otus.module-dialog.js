import {Type} from 'main.core';

export class OtusModuleDialog
{
	constructor(options = {name: 'OtusModuleDialog'})
	{
		this.name = options.name;
	}

	setName(name)
	{
		if (Type.isString(name))
		{
			this.name = name;
		}
	}

	getName()
	{
		return this.name;
	}
}
