<?php

/**
 * This is the model class for table "Author".
 *
 * The followings are the available columns in table 'Author':
 * @property integer $authorId
 * @property string $fullName
 * @property string $photo
 * @property float $index
 */
class Author extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Author';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('fullName', 'length', 'max'=>200),
			array('index', 'numerical'),
			// array('photo', 'length', 'max'=>500),
			array(
                'photo',
                'file',
                'types' => 'bmp,gif,jpeg,jpg',
                'maxSize' => 1024 * 1024 * 5,
                'tooLarge' => Yii::t('application', 'Image has to be smaller than 5MB') ,
                'allowEmpty' => true
            ) ,
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('authorId, fullName, photo', 'safe', 'on'=>'search'),
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
			'categories' => array(self::HAS_MANY,'AuthorCategory','authorId'),
			'articles' => array(self::HAS_MANY,'AuthorArticle','authorId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'authorId' => 'Author',
			'fullName' => 'Full Name',
			'photo' => 'Photo',
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

		$criteria->compare('authorId',$this->authorId);
		$criteria->compare('fullName',$this->fullName,true);
		// $criteria->compare('photo',$this->photo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Author the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		public function beforeSave()
    {
        $photo = CUploadedFile::getInstance($this, 'photo');
        if ($photo) {
            $newFileUrl = '/public/' . time() . '_' . $photo;
            $newFileName = Yii::getPathOfAlias('webroot') . $newFileUrl;
            $oldFileName = Yii::getPathOfAlias('webroot') . $this->photo;
            if ($this->photo && file_exists($oldFileName)) {
                @unlink($oldFileName);
            }
            if (!$photo->saveAs($newFileName)) {
                $this->addError('photo', 'Файл не сохранился');
                
                return false;
            }
            $this->photo = $newFileUrl;
        }
        
        return parent::beforeSave();
    }

    public function afterSave() {

    	if(isset($_POST['AuthorCategory']['categoryId']) && is_array($_POST['AuthorCategory']['categoryId'])) {
    		$r = Yii::app()->db->createCommand('delete From AuthorCategory
			where authorId = :tId')->execute(array(
                                                ':tId' => $this->primaryKey
                                           ));
            $hasCategory = false;
            foreach ($_POST['AuthorCategory']['categoryId'] as $id) {
                $id = intval($id);
				if($id > 0 /* validate if id in avalilable categories */) {
                    $ac = new AuthorCategory();
                    $ac->categoryId = $id;

                    $ac->authorId = $this->primaryKey;
                    if(!$ac->save()) {
                        throw new CException('Can\'t save AuthorCategory model for Author');
                    } else {
                        $hasCategory = true;
                    }
                }
            }

            if(!$hasCategory) {
                $this->addError('categories', 'Нужно указать хотя бы одну категория');
                return false;
            }
        } else {
            $this->addError('categories', 'Нужно указать хотя бы одну категория');
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
						'name' => 'Автор',
						'attribute' => 'fullName',
						'type' => 'text',
					) ,
					array(
                        'name' => 'Категории',
                        'type' => 'view',
                        'viewName' => 'application.views.author._categoryListAdmin',
                        'data' => array(
                            'relation' => 'categories',
                            'relationName' => 'category',
                            'attribute' => 'categoryId',
                            'type' => 'dropdown',
							'fieldName' => 'AuthorCategory[categoryId][]',
							'valueField' => 'categoryId',
							'textField' => 'name',
							'data' => array(
								'model' => Category::getAll() ,
								'valueField' => 'categoryId',
								'textField' => 'name',
							)
                        ),
                    ),
					array(
                        'name' => 'Фото',
                        'attribute' => 'photo',
                        'attributePath' => 'photo',
                        'type' => 'file',
                        'htmlOptions' => array()
                    ) ,
				) ,
				'columns' => array(
					'authorId',
					'fullName',
				)
			)
		);
		
		return CMap::mergeArray(parent::behaviors() , $bs);
	}

    protected static $_avgIndex = array();
    public function getAvarageIndex() {
        if(!self::$_avgIndex[$this->primaryKey] || self::$_avgIndex[$this->primaryKey] <= 0) {
            // $indexes = array();
            // foreach ($this->articles as $article) {
            //     $indexes[] = $article->article->index;
            // }
            // self::$_avgIndex[$this->primaryKey] = array_sum($indexes) / count($indexes);
            self::$_avgIndex[$this->primaryKey] = ArticleAuthor::model()->count('authorId =:aId',array(':aId'=> $this->primaryKey));
        }
        return self::$_avgIndex[$this->primaryKey];
    }

    public function getWorkCount() {
        return count($this->getRelated('articles',true));
    }

    protected static $_all = null;
    public static function getAll() {
        if(!self::$_all) {
            self::$_all = self::model()->findAll();
        }

        return self::$_all;
    }

    public static function updateAllIndexes() {

        $data = Yii::app()->db->createCommand('
            SELECT au.authorId,COUNT(articleId) as acount FROM `Author` au
            LEFT JOIN ArticleAuthor USING(authorId)
            GROUP BY au.authorId')->queryAll();
        $aData = Yii::app()->db->createCommand('
            SELECT au.authorId, COUNT(auar.articleId) as arcount  FROM `Author` au
            LEFT JOIN AuthorArticle auar ON au.authorId = auar.authorId
            GROUP BY au.authorId ')->queryAll();
        $articleCounts = array();
        foreach ($aData as $row) {
            $articleCounts[$row['authorId']] = $row['arcount'];
        }
        foreach ($data as $row) {
            Yii::app()->db->createCommand('
                UPDATE Author set `index` = :ind 
                WHERE authorId = :aId
            ')->execute(array(
                    ':ind' => ($row['acount']),
                    ':aId' => $row['authorId'],
                ));
        }
    }

}
