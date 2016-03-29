<?php namespace App\DataAccess;

use App\Helpers\Config;
use PDO;
use PDOException;

class DB {
    private static $_instance = null;

    private
        $_pdo,
        $_error = false;

    private function __construct() {
        try {
            $host = Config::get('db.host');
            $dbname = Config::get('db.name');
            $username = Config::get('db.username');
            $password = Config::get('db.password');
            
            $this->_pdo = new \PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password);

            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Get the singleton instance
     * @return DB
     */
    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * Perform a non-query
     * @param string Query
     * @param array  Parameters
     * @return DB
     */
    public function nonQuery($sql, $params = []) {
        return $this->_query($sql, $params, 0);
    }

    /**
     * Perform a query with a single result
     * @param string Query
     * @param array  Parameters
     * @return object
     */
    public function query($sql, $params = []) {
        return $this->_query($sql, $params, 1);
    }

    /**
     * Perform a query with multiple results
     * @param string Query
     * @param array  Parameters
     * @return object
     */
    public function queryAll($sql, $params = []) {
        return $this->_query($sql, $params, 2);
    }

    // 0 - non-query
    // 1 - single
    // 2 - all
    private function _query($sql, $params = [], $type = 0) {
        $this->_error = false;

        $query = $this->_pdo->prepare($sql);
        if($query) {

            if(count($params)) {
                DB::bindParams($query, $params);
            }

            if($query->execute()) {
                return
                    ($type === 0) ? $this :
                    ($type === 1) ? $query->fetch(PDO::FETCH_OBJ) :
                                    $query->fetchAll(PDO::FETCH_OBJ);
            }
        }

        $this->_error = true;
        return $this;
    }
    
    private static function bindParams($query, $params) {
        foreach ($params as $position => $value) {
            $query->bindValue($position, $value);
        }
    }

    /**
     * Return True if errors occured
     * @return bool
     */
    public function error() {
        return $this->_error;
    }
    
    /**
     * Get last inserted id
     * @return string The id
     */
    public function lastInsertedId() {
        return $this->_pdo->lastInsertId();
    }
}