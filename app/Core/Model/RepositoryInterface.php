<?php

namespace App\Core\Model;

interface RepositoryInterface
{
    public function getList();
    public function insert($data);
}