<?php

/**
 * Description of bd
 *
 * @author Guilherme Camacho
 * @url https://github.com/evguiters/php_mysql-easytools/
 */
class bd {

    function select($table, $where = null, $limit = null) {
        connect();
        $sql = 'SELECT * FROM ' . $table;

        if ($where == null) {
            $sql .= '';
        } else {
            $sql .= ' WHERE ' . $where;
        }
        
        if ($limit == null){
           $sql .= '';
        } else {
            $sql .= ' LIMIT ' . $limit;
        }
		
        $result = '';
        $res = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_assoc($res)) {
            $result[] = $row;
        }
        return $result;
    }

    function select_distinct($table, $col, $where = null) {
        connect();
        $sql = 'SELECT DISTINCT ' . $col . ' FROM ' . $table;

        if ($where == null) {
            $sql .= '';
        } else {
            $sql .= ' WHERE ' . $where;
        }
        $result = '';
        $res = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_assoc($res)) {
            $result[] = $row;
        }
        return $result;
    }

    function insert($table, $data) {
        connect();
        $sql = 'INSERT  INTO ' . $table . ' VALUES (';
        for ($i = 0; $i < count($data); $i++) {
            if (($i + 1) == count($data)) {
                $sql .= " '" . $data[$i] . "'";
            } elseif ($i == 0) {
                $sql .= "'" . $data[$i] . "'" . ", ";
            } else {
                $sql .= " '" . $data[$i] . "'" . ", ";
            }
        }
        $sql .=')';

        $res = mysql_query($sql) or die(mysql_error());

        if ($res) {
            return '1';
        } else {
            return '2';
        }
    }

    function update($table, $data, $where) {
        connect();
        $b = 0;
        $query_a = array();
        $vars = array();
        $result = mysql_query("SELECT * FROM $table");

        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            $vars[] = mysql_field_name($result, $b);
            $b++;
        }
        $sql = "";
        for ($i = 0; $i < count($data); $i++) {
            if (($i + 1) == count($data)) {
                $sql .= $vars[$i] . "='" . $data[$i] . "'";
            } else {
                $sql .= $vars[$i] . "='" . $data[$i] . "'" . ", ";
            }
        }

        $query = "UPDATE $table SET $sql WHERE $where";
        $res = mysql_query($query) or die(mysql_error());

        if ($res) {
            return '1';
        } else {
            return '2';
        }
    }

    function delete($table, $where) {
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $where;

        $res = mysql_query($sql) or die(mysql_error());

        if ($res) {
            return '1';
        } else {
            return '2';
        }
    }

}

?>
