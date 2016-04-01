<?php namespace App\DataAccess;


use App\Models\BaseModel;

abstract class BaseRepository {
    /**
     * @var DB
     */
    protected $_db;
    protected $_tableName;
    protected $_idColumn;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    protected abstract function mapEntity($entity);
    protected abstract function getProperties();
    protected abstract function getKeyValues($entity);

    protected function getAllQuery($take = 0, $offset = 0, $sort = [], $filters = []) {
        return "SELECT * FROM `{$this->_tableName}`" .
        $this->getFilterSection($filters) .
        $this->getOrderSection($sort) .
        self::getLimitSection($take, $offset);
    }

    public function getAll($take = 0, $offset = 0, $sort = [], $filters = []) {
        $entities = $this->_db->queryAll($this->getAllQuery($take, $offset, $sort, $filters));
        $result = [];

        if(!empty($entities)) {
            foreach ($entities as $entity) {
                $result[] = $this->mapEntity($entity);
            }
        }

        return $result;
    }

    public function getById($id) {

        $entity = $this->_db->query($this->getByIdQuery(), [
            ':' . $this->_idColumn => (int)$id
        ]);

        if($entity) {
            $entity = $this->mapEntity($entity);
        }

        return $entity;
    }

    protected function getByIdQuery() {
        return "SELECT * FROM `{$this->_tableName}` WHERE {$this->_idColumn} = :{$this->_idColumn} LIMIT 1";
    }

    protected function prepareInsertQuery($properties) {

        $sql = "INSERT INTO `{$this->_tableName}` ";

        if (!empty($properties)) {
            $values = [];
            $columns = [];

            foreach ($properties as $prop) {
                if ($prop === $this->_idColumn) continue;
                $values[] = ':'. $prop;
                $columns[] = $prop;
            }

            var_dump_pre($properties);
//            var_dump_pre($columns);

            $sql .= '(' . implode(', ', $columns) .') VALUES (' . implode(', ', $values) . ')';
        }

        return $sql;
    }

    protected function prepareUpdateQuery($properties) {

        $sql = "UPDATE `{$this->_tableName}` SET ";
        $props = [];

        foreach ($properties as $prop) {
            if($prop !== $this->_idColumn) {
                $props[] = "{$prop} = :{$prop}";
            }
        }

        $sql .= implode(', ', $props);
        $sql .= " WHERE {$this->_idColumn} = :{$this->_idColumn}";

        return $sql;
    }

    protected function getDeleteQuery() {
        return "DELETE FROM `{$this->_tableName}` WHERE {$this->_idColumn} = :{$this->_idColumn}";
    }

    public function save(BaseModel $entity) {
        if($entity->getId() > 0) {
            $this->update($entity);
        } else {
            $this->insert($entity);
        }
    }

    protected function insert(BaseModel $entity) {
        $kv = $this->getKeyValues($entity);
        unset($kv[':' . $this->_idColumn]);
        $this->_db->nonQuery(
            $this->prepareInsertQuery($this->getProperties()),
            $kv);

        $entity->setId($this->_db->lastInsertedId());
    }

    protected function update(BaseModel $entity) {
        $this->_db->nonQuery(
            $this->prepareUpdateQuery($this->getProperties()),
            $this->getKeyValues($entity));
    }

    public function delete(BaseModel $entity) {
        $this->_db->nonQuery($this->getDeleteQuery(), [
            ':' . $this->_idColumn => $entity->getId()
        ]);
    }

    public function count($filter = []) {
        $sql = "SELECT COUNT(*) AS `count` FROM `{$this->_tableName}`" . self::getFilterSection($filter);
        $result = $this->_db->query($sql);
        return (int)$result->count;
    }

    protected static function getLimitSection($take = 0, $offset = 0) {
        $sql = '';

        if ($take > 0) {
            $sql = " LIMIT ";

            if($offset > 0) {
                $sql .= "{$offset}, {$take}";
            } else {
                $sql .= $take;
            }
        }

        return $sql;
    }

    protected function getFilterSection($filter = []) {

        if (empty($filter)) {
            return '';
        }

        $filters = [];

        if (isset($filter['like'])) {
            foreach($filter['like'] as $k => $v) {
                $filters[] = "{$k} LIKE '{$v}'";
            }
        }

        if (isset($filter['>'])) {
            foreach($filter['>'] as $k => $v) {
                if (is_string($v)) {
                    $filters[] = "{$k} > '{$v}'";
                } else {
                    $filters[] = "{$k} > {$v}";
                }
            }
        }

        if (isset($filter['<'])) {
            foreach($filter['<'] as $k => $v) {
                if (is_string($v)) {
                    $filters[] = "{$k} < '{$v}'";
                } else {
                    $filters[] = "{$k} < {$v}";
                }
            }
        }

        if (isset($filter['>='])) {
            foreach($filter['>='] as $k => $v) {
                if (is_string($v)) {
                    $filters[] = "{$k} >= '{$v}'";
                } else {
                    $filters[] = "{$k} >= {$v}";
                }
            }
        }

        if (isset($filter['<='])) {
            foreach($filter['<='] as $k => $v) {
                if (is_string($v)) {
                    $filters[] = "{$k} <= '{$v}'";
                } else {
                    $filters[] = "{$k} <= {$v}";
                }
            }
        }

        if (isset($filter['='])) {
            foreach($filter['='] as $k => $v) {
                if (is_string($v)) {
                    $filters[] = "{$k} = '{$v}'";
                } else {
                    $filters[] = "{$k} = {$v}";
                }
            }
        }

        return ' WHERE ' . implode(' AND ', $filters);
    }

    protected function getOrderSection($sort = []) {

        if (empty($sort)) {
            return '';
        }

        $sorts = [];

        foreach ($sort as $k => $v) {
            $sorts[] = "{$k} {$v}";
        }

        return ' ORDER BY ' . implode(', ', $sorts);
    }
}