<?php
// PHP 8.1+ makes mysqli throw exceptions by default; this connector checks errors itself
mysqli_report(MYSQLI_REPORT_OFF);

$APP_DB_LINK = NULL;

$MESSAGE = '';

function db_connect()
{
    global $APP_DB_SERVER, $APP_DB_USER, $APP_DB_PASS, $APP_DB_NAME, $APP_DB_PORT, $APP_DB_LINK, $MESSAGE;
    $APP_DB_LINK = mysqli_connect($APP_DB_SERVER, $APP_DB_USER, $APP_DB_PASS, $APP_DB_NAME, (int)$APP_DB_PORT ?: 3306);
    if (!$APP_DB_LINK) {
        $MESSAGE = mysqli_connect_error();
        $APP_DB_LINK = NULL;
        return FALSE;
    }
    mysqli_set_charset($APP_DB_LINK, 'utf8mb4');
    return TRUE;
}

/** False (and $MESSAGE set) when there is no DB connection */
function db_ready()
{
    global $APP_DB_LINK, $MESSAGE;
    if ($APP_DB_LINK) return TRUE;
    if ($MESSAGE == '') $MESSAGE = 'No database connection';
    return FALSE;
}

/** Names of the tables created by a schema file (CREATE TABLE `name`) */
function db_schema_tables($sqlFile)
{
    $sql = @file_get_contents($sqlFile);
    if ($sql === false) return [];
    preg_match_all('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?`([A-Za-z0-9_]+)`/i', $sql, $m);
    return $m[1];
}

/** Tables of the current database */
function db_tables()
{
    global $APP_DB_LINK;
    if (!db_ready()) return [];
    $ret = [];
    $re = mysqli_query($APP_DB_LINK, 'SHOW TABLES');
    if ($re) while ($r = mysqli_fetch_row($re)) $ret[] = $r[0];
    return $ret;
}

/**
 * Creates the database structure + initial data from a schema file (setup).
 * $replace: placeholder => value, every [[placeholder]] in the file is replaced with the SQL-escaped value.
 * $dropExisting: drop the schema's tables first (deletes their data).
 */
function db_initialize($sqlFile, $replace = [], $dropExisting = false)
{
    global $APP_DB_LINK, $MESSAGE;
    if (!db_ready()) return FALSE;
    $sql = @file_get_contents($sqlFile);
    if ($sql === false) {
        $MESSAGE = 'Schema file not found: ' . basename($sqlFile);
        return FALSE;
    }
    foreach ($replace as $k => $v) $sql = str_replace("[[$k]]", db_esc($v), $sql);
    if ($dropExisting) {
        $tables = db_schema_tables($sqlFile);
        if ($tables) $sql = 'DROP TABLE IF EXISTS `' . implode('`, `', $tables) . "`;\n" . $sql;
    }

    // the schema holds many statements: run them all, stop at the first error
    $MESSAGE = '';
    if (mysqli_multi_query($APP_DB_LINK, $sql)) {
        do {
            if ($res = mysqli_store_result($APP_DB_LINK)) mysqli_free_result($res);
            if (!mysqli_more_results($APP_DB_LINK)) break;
        } while (mysqli_next_result($APP_DB_LINK));
    }
    if (mysqli_errno($APP_DB_LINK)) $MESSAGE = mysqli_error($APP_DB_LINK);
    return ($MESSAGE == '');
}
/** Escapes a value for use inside a quoted SQL string: "col='" . db_esc($v) . "'" */
function db_esc($value)
{
    global $APP_DB_LINK;
    if (!$APP_DB_LINK) return addslashes((string)($value ?? ''));
    return mysqli_real_escape_string($APP_DB_LINK, (string)($value ?? ''));
}

/** True if $name is a safe column / table name (letters, digits, "_") */
function db_is_ident($name)
{
    return is_string($name) && preg_match('/^[A-Za-z0-9_]+$/', $name) === 1;
}

/** Keeps only the keys of $data that are listed in $allowed */
function db_only($data, $allowed)
{
    return array_intersect_key((array)$data, array_flip($allowed));
}

function db_select($what, $table, $where = '1', $order = NULL, $limit = NULL, $keyField = NULL)
{
    global $APP_DB_LINK, $MESSAGE;
    if (!db_ready()) return NULL;
    $ret = [];
    if (is_array($what)) $what = '`' . implode('`, `', $what) . '`';
    if (!empty($order)) $order = ' ORDER BY ' . $order;
    if (!empty($limit)) $limit = ' LIMIT ' . $limit;
    $re = mysqli_query($APP_DB_LINK, "SELECT $what FROM $table WHERE $where$order$limit");
    //        echo "SELECT $what FROM $table WHERE $where$order$limit";
    if (mysqli_errno($APP_DB_LINK)) {
        $MESSAGE = mysqli_error($APP_DB_LINK) . "<br>SELECT $what FROM $table WHERE $where$order$limit";
        $ret = NULL;
    } else {
        while ($r = mysqli_fetch_assoc($re)) {
            if (empty($keyField)) {
                $ret[] = $r;
            } else {
                $ret[$r[$keyField]] = $r;
            }
        }
    }
    return $ret;
}

function db_update($what, $table, $where)
{
    global $APP_DB_LINK, $MESSAGE;
    if (!db_ready()) return FALSE;

    $upd = [];
    foreach ($what as $k => $v) {
        if (!db_is_ident($k)) {
            $MESSAGE = 'Invalid field name';
            return FALSE;
        }
        $upd[] = "`$k`='" . db_esc($v) . "'";
    }
    if (count($upd) == 0) return TRUE;

    mysqli_query($APP_DB_LINK, "UPDATE $table SET " . implode(', ', $upd) . " WHERE $where");

    if (mysqli_errno($APP_DB_LINK)) {
        $MESSAGE = mysqli_error($APP_DB_LINK);
        return FALSE;
    }
    return TRUE;
}

function db_insert($what, $table)
{
    global $APP_DB_LINK, $MESSAGE;
    if (!db_ready()) return FALSE;
    $cols = [];
    $vals = [];
    foreach ($what as $k => $v) {
        if (!db_is_ident($k)) {
            $MESSAGE = 'Invalid field name';
            return FALSE;
        }
        $cols[] = "`$k`";
        $vals[] = "'" . db_esc($v) . "'";
    }
    $query = "INSERT INTO $table (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ")";
    mysqli_query($APP_DB_LINK, $query);
    if (mysqli_errno($APP_DB_LINK)) {
        $MESSAGE = mysqli_error($APP_DB_LINK);
        return FALSE;
    }
    return mysqli_insert_id($APP_DB_LINK);
}

function db_drop($where, $table)
{
    global $APP_DB_LINK, $MESSAGE;
    if (!db_ready()) return FALSE;

    mysqli_query($APP_DB_LINK, "DELETE FROM $table WHERE $where");

    if (mysqli_errno($APP_DB_LINK)) {
        $MESSAGE = mysqli_error($APP_DB_LINK);
        return FALSE;
    }
    return TRUE;
}
