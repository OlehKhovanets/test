<?php

namespace App\Http\Validation;

class FileValidator
{
    protected $request;
    protected $file;

    public function __construct($file)
    {
        $this->file  = $file;
        $this->request = [
            'errors' => [

            ]
        ];
    }

    public function required()
    {
        if(!file_exists($this->file['tmp_name'])){
            array_push($this->request['errors'],  ['fileRequired' => 'файл обовязковий']);
        }

        return $this;
    }

    public function type($type)
    {
        if ($this->file['type'] !== $type) {
            array_push($this->request['errors'],  ['fileType' => sprintf('даний тип файлу не підтримується. Допустимий тип: %s', $type)]);
        }

        return $this;
    }

    public function validate()
    {
        if (!empty($this->request['errors'])) {
            $_SESSION['errors'] = $this->request['errors'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            unset($_SESSION["errors"]);
        }
    }
}