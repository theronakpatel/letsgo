<?php

namespace backend\models;

use Yii;

class Dashboard extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
    public $accessToken;

  /*  private static $users = [
        '100' => [
            'id' => '100',
            'name' => 'Admin 123',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'name' => 'Demo 123',
            'username' => 'demo',
            'email' => 'demo@demo.com',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/

    public static function tableName()
    {
        return 'hoi_user';
    }

    /**
     * @inheritdoc
     */
    /*public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }*/

    public static function findIdentity($admin_id) {
        // $id = 2;
        // print_r($id);exit();
        $user = self::find()
                ->where([
                    "user_id" => $admin_id
                ])
                ->one();

        if (!count($user)) {
            return null;
        }
        return new static($user);
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


    public static function findByEmail($admin_email)
    {
        return static::findOne(['admin_email' => $admin_email]);
    }

    public static function authoniticateEmail($admin_email,$admin_password) {
     $dbUser = self::find()
                ->where([
                    "admin_email" => $admin_email,
                    "admin_password" => md5($admin_password)
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
    
    
    public function validatePassword($admin_password)
    {
        return $this->admin_password === $admin_password;
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
