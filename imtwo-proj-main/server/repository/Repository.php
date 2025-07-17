<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once "IRepository.php";
require_once __DIR__."/../config/Database.php";



class Repository implements IRepository {
    protected $ConnectionDB;
    protected $CurrentModel;
    protected $ModelName;
    protected $ModelExcludedProp;

    public function __construct(string $modelName) {
        $this->ConnectionDB = connectDB('im2project');
        $this->CurrentModel = new $modelName();
        $this->ModelName = $modelName;
        $this->ModelExcludedProp = array('TableNameAlias');

        if (is_string($this->ConnectionDB))
        {
            die("CANNONT CONNECT TO DB\n" . $this->ConnectionDB);
        }
    }

    private function getTableName() {
        $currentModel = $this->CurrentModel;
        $tableName = isset($currentModel->TableNameAlias) ? $currentModel->TableNameAlias : $this->CurrentModel::class."s";

        return $tableName;
    }

    public function getInsertColumns(object $model, array $excludedColumns = null) : string
    {
        $allExcludedColumns = $this->ModelExcludedProp;
        if ($excludedColumns != null)
            $allExcludedColumns = array_merge($allExcludedColumns, $excludedColumns);

        $properties = array();
        foreach (get_object_vars($model) as $key => $value)
        {
            if (in_array($key, $allExcludedColumns))
                continue;
            array_push($properties, $key);
        }

        return join(", ", $properties);
    }

    public function getInsertValues(object $model, array $excludedColumns = null) : string
    {

        $allExcludedColumns = $this->ModelExcludedProp;
        if ($excludedColumns != null)
            $allExcludedColumns = array_merge($allExcludedColumns, $excludedColumns);

        $valueList = array();

        foreach (get_object_vars($model) as $key => $value) 
        {
            if (in_array($key, $allExcludedColumns))
                continue;

            if (is_string($value))
                array_push($valueList, "'$value'");
            elseif(is_bool($value))
                array_push($valueList, $value ? 1 : 0);
            else
                array_push($valueList, $value);
        }
        return join(", " , $valueList);
    }

    public function getUpdateValues(object $model, array $excludedColumns = null) : string
    {
        $allExcludedColumns = $this->ModelExcludedProp;
        if ($excludedColumns != null)
            $allExcludedColumns = array_merge($allExcludedColumns, $excludedColumns);

        $valueList = array();

        foreach (get_object_vars($model) as $key => $value) 
        {
            if (in_array($key, $allExcludedColumns))
                continue;

            $currentValue = '';

            if (is_string($value))
                $currentValue = "'$value'";
            elseif(is_bool($value))
                $currentValue = $value? 1 : 0;
            else
                $currentValue = $value;

            array_push($valueList, "$key = $currentValue");
        }
        return join(", " , $valueList);
    }

    private function logQuery(string $queryString){
        echo "<script>console.log('repo-query: $queryString');</script>";
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $query = "SELECT * FROM $tableName;";
        $this->logQuery($query);

        $result = $this->ConnectionDB->query($query);

        $modelList = array();

        while($row = $result->fetch_assoc()) {
            $current = new $this->ModelName($row);
            array_push($modelList, $current);
        }
        return $modelList;
    }
    public function get(int $id) 
    {
        $tableName = $this->getTableName();
        $query = "SELECT * FROM $tableName WHERE ID = $id;";
        $this->logQuery($query);

        $result = $this->ConnectionDB->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return new $this->ModelName($row);
            }
        } 
        return $result->fetch_assoc();
    }
    public function add(object $model)
    {
        $tableName = $this->getTableName();

        $excludedColumns = array("ID");
        $columnList =  $this->getInsertColumns($model, excludedColumns: $excludedColumns);

        $valueList = $this->getInsertValues($model, excludedColumns: $excludedColumns);
        
        $query = "INSERT INTO $tableName($columnList) VALUES($valueList);";
        $this->logQuery($query);

        if ($this->ConnectionDB->query($query) === true)
        {
            return $this->ConnectionDB->insert_id;
        }
        else {
            return -1;
        }
        
    }
    public function update(object $model)
    {
        $tableName = $this->getTableName();

        $excludedColumns = array("ID");
        $id = $model->ID;

        $valueList = $this->getUpdateValues($model, excludedColumns: $excludedColumns);
        $query = "UPDATE $tableName SET $valueList WHERE ID = $id;";
        $this->logQuery($query);
        return $this->ConnectionDB->query($query);
    }
    public function delete(int $id)
    {
        $tableName = $this->getTableName();
        $query = "DELETE FROM $tableName WHERE ID = $id;";
        $this->logQuery($query);
        return $this->ConnectionDB->query($query);
    }

    public function query(string $queryString)
    {
        $this->logQuery($queryString);
        $result = $this->ConnectionDB->query($queryString);

        $modelList = array();

        while($row = $result->fetch_assoc()) {
            $current = new $this->ModelName($row);
            array_push($modelList, $current);
        }
        return $modelList;
    }
}
