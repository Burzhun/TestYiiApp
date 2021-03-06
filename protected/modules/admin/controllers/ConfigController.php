<?php

class ConfigController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column2';


	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}



	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	public function actionIndex()
	{
		if(Yii::app()->request->isPostRequest)
		{

			foreach ($_POST['Config']['value'] as $key=>$value)
			{
				$config = Config::model()->findbyPk($key);
				$config->value = $value;
				if($config->save()) {
					Yii::app()->user->setFlash('success', "<b>$config->name</b>: Данные успешно обновлены!");
				}
			}
		}

		if(Yii::app()->theme->name == 'roznica'){
			$models = Config::model()->findAll(array('order'=>'position', 'condition'=>'theme = 1'));
		}else{
			$models = Config::model()->findAll(array('order'=>'position', 'condition'=>'theme = 0'));
		}
	
		
		$this->render('index',array(
			'models'=>$models,
		));
	}

	
	public function loadModel($id)
	{
		$model=Config::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='config-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}