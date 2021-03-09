 <!--<li class="header">MAIN NAVIGATION</li>-->
            <li class="treeview">
              <a href="<?php  ?>/kslta"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
              
              </a>
            </li> 
          <li class="treeview">
              <a href="#">
                <i class="fa fa-user"></i> <span>Users</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">              
                <li><a href="<?php echo Yii::$app->homeUrl.'?r=rights'; ?>"><i class="fa fa-fw fa-check-circle-o"></i>Rights Management</a></li>
            
                <li><a href="<?php echo Yii::$app->homeUrl.'?r=userdetails'; ?>"><i class="fa fa-fw fa-street-view"></i> User Management</a></li>
              </ul>
            </li>
         
       <li class="treeview">
              <a href="#"><i class="fa fa-fw fa-file-o"></i> <span>Pages</span>
              
              </a>
            </li> 
			<li class="treeview">
              <a href="#"><i class="fa fa-fw fa-object-group"></i> <span>Generic Design</span>
              
              </a>
            </li>
			<li class="treeview">
              <a href="#">
                  <i class="fa fa-fw fa-newspaper-o"></i> <span>News</span>
                  <i class="fa fa-angle-left pull-right"></i>
               <ul class="treeview-menu">   

                <li><a href="<?php echo Yii::$app->homeUrl.'?r=ksl-news-tbl/newsunapproved'; ?>"><i class="fa fa-fw fa-exclamation-triangle"></i>Un-approved List</a></li>
            	<li><a href="<?php echo Yii::$app->homeUrl.'?r=ksl-news-tbl'; ?>"><i class="fa fa-fw fa-check-square-o"></i>Approved List</a></li>

                <li><a href="<?php echo Yii::$app->homeUrl.'?r=ksl-news-tbl/newsrecjected'; ?>"><i class="fa fa-fw fa-ban"></i> Rejected List</a></li>
              </ul>
              </a>
            </li>
              <li class="treeview">
              <a href="#">
                <i class="fa fa-fw fa-file-image-o"></i> <span>Gallery</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">              
                <li><a href="<?php echo Yii::$app->homeUrl.'?r=ksl-gallery-model%2Fcreate'; ?>"><i class="fa fa-fw fa-object-ungroup"></i> Add New Gallery</a></li>
            
                <li><a href="<?php echo Yii::$app->homeUrl.'?r=ksl-gallery-model'; ?>"><i class="fa fa-fw fa-qrcode"></i> Gallery Management</a></li>
              </ul>
            </li>
			<li class="treeview">
              <a href="<?php echo Yii::$app->homeUrl.'?r=ksl-tournaments-tbl'; ?>"><i class="fa fa-fw fa-trophy"></i> <span>Tournament</span>
              
              </a>
            </li>
			
			<li class="treeview">
              <a href="<?php echo Yii::$app->homeUrl.'?r=ksl-players-registration'; ?>"><i class="fa fa-fw fa-user-plus"></i> <span>Player's registration</span>
              
              </a>
            </li>
			<li class="treeview">
              <a href="#"><i class="fa fa-fw fa-calendar-check-o"></i> <span>Events</span>
              
              </a>
            </li>
			<li class="treeview">
              <a href="#"><i class="fa fa-fw fa-cubes"></i> <span>Ranking</span>
              
              </a>
            </li>
            <?php 
          
		  ?>
			<li class="treeview">
              <a href="#"><i class="fa fa-fw fa-globe"></i> <span>Online Forms</span>
              
              </a>
            </li>
           <li class="treeview">
              <a href="#"><i class="fa fa-fw fa-user-secret"></i> <span>Coaching</span>
              
              </a>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-fw fa-sort-numeric-asc"></i> <span>Courts</span>
              
              </a>
            </li>
			<li class="treeview">
              <a href="#"><i class="fa fa-fw fa-check-square-o"></i> <span>Approval</span>
              
              </a>
            </li>
			<li class="treeview">
              <a href="#"><i class="fa fa-fw fa-users"></i> <span>Board Members</span>
              
              </a>
            </li>
			<li class="treeview">
              <a href="#"><i class="fa fa-fw fa-cog"></i> <span>Configuration</span>
              
              </a>
            </li>