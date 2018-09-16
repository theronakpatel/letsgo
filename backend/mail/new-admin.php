<?php
use yii\helpers\Html;

extract($arr);
 
?>


<div style="margin:0px">
      <span class="HOEnZb"><font color="#888888">
                      </font></span><table cellspacing="0" cellpadding="0" border="0" align="center" style="width:650px;height:auto;font-family:Lato,sans-serif;background:#fff">
            <tbody><tr>
        <td>
      <table cellspacing="0" border="0" align="center" style="width:650px;background:#118686">
          <tbody><tr>
            <td>
            <table cellspacing="0" border="0" style="color:#ffffff;padding:10px 5px;height:30px;width:100%;margin:0;font-size:12px;font-weight:600">
                                    <tbody><tr>
                          <td style="height:30px;background:#118686;color:#ffffff">
                              <span style="margin-left:20px;font-family:Arial Regular;font-size:18px">New admin information</span>
                          </td>
                      </tr>
             </tbody></table>
                                     </td><td colspan="2"> 
                </td>
            </tr></tbody></table>
            
            </td>
          </tr>
                      
                      <tr>
                          <td style="height:115px;border:1px solid #118686;color:#747474;text-align:justify;padding:13px;font-size:14px;line-height:23px">
                                    Hello <?=$name ?>, <br><br>You are now admin in HOI app. Please use below credentials to sign in into portal.<br><br>

<?php 
   $start_table = '<table border="0" width="100%" style="border:0;">';

    $start_table .= '<tr>';
    $start_table .= '<th align="left">URL: </th>';
    $start_table .= '<td  align="left"><a href="'.$url.'">HOI Admin Portal</a></td>';
    $start_table .= '</tr>';
    
    $start_table .= '<tr>';
    $start_table .= '<th align="left">Email: </th>';
    $start_table .= '<td  align="left">'.$email.'</td>';
    $start_table .= '</tr>';
    
    $start_table .= '<tr>';
    $start_table .= '<th align="left">Password: </th>';
    $start_table .= '<td  align="left">'.$password.'</td>';
    $start_table .= '</tr>';

          
    $start_table .= '</table>';

    echo $start_table;

  ?>


 <br><br>
Thanks, <br>
HOI App.
                          </td></tr>
                      <tr style="height:15px">
                      </tr>
            
      </tbody></table><div class="yj6qo ajU"><div tabindex="0" role="button" class="ajR" id=":nw" data-tooltip="Show trimmed content" aria-label="Show trimmed content"><img src="//ssl.gstatic.com/ui/v1/icons/mail/images/cleardot.gif" class="ajT"></div></div><span class="HOEnZb adL"><font color="#888888">
  </font></span></div>