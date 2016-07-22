<?php
class HomeEventsWidget extends CWidget{
    public function run() {
        $models = Events::model()->getLatest();
        $this->render("home_events", array(
            'models' => $models,
        ));
    }
}
