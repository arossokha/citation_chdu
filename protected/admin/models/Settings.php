<?php
/**
 * Setting for site
 * @author:  
 */
class Settings extends CFormModel
{

	public $name;

	public $about;
	public $aboutPageTitle;
	public $aboutKeywords;
	public $aboutDescription;

	public $sitemap;
	public $sitemapPageTitle;
	public $sitemapKeywords;
	public $sitemapDescription;

	public $contact;
	public $contactPageTitle;
	public $contactKeywords;
	public $contactDescription;

	public $adv;
	public $advPageTitle;
	public $advKeywords;
	public $advDescription;


	public $leftBanner;
	public $leftBannerUrl;
	public $feedbackEmail;


	public $showTime;
	//	public $keywords;
	//	public $description;
	//	public $info;

	protected $fileName = 'settings.bin';

	public function init()
	{
		if ( file_exists($this->getSavePath() . $this->fileName) ) {
			$this->setAttributes(unserialize(file_get_contents($this->getSavePath() . $this->fileName)));
		}
		return parent::init();
	}

	public function rules()
	{
		return array(
			array('name, leftBanner, about, aboutPageTitle, aboutKeywords, aboutDescription,sitemap,sitemapPageTitle,
				sitemapKeywords,sitemapDescription, adv, advPageTitle, advKeywords, advDescription
				contact, showTime, contactPageTitle, contactKeywords, contactDescription', 'safe'),
			array('feedbackEmail','email')
			//			array('name, description, info, keywords', 'safe')
		);
	}

	public function save($runValidation = true, $attributes = null)
	{
		if ( !$runValidation || $this->validate($attributes) ) {
			return file_put_contents($this->getSavePath() . $this->fileName, serialize($this->getAttributes()));
		}
		return false;
	}

	protected function getSavePath()
	{
		return Yii::getPathOfAlias('application.admin.data') . DIRECTORY_SEPARATOR;
	}

	public function getIsNewRecord()
	{
		return false;
	}

	public function getFieldSettingsForAdminPanel()
	{

		return array(
			array(
				'name' => 'Имя',
				'attribute' => 'name',
				'type' => 'text',
			),
			array(
				'name' => 'Email для обратной связи',
				'attribute' => 'feedbackEmail',
				'type' => 'text',
			),
            array(
                'name' => 'Email для обратной связи',
                'attribute' => 'feedbackEmail',
                'type' => 'text',
            ),
			array(
				'name' => 'Время показа заявок',
				'attribute' => 'showTime',
				'type' => 'dropdown',
                'data' => array(
                    0 => '1 day',
                    (24*3600*7) => '1 week',
                    (24*3600*7*2) => '2 week',
                    (24*3600*7*3) => '3 week',
                )
			),

			array(
				'name' => 'Page title О системе',
				'attribute' => 'aboutPageTitle',
				'type' => 'text',
			),
			array(
				'name' => 'Keywords О системе',
				'attribute' => 'aboutKeywords',
				'type' => 'text',
			),
			array(
				'name' => 'Description О системе',
				'attribute' => 'aboutDescription',
				'type' => 'text',
			),
			array(
				'name' => 'О системе',
				'attribute' => 'about',
				'type' => 'textEditor',
			),

			array(
				'name' => 'Page title Карта сайта',
				'attribute' => 'sitemapPageTitle',
				'type' => 'text',
			),
			array(
				'name' => 'Keywords Карта сайта',
				'attribute' => 'sitemapKeywords',
				'type' => 'text',
			),
			array(
				'name' => 'Description Карта сайта',
				'attribute' => 'sitemapDescription',
				'type' => 'text',
			),
			array(
				'name' => 'Карта сайта',
				'attribute' => 'sitemap',
				'type' => 'textEditor',
			),

			array(
				'name' => 'Page title Реклама',
				'attribute' => 'advPageTitle',
				'type' => 'text',
			),
			array(
				'name' => 'Keywords Реклама',
				'attribute' => 'advKeywords',
				'type' => 'text',
			),
			array(
				'name' => 'Description Реклама',
				'attribute' => 'advDescription',
				'type' => 'text',
			),
			array(
				'name' => 'Реклама',
				'attribute' => 'adv',
				'type' => 'textEditor',
			),
			array(
				'name' => 'Page title для Контакты',
				'attribute' => 'contactPageTitle',
				'type' => 'text',
			),
			array(
				'name' => 'Keywords для Контакты',
				'attribute' => 'contactKeywords',
				'type' => 'text',
			),
			array(
				'name' => 'Description для Контакты',
				'attribute' => 'contactDescription',
				'type' => 'text',
			),
            array(
                'name' => 'Контакты',
                'attribute' => 'contact',
                'type' => 'textEditor',
            ),
			//			array(
			//				'name' => 'Описание',
			//				'attribute' => 'description',
			//				'type' => 'textEditor',
			//			),
			//			array(
			//				'name' => 'Информация',
			//				'attribute' => 'info',
			//				'type' => 'textarea',
			//			),
			//			array(
			//				'name' => 'Ключевые слова',
			//				'attribute' => 'keywords',
			//				'type' => 'date',
			//			),
		);
	}

}
