<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Login form
 */
class ProfileForm extends Model {

    public $cropper;
    public $cropper_data;
    public $sizes = [
        'main' => [
            'width' => 250,
            'height' => 250
        ],
        'thumbnail' => [
            'width' => 80,
            'height' => 80
        ]
    ];

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['cropper', 'cropper_data'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [];
    }

    public function upload() {
        $result = ['success' => false, 'secure_url' => '', 'message' => '',];
        $image = UploadedFile::getInstanceByName('file');
        if ($image && $image->saveAs(Yii::$app->user->identity->uploadPath .
                        DIRECTORY_SEPARATOR . $image->name)) {
            $result['secure_url'] = Yii::$app->urlManagerFrontend
                    ->createAbsoluteUrl(['/image/user',
                'id' => Yii::$app->user->identity->imageId([
                    Yii::$app->user->id,
                    $image->name,
                    0,
                ])], '');
            $result['success'] = true;
        } else {
            $file = Yii::$app->request->post('file');
            $base64 = explode(',', $file);
            $bin = base64_decode($base64[1]);
            $im = imagecreatefromstring($bin);
            if ($im) {
                $filename = str_replace('.', '', str_replace(' ', '', microtime())) . '.png';
                imagepng($im, Yii::$app->user->identity->uploadPath . DIRECTORY_SEPARATOR . $filename, 0);
                $result['secure_url'] = Yii::$app->urlManagerFrontend
                        ->createAbsoluteUrl(['/image/user',
                    'id' => Yii::$app->user->identity->imageId([
                        Yii::$app->user->id,
                        $filename,
                        0,
                    ])], '');
                $result['success'] = true;
            }
        }
        return $result;
    }

    public function change() {
        $result = ['success' => true, 'message' => ''];
        if ($this->load(Yii::$app->request->post())) {
            Yii::$app->user->identity->profile = $this->attributes;
            Yii::$app->user->identity->save();
        }
        return $result;
    }

}
