<header class="header-container">
	<div class="wrapper clearfix">
		<div class="header-top clearfix">
			<div class="logo">
				<a href="<?php echo str_replace('/hr-portal', '/', Yii::app()->getBaseUrl(true)); ?>">
					<img src="<?php echo Yii::app()->theme->baseUrl ?>/themes/img/logo.png" alt="Precicon" />
				</a>
			</div>
			<div class="header-right">
				<div class="dropdown">
					<button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Singapore
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dLabel">
						<li class="selected">Singapore</li>
						<li class="">Malaysia</li>
						<li class="last">Indonesia</li>
					</ul>
				</div>
				<div id="login">
					<?php if(isset(Yii::app()->user->id)){ ?>
						<a target="_self" href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>"><img src="<?php echo Yii::app()->theme->baseUrl ?>/themes/img/login-btn.png" border="0"></a>
					<?php } ?>
				</div>
				<?php
				if (isset(Yii::app()->user->id)) {
					$this->widget('MenuWidget', array(
						'layout' => 'cast-lap-main_menu',
						'menu' => MENU_MAIN,
						'parent' => 0,
					));
				}
				?>
			</div>
		</div>
	</div>
</header>

<script>
	$(document).ready(function() {
		console.log($('#main-menu .inner ul').text());
		$('#main-menu .inner ul').each(function() {
			if ($(this).text() == '') {
				$(this).remove();
			}
		});
	});
</script>



