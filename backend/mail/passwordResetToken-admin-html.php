<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

// $resetLink = 'http://192.168.1.108/hoi/backend/login/resetpassword?token='.$password_reset_token;
$resetLink = Yii::$app->params['site_url'].'backend/login/resetpassword?token='.$password_reset_token;


?>
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="background-color:#c4daf7;border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;">
      <tr>
        <td>&nbsp;</td>
        <td class="container" style="display: block;margin: 0 auto !important;max-width: 580px;padding: 10px;width: auto !important;width: 580px;">
          <div class="content" style="box-sizing: border-box;display: block;margin: 0 auto;max-width: 580px;padding: 10px;">

            <!-- START CENTERED WHITE CONTAINER -->
<!--             <span class="preheader">Request for new password!</span>
 -->            <table class="main" style="background: #fff;border-radius: 3px;width: 100%;">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="box-sizing: border-box;padding: 20px;">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">Hi <?=$admin_firstname ?>,</p>
                        <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">You have requested to reset your password.<br>You can change your password by using below link.</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;">
                          <tbody>
                            <tr>
                              <td align="left">
                                <table border="0" cellpadding="0" cellspacing="0">
                                  <tbody>
                                    <tr>
                                      <td> <?= Html::a('Click here to reset password', $resetLink,['style' => 'background-color: #ffffff;border: solid 1px #3498db;border-radius: 5px;box-sizing: border-box;color: #3498db;cursor: pointer;display: inline-block;font-size: 14px;font-weight: bold;margin: 0;padding: 12px 25px;text-decoration: none;text-transform: capitalize;']); ?> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <br>
                        <small  style="font-family: sans-serif;font-weight: normal;margin-top: 15px;margin-bottom: 15px;"><i>[Note: Above link will be used only once to reset password. If you dont want to reset password, ignore this email.]</i></small>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <!-- END MAIN CONTENT AREA -->
              </table>

            <!-- START FOOTER -->
            <div class="footer" style="clear: both;padding-top: 20px;text-align: center;width: 100%;">
              <table border="0" cellpadding="0" cellspacing="0" style="background-color:#c4daf7;border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;color:white;">
                <tr>
                  <td class="content-block" style="color: white;font-size: 12px;text-align: center;">
                    <span class="apple-link" style="color: white;font-size: 12px;text-align: center;"><b>HOI App</b></span>
                    <!-- <br> Don't like these emails? <a href="http://i.imgur.com/CScmqnj.gif">Unsubscribe</a>. -->
                  </td>
                </tr> 
              </table>
            </div>

</div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
