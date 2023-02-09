<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 2 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Native sqlsrv class representing moodle database interface.
 *
 * @package    core_dml
 * @copyright  2009 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */

use core\dml\sql;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/moodle_database.php');
require_once(__DIR__.'/array_recordset.php');
require_once(__DIR__.'/sqlsrv_native_huge_recordset.php');
require_once(__DIR__.'/sqlsrv_native_moodle_temptables.php');

/**
 * Native sqlsrv class representing moodle database interface.
 *
 * @package    core_dml
 * @copyright  2009 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */
class sqlsrv_native_moodle_database extends moodle_database {

    protected $sqlsrv = null;
    protected $last_error_reporting; // To handle SQL*Server-Native driver default verbosity
    /** @var sqlsrv_native_moodle_temptables */
    protected $temptables; // Control existing temptables
    protected $collation;  // current DB collation cache

    /** @var array cached server information */
    protected $serverinfo = null;

    /**
     * Constructor - instantiates the database, specifying if it's external (connect to other systems) or no (Moodle DB)
     *              note this has effect to decide if prefix checks must be performed or no
     * @param bool true means external database used
     */
    public function __construct($external=false) {
        parent::__construct($external);
    }

    /**
     * Detects if all needed PHP stuff installed.
     * Note: can be used before connect()
     * @return mixed true if ok, string if something
     */
    public function driver_installed() {
        // use 'function_exists()' rather than 'extension_loaded()' because
        // the name used by 'extension_loaded()' is case specific! The extension
        // therefore *could be* mixed case and hence not found.
        if (!function_exists('sqlsrv_num_rows')) {
            return get_string('nativesqlsrvnodriver', 'install');
        }
        return true;
    }

    /**
     * Returns database family type - describes SQL dialect
     * Note: can be used before connect()
     * @return string db family name (mysql, postgres, mssql, sqlsrv, oracle, etc.)
     */
    public function get_dbfamily() {
        return 'mssql';
    }

    /**
     * Returns more specific database driver type
     * Note: can be used before connect()
     * @return string db type mysqli, pgsql, oci, mssql, sqlsrv
     */
    protected function get_dbtype() {
        return 'sqlsrv';
    }

    /**
     * Returns general database library name
     * Note: can be used before connect()
     * @return string db type pdo, native
     */
    protected function get_dblibrary() {
        return 'native';
    }

    /**
     * Returns localised database type name
     * Note: can be used before connect()
     * @return string
     */
    public function get_name() {
        return get_string('nativesqlsrv', 'install');
    }

    /**
     * Returns localised database configuration help.
     * Note: can be used before connect()
     * @return string
     */
    public function get_configuration_help() {
        return get_string('nativesqlsrvhelp', 'install');
    }

    /**
     * Diagnose database and tables, this function is used
     * to verify database and driver settings, db engine types, etc.
     *
     * @return string null means everything ok, string means problem found.
     */
    public function diagnose() {
        // Verify the database is running with READ_COMMITTED_SNAPSHOT enabled.
        // (that's required to get snapshots/row versioning on READ_COMMITED mode).
        $correctrcsmode = false;
        $sql = "SELECT is_read_committed_snapshot_on
                  FROM sys.databases
                 WHERE name = '{$this->dbname}'";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);
        if ($result) {
            if ($row = sqlsrv_fetch_array($result)) {
                $correctrcsmode = (bool)reset($row);
            }
        }
        $this->free_result($result);

        if (!$correctrcsmode) {
            return get_string('mssqlrcsmodemissing', 'error');
        }

        // Arrived here, all right.
        return null;
    }

    /**
     * Connect to db
     * Must be called before most other methods. (you can call methods that return connection configuration parameters)
     * @param string $dbhost The database host.
     * @param string $dbuser The database username.
     * @param string $dbpass The database username's password.
     * @param string $dbname The name of the database being connected to.
     * @param mixed $prefix string|bool The moodle db table name's prefix. false is used for external databases where prefix not used
     * @param array $dboptions driver specific options
     * @return bool true
     * @throws dml_connection_exception if error
     */
    public function connect($dbhost, $dbuser, $dbpass, $dbname, $prefix, array $dboptions=null) {
        if ($prefix == '' and !$this->external) {
            // Enforce prefixes for everybody but mysql.
            throw new dml_exception('prefixcannotbeempty', $this->get_dbfamily());
        }

        $driverstatus = $this->driver_installed();

        if ($driverstatus !== true) {
            throw new dml_exception('dbdriverproblem', $driverstatus);
        }

        if (!$this->external and strlen($prefix) > 80) {
            // Max prefix length is 128 - 48 = 80 characters,
            // see https://docs.microsoft.com/en-us/sql/odbc/microsoft/table-name-limitations?view=sql-server-2017
            $a = (object)array('dbfamily' => 'mssql', 'maxlength' => 80);
            throw new dml_exception('prefixtoolong', $a);
        }

        /*
         * Log all Errors.
         */
        sqlsrv_configure("WarningsReturnAsErrors", FALSE);
        sqlsrv_configure("LogSubsystems", SQLSRV_LOG_SYSTEM_OFF);
        sqlsrv_configure("LogSeverity", SQLSRV_LOG_SEVERITY_ERROR);

        $this->store_settings($dbhost, $dbuser, $dbpass, $dbname, $prefix, $dboptions);
        $dbhost = $this->dbhost;
        if (!empty($dboptions['dbport'])) {
            $dbhost .= ','.$dboptions['dbport'];
        }

        $options = array(
            'UID' => $this->dbuser,
            'PWD' => $this->dbpass,
            'Database' => $this->dbname,
            'CharacterSet' => 'UTF-8',
            'MultipleActiveResultSets' => true,
            'ConnectionPooling' => !empty($this->dboptions['dbpersist']),
            'ReturnDatesAsStrings' => true,
        );

        // Totara: add database communication encryption support
        if (!empty($this->dboptions['encrypt'])) {
            $options['encrypt'] = true;
            // Check if we're supporting unsigned certs
            if (isset($this->dboptions['trustservercertificate'])) {
                $options['TrustServerCertificate'] = (bool)$this->dboptions['trustservercertificate'];
            }
        }

        $this->sqlsrv = sqlsrv_connect($dbhost, $options);

        if ($this->sqlsrv === false) {
            $this->sqlsrv = null;
            $dberr = $this->get_last_error();

            throw new dml_connection_exception($dberr);
        }

        // Disable logging until we are fully setup.
        $this->query_log_prevent();

        // Allow quoted identifiers
        $sql = "SET QUOTED_IDENTIFIER ON";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        $this->free_result($result);

        // Force ANSI nulls so the NULL check was done by IS NULL and NOT IS NULL
        // instead of equal(=) and distinct(<>) symbols
        $sql = "SET ANSI_NULLS ON";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        $this->free_result($result);

        // Force ANSI warnings so arithmetic/string overflows will be
        // returning error instead of transparently truncating data
        $sql = "SET ANSI_WARNINGS ON";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        // Concatenating null with anything MUST return NULL
        $sql = "SET CONCAT_NULL_YIELDS_NULL  ON";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        $this->free_result($result);

        // Set transactions isolation level to READ_COMMITTED
        // prevents dirty reads when using transactions +
        // is the default isolation level of sqlsrv
        $sql = "SET TRANSACTION ISOLATION LEVEL READ COMMITTED";
        $this->query_start($sql, NULL, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        $this->free_result($result);

        // Totara: this is needed for unique indexes on nullable columns, we do not want any space trimming anyway.
        $sql = "SET ANSI_PADDING ON";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);
        $this->free_result($result);

        // We can enable logging now.
        $this->query_log_allow();

        // Connection established and configured, going to instantiate the temptables controller
        $this->temptables = new sqlsrv_native_moodle_temptables($this);

        return true;
    }

    /**
     * Close database connection and release all resources
     * and memory (especially circular memory references).
     * Do NOT use connect() again, create a new instance if needed.
     */
    public function dispose() {
        parent::dispose(); // Call parent dispose to write/close session and other common stuff before closing connection

        if ($this->sqlsrv) {
            sqlsrv_close($this->sqlsrv);
            $this->sqlsrv = null;
        }
    }

    /**
     * Called before each db query.
     * @param string $sql
     * @param array $params array of parameters
     * @param int $type type of query
     * @param mixed $extrainfo driver specific extra information
     * @return void
     */
    protected function query_start($sql, array $params = null, $type, $extrainfo = null) {
        parent::query_start($sql, $params, $type, $extrainfo);
    }

    /**
     * Called immediately after each db query.
     * @param mixed db specific result
     * @return void
     */
    protected function query_end($result) {
        parent::query_end($result);
    }

    /**
     * Returns database server info array
     * @return array Array containing 'description' and 'version' info
     */
    public function get_server_info() {
        if (!$this->sqlsrv) {
            return null;
        }

        if (isset($this->serverinfo)) {
            return $this->serverinfo;
        }

        $server_info = sqlsrv_server_info($this->sqlsrv);
        if (!$server_info) {
            return null;
        }

        $this->serverinfo = array(
            'description' => $server_info['SQLServerVersion'],
            'version' => $server_info['SQLServerVersion'],
        );

        // Totara: use database compatibility overrides instead of database engine version, see
        // https://docs.microsoft.com/en-us/sql/t-sql/statements/alter-database-transact-sql-compatibility-level?view=sql-server-ver15

        $compatibility_levels = [
            80 => '8.0',
            90 => '9.0',
            100 => '10.0',
            110 => '11.0',
            120 => '12.0',
            130 => '13.0',
            140 => '14.0',
            150 => '15.0',
        ];

        // Do not use ger_record() or similar here because it might internally need the server version and end up in infinite loop.
        $rsrc = $this->do_query("SELECT compatibility_level FROM sys.databases WHERE name=?", [$this->dbname], SQL_QUERY_AUX, false);
        if ($rsrc) {
            if ($row = sqlsrv_fetch_array($rsrc, SQLSRV_FETCH_ASSOC)) {
                if (isset($compatibility_levels[$row['compatibility_level']])) {
                    $this->serverinfo['version'] = $compatibility_levels[$row['compatibility_level']];
                } else {
                    error_log('unknown compatibility level detected in MS SQL server database: ' . $row['compatibility_level']);
                }
            }
            sqlsrv_free_stmt($rsrc);
        }

        return $this->serverinfo;
    }

    /**
     * Override: Converts short table name {tablename} to real table name
     * supporting temp tables (#) if detected
     *
     * @param string sql
     * @return string sql
     */
    protected function fix_table_names($sql) {
        $sql = preg_replace('/"ttr_([a-z][a-z0-9_]*)"/', '{$1}', $sql);
        $temptables = $this->temptables;
        $prefix = $this->prefix;
        $replacer = function ($matches) use ($temptables, $prefix) {
            $name = $matches[1];
            if ($temptables->is_temptable($name)) {
                return $temptables->get_correct_name($name);
            } else {
                return $prefix . $name;
            }
        };
        return preg_replace_callback('/{([a-z][a-z0-9_]*)}/', $replacer, $sql);
    }

    /**
     * Returns supported query parameter types
     * @return int bitmask
     */
    protected function allowed_param_types() {
        return SQL_PARAMS_QM;  // sqlsrv 1.1 can bind
    }

    /**
     * Returns last error reported by database engine.
     * @return string error message
     */
    public function get_last_error() {
        $retErrors = sqlsrv_errors(SQLSRV_ERR_ALL);
        $errorMessage = 'No errors found';

        if ($retErrors != null) {
            $errorMessage = '';

            foreach ($retErrors as $arrError) {
                $errorMessage .= "SQLState: ".$arrError['SQLSTATE']."<br>\n";
                $errorMessage .= "Error Code: ".$arrError['code']."<br>\n";
                $errorMessage .= "Message: ".$arrError['message']."<br>\n";
            }
        }

        return $errorMessage;
    }

    /**
     * Prepare the query binding and do the actual query.
     *
     * @param string|sql $sql The sql statement
     * @param array $params array of params for binding. If NULL, they are ignored.
     * @param int $sql_query_type - Type of operation
     * @param bool $free_result - Default true, transaction query will be freed.
     * @return resource|bool result
     */
    private function do_query($sql, $params, $sql_query_type, bool $free_result = true) {
        list($sql, $params, $type) = $this->fix_sql_params($sql, $params);

        /*
         * Bound variables in sqlsrv have too many limitations, so emulate them instead.
         *
         * -- skodak
         */

        $sql = $this->emulate_bound_params($sql, $params);
        $this->query_start($sql, $params, $sql_query_type);
        $result = sqlsrv_query($this->sqlsrv, $sql);

        $this->query_end($result);

        if ($free_result) {
            $this->free_result($result);
            return true;
        }
        return $result;
    }

    /**
     * Return tables in database WITHOUT current prefix.
     * @param bool $usecache if true, returns list of cached tables.
     * @return array of table names in lowercase and without prefix
     */
    public function get_tables($usecache = true) {
        if ($usecache and $this->tables !== null) {
            return $this->tables;
        }
        $this->tables = array ();
        $prefix = str_replace('_', '\\_', $this->prefix);
        $sql = "SELECT table_name
                  FROM INFORMATION_SCHEMA.TABLES
                 WHERE table_name LIKE '$prefix%' ESCAPE '\\' AND table_type = 'BASE TABLE'";

        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        if ($result) {
            while ($row = sqlsrv_fetch_array($result)) {
                $tablename = reset($row);
                if ($this->prefix !== false && $this->prefix !== '') {
                    if (strpos($tablename, $this->prefix) !== 0) {
                        continue;
                    }
                    $tablename = substr($tablename, strlen($this->prefix));
                }
                $this->tables[$tablename] = $tablename;
            }
            $this->free_result($result);
        }

        // Separate tables cause we're going to be adding to it.
        $tables = $this->tables;
        // Add the currently available temptables
        foreach ($this->temptables->get_temptables() as $tablename => $tablenameencoded) {
            $tables[$tablename] = $tablename;
        }
        return $tables;
    }

    /**
     * @inheritDoc
     */
    public function get_primary_keys(string $table): array {
        $keys = [];
        $table_name = $this->prefix.$table;

        $sql = "SELECT 
                 ku.COLUMN_NAME as column_name 
            FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS tc 
            INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS ku
                ON tc.CONSTRAINT_TYPE = 'PRIMARY KEY' 
                AND tc.CONSTRAINT_NAME = ku.CONSTRAINT_NAME 
                AND ku.TABLE_NAME = :table_name 
            ORDER BY ku.TABLE_NAME, ku.ORDINAL_POSITION";

        $rows = $this->get_records_sql_unkeyed($sql, ['table_name' => $table_name]);

        foreach ($rows as $row) {
            $keys[$row->column_name] = [
                'column_name' => $row->column_name
            ];
        }

        return $keys;
    }

    /**
     * Return table indexes - everything lowercased.
     * @param string $table The table we want to get indexes from.
     * @return array of arrays
     */
    public function get_indexes($table) {
        $indexes = array ();
        $tablename = $this->prefix.$table;

        // Indexes aren't covered by information_schema metatables, so we need to
        // go to sys ones. Skipping primary key indexes on purpose.
        $sql = "SELECT i.name AS index_name, i.is_unique, ic.index_column_id, c.name AS column_name
                  FROM sys.indexes i
                  JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
                  JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
                  JOIN sys.tables t ON i.object_id = t.object_id
                 WHERE t.name = '$tablename' AND i.is_primary_key = 0
              ORDER BY i.name, i.index_id, ic.index_column_id";

        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        if (!$result) {
            return array();
        }

        $fulltextsearch = false;
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            if (preg_match('/^(.*)([^_]+)_fts$/', $row['index_name'], $matches)) {
                $fulltextsearch = $matches[1];
                continue;

            } else if (!isset($indexes[$row['index_name']])) {
                $indexes[$row['index_name']] = array(
                    'unique' => empty($row['is_unique']) ? false : true,
                    'columns' => array($row['column_name']),
                    'fulltextsearch' => false,
                );

            } else {
                $indexes[$row['index_name']]['columns'][] = $row['column_name'];
            }
        }
        $this->free_result($result);

        if ($fulltextsearch !== false) {
            // We need to find the fake full text search indices the slow way.
            $sql = "SELECT ic.column_id, c.name AS column_name
                            FROM sys.fulltext_indexes i
                            JOIN sys.fulltext_index_columns ic ON i.object_id = ic.object_id
                            JOIN sys.tables t ON i.object_id = t.object_id
                            JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
                           WHERE t.name = '$tablename' ";

            $this->query_start($sql, null, SQL_QUERY_AUX);
            $result = sqlsrv_query($this->sqlsrv, $sql);
            $this->query_end($result);

            if ($result) {
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    $indexes[$fulltextsearch . $row['column_name'] . '_fts'] = array(
                        'unique'  => false,
                        'columns' => array($row['column_name']),
                        'fulltextsearch'  => true,
                    );
                }
                $this->free_result($result);
            }
        }
        return $indexes;
    }

    /**
     * Returns detailed information about columns in table. This information is cached internally.
     * @param string $table name
     * @param bool $usecache
     * @return array array of database_column_info objects indexed with column names
     */
    public function get_columns($table, $usecache = true) {
        if ($usecache) {
            if ($this->temptables->is_temptable($table)) {
                if ($data = $this->get_temp_tables_cache()->get($table)) {
                    return $data;
                }
            } else {
                if ($data = $this->get_metacache()->get($table)) {
                    return $data;
                }
            }
        }

        $structure = array();

        if (!$this->temptables->is_temptable($table)) { // normal table, get metadata from own schema
            $sql = "SELECT column_name AS name,
                           data_type AS type,
                           numeric_precision AS max_length,
                           character_maximum_length AS char_max_length,
                           numeric_scale AS scale,
                           is_nullable AS is_nullable,
                           columnproperty(object_id(quotename(table_schema) + '.' + quotename(table_name)), column_name, 'IsIdentity') AS auto_increment,
                           column_default AS default_value
                      FROM INFORMATION_SCHEMA.COLUMNS
                     WHERE table_name = '{".$table."}'
                  ORDER BY ordinal_position";
        } else { // temp table, get metadata from tempdb schema
            $sql = "SELECT column_name AS name,
                           data_type AS type,
                           numeric_precision AS max_length,
                           character_maximum_length AS char_max_length,
                           numeric_scale AS scale,
                           is_nullable AS is_nullable,
                           columnproperty(object_id(quotename(table_schema) + '.' + quotename(table_name)), column_name, 'IsIdentity') AS auto_increment,
                           column_default AS default_value
                      FROM tempdb.INFORMATION_SCHEMA.COLUMNS ".
            // check this statement
            // JOIN tempdb..sysobjects ON name = table_name
            // WHERE id = object_id('tempdb..{".$table."}')
                    "WHERE table_name LIKE '{".$table."}__________%'
                  ORDER BY ordinal_position";
        }

        list($sql, $params, $type) = $this->fix_sql_params($sql, null);

        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        if (!$result) {
            return array ();
        }

        while ($rawcolumn = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $rawcolumn = (object)$rawcolumn;

            $info = new stdClass();
            $info->name = $rawcolumn->name;
            $info->type = $rawcolumn->type;
            $info->meta_type = $this->sqlsrvtype2moodletype($info->type);

            // Prepare auto_increment info
            $info->auto_increment = $rawcolumn->auto_increment ? true : false;

            // Define type for auto_increment columns
            $info->meta_type = ($info->auto_increment && $info->meta_type == 'I') ? 'R' : $info->meta_type;

            // id columns being auto_incremnt are PK by definition
            $info->primary_key = ($info->name == 'id' && $info->meta_type == 'R' && $info->auto_increment);

            if ($info->meta_type === 'C' and $rawcolumn->char_max_length == -1) {
                // This is NVARCHAR(MAX), not a normal NVARCHAR.
                $info->max_length = -1;
                $info->meta_type = 'X';
            } else {
                // Put correct length for character and LOB types
                $info->max_length = $info->meta_type == 'C' ? $rawcolumn->char_max_length : $rawcolumn->max_length;
                $info->max_length = ($info->meta_type == 'X' || $info->meta_type == 'B') ? -1 : $info->max_length;
            }

            // Scale
            $info->scale = $rawcolumn->scale;

            // Prepare not_null info
            $info->not_null = $rawcolumn->is_nullable == 'NO' ? true : false;

            // Process defaults
            $info->has_default = !empty($rawcolumn->default_value);
            if ($rawcolumn->default_value === NULL) {
                $info->default_value = NULL;
            } else {
                $info->default_value = preg_replace("/^[\(N]+[']?(.*?)[']?[\)]+$/", '\\1', $rawcolumn->default_value);
            }

            // Process binary
            $info->binary = $info->meta_type == 'B' ? true : false;

            $structure[$info->name] = new database_column_info($info);
        }
        $this->free_result($result);

        if ($usecache) {
            if ($this->temptables->is_temptable($table)) {
                $this->get_temp_tables_cache()->set($table, $structure);
            } else {
                $this->get_metacache()->set($table, $structure);
            }
        }

        return $structure;
    }

    /**
     * Normalise values based in RDBMS dependencies (booleans, LOBs...)
     *
     * @param database_column_info $column column metadata corresponding with the value we are going to normalise
     * @param mixed $value value we are going to normalise
     * @return mixed the normalised value
     */
    protected function normalise_value($column, $value) {
        $this->detect_objects($value);

        if (is_bool($value)) {                               // Always, convert boolean to int
            $value = (int)$value;
        }                                                    // And continue processing because text columns with numeric info need special handling below

        if ($column->meta_type == 'B')
            { // BLOBs need to be properly "packed", but can be inserted directly if so.
            if (!is_null($value)) {               // If value not null, unpack it to unquoted hexadecimal byte-string format
                $value = unpack('H*hex', $value); // we leave it as array, so emulate_bound_params() can detect it
            }                                                // easily and "bind" the param ok.

        } else if ($column->meta_type == 'X') {              // sqlsrv doesn't cast from int to text, so if text column
            // and is numeric value then cast to string
            if (is_numeric($value)) {
                if (is_float($value)) {
                    $value = core_text::float2str($value);
                }
                $value = array('numstr' => (string)$value);  // and put into array, so emulate_bound_params() will know how
            }                                                // to "bind" the param ok, avoiding reverse conversion to number
        } else if ($value === '') {

            if ($column->meta_type == 'I' or $column->meta_type == 'F' or $column->meta_type == 'N') {
                $value = 0; // prevent '' problems in numeric fields
            }
        }
        return $value;
    }

    /**
     * Selectively call sqlsrv_free_stmt(), avoiding some warnings without using the horrible @
     *
     * @param resource $resource resource to be freed if possible
     * @return bool
     */
    private function free_result($resource) {
        if (!is_bool($resource)) { // true/false resources cannot be freed
            return sqlsrv_free_stmt($resource);
        }
    }

    /**
     * Provides mapping between sqlsrv native data types and moodle_database - database_column_info - ones)
     *
     * @param string $sqlsrv_type native sqlsrv data type
     * @return string 1-char database_column_info data type
     */
    private function sqlsrvtype2moodletype($sqlsrv_type) {
        $type = null;

        switch (strtoupper($sqlsrv_type)) {
          case 'BIT':
           $type = 'L';
           break;

          case 'INT':
          case 'SMALLINT':
          case 'INTEGER':
          case 'BIGINT':
           $type = 'I';
           break;

          case 'DECIMAL':
          case 'REAL':
          case 'FLOAT':
           $type = 'N';
           break;

          case 'VARCHAR':
          case 'NVARCHAR':
           $type = 'C';
           break;

          case 'TEXT':
          case 'NTEXT':
          case 'VARCHAR(MAX)':
          case 'NVARCHAR(MAX)':
           $type = 'X';
           break;

          case 'IMAGE':
          case 'VARBINARY':
          case 'VARBINARY(MAX)':
           $type = 'B';
           break;

          case 'DATETIME':
           $type = 'D';
           break;
         }

        if (!$type) {
            throw new dml_exception('invalidsqlsrvnativetype', $sqlsrv_type);
        }
        return $type;
    }

    /**
     * Do NOT use in code, to be used by database_manager only!
     * @param string|array $sql query
     * @param array|null $tablenames an array of xmldb table names affected by this request.
     * @return bool true
     * @throws ddl_change_structure_exception A DDL specific exception is thrown for any errors.
     */
    public function change_database_structure($sql, $tablenames = null) {
        if ($this->is_transaction_started()) {
            debugging('Transactions are not compatible with DDL operations in MySQL and MS SQL Server', DEBUG_DEVELOPER);
        }
        $this->get_manager(); // Includes DDL exceptions classes ;-)
        $sqls = (array)$sql;

        try {
            foreach ($sqls as $sql) {
                $this->query_start($sql, null, SQL_QUERY_STRUCTURE);
                $result = sqlsrv_query($this->sqlsrv, $sql);
                $this->query_end($result);
            }
        } catch (ddl_change_structure_exception $e) {
            $this->reset_caches($tablenames);
            throw $e;
        }

        $this->reset_caches($tablenames);
        return true;
    }

    /**
     * Prepare the array of params for native binding
     */
    protected function build_native_bound_params(array $params = null) {

        return null;
    }

    /**
     * Workaround for SQL*Server Native driver similar to MSSQL driver for
     * consistent behavior.
     */
    protected function emulate_bound_params($sql, array $params = null) {

        if (empty($params)) {
            return $sql;
        }
        // ok, we have verified sql statement with ? and correct number of params
        $parts = array_reverse(explode('?', $sql));
        $return = array_pop($parts);
        foreach ($params as $param) {
            if (is_bool($param)) {
                $return .= (int)$param;
            } else if (is_array($param) && isset($param['hex'])) { // detect hex binary, bind it specially
                $return .= '0x'.$param['hex'];
            } else if (is_array($param) && isset($param['numstr'])) { // detect numerical strings that *must not*
                $return .= "N'{$param['numstr']}'";                   // be converted back to number params, but bound as strings
            } else if (is_null($param)) {
                $return .= 'NULL';

            } else if (is_number($param)) { // we can not use is_numeric() because it eats leading zeros from strings like 0045646
                $return .= "'$param'"; // this is a hack for MDL-23997, we intentionally use string because it is compatible with both nvarchar and int types
            } else if (is_float($param)) {
                $return .= core_text::float2str($param);
            } else {
                $param = str_replace("'", "''", $param);
                $param = str_replace("\0", "", $param);
                $return .= "N'$param'";
            }

            $return .= array_pop($parts);
        }
        return $return;
    }

    /**
     * Execute general sql query. Should be used only when no other method suitable.
     * Do NOT use this to make changes in db structure, use database_manager methods instead!
     * @param string|sql $sql query
     * @param array $params query parameters
     * @return bool true
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function execute($sql, array $params = null) {
        if (strpos($sql, ';') !== false) {
            throw new coding_exception('moodle_database::execute() Multiple sql statements found or bound parameters not used properly in query!');
        }
        $this->do_query($sql, $params, SQL_QUERY_UPDATE);
        return true;
    }

    /**
     * Fetch records from database.
     *
     * @param string|sql $sql
     * @param array $params
     * @param int $limitfrom
     * @param int $limitnum
     * @param bool $numkeys
     * @return array
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    private function fetch_records($sql, ?array $params, int $limitfrom, int $limitnum, bool $numkeys): array {
        list($sql, $params, $type) = $this->fix_sql_params($sql, $params);

        if ($limitfrom || $limitnum) {
            // Remove problematic trailing semicolons, hopefully there are no comments in the statement.
            $sql = rtrim($sql);
            $sql = rtrim($sql, ';');

            // We need order by to use FETCH/OFFSET.
            // Ordering by first column shouldn't break anything if there was no order in the first place.
            if (!strpos(strtoupper($sql), "ORDER BY")) {
                $sql .= " ORDER BY 1";
            }

            $sql .= " OFFSET " . $limitfrom . " ROWS ";

            if ($limitnum > 0) {
                $sql .= " FETCH NEXT " . $limitnum . " ROWS ONLY";
            }
        }

        $rsrc = $this->do_query($sql, $params, SQL_QUERY_SELECT, false);

        $result = [];
        while ($row = sqlsrv_fetch_array($rsrc, SQLSRV_FETCH_ASSOC)) {
            $row = array_change_key_case($row, CASE_LOWER);
            // Totara expects everything from DB as strings.
            foreach ($row as $k => $v) {
                if (is_null($v)) {
                    continue;
                }
                if (!is_string($v)) {
                    if (is_float($v)) {
                        $v = core_text::float2str($v);
                    }
                    $row[$k] = (string)$v;
                }
            }
            if ($numkeys) {
                $result[] = (object)$row;
            } else {
                $id = reset($row);
                if (isset($result[$id])) {
                    $colname = key($row);
                    debugging("Did you remember to make the first column something unique in your call to get_records? Duplicate value '$id' found in column '$colname'.", DEBUG_DEVELOPER);
                }
                $result[$id] = (object)$row;
            }
        }
        sqlsrv_free_stmt($rsrc);

        return $result;
    }

    /**
     * Get a number of records as a moodle_recordset using a SQL statement.
     *
     * This method is intended for queries with reasonable result size only,
     * @see moodle_database::get_huge_recordset_sql() if the results might not fit into memory.
     *
     * The result may be used as iterator in foreach(), if you want to obtain
     * an array with incremental numeric keys @see moodle_recordset::to_array()
     *
     * @param string|sql $sql the SQL select query to execute.
     * @param array|null $params array of sql parameters
     * @param int $limitfrom return a subset of records, starting at this point (optional).
     * @param int $limitnum return a subset comprising this many records (optional, required if $limitfrom is set).
     * @return moodle_recordset A moodle_recordset instance.
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function get_recordset_sql($sql, array $params = null, $limitfrom = 0, $limitnum = 0) {
        list($limitfrom, $limitnum) = $this->normalise_limit_from_num($limitfrom, $limitnum);
        $data = $this->fetch_records($sql, $params, $limitfrom, $limitnum, true);
        return new array_recordset($data);
    }

    /**
     * Get records as a moodle_recordset using a SQL statement.
     *
     * This is intended to be used instead of @see moodle_database::get_recordset_sql()
     * when results may not fit into available PHP memory.
     *
     * Notes:
     *   - it is not acceptable to modify referenced tables during iteration due to MS SQL Server limitations
     *   - transactions cannot be started while iterating the records due to MS SQL Server limitations
     *
     * @since Totara 13.0
     *
     * @param string|sql $sql the SQL select query to execute.
     * @param array $params array of sql parameters
     * @return moodle_recordset A moodle_recordset instance.
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function get_huge_recordset_sql($sql, array $params = null): moodle_recordset {
        $rsrc = $this->do_query($sql, $params, SQL_QUERY_SELECT, false);
        return new sqlsrv_native_huge_recordset($rsrc);
    }

    /**
     * Get a number of records as an array of objects using a SQL statement.
     *
     * Return value is like:
     * @see function get_records.
     *
     * @param string|sql $sql the SQL select query to execute. The first column of this SELECT statement
     *   must be a unique value (usually the 'id' field), as it will be used as the key of the
     *   returned array.
     * @param array $params array of sql parameters
     * @param int $limitfrom return a subset of records, starting at this point (optional, required if $limitnum is set).
     * @param int $limitnum return a subset comprising this many records (optional, required if $limitfrom is set).
     * @param bool $unique_id Require the first column to be unique and key the array by it, otherwise return an array with sequential keys
     * @return array of objects, or empty array if no records were found
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    protected function get_records_sql_raw($sql, array $params = null, $limitfrom = 0, $limitnum = 0, bool $unique_id = true): array {

        $rs = $this->get_recordset_sql($sql, $params, $limitfrom, $limitnum);

        $results = array();

        foreach ($rs as $row) {
            $this->add_row_to_result($row, $results, $unique_id);
        }

        $rs->close();

        return $results;
    }

    /**
     * Selects records and return values (first field) as an array using a SQL statement.
     *
     * @param string|sql $sql The SQL query
     * @param array $params array of sql parameters
     * @return array of values
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function get_fieldset_sql($sql, array $params = null) {
        $data = $this->fetch_records($sql, $params, 0, 0, true);

        foreach ($data as $k => $row) {
            // Totara: reset is only valid for arrays
            if (!is_array($row)) {
                $row = (array) $row;
            }
            $data[$k] = reset($row);
        }

        return $data;
    }

    /**
     * Insert new record into database, as fast as possible, no safety checks, lobs not supported.
     * @param string $table name
     * @param mixed $params data record as object or array
     * @param bool $returnit return it of inserted record
     * @param bool $bulk true means repeated inserts expected
     * @param bool $customsequence true if 'id' included in $params, disables $returnid
     * @return bool|int true or new id
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function insert_record_raw($table, $params, $returnid=true, $bulk=false, $customsequence=false) {
        if (!is_array($params)) {
            $params = (array)$params;
        }

        $isidentity = false;

        if ($customsequence) {
            if (!isset($params['id'])) {
                throw new coding_exception('moodle_database::insert_record_raw() id field must be specified if custom sequences used.');
            }

            $returnid = false;
            $columns = $this->get_columns($table);
            if (isset($columns['id']) and $columns['id']->auto_increment) {
                $isidentity = true;
            }

            // Disable IDENTITY column before inserting record with id, only if the
            // column is identity, from meta information.
            if ($isidentity) {
                $sql = 'SET IDENTITY_INSERT {'.$table.'} ON'; // Yes, it' ON!!
                $this->do_query($sql, null, SQL_QUERY_AUX);
            }

        } else {
            unset($params['id']);
        }

        if (empty($params)) {
            throw new coding_exception('moodle_database::insert_record_raw() no fields found.');
        }
        $fields = array();
        foreach ($params as $field => $value) {
            $fields[] = '"' . $field . '"'; // Totara: always quote column names to allow reserved words.
        }
        $fields = implode(',', $fields);
        $qms = array_fill(0, count($params), '?');
        $qms = implode(',', $qms);
        $sql = "INSERT INTO {" . $table . "} ($fields) VALUES($qms)";
        $query_id = $this->do_query($sql, $params, SQL_QUERY_INSERT);

        if ($customsequence) {
            // Enable IDENTITY column after inserting record with id, only if the
            // column is identity, from meta information.
            if ($isidentity) {
                $sql = 'SET IDENTITY_INSERT {'.$table.'} OFF'; // Yes, it' OFF!!
                $this->do_query($sql, null, SQL_QUERY_AUX);
            }
        }

        if ($returnid) {
            // Totara: use low level API so that the identity value does not get lost
            $sql = 'SELECT SCOPE_IDENTITY() AS id';
            $this->query_start($sql, null, SQL_QUERY_AUX);
            $result = sqlsrv_query($this->sqlsrv, $sql);
            $this->query_end($result);
            $id = sqlsrv_fetch_array($result)['id'];
            $this->free_result($result);
            return (int)$id;
        } else {
            return true;
        }
    }

    /**
     * Find out the identity information for given table.
     *
     * @param string $tablename
     * @return array ($identityvalue, $columnvalue, $nextid), or empty array on error
     */
    public function get_identity_info($tablename) {
        // Use direct db access to get the server message reliably.
        $result = sqlsrv_query($this->sqlsrv, "DBCC CHECKIDENT ('{$this->prefix}{$tablename}', NORESEED);");
        if ($result === false) {
            return array();
        }
        $info = sqlsrv_errors();
        sqlsrv_free_stmt($result);
        if (!is_array($info)) {
            return array();
        }
        foreach ($info as $data) {
            if ($data['code'] == 7998) {
                if (preg_match("/current identity value '([^']+)', current column value '([^']+)'/", $data['message'], $matches)) {
                    $identityvalue = $matches[1];
                    $columnvalue = $matches[2];
                    if ($identityvalue === 'NULL') {
                        // Identity is the seed - future value of the first record inserted into the table.
                        $nextid = (int)$this->get_field_sql("SELECT IDENT_CURRENT(?)", array($this->prefix.$tablename));
                    } else {
                        // Something was already inserted, identity value is supposed to be already taken.
                        $nextid = (int)$identityvalue + 1;
                    }
                    return array($identityvalue, $columnvalue, $nextid);
                }
            }
        }
        // We should never get here, if we do phpunit will most likely fail in some weird way...
        return array();
    }

    /**
     * Insert a record into a table and return the "id" field if required.
     *
     * Some conversions and safety checks are carried out. Lobs are supported.
     * If the return ID isn't required, then this just reports success as true/false.
     * $data is an object containing needed data
     * @param string $table The database table to be inserted into
     * @param object $data A data object with values for one or more fields in the record
     * @param bool $returnid Should the id of the newly created record entry be returned? If this option is not requested then true/false is returned.
     * @return bool|int true or new id
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function insert_record($table, $dataobject, $returnid = true, $bulk = false) {
        $dataobject = (array)$dataobject;

        $columns = $this->get_columns($table);
        if (empty($columns)) {
            throw new dml_exception('ddltablenotexist', $table);
        }

        $cleaned = array ();

        foreach ($dataobject as $field => $value) {
            if ($field === 'id') {
                continue;
            }
            if (!isset($columns[$field])) {
                continue;
            }
            $column = $columns[$field];
            $cleaned[$field] = $this->normalise_value($column, $value);
        }

        return $this->insert_record_raw($table, $cleaned, $returnid, $bulk);
    }

    /**
     * Insert multiple records into database as fast as possible.
     *
     * Order of inserts is maintained, but the operation is not atomic,
     * use transactions if necessary.
     *
     * This method is intended for inserting of large number of small objects,
     * do not use for huge objects with text or binary fields.
     *
     * @since Totara 13
     *
     * @param string $table  The database table to be inserted into
     * @param array|Traversable $dataobjects list of objects to be inserted, must be compatible with foreach
     * @return void does not return new record ids
     *
     * @throws coding_exception if data objects have different structure
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function insert_records($table, $dataobjects) {
        if (!is_array($dataobjects) and !($dataobjects instanceof Traversable)) {
            throw new coding_exception('insert_records() passed non-traversable object');
        }

        // Mssql does seem to perform best with relatively small chunks
        $chunksize = 25;
        if (!empty($this->dboptions['bulkinsertsize'])) {
            $chunksize = (int)$this->dboptions['bulkinsertsize'];
        }

        $columns = $this->get_columns($table, true);

        $fields = null;
        $count = 0;
        $chunk = array();
        foreach ($dataobjects as $dataobject) {
            if (!is_array($dataobject) and !is_object($dataobject)) {
                throw new coding_exception('insert_records() passed invalid record object');
            }
            $dataobject = (array)$dataobject;
            if ($fields === null) {
                $fields = array_keys($dataobject);
                $columns = array_intersect_key($columns, $dataobject);
                unset($columns['id']);
            } else if ($fields !== array_keys($dataobject)) {
                throw new coding_exception('All dataobjects in insert_records() must have the same structure!');
            }

            $count++;
            $chunk[] = $dataobject;

            if ($count === $chunksize) {
                $this->insert_chunk($table, $chunk, $columns);
                $chunk = array();
                $count = 0;
            }
        }

        if ($count) {
            $this->insert_chunk($table, $chunk, $columns);
        }
    }

    /**
     * Insert records in chunks, strict param types...
     *
     * @since Totara 13
     *
     * @param string $table
     * @param array $chunk
     * @param database_column_info[] $columns
     */
    protected function insert_chunk($table, array $chunk, array $columns) {
        $params = array();
        $values = array();
        foreach ($chunk as $dataobject) {
            $vals = array();
            foreach ($columns as $field => $column) {
                $params[] = $this->normalise_value($column, $dataobject[$field]);
                $vals[] = "?";
            }
            $values[] = '('.implode(',', $vals).')';
        }

        $fieldssql = '('.implode(',', array_keys($columns)).')';
        $valuessql = implode(',', $values);

        $sql = "INSERT INTO {" . $table . "} $fieldssql VALUES $valuessql";

        $this->do_query($sql, $params, SQL_QUERY_INSERT);
    }

    /**
     * Import a record into a table, id field is required.
     * Safety checks are NOT carried out. Lobs are supported.
     *
     * @param string $table name of database table to be inserted into
     * @param object $dataobject A data object with values for one or more fields in the record
     * @return bool true
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function import_record($table, $dataobject) {
        if (!is_object($dataobject)) {
            $dataobject = (object)$dataobject;
        }

        $columns = $this->get_columns($table);
        $cleaned = array ();

        foreach ($dataobject as $field => $value) {
            if (!isset($columns[$field])) {
                continue;
            }
            $column = $columns[$field];
            $cleaned[$field] = $this->normalise_value($column, $value);
        }

        $this->insert_record_raw($table, $cleaned, false, false, true);

        return true;
    }

    /**
     * Update record in database, as fast as possible, no safety checks, lobs not supported.
     * @param string $table name
     * @param mixed $params data record as object or array
     * @param bool true means repeated updates expected
     * @return bool true
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function update_record_raw($table, $params, $bulk = false) {
        $params = (array)$params;

        if (!isset($params['id'])) {
            throw new coding_exception('moodle_database::update_record_raw() id field must be specified.');
        }
        $id = $params['id'];
        unset($params['id']);

        if (empty($params)) {
            throw new coding_exception('moodle_database::update_record_raw() no fields found.');
        }

        $sets = array ();

        foreach ($params as $field => $value) {
            $sets[] = '"' . $field .'" = ?'; // Totara: always quote column names to allow reserved words.
        }

        $params[] = $id; // last ? in WHERE condition

        $sets = implode(',', $sets);
        $sql = "UPDATE {".$table."} SET $sets WHERE id = ?";

        $this->do_query($sql, $params, SQL_QUERY_UPDATE);

        return true;
    }

    /**
     * Update a record in a table
     *
     * $dataobject is an object containing needed data
     * Relies on $dataobject having a variable "id" to
     * specify the record to update
     *
     * @param string $table The database table to be checked against.
     * @param object $dataobject An object with contents equal to fieldname=>fieldvalue. Must have an entry for 'id' to map to the table specified.
     * @param bool true means repeated updates expected
     * @return bool true
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function update_record($table, $dataobject, $bulk = false) {
        $dataobject = (array)$dataobject;

        $columns = $this->get_columns($table);
        $cleaned = array ();

        foreach ($dataobject as $field => $value) {
            if (!isset($columns[$field])) {
                continue;
            }
            $column = $columns[$field];
            $cleaned[$field] = $this->normalise_value($column, $value);
        }

        return $this->update_record_raw($table, $cleaned, $bulk);
    }

    /**
     * Delete one or more records from a table which match a particular WHERE clause.
     *
     * @param string $table The database table to be checked against.
     * @param string|sql $select A fragment of SQL to be used in a where clause in the SQL call (used to define the selection criteria).
     * @param array $params array of sql parameters
     * @return bool true
     * @throws dml_exception A DML specific exception is thrown for any errors.
     */
    public function delete_records_select($table, $select, array $params = null) {
        if ($select instanceof sql) {
            $sql = self::sql("DELETE FROM {{$table}}");
            $sql = $sql->append($select->prepend("WHERE"));
        } else {
            if ($select) {
                $select = "WHERE $select";
            }
            $sql = "DELETE FROM {{$table}} $select";
        }

        // we use SQL_QUERY_UPDATE because we do not know what is in general SQL, delete constant would not be accurate
        $this->do_query($sql, $params, SQL_QUERY_UPDATE);

        return true;
    }


    public function sql_cast_char2int($fieldname, $text = false) {
        if (!$text) {
            return ' CAST(' . $fieldname . ' AS BIGINT) ';
        } else {
            return ' CAST(' . $this->sql_compare_text($fieldname) . ' AS BIGINT) ';
        }
    }

    public function sql_cast_char2real($fieldname, $text=false) {
        if (!$text) {
            return ' CAST(' . $fieldname . ' AS REAL) ';
        } else {
            return ' CAST(' . $this->sql_compare_text($fieldname) . ' AS REAL) ';
        }
    }

    public function sql_cast_char2float($fieldname) {
        return ' CAST(' . $fieldname . ' AS FLOAT) ';
    }

    public function sql_cast_2char($fieldname) {
        return ' CAST(' . $fieldname . ' AS NVARCHAR(MAX)) ';
    }

    public function sql_ceil($fieldname) {
        // We use sprintf to convert the value to a locale-independent float value
        return ' CEILING('.sprintf('%F', $fieldname).')';
    }

    public function sql_round($fieldname, $places = 0) {
        // We use sprintf to convert the value to a locale-independent float value
        if ($places >= 0) {
            return "CAST(ROUND(".sprintf('%F', $fieldname).", {$places}) AS DECIMAL(20, {$places}))";
        } else {
            return "ROUND(CAST(".sprintf('%F', $fieldname)." AS DECIMAL(20, 0)), {$places})";
        }
    }

    protected function get_collation() {
        if (isset($this->collation)) {
            return $this->collation;
        }
        if (!empty($this->dboptions['dbcollation'])) {
            // perf speedup
            $this->collation = $this->dboptions['dbcollation'];
            return $this->collation;
        }

        // make some default
        $this->collation = 'Latin1_General_CI_AI';

        $sql = "SELECT CAST(DATABASEPROPERTYEX('$this->dbname', 'Collation') AS varchar(255)) AS SQLCollation";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        if ($result) {
            if ($rawcolumn = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $this->collation = reset($rawcolumn);
            }
            $this->free_result($result);
        }

        return $this->collation;
    }

    public function sql_equal($fieldname, $param, $casesensitive = true, $accentsensitive = true, $notequal = false) {
        $equalop = $notequal ? '<>' : '=';
        $collation = $this->get_collation();

        if ($casesensitive) {
            $collation = str_replace('_CI', '_CS', $collation);
        } else {
            $collation = str_replace('_CS', '_CI', $collation);
        }
        if ($accentsensitive) {
            $collation = str_replace('_AI', '_AS', $collation);
        } else {
            $collation = str_replace('_AS', '_AI', $collation);
        }

        return "$fieldname COLLATE $collation $equalop $param";
    }

    /**
     * Escape sql LIKE special characters like '_' or '%'.
     * @param string $text The string containing characters needing escaping.
     * @param string $escapechar The desired escape character, defaults to '\\'.
     * @return string The escaped sql LIKE string.
     */
    public function sql_like_escape($text, $escapechar = '\\') {
        // Totara fix for weird [] LIKEs in SQL Server.
        $text = str_replace($escapechar, $escapechar.$escapechar, $text);
        $text = str_replace('_', $escapechar.'_', $text);
        $text = str_replace('%', $escapechar.'%', $text);
        $text = str_replace('[', $escapechar.'[', $text);
        return $text;
    }

    /**
     * Returns 'LIKE' part of a query.
     *
     * @param string $fieldname usually name of the table column
     * @param string $param usually bound query parameter (?, :named)
     * @param bool $casesensitive use case sensitive search
     * @param bool $accensensitive use accent sensitive search (not all databases support accent insensitive)
     * @param bool $notlike true means "NOT LIKE"
     * @param string $escapechar escape char for '%' and '_'
     * @return string SQL code fragment
     */
    public function sql_like($fieldname, $param, $casesensitive = true, $accentsensitive = true, $notlike = false, $escapechar = '\\') {
        if (strpos($param, '%') !== false) {
            debugging('Potential SQL injection detected, sql_like() expects bound parameters (? or :named)');
        }

        $collation = $this->get_collation();
        $LIKE = $notlike ? 'NOT LIKE' : 'LIKE';

        if ($casesensitive) {
            $collation = str_replace('_CI', '_CS', $collation);
        } else {
            $collation = str_replace('_CS', '_CI', $collation);
        }
        if ($accentsensitive) {
            $collation = str_replace('_AI', '_AS', $collation);
        } else {
            $collation = str_replace('_AS', '_AI', $collation);
        }

        return "$fieldname COLLATE $collation $LIKE $param ESCAPE '$escapechar'";
    }

    public function sql_concat() {
        $arr = func_get_args();

        foreach ($arr as $key => $ele) {
            $arr[$key] = ' CAST('.$ele.' AS NVARCHAR(255)) ';
        }
        $s = implode(' + ', $arr);

        if ($s === '') {
            return " '' ";
        }
        return " $s ";
    }

    /**
     * Returns true if group concat supports order by.
     *
     * Not all databases support order by.
     * If it is not supported the when calling sql_group_concat with an order by it will be ignored.
     * You can call this method to check whether the database supports it in order to implement alternative solutions.
     *
     * @since      Totara 12
     * @deprecated since Totara 12 This function will be removed when MSSQL 2017 is the minimum required version. All
     *             other databases support orderby.
     * @return bool
     */
    public function sql_group_concat_orderby_supported() {
        $serverinfo = $this->get_server_info();
        return (version_compare($serverinfo['version'], '14', '>='));
    }

    /**
     * Returns database specific SQL code similar to GROUP_CONCAT() behaviour from MySQL.
     *
     * NOTE: NULL values are skipped, use COALESCE if you want to include a replacement.
     *
     * @since Totara 2.6.34, 2.7.17, 2.9.9
     *
     * @param string $expr      Expression to get individual values
     * @param string $separator The delimiter to separate the values, a simple string value only
     * @param string $orderby   ORDER BY clause that determines order of rows with values,
     *                          optional since Totara 2.6.44, 2.7.27, 2.9.19, 9.7
     * @return string SQL fragment equivalent to GROUP_CONCAT()
     */
    public function sql_group_concat($expr, $separator, $orderby = '') {
        $separator = $this->get_manager()->generator->addslashes($separator);
        // Function string_agg() is supported from SQL Server 2017.
        $serverinfo = $this->get_server_info();
        if (version_compare($serverinfo['version'], '14', '>=')) {
            if ($orderby) {
                $orderby = "WITHIN GROUP (ORDER BY {$orderby})";
            } else {
                $orderby = "";
            }
            return " string_agg(CAST({$expr} AS NVARCHAR(MAX)), '{$separator}') {$orderby} ";
        } else {
            return " dbo.GROUP_CONCAT_D($expr, '{$separator}') ";
        }
    }

    /**
     * Returns database specific SQL code similar to GROUP_CONCAT() behaviour from MySQL
     * where duplicates are removed.
     *
     * NOTE: NULL values are skipped, use COALESCE if you want to include a replacement,
     *       the ordering of results cannot be defined.
     *
     * @since Totara 2.6.44, 2.7.27, 2.9.19, 9.7
     *
     * @param string $expr      Expression to get individual values
     * @param string $separator The delimiter to separate the values, a simple string value only
     * @return string SQL fragment equivalent to GROUP_CONCAT()
     */
    public function sql_group_concat_unique($expr, $separator) {
        $separator = $this->get_manager()->generator->addslashes($separator);
        return " dbo.GROUP_CONCAT_D(DISTINCT $expr, '{$separator}') ";
    }

    public function sql_concat_join($separator = "' '", $elements = array ()) {
        for ($n = count($elements) - 1; $n > 0; $n--) {
            array_splice($elements, $n, 0, $separator);
        }
        return call_user_func_array(array($this, 'sql_concat'), array_values($elements));
    }

    public function sql_isempty($tablename, $fieldname, $nullablefield, $textfield) {
        if ($textfield) {
            return ' ('.$this->sql_compare_text($fieldname)." = '') ";
        } else {
            return " ($fieldname = '') ";
        }
    }

    /**
     * Returns the SQL text to be used to calculate the length in characters of one expression.
     * @param string fieldname or expression to calculate its length in characters.
     * @return string the piece of SQL code to be used in the statement.
     */
    public function sql_length($fieldname) {
        return ' LEN('.$fieldname.')';
    }

    public function sql_order_by_text($fieldname, $numchars = 32) {
        return " CONVERT(varchar({$numchars}), {$fieldname})";
    }

    /**
     * Returns the SQL for returning searching one string for the location of another.
     */
    public function sql_position($needle, $haystack) {
        return "CHARINDEX(($needle), ($haystack))";
    }

    /**
     * Returns the proper substr() SQL text used to extract substrings from DB
     * NOTE: this was originally returning only function name
     *
     * @param string $expr some string field, no aggregates
     * @param mixed $start integer or expression evaluating to int
     * @param mixed $length optional integer or expression evaluating to int
     * @return string sql fragment
     */
    public function sql_substr($expr, $start, $length = false) {
        if (count(func_get_args()) < 2) {
            throw new coding_exception('moodle_database::sql_substr() requires at least two parameters',
                'Originally this function was only returning name of SQL substring function, it now requires all parameters.');
        }

        if ($length === false) {
            return "SUBSTRING($expr, " . $this->sql_cast_char2int($start) . ", 2147483647)";
        } else {
            return "SUBSTRING($expr, " . $this->sql_cast_char2int($start) . ", " . $this->sql_cast_char2int($length) . ")";
        }
    }

    /**
     * Does this driver support tool_replace?
     *
     * @since Moodle 2.6.1
     * @return bool
     */
    public function replace_all_text_supported() {
        return true;
    }

    public function session_lock_supported() {
        return true;
    }

    /**
     * Obtain session lock
     * @param int $rowid id of the row with session record
     * @param int $timeout max allowed time to wait for the lock in seconds
     * @return void
     */
    public function get_session_lock($rowid, $timeout) {
        if (!$this->session_lock_supported()) {
            return;
        }
        parent::get_session_lock($rowid, $timeout);

        $timeoutmilli = $timeout * 1000;

        $fullname = $this->dbname.'-'.$this->prefix.'-session-'.$rowid;
        // While this may work using proper {call sp_...} calls + binding +
        // executing + consuming recordsets, the solution used for the mssql
        // driver is working perfectly, so 100% mimic-ing that code.
        // $sql = "sp_getapplock '$fullname', 'Exclusive', 'Session',  $timeoutmilli";
        $sql = "BEGIN
                    DECLARE @result INT
                    EXECUTE @result = sp_getapplock @Resource='$fullname',
                                                    @LockMode='Exclusive',
                                                    @LockOwner='Session',
                                                    @LockTimeout='$timeoutmilli'
                    SELECT @result
                END";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);

        if ($result) {
            $row = sqlsrv_fetch_array($result);
            if ($row[0] < 0) {
                throw new dml_sessionwait_exception();
            }
        }

        $this->free_result($result);
    }

    public function release_session_lock($rowid) {
        if (!$this->session_lock_supported()) {
            return;
        }
        if (!$this->used_for_db_sessions) {
            return;
        }

        parent::release_session_lock($rowid);

        $fullname = $this->dbname.'-'.$this->prefix.'-session-'.$rowid;
        $sql = "sp_releaseapplock '$fullname', 'Session'";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);
        $this->free_result($result);
    }

    /**
     * Driver specific start of real database transaction,
     * this can not be used directly in code.
     * @return void
     */
    protected function begin_transaction() {
        $this->query_start('native sqlsrv_begin_transaction', NULL, SQL_QUERY_AUX);
        $result = sqlsrv_begin_transaction($this->sqlsrv);
        $this->query_end($result);
    }

    /**
     * Driver specific commit of real database transaction,
     * this can not be used directly in code.
     * @return void
     */
    protected function commit_transaction() {
        $this->query_start('native sqlsrv_commit', NULL, SQL_QUERY_AUX);
        $result = sqlsrv_commit($this->sqlsrv);
        $this->query_end($result);
    }

    /**
     * Driver specific abort of real database transaction,
     * this can not be used directly in code.
     * @return void
     */
    protected function rollback_transaction() {
        $this->query_start('native sqlsrv_rollback', null, SQL_QUERY_AUX);
        $result = sqlsrv_rollback($this->sqlsrv);
        $this->query_end($result);
    }

    /**
     * Creates new database savepoint.
     * @param string $name
     */
    protected function create_savepoint(string $name) {
        $sql = "SAVE TRANSACTION {$name}";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);
    }

    /**
     * Release savepoint, rollback will not be possible any more.
     * @param string $name
     */
    protected function release_savepoint(string $name) {
        // nothing to do
    }

    /**
     * Rolls back current transaction back to given savepoint.
     * @param string $name
     */
    protected function rollback_savepoint(string $name) {
        $sql = "ROLLBACK TRANSACTION {$name}";
        $this->query_start($sql, null, SQL_QUERY_AUX);
        $result = sqlsrv_query($this->sqlsrv, $sql);
        $this->query_end($result);
    }

    /**
     * Do not use.
     *
     * @deprecated
     *
     * @param string|sql $sql the SQL select query to execute.
     * @param array $params array of sql parameters (optional)
     * @param int $limitfrom return a subset of records, starting at this point (optional).
     * @param int $limitnum return a subset comprising this many records (optional, required if $limitfrom is set).
     * @param int &$count this variable will be filled with count of rows returned by select without limit statement
     * @return counted_recordset A moodle_recordset instance.
     * @throws dml_exception A DML specific exception is thrown for any errors.
     * @throws coding_exception If an invalid result not containing the count is experienced
     */
    public function get_counted_recordset_sql($sql, array $params=null, $limitfrom = 0, $limitnum = 0, &$count = 0) {
        global $CFG;
        require_once($CFG->libdir.'/dml/counted_recordset.php');

        debugging('Counted recordsets are deprecated, use two separate queries instead.', DEBUG_DEVELOPER);

        if ($sql instanceof sql) {
            if (!empty($params)) {
                debugging('$params parameter is ignored when sql instance supplied', DEBUG_DEVELOPER);
            }
            $params = $sql->get_params();
            $sql = $sql->get_sql();
        }

        if (!preg_match('/^\s*SELECT\s/is', $sql)) {
            throw new dml_exception('dmlcountedrecordseterror', null, "Counted recordset query must start with SELECT");
        }

        $countorfield = 'dml_count_recordset_rows';
        $sqlcnt = preg_replace('/^\s*SELECT\s/is', "SELECT COUNT('x') OVER () AS {$countorfield}, ", $sql);

        $recordset = $this->get_recordset_sql($sqlcnt, $params, $limitfrom, $limitnum);
        if ($limitfrom > 0 and !$recordset->valid()) {
            // Bad luck, we are out of range and do not know how many are there, we need to make another query.
            $rs2 = $this->get_recordset_sql($sqlcnt, $params, 0, 1);
            if ($rs2->valid()) {
                $current = $rs2->current();
                $rs2->close();
                if (!property_exists($current, $countorfield)) {
                    throw new dml_exception("Expected column {$countorfield} used for counting records without limit was not found");
                } else if (!isset($current->{$countorfield})) {
                    throw new coding_exception("Invalid count result in {$countorfield} used for counting records without limit");
                }
                $recordset = new counted_recordset($recordset, (int)$current->{$countorfield});
                $count = $recordset->get_count_without_limits();
                return $recordset;
            }
            $rs2->close();
        }
        $recordset = new counted_recordset($recordset, $countorfield);
        $count = $recordset->get_count_without_limits();

        return $recordset;
    }

    /**
     * Build a natural language search subquery using database specific search functions.
     *
     * @since Totara 12
     *
     * @param string $table        database table name
     * @param array  $searchfields ['field_name'=>weight, ...] eg: ['high'=>3, 'medium'=>2, 'low'=>1]
     * @param string $searchtext   natural language search text
     * @return array [sql, params[]]
     */
    protected function build_fts_subquery(string $table, array $searchfields, string $searchtext): array {
        $language = $this->get_ftslanguage();
        // Microsoft is using either language code numbers or names of languages.
        if (is_number($language)) {
            $language = intval($language);
        } else {
            $language = "'$language'";
        }

        $params = array();
        $searchjoin = array();
        $score = array();

        $defaulttb = 'FREETEXTTABLE';
        if ($this->get_fts_mode($searchtext) === self::SEARCH_MODE_BOOLEAN) {
            $searchtext = "\"{$searchtext}\"";
            $defaulttb = "CONTAINSTABLE";
        }

        foreach ($searchfields as $field => $weight) {
            $paramname = $this->get_unique_param('fts');
            $params[$paramname] = $searchtext;
            $searchjoin[] = "LEFT JOIN {$defaulttb}({{$table}},{$field},:{$paramname},LANGUAGE $language) AS join_{$field} ON basesearch.id = join_{$field}.[KEY]";
            $score[] = "COALESCE(join_{$field}.RANK,0)*{$weight}";
        }

        $searchjoins = implode("\n", $searchjoin);
        $scoresum = implode(' + ', $score);
        $sql = "SELECT basesearch.id, {$scoresum} AS score
                  FROM {{$table}} basesearch
                       {$searchjoins}
                 WHERE {$scoresum} > 0";

        return array("({$sql})", $params);
    }

    /**
     * Wait for MS SQL Server to index table with full text search data.
     *
     * NOTE: this is intended mainly for testing purposes
     *
     * @param string $tablename
     * @param int $maxtime
     * @return bool success, false if not indexed in $maxtime
     */
    public function fts_wait_for_indexing(string $tablename, int $maxtime = 10) {
        $prefix = $this->get_prefix();

        $timestart = time();

        $sql = "SELECT COUNT('x')
                  FROM sys.fulltext_indexes i
                  JOIN sys.fulltext_catalogs c ON (c.name = :catalog AND i.fulltext_catalog_id = c.fulltext_catalog_id)
                  JOIN sys.tables t ON i.object_id = t.object_id
                 WHERE t.name = :table AND i.has_crawl_completed = 0";
        $params = array('catalog' => $prefix . 'search_catalog', 'table' => $prefix . $tablename);

        while($this->count_records_sql($sql, $params)) {
            if ($timestart + $maxtime < time()) {
                return false;
            }
            sleep(1);
        }

        return true;
    }

    /**
     * Check if accent sensitivity is currently active or not.
     *
     * @since Totara 12
     * @return bool
     */
    public function is_fts_accent_sensitive(): bool {
        $sql = "SELECT fulltextcatalogproperty(:catalog, 'AccentSensitivity')";
        $params = ['catalog' => $this->get_prefix() . 'search_catalog'];
        return !empty($this->get_field_sql($sql, $params));
    }
}
