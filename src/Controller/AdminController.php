<?php


namespace App\Controller;

use App\Parser\ZhilCodex;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\HeadingRepository;
use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction() {
        return $this->render('admin/index', ['title' => 'Админка']);
    }

    public function pageAction($action, Request $request)
    {
        $pageRep = new PageRepository(db());

        if ($action == 'edit') {
            $id = $request->get('id');
            $page = $pageRep->get($id);
            return $this->render('admin/page', ['title' => 'Редактировать страницу', 'page' => $page]);
        }

        if ($action == 'save') {
            if ($request->getMethod() == 'POST') {
                $data = $request->request->all();
                $newId = $pageRep->save($data);
                $id = $data['id'] ?: $newId;
                $url = $this->generator->generate('admin_page_route', ['action' => 'edit', 'id' => $id]);
            } else {
                $url = $this->generator->generate('admin_page_route', ['action' => 'list']);
            }
            return new RedirectResponse($url);
        }

        $pages = $pageRep->getList();
        return $this->render('admin/pages', ['title' => 'Страницы', 'pages' => $pages]);
    }

    public function articleAction($action, Request $request)
    {
        $articleRep = new ArticleRepository(db());

        if ($action == 'upload') {
            /** @var UploadedFile $file */
            $file = $request->files->get('codex-file');
            if ($file) {
                $codex = new ZhilCodex($file->getPathname());
                $codex->parse();
            }
        }

        if ($action == 'save') {
            if ($request->getMethod() == 'POST') {
                $data = $request->request->all();
                $newId = $articleRep->save($data);
                $id = $data['id'] ?: $newId;
                $url = $this->generator->generate('admin_article_route', ['action' => 'edit', 'id' => $id]);
            } else {
                $url = $this->generator->generate('admin_article_route', ['action' => 'list']);
            }
            return new RedirectResponse($url);
        }

        if ($action == 'edit') {
            $id = $request->get('id');
            $article = $articleRep->get($id);
            return $this->render('admin/article', ['title' => 'Редактировать статью', 'article' => $article]);
        }

        $articles = $articleRep->getList();
        return $this->render('admin/articles', ['title' => 'Статьи кодекса', 'articles' => $articles]);
    }

    public function headingAction($action, Request $request)
    {
        $headingRep = new HeadingRepository(db());

        if ($action == 'save') {
            if ($request->getMethod() == 'POST') {
                $data = $request->request->all();
                $newId = $headingRep->save($data);
                $id = $data['id'] ?: $newId;
                $url = $this->generator->generate('admin_heading_route', ['action' => 'edit', 'id' => $id]);
            } else {
                $url = $this->generator->generate('admin_heading_route', ['action' => 'list']);;
            }
            return new RedirectResponse($url);
        }

        if ($action == 'edit') {
            $id = $request->get('id');
            $heading = $headingRep->get($id);
            return $this->render('admin/heading', ['title' => 'Редактировать заголовок', 'heading' => $heading]);
        }

        $headings = $headingRep->getList();
        return $this->render('admin/headings', ['title' => 'Оглавление', 'headings' => $headings]);
    }

    public function commentAction($action, Request $request) {
        $commentRep = new CommentRepository(db());

        if ($action == 'edit') {
            $id = $request->get('id');
            $comment = $commentRep->get($id);

            $articleRep = new ArticleRepository(db());
            try {
                $articles = $articleRep->getDictionary('title');
            } finally {
                unset($articleRep);
            }
            $data = [
                'title' => 'Редактировать комментарий',
                'comment' => $comment,
                'articles' => $articles,
            ];
            return $this->render('admin/comment', $data);
        }

        if ($action == 'save') {
            if ($request->getMethod() == 'POST') {
                $data = $request->request->all();
                $newId = $commentRep->save($data);
                $id = $data['id'] ?: $newId;
                $url = $this->generator->generate('admin_comment_route', ['action' => 'edit', 'id' => $id]);
            } else {
                $url = $this->generator->generate('admin_comment_route', ['action' => 'list']);
            }
            return new RedirectResponse($url);
        }

        $comments = $commentRep->getList();
        return $this->render('admin/comments', ['title' => 'Комментарии', 'comments' => $comments]);
    }

    public function __invoke() {
        return new Response("__invoke");
    }
}