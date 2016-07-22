<footer class="footer-container">
	<div class="footer-top">
		<div class="wrapper clearfix">
			<div class="group-1">
				<div class="links">
					<h5 class="title-2">SITEMAP</h5>
					<?php
					$this->widget('MenuWidget', array(
						'layout' => 'lkh-elec-footer_menu',
						'menu' => MENU_FOOTER,
						'parent' => 0,
					));
					?>
				</div>
				<div class="contact-us">
					<h5 class="title-2">CONTACT US</h5>
					<p>Lim Kim Hai Electric Co (S) Pte. Ltd.</p>
					<address>Lim Kim Hai Building,<br> 53 Kallang Place,<br> Singapore 339177</address>
					<a href="mailto:customerservice@limkimhai.com.sg">customerservice@limkimhai.com.sg</a>
				</div>
			</div>
			<div class="group-2">
				<div class="logos">
					<img style="margin-top: 8px; margin-bottom: 8px; " alt="SG50" src="<?php echo Yii::app()->theme->baseUrl ?>/themes/img/SG50-150x150.png" width="50" height="50"><br>
					<img style="line-height: 1.5em;" alt="Logos" src="<?php echo Yii::app()->theme->baseUrl ?>/themes/img/logo-6.jpg">
					<a style="line-height: 1.5em;" href="#" target="_blank">
						<img alt="Logos" src="<?php echo Yii::app()->theme->baseUrl ?>/themes/img/logo-7.jpg">
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="wrapper clearfix">
			<div class="copy-right">
                <?php echo Yii::app()->params['copyrightOnFooter']  ?>
<!-- 				<p>Copyright © 2015 Lim Kim Hai Electric Co (S) Pte. Ltd. All Rights Reserved.
					<a href="http://www.verzdesign.com/" target="_blank">Web Design</a> by <span class="verz">Verz</span></p> -->
			</div>
			<div class="social">
				<ul class="list-social">
					<li class="fb first"><a href="<?php echo Yii::app()->setting->getItem('facebook'); ?>" target="_blank"></a></li>
					<li class="tw" style="display:none"><a href="#"></a></li>
					<li class="lk last"><a href="<?php echo Yii::app()->setting->getItem('linkedin'); ?>" target="_blank"></a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>




<script src="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/js/plugins.js"></script>
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