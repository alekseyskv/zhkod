<?php

namespace App\Controller;

interface IController
{
    public function render($path, $data = [], $headers = []);
}