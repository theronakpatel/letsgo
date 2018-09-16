<?php
use yii\helpers\Html;
$this->title = $name;
?>
 <div>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
           
                 <h1><?= Html::encode($this->title) ?></h1>
                 <h4><?= nl2br(Html::encode($message)) ?></h4>
          </section>
        </div>

      </div>
    </div>