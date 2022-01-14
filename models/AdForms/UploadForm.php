<?php

namespace app\models\AdForms;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['photo_array'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 8],
        ];
    }
    
    public function upload()
    {
        var_dump($this->validate());
        die();
        if ($this->validate()) { 
            foreach ($this->imageFiles as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}