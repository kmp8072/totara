<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
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
 * Behat basic functions
 *
 * It does not include MOODLE_INTERNAL because is part of the bootstrap.
 *
 * This script should not be usually included, neither any of its functions
 * used, within mooodle code at all. It's for exclusive use of behat and
 * moodle setup.php. For places requiring a different/special behavior
 * needing to check if are being run as part of behat tests, use:
 *     if (defined('BEHAT_SITE_RUNNING')) { ...
 *
 * @package    core
 * @category   test
 * @copyright  2012 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../testing/lib.php');

define('BEHAT_EXITCODE_CONFIG', 250);
define('BEHAT_EXITCODE_REQUIREMENT', 251);
define('BEHAT_EXITCODE_PERMISSIONS', 252);
define('BEHAT_EXITCODE_REINSTALL', 253);
define('BEHAT_EXITCODE_INSTALL', 254);
define('BEHAT_EXITCODE_INSTALLED', 256);

/**
 * The behat test site fullname and shortname.
 */
define('BEHAT_PARALLEL_SITE_NAME', "behatrun");

/**
 * Exits with an error code
 *
 * @param  mixed $errorcode
 * @param  string $text
 * @return void Stops execution with error code
 */
function behat_error($errorcode, $text = '') {

    // Adding error prefixes.
    switch ($errorcode) {
        case BEHAT_EXITCODE_CONFIG:
            $text = 'Behat config error: ' . $text;
            break;
        case BEHAT_EXITCODE_REQUIREMENT:
            $text = 'Behat requirement not satisfied: ' . $text;
            break;
        case BEHAT_EXITCODE_PERMISSIONS:
            $text = 'Behat permissions problem: ' . $text . ', check the permissions';
            break;
        case BEHAT_EXITCODE_REINSTALL:
            $path = testing_cli_argument_path('/admin/tool/behat/cli/init.php');
            $text = "Reinstall Behat: ".$text.", use:\n php ".$path;
            break;
        case BEHAT_EXITCODE_INSTALL:
            $path = testing_cli_argument_path('/admin/tool/behat/cli/init.php');
            $text = "Install Behat before enabling it, use:\n php ".$path;
            break;
        case BEHAT_EXITCODE_INSTALLED:
            $text = "The Behat site is already installed";
            break;
        default:
            $text = 'Unknown error ' . $errorcode . ' ' . $text;
            break;
    }

    testing_error($errorcode, $text);
}

/**
 * Return logical error string.
 *
 * @param int $errtype php error type.
 * @return string string which will be returned.
 */
function behat_get_error_string($errtype) {
    switch ($errtype) {
        case E_USER_ERROR:
            $errnostr = 'Fatal error';
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $errnostr = 'Warning';
            break;
        case E_NOTICE:
        case E_USER_NOTICE:
        case E_STRICT:
            $errnostr = 'Notice';
            break;
        case E_RECOVERABLE_ERROR:
            $errnostr = 'Catchable';
            break;
        default:
            $errnostr = 'Unknown error type';
    }

    return $errnostr;
}

/**
 * Before shutdown save last error entries, so we can fail the test.
 */
function behat_shutdown_function() {
    // If any error found, then save it.
    if ($error = error_get_last()) {
        // Ignore E_WARNING, as they might come via ( @ )suppression and might lead to false failure.
        if (isset($error['type']) && !($error['type'] & E_WARNING)) {

            $errors = behat_get_shutdown_process_errors();

            $errors[] = $error;
            $errorstosave = json_encode($errors);

            set_config('process_errors', $errorstosave, 'tool_behat');
        }
    }
}

/**
 * Return php errors save which were save during shutdown.
 *
 * @return array
 */
function behat_get_shutdown_process_errors() {
    global $DB;

    // Don't use get_config, as it use cache and return invalid value, between selenium and cli process.
    $phperrors = $DB->get_field('config_plugins', 'value', array('name' => 'process_errors', 'plugin' => 'tool_behat'));

    if (!empty($phperrors)) {
        return json_decode($phperrors, true);
    } else {
        return array();
    }
}

/**
 * Restrict the config.php settings allowed.
 *
 * When running the behat features the config.php
 * settings should not affect the results.
 *
 * @return void
 */
function behat_clean_init_config(\stdClass $cfg) {
    $allowed = array_flip(array(
        'wwwroot', 'dataroot', 'dirroot', 'srcroot', 'admin', 'directorypermissions', 'filepermissions',
        'umaskpermissions', 'dbtype', 'dblibrary', 'dbhost', 'dbname', 'dbuser', 'dbpass', 'prefix',
        'dboptions', 'proxyhost', 'proxyport', 'proxytype', 'proxyuser', 'proxypassword',
        'proxybypass', 'theme', 'pathtogs', 'pathtodu', 'aspellpath', 'pathtodot', 'skiplangupgrade',
        'altcacheconfigpath', 'pathtounoconv'
    ));

    // Add extra allowed settings.
    if (!empty($cfg->behat_extraallowedsettings)) {
        $allowed = array_merge($allowed, array_flip($cfg->behat_extraallowedsettings));
    }

    // Also allowing behat_ prefixed attributes.
    foreach ($cfg as $key => $value) {
        if (!isset($allowed[$key]) && strpos($key, 'behat_') !== 0) {
            unset($cfg->{$key});
        }
    }
}

/**
 * Checks that the behat config vars are properly set.
 *
 * @return void Stops execution with error code if something goes wrong.
 */
function behat_check_config_vars(\stdClass $cfg) {
    // Verify prefix value.
    if (empty($cfg->behat_prefix)) {
        behat_error(BEHAT_EXITCODE_CONFIG,
            'Define $cfg->behat_prefix in config.php');
    }
    if (!empty($cfg->prefix) and $cfg->behat_prefix == $cfg->prefix) {
        behat_error(BEHAT_EXITCODE_CONFIG,
            '$cfg->behat_prefix in config.php must be different from $cfg->prefix');
    }
    if (!empty($cfg->phpunit_prefix) and $cfg->behat_prefix == $cfg->phpunit_prefix) {
        behat_error(BEHAT_EXITCODE_CONFIG,
            '$cfg->behat_prefix in config.php must be different from $cfg->phpunit_prefix');
    }

    // Verify behat wwwroot value.
    if (empty($cfg->behat_wwwroot)) {
        behat_error(BEHAT_EXITCODE_CONFIG,
            'Define $cfg->behat_wwwroot in config.php');
    }
    if (!empty($cfg->wwwroot) and $cfg->behat_wwwroot == $cfg->wwwroot) {
        behat_error(BEHAT_EXITCODE_CONFIG,
            '$cfg->behat_wwwroot in config.php must be different from $cfg->wwwroot');
    }

    // Verify behat dataroot value.
    if (empty($cfg->behat_dataroot)) {
        behat_error(BEHAT_EXITCODE_CONFIG,
            'Define $cfg->behat_dataroot in config.php');
    }
    clearstatcache();
    if (!file_exists($cfg->behat_dataroot_parent)) {
        $permissions = isset($cfg->directorypermissions) ? $cfg->directorypermissions : 02777;
        umask(0);
        if (!mkdir($cfg->behat_dataroot_parent, $permissions, true)) {
            behat_error(BEHAT_EXITCODE_PERMISSIONS, '$cfg->behat_dataroot directory can not be created');
        }
    }
    $cfg->behat_dataroot_parent = realpath($cfg->behat_dataroot_parent);
    if (empty($cfg->behat_dataroot_parent) or !is_dir($cfg->behat_dataroot_parent) or !is_writable($cfg->behat_dataroot_parent)) {
        behat_error(BEHAT_EXITCODE_CONFIG,
            '$cfg->behat_dataroot in config.php must point to an existing writable directory');
    }
    if (!empty($cfg->dataroot) and $cfg->behat_dataroot_parent == realpath($cfg->dataroot)) {
        behat_error(BEHAT_EXITCODE_CONFIG,
            '$cfg->behat_dataroot in config.php must be different from $cfg->dataroot');
    }
    if (!empty($cfg->phpunit_dataroot) and $cfg->behat_dataroot_parent == realpath($cfg->phpunit_dataroot)) {
        behat_error(BEHAT_EXITCODE_CONFIG,
            '$cfg->behat_dataroot in config.php must be different from $cfg->phpunit_dataroot');
    }

    // This request is coming from admin/tool/behat/cli/util.php which will call util_single.php. So just return from
    // here as we don't need to create a dataroot for single run.
    if (defined('BEHAT_PARALLEL_UTIL') && BEHAT_PARALLEL_UTIL && empty($cfg->behatrunprocess)) {
        return;
    }

    if (!file_exists($cfg->behat_dataroot)) {
        $permissions = isset($cfg->directorypermissions) ? $cfg->directorypermissions : 02777;
        umask(0);
        if (!mkdir($cfg->behat_dataroot, $permissions, true)) {
            behat_error(BEHAT_EXITCODE_PERMISSIONS, '$cfg->behat_dataroot directory can not be created');
        }
    }
    $cfg->behat_dataroot = realpath($cfg->behat_dataroot);
}

/**
 * Should we switch to the test site data?
 * @return bool
 */
function behat_is_test_site(\stdClass $cfg) {
    if (defined('BEHAT_UTIL')) {
        // This is the admin tool that installs/drops the test site install.
        return true;
    }
    if (defined('BEHAT_TEST')) {
        // This is the main vendor/bin/behat script.
        return true;
    }
    if (empty($cfg->behat_wwwroot)) {
        return false;
    }
    if (isset($_SERVER['REMOTE_ADDR']) and behat_is_requested_url($cfg->behat_wwwroot)) {
        if (!empty($_COOKIE['BEHAT'])) {
            // Totara: Something is accessing the web server with BEHAT cookie like a real browser.
            return true;
        }
    }

    return false;
}

/**
 * Fix variables for parallel behat testing.
 * - behat_wwwroot = behat_wwwroot{behatrunprocess}
 * - behat_dataroot = behat_dataroot{behatrunprocess}
 * - behat_prefix = behat_prefix.{behatrunprocess}_ (For oracle it will be firstletter of prefix and behatrunprocess)
 **/
function behat_update_vars_for_process(\stdClass $cfg) {
    $allowedconfigoverride = array('dbtype', 'dblibrary', 'dbhost', 'dbname', 'dbuser', 'dbpass', 'behat_prefix',
        'behat_wwwroot', 'behat_dataroot');
    $behatrunprocess = behat_get_run_process($cfg);
    $cfg->behatrunprocess = $behatrunprocess;

    // Data directory will be a directory under parent directory.
    $cfg->behat_dataroot_parent = $cfg->behat_dataroot;
    $cfg->behat_dataroot .= '/'. BEHAT_PARALLEL_SITE_NAME;
    if ($behatrunprocess) {
        if (empty($cfg->behat_parallel_run[$behatrunprocess - 1]['behat_wwwroot'])) {
            // Set www root for run process.
            if (isset($cfg->behat_wwwroot) &&
                !preg_match("#/" . BEHAT_PARALLEL_SITE_NAME . $behatrunprocess . "\$#", $cfg->behat_wwwroot)) {
                $cfg->behat_wwwroot .= "/" . BEHAT_PARALLEL_SITE_NAME . $behatrunprocess;
            }
        }

        if (empty($cfg->behat_parallel_run[$behatrunprocess - 1]['behat_dataroot'])) {
            // Set behat_dataroot.
            if (!preg_match("#" . $behatrunprocess . "\$#", $cfg->behat_dataroot)) {
                $cfg->behat_dataroot .= $behatrunprocess;
            }
        }

        // Set behat_prefix for db, just suffix run process number, to avoid max length exceed.
        // For oracle only 2 letter prefix is possible.
        // NOTE: This will not work for parallel process > 9.
        if ($cfg->dbtype === 'oci') {
            $cfg->behat_prefix = substr($cfg->behat_prefix, 0, 1);
            $cfg->behat_prefix .= "{$behatrunprocess}";
        } else {
            $cfg->behat_prefix .= "{$behatrunprocess}_";
        }

        if (!empty($cfg->behat_parallel_run[$behatrunprocess - 1])) {
            // Override allowed config vars.
            foreach ($allowedconfigoverride as $config) {
                if (isset($cfg->behat_parallel_run[$behatrunprocess - 1][$config])) {
                    $cfg->$config = $cfg->behat_parallel_run[$behatrunprocess - 1][$config];
                }
            }
        }
    }
}

/**
 * Checks if the URL requested by the user matches the provided argument
 *
 * @param string $url
 * @return bool Returns true if it matches.
 */
function behat_is_requested_url($url) {

    $parsedurl = parse_url($url . '/');
    $parsedurl['port'] = isset($parsedurl['port']) ? $parsedurl['port'] : 80;
    $parsedurl['path'] = rtrim($parsedurl['path'], '/');

    // Removing the port.
    $pos = strpos($_SERVER['HTTP_HOST'], ':');
    if ($pos !== false) {
        $requestedhost = substr($_SERVER['HTTP_HOST'], 0, $pos);
    } else {
        $requestedhost = $_SERVER['HTTP_HOST'];
    }

    // The path should also match.
    if (empty($parsedurl['path'])) {
        $matchespath = true;
    } else if (strpos($_SERVER['SCRIPT_NAME'], $parsedurl['path']) === 0) {
        $matchespath = true;
    }

    // The host and the port should match
    if ($parsedurl['host'] == $requestedhost && $parsedurl['port'] == $_SERVER['SERVER_PORT'] && !empty($matchespath)) {
        return true;
    }

    return false;
}

/**
 * Get behat run process from either $_SERVER or command config.
 *
 * @return bool|int false if single run, else run process number.
 */
function behat_get_run_process(\stdClass $cfg) {
    global $argv;
    $behatrunprocess = false;

    // Get behat run process, if set.
    if (defined('BEHAT_CURRENT_RUN') && BEHAT_CURRENT_RUN) {
        $behatrunprocess = BEHAT_CURRENT_RUN;
    } else if (!empty($_SERVER['REMOTE_ADDR'])) {
        // Try get it from config if present.
        if (!empty($cfg->behat_parallel_run)) {
            foreach ($cfg->behat_parallel_run as $run => $behatconfig) {
                if (isset($behatconfig['behat_wwwroot']) && behat_is_requested_url($behatconfig['behat_wwwroot'])) {
                    $behatrunprocess = $run + 1; // We start process from 1.
                    break;
                }
            }
        }
        // Check if parallel site prefix is used.
        if (empty($behatrunprocess) && preg_match('#/' . BEHAT_PARALLEL_SITE_NAME . '(.+?)/#', $_SERVER['REQUEST_URI'])) {
            $dirrootrealpath = str_replace("\\", "/", realpath(__DIR__ . '/../../'));
            $serverrealpath = str_replace("\\", "/", realpath($_SERVER['SCRIPT_FILENAME']));
            $afterpath = str_replace($dirrootrealpath.'/', '', $serverrealpath);
            // Totara: replace backslash with slash for Windows
            $scriptfilename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);
            if (!$behatrunprocess = preg_filter("#.*/" . BEHAT_PARALLEL_SITE_NAME . "(.+?)/$afterpath#", '$1',
                $scriptfilename)) {
                throw new Exception("Unable to determine behat process [afterpath=" . $afterpath .
                    ", scriptfilename=" . $scriptfilename . "]!");
            }
        }
    } else if (defined('BEHAT_TEST') || defined('BEHAT_UTIL')) {
        if ($match = preg_filter('#--run=(.+)#', '$1', $argv)) {
            $behatrunprocess = reset($match);
        } else if ($k = array_search('--config', $argv)) {
            $behatconfig = str_replace("\\", "/", $argv[$k + 1]);
            // Try get it from config if present.
            if (!empty($cfg->behat_parallel_run)) {
                foreach ($cfg->behat_parallel_run as $run => $parallelconfig) {
                    if (!empty($parallelconfig['behat_dataroot']) &&
                        $parallelconfig['behat_dataroot'] . '/behat/behat.yml' == $behatconfig) {

                        $behatrunprocess = $run + 1; // We start process from 1.
                        break;
                    }
                }
            }
            // Check if default behat datroot increment was done.
            if (empty($behatrunprocess)) {
                $behatdataroot = str_replace("\\", "/", $cfg->behat_dataroot . '/' . BEHAT_PARALLEL_SITE_NAME);
                $behatrunprocess = preg_filter("#^{$behatdataroot}" . "(.+?)[/|\\\]behat[/|\\\]behat\.yml#", '$1',
                    $behatconfig);
            }
        }
    }

    return $behatrunprocess;
}

/**
 * Execute commands in parallel.
 *
 * @param array $cmds list of commands to be executed.
 * @param string $cwd absolute path of working directory.
 * @param int $delay time in seconds to add delay between each parallel process.
 * @return array list of processes.
 */
function cli_execute_parallel($cmds, $cwd = null, $delay = 0) {

    if (defined('TOOL_BEHAT_DIR_VENDOR')) {
        require_once(TOOL_BEHAT_DIR_VENDOR . "/autoload.php");
    } else {
        // Guess it.
        require_once(__DIR__ . "/../../../vendor/autoload.php");
    }


    $processes = array();

    // Create child process.
    foreach ($cmds as $name => $cmd) {
        $process = new Symfony\Component\Process\Process($cmd);

        $process->setWorkingDirectory($cwd);
        $process->setTimeout(null);
        $processes[$name] = $process;
        $processes[$name]->start();

        // If error creating process then exit.
        if ($processes[$name]->getStatus() !== 'started') {
            echo "Error starting process: $name";
            foreach ($processes[$name] as $process) {
                if ($process) {
                    $process->signal(SIGKILL);
                }
            }
            exit(1);
        }

        // Sleep for specified delay.
        if ($delay) {
            sleep($delay);
        }
    }
    return $processes;
}
