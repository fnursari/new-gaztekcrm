<?php
if(!function_exists("getPreparingWhereConditionFromArray")) {
    function getPreparingWhereConditionFromArray($where)
    {
        if (empty($where)) {
            return "";
        } else {
            return " WHERE ".getWhereConditionFromArray($where)." ";
        }
    }
}


if(!function_exists("getWhereConditionFromArray")) {
    function getWhereConditionFromArray($where)
    {
        if (empty($where)) {
            return '';
        } else {
            foreach ($where as $k => $v) {                       
                $query_w[] = "`" . $k .  "`='" .  makeSafe($v). "'";
            }
            return implode(" AND ", $query_w);
        }        
    }
}

if(!function_exists("deleteTableData")) {
    function deleteTableData($tableName,$where) {
        global $db,$cfg;
        $sql = 'DELETE FROM '.$tableName.getPreparingWhereConditionFromArray($where);
        $db->query($sql);
        if($db->rows_affected==0) {
            return false;
        }
        return true;
    }
}


if(!function_exists("updateTableData")) {
    function updateTableData($tableName,$updateData=array(),$where) {
        global $db,$cfg;
        $args=array();
        foreach($updateData as $field=>$value){
            $args[]=$field."='".makeSafe($value)."'";
        }
        $sql='UPDATE '.$tableName.' SET '.implode(',',$args).getPreparingWhereConditionFromArray($where);
        $db->query($sql);
        if($db->rows_affected==0) {
            return false;
        }
        return true;
    }
}

if(!function_exists("insertDatatoTable")) {
    function insertDatatoTable($tableName,$insertData) {
        global $db,$cfg;
        $columns = implode(", ",array_keys($insertData));
        $escaped_values = array_map('makeSafe', array_values($insertData));
        foreach ($escaped_values as $idx=>$data) $escaped_values[$idx] = "'".$data."'";
        $values  = implode(", ", $escaped_values);

        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $db->query($sql);
        return $db->insert_id;
    }
}