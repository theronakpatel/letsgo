<?php
use yii\helpers\Html;

$data = json_decode($data,true);

?>


<div style="margin:0px">
      <span class="HOEnZb"><font color="#888888">
                      </font></span><table cellspacing="0" cellpadding="0" border="0" align="center" style="width:650px;height:auto;font-family:Lato,sans-serif;background:#fff">
            <tbody><tr>
        <td>
      <table cellspacing="0" border="0" align="center" style="width:650px;background:#f44336">
          <tbody><tr>
            <td>
            <table cellspacing="0" border="0" style="color:#ffffff;padding:10px 5px;height:30px;width:100%;margin:0;font-size:12px;font-weight:600">
                                    <tbody><tr>
                          <td style="height:30px;background:#f44336;color:#ffffff">
                              <span style="margin-left:20px;font-family:Arial Regular;font-size:18px">Polycab Loyalty Report : Redemption user information</span>
                          </td>
                      </tr>
             </tbody></table>
                                     </td><td colspan="2"> 
                </td>
            </tr></tbody></table>
            
            </td>
          </tr>
                      
                      <tr>
                          <td style="height:115px;border:1px solid #f44336;color:#747474;text-align:justify;padding:13px;font-size:14px;line-height:23px">
                                    Hello Admin, <br><br>Here is redemption details of polycab users.<br><br>

<?php 
   $start_table = '<table border="1" width="100%" style="border:1px solid #f44336;">';

    $start_table .= '<tr>';
    $start_table .= '<th align="center">Name</th>';
    $start_table .= '<th align="center">Phone number</th>';
    $start_table .= '<th align="center">User Type</th>';
    $start_table .= '<th align="center">Loyalty Points</th>';
    $start_table .= '</tr>';

    foreach ($data as $key => $value) {
        
           
           if(
               ($value['user_type'] == 'R' && $value['loyalty_points'] > $redemption_retailer) 
            || ($value['user_type'] == 'D' && $value['loyalty_points'] > $redemption_dealer) 
            || ($value['user_type'] == 'E' && $value['loyalty_points'] > $redemption_elect) 
            ) 
           {
                $start_table .= '<tr>';
                $start_table .= '<td  align="center">'.$value['name'].'</td>';
                $start_table .= '<td  align="center">'.$value['phone'].'</td>';
                $start_table .= '<td  align="center">'.(($value['user_type'] == 'R')?'Retailer':(($value['user_type'] == 'D')?'Dealer':'Electrician')).'</td>';
                $start_table .= '<td  align="center">'.$value['loyalty_points'].'</td>';
                $start_table .= '</tr>';
           }

        
        
    }
    $start_table .= '</table>';

    echo $start_table;

  ?>


 <br><br>
Thanks, <br>
Polycab.
                          </td></tr>
                      <tr style="height:15px">
                      </tr>
            
      </tbody></table><div class="yj6qo ajU"><div tabindex="0" role="button" class="ajR" id=":nw" data-tooltip="Show trimmed content" aria-label="Show trimmed content"><img src="//ssl.gstatic.com/ui/v1/icons/mail/images/cleardot.gif" class="ajT"></div></div><span class="HOEnZb adL"><font color="#888888">
  </font></span></div>