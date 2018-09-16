<?php

namespace backend\models;

use Yii;
use backend\models\User;

/**
 * This is the model class for table "class5_forgotpassword".
 *
 * @property integer $forgotpassword_id
 * @property string $username
 * @property string $emailaddress
 * @property string $usertype
 * @property string $token
 * @property string $create_dt
 * @property string $is_set
 */
class ForgotForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hoi_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            ['email', 'validateemail'],
            
        ];
    }


    public function validateemail($attribute, $params)
    {
        if (!$this->hasErrors()) {

             $dbUser = self::find()
                ->where([
                    "email" => $this->email,
                ])
                ->one();

                if (!count($dbUser) ) {
                    $this->addError($attribute, 'No such user exists!');
                }
        }
    }

    public static function findByemail($email)
    {
        return static::findOne(['email' => $email]);
    }


    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    public function getPasswordSecurityToken()
    {
        return $this->password_reset_token = Yii::$app->security->generateRandomString(). '_' . time();
    }


   
    public function updatePasswordResetToken($password_reset_token,$email)
    {
        // $email = 'ronak.patel@ecosmob.com';

        Yii::$app->db->createCommand('UPDATE hoi_admin SET password_reset_token = \''.$password_reset_token.'\' WHERE email=\''.$email.'\'')->execute();
        Yii::$app
            ->mailer
            ->compose(
              ['html' => 'passwordResetToken-html'],
                ['password_reset_token' => $password_reset_token]
            )
            ->setFrom(['ronak.patel@ecosmob.com'])
            // ->setTo('ronak.patel@ecosmob.com')
            ->setTo($email)
            ->setSubject('Admin - Password reset')
            ->send();
        return TRUE;
    }

    public static function checkEmail($data)
    {
        extract($data['ForgotForm']);

        $dbUser = self::find()
                ->where([
                    "email" => $email,
                ])
                ->one();

        // print_r($dbUser);exit;
//                echo "<pre>";
//                 print_r($dbUser);exit();
        if (count($dbUser)) {
            return TRUE;
        }
        return FALSE;
    }
    
}
