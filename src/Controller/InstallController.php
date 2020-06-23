<?php


namespace App\Controller;


use App\Repository\Repository;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\HttpFoundation\Response;

class InstallController extends Controller
{
    public function indexAction($action) {

        $msg = '';

        /** @var \Doctrine\DBAL\Schema\AbstractSchemaManager $mngr */
        $mngr = db()->getSchemaManager();

        if ($action === 'create')
        {
            $schema = new Schema();

/*--------------------------------------------------------------------------------------------------------------------*/

            $userTable = $schema->createTable('users');

            $userTable->addColumn('id', 'integer', ['autoincrement' => true]);
            $userTable->addColumn('username', 'string');
            $userTable->addColumn('password', 'string');
            $userTable->addColumn('role', 'string', ['notnull' => false]);
            $userTable->addColumn('status', 'integer', ['notnull' => false]);

            $userTable->setPrimaryKey(['id']);

            if (!$mngr->tablesExist('users')) {
                $mngr->createTable($userTable);
            }

/*--------------------------------------------------------------------------------------------------------------------*/

            $headingTable = $schema->createTable('heading');

            $headingTable->addColumn('id', 'integer', ['autoincrement' => true]);
            $headingTable->addColumn('parent_id', 'integer', ['notnull' => false]);
            $headingTable->addColumn('number', 'string', ['length' => 10]);
            $headingTable->addColumn('name', 'string', ['length' => 500]);
            $headingTable->addColumn('title', 'string', ['length' => 500]);
            $headingTable->addColumn('description', 'string', ['notnull' => false]);
            $headingTable->addColumn('keywords', 'string', ['notnull' => false]);
            $headingTable->addColumn('note', 'text', ['notnull' => false]);
            $headingTable->addColumn(Repository::TIMESTAMP_FIELD, 'integer', ['unsigned' => true]);

            $headingTable->setPrimaryKey(['id']);
            $headingTable->addIndex(['parent_id']);
            $headingTable->addIndex(['number']);

            if (!$mngr->tablesExist('heading')) {
                $mngr->createTable($headingTable);
            }

/*--------------------------------------------------------------------------------------------------------------------*/

            $articleTable = $schema->createTable('articles');

            $articleTable->addColumn('id', 'integer', ['autoincrement' => true]);
            $articleTable->addColumn('parent_id', 'integer');
            $articleTable->addColumn('number', 'string', ['length' => 10]);
            $articleTable->addColumn('name', 'string', ['length' => 500]);
            $articleTable->addColumn('title', 'string', ['length' => 500]);
            $articleTable->addColumn('content', 'text', ['notnull' => false]);
            $articleTable->addColumn('description', 'string', ['notnull' => false]);
            $articleTable->addColumn('keywords', 'string', ['notnull' => false]);
            $articleTable->addColumn('note', 'text', ['notnull' => false]);
            $articleTable->addColumn('updated', 'date', ['notnull' => false]);
            $articleTable->addColumn('views', 'integer', ['unsigned' => true, 'default' => 0]);
            $articleTable->addColumn(Repository::TIMESTAMP_FIELD, 'integer', ['unsigned' => true]);

            $articleTable->setPrimaryKey(['id']);
            $articleTable->addIndex(['number']);

            if (!$mngr->tablesExist('articles')) {
                $mngr->createTable($articleTable);
            }

/*--------------------------------------------------------------------------------------------------------------------*/

            $commentTable = $schema->createTable('comments');

            $commentTable->addColumn('id', 'integer', ['autoincrement' => true]);
            $commentTable->addColumn('article_id', 'integer');
            $commentTable->addColumn('user_id', 'integer', ['default' => 1]);
            $commentTable->addColumn('title', 'string', ['length' => 500]);
            $commentTable->addColumn('content', 'text', ['notnull' => false]);
            $commentTable->addColumn('author_name', 'string', ['notnull' => false]);
            $commentTable->addColumn('note', 'text', ['notnull' => false]);
            $commentTable->addColumn('date_begin', 'date', ['notnull' => false]);
            $commentTable->addColumn('date_end', 'date', ['notnull' => false]);

            $commentTable->setPrimaryKey(['id']);
            $commentTable->addIndex(['article_id']);
            $commentTable->addIndex(['user_id']);

            if (!$mngr->tablesExist('comments')) {
                $mngr->createTable($commentTable);
            }

/*--------------------------------------------------------------------------------------------------------------------*/

            $pageTable = $schema->createTable('pages');

            $pageTable->addColumn('id', 'integer', ['autoincrement' => true]);
            $pageTable->addColumn('url', 'string');
            $pageTable->addColumn('title', 'string');
            $pageTable->addColumn('content', 'text', ['notnull' => false]);
            $pageTable->addColumn('description', 'string', ['notnull' => false]);
            $pageTable->addColumn('keywords', 'string', ['notnull' => false]);
            $pageTable->addColumn('views', 'integer', ['unsigned' => true, 'default' => 0]);

            $pageTable->setPrimaryKey(['id']);
            $pageTable->addUniqueIndex(['url']);

            if (!$mngr->tablesExist('pages')) {
                $mngr->createTable($pageTable);
            }


            $msg = 'OK';
        }

        if ($action === 'destroy')
        {
            $mngr->dropTable('users');

            $msg = 'OK';
        }


        return new Response($msg);
    }
}