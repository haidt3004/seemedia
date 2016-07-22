<footer class="footer-container">
	<div class="footer-links">
		<div class="wrapper clearfix">
			<div class="group">
				<h4>Company</h4>
				<?php
				$this->widget('MenuWidget', array(
					'layout' => 'lkh-power-footer_menu',
					'menu' => MENU_FOOTER_COMPANY,
					'parent' => 0,
				));
				?>
			</div>
			<div class="group">
				<h4>related links</h4>
				<?php
				$this->widget('MenuWidget', array(
					'layout' => 'lkh-power-footer_menu',
					'menu' => MENU_FOOTER_RELATED_LINKS,
					'parent' => 0,
				));
				?>

			</div>
		</div>
	</div>
	<div class="wrapper clearfix copyright">
        <?php echo Yii::app()->params['copyrightOnFooter']  ?>
		<!-- Copyright &copy; 2016 LKH Power Distribution. All rights reserved. <a href="" target="_blank">Web design</a> by <span class="verz">Verz</span> -->
	</div>
</footer>


<script src="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/js/plugins.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/themes/js/main-2.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/themes/js/custom.js"></script>

<script>
	$(document).ready(function() {
		// add class active menu
		// main menu
		var currentURL = document.URL;
		$('#menu > li').each(function () {
			var selectedURL = $(this).find('.inner > a').attr('href');
			if (selectedURL == currentURL) {
				$(this).addClass('active');
			}

			var baseUrl = currentURL + 'site/index';
			if (selectedURL == baseUrl) {
				$(this).addClass('active');
			}
		});

		// footer menu
		$('#footer-menu > a').each(function() {
			var selectedURL = $(this).attr('href');
			if (selectedURL == currentURL) {
				$(this).addClass('active');
			}

			var baseUrl = currentURL + 'site/index';
			if (selectedURL == baseUrl) {
				$(this).addClass('active');
			}
		});
		// end add class active menu
	});
</script>