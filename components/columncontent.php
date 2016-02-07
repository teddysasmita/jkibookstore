<?php

namespace app\components;

use Yii\base\Component;

class Columncontent extends Component
{
	//put your code here
	 
	public static function authitemtype($model, $key, $index, $column)
	{
		return lookup::getAuthItemType($model->type);
	}
}