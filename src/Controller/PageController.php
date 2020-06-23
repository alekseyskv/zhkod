<?php


namespace App\Controller;


class PageController extends Controller
{
    public function showAction($alias = '') {
        $data = [
            'title' => 'sdfsdfdf',
            'alias' => $alias,
        ];
        return $this->render('page', $data);
    }
}