<!DOCTYPE html>
<html lang="en">
    <head>
		<?php include_once '_head.php'; ?>
    </head>

    <body class="homepage">
        <div class="bigmain">
			<div class="header-container">
				<?php include_once '_header.php'; ?>
			</div>

            <?php if($this->isStaticPage):  //danh cho home page ?>
                <?php echo $content; ?>
            <?php else: // khong file home ?>
                <div class="main">
                    <div class="wrapper clearfix fullwidth">
                        <div class="maincontent">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

		<?php include_once '_footer.php'; ?>
	</body>
	
</html>