<footer class="footer-container gradient">
	<div class="wrapper clearfix">
		<div class="group-1">
			<?php
			$this->widget('MenuWidget', array(
				'layout' => 'lkh-pre-footer_menu',
				'menu' => MENU_FOOTER_01,
				'parent' => 0,
			));
			?>
		</div>
		<div class="group-2">
			<?php
			$this->widget('MenuWidget', array(
				'layout' => 'lkh-pre-footer_menu',
				'menu' => MENU_FOOTER_02,
				'parent' => 0,
			));
			?>
		</div>
		<div class="group-3">
			<?php
			$this->widget('MenuWidget', array(
				'layout' => 'lkh-pre-footer_menu',
				'menu' => MENU_FOOTER_03,
				'parent' => 0,
			));
			?>
		</div>
		<div class="group-5">
			<h4>SUBSCRIBE TO NEWSLETTER</h4>
			<p>Get the lastest updates!</p>
			<div class="newsletter-form clearfix">
				<input type="text" placeholder="Your email address" />
				<button type="button" class="button">Go</button>
			</div>
		</div>
		<div class="group-6">
			<ul class="social-media">
				<li><a target="_blanl" href="https://www.facebook.com/precicon" class="facebook">Facebook</a></li>
				<li><a target="_blanl" href="https://twitter.com" class="twitter">Twitter</a></li>
				<li><a target="_blanl" href="https://www.youtube.com/" class="youtube">Youtube</a></li>
			</ul>
            <?php echo Yii::app()->params['copyrightOnFooter']  ?>
<!-- 			<p>Copyright &copy; 2016 LKH PRECICON PTE LTD</p>
			<p>Ecommerce Solutions by <a href="http://www.verzdesign.com/" target="_blank" class="verz">Verz</a></p> -->
		</div>
	</div>
</footer>


<script src="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/js/plugins.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/themes/js/main-1.js"></script>
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