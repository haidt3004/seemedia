<div class="wrapper">
    <div class="clearfix">
        <div class="logo">
            <a href="<?php echo str_replace('/hr-portal', '/', Yii::app()->getBaseUrl(true)); ?>">
                <img src="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/img/taisin-logo.jpg" alt="Tai Sin"/>
            </a>
        </div>

        <?php if (isset(Yii::app()->user->id)) { ?>
            <div class="pull-right">
                <form id="form-language-change" method="post" style="display: inline;">
                    <div class="form-horizontal pull-right">
                        <?php
                        $languages = Languages::getListLanguageFE();
                        ?>
                        <select class="form-control" name="lang" id="language-change">
                            <?php foreach ($languages as $language_key =>  $language_value): ?>
                                <option value="<?php echo $language_key; ?>" <?php echo ($language_key == Yii::app()->language) ? 'selected': ''; ?>><?php echo $language_value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>

        <?php } ?>

    </div>

    <?php

    if (isset(Yii::app()->user->id)) {
        $this->widget('MenuWidget', array(
            'layout' => 'main_menu',
            'menu' => MENU_MAIN,
            'parent' => 0,
        ));
    }
    ?>
</div>

<script>
    $(document).ready(function () {
        $("#language-change").change(function () {
            $('#form-language-change').submit();
        });
    });
</script>

