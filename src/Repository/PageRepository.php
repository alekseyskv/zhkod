<?php


namespace App\Repository;


use PDO;

class PageRepository extends Repository
{
    function __construct($db)
    {
        parent::__construct($db);
        $this->tableName = 'pages';
    }

    public function getByUrl($url)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select( '*' )
            ->from( $this->tableName )
            ->where('url = :url' )
            ->setParameter( ':url', $url )
            ->setFirstResult( 0 )
            ->setMaxResults( 1 );
        $stmt = $qb->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}