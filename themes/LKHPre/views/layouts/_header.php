<header class="header-container">
	<div class="wrapper clearfix">
		<div class="logo"><a href="<?php echo str_replace('/hr-portal', '/', Yii::app()->getBaseUrl(true)); ?>"><img src="<?php echo Yii::app()->theme->baseUrl ?>/themes/img/logo.png" alt="Precicon" /></a></div>
		<div class="group nav-top">
			<?php if(isset(Yii::app()->user->id)){ ?>
				<div class="clearfix">
					<div class="fe-admin">
						<p>Welcome! <a href="<?php echo Yii::app()->createUrl('member/site'); ?>"><?php echo Yii::app()->user->staff_name ?></a></p>
						<p><?php echo date_format(date_create(Yii::app()->user->last_logged_in), 'h:i A / F j, Y '); ?></p>
					</div>
					<a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout') ?>"><button class="btn-logout"><i class="fa fa-arrow-right"></i> LOGOUT</button></a>
				</div>
			<?php } else { ?>
				<div class="clearfix" style="visibility: hidden;">
					<div class="fe-admin">
						<p>Welcome! <a href="#">Ryan</a></p>
						<p>10:00AM / November 23, 2015</p>
					</div>
					<button class="btn-logout"><i class="fa fa-arrow-right"></i> LOGOUT</button>
				</div>
			<?php } ?>

			<?php
			if (isset(Yii::app()->user->id)) {
				$this->widget('MenuWidget', array(
					'layout' => 'lkh-pre-main_menu',
					'menu' => MENU_MAIN,
					'parent' => 0,
				));
			}
			
			?>
		</div>
	</div>
</header>


<script>
	$(document).ready(function() {
		$('#main-menu .inner ul').each(function() {
			if ($(this).text() == '') {
				$(this).remove();
			}
		});
	});
</script>


