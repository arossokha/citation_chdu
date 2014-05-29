<?php

/**
 * This is the model class for table "Article".
 *
 * The followings are the available columns in table 'Article':
 * @property integer $articleId
 * @property string $name
 * @property integer $categoryId
 * @property double $index
 * @property integer $year
 * @property string $file
 */
class Article extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('categoryId', 'numerical', 'integerOnly'=>true),
			array('index, year', 'numerical'),
			array('name', 'length', 'max'=>200),
			// array('file', 'length', 'max'=>500),
			array(
                'file',
                'file',
                'types' => 'pdf',
                'maxSize' => 1024 * 1024 * 10,
                'tooLarge' => Yii::t('application', 'Document has to be smaller than 10MB') ,
                'allowEmpty' => true
            ) ,
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('articleId, name, categoryId, index, year, file', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO,'Category','categoryId'),
			'authors' => array(self::HAS_MANY,'AuthorArticle','articleId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'articleId' => 'Article',
			'name' => 'Name',
			'categoryId' => 'Category',
			'index' => 'Index',
			'year' => 'Year',
			'file' => 'File',
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

		$criteria->compare('articleId',$this->articleId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('categoryId',$this->categoryId);
		$criteria->compare('year',$this->year);
		$criteria->compare('index',$this->index);
        // $criteria->compare('file',$this->file,true);
        $criteria->order = '`index` DESC';
		$criteria->with = array('category','authors.author');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
    {
        $file = CUploadedFile::getInstance($this, 'file');
        if ($file) {
            $newFileUrl = '/public/' . time() . '_' . $file;
            $newFileName = Yii::getPathOfAlias('webroot') . $newFileUrl;
            $oldFileName = Yii::getPathOfAlias('webroot') . $this->file;
            if ($this->file && file_exists($oldFileName)) {
                @unlink($oldFileName);
            }
            if (!$file->saveAs($newFileName)) {
                $this->addError('file', 'Файл не сохранился');
                
                return false;
            }
            $this->file = $newFileUrl;
        } elseif(strpos($_POST[get_class($this)]['file'],'http://') !== false) {
            $this->file = $_POST[get_class($this)]['file'];
        } else {
            if ($this->isNewRecord) {
                $this->addError('file', 'Укажите файл');
                
                return false;
            }
        }
        
        return parent::beforeSave();
    }

    public function afterSave() {

    	if(isset($_POST['AuthorArticle']['authorId']) && is_array($_POST['AuthorArticle']['authorId'])) {
    		$r = Yii::app()->db->createCommand('delete From AuthorArticle
			where articleId = :tId')->execute(array(
                                                ':tId' => $this->primaryKey
                                           ));
            $hasCategory = false;
            foreach ($_POST['AuthorArticle']['authorId'] as $id) {
                $id = intval($id);
				if($id > 0 /* validate if id in avalilable authors */) {
                    $ac = new AuthorArticle();
                    $ac->authorId = $id;
                    $ac->articleId = $this->primaryKey;

                    if(!$ac->save()) {
                        throw new CException('Can\'t save AuthorArticle model for Article');
                    } else {
                        $hasCategory = true;
                    }
                }
            }

            if(!$hasCategory) {
                $this->addError('authors', 'Нужно указать хотя бы одного автора');
                return false;
            }
        } else {
            $this->addError('authors', 'Нужно указать хотя бы одного автора');
            return false;
    	}

        /**
         * @TODO MOVE TO CORRECT PLACE
         */
        Author::updateAllIndexes();

    	return parent::afterSave();
    }

	public function behaviors() {
		$bs = array(
			'AdminBehavior' => array(
				'class' => 'application.admin.components.behaviours.AdminBehavior',
				'fields' => array(
					array(
						'name' => 'Статья',
						'attribute' => 'name',
						'type' => 'text',
					) ,
					array(
						'name' => 'Категория',
						'attribute' => 'categoryId',
						'type' => 'dropdown',
						'data' => array(
							'model' => Category::getAll() ,
							'valueField' => 'categoryId',
							'textField' => 'name',
						)
					) ,
					array(
						'name' => 'Year',
						'attribute' => 'year',
						'type' => 'text',
					) ,
					array(
						'name' => 'Index',
						'attribute' => 'index',
						'type' => 'number',
					) ,
					array(
                        'name' => 'Авторы',
                        'type' => 'view',
                        'viewName' => 'application.views.article._authorListAdmin',
                        'data' => array(
                            'relation' => 'authors',
                            'relationName' => 'author',
                            'attribute' => 'authorId',
                            
                            'type' => 'dropdown',
                            'data' => array(
								'model' => Author::getAll() ,
								'valueField' => 'authorId',
								'textField' => 'fullName',
							),
							'valueField' => 'authorId',
							'textField' => 'fullName',
							'fieldName' => 'AuthorArticle[authorId][]',
                        ),
                    ),
					array(
                        'name' => 'Документ',
                        'attribute' => 'file',
                        'attributePath' => 'file',
                        'type' => 'filedoc',
                        'htmlOptions' => array()
                    ) ,
				) ,
				'columns' => array(
					'articleId',
					'name',
					'category.name'
				)
			)
		);
		
		return CMap::mergeArray(parent::behaviors() , $bs);
	}

	public function getAuthorsList($asString = true) {

		$data = array();
		foreach ($this->authors as $author) {
			$data[$author->authorId] = $author->author->fullName;
		}

		if($asString) {
			return implode(',',$data);
		}
		return $data;
	}
}
