<footer class="footer-container">
	<div class="wrapper clearfix">
		<div class="footer-top">
            		<?php echo Yii::app()->params['copyrightOnFooter']  ?>
			<!-- COPYRIGHT © 2016. ALL RIGHTS RESERVED CAST LABORATORIES PTE LTD -->
			<?php
			$this->widget('MenuWidget', array(
				'layout' => 'cast-lab-footer_menu',
				'menu' => MENU_FOOTER,
				'parent' => 0,
			));
			?>
		</div>
	</div>
</footer>


<script src="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/js/plugins.js"></script>
<!--<script src="--><?php //echo Yii::app()->theme->baseUrl ?><!--/themes/js/main-3.js"></script>-->
<script src="<?php echo Yii::app()->theme->baseUrl ?>/themes/js/main.js"></script>
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