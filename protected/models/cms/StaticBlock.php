<?php

/**
 * This is the model class for table "{{_static_block}}".
 *
 * The followings are the available columns in table '{{_static_block}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 */
class StaticBlock extends CActiveRecord {

	public function tableName() {
		return '{{_static_block}}';
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required', 'on'=>'create, update'),
			array('content', 'safe'),
		);
	}

	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('content', $this->content, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public static function getBlockContent($blockId) {
		$field = is_numeric($blockId) ? 'id' : 'slug';
		$model = self::model()->findByAttributes(array($field => $blockId));
		$content = $model ? $model->content : '';
		// replace markup
		$content = str_replace('{{BASE_URL}}', Yii::app()->request->getBaseUrl(true), $content);
		return $content;
	}

	public function nextOrderNumber() {
		return StaticBlock::model()->count() + 1;
	}
        
        public function behaviors() {
            return array('sluggable' => array(
                    'class' => 'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
                    'columns' => array('title'),
                    'unique' => true,
                    'update' => true,
                ),);
        }

}
