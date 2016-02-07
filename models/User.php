<?php

namespace app\models;


class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    	//return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;*/
    	return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;*/
    	return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
    	$encpassword = \app\components\mytools::getMySQLPassword($password);
        return $this->password === $encpassword;
    }

    public static function tableName()
    {
    	return 'users';
    }
    
    public static function getDb()
    {
    	return \Yii::$app->authdb;
    }
    
    public function beforeSave($insert)
    {
    	if (parent::beforeSave($insert)) {
    		if ($this->isNewRecord) {
    			$this->id = app\components\Mytools::getCurrentID2();
    			$this->auth_key = \Yii::$app->security->generateRandomString();
    		}
    		return true;
    	}
    	return false;
    }
}
