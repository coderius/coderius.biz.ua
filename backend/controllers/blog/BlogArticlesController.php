<?php

namespace backend\controllers\blog;

use Yii;
use backend\controllers\BaseAdminController;
use backend\models\blog\BlogArticles;
use backend\models\blog\BlogArticlesBlogSeries;
use backend\models\blog\BlogArticlesSearch;
use backend\models\blog\BlogTagsBlogArticles;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box; 
use yii\imagine\Gd;
use Imagine\Image\Point;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\base\DynamicModel;
use yii\web\Response;
/**
 * BlogArticlesController implements the CRUD actions for BlogArticles model.
 */
class BlogArticlesController extends BaseAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $config = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'ajax-upload-img-tinymce' => ['POST'],
                ],
            ],
        ];
        
        return  ArrayHelper::merge(
            $config,
            parent::behaviors()    
        );
        
        
    }

    public function beforeAction($action)
    {
//        if (parent::beforeAction($action)) {
//            if ($this->action->id == 'create') {
//                Yii::$app->controller->enableCsrfValidation = false;
//            }
//
//            return true;
//        }
//        return false;
        $this->enableCsrfValidation = false;

	return parent :: beforeAction($action);
    }
    
    /**
     * Lists all BlogArticles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogArticlesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * Displays a single Post model as an ajax response.
    * @param integer $id
    * @return mixed
    */
    public function actionAjaxViewInfoIndex($id)
    {
         $model = $this->findModel($id);

         $body = $this->renderPartial('_view_index', compact('model'));
         $title = $model->title;

         $arr = array("body" => $body, 'title' => $title);
         return json_encode($arr, JSON_FORCE_OBJECT);
    }
    
    public function actionAjaxUploadImgTinymce()
    {
        
        if (Yii::$app->request->isPost) {
            //{ "location": "folder/sub-folder/new-location.png" }
            
            $file = UploadedFile::getInstanceByName('file');
            $model = new DynamicModel(compact('file'));
            $model->addRule('file', 'image', [])->validate();
            
            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file')
                ];
                
            }else{
                $path = Yii::getAlias("@img-path-blog/text-img/");
                $url = Yii::getAlias("@img-web-blog/text-img/");
                $model->file->name = uniqid() . '.' . $model->file->extension;
                $resPath = $path . $model->file->name;
                $resUrl = $url . $model->file->name;
                
//                $size = $model->file->size;//вес
                $minSize = 50000;//файл весит 50 кб
                $minwidth = 800;
                
                try {
                    $imagine = Image::getImagine()->open($model->file->tempName);

                    $curWidth = $imagine->getSize()->getWidth();
                    $curHeight = $imagine->getSize()->getHeight();
                    // размер
                    if($curWidth > $minwidth){
                        $resWidth = $minwidth;
                        $resHeight = (($curHeight * $resWidth) / $curWidth);
                    }else{
                        $resWidth = $curWidth;
                        $resHeight = $curHeight;
                    }
                    //для gif изменение размера не работает
                    if($model->file->extension == 'gif'){
                        $imagine->save($resPath, array('animated' => true));
                    }else{
                        $imagine->resize(new Box($resWidth, $resHeight));
                        $imagine->save($resPath, ['quality' => 60]);
                    }
                    $result = ['location' => $resUrl];
//                    $imagine->save($resPath);
//                    
//                    sleep(2);
//                    //вес
//                    $size = filesize($resPath);
//                    if (file_exists($resPath)   && $size > $minSize) {
//                        $quality = 60;
//                        
//                    }else{
//                        $quality = 100;
//                        
//                    }
//                  
                    
                   
                    
                }catch(Exception $e) {
//                    echo 'Message: ' .$e->getMessage();
                    $result = [
                        'error' => 'ERROR_CAN_NOT_UPLOAD_FILE',
                    ];
                }
                
            }
            
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $result;
            
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }

    }
    
    
    public function actionAjaxDeleteImgTinymce()
    {
        $request = Yii::$app->request;
        if ($request->isPost && $request->isAjax) {
            $fullSrc = $request->post('src');
            $src = array_pop(explode('/', $fullSrc)); 
            $path = Yii::getAlias("@img-path-blog/text-img/".$src);
            if(is_file($path))
                if(FileHelper::unlink($path)){
                    $message = 'Удалено';
                }else{
                    $message = 'Не удалось удалить';
                }
            }else{
                $message = 'Удаляемый объект не является файлом';
            }    
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['message' => $message];
        
    }
    
    /**
     * Displays a single BlogArticles model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BlogArticles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogArticles();
        
//        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            
//            return \yii\widgets\ActiveForm::validate($model);
//        }
        
        if ($model->load(Yii::$app->request->post()))
        {
//        $model->addError('file', \Yii::t('app', 'You entered an invalid date format.'));
            
                
            if($file = UploadedFile::getInstance($model, 'file')){
                $model->file = $file;

                //имя файла
                $fileName = uniqid().'.'.$model->file->extension;

                //имя картинки для записи в базу данных
                $model->faceImg = $fileName;
            }
                
            
            

            //сохраняем данные в базу данных
            if($model->validate() and $model->save())
            {

                // ID нового элемента
                $new_id = $model->id;
                
                if(is_file($model->file->tempName))
                {
                    
                    //путь к папке для сохранения изображения текущей записи
                    $dirBig     = Yii::getAlias('@img-path-blog-posts/'.$new_id.'/big/');
                    $dirMiddle  = Yii::getAlias('@img-path-blog-posts/'.$new_id.'/middle/');
                    $dirThumb   = Yii::getAlias('@img-path-blog-posts/'.$new_id.'/thumb/');


                    //создаем папку, если не существует
                    FileHelper::createDirectory($dirBig);
                    FileHelper::createDirectory($dirMiddle);
                    FileHelper::createDirectory($dirThumb);

                    //сохраняем картинку в созданную папку
                    $pathToBig      = $dirBig.$fileName;
                    $pathToMiddle   = $dirMiddle.$fileName;
                    $pathToThumb    = $dirThumb.$fileName;
                    
//                    $this->uploadImg($model->file, $pathToBig, 900, 600, 80);
                    
                    $imgn = Image::thumbnail($model->file->tempName, 900, 600)
                            ->copy()
                            ->crop(new Point(0, 0), new Box(900, 600))
                            ->save($pathToBig, ['quality' => 80]);
                    sleep(1);
                    
                    //500 334
                    Image::thumbnail($pathToBig, 400, null)->save($pathToMiddle);
                    sleep(1);

                    Image::thumbnail($pathToBig, 150, null)->save($pathToThumb);
                    sleep(1);


                }
                
                //Сохраняем серию
                
                if(!empty($model->selectedSery)){
                    BlogArticlesBlogSeries::deleteAll(['idArticle' => $model->id]);
                    
                    foreach($model->selectedSery as $selectedSery){
                        $blogArticlesBlogSeries = new BlogArticlesBlogSeries();
                        $blogArticlesBlogSeries->idArticle = $model->id;
                        $blogArticlesBlogSeries->idSery = $selectedSery;
                        $blogArticlesBlogSeries->save();
                    }
                    
                }
                
                
                //Сохраняем теги
                if(!empty($model->selectedTags)){
                    BlogTagsBlogArticles::deleteAll(['idBlogArticle' => $model->id]);
                    $batchValBTBA = [];
                    foreach($model->selectedTags as $k => $idBlogTag){
                        $batchValBTBA[$k][] = $idBlogTag;
                        $batchValBTBA[$k][] = $model->id;
                    }
                    
                    Yii::$app->db
                            ->createCommand()
                            ->batchInsert(BlogTagsBlogArticles::tableName(),
                                    ['idBlogTag', 'idBlogArticle'],
                                    $batchValBTBA)
                            ->execute();
                }
                
                
                return $this->redirect(['view', 'id' => $model->id]);
                
            }// if validate() and save()
            
            
              
        }



        return $this->render('create', [
            'model' => $model,
        ]);
    }


    
    /**
     * Updates an existing BlogArticles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        //заполняем поля серии и блога в форме
        $series = $model->getSeries()->asArray()->all();
        $tags = $model->getBlogTags()->asArray()->all();
        
        $model->selectedCategory = $model->idCategory;
        
        foreach($series as $sery){
            $model->selectedSery[] = ArrayHelper::getValue($sery, 'id');
        }
        
        foreach($tags as $tag){
            $model->selectedTags[] = ArrayHelper::getValue($tag, 'id');
        }
        

        //обработка формы
        if ($model->load(Yii::$app->request->post()))
        {
            $file = UploadedFile::getInstance($model, 'file');

            if($file && $file->tempName){
                $model->file = $file;

                //имя файла
                $fileName = $model->file->baseName . '.' . $model->file->extension;

                //имя картинки для записи в базу данных
                $model->faceImg = $fileName;
            }
            

            //сохраняем данные в базу данных
            if($model->validate() and $model->save())
            {
                // ID нового элемента
                $new_id = $model->id;
                
                if ($file && $file->tempName)
                {
                    
                    //путь к папке для сохранения изображения текущей записи
                    $dirBig     = Yii::getAlias('@img-path-blog-posts/'.$new_id.'/big/');
                    $dirMiddle  = Yii::getAlias('@img-path-blog-posts/'.$new_id.'/middle/');
                    $dirThumb   = Yii::getAlias('@img-path-blog-posts/'.$new_id.'/thumb/');

                    //путь к папке изображений текущей записи
                    $dir = Yii::getAlias('@img-path-blog-posts/'.$new_id);

                    //удаляем папку картинок с id статьи блога и все ее картинки
                    FileHelper::removeDirectory($dir);

                    //создаем папку, если не существует
                    FileHelper::createDirectory($dirBig);
                    FileHelper::createDirectory($dirMiddle);
                    FileHelper::createDirectory($dirThumb);

                    //сохраняем картинку в созданную папку
                    $pathToBig      = $dirBig.$fileName;
                    $pathToMiddle   = $dirMiddle.$fileName;
                    $pathToThumb    = $dirThumb.$fileName;

                    
                    $imgn = Image::thumbnail($model->file->tempName, 900, 600)
                        ->copy()
                        ->crop(new Point(0, 0), new Box(900, 600))
                        ->save($pathToBig, ['quality' => 80]);
                    sleep(1);
                    
                    //500X334
                    Image::thumbnail($pathToBig, 400, null)->save($pathToMiddle);
                    sleep(1);

                    Image::thumbnail($pathToBig, 150, null)->save($pathToThumb);
                    sleep(1);


                   
                }
                
                
                //Сохраняем серию
                if(!empty($model->selectedSery)){
                    BlogArticlesBlogSeries::deleteAll(['idArticle' => $model->id]);
                    foreach($model->selectedSery as $selectedSery){
                        $blogArticlesBlogSeries = new BlogArticlesBlogSeries();
                        $blogArticlesBlogSeries->idArticle = $model->id;
                        $blogArticlesBlogSeries->idSery = $selectedSery;
                        $blogArticlesBlogSeries->save();
                    }
                    
                }else{
                    BlogArticlesBlogSeries::deleteAll(['idArticle' => $model->id]);
                }
                
                
                //Сохраняем теги
                if(!empty($model->selectedTags)){
                    BlogTagsBlogArticles::deleteAll(['idBlogArticle' => $model->id]);
                    $batchValBTBA = [];
                    foreach($model->selectedTags as $k => $idBlogTag){
                        $batchValBTBA[$k][] = $idBlogTag;
                        $batchValBTBA[$k][] = $model->id;
                    }
                    
                    Yii::$app->db
                            ->createCommand()
                            ->batchInsert(BlogTagsBlogArticles::tableName(),
                                    ['idBlogTag', 'idBlogArticle'],
                                    $batchValBTBA)
                            ->execute();
                }else{
                    BlogTagsBlogArticles::deleteAll(['idBlogArticle' => $model->id]);
                }
                
                
                return $this->redirect(['view', 'id' => $model->id]);
                
            }// if validate() and save()
            
            
              
        }
        
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BlogArticles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->enableCsrfValidation = false;
        $this->findModel($id)->delete();
        BlogArticlesBlogSeries::deleteAll(['idArticle' => $id]);
        BlogTagsBlogArticles::deleteAll(['idBlogArticle' => $id]);
        
        //путь к папке изображений текущей записи
        $dir = Yii::getAlias('@img-path-blog-posts/'.$id);

        //удаляем папку картинок с id статьи блога и все ее картинки
        FileHelper::removeDirectory($dir);

        return $this->redirect(['index']);
    }
    
    public function uploadImg(UploadedFile $file, $pathToSave, $width, $height, $quality = 60)
    {
        
        
        $imagine = Image::getImagine()->open($file->tempName);

        $curWidth = $imagine->getSize()->getWidth();
        $curHeight = $imagine->getSize()->getHeight();
        
        list($w, $h) = $this->calcNewSize($curWidth, $curHeight, $width, $height);
        
        $imagine->resize(new Box($w, $h));
        
        $imagine->copy()
                ->crop(new \Imagine\Image\Point(0, 0), new Box($width, $height));
        
        $imagine->save($pathToSave, [$quality]);
        
        
    }
    
    //Вычисляет пропорционально размеры фото до нужных, подгоняя меньшую сторону под заданную
    //Меньшая будет равна заданной, а большая - пропорционально
    //Далее картинка подгоняется под размер crop
    private function calcNewSize($curWidth, $curHeight, $width, $height) {
        $resWidth = $width;
        $resHeight = (($curHeight * $resWidth) / $curWidth);
        
        if($curWidth < $width || $curHeight < $height){
            if($curWidth < $width){
                return $this->calcNewSize($resWidth, $resHeight, $width, $height);
            }
            
            if($curHeight < $height){
                $resHeight = $height;
                $resWidth = (($curWidth * $resHeight) / $curHeight);
                return $this->calcNewSize($resWidth, $resHeight, $width, $height);
            }
        }else if($curWidth > $width && $curHeight > $height){
            return $this->calcNewSize($resWidth, $resHeight, $width, $height);
            
        }else{
            return [$resWidth, $resHeight];
        }
        
        throw new \yii\base\ErrorException('Error when calculate resize.');
    }
    /**
     * Finds the BlogArticles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogArticles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogArticles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app/admin', 'The requested page does not exist.'));
    }
}
