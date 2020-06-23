<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\HeadingRepository;

class CodeController extends Controller
{
    public function showAction()
    {
        $articleRep = new ArticleRepository(db());
        try {
            $articles = $articleRep->getAll();
        } finally {
            unset($articleRep);
        }
        $data = [
            'title' => 'ЖК РФ',
            'articles' => $articles,
        ];
        $headers = [
        ];
        return $this->render('code', $data, $headers);
        /*
        $LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastMod);
	    $IfModifiedSince = false;
	    if (isset($_ENV['HTTP_IF_MODIFIED_SINCE']))
		    $IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));
	    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
		    $IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
	    if ($IfModifiedSince && $IfModifiedSince >= $LastMod) {
		    header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
		    exit;
	    }
	    header('Last-Modified: ' . $LastModified);
	    header('ETag: ' . md5($LastModified));
	    header_remove('X-Powered-By');
        */
    }

    public function showSectionAction($section)
    {
        $headingRep = new HeadingRepository(db());
        $articleRep = new ArticleRepository(db());
        try {
            $section = $headingRep->getSections($section);
            $articles = $articleRep->getAll($section['id']);
        } finally {
            unset($headingRep);
            unset($articleRep);
        }
        $data = [
            'title' => $section['title'],
            'articles' => $articles,
        ];
        return $this->render('code', $data);
    }

    public function showArticleAction($section, $article)
    {
        $headingRep = new HeadingRepository(db());
        $articleRep = new ArticleRepository(db());
        $commentRep = new CommentRepository(db());
        try {
            $section = $headingRep->getSections($section);
            $article = $articleRep->getByNumber($article);
            $comments = $commentRep->getByArticle($article['id']);
        } finally {
            unset($headingRep);
            unset($articleRep);
            unset($commentRep);
        }
        $data = [
            'title' => $article['title'],
            'article' => $article,
            'section' => $section,
            'comments' => $comments,
        ];
        return $this->render('article', $data);
    }
}
