<?php

namespace scandiweb\Factory;

class QueryBuilder
{
    /**
     * Turns error messages on and off, usefull for debugging
     *
     * @var bool
     */
    private bool $showErrors = true;

    /**
     * Holds the query type (select, insert, update, delete)
     * it can take an extra value named "query" for
     * returning arbitrary SQL Queries.
     *
     * @var string
     */
    public string $queryType = "SELECT"; // Default Query Type

    /**
     * These hold the variables for building the query
     *
     * @var string
     */
    protected string $query;
    protected string  $table;
    protected string $groupBy;
    protected string $having;
    protected string $orderBy;
    protected string $limit;

    /**
     * Columns and values arrays, dimensions must match
     *
     * @var array
     */
    protected $columns = array();
    protected $values = array();

    /**
     * Constructor - Defines the query type
     *
     * @param string $queryType
     */
    public function __construct($queryType) {
        $this->queryType = strtoupper($queryType);
    }

    /**
     * Set the table to work on
     *
     * @param string $tableName
     */
    public function setTable($tableName) {
        $this->table = $tableName;
    }

    /**
     * Adds a column to the list
     *
     * @param $colName
     */
    public function addColumn($colName) {
        $this->columns[] = $colName;
    }

    /**
     * Add a value to the list
     *
     * @param string $value
     */
    public function addValue($value) {
        $this->values[] = "'".$value."'";
    }

    /**
     * These methods set the query clauses
     */
    public function setWhere($where) {
        $this->where = $where;
    }
    public function setGroupBy($groupBy) {
        $this->groupBy = $groupBy;
    }
    public function setHaving($having) {
        $this->having = $having;
    }
    public function setOrderBy($orderBy) {
        $this->orderBy = $orderBy;
    }
    public function setQuery($query) {
        $this->query = $query;
    }
    public function setLimit($limit) {
        $this->limit = $limit;
    }

    public function showErrors($showErrors) {
        $this->showErrors = ($showErrors)? true:false;
    }

    /**
     *
     * Decides what to do in case of error and hanldes it
     *
     * @param string $message
     * @return boolean
     */
    private function error($message) {
        if ($this->showErrors) {

            print "<p>$message</p>";
        }
        return false;
    }

    /**
     * Generates and returns query as a string
     *
     * @return string
     */
    public function buildQuery() {
        if (empty($this->table) and ($this->queryType != "QUERY")) return $this->error("Error - No table selected");

        $sqlString = "";
        switch ($this->queryType) {
            case "SELECT":
                $sqlString.= "SELECT ";
                $sqlString.= implode(", ", $this->columns);
                $sqlString.=" FROM {$this->table}";

                if ($this->where) $sqlString.= " WHERE $this->where";
                if (!empty($this->groupBy)) $sqlString.= " GROUP BY $this->groupBy";
                if (!empty($this->having)) $sqlString.= " HAVING $this->having";
                if (!empty($this->orderBy)) $sqlString.= " ORDER BY $this->orderBy";
                if (!empty($this->limit)) $sqlString.= " LIMIT $this->limit";

                break;
            case "INSERT":
                if (count($this->columns) != count($this->values)) return $this->error("Error - Column list doesn't match the value list");
                $sqlString.= "INSERT INTO {$this->table} ";

                $sqlString.= "(";
                $sqlString.= implode(", ", $this->columns);
                $sqlString.= ") ";

                $sqlString.= "VALUES";

                $sqlString.= " (";
                $sqlString.= implode(", ", $this->values);
                $sqlString.= ")";
                break;
            case "UPDATE":
                if (count($this->columns) != count($this->values)) return $this->error("Error - Column list doesn't match the value list");
                $sqlString.= "UPDATE {$this->table} SET ";

                $noColumns = count($this->columns);
                for ($i=0;$i<$noColumns;$i++) {
                    $sqlString.= "{$this->columns[$i]} = {$this->values[$i]}";
                    if ($i < $noColumns-1) $sqlString.= ", ";
                }


                if ($this->where) $sqlString.= " WHERE $this->where";
                if ($this->limit) $sqlString.= " LIMIT $this->limit";

                break;
            case "DELETE":
                $sqlString.= "DELETE FROM {$this->table} ";

                if ($this->where) $sqlString.= "WHERE $this->where";
                break;
            case "QUERY":
                if (!$this->query) $this->error("Warning - There's no SQL");
                $sqlString.= $this->query;

        }

        $sqlString.=";";
        return $sqlString;
    }

}