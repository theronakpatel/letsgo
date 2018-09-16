
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">

    <a href="<?=$bUrl ?>" class="logo">
        <img src="<?=$bUrl?>logo.png" alt="" width="100" height="50">
    </a>
   <!--  <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div> -->
</div>
<!--logo end-->
 

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
<!--             <a data-toggle="dropdown" class="dropdown-toggle" href="#" id="phone_open">
                <i class="fa fa-phone"></i>
            </a> -->
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <!-- <img alt="" src="images/avatar1_small.jpg"> -->
                <span class="username"><?php 

                $name = isset(Yii::$app->user->identity->name)?Yii::$app->user->identity->name:'';
                $email = isset(Yii::$app->user->identity->email)?Yii::$app->user->identity->email:'';
                    echo '<b>';
                    print_r($name.' ('.$email.')'); 
                    echo '</b>';
                     
                    echo '</b>';
                    ?></span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <!-- <li><a href="<?=$bUrl ?>profile/update"><i class=" fa fa-pencil"></i> Edit Profile</a></li> -->
                <!-- <li><a href="<?=$bUrl ?>profile/changepassword"><i class=" fa fa-key"></i> Change Password</a></li> -->
                <!-- <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li> -->
                <li><a href="<?=$bUrl ?>site/logout" id="logout_click"><i class="fa fa-power-off"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
     <!--    <li>
            <div class="toggle-right-box">
                <div class="fa fa-bars"></div>
            </div>
        </li> -->
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->

 