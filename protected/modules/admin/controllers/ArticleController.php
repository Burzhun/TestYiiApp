<?php

class ArticleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column2';

	/**
	 * @return array action filters
	 */


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Article;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
		$model->attributes=$_POST['Article'];
		if(!isset($_FILES['Article']['tmp_name']['image'])) {} else {
			$name  =  ImageFuck::save($_FILES['Article']['tmp_name']['image']);
			$model->image = $name;    }
			
			$model->theme = $this->themeId;
			$model->date = time();
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Статья <b>$model->title</b> успешно добавлена");
				$this->redirect(array('index'));
		} 
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
		$oldimage = $model->image;
		$model->attributes=$_POST['Article'];
		
			if(empty($_FILES['Article']['tmp_name']['image'])) {
			$model->image = $oldimage; 
			} else {
			$name  =  ImageFuck::save($_FILES['Article']['tmp_name']['image']);
			ImageFuck::delete($oldimage);
			$model->image = $name;   
								}
			
			
			
			
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Статья <b>$model->title</b> изменена");
			$this->redirect(array('index'));
		}}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
		
			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			$model->delete();
			ImageFuck::delete($model->image);
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Article',array(
											'criteria'=>array(
												'order'=>'position, date DESC',
												'condition'=>'theme='.$this->themeId,
											),
											'pagination'=>array(
												'pageSize'=>100,
											),
		));
		
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Article('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Article']))
			$model->attributes=$_GET['Article'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
		public function actionSort()
	{
	  if (isset($_POST['items']) && is_array($_POST['items']))
	  {
        $i = 1;
        foreach ($_POST['items'] as $item)
        {
            $model = Article::model()->findByPk($item);
            $model->position = $i;
            $model->save();
            $i++;
        }
      }
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
