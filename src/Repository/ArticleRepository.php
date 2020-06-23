<?php


namespace App\Repository;


use PDO;

class ArticleRepository extends Repository
{
    function __construct($db)
    {
        parent::__construct($db);
        $this->tableName = 'articles';
        $this->columns = $this->getColumns();
    }

    public function getByNumber($number)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select( '*' )
            ->from( $this->tableName )
            ->where('number = :number' )
            ->setParameter( ':number', $number )
            ->setFirstResult( 0 )
            ->setMaxResults( 1 );
        $stmt = $qb->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findArticleByNumberAndSave($article)
    {
        if ($article['number']) {
            $tmp = $this->getByNumber($article['number']);
            if ($tmp) {
                $article['id'] = $tmp['id'];
                $this->save($article);
                return $article['id'];
            } else {
                return $this->save($article);
            }
        }
    }

    public function getByParent($parentId)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->tableName )
            ->where('parent_id = :parent_id')
            ->setParameter(':parent_id', $parentId)
            ->orderBy('number');
        $stmt = $qb->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll($sectionId = null)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('a.*',
            'chapt.title as parent_title',
            'chapt.number as parent_number',
            'chapt.note as parent_note',
            'coalesce(sect.title, chapt.title) as section_title',
            'coalesce(sect.number, chapt.number) as section_number',
            'coalesce(sect.note, chapt.note) as section_note')
            ->from($this->tableName, 'a')
            ->leftJoin('a', 'heading', 'chapt', 'chapt.id = a.parent_id')
            ->leftJoin('a', 'heading', 'sect', 'sect.id = chapt.parent_id')
            ->orderBy('a.id');
        if ($sectionId) {
            $qb->where('coalesce(sect.id, chapt.id) = :section_id')
                ->setParameter(':section_id', $sectionId);
        }
        $stmt = $qb->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}