<?php declare(strict_types = 1);

namespace App\Core\Controller;

use App\Core\Request\Request;

abstract class AbstractController
{
    protected Request $request;
    protected array $errors;

    public function __construct()
    {
        $this->request = new Request();
        $this->errors = [];
    }
}