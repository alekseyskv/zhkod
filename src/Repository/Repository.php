<?php


namespace App\Repository;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\DBAL\Schema\Column;
use PDO;


abstract class Repository implements IRepository
{
    const TIMESTAMP_FIELD = 'upd_time_stamp';

    /** @var Connection $db */
    protected $db;
    /** @var string $tableName */
    protected $tableName;
    /** @var string $idField */
    protected $idField;
    /** @var array $columns */
    protected $columns;

    function __construct( $db )
    {
        $this->db = $db;
        $this->idField = 'id';
        $this->columns = [];
    }

    protected function getColumns()
    {
        $result = [];
        $columns = $this->db->getSchemaManager()->listTableColumns($this->tableName);
        /** @var Column $column */
        foreach ($columns as $column) {
            $result[] = strtolower($column->getName());
        }
        return $result;
    }

    public function exist($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select( $this->idField )
            ->from( $this->tableName )
            ->where( $this->idField . ' = :id' )
            ->setParameter( ':id', $id );
        $stmt = $qb->execute();
        return $stmt->rowCount() > 0;
    }

    protected function prepareData($data)
    {
        return $data;
    }

    protected function log( $var )
    {
        $f = fopen( __DIR__ . DIRECTORY_SEPARATOR . 'logs.log', 'a+' );
        fwrite( $f, print_r(date('[Y-m-d H:i:s] ') . $var, true ) );
        fwrite( $f, "\n" );
        fclose( $f );
    }

    protected function exception( $var )
    {
        $f = fopen( __DIR__ . DIRECTORY_SEPARATOR . 'exceptions.log', 'a+' );
        fwrite( $f, print_r(date('[Y-m-d H:i:s] ') . $var, true ) );
        fwrite( $f, "\n" );
        fclose( $f );
    }

    protected function debug( $var )
    {
        $f = fopen( __DIR__ . DIRECTORY_SEPARATOR . 'debugs.log', 'a+' );
        fwrite( $f, print_r($var, true) );
        fwrite( $f, "\n" );
        fclose( $f );
    }

    public function getDictionary ($valueField, $keyField = 'id')
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select($keyField, $valueField)
            ->from( $this->tableName );
        $stmt = $qb->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getList($conditions = null)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->tableName);
            //->setFirstResult( 0 )
            //->setMaxResults( 1 );
        $stmt = $qb->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select( '*' )
            ->from( $this->tableName )
            ->where( $this->idField . ' = :id' )
            ->setParameter( ':id', $id )
            ->setFirstResult( 0 )
            ->setMaxResults( 1 );
        $stmt = $qb->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data, $checkColumns = false)
    {
        $data = $this->prepareData($data);
        
        if ($checkColumns) {
            if (!$this->columns) {
                $this->columns = $this->getColumns();
            }
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->columns) || $value == '') {
                    unset($data[$key]);
                }
            }
        }

        if (in_array($this::TIMESTAMP_FIELD, $this->columns)) {
            $data[$this::TIMESTAMP_FIELD] = time();
        }

        if (array_key_exists($this->idField, $data) && $data[$this->idField]) {
            //$this->debug($data);
            try {
                $affectedRowsCount = $this->db->update($this->tableName, $data, [$this->idField => $data[$this->idField]]);
                $result = $affectedRowsCount; // UPDATE => lastInsertId() = 0
            } catch (DBALException $e) {
                $this->exception("\nUPDATE: " . $e->getMessage());
                exit($e->getMessage());
            }
        } else {
            //$this->debug($data);
            try {
                $affectedRowsCount = $this->db->insert($this->tableName, $data);
                $result = $this->db->lastInsertId();
            } catch (DBALException $e) {
                $this->exception("\nINSERT: " . $e->getMessage());
                exit($e->getMessage());
            }
        }
        //$this->debug($result);
        return $result;
    }

    public function delete($id)
    {
        try {
            return $this->db->delete($this->tableName, [$this->idField => $id]);
        } catch (InvalidArgumentException $e) {
            exit($e->getMessage());
        } catch (DBALException $e) {
            exit($e->getMessage());
        }
    }
}