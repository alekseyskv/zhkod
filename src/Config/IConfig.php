<?php

namespace App\Config;

interface IConfig
{
    public function addConfig($file);
    public function get($keyValue);
}