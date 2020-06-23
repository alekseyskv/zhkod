<?php

namespace App\View;

interface IView
{
    public function make($path, $data = []);
}