<?php
/**
 * @Author Haidt <haidt3004@gmail.com>
 * @copyright 2015 Verz Design 	 	 
 * @Todo: build main menu
 */
$controllerName = Yii::app()->controller->id;
$actionName = Yii::app()->controller->action->id;
$currUrl = Yii::app()->request->hostInfo . Yii::app()->request->requestUri;
?>

<nav id="sub-menu" class="nav">
	<div id="topMenu">
		<?php if (!empty($menu_items)) : ?>
			<ul class="menu">
				<?php foreach ($menu_items as $key => $item) : ?>
					<?php
					if ($item->type == Menuitem::TYPE_LINK) { //type: external link
						$link = $item->link;
					} else if ($item->type == Menuitem::TYPE_CMS_PAGE) {//type: cms page
						$page = Page::model()->getSlugById($item->link);
						if ($page) {
							$link = Yii::app()->createAbsoluteUrl('/' . $page->slug);
						}
					} else {//type: statics page
						$link = Yii::app()->createAbsoluteUrl('/' . $item->link);
					}
					$class = "";

					//end
					$sub_menu_items = Menuitem::model()->findAll("parent_id = $item->id");
					if (count($sub_menu_items) > 0) {
						foreach ($sub_menu_items as $k => $sub_item) {
							if ($sub_item->type == Menuitem::TYPE_LINK) {
								$link_sub = $sub_item->link;
							} else if ($sub_item->type == Menuitem::TYPE_CMS_PAGE) {
								$page_sub = Page::model()->getSlugById($sub_item->link);
								$link_sub = Yii::app()->createAbsoluteUrl('/' . $page_sub->slug);
							} else {
								$link_sub = Yii::app()->createAbsoluteUrl('/' . $sub_item->link);
							}
							$class = $link_sub == $currUrl ? 'selected' : '';
							if (!empty($class)) {
								continue;
							}
						}
					} else {
						$class = $link == $currUrl ? 'selected' : '';
					}
					if (empty($class)) {
						$action = Yii::app()->createAbsoluteUrl($controllerName.'/index');
						$class = $action == $link ? 'selected' : '';
					}
					?>
					<li class="<?php echo $class; ?>"><a href="<?php echo $link; ?>"><?php echo $item->name; ?></a>
						<?php if ($sub_menu_items) : ?>
							<ul>
								<?php foreach ($sub_menu_items as $k => $sub_item) : ?>
									<?php
									if ($sub_item->type == Menuitem::TYPE_LINK) {
										$link_sub = $sub_item->link;
									} else if ($sub_item->type == Menuitem::TYPE_CMS_PAGE) {
										$page_sub = Page::model()->getSlugById($sub_item->link);
										$link_sub = Yii::app()->createAbsoluteUrl('/' . $page_sub->slug);
									} else {
										$link_sub = Yii::app()->createAbsoluteUrl('/' . $sub_item->link);
									}
									?>
									<li><a href="<?php echo $link_sub; ?>"><?php echo $sub_item->name; ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</nav>