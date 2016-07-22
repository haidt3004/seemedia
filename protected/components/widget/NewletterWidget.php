<?php
class NewletterWidget extends CWidget{
    public function run() {
        $model = new Subscriber();
        $this->render("newletter", array(
            'model' => $model,
        ));
    }
}
