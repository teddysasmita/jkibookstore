<?php

namespace app\components;

use Yii\base\Component;

class Lookup extends Component
{
	//put your code here
	 
	public static function getAuthItemType($num)
	{
		//return $num;
		switch($num) {
			case 1: return 'Role / Peran';
			case 2: return 'Permission / Otoritas';
		}
	}
}