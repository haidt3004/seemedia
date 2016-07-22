<header class="header-container">
	<div class="wrapper clearfix">
		<div class="logo"><a href="<?php echo str_replace('/hr-portal', '/', Yii::app()->getBaseUrl(true)); ?>">
				<img src="<?php echo Yii::app()->theme->baseUrl ?>/themes/img/LKH-Projects-Distribution-Portal.png" alt="Precicon" />
			</a>
		</div>
		<div class="nav-top-2">
			<div class="group">
				<p>LKH POWER DISTRIBUTION PTE LTD</p>
				<address>Lim Kim Hai Building,<br/>
					53 Kallang Place, 1st Storey<br/>
					Singapore 339177</address>
			</div>
			<div class="quick-search clearfix" style="visibility: hidden;">
				<input type="text" class="text" placeholder="Search..." />
				<input type="submit" class="btn-search" value="Go" />
			</div>
		</div>
	</div>
</header>
<div class="menu">
	<?php
	if (isset(Yii::app()->user->id)) {
		$this->widget('MenuWidget', array(
			'layout' => 'lkh-power-main_menu',
			'menu' => MENU_MAIN,
			'parent' => 0,
		));
	}
	?>
</div>

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

