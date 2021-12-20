<?php

class Column{
    public $name;
    public $type;
    public $length;
    public $null;
    public $key;
    public $isAutoincrement;
    
    public function __construct($name, $type, $length, bool $null, bool $isPrimaryKey, bool $isAutoincrement){
        $this->name = $name;
        $this->type = $type;
        $this->length = $length;
        $this->null = $null;
        $this->key = $isPrimaryKey;
        $this->isAutoincrement = $isAutoincrement;
    }
}

class Table{
    public function __construct($tableName, Array $columns){
        $this->tableName = $tableName;
        $this->columns = $columns;
    }

    public function returnSql(){
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->tableName . " (";
        $primary = "";
        foreach ($this->columns as $column) {
            if ($column->key && $primary == "") {
                $primary = ", PRIMARY KEY(" . $column->name . ")";
            }
            $sql .= $column->name . " " . $column->type . "(" . $column->length . ")" . ($column->null ? " NULL " : " NOT NULL ") . ($column->isAutoincrement ? " AUTO_INCREMENT " : "") . ", ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= "$primary);";
        return $sql;
    }
}

class Database{
    public function __construct($dbName, Array $tables)
    {
        $this->dbName = $dbName;
        $this->tables = $tables;
    }

    public function createTables($connetion){
        $success = true;
        $conn = $connetion;
        foreach ($this->tables as $table) {
            $sql = $table->returnSql();
            if (!mysqli_query($conn, $sql)) {
                $success = false;
            }
        }
        return $success;
    }
}

?>