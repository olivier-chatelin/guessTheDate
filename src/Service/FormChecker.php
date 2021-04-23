<?php

namespace App\Service;

class FormChecker
{
    public const MAX_LENGTH = 255;
    public const PSEUDO_LENGTH = 25;
    private array $errors = [];
    private array $post;

    public function cleanAll()
    {
        $cleanData = [];
        foreach ($this->post as $inputName => $formInput) {
            if (is_string($formInput)) {
                $this->post[$inputName] = trim($formInput);
            } else {
                $this->post[$inputName] = $formInput;
            }
        }
        return $cleanData;
    }

    public function checkInputLength(string $input, string $errName, $min = 1, $max = self::MAX_LENGTH)
    {
        if (empty($input)) {
            $this->errors[$errName] = 'Ce champ ne peut être vide';
        } elseif (strlen($input) <= $min) {
            $this->errors[$errName] = 'Ce champ doit faire au moins ' . $min . ' caractères';
        } elseif (strlen($input) > $max) {
            $this->errors[$errName] = 'Ce champ ne doit pas dépasser ' . $max . ' caractères';
        }
    }

    public function checkInputPattern(string $input, string $errName, string $pattern = '')
    {
        switch ($pattern) {
            case 'alnum':
                if (!ctype_alnum($input)) {
                    $this->errors[$errName] = 'Ce champ ne peut contenir que des lettres et des chiffres';
                }
                break;
            case 'alpha':
                if (!ctype_alpha($input)) {
                    $this->errors[$errName] = 'Ce champ ne peut contenir que des lettres';
                }
                break;
            case 'digit':
                if (!ctype_digit($input)) {
                    $this->errors[$errName] = 'Ce champ ne peut contenir que des chiffres';
                }
                break;
        }
    }



    public function __construct(array $post)
    {
        $this->post = $post;
    }


    public function getErrors(): array
    {
        return $this->errors;
    }


    public function setErrors(array $errors): FormChecker
    {
        $this->errors = $errors;
        return $this;
    }

    public function getPost(): array
    {
        return $this->post;
    }

    public function setPost(array $post): FormChecker
    {
        $this->post = $post;
        return $this;
    }
}
