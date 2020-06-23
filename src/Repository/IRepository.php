<?php


namespace App\Repository;


interface IRepository
{
    function get($id);
    function delete($id);
    function save($data, $checkColumns = false);
}