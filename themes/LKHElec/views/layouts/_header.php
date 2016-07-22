<header class="header-container">
	<div class="wrapper clearfix">
		<div class="header-top clearfix">
			<div class="logo">
				<a href="<?php echo str_replace('/hr-portal', '/', Yii::app()->getBaseUrl(true)); ?>">
					<img src="<?php echo Yii::app()->theme->baseUrl ?>/themes/img/logo.png" alt="Precicon" />
				</a>
			</div>
			<div class="header-right">
				<div class="form-search" style="visibility: hidden;">
					<img class="alignnone  wp-image-1628" alt="SG50" src="<?php echo Yii::app()->theme->baseUrl ?>/themes/img/SG50-150x150.png" width="50" height="50">
					<form method="get">
						<input type="text" class="input" name="s" placeholder="Enter Keyword">
						<button type="submit" class="btn-1">Search</button>
					</form>
				</div>
			</div>
		</div>
		<?php
		if (isset(Yii::app()->user->id)) {
			$this->widget('MenuWidget', array(
				'layout' => 'lkh-elec-main_menu',
				'menu' => MENU_MAIN,
				'parent' => 0,
			));
		}
		?>
	</div>
</header>



