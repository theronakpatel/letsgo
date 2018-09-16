<?php

namespace backend\models;

use Yii;
use yii\base\Model;



/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $verify_password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['email', 'email'],
            ['email', 'string'],
            //['password', 'match','pattern'=>"/^([a-zA-Z0-9-_]*)$/", 'message' => 'Space is not allowed'], 
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    
    public function validatePassword($attribute, $params)
    { 
        if (!$this->hasErrors()) {
        
            $user = $this->getUser();

            if (!$user || !$user->validatePassword(md5($this->password))) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
           
        }
    }

    /**
     * Logs in a user using the provided email and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }
    
}
?>
