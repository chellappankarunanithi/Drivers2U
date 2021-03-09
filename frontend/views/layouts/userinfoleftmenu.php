<div class="user-info" style="height:100px;background-color:#e1e1e1;">
                <div class="image">
                    <img src="<?= Url::to('@web/frontend/web/img/profile-img.jpg') ?>" width="48" height="48" alt="User" />
                    <div><h5><?php echo $ba_name;?></h5></div>
                    
                    
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href='#' ><i class="material-icons">person</i> Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
							 <!-- <li><a href='<?php echo Yii::$app->homeUrl."?r=users-profile/update&id=".Yii::$app->user->getId(); ?>' ><i class="material-icons">group</i> Edit Profile</a></li>
							 <li><a href='<?php echo Yii::$app->homeUrl."?r=users-profile/password&id=".Yii::$app->user->getId(); ?>' ><i class="material-icons">lock</i> Change Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li> -->
                            <li role="seperator" class="divider"></li>
                             <li><?= Html::a('<i class="material-icons">input</i>Sign Out', ['index.php/login'], [
                       
                        'data' => [
                            'method' => 'post',
                        ],
                    ]) ?></li> 
                   <!--  <li>
                        <?php
                        echo '<a>'
                                . Html::beginForm(['index.php/login'], 'post')
                                . Html::submitButton(
                                    '<i class="fa fa-fw fa-sign-out"></i> Logout',
                                    ['class' => 'btn btn-default btn-flat']
                                )
                                . Html::endForm()
                                . '</a>';

                        ?>

                    </li> -->
                        </ul>
                    </div>
                    
                </div>
                
               
            </div>