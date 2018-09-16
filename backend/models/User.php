<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
    public $accessToken;
    /**
     * @inheritdoc
     */
   

    /**
     * @inheritdoc
     */
   public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'string'],
        ];
    }

    public static function tableName()
    {
        return 'tbl_admin';
    }

    public function attributeLabels()
    {
        return [
            'admin_id' => 'admin_id',           
        ];
    }

    /**
     * @inheritdoc
     */
    /*public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }*/



public function getLanguagelist(){
        $languageModel = Language::find()->asArray()->all();
        
        return ArrayHelper::map($languageModel, 'language_id','language_name');
    }

    public static function findIdentity($user_id) {
        // $id = 2;
        // print_r($id);exit();
        $user = self::find()
                ->where([
                    "user_id" => $user_id
                ])
                ->one();

        if (!count($user)) {
            return null;
        }
        return new static($user);
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function setPassword($user_password)
    {
        $this->password_hash = ($user_password);
        $this->password = ($user_password);
    }
    
    public function reset_device($user_id)
    {
        
        Yii::$app->db->createCommand("UPDATE `tbl_admin` SET device = '',device_id = '' WHERE user_id = '$user_id'")->execute();
        Yii::$app->db->createCommand("DELETE FROM auth_key WHERE user_id = '$user_id'")->execute();
        return TRUE;
    }

    
    public function update_status($status,$user_id)
    {
        
        Yii::$app->db->createCommand("UPDATE `tbl_admin` SET status = '$status' WHERE user_id = '$user_id'")->execute();
        return TRUE;
    }


     public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }


    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    /*public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }*/

    public static function findByUsername($username) {
        $dbUser = self::find()
                ->where([
                    "username" => $username
                ])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /*public static function findByEmail($email) {
        
        $dbUser = self::find()->where(["email" => $email])->one();

        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);

    }*/


    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }
    public static function findByAppPhone($phone)
    {
        return static::findOne(['phone' => $phone,'app_type' => 'M']);
    }

    public static function authoniticateEmail($phone,$password) {
     $dbUser = self::find()
                ->where([
                    "phone" => $phone,
                    "password" => md5($password)
                ])
                ->one();
                // print_r($this->_user);exit();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);

    }


    /*public static function findByEmail($email)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['email'], $email) === 0) {
                return new static($user);
            }
        }

        return null;
    }*/

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->admin_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    
    
    public function validatePassword($password)
    {
        return $this->password === $password;
    }


    /*public function validatePassword($email,$password)
    {
         $dbUser = self::find()
                ->where([
                    "email" => $email,
                    "password" => md5($password)
                ])
                ->one();
                // print_r(count($dbUser));exit();
        if (!count($dbUser)) {
            return TRUE;
        }else{
            return FALSE;
        }
        // return new static($dbUser);

        // return $this->password === $password;
    }*/

}
