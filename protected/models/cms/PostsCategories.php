<?php

/**
 * This is the model class for table "{{_posts_categories}}".
 *
 * The followings are the available columns in table '{{_posts_categories}}':
 * @property string $id
 * @property string $post_id
 * @property string $category_id
 */
class PostsCategories extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_posts_categories}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_id, category_id', 'required'),
			array('post_id, category_id', 'length', 'max'=>20),
		 array('id,post_id,category_id', 'required', 'on' => 'create, update'), 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, post_id, category_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'blog' => array(self::BELONGS_TO, 'News', 'post_id'),
			'blog_category' => array(self::BELONGS_TO, 'NewsCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation','ID'),
			'post_id' => Yii::t('translation','Post'),
			'category_id' => Yii::t('translation','Category'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('category_id',$this->category_id,true);
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ),
		));
	}

	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PostCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PostCategory::model()->count() + 1;
	}
	
	public function saveRecord($post_id, $category_id) {
		$model = new PostsCategories() ;
		$model->post_id = $post_id;
		$model->category_id = $category_id;
		if($model->save()) {
			return true;
		} 
		return false;
	}
	
	public function deleteAllByPost($post_id) {
		$criteria=new CDbCriteria;
		$criteria->compare('post_id',$post_id);
		self::model()->deleteAll($criteria);
	}
	
	public function deleteAllByCategory($category_id) {
		$criteria=new CDbCriteria;
		$criteria->compare('category_id',$category_id);
		self::model()->deleteAll($criteria);
	}
	
	public function getByPost($post_id) {
		$criteria=new CDbCriteria;
		$criteria->compare('post_id',$post_id);
		return self::model()->find($criteria);
	}
        
        public function getAllByPost($post_id) {
		$criteria=new CDbCriteria;
		$criteria->compare('post_id',$post_id);
		return self::model()->findAll($criteria);
	}
	
	public function getAllByCategoryGrid($category_id) {
		$criteria=new CDbCriteria;
		$criteria->with = array('blog');
		$criteria->compare('t.category_id',$category_id);
		$criteria->compare('blog.status',STATUS_ACTIVE);
		$criteria->order = 'blog.modified_date DESC, blog.created_date DESC';
		return new CActiveDataProvider('PostsCategories', array(
                'criteria'=>$criteria,
                'pagination' => array(
					'pageSize' => 3,
				),
        ));
	}
	
	public static function getCategoryName($post_id) {
		$name = '';
		$model = self::model()->getByPost($post_id);
		if($model) {
			$category_id = $model->category_id;
			$category = NewsCategory::model()->findByPk($category_id);
			$name = $category->category_name;
		}
		return $name;
	}
        
        public static function getAllCategoryName($post_id) {
		$name = array();
		$model = self::model()->getAllByPost($post_id);
		if($model) {
                    foreach ($model as $item) {
			$category_id = $item->category_id;
			$category = NewsCategory::model()->findByPk($category_id);
			$name[] = $category->category_name;
                    }
		}
                if (!empty($name)) {
                    $str = implode(', ', $name);
                    return $str;
                }
		return '';
	}
}
