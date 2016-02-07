<?php

namespace app\modules\rbac\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $username
 * @property string $fullname
 * @property string $password
 * @property string $access_token
 * @property string $auth_key
 * @property string $active
 * @property string $userlog
 * @property string $datetimelog
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'fullname', 'password', 'active'], 'required'],
            [['id', 'userlog'], 'string', 'max' => 21],
            [['username'], 'string', 'max' => 20],
            [['fullname', 'access_token'], 'string', 'max' => 100],
            [['password', 'auth_key'], 'string', 'max' => 200],
            [['active'], 'string', 'max' => 1],
            [['datetimelog'], 'string', 'max' => 19]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'fullname' => 'Fullname',
            'password' => 'Password',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
            'active' => 'Active',
            'userlog' => 'Userlog',
            'datetimelog' => 'Datetimelog',
        ];
    }

    /**
     * @inheritdoc
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
    
    public function beforeSave($insert) 
    {
		if (parent::beforeSave($insert)) {
	    	if ($insert) {
				$this->id = \app\components\mytools::getCurrentID2();
				$this->auth_key = \Yii::$app->security->generateRandomKey();
				$this->access_token = \Yii::$app->security->generateRandomString();
			}
			$this->password = \app\components\mytools::getMySQLPassword($this->password);
			$this->userlog = Yii::$app->user->id;
			$this->datetimelog = \app\components\mytools::getDateTime();
			return true;
		} else 
			return false;
    }
}
