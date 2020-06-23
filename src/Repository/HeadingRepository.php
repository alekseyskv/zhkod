<?php


namespace App\Repository;


use PDO;

class HeadingRepository extends Repository
{
    function __construct($db)
    {
        parent::__construct($db);
        $this->tableName = 'heading';
        $this->columns = $this->getColumns();
    }

    public function getSections($number = null)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select( '*' )
            ->from( $this->tableName )
            ->where('parent_id is null')
            ->orderBy('number');
        if ($number) {
            $qb->andWhere('number = :number')
                ->setParameter(':number', $number)
                ->setFirstResult( 0 )
                ->setMaxResults( 1 );
        }
        $stmt = $qb->execute();
        if ($number) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    public function getChapters($number = null)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select( '*' )
            ->from( $this->tableName )
            ->where('parent_id is not null');
        if ($number) {
            $qb->andWhere('number = :number')
                ->setParameter(':number', $number)
                ->setFirstResult( 0 )
                ->setMaxResults( 1 );
        }
        $stmt = $qb->execute();
        if ($number) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    public function findSectionByNumberAndSave($section)
    {
        if ($section['number']) {
            $tmp = $this->getSections($section['number']);
            if ($tmp) {
                $section['id'] = $tmp['id'];
                $this->save($section);
                return $section['id'];
            } else {
                return $this->save($section);
            }
        }
    }

    public function findChapterByNumberAndSave($chapter)
    {
        if ($chapter['number']) {
            $tmp = $this->getChapters($chapter['number']);
            if ($tmp) {
                $chapter['id'] = $tmp['id'];
                $this->save($chapter);
                return $chapter['id'];
            } else {
                return $this->save($chapter);
            }
        }
    }
}