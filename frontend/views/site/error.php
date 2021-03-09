<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $name;

?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="rs_transprantbg">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: -158px;">
                <div class="rs_error_section rs_toppadder90 rs_bottompadder90">

                    <img src=<?= Url::to('@web/frontend/web/solnwizfiles/images/error_Icon.png') ?> alt="" class="img-responsive">
                    <div class="re_error_info rs_toppadder20">
                        <h2> <?= nl2br(Html::encode($message)) ?></h2>
                        <span class="rs_toppadder20">The above error occurred while the Web server was processing your request.</span>
                        
                        <p class="rs_toppadder60">Please contact us if you think this is a server error. Thank you.</p>
                        <p><a href='<?= Url::base(); ?>'>HomePage</a> or  <a href='<?= Url::base(); ?>'">Contact us</a>?</p>
                    </div>
                    <div class="rs_error_section_social rs_toppadder60">
                        <ul>
                            <li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                            <li><a href=""><i class="fa fa-pinterest"></i></a></li>
                            <li><a href=""><i class="fa fa-dribbble"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
