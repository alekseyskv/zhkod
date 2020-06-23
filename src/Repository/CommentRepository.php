<?php


namespace App\Repository;


use PDO;

class CommentRepository extends Repository
{
    function __construct($db)
    {
        parent::__construct($db);
        $this->tableName = 'comments';
    }

    public function getList($conditions = null)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('c.*', 'a.number')
            ->from($this->tableName, 'c' )
            ->leftJoin('c', 'articles', 'a', 'c.article_id = a.id');
        $stmt = $qb->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByArticle($articleId)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->tableName)
            ->where('article_id = :article_id')
            ->setParameter(':article_id', $articleId);
        $stmt = $qb->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}