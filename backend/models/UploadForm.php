<?php

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin
 * Date: 02.08.2018
 * Time: 14:35
 */

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $excelFile;
    /**
     * @var string
     */
    public $uploadDir;
    /**
     * @var string
     */
    public $filename;

    /**
     * UploadForm constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->createUploadFolder();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $filename = 'tmp_excel';
            $this->filename = "$this->uploadDir/$filename.{$this->excelFile->extension}";
            $this->excelFile->saveAs($this->filename);
            return true;
        }
        return false;
    }

    /**
     * Create an upload folder if it isn't exists.
     */
    private function createUploadFolder()
    {
        $this->uploadDir = dirname(__FILE__) . '/../../upload/';
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir);
            chmod($this->uploadDir, 0755);
        }
    }
}
