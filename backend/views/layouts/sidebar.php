<?php $root_val = Yii::$app->controller->id; //current controller id ?>
<?php $child_val = Yii::$app->controller->action->id; //current controller action id
//echo $child_val;
//die;
?>



<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li >
                    <a href="<?=$bUrl ?>" class="<?= ($root_val == 'site')?'active':'' ?>">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li >
                    <a href="<?=$bUrl ?>countries" class="<?= ($root_val == 'countries')?'active':'' ?>">
                        <i class="fa fa-building-o"></i>
                        <span>Country Management</span>
                    </a>
                </li>
                <li >
                    <a href="<?=$bUrl ?>sliders" class="<?= ($root_val == 'sliders')?'active':'' ?>">
                        <i class="fa fa-image"></i>
                        <span>Sliders Management</span>
                    </a>
                </li>

                <li >
                    <a href="<?=$bUrl ?>customer" class="<?= ($root_val == 'customer')?'active':'' ?>">
                        <i class="fa fa-users"></i>
                        <span>Customer Management</span>
                    </a>
                </li>

                <li >
                    <a href="<?=$bUrl ?>category" class="<?= ($root_val == 'category')?'active':'' ?>">
                        <i class="fa fa-list"></i>
                        <span>Category Management</span>
                    </a>
                </li>



                <li >
                    <a href="<?=$bUrl ?>posts" class="<?= ($root_val == 'posts')?'active':'' ?>">
                        <i class="fa fa-compass"></i>
                        <span>Posts Management</span>
                    </a>
                </li>

                <li >
                    <a href="<?=$bUrl ?>promotion" class="<?= ($root_val == 'promotion')?'active':'' ?>">
                        <i class="fa fa-anchor"></i>
                        <span>Promotion Management</span>
                    </a>
                </li>

                <li >
                    <a href="<?=$bUrl ?>activationcode" class="<?= ($root_val == 'activationcode')?'active':'' ?>">
                        <i class="fa fa-thumbs-up"></i>
                        <span>Activationcode Management</span>
                    </a>
                </li>
                

                
 

            </ul>            
        </div>
    </div><!-- sidebar menu end-->
</aside><!--sidebar end-->