<?php
/*
  Copyright 2011-17  snapcreek.com

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 3, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  GPL v3 https://www.gnu.org/licenses/gpl-3.0.en.html
 */

if (file_exists('dtoken.php')) {
    //This is most likely inside the snapshot folder.
    
    //DOWNLOAD ONLY: (Only enable download from within the snapshot directory)
    if (isset($_GET['get']) && isset($_GET['file'])) {
        //Clean the input, strip out anything not alpha-numeric or "_.", so restricts
        //only downloading files in same folder, and removes risk of allowing directory
        //separators in other charsets (vulnerability in older IIS servers), also
        //strips out anything that might cause it to use an alternate stream since
        //that would require :// near the front.
    	$filename = preg_replace('/[^a-zA-Z0-9_.]*/','',$_GET['file']);
    	if (strlen($filename) && file_exists($filename) && (strstr($filename, '_installer.php'))) {
            //Attempt to push the file to the browser
    	    header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=installer.php');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            @ob_clean();
            @flush();
            if (@readfile($filename) == false) {
                $data = file_get_contents($filename);
                if ($data == false) {
                    die("Unable to read installer file.  The server currently has readfile and file_get_contents disabled on this server.  Please contact your server admin to remove this restriction");
                } else {
                    print $data;
                }
            }
        } else {
            header("HTTP/1.1 404 Not Found", true, 404);
            header("Status: 404 Not Found");
        }
    }
	//Prevent Access from rovers or direct browsing in snapshop directory, or when
    //requesting to download a file, should not go past this point.
    exit;
}

/* ==============================================================================================
ADVANCED FEATURES - Allows admins to perform aditional logic on the import.

$GLOBALS['REPLACE_LIST']
	Add additional search and replace items to step 2 for the serialize engine.  
	Place directly below $GLOBALS['REPLACE_LIST'] variable below your items
	EXAMPLE:
		array_push($GLOBALS['REPLACE_LIST'], array('search' => 'https://oldurl/',  'replace' => 'https://newurl/'));
		array_push($GLOBALS['REPLACE_LIST'], array('search' => 'ftps://oldurl/',   'replace' => 'ftps://newurl/'));
  ================================================================================================= */

// Some machines don’t have this set so just do it here.
date_default_timezone_set('UTC');

//PATCH FOR IIS:  Does not support REQUEST_URI
if (!isset($_SERVER['REQUEST_URI']))  {
	$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],0);
	if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != "") {
		$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
	}
}

//COMPARE VALUES
$GLOBALS['DUPX_DEBUG']			= false;
$GLOBALS['DUPX_DBPASS_CHECK']	= true;
$GLOBALS['FW_CREATED']			= '2018-09-06 05:24:51';
$GLOBALS['FW_VERSION_DUP']		= '1.2.42';
$GLOBALS['FW_VERSION_WP']		= '4.9.8';
$GLOBALS['FW_VERSION_DB']		= '5.7.22';
$GLOBALS['FW_VERSION_PHP']		= '5.6.37';
$GLOBALS['FW_VERSION_OS']		= 'Linux';
//GENERAL
$GLOBALS['FW_TABLEPREFIX']		= 'am_';
$GLOBALS['FW_URL_OLD']			= 'http://efengy.com/amigo';
$GLOBALS['FW_PACKAGE_NAME']		= '20180906_amigosystem_14479840ecce64395632180906052451_archive.zip';
$GLOBALS['FW_PACKAGE_NOTES']	= '';
$GLOBALS['FW_PACKAGE_EST_SIZE']	= 18826644;
$GLOBALS['FW_SECURE_NAME']		= '20180906_amigosystem_14479840ecce64395632180906052451';
$GLOBALS['FW_DBHOST']			= '';
$GLOBALS['FW_DBHOST']			= empty($GLOBALS['FW_DBHOST']) ? 'localhost' : $GLOBALS['FW_DBHOST'];
$GLOBALS['FW_DBPORT']			= '';
$GLOBALS['FW_DBPORT']			= empty($GLOBALS['FW_DBPORT']) ? 3306 : $GLOBALS['FW_DBPORT'];
$GLOBALS['FW_DBNAME']			= '';
$GLOBALS['FW_DBUSER']			= '';
$GLOBALS['FW_DBPASS']			= '';
$GLOBALS['FW_SECUREON']			= 0;
$GLOBALS['FW_SECUREPASS']		= '$2a$08$d.FXfZAPB3Wy2SsHZEV3juFokck3BvwEqcPIerH//5jo0mB2QqLHC';
$GLOBALS['FW_BLOGNAME']			= 'Amigo System';
$GLOBALS['FW_WPROOT']			= '/home/efengyco/public_html/amigo/';
$GLOBALS['FW_WPLOGIN_URL']		= 'http://efengy.com/amigo/wp-login.php';
$GLOBALS['FW_OPTS_DELETE']		= json_decode('["duplicator_ui_view_state","duplicator_package_active","duplicator_settings"]', true);
$GLOBALS['FW_DUPLICATOR_VERSION'] = '1.2.42';
$GLOBALS['FW_ARCHIVE_ONLYDB']	= 0;

//DATABASE SETUP: all time in seconds	
$GLOBALS['DB_MAX_TIME']		= 5000;
$GLOBALS['DB_MAX_PACKETS']	= 268435456;
$GLOBALS['DB_FCGI_FLUSH']	= false;
ini_set('mysql.connect_timeout', '5000');

//PHP SETUP: all time in seconds
ini_set('memory_limit', '2048M');
ini_set("max_execution_time", '5000');
ini_set("max_input_time", '5000');
ini_set('default_socket_timeout', '5000');
@set_time_limit(0);

$GLOBALS['DBCHARSET_DEFAULT'] = 'utf8';
$GLOBALS['DBCOLLATE_DEFAULT'] = 'utf8_general_ci';
$GLOBALS['FAQ_URL'] = 'https://snapcreek.com/duplicator/docs/faqs-tech';
$GLOBALS['NOW_DATE'] = @date("Y-m-d-H:i:s");
$GLOBALS['DB_RENAME_PREFIX'] = 'x-bak__';

//UPDATE TABLE SETTINGS
$GLOBALS['REPLACE_LIST'] = array();


/** ================================================================================================
  END ADVANCED FEATURES: Do not edit below here.
  =================================================================================================== */

//CONSTANTS
define("DUPLICATOR_INIT", 1); 
define("DUPLICATOR_SSDIR_NAME", 'wp-snapshots');  //This should match DUPLICATOR_SSDIR_NAME in duplicator.php

//SHARED POST PARMS
$_POST['action_step'] = isset($_POST['action_step']) ? $_POST['action_step'] : "0";
$_POST['secure-pass'] = isset($_POST['secure-pass']) ? $_POST['secure-pass'] : '';

if ($GLOBALS['FW_SECUREON']) {
	$pass_hasher = new DUPX_PasswordHash(8, FALSE);
	$pass_check  = $pass_hasher->CheckPassword(base64_encode($_POST['secure-pass']), $GLOBALS['FW_SECUREPASS']);
	if (! $pass_check) {
		$_POST['action_step'] = 0;
	}
}

/** Host has several combinations :
localhost | localhost:55 | localhost: | http://localhost | http://localhost:55 */
$_POST['dbhost']	= isset($_POST['dbhost']) ? trim($_POST['dbhost']) : null;
$_POST['dbport']    = isset($_POST['dbport']) ? trim($_POST['dbport']) : 3306;
$_POST['dbuser']	= isset($_POST['dbuser']) ? trim($_POST['dbuser']) : null;
$_POST['dbpass']	= isset($_POST['dbpass']) ? trim($_POST['dbpass']) : null;
$_POST['dbname']	= isset($_POST['dbname']) ? trim($_POST['dbname']) : null;
$_POST['dbcharset'] = isset($_POST['dbcharset'])  ? trim($_POST['dbcharset']) : $GLOBALS['DBCHARSET_DEFAULT'];
$_POST['dbcollate'] = isset($_POST['dbcollate'])  ? trim($_POST['dbcollate']) : $GLOBALS['DBCOLLATE_DEFAULT'];

//GLOBALS
$GLOBALS['SQL_FILE_NAME']       = "installer-data.sql";
$GLOBALS['LOG_FILE_NAME']       = "installer-log.txt";
$GLOBALS['LOGGING']             = isset($_POST['logging']) ? $_POST['logging'] : 1;
$GLOBALS['CURRENT_ROOT_PATH']   = dirname(__FILE__);
$GLOBALS['CHOWN_ROOT_PATH']     = @chmod("{$GLOBALS['CURRENT_ROOT_PATH']}", 0755);
$GLOBALS['CHOWN_LOG_PATH']      = @chmod("{$GLOBALS['CURRENT_ROOT_PATH']}/{$GLOBALS['LOG_FILE_NAME']}", 0644);
$GLOBALS['URL_SSL']             = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on') ? true : false;
$GLOBALS['URL_PATH']            = ($GLOBALS['URL_SSL']) ? "https://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}" : "http://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}";
$GLOBALS['PHP_MEMORY_LIMIT']    = ini_get('memory_limit') === false ? 'n/a' : ini_get('memory_limit');
$GLOBALS['PHP_SUHOSIN_ON']      = extension_loaded('suhosin') ? 'enabled' : 'disabled';
$GLOBALS['ARCHIVE_PATH']        = $GLOBALS['CURRENT_ROOT_PATH'] . '/' . $GLOBALS['FW_PACKAGE_NAME'];
$GLOBALS['ARCHIVE_PATH']        = str_replace("\\", "/", $GLOBALS['ARCHIVE_PATH']);

//Restart log if user starts from step 1
if ($_POST['action_step'] == 1 && ! isset($_GET['help'])) {
    $GLOBALS['LOG_FILE_HANDLE'] = @fopen($GLOBALS['LOG_FILE_NAME'], "w+");
} else {
    $GLOBALS['LOG_FILE_HANDLE'] = @fopen($GLOBALS['LOG_FILE_NAME'], "a+");
}
?>
<?php
/**
 * Various Static Utility methods for working with the installer
 *
 * Standard: PSR-2
 * @link http://www.php-fig.org/psr/psr-2 Full Documentation
 *
 * @package SC\DUPX\U
 *
 */
class DUPX_U
{
    /**
     * Adds a slash to the end of a file or directory path
     *
     * @param string $path		A path
     *
     * @return string The original $path with a with '/' added to the end.
     */
    public static function addSlash($path)
    {
        $last_char = substr($path, strlen($path) - 1, 1);
        if ($last_char != '/') {
            $path .= '/';
        }
        return $path;
    }

    /**
     * Return a string with the elapsed time
     *
     * @see getMicrotime()
     *
     * @param mixed number $end     The final time in the sequence to measure
     * @param mixed number $start   The start time in the sequence to measure
     *
     * @return  string   The time elapsed from $start to $end
     */
    public static function elapsedTime($end, $start)
    {
        return sprintf("%.4f sec.", abs($end - $start));
    }

    /**
     * Convert all applicable characters to HTML entities
     *
     * @param string $string    String that needs conversion
     * @param bool $echo        Echo or return as a variable
     *
     * @return string    Escaped string.
     */
    public static function escapeHTML($string = '', $echo = false)
    {
        $output = htmlentities($string, ENT_QUOTES, 'UTF-8');
        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
    }

    /**
     *  Returns 256 spaces
     *
     *  PHP_SAPI for fcgi requires a data flush of at least 256
     *  bytes every 40 seconds or else it forces a script halt
     *
     * @return string A series of 256 spaces ' '
     */
    public static function fcgiFlush()
    {
        echo(str_repeat(' ', 256));
        @flush();
    }

    /**
     * Get current microtime as a float.  Method is used for simple profiling
     *
     * @see elapsedTime
     *
     * @return  string   A float in the form "msec sec", where sec is the number of seconds since the Unix epoch
     */
    public static function getMicrotime()
    {
        return microtime(true);
    }

    /** 
     *  Returns the active plugins for the WordPress website in the package
     *
     *  @param  obj    $dbh	 A database connection handle
	 *
     *  @return array  $list A list of active plugins
     */
    public static function getActivePlugins($dbh)
    {
        $query = @mysqli_query($dbh, "SELECT option_value FROM `{$GLOBALS['FW_TABLEPREFIX']}options` WHERE option_name = 'active_plugins' ");
        if ($query) {
            $row         = @mysqli_fetch_array($query);
            $all_plugins = unserialize($row[0]);
            if (is_array($all_plugins)) {
                return $all_plugins;
            }
        }
        return array();
    }

    /**
     *  Check to see if the internet is accessible
     *
     *  Note: fsocketopen on windows doesn't seem to honor $timeout setting.
     *
     *  @param string $url		A url e.g without prefix "ajax.googleapis.com"
     *  @param string $port		A valid port number
     *
     *  @return bool	Returns true PHP can request the URL
     */
    public static function isURLActive($url, $port, $timeout = 5)
    {
        if (function_exists('fsockopen')) {
            @ini_set("default_socket_timeout", 5);
            $port      = isset($port) && is_integer($port) ? $port : 80;
            $connected = @fsockopen($url, $port, $errno, $errstr, $timeout); //website and port
            if ($connected) {
                @fclose($connected);
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    /**
     * Does a string have non ascii characters
     *
     * @param string $string Any string blob
     *
     * @return bool Returns true if any non ascii character is found in the blob
     */
    public static function isNonASCII($string)
    {
        return preg_match('/[^\x20-\x7f]/', $string);
    }


	/**
     * Is the string JSON
     *
     * @param string $string Any string blob
     *
     * @return bool Returns true if the string is JSON encoded
     */
    public static function isJSON($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }

    /**
     *  The characters that are special in the replacement value of preg_replace are not the
     *  same characters that are special in the pattern.  Allows for '$' to be safely passed.
     *
     *  @param string $str		The string to replace on
    public static function pregSpecialChars($str)
    {
        return preg_replace('/(\$|\\\\)(?=\d)/', '\\\\\1', $str);
    }
	 * */

    /**
     * Display human readable byte sizes
     *
     * @param string $size	The size in bytes
     *
     * @return string Human readable bytes such as 50MB, 1GB
     */
    public static function readableByteSize($size)
    {
        try {
            $units = array('B', 'KB', 'MB', 'GB', 'TB');
            for ($i = 0; $size >= 1024 && $i < 4; $i++)
                $size /= 1024;
            return round($size, 2).$units[$i];
        } catch (Exception $e) {
            return "n/a";
        }
    }

    /**
     * Converts shorthand memory notation value to bytes
     *
     * @param $val Memory size shorthand notation string such as 10M, 1G
     *
     * @returns int The byte representation of the shorthand $val
     */
    public static function getBytes($val)
    {
        $val  = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
                break;
            default :
                $val = null;
        }
        return $val;
    }

    /**
     *  Makes path safe for any OS for PHP
     *
     *  Paths should ALWAYS READ be "/"
     * 		uni:  /home/path/file.txt
     * 		win:  D:/home/path/file.txt
     *
     *  @param string $path		The path to make safe
     *
     *  @return string The original $path with a with all slashes facing '/'.
     */
    public static function setSafePath($path)
    {
        return str_replace("\\", "/", $path);
    }

    /**
     *  Looks for a list of strings in a string and returns each list item that is found
     *
     *  @param array  $list		An array of strings to search for
     *  @param string $haystack	The string blob to search through
     *
     *  @return array An array of strings from the $list array found in the $haystack
     */
    public static function getListValues($list, $haystack)
    {
        $found = array();
        foreach ($list as $var) {
            if (strstr($haystack, $var) !== false) {
                array_push($found, $var);
            }
        }
        return $found;
    }

    /**
     *  Makes path unsafe for any OS for PHP used primarily to show default
     *  Windows OS path standard
     *
     *  @param string $path		The path to make unsafe
     *
     *  @return string The original $path with a with all slashes facing '\'.
     */
    public static function unsetSafePath($path)
    {
        return str_replace("/", "\\", $path);
    }

	 /**
     *  Sanitize input for XSS code
     *
     *  @param string $val		The value to sanitize
     *
     *  @return string Returns the input value cleaned up.
     */
    public static function sanitize($input)
    {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

	/**
     *  Filter the string to escape the quote
     *
     *  @param string $val		The value to escape quote
     *
     *  @return string Returns the input value escaped
     */
    public static function safeQuote($val)
    {
		$val = addslashes($val);
        return $val;
    }

     /**
     *  Check PHP version
     *
     *  @param string $version		PHP version we looking for
     *
     *  @return boolean Returns true if version is same or above.
     */
    public static function isVersion($version)
    {
        return (version_compare(PHP_VERSION, $version) >= 0);
    }

}
?>
<?php

/**
 * Lightweight abstraction layer for common simple server based routines
 *
 * Standard: PSR-2
 * @link http://www.php-fig.org/psr/psr-2 Full Documentation
 *
 * @package SC\DUPX\Server
 *
 */
class DUPX_Server
{
	/**
	 * Returns true if safe mode is enabled
	 */
	public static $php_safe_mode_on = false;

	/**
	 * The servers current PHP version
	 */
	public static $php_version = 0;

	/**
	 * The minimum PHP version the installer will support
	 */
	public static $php_version_min = "5.2.7";

	/**
	 * Is the current servers version of PHP safe to use with the installer
	 */
	public static $php_version_safe = false;


	 /**
     * Is PHP 5.3 or better running
     */
    public static $php_version_53_plus;

	/**
	 *  Used to init the static properties
	 */
	public static function init()
	{
		self::$php_safe_mode_on		= in_array(strtolower(@ini_get('safe_mode')), array('on', 'yes', 'true', 1, "1"));
		self::$php_version			= phpversion();
		self::$php_version_safe		= DUPX_U::isVersion(self::$php_version_min);
		self::$php_version_53_plus	= DUPX_U::isVersion('5.3.0');
	}

	/**
	 *  Is the directory provided writable by PHP
	 *
	 * 	@param string $path A physical directory path
	 *
	 *  @return bool Returns true if PHP can write to the path provided
	 */
	public static function isDirWritable($path)
	{
		if (!@is_writeable($path)) return false;

		if (is_dir($path)) {
			if ($dh = @opendir($path)) {
				closedir($dh);
			} else {
				return false;
			}
		}
		return true;
	}

	/**
	 *  Can this server process in shell_exec mode
	 *
	 *  @return bool	Returns true is the server can run shell_exec commands
	 */
	public static function hasShellExec()
	{
		if (array_intersect(array('shell_exec', 'escapeshellarg', 'escapeshellcmd', 'extension_loaded'), array_map('trim', explode(',', @ini_get('disable_functions'))))) return false;

		//Suhosin: http://www.hardened-php.net/suhosin/
		//Will cause PHP to silently fail.
		if (extension_loaded('suhosin')) return false;

		// Can we issue a simple echo command?
		if (!@shell_exec('echo duplicator')) return false;

		return true;
	}

	/**
	 *  Returns the path where the zip command can be called on this server
	 *
	 *  @return string	The path to where the zip command can be processed
	 */
	public static function getUnzipPath()
	{
		$filepath = null;
		if (self::hasShellExec()) {
			if (shell_exec('hash unzip 2>&1') == NULL) {
				$filepath = 'unzip';
			} else {
				$try_paths = array(
					'/usr/bin/unzip',
					'/opt/local/bin/unzip');
				foreach ($try_paths as $path) {
					if (file_exists($path)) {
						$filepath = $path;
						break;
					}
				}
			}
		}
		return $filepath;
	}


	/**
     *  A safe method used to copy larger files
     *
     *  @param string $source		The path to the file being copied
     *  @param string $destination	The path to the file being made
	 *
	 *	@return bool	True if the file was copied 
     */
    public static function copyFile($source, $destination)
    {
		try {
			$sp = fopen($source, 'r');
			$op = fopen($destination, 'w');

			while (!feof($sp)) {
				$buffer = fread($sp, 512);  // use a buffer of 512 bytes
				fwrite($op, $buffer);
			}
			// close handles
			fclose($op);
			fclose($sp);
			return true;

		} catch (Exception $ex) {
			return false;
		}
    }


	/**
     *  Returns an array of zip files found in the current executing directory
     *
     *  @return array of zip files
     */
    public static function getZipFiles()
    {
        $files = array();
        foreach (glob("*.zip") as $name) {
            if (file_exists($name)) {
                $files[] = $name;
            }
        }

        if (count($files) > 0) {
            return $files;
        }

        //FALL BACK: Windows XP has bug with glob,
        //add secondary check for PHP lameness
        if ($dh = opendir('.')) {
            while (false !== ($name = readdir($dh))) {
                $ext = substr($name, strrpos($name, '.') + 1);
                if (in_array($ext, array("zip"))) {
                    $files[] = $name;
                }
            }
            closedir($dh);
        }

        return $files;
    }
}
//INIT Class Properties
DUPX_Server::init();
?>
<?php

/**
 * Lightweight abstraction layer for common simple database routines
 *
 * Standard: PSR-2
 * @link http://www.php-fig.org/psr/psr-2 Full Documentation
 *
 * @package SC\DUPX\DB
 *
 */
class DUPX_DB
{

	/**
	 * MySQL connection wrapper with support for port
	 *
	 * @param string    $host       The server host name
	 * @param string    $username   The server DB user name
	 * @param string    $password   The server DB password
	 * @param string    $dbname     The server DB name
	 * @param int       $port       The server DB port
	 *
	 * @return database connection handle
	 */
	public static function connect($host, $username, $password, $dbname = '', $port = null)
	{
		//sock connections
		if ('sock' === substr($host, -4)) {
			$url_parts	 = parse_url($host);
			$dbh		 = @mysqli_connect('localhost', $username, $password, $dbname, null, $url_parts['path']);
		} else {
			$dbh = @mysqli_connect($host, $username, $password, $dbname, $port);
		}
		return $dbh;
	}

	/**
	 *  Count the tables in a given database
	 *
	 * @param obj    $dbh       A valid database link handle
	 * @param string $dbname    Database to count tables in
	 *
	 * @return int  The number of tables in the database
	 */
	public static function countTables($dbh, $dbname)
	{
		$res = mysqli_query($dbh, "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '{$dbname}' ");
		$row = mysqli_fetch_row($res);
		return is_null($row) ? 0 : $row[0];
	}

	/**
	 * Returns the number of rows in a table
	 *
	 * @param obj    $dbh   A valid database link handle
	 * @param string $name	A valid table name
	 */
	public static function countTableRows($dbh, $name)
	{
		$total = mysqli_query($dbh, "SELECT COUNT(*) FROM `$name`");
		if ($total) {
			$total = @mysqli_fetch_array($total);
			return $total[0];
		} else {
			return 0;
		}
	}

	/**
	 * Returns the tables for a database as an array
	 *
	 * @param obj $dbh   A valid database link handle
	 *
	 * @return array  A list of all table names
	 */
	public static function getTables($dbh)
	{
		$query = @mysqli_query($dbh, 'SHOW TABLES');
		if ($query) {
			while ($table = @mysqli_fetch_array($query)) {
				$all_tables[] = $table[0];
			}
			if (isset($all_tables) && is_array($all_tables)) {
				return $all_tables;
			}
		}
		return array();
	}

	/**
	 * Get the requested MySQL system variable
	 *
	 * @param obj    $dbh   A valid database link handle
	 * @param string $name  The database variable name to lookup
	 *
	 * @return string the server variable to query for
	 */
	public static function getVariable($dbh, $name)
	{
		$result	 = @mysqli_query($dbh, "SHOW VARIABLES LIKE '{$name}'");
		$row	 = @mysqli_fetch_array($result);
		@mysqli_free_result($result);
		return isset($row[1]) ? $row[1] : null;
	}

	/**
	 * Gets the MySQL database version number
	 *
	 * @param obj    $dbh   A valid database link handle
	 * @param bool   $full  True:  Gets the full version
	 *                      False: Gets only the numeric portion i.e. 5.5.6 or 10.1.2 (for MariaDB)
	 *
	 * @return false|string 0 on failure, version number on success
	 */
	public static function getVersion($dbh, $full = false)
	{
		if ($full) {
			$version = self::getVariable($dbh, 'version');
		} else {
			$version = preg_replace('/[^0-9.].*/', '', self::getVariable($dbh, 'version'));
		}

		$version = is_null($version) ? null : $version;
		return empty($version) ? 0 : $version;
	}

	/**
	 * Returns a more detailed string about the msyql server version
	 * For example on some systems the result is 5.5.5-10.1.21-MariaDB
	 * this format is helpful for providing the user a full overview
	 *
	 * @param conn $dbh Database connection handle
	 *
	 * @return string The full details of mysql
	 */
	public static function getServerInfo($dbh)
	{
		return mysqli_get_server_info($dbh);
	}

    /**
     * Get an array of all supported collation names
     *
     * @param conn $dbh Database connection handle
     *
     * @return array
     */
    public static function getSupportedCollationsList($dbh)
    {
        $collations = array();

        $query  = "SHOW COLLATION";
        if ($result = $dbh->query($query)) {

            while ($row = $result->fetch_assoc()) {
                $collations[] = $row["Collation"];
            }

        }
        $result->free();

        return $collations;
    }

	/**
	 * Determine if a MySQL database supports a particular feature
	 *
	 * @param conn $dbh Database connection handle
	 * @param string $feature the feature to check for
	 *
	 * @return bool
	 */
	public static function hasAbility($dbh, $feature)
	{
		$version = self::getVersion($dbh);

		switch (strtolower($feature)) {
			case 'collation' :
			case 'group_concat' :
			case 'subqueries' :
				return version_compare($version, '4.1', '>=');
			case 'set_charset' :
				return version_compare($version, '5.0.7', '>=');
		};
		return false;
	}

	/**
	 * Sets the MySQL connection's character set.
	 *
	 * @param resource $dbh     The resource given by mysqli_connect
	 * @param string   $charset The character set (optional)
	 * @param string   $collate The collation (optional)
	 *
	 * @return bool True on success
	 */
	public static function setCharset($dbh, $charset = null, $collate = null)
	{
		$charset = (!isset($charset) ) ? $GLOBALS['DBCHARSET_DEFAULT'] : $charset;
		$collate = (!isset($collate) ) ? $GLOBALS['DBCOLLATE_DEFAULT'] : $collate;

		if (self::hasAbility($dbh, 'collation') && !empty($charset)) {
			if (function_exists('mysqli_set_charset') && self::hasAbility($dbh, 'set_charset')) {
				return mysqli_set_charset($dbh, $charset);
			} else {
				$sql = " SET NAMES {$charset}";
				if (!empty($collate)) $sql .= " COLLATE {$collate}";
				return mysqli_query($dbh, $sql);
			}
		}
	}
}
?>
<?php

define('ERR_CONFIG_FOUND',		'A wp-config.php already exists in this location.  This error prevents users from accidentally overwriting the wrong directories contents.  You have three options: <ul><li>Empty this root directory except for the package and installer and try again.</li><li>Delete just the wp-config.php file and try again.  This will over-write all other files in the directory.</li><li>Check the "Manual package extraction" checkbox under advanced options to skip extraction</li></ul>');
define('ERR_ZIPNOTFOUND',		'The packaged zip file was not found. Be sure the zip package is in the same directory as the installer file and as the correct permissions.  If you are trying to reinstall a package you can copy the package from the "' . DUPLICATOR_SSDIR_NAME . '" directory back up to your root which is the same location as your installer.php file.');
define('ERR_ZIPOPEN',			'Failed to open zip archive file. Please be sure the archive is completely downloaded before running the installer. Try to extract the archive manually to make sure the file is not corrupted.');
define('ERR_ZIPEXTRACTION',		'Errors extracting zip file.  Portions or part of the zip archive did not extract correctly.    Try to extract the archive manually with a client side program like unzip/win-zip/winrar or your hosts cPanel to make sure the file is not corrupted.  If the file extracts correctly then there is an invalid file or directory that PHP is unable to extract.  This can happen if your moving from one operating system to another where certain naming conventions work on one environment and not another. <br/><br/> <b>Workarounds:</b> <br/> 1. Create a new package and be sure to exclude any directories that have invalid names or files in them.   This warning will be displayed on the scan results under "Name Checks". <br/> 2. Manually extract the zip file with a client side program or your hosts cPanel.  Then under options in step 1 of this installer check the "Manual Archive Extraction" option and perform the install.');
define('ERR_ZIPMANUAL',			'When choosing manual package extraction, the contents of the package must already be extracted and the wp-config.php and database.sql files must be present in the same directory as the installer.php for the process to continue.  Please manually extract the package into the current directory before continuing in manual extraction mode.  Also validate that the wp-config.php and database.sql files are present.');
define('ERR_MAKELOG',			'PHP is having issues writing to the log file <b>' . DUPX_U::setSafePath($GLOBALS['CURRENT_ROOT_PATH']) . '\installer-log.txt .</b> In order for the Duplicator to proceed validate your owner/group and permission settings for PHP on this path. Try temporarily setting you permissions to 777 to see if the issue gets resolved.  If you are on a shared hosting environment please contact your hosting company and tell them you are getting errors writing files to the path above when using PHP.');
define('ERR_ZIPARCHIVE',		'In order to extract the archive.zip file the PHP ZipArchive module must be installed.  Please read the FAQ for more details.  You can still install this package but you will need to check the Manual package extraction checkbox found in the Advanced Options.  Please read the online user guide for details in performing a manual package extraction.');
define('ERR_MYSQLI_SUPPORT',	'In order to complete an install the mysqli extension for PHP is required. If you are on a hosted server please contact your host and request that mysqli be enabled.  For more information visit: http://php.net/manual/en/mysqli.installation.php');
define('ERR_DBCONNECT',			'DATABASE CONNECTION FAILED!<br/>');
define('ERR_DBCONNECT_INFO',	'<b>DATABASE CONNECTION FAILED!</b><br/>If the problem persists see the online FAQ for <a href="https://snapcreek.com/duplicator/docs/faqs-tech/#faq-installer-100-q" target="_blank">recommended fixes</a>.');
define('ERR_DBCONNECT_CREATE',  'DATABASE CREATION FAILURE!<br/> Unable to create database "%s". Check to make sure the user has "Create" privileges.  Some hosts will restrict creation of a database only through the cpanel.  Try creating the database manually to proceed with installation.  If the database already exists then check the radio button labeled "Connect and Remove All Data" which will remove all existing tables.');
define('ERR_DBTRYCLEAN',		'DATABASE CREATION FAILURE!<br/> Unable to remove all tables from database "%s".<br/>  Please remove all tables from this database and try the installation again.');
define('ERR_DBCREATE',			'The database "%s" does not exists.<br/>  Change mode to create in order to create a new database.');
define('ERR_DBEMPTY',			'The database "%s" has "%s" tables.  The Duplicator only works with an EMPTY database.  Enable the action "Connect and Remove All Data" radio button to remove all tables and or create a new database. Some hosting providers do not allow table removal from scripts.  In this case you will need to login to your hosting providers control panel and remove the tables manually.  Please contact your hosting provider for further details.  Always backup all your data before proceeding!');
define('ERR_TESTDB_UTF8',		'UTF8 Characters were detected as part of the database connection string. If your connection fails be sure  to update the MySQL my.ini configuration file setting to support UTF8 characters by enabling this option [character_set_server=utf8] and restarting the database server.');
define('ERR_TESTDB_VERSION_INFO',	'If the current version detected is below 5.5.3 (release on April 8th 2010) then support for utf8mb4 tables will not work.  The utf8mb4 format is only supported in MySQL server 5.5.3+.  It is highly recommended to upgrade your version of MySQL server on this server to be more compatible with recent releases of WordPress and avoid issues with install errors.');
define('ERR_TESTDB_VERSION_COMPAT',	'In order to avoid database incompatibility issues make sure the database versions between the build and installer servers are as close as possible. If the package was created on a newer database version than where it is being installed then you might run into issues.<br/><br/> It is best to make sure the server where the installer is running has the same or higher version number than where it was built.  If the major and minor version are the same or close for example [5.7 to 5.6], then the migration should work without issues.  A version pair of [5.7 to 5.1] is more likely to cause issues unless you have a very simple setup.  If the versions are too far apart work with your hosting provider to upgrade the MySQL engine on this server.<br/><br/>   <b>MariaDB:</b> If a version of 10.N.N shows then the database distribution is a MariaDB flavor of MySQL.   While the distributions are very close there are some subtle differences.   Some operating systems will report the version such as "5.5.5-10.1.21-MariaDB" showing the correlation of both.  Please visit the online <a href="https://mariadb.com/kb/en/mariadb/mariadb-vs-mysql-compatibility/" target="_blank">MariaDB versus MySQL - Compatibility</a> page for more details.<br/><br/> Please note these messages are simply notices.  It is highly recommended that you continue with the install process and closely monitor the installer-log.txt file along with the install report found on step 3 of the installer.  Be sure to look for any notices/warnings/errors in these locations to validate the install process did not detect any errors. If any issues are found please visit the FAQ pages and see the question <a href="https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=database_incompatibility#faq-installer-260-q" target="_blank">What if I get database errors or general warnings on the install report?</a>.');

/**
 * Class used to log information to the installer-log.txt file
 *
 * Standard: PSR-2
 * @link http://www.php-fig.org/psr/psr-2 Full Documentation
 *
 * @package SC\DUPX\Log
 *
 */
class DUPX_Log 
{

    /** 
     *  Used to write debug info to the text log file
     *
     *  @param string $msg		Any text data
     *  @param int $loglevel	Log level
     *
     *  @return string Write info to both the log and browser
     */
    public static function info($msg, $logging = 1)
	{
        if ($logging <= $GLOBALS["LOGGING"]) {
            @fwrite($GLOBALS["LOG_FILE_HANDLE"], "{$msg}\n");
        }
    }
	
    /** 
     *  Used to write errors to the text log file
     * 
     *  @param string $msg		Any text data
     *  @param int $loglevel	Log level
     * 
     *  @return string Write errors to both the log and browser
     */
    public static function error($msg)
	{
		$breaks = array("<br />","<br>","<br/>");  
		$log_msg = str_ireplace($breaks, "\r\n", $msg);
		$log_msg = strip_tags($log_msg);
		@fwrite($GLOBALS["LOG_FILE_HANDLE"], "\nINSTALLER ERROR:\n{$log_msg}\n");
		@fclose($GLOBALS["LOG_FILE_HANDLE"]);
        die("<div class='dupx-ui-error'><hr size='1' /><b style='color:#B80000;'>INSTALL ERROR!</b><br/>{$msg}</div>");
    }
}
?>
<?php

/**
 * Walks every table in db that then walks every row and column replacing searches with replaces
 * large tables are split into 50k row blocks to save on memory.
 *
 * Standard: PSR-2
 * @link http://www.php-fig.org/psr/psr-2 Full Documentation
 *
 * @package SC\DUPX\UpdateEngine
 *
 */
class DUPX_UpdateEngine
{

	/**
	 *  Used to report on all log errors into the installer-txt.log
	 *
	 *  @param string $report   The report error array of all error types
	 *
	 *  @return string Writes the results of the update engine tables to the log
	 */
	public static function logErrors($report)
	{
		if (!empty($report['errsql'])) {
			DUPX_Log::info("--------------------------------------");
			DUPX_Log::info("DATA-REPLACE ERRORS (MySQL)");
			foreach ($report['errsql'] as $error) {
				DUPX_Log::info($error);
			}
			DUPX_Log::info("");
		}
		if (!empty($report['errser'])) {
			DUPX_Log::info("--------------------------------------");
			DUPX_Log::info("DATA-REPLACE ERRORS (Serialization):");
			foreach ($report['errser'] as $error) {
				DUPX_Log::info($error);
			}
			DUPX_Log::info("");
		}
		if (!empty($report['errkey'])) {
			DUPX_Log::info("--------------------------------------");
			DUPX_Log::info("DATA-REPLACE ERRORS (Key):");
			DUPX_Log::info('Use SQL: SELECT @row := @row + 1 as row, t.* FROM some_table t, (SELECT @row := 0) r');
			foreach ($report['errkey'] as $error) {
				DUPX_Log::info($error);
			}
		}
	}

	/**
	 *  Used to report on all log stats into the installer-txt.log
	 *
	 *  @param string $report   The report stats array of all error types
	 *
	 *  @return string Writes the results of the update engine tables to the log
	 */
	public static function logStats($report)
	{
		if (!empty($report) && is_array($report)) {
			$stats	 = "--------------------------------------\n";
			$srchnum = 0;
			foreach ($GLOBALS['REPLACE_LIST'] as $item) {
				$srchnum++;
				$stats .= sprintf("Search{$srchnum}:\t'%s' \nChange{$srchnum}:\t'%s' \n", $item['search'], $item['replace']);
			}
			$stats .= sprintf("SCANNED:\tTables:%d \t|\t Rows:%d \t|\t Cells:%d \n", $report['scan_tables'], $report['scan_rows'], $report['scan_cells']);
			$stats .= sprintf("UPDATED:\tTables:%d \t|\t Rows:%d \t|\t Cells:%d \n", $report['updt_tables'], $report['updt_rows'], $report['updt_cells']);
			$stats .= sprintf("ERRORS:\t\t%d \nRUNTIME:\t%f sec", $report['err_all'], $report['time']);
			DUPX_Log::info($stats);
		}
	}

	/**
	 * Returns only the text type columns of a table ignoring all numeric types
	 *
	 * @param obj    $dbh       A valid database link handle
	 * @param string $table     A valid table name
	 *
	 * @return array All the column names of a table
	 */
	public static function getTextColumns($dbh, $table)
	{
		$type_where = "type NOT LIKE 'tinyint%' AND ";
		$type_where .= "type NOT LIKE 'smallint%' AND ";
		$type_where .= "type NOT LIKE 'mediumint%' AND ";
		$type_where .= "type NOT LIKE 'int%' AND ";
		$type_where .= "type NOT LIKE 'bigint%' AND ";
		$type_where .= "type NOT LIKE 'float%' AND ";
		$type_where .= "type NOT LIKE 'double%' AND ";
		$type_where .= "type NOT LIKE 'decimal%' AND ";
		$type_where .= "type NOT LIKE 'numeric%' AND ";
		$type_where .= "type NOT LIKE 'date%' AND ";
		$type_where .= "type NOT LIKE 'time%' AND ";
		$type_where .= "type NOT LIKE 'year%' ";

		$result = mysqli_query($dbh, "SHOW COLUMNS FROM `{$table}` WHERE {$type_where}");
		if (!$result) {
			return null;
		}
		$fields = array();
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$fields[] = $row['Field'];
			}
		}

		//Return Primary which is needed for index lookup
		//$result = mysqli_query($dbh, "SHOW INDEX FROM `{$table}` WHERE KEY_NAME LIKE '%PRIMARY%'"); 1.1.15 updated
		$result = mysqli_query($dbh, "SHOW INDEX FROM `{$table}`");
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$fields[] = $row['Column_name'];
			}
		}

		return (count($fields) > 0) ? $fields : null;
	}

	/**
	 * Begins the processing for replace logic
	 *
	 * @param mysql  $dbh			The db connection object
	 * @param array  $list			Key value pair of 'search' and 'replace' arrays
	 * @param array  $tables		The tables we want to look at
	 * @param array  $fullsearch    Search every column regardless of its data type
	 *
	 * @return array Collection of information gathered during the run.
	 */
	public static function load($dbh, $list = array(), $tables = array(), $fullsearch = false)
	{
		$report = array(
			'scan_tables' => 0,
			'scan_rows' => 0,
			'scan_cells' => 0,
			'updt_tables' => 0,
			'updt_rows' => 0,
			'updt_cells' => 0,
			'errsql' => array(),
			'errser' => array(),
			'errkey' => array(),
			'errsql_sum' => 0,
			'errser_sum' => 0,
			'errkey_sum' => 0,
			'time' => '',
			'err_all' => 0
		);

		function set_sql_column_safe(&$str) {
			$str = "`$str`";
		}
        
		$profile_start = DUPX_U::getMicrotime();
		if (is_array($tables) && !empty($tables)) {

			foreach ($tables as $table) {
				$report['scan_tables'] ++;
				$columns = array();

				// Get a list of columns in this table
				$fields	 = mysqli_query($dbh, 'DESCRIBE '.$table);
				while ($column	 = mysqli_fetch_array($fields)) {
					$columns[$column['Field']] = $column['Key'] == 'PRI' ? true : false;
				}

				// Count the number of rows we have in the table if large we'll split into blocks
				$row_count	 = mysqli_query($dbh, "SELECT COUNT(*) FROM `{$table}`");
				$rows_result = mysqli_fetch_array($row_count);
				@mysqli_free_result($row_count);
				$row_count	 = $rows_result[0];
				if ($row_count == 0) {
					DUPX_Log::info("{$table}^ ({$row_count})");
					continue;
				}

				$page_size	 = 25000;
				$offset		 = ($page_size + 1);
				$pages		 = ceil($row_count / $page_size);

				// Grab the columns of the table.  Only grab text based columns because
				// they are the only data types that should allow any type of search/replace logic
				$colList = '*';
				$colMsg	 = '*';
				if (!$fullsearch) {
					$colList = self::getTextColumns($dbh, $table);
					if ($colList != null && is_array($colList)) {
						array_walk($colList, set_sql_column_safe);
						$colList = implode(',', $colList);
					}
					$colMsg = (empty($colList)) ? '*' : '~';
				}

				if (empty($colList)) {
					DUPX_Log::info("{$table}^ ({$row_count})");
					continue;
				} else {
					DUPX_Log::info("{$table}{$colMsg} ({$row_count})");
				}

				//Paged Records
				for ($page = 0; $page < $pages; $page++) {
					$current_row = 0;
					$start		 = $page * $page_size;
					$end		 = $start + $page_size;
					$sql		 = sprintf("SELECT {$colList} FROM `%s` LIMIT %d, %d", $table, $start, $offset);
					$data		 = mysqli_query($dbh, $sql);

					if (!$data) $report['errsql'][] = mysqli_error($dbh);

					$scan_count = ($row_count < $end) ? $row_count : $end;
					DUPX_Log::info("\tScan => {$start} of {$scan_count}", 2);

					//Loops every row
					while ($row = mysqli_fetch_array($data)) {
						$report['scan_rows'] ++;
						$current_row++;
						$upd_col	 = array();
						$upd_sql	 = array();
						$where_sql	 = array();
						$upd		 = false;
						$serial_err	 = 0;
                        $is_unkeyed = !in_array(true,$columns);

						//Loops every cell
						foreach ($columns as $column => $primary_key) {
							$report['scan_cells'] ++;
							$edited_data		= $data_to_fix = $row[$column];
							$base64converted	= false;
							$txt_found			= false;

                            //Unkeyed table code
                            //Added this here to add all columns to $where_sql
                            //The if statement with $txt_found would skip additional columns
                            if($is_unkeyed && ! empty($data_to_fix)) {
                                $where_sql[] = $column.' = "'.mysqli_real_escape_string($dbh, $data_to_fix).'"';
                            }

							//Only replacing string values
							if (!empty($row[$column]) && !is_numeric($row[$column]) && $primary_key != 1) {
								//Base 64 detection
								if (base64_decode($row[$column], true)) {
									$decoded = base64_decode($row[$column], true);
									if (self::isSerialized($decoded)) {
										$edited_data	 = $decoded;
										$base64converted	 = true;
									}
								}

								//Skip table cell if match not found
								foreach ($list as $item) {
									if (strpos($edited_data, $item['search']) !== false) {
										$txt_found = true;
										break;
									}
								}
								if (!$txt_found) {
									continue;
								}

								//Replace logic - level 1: simple check on any string or serialized strings
								foreach ($list as $item) {
									$edited_data = self::recursiveUnserializeReplace($item['search'], $item['replace'], $edited_data);
								}

								//Replace logic - level 2: repair serialized strings that have become broken
								$serial_check = self::fixSerialString($edited_data);
								if ($serial_check['fixed']) {
									$edited_data = $serial_check['data'];
								} elseif ($serial_check['tried'] && !$serial_check['fixed']) {
									$serial_err++;
								}
							}

							//Change was made
							if ($edited_data != $data_to_fix || $serial_err > 0) {
								$report['updt_cells'] ++;
								//Base 64 encode
								if ($base64converted) {
									$edited_data = base64_encode($edited_data);
								}
								$upd_col[]	 = $column;
								$upd_sql[]	 = $column.' = "'.mysqli_real_escape_string($dbh, $edited_data).'"';
								$upd		 = true;
							}

							if ($primary_key) {
								$where_sql[] = $column.' = "'.mysqli_real_escape_string($dbh, $data_to_fix).'"';
							}
						}

						//PERFORM ROW UPDATE
						if ($upd && !empty($where_sql)) {
							$sql	= "UPDATE `{$table}` SET ".implode(', ', $upd_sql).' WHERE '.implode(' AND ', array_filter($where_sql));
							$result	= mysqli_query($dbh, $sql);
							if ($result) {
								if ($serial_err > 0) {
									$report['errser'][] = "SELECT " . implode(', ', $upd_col) . " FROM `{$table}`  WHERE " . implode(' AND ', array_filter($where_sql)) . ';';
								}
								$report['updt_rows']++;
							} else  {
								$report['errsql'][]	 = ($GLOBALS["LOGGING"] == 1)
									? 'DB ERROR: ' . mysqli_error($dbh)
									: 'DB ERROR: ' . mysqli_error($dbh) . "\nSQL: [{$sql}]\n";
							}

							//DEBUG ONLY:
							DUPX_Log::info("\t{$sql}\n", 3);

						} elseif ($upd) {
							$report['errkey'][] = sprintf("Row [%s] on Table [%s] requires a manual update.", $current_row, $table);
						}
					}
					//DUPX_U::fcgiFlush();
					@mysqli_free_result($data);
				}

				if ($upd) {
					$report['updt_tables'] ++;
				}
			}
		}
		$profile_end			 = DUPX_U::getMicrotime();
		$report['time']			 = DUPX_U::elapsedTime($profile_end, $profile_start);
		$report['errsql_sum']	 = empty($report['errsql']) ? 0 : count($report['errsql']);
		$report['errser_sum']	 = empty($report['errser']) ? 0 : count($report['errser']);
		$report['errkey_sum']	 = empty($report['errkey']) ? 0 : count($report['errkey']);
		$report['err_all']		 = $report['errsql_sum'] + $report['errser_sum'] + $report['errkey_sum'];
		return $report;
	}

	/**
	 * Take a serialized array and unserialized it replacing elements and
	 * unserializing any subordinate arrays and performing the replace.
	 *
	 * @param string $from       String we're looking to replace.
	 * @param string $to         What we want it to be replaced with
	 * @param array  $data       Used to pass any subordinate arrays back to in.
	 * @param bool   $serialised Does the array passed via $data need serializing.
	 *
	 * @return array	The original array with all elements replaced as needed. 
	 */
	public static function recursiveUnserializeReplace($from = '', $to = '', $data = '', $serialised = false)
	{
		// some unseriliased data cannot be re-serialised eg. SimpleXMLElements
		try {
			if (is_string($data) && ($unserialized = @unserialize($data)) !== false) {
				$data = self::recursiveUnserializeReplace($from, $to, $unserialized, true);
			} elseif (is_array($data)) {
				$_tmp = array();
				foreach ($data as $key => $value) {
					$_tmp[$key] = self::recursiveUnserializeReplace($from, $to, $value, false);
				}
				$data = $_tmp;
				unset($_tmp);

				/* CJL
				  Check for an update to the key of an array e.g.   [http://localhost/projects/wpplugins/] => 1.41
				  This could have unintended consequences would need to enable with full-search needs more testing
				  if (array_key_exists($from, $data))
				  {
				  $data[$to] = $data[$from];
				  unset($data[$from]);
				  } */
			} elseif (is_object($data)) {
				/* RSR Old logic that didn't work with Beaver Builder - they didn't want to create a brand new
				  object instead reused the existing one...
				  $dataClass = get_class($data);
				  $_tmp = new $dataClass();
				  foreach ($data as $key => $value) {
				  $_tmp->$key = self::recursiveUnserializeReplace($from, $to, $value, false);
				  }
				  $data = $_tmp;
				  unset($_tmp); */

				// RSR NEW LOGIC
				$_tmp	 = $data;
				$props	 = get_object_vars($data);
				foreach ($props as $key => $value) {
					$_tmp->$key = self::recursiveUnserializeReplace($from, $to, $value, false);
				}
				$data = $_tmp;
				unset($_tmp);
			} else {
				if (is_string($data)) {
					$data = str_replace($from, $to, $data);
				}
			}

			if ($serialised) return serialize($data);
		} catch (Exception $error) {
			DUPX_Log::info("\nRECURSIVE UNSERIALIZE ERROR: With string\n".$error, 2);
		}
		return $data;
	}

	/**
	 * Test if a string in properly serialized
	 *
	 * @param string $data  Any string type
	 *
	 * @return bool Is the string a serialized string
	 */
	public static function isSerialized($data)
	{
		$test = @unserialize(($data));
		return ($test !== false || $test === 'b:0;') ? true : false;
	}

	/**
	 *  Fixes the string length of a string object that has been serialized but the length is broken
	 *
	 *  @param string $data	The string ojbect to recalculate the size on.
	 *
	 *  @return string  A serialized string that fixes and string length types
	 */
	public static function fixSerialString($data)
	{
		$result = array('data' => $data, 'fixed' => false, 'tried' => false);
		if (preg_match("/s:[0-9]+:/", $data)) {
			if (!self::isSerialized($data)) {
				$regex			 = '!(?<=^|;)s:(\d+)(?=:"(.*?)";(?:}|a:|s:|b:|d:|i:|o:|N;))!s';
				$serial_string	 = preg_match('/^s:[0-9]+:"(.*$)/s', trim($data), $matches);
				//Nested serial string
				if ($serial_string) {
					$inner				 = preg_replace_callback($regex, 'DUPX_UpdateEngine::fixStringCallback', rtrim($matches[1], '";'));
					$serialized_fixed	 = 's:'.strlen($inner).':"'.$inner.'";';
				} else {
					$serialized_fixed = preg_replace_callback($regex, 'DUPX_UpdateEngine::fixStringCallback', $data);
				}

				if (self::isSerialized($serialized_fixed)) {
					$result['data']	 = $serialized_fixed;
					$result['fixed'] = true;
				}
				$result['tried'] = true;
			}
		}
		return $result;
	}

	/**
	 *  The call back method call from via fixSerialString
	 */
	private static function fixStringCallback($matches)
	{
		return 's:'.strlen(($matches[2]));
	}
}
?>
<?php
/**
 * Class used to update and edit and update the wp-config.php
 *
 * Standard: PSR-2
 * @link http://www.php-fig.org/psr/psr-2 Full Documentation
 *
 * @package SC\DUPX\WPConfig
 *
 */
class DUPX_WPConfig
{
	/**
	 *  Updates the web server config files in Step 3
	 *
	 *  @return null
	 */
	public static function updateStandard()
	{
		if (!file_exists('wp-config.php'))
			return;

		$root_path	= DUPX_U::setSafePath($GLOBALS['CURRENT_ROOT_PATH']);
		$wpconfig	= @file_get_contents('wp-config.php', true);

		$db_port    = is_int($_POST['dbport'])   ? $_POST['dbport'] : 3306;
		$db_host	= ($db_port == 3306) ? $_POST['dbhost'] : "{$_POST['dbhost']}:{$db_port}";
		$db_name	= isset($_POST['dbname']) ? DUPX_U::safeQuote($_POST['dbname']) : null;
		$db_user	= isset($_POST['dbuser']) ? DUPX_U::safeQuote($_POST['dbuser']) : null;
       	$db_pass	= isset($_POST['dbpass']) ? DUPX_U::safeQuote($_POST['dbpass']) : null;

		$patterns = array(
			"/'DB_NAME',\s*'.*?'/",
			"/'DB_USER',\s*'.*?'/",
			"/'DB_PASSWORD',\s*'.*?'/",
			"/'DB_HOST',\s*'.*?'/"
		);

		$replace = array(
			"'DB_NAME', "		. "'{$db_name}'",
			"'DB_USER', "		. "'{$db_user}'",
			"'DB_PASSWORD', "	. "'{$db_pass}'",
			"'DB_HOST', "		. "'{$db_host}'"
		);

		//SSL CHECKS
		if ($_POST['ssl_admin']) {
			if (!strstr($wpconfig, 'FORCE_SSL_ADMIN')) {
				$wpconfig = $wpconfig.PHP_EOL."define('FORCE_SSL_ADMIN', true);";
			}
		} else {
			array_push($patterns, "/'FORCE_SSL_ADMIN',\s*true/");
			array_push($replace, "'FORCE_SSL_ADMIN', false");
		}

		//CACHE CHECKS
		if ($_POST['cache_wp']) {
			if (!strstr($wpconfig, 'WP_CACHE')) {
				$wpconfig = $wpconfig.PHP_EOL."define('WP_CACHE', true);";
			}
		} else {
			array_push($patterns, "/'WP_CACHE',\s*true/");
			array_push($replace, "'WP_CACHE', false");
		}
		if (!$_POST['cache_path']) {
			array_push($patterns, "/'WPCACHEHOME',\s*'.*?'/");
			array_push($replace, "'WPCACHEHOME', ''");
		}

		if (!is_writable("{$root_path}/wp-config.php")) {
			if (file_exists("{$root_path}/wp-config.php")) {
				chmod("{$root_path}/wp-config.php", 0644) ? DUPX_Log::info('File Permission Update: wp-config.php set to 0644') : DUPX_Log::info('WARNING: Unable to update file permissions and write to wp-config.php.  Please visit the online FAQ for setting file permissions and work with your hosting provider or server administrator to enable this installer.php script to write to the wp-config.php file.');
			} else {
				DUPX_Log::info('WARNING: Unable to locate wp-config.php file.  Be sure the file is present in your archive.');
			}
		}

        $replace  = array_map('self::customEscape', $replace);
		$wpconfig = preg_replace($patterns, $replace, $wpconfig);

		file_put_contents('wp-config.php', $wpconfig);
		$wpconfig = null;
	}

	/**
	 *  Updates the web server config files in Step 3
	 *
	 *  @return null
	 */
	public static function updateExtended()
	{
		$config_file = '';
		if (!file_exists('wp-config.php')) {
			return $config_file;
		}

		$root_path		= DUPX_U::setSafePath($GLOBALS['CURRENT_ROOT_PATH']);
		$wpconfig_path	= "{$root_path}/wp-config.php";
		$config_file	= @file_get_contents($wpconfig_path, true);

		$patterns	 = array(
			"/('|\")WP_HOME.*?\)\s*;/",
			"/('|\")WP_SITEURL.*?\)\s*;/");
		$replace	 = array(
			"'WP_HOME', '{$_POST['url_new']}');",
			"'WP_SITEURL', '{$_POST['url_new']}');");

		//Not sure how well tokenParser works on all servers so only using for not critical constants at this point.
		//$count checks for dynamic variable types such as:  define('WP_TEMP_DIR',	'D:/' . $var . 'somepath/');
		//which should not be updated.
		$defines = self::tokenParser($wpconfig_path);

		//WP_CONTENT_DIR
		if (isset($defines['WP_CONTENT_DIR'])) {
			$val = str_replace($_POST['path_old'], $_POST['path_new'], DUPX_U::setSafePath($defines['WP_CONTENT_DIR']), $count);
			if ($count > 0) {
				array_push($patterns, "/('|\")WP_CONTENT_DIR.*?\)\s*;/");
				array_push($replace, "'WP_CONTENT_DIR', '{$val}');");
			}
		}

		//WP_CONTENT_URL
		if (isset($defines['WP_CONTENT_URL'])) {
			$val = str_replace($_POST['url_old'] . '/', $_POST['url_new'] . '/', $defines['WP_CONTENT_URL'], $count);
			if ($count > 0) {
				array_push($patterns, "/('|\")WP_CONTENT_URL.*?\)\s*;/");
				array_push($replace, "'WP_CONTENT_URL', '{$val}');");
			}
		}

		//WP_TEMP_DIR
		if (isset($defines['WP_TEMP_DIR'])) {
			$val = str_replace($_POST['path_old'], $_POST['path_new'], DUPX_U::setSafePath($defines['WP_TEMP_DIR']) , $count);
			if ($count > 0) {
				array_push($patterns, "/('|\")WP_TEMP_DIR.*?\)\s*;/");
				array_push($replace, "'WP_TEMP_DIR', '{$val}');");
			}
		}
		
		//DOMAIN_CURRENT_SITE
		if (isset($defines['DOMAIN_CURRENT_SITE'])) {
			$mu_newDomainHost = parse_url($_POST['url_new'], PHP_URL_HOST);
			array_push($patterns, "/('|\")DOMAIN_CURRENT_SITE.*?\)\s*;/");
			array_push($replace, "'DOMAIN_CURRENT_SITE', '{$mu_newDomainHost}');");
		}

		//PATH_CURRENT_SITE
		if (isset($defines['PATH_CURRENT_SITE'])) {
			$mu_newUrlPath = parse_url($_POST['url_new'], PHP_URL_PATH);
			array_push($patterns, "/('|\")PATH_CURRENT_SITE.*?\)\s*;/");
			array_push($replace, "'PATH_CURRENT_SITE', '{$mu_newUrlPath}');");
		}
		
		$config_file = preg_replace($patterns, $replace, $config_file);
		file_put_contents($wpconfig_path, $config_file);
		$config_file = file_get_contents($wpconfig_path, true);

		return $config_file;
	}

	/**
	 *  Used to parse the wp-config.php file
	 *
	 *  @return null
	 */
	public static function tokenParser($wpconfig_path)
	{
		$defines = array();
		$wpconfig_file = @file_get_contents($wpconfig_path);

		if (!function_exists('token_get_all')) {
			DUPX_Log::info("\nNOTICE: PHP function 'token_get_all' does not exist so skipping WP_CONTENT_DIR and WP_CONTENT_URL processing.");
			return $defines;
		}

		if ($wpconfig_file === false) {
			return $defines;
		}

		$defines = array();
		$tokens	 = token_get_all($wpconfig_file);
		$token	 = reset($tokens);
		while ($token) {
			if (is_array($token)) {
				if ($token[0] == T_WHITESPACE || $token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
					// do nothing
				} else if ($token[0] == T_STRING && strtolower($token[1]) == 'define') {
					$state = 1;
				} else if ($state == 2 && self::isConstant($token[0])) {
					$key	 = $token[1];
					$state	 = 3;
				} else if ($state == 4 && self::isConstant($token[0])) {
					$value	 = $token[1];
					$state	 = 5;
				}
			} else {
				$symbol = trim($token);
				if ($symbol == '(' && $state == 1) {
					$state = 2;
				} else if ($symbol == ',' && $state == 3) {
					$state = 4;
				} else if ($symbol == ')' && $state == 5) {
					$defines[self::tokenStrip($key)] = self::tokenStrip($value);
					$state = 0;
				}
			}
			$token = next($tokens);
		}

		return $defines;
	}

	private static function tokenStrip($value)
	{
		return preg_replace('!^([\'"])(.*)\1$!', '$2', $value);
	}

	private static function customEscape($str)
    {
		return str_replace('\\', '\\\\', $str);
	}

	private static function isConstant($token)
	{
		return $token == T_CONSTANT_ENCAPSED_STRING || $token == T_STRING || $token == T_LNUMBER || $token == T_DNUMBER;
	}
}
?>
<?php

/**
 * Class used to update and edit web server configuration files
 *
 * Standard: PSR-2
 * @link http://www.php-fig.org/psr/psr-2 Full Documentation
 *
 * @package SC\DUPX\ServerConfig
 *
 */
class DUPX_ServerConfig
{

	/**
	 *  Clear .htaccess and web.config files and backup
	 *
	 *  @return null
	 */
	public static function reset()
	{


		DUPX_Log::info("\nWEB SERVER CONFIGURATION FILE RESET:");
		$timeStamp = date("ymdHis");

		//Apache
		@copy('.htaccess', ".htaccess.{$timeStamp}.orig");
		@unlink('.htaccess');
		@file_put_contents('.htaccess', "#Reset by Duplicator Installer.  Original can be found in .htaccess.{$timeStamp}.orig");

		//IIS
		@copy('web.config', "web.config.{$timeStamp}.orig");
		@unlink('web.config');
		$xml_contents  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$xml_contents .= "<!-- Reset by Duplicator Installer.  Original can be found in web.config.{$timeStamp}.orig -->\n";
		$xml_contents .=  "<configuration></configuration>\n";
		@file_put_contents('web.config', $xml_contents);

		//.user.ini - For WordFence
		@copy('.user.ini', ".user.ini.{$timeStamp}.orig");
		@unlink('.user.ini');

		DUPX_Log::info("- Backup of .htaccess/web.config made to *.{$timeStamp}.orig");
		DUPX_Log::info("- Reset of .htaccess/web.config files");
		
		
		@chmod('.htaccess', 0644);
	}

	/**
	 *  Resets the .htaccess file to a very slimed down version with new paths
	 *
	 *  @return null
	 */
	public static function setup($dbh)
	{
		if (!isset($_POST['url_new'])) {
			return;
		}

		DUPX_Log::info("\nWEB SERVER CONFIGURATION FILE BASIC SETUP:");
		$currdata	 = parse_url($_POST['url_old']);
		$newdata	 = parse_url($_POST['url_new']);
		$currpath	 = DUPX_U::addSlash(isset($currdata['path']) ? $currdata['path'] : "");
		$newpath	 = DUPX_U::addSlash(isset($newdata['path']) ? $newdata['path'] : "");
		$timestamp   = date("Y-m-d H:i:s");
		$update_msg  = "# This file was updated by Duplicator on {$timestamp}. See .htaccess.orig for the original .htaccess file.\n";
		$update_msg .= "# Please note that other plugins and resources write to this file. If the time-stamp above is different\n";
		$update_msg .= "# than the current time-stamp on the file system then another resource has updated this file.\n";
		$update_msg .= "# Duplicator only writes to this file once during the install process while running the installer.php file.\n";

		$empty_htaccess	 = false;
		$query_result	 = @mysqli_query($dbh, "SELECT option_value FROM `{$GLOBALS['FW_TABLEPREFIX']}options` WHERE option_name = 'permalink_structure' ");

		//If the permalink is set to Plain then don't update the rewrite rules
		if ($query_result) {
			$row = @mysqli_fetch_array($query_result);
			if ($row != null) {
				$permalink_structure = trim($row[0]);
				$empty_htaccess		 = empty($permalink_structure);
			}
		}

		if ($empty_htaccess) {
			$tmp_htaccess = "{$update_msg}";
			DUPX_Log::info("- No permalink structures set creating blank .htaccess file.");
		} else {
			$tmp_htaccess = <<<HTACCESS
{$update_msg}
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase {$newpath}
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . {$newpath}index.php [L]
</IfModule>
# END WordPress
HTACCESS;
				DUPX_Log::info("- Preparing .htaccess file with basic setup.");
			}

		file_put_contents('.htaccess', $tmp_htaccess);
		@chmod('.htaccess', 0644);
		DUPX_Log::info("Basic .htaccess file edit complete.  If using IIS web.config this process will need to be done manually.");

	}
}
?>
<?php

/**	 * *****************************************************
 *  CLASS::DUPX_Http
 *  Http Class Utility */
class DUPX_HTTP
{
	/**
	 *  Do an http post request with html form elements
	 *  @param string $url		A URL to post to
	 *  @param string $data		A valid key/pair combo $data = array('key1' => 'value1', 'key2' => 'value2')
	 * 							generated hidden form elements
	 *  @return string		    An html form that will automatically post itself
	 */
	public static function post_with_html($url, $data)
	{
		$id = uniqid();
		$html = "<form id='{$id}' method='post' action='{$url}' />\n";
		foreach ($data as $name => $value)
		{
			$html .= "<input type='hidden' name='{$name}' value='{$value}' />\n";
		}
		$html .= "</form>\n";
		$html .= "<script>$(document).ready(function() { $('#{$id}').submit(); });</script>";
		echo $html;
	}

	/**
	 *  Do an http post request with curl or php code
	 *  @param string $url		A URL to post to
	 *  @param string $params	A valid key/pair combo $data = array('key1' => 'value1', 'key2' => 'value2');
	 * 	@param string $headers	Optional header elements
	 *  @return a string or FALSE on failure.
	 */
	public static function post($url, $params = array(), $headers = null)
	{
		//PHP POST
		if (!function_exists('curl_init'))
		{
			return self::php_get_post($url, $params, $headers = null, 'POST');
		}

		//CURL POST
		$headers_on = isset($headers) && array_count_values($headers);
		$params = http_build_query($params);
		$ch = curl_init();

		// Return contents of transfer on curl_exec
		// Allow self-signed certs
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, $headers_on);

		if ($headers_on)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt($ch, CURLOPT_POST, count($params));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

	/**
	 *  Do an http post request with curl or php code
	 *  @param string $url		A URL to get.  If $params is not null then all query strings will be removed.
	 *  @param string $params	A valid key/pair combo $data = array('key1' => 'value1', 'key2' => 'value2');
	 * 	@param string $headers	Optional header elements
	 *  @return a string or FALSE on failure.
	 */
	public static function get($url, $params = array(), $headers = null)
	{
		//PHP GET
		if (!function_exists('curl_init'))
		{
			return self::php_get_post($url, $params, $headers = null, 'GET');
		}

		//Remove query string if $params are passed
		$full_url = $url;
		if (count($params))
		{
			$url = preg_replace('/\?.*/', '', $url);
			$full_url = $url . '?' . http_build_query($params);
		}
		$headers_on = isset($headers) && array_count_values($headers);
		$ch = curl_init();

		// Return contents of transfer on curl_exec
		// Allow self-signed certs
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_URL, $full_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, $headers_on);
		if ($headers_on)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

	/**
	 *  Gets the URL of the current request
	 *  @param bool $show_query		Include the query string in the URL
	 *  @return string	A URL
	 */
	public static function get_request_uri($show_query = true)
	{
		$isSecure = false;

		if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] == 443))
		{
			$isSecure = true;
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
		{
			$isSecure = true;
		}
		$protocol = $isSecure ? 'https' : 'http';
		$url = "{$protocol}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$url = ($show_query) ? $url : preg_replace('/\?.*/', '', $url);
		return $url;
	}

	/**
	 *  Check to see if the internet is accessible
	 *  @param string $url		A URL e.g without prefix "ajax.googleapis.com"
	 *  @param string $port		A valid port number
	 *  @return bool
	 */
	public static function is_url_active($url, $port, $timeout = 5)
	{
		if (function_exists('fsockopen'))
		{
			$port = isset($port) && is_integer($port) ? $port : 80;
			$connected = @fsockopen($url, $port, $errno, $errstr, $timeout); //website and port
			if ($connected)
			{
				$is_conn = true;
				@fclose($connected);
			}
			else
			{
				$is_conn = false;
			}
			return $is_conn;
		}
		else
		{
			return false;
		}
	}

	public static function parse_host($url)
	{
		$url = parse_url(trim($url));
		if ($url == false)
		{
			return null;
		}
		return trim($url['host'] ? $url['host'] : array_shift(explode('/', $url['path'], 2)));
	}

	//PHP POST or GET requets
	private static function php_get_post($url, $params, $headers = null, $method)
	{
		$full_url = $url;
		if ($method == 'GET' && count($params))
		{
			$url = preg_replace('/\?.*/', '', $url);
			$full_url = $url . '?' . http_build_query($params);
		}

		$data = array('http' => array(
				'method' => $method,
				'content' => http_build_query($params)));

		if ($headers !== null)
		{
			$data['http']['header'] = $headers;
		}
		$ctx = stream_context_create($data);
		$fp = @fopen($full_url, 'rb', false, $ctx);
		if (!$fp)
		{
			throw new Exception("Problem with $full_url, $php_errormsg");
		}
		$response = @stream_get_contents($fp);
		if ($response === false)
		{
			throw new Exception("Problem reading data from $full_url, $php_errormsg");
		}
		return $response;
	}

}
?>

<?php
#
# Portable PHP password hashing framework.
#
# Version 0.5 / genuine.
#
# Written by Solar Designer <solar at openwall.com> in 2004-2006 and placed in
# the public domain.  Revised in subsequent years, still public domain.
#
# There's absolutely no warranty.
#
# The homepage URL for this framework is:
#
#	http://www.openwall.com/phpass/
#
# Please be sure to update the Version line if you edit this file in any way.
# It is suggested that you leave the main version number intact, but indicate
# your project name (after the slash) and add your own revision information.
#
# Please do not change the "private" password hashing method implemented in
# here, thereby making your hashes incompatible.  However, if you must, please
# change the hash type identifier (the "$P$") to something different.
#
# Obviously, since this code is in the public domain, the above are not
# requirements (there can be none), but merely suggestions.
#
class DUPX_PasswordHash
{

	var $itoa64;
	var $iteration_count_log2;
	var $portable_hashes;
	var $random_state;

	function __construct($iteration_count_log2, $portable_hashes)
	{
		$this->itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
			$iteration_count_log2 = 8;
		$this->iteration_count_log2 = $iteration_count_log2;

		$this->portable_hashes = $portable_hashes;

		$this->random_state = microtime();
		if (function_exists('getmypid'))
			$this->random_state .= getmypid();
	}

	function PasswordHash($iteration_count_log2, $portable_hashes)
	{
		self::__construct($iteration_count_log2, $portable_hashes);
	}

	function get_random_bytes($count)
	{
		$output = '';
		if (@is_readable('/dev/urandom') &&
		    ($fh = @fopen('/dev/urandom', 'rb'))) {
			$output = fread($fh, $count);
			fclose($fh);
		}

		if (strlen($output) < $count) {
			$output = '';
			for ($i = 0; $i < $count; $i += 16) {
				$this->random_state =
				    md5(microtime() . $this->random_state);
				$output .= md5($this->random_state, TRUE);
			}
			$output = substr($output, 0, $count);
		}

		return $output;
	}

	function encode64($input, $count)
	{
		$output = '';
		$i = 0;
		do {
			$value = ord($input[$i++]);
			$output .= $this->itoa64[$value & 0x3f];
			if ($i < $count)
				$value |= ord($input[$i]) << 8;
			$output .= $this->itoa64[($value >> 6) & 0x3f];
			if ($i++ >= $count)
				break;
			if ($i < $count)
				$value |= ord($input[$i]) << 16;
			$output .= $this->itoa64[($value >> 12) & 0x3f];
			if ($i++ >= $count)
				break;
			$output .= $this->itoa64[($value >> 18) & 0x3f];
		} while ($i < $count);

		return $output;
	}

	function gensalt_private($input)
	{
		$output = '$P$';
		$output .= $this->itoa64[min($this->iteration_count_log2 +
			((PHP_VERSION >= '5') ? 5 : 3), 30)];
		$output .= $this->encode64($input, 6);

		return $output;
	}

	function crypt_private($password, $setting)
	{
		$output = '*0';
		if (substr($setting, 0, 2) === $output)
			$output = '*1';

		$id = substr($setting, 0, 3);
		# We use "$P$", phpBB3 uses "$H$" for the same thing
		if ($id !== '$P$' && $id !== '$H$')
			return $output;

		$count_log2 = strpos($this->itoa64, $setting[3]);
		if ($count_log2 < 7 || $count_log2 > 30)
			return $output;

		$count = 1 << $count_log2;

		$salt = substr($setting, 4, 8);
		if (strlen($salt) !== 8)
			return $output;

		# We were kind of forced to use MD5 here since it's the only
		# cryptographic primitive that was available in all versions
		# of PHP in use.  To implement our own low-level crypto in PHP
		# would have resulted in much worse performance and
		# consequently in lower iteration counts and hashes that are
		# quicker to crack (by non-PHP code).
		$hash = md5($salt . $password, TRUE);
		do {
			$hash = md5($hash . $password, TRUE);
		} while (--$count);

		$output = substr($setting, 0, 12);
		$output .= $this->encode64($hash, 16);

		return $output;
	}

	function gensalt_blowfish($input)
	{
		# This one needs to use a different order of characters and a
		# different encoding scheme from the one in encode64() above.
		# We care because the last character in our encoded string will
		# only represent 2 bits.  While two known implementations of
		# bcrypt will happily accept and correct a salt string which
		# has the 4 unused bits set to non-zero, we do not want to take
		# chances and we also do not want to waste an additional byte
		# of entropy.
		$itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		$output = '$2a$';
		$output .= chr(ord('0') + $this->iteration_count_log2 / 10);
		$output .= chr(ord('0') + $this->iteration_count_log2 % 10);
		$output .= '$';

		$i = 0;
		do {
			$c1 = ord($input[$i++]);
			$output .= $itoa64[$c1 >> 2];
			$c1 = ($c1 & 0x03) << 4;
			if ($i >= 16) {
				$output .= $itoa64[$c1];
				break;
			}

			$c2 = ord($input[$i++]);
			$c1 |= $c2 >> 4;
			$output .= $itoa64[$c1];
			$c1 = ($c2 & 0x0f) << 2;

			$c2 = ord($input[$i++]);
			$c1 |= $c2 >> 6;
			$output .= $itoa64[$c1];
			$output .= $itoa64[$c2 & 0x3f];
		} while (1);

		return $output;
	}

	function HashPassword($password)
	{
		$random = '';

		if (CRYPT_BLOWFISH === 1 && !$this->portable_hashes) {
			$random = $this->get_random_bytes(16);
			$hash =
			    crypt($password, $this->gensalt_blowfish($random));
			if (strlen($hash) === 60)
				return $hash;
		}

		if (strlen($random) < 6)
			$random = $this->get_random_bytes(6);
		$hash =
		    $this->crypt_private($password,
		    $this->gensalt_private($random));
		if (strlen($hash) === 34)
			return $hash;

		# Returning '*' on error is safe here, but would _not_ be safe
		# in a crypt(3)-like function used _both_ for generating new
		# hashes and for validating passwords against existing hashes.
		return '*';
	}

	function CheckPassword($password, $stored_hash)
	{
		$hash = $this->crypt_private($password, $stored_hash);
		if ($hash[0] === '*')
			$hash = crypt($password, $stored_hash);

		# This is not constant-time.  In order to keep the code simple,
		# for timing safety we currently rely on the salts being
		# unpredictable, which they are at least in the non-fallback
		# cases (that is, when we use /dev/urandom and bcrypt).
		return $hash === $stored_hash;
	}
}

?>

<?php
if (isset($_POST['action_ajax'])) :

	if ($GLOBALS['FW_SECUREON']) {
		$pass_hasher = new DUPX_PasswordHash(8, FALSE);
		$pass_check  = $pass_hasher->CheckPassword(base64_encode($_POST['secure-pass']), $GLOBALS['FW_SECUREPASS']);
		if (! $pass_check) {
			die("Unauthorized Access:  Please provide a password!");
		}
	}

	//Alternative control switch structer will not work in this case
	//see: http://php.net/manual/en/control-structures.alternative-syntax.php
	//Some clients will create double spaces such as the FTP client which
	//will break example found online
	switch ($_POST['action_ajax']) :

		case "1": ?><?php

//POST PARAMS
$_POST['archive_name']		 = isset($_POST['archive_name']) ? $_POST['archive_name'] : null;
$_POST['archive_engine']	 = isset($_POST['archive_engine']) ? $_POST['archive_engine']  : 'manual';
$_POST['archive_filetime']	 = (isset($_POST['archive_filetime'])) ? $_POST['archive_filetime'] : 'current';
$_POST['retain_config']		 = (isset($_POST['retain_config']) && $_POST['retain_config'] == '1') ? true : false;
$_POST['exe_safe_mode']          = (isset($_POST['exe_safe_mode'])) ? $_POST['exe_safe_mode'] : 0;
//LOGGING
$POST_LOG = $_POST;
unset($POST_LOG['dbpass']);
ksort($POST_LOG);

//PAGE VARS
$php_max_time   = @ini_get("max_execution_time");
$php_max_time   = ($php_max_time == 0) ? "[0] time limit restriction disabled" : "[{$php_max_time}] time limit restriction enabled";
$root_path		 = DUPX_U::setSafePath($GLOBALS['CURRENT_ROOT_PATH']);
$package_path	 = "{$root_path}/{$_POST['archive_name']}";
$ajax1_start	 = DUPX_U::getMicrotime();
$zip_support	 = class_exists('ZipArchive') ? 'Enabled' : 'Not Enabled';
$JSON			 = array();
$JSON['pass']	 = 0;

/** JSON RESPONSE: Most sites have warnings turned off by default, but if they're turned on the warnings
  cause errors in the JSON data Here we hide the status so warning level is reset at it at the end */
if (!headers_sent())  {
	header('Content-Type: application/json');
}
$ajax1_error_level = error_reporting();
error_reporting(E_ERROR);

//===============================
//ERROR MESSAGES
//===============================
($GLOBALS['LOG_FILE_HANDLE'] != false) or DUPX_Log::error(ERR_MAKELOG);

if (!$GLOBALS['FW_ARCHIVE_ONLYDB']) {
	//ERR_ZIPMANUAL
	if ($_POST['archive_engine'] == 'manual') {
		if (!file_exists("wp-config.php") && !file_exists("database.sql")) {
			DUPX_Log::error(ERR_ZIPMANUAL);
		}
	} else {
		//ERR_CONFIG_FOUND
		(!file_exists('wp-config.php'))
			or DUPX_Log::error(ERR_CONFIG_FOUND);
		//ERR_ZIPNOTFOUND
		(is_readable("{$package_path}"))
			or DUPX_Log::error(ERR_ZIPNOTFOUND);
	}
}



DUPX_Log::info("********************************************************************************");
DUPX_Log::info('* DUPLICATOR-LITE: INSTALL-LOG');
DUPX_Log::info("* VERSION: {$GLOBALS['FW_DUPLICATOR_VERSION']}");
DUPX_Log::info('* STEP-1 START @ '.@date('h:i:s'));
DUPX_Log::info('* NOTICE: Do NOT post this data to public sites or forums');
DUPX_Log::info("********************************************************************************");
DUPX_Log::info("PHP VERSION:\t".phpversion().' | SAPI: '.php_sapi_name());
DUPX_Log::info("PHP TIME LIMIT:\t{$php_max_time}");
DUPX_Log::info("PHP MEMORY:\t".$GLOBALS['PHP_MEMORY_LIMIT'].' | SUHOSIN: '.$GLOBALS['PHP_SUHOSIN_ON']);
DUPX_Log::info("SERVER:\t\t{$_SERVER['SERVER_SOFTWARE']}");
DUPX_Log::info("DOC ROOT:\t{$root_path}");
DUPX_Log::info("DOC ROOT 755:\t".var_export($GLOBALS['CHOWN_ROOT_PATH'], true));
DUPX_Log::info("LOG FILE 644:\t".var_export($GLOBALS['CHOWN_LOG_PATH'], true));
DUPX_Log::info("REQUEST URL:\t{$GLOBALS['URL_PATH']}");
DUPX_Log::info("SAFE MODE :\t{$_POST['exe_safe_mode']}");

$log = "--------------------------------------\n";
$log .= "POST DATA\n";
$log .= "--------------------------------------\n";
$log .= print_r($POST_LOG, true);
DUPX_Log::info($log, 2);

$log = "--------------------------------------\n";
$log .= "ARCHIVE EXTRACTION\n";
$log .= "--------------------------------------\n";
$log .= "NAME:\t{$_POST['archive_name']}\n";
$log .= "SIZE:\t".DUPX_U::readableByteSize(@filesize($_POST['archive_name']))."\n";
$log .= "ZIP:\t{$zip_support} (ZipArchive Support)";
DUPX_Log::info($log);


if ($_POST['archive_engine'] == 'manual') {
	DUPX_Log::info("\n** PACKAGE EXTRACTION IS IN MANUAL MODE ** \n");
} else {
	if ($GLOBALS['FW_PACKAGE_NAME'] != $_POST['archive_name']) {
		$log = "\n--------------------------------------\n";
		$log .= "WARNING: This package set may be incompatible!  \nBelow is a summary of the package this installer was built with and the package used. \n";
		$log .= "To guarantee accuracy the installer and archive should match. For details see the online FAQs.";
		$log .= "\nCREATED WITH:\t{$GLOBALS['FW_PACKAGE_NAME']} \nPROCESSED WITH:\t{$_POST['archive_name']}  \n";
		$log .= "--------------------------------------\n";
		DUPX_Log::info($log);
	}

	if (!class_exists('ZipArchive')) {
		DUPX_Log::info("ERROR: Stopping install process.  Trying to extract without ZipArchive module installed.  Please use the 'Manual Package extraction' mode to extract zip file.");
		DUPX_Log::error(ERR_ZIPARCHIVE);
	}

	$target	 = $root_path;
	$zip	 = new ZipArchive();
	if ($zip->open($_POST['archive_name']) === TRUE) {

		DUPX_Log::info("\n>>> START EXTRACTION:");
		if (!$zip->extractTo($target)) {
			DUPX_Log::error(ERR_ZIPEXTRACTION);
		}
		$log = print_r($zip, true);

		//Keep original timestamp on the file
		if ($_POST['archive_filetime'] == 'original') {
			$log .= "File timestamp is 'Original' mode.\n";
			for ($idx = 0; $s = $zip->statIndex($idx); $idx++) {
				touch($target.DIRECTORY_SEPARATOR.$s['name'], $s['mtime']);
			}
		} else {
			$now = date("Y-m-d H:i:s");
			$log .= "File timestamp is 'Current' mode: {$now}\n";
		}

		$close_response = $zip->close();
		$log .= "<<< EXTRACTION COMPLETE: " . var_export($close_response, true);
		DUPX_Log::info($log);
	} else {
		DUPX_Log::error(ERR_ZIPOPEN);
	}
}

//===============================
//RESET SERVER CONFIG FILES
//===============================
if ($_POST['retain_config']) {
	DUPX_Log::info("\nNOTICE: Manual update of permalinks required see:  Admin > Settings > Permalinks > Click Save Changes");
	DUPX_Log::info("Retaining the original htaccess, user.ini or web.config files may cause issues with the setup of this site.");
	DUPX_Log::info("If you run into issues during or after the install process please uncheck the 'Config Files' checkbox labeled:");
	DUPX_Log::info("'Retain original .htaccess, .user.ini and web.config' from Step 1 and re-run the installer. Backups of the");
	DUPX_Log::info("orginal config files will be made and can be merged per required directive.");
} else {
	DUPX_ServerConfig::reset();
}


//FINAL RESULTS
$ajax1_end	 = DUPX_U::getMicrotime();
$ajax1_sum	 = DUPX_U::elapsedTime($ajax1_end, $ajax1_start);
DUPX_Log::info("\nSTEP-1 COMPLETE @ " . @date('h:i:s') . " - RUNTIME: {$ajax1_sum}");


$JSON['pass'] = 1;
echo json_encode($JSON);
error_reporting($ajax1_error_level);
die('');
?><?php break;

		case "2": ?><?php
//POST PARAMS
$_POST['dbaction']			= isset($_POST['dbaction'])  ? $_POST['dbaction'] : 'create';
$_POST['dbhost']			= isset($_POST['dbhost'])    ? DUPX_U::sanitize(trim($_POST['dbhost'])) : null;
$_POST['dbname']			= isset($_POST['dbname'])    ? trim($_POST['dbname']) : null;
$_POST['dbuser']			= isset($_POST['dbuser'])    ? $_POST['dbuser'] : null;
$_POST['dbpass']			= isset($_POST['dbpass'])    ? $_POST['dbpass'] : null;
$_POST['dbcharset']			= isset($_POST['dbcharset']) ? DUPX_U::sanitize(trim($_POST['dbcharset'])) : $GLOBALS['DBCHARSET_DEFAULT'];
$_POST['dbcollate']			= isset($_POST['dbcollate']) ? DUPX_U::sanitize(trim($_POST['dbcollate'])) : $GLOBALS['DBCOLLATE_DEFAULT'];
$_POST['dbnbsp']			= (isset($_POST['dbnbsp']) && $_POST['dbnbsp'] == '1') ? true : false;
$_POST['ssl_admin']			= (isset($_POST['ssl_admin']))  ? true : false;
$_POST['cache_wp']			= (isset($_POST['cache_wp']))   ? true : false;
$_POST['cache_path']		= (isset($_POST['cache_path'])) ? true : false;
$_POST['archive_name']		= isset($_POST['archive_name']) ? $_POST['archive_name'] : null;
$_POST['retain_config']		= (isset($_POST['retain_config']) && $_POST['retain_config'] == '1') ? true : false;
$_POST['dbcollatefb']       = isset($_POST['dbcollatefb']) ? $_POST['dbcollatefb'] : false;

//LOGGING
$POST_LOG = $_POST;
unset($POST_LOG['dbpass']);
ksort($POST_LOG);

//PAGE VARS
$date_time      = @date('h:i:s');
$root_path		= DUPX_U::setSafePath($GLOBALS['CURRENT_ROOT_PATH']);
$ajax2_start	= DUPX_U::getMicrotime();
$JSON = array();
$JSON['pass'] = 0;

/** JSON RESPONSE: Most sites have warnings turned off by default, but if they're turned on the warnings
cause errors in the JSON data Here we hide the status so warning level is reset at it at the end*/
$ajax1_error_level = error_reporting();
error_reporting(E_ERROR);

//====================================================================================================
//DATABASE TEST CONNECTION
//====================================================================================================
if (isset($_GET['dbtest']))
{
	$html     = "";
	$baseport =  parse_url($_POST['dbhost'], PHP_URL_PORT);
	$dbConn   = DUPX_DB::connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], null, $_POST['dbport']);
	$dbErr	  = mysqli_connect_error();

	$dbFound  = mysqli_select_db($dbConn, $_POST['dbname']);
	$port_view = (is_int($baseport) || substr($_POST['dbhost'], -1) == ":") ? "Port=[Set in Host]" : "Port={$_POST['dbport']}";

	$tstSrv   = ($dbConn)  ? "<div class='dupx-pass'>Success</div>" : "<div class='dupx-fail'>Fail</div>";
	$tstDB    = ($dbFound) ? "<div class='dupx-pass'>Success</div>" : "<div class='dupx-fail'>Fail</div>";

    $dbversion_info         = DUPX_DB::getServerInfo($dbConn);
    $dbversion_info         = empty($dbversion_info) ? 'no connection' : $dbversion_info;
    $dbversion_info_fail    = $dbConn && version_compare(DUPX_DB::getVersion($dbConn), '5.5.3') < 0;

    $dbversion_compat       = DUPX_DB::getVersion($dbConn);
	$dbversion_compat       = empty($dbversion_compat) ? 'no connection' : $dbversion_compat;
    $dbversion_compat_fail  = $dbConn && version_compare($dbversion_compat, $GLOBALS['FW_VERSION_DB']) < 0;

    $tstInfo = ($dbversion_info_fail)
		? "<div class='dupx-notice'>{$dbversion_info}</div>"
        : "<div class='dupx-pass'>{$dbversion_info}</div>";

	$tstCompat = ($dbversion_compat_fail)
		? "<div class='dupx-notice'>This Server: [{$dbversion_compat}] -- Package Server: [{$GLOBALS['FW_VERSION_DB']}]</div>"
		: "<div class='dupx-pass'>This Server: [{$dbversion_compat}] -- Package Server: [{$GLOBALS['FW_VERSION_DB']}]</div>";

	$html	 .= <<<DATA
	<div class='s2-db-test'>
		<small>
			Using Connection String:<br/>
			Host={$_POST['dbhost']}; Database={$_POST['dbname']}; Uid={$_POST['dbuser']}; Pwd={$_POST['dbpass']}; {$port_view}
		</small>
		<table class='s2-db-test-dtls'>
			<tr>
				<td>Host:</td>
				<td>{$tstSrv}</td>
			</tr>
			<tr>
				<td>Database:</td>
				<td>{$tstDB}</td>
			</tr>
			<tr>
				<td>Version:</td>
				<td>{$tstInfo}</td>
			</tr>
            <tr>
				<td>Compatibility:</td>
				<td>{$tstCompat}</td>
			</tr>
		</table>
DATA;

	//--------------------------------
	//WARNING: Unable to connect
	$html .=  (!$dbConn ||  !$dbFound)
		? "<div class='warn-msg'>" . ERR_DBCONNECT_INFO .  "</div>"
		: '';

	//WARNING: DB has tables with create option
	if ($_POST['dbaction'] == 'create')
	{
		$tblcount = DUPX_DB::countTables($dbConn, $_POST['dbname']);
		$html .= ($tblcount > 0)
			? "<div class='warn-msg'><b>WARNING:</b> " . sprintf(ERR_DBEMPTY, $_POST['dbname'], $tblcount) . "</div>"
			: '';
	}

	//WARNNG: Input has utf8
	$dbConnItems = array($_POST['dbhost'], $_POST['dbuser'], $_POST['dbname'],$_POST['dbpass']);
	$dbUTF8_tst  = false;
	foreach ($dbConnItems as $value) {
		if (DUPX_U::isNonASCII($value)) {
			$dbUTF8_tst = true;
			break;
		}
	}

    //WARNING: UTF8 Data in Connection String
	$html .=  (!$dbConn && $dbUTF8_tst)
		? "<div class='warn-msg'><b>WARNING:</b> " . ERR_TESTDB_UTF8 .  "</div>"
		: '';

	//NOTICE: Version Too Low
	$html .=  ($dbversion_info_fail)
		? "<div class='warn-msg'><b>NOTICE:</b> " . ERR_TESTDB_VERSION_INFO . "</div>"
		: '';

    //NOTICE: Version Incompatibility
	$html .=  ($dbversion_compat_fail)
		? "<div class='warn-msg'><b>NOTICE:</b> " . ERR_TESTDB_VERSION_COMPAT . "</div>"
		: '';

	$html .= "</div>";
	die($html);
}

//===============================
//ERROR MESSAGES
//===============================

//ERR_MAKELOG
($GLOBALS['LOG_FILE_HANDLE'] != false) or DUPX_Log::error(ERR_MAKELOG);

//ERR_MYSQLI_SUPPORT
function_exists('mysqli_connect') or DUPX_Log::error(ERR_MYSQLI_SUPPORT);

//ERR_DBCONNECT
$dbh = DUPX_DB::connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], null, $_POST['dbport']);
@mysqli_query($dbh, "SET wait_timeout = {$GLOBALS['DB_MAX_TIME']}");
($dbh) or DUPX_Log::error(ERR_DBCONNECT . mysqli_connect_error());
if ($_POST['dbaction'] == 'empty') {
	mysqli_select_db($dbh, $_POST['dbname']) or DUPX_Log::error(sprintf(ERR_DBCREATE, $_POST['dbname']));
}
//ERR_DBEMPTY
if ($_POST['dbaction'] == 'create' ) {
	$tblcount = DUPX_DB::countTables($dbh, $_POST['dbname']);
	if ($tblcount > 0) {
		DUPX_Log::error(sprintf(ERR_DBEMPTY, $_POST['dbname'], $tblcount));
	}
}



$log = <<<LOG
\n\n********************************************************************************
* DUPLICATOR-LITE: INSTALL-LOG
* STEP-2 START @ {$date_time}
* NOTICE: Do NOT post to public sites or forums
********************************************************************************
LOG;
DUPX_Log::info($log);

$log  = "--------------------------------------\n";
$log .= "POST DATA\n";
$log .= "--------------------------------------\n";
$log .= print_r($POST_LOG, true);
DUPX_Log::info($log, 2);


//====================================================================================================
//DATABASE ROUTINES
//====================================================================================================
$log = '';
$faq_url = $GLOBALS['FAQ_URL'];
$utm_prefix = '?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=';
$db_file_size = filesize('database.sql');
$php_mem = $GLOBALS['PHP_MEMORY_LIMIT'];
$php_mem_range = DUPX_U::getBytes($GLOBALS['PHP_MEMORY_LIMIT']);
$php_mem_range = $php_mem_range == null ?  0 : $php_mem_range - 5000000; //5 MB Buffer

//Fatal Memory errors from file_get_contents is not catchable.
//Try to warn ahead of time with a buffer in memory difference
if ($db_file_size >= $php_mem_range  && $php_mem_range != 0)
{
	$db_file_size = DUPX_U::readableByteSize($db_file_size);
	$msg = "\nWARNING: The database script is '{$db_file_size}' in size.  The PHP memory allocation is set\n";
	$msg .= "at '{$php_mem}'.  There is a high possibility that the installer script will fail with\n";
	$msg .= "a memory allocation error when trying to load the database.sql file.  It is\n";
	$msg .= "recommended to increase the 'memory_limit' setting in the php.ini config file.\n";
    $msg .= "see: {$faq_url}{$utm_prefix}inst_step2_lgdbscript#faq-trouble-056-q \n";
	DUPX_Log::info($msg);
}

@chmod("{$root_path}/database.sql", 0777);
$sql_file = file_get_contents('database.sql', true);

//ERROR: Reading database.sql file
if ($sql_file === FALSE || strlen($sql_file) < 10)
{
	$msg = "<b>Unable to read the database.sql file from the archive.  Please check these items:</b> <br/>";
	$msg .= "1. Validate permissions and/or group-owner rights on these items: <br/>";
	$msg .= " - File: database.sql <br/> - Directory: [{$root_path}] <br/>";
    $msg .= "<i>see: <a href='{$faq_url}{$utm_prefix}inst_step2_dbperms#faq-trouble-055-q' target='_blank'>{$faq_url}#faq-trouble-055-q</a></i> <br/>";
	$msg .= "2. Validate the database.sql file exists and is in the root of the archive.zip file <br/>";
	$msg .= "<i>see: <a href='{$faq_url}{$utm_prefix}inst_step2_sqlroot#faq-installer-020-q' target='_blank'>{$faq_url}#faq-installer-020-q</a></i> <br/>";
	DUPX_Log::error($msg);
}

//Removes invalid space characters
//Complex Subject See: http://webcollab.sourceforge.net/unicode.html
if ($_POST['dbnbsp'])
{
	DUPX_Log::info("NOTICE: Ran fix non-breaking space characters\n");
	$sql_file = preg_replace('/\xC2\xA0/', ' ', $sql_file);
}

//Write new contents to install-data.sql
$sql_file_copy_status   = file_put_contents($GLOBALS['SQL_FILE_NAME'], $sql_file);
$sql_result_file_data	= explode(";\n", $sql_file);
$sql_result_file_length = count($sql_result_file_data);
$sql_result_file_path	= "{$root_path}/{$GLOBALS['SQL_FILE_NAME']}";
$sql_file = null;
$db_collatefb_log = '';

if($_POST['dbcollatefb']){
    $supportedCollations = DUPX_DB::getSupportedCollationsList($dbh);
    $collation_arr = array(
        'utf8mb4_unicode_520_ci',
        'utf8mb4_unicode_520',
        'utf8mb4_unicode_ci',
        'utf8mb4',
        'utf8_unicode_520_ci',
        'utf8_unicode_520',
        'utf8_unicode_ci',
        'utf8'
    );
    $latest_supported_collation = '';
    $latest_supported_index = -1;

    foreach ($collation_arr as $key => $val){
        if(in_array($val,$supportedCollations)){
            $latest_supported_collation = $val;
            $latest_supported_index = $key;
            break;
        }
    }

	//No need to replace if current DB is up to date
    if($latest_supported_index != 0){
        for($i=0; $i < $latest_supported_index; $i++){
            foreach ($sql_result_file_data as $index => $col_sql_query){
                if(strpos($col_sql_query,$collation_arr[$i]) !== false){
                    $sql_result_file_data[$index] = str_replace($collation_arr[$i], $latest_supported_collation, $col_sql_query);
                    if(strpos($collation_arr[$i],'utf8mb4') !== false && strpos($latest_supported_collation,'utf8mb4') === false){
                        $sql_result_file_data[$index] = str_replace('utf8mb4','utf8',$sql_result_file_data[$index]);
                    }
					$sub_query = str_replace("\n", '', substr($col_sql_query, 0, 75));
                    $db_collatefb_log .= "   - Collation '{$collation_arr[$i]}' set to '{$latest_supported_collation}' on query [{$sub_query}...]\n";
                }
            }
        }
    }
}

//WARNING: Create installer-data.sql failed
if ($sql_file_copy_status === FALSE || filesize($sql_result_file_path) == 0 || !is_readable($sql_result_file_path))
{
	$sql_file_size = DUPX_U::readableByteSize(filesize('database.sql'));
	$msg  = "\nWARNING: Unable to properly copy database.sql ({$sql_file_size}) to {$GLOBALS['SQL_FILE_NAME']}.  Please check these items:\n";
	$msg .= "- Validate permissions and/or group-owner rights on database.sql and directory [{$root_path}] \n";
	$msg .= "- see: {$faq_url}{$utm_prefix}inst_step2_copydbsql#faq-trouble-055-q \n";
	DUPX_Log::info($msg);
}

//=================================
//START DB RUN
@mysqli_query($dbh, "SET wait_timeout = {$GLOBALS['DB_MAX_TIME']}");
@mysqli_query($dbh, "SET max_allowed_packet = {$GLOBALS['DB_MAX_PACKETS']}");
DUPX_DB::setCharset($dbh, $_POST['dbcharset'], $_POST['dbcollate']);

//Will set mode to null only for this db handle session
//sql_mode can cause db create issues on some systems
$qry_session_custom = true;
switch ($_POST['dbmysqlmode']) {
	case 'DISABLE':
		@mysqli_query($dbh, "SET SESSION sql_mode = ''");
		break;
	case 'CUSTOM':
		$dbmysqlmode_opts	 = $_POST['dbmysqlmode_opts'];
		$qry_session_custom	 = @mysqli_query($dbh, "SET SESSION sql_mode = '{$dbmysqlmode_opts}'");
		if ($qry_session_custom == false) {
			$sql_error	 = mysqli_error($dbh);
			$log		 = "WARNING: Trying to set a custom sql_mode setting issue has been detected:\n{$sql_error}.\n";
			$log		 .= "For more details visit: http://dev.mysql.com/doc/refman/5.7/en/sql-mode.html\n";
		}
		break;
}

//Set defaults in-case the variable could not be read
$dbvar_maxtime		= DUPX_DB::getVariable($dbh, 'wait_timeout');
$dbvar_maxpacks		= DUPX_DB::getVariable($dbh, 'max_allowed_packet');
$dbvar_sqlmode		= DUPX_DB::getVariable($dbh, 'sql_mode');
$dbvar_maxtime		= is_null($dbvar_maxtime) ? 300 : $dbvar_maxtime;
$dbvar_maxpacks		= is_null($dbvar_maxpacks) ? 1048576 : $dbvar_maxpacks;
$dbvar_sqlmode		= empty($dbvar_sqlmode) ? 'NOT_SET'  : $dbvar_sqlmode;
$dbvar_version		= DUPX_DB::getVersion($dbh);
$sql_file_size1		= DUPX_U::readableByteSize(@filesize("database.sql"));
$sql_file_size2		= DUPX_U::readableByteSize(@filesize("{$GLOBALS['SQL_FILE_NAME']}"));
$db_collatefb		= isset($_POST['dbcollatefb']) ? 'On' : 'Off';


DUPX_Log::info("--------------------------------------");
DUPX_Log::info("DATABASE ENVIRONMENT");
DUPX_Log::info("--------------------------------------");
DUPX_Log::info("MYSQL VERSION:\tThis Server: {$dbvar_version} -- Build Server: {$GLOBALS['FW_VERSION_DB']}");
DUPX_Log::info("FILE SIZE:\tdatabase.sql ({$sql_file_size1}) - installer-data.sql ({$sql_file_size2})");
DUPX_Log::info("TIMEOUT:\t{$dbvar_maxtime}");
DUPX_Log::info("MAXPACK:\t{$dbvar_maxpacks}");
DUPX_Log::info("SQLMODE:\t{$dbvar_sqlmode}");
DUPX_Log::info("NEW SQL FILE:\t[{$sql_result_file_path}]");
DUPX_Log::info("COLLATE RESET:\t{$db_collatefb}\n{$db_collatefb_log}");

if ($qry_session_custom == false) {
	DUPX_Log::info("\n{$log}\n");
}

//CREATE DB
switch ($_POST['dbaction']) {
	case "create":
		mysqli_query($dbh, "CREATE DATABASE IF NOT EXISTS `{$_POST['dbname']}`");
		mysqli_select_db($dbh, $_POST['dbname'])
		or DUPX_Log::error(sprintf(ERR_DBCONNECT_CREATE, $_POST['dbname']));
		break;
	case "empty":
		//DROP DB TABLES
		$drop_log = "Database already empty. Ready for install.";
		$sql = "SHOW FULL TABLES WHERE Table_Type != 'VIEW'";
		$found_tables = null;
		if ($result = mysqli_query($dbh, $sql)) {
			while ($row = mysqli_fetch_row($result)) {
				$found_tables[] = $row[0];
			}
			if (count($found_tables) > 0) {
				foreach ($found_tables as $table_name) {
					$sql = "DROP TABLE `{$_POST['dbname']}`.`{$table_name}`";
					if (!$result = mysqli_query($dbh, $sql)) {
						DUPX_Log::error(sprintf(ERR_DBTRYCLEAN, $_POST['dbname']));
					}
				}
			}
			$drop_log = count($found_tables);
		}
		break;
}


//WRITE DATA
DUPX_Log::info("--------------------------------------");
DUPX_Log::info("DATABASE RESULTS");
DUPX_Log::info("--------------------------------------");
$profile_start = DUPX_U::getMicrotime();
$fcgi_buffer_pool = 5000;
$fcgi_buffer_count = 0;
$dbquery_rows = 0;
$dbtable_rows = 1;
$dbquery_errs = 0;
$counter = 0;
@mysqli_autocommit($dbh, false);

while ($counter < $sql_result_file_length) {

	$query_strlen = strlen(trim($sql_result_file_data[$counter]));

	if ($dbvar_maxpacks < $query_strlen) {

		DUPX_Log::info("**ERROR** Query size limit [length={$query_strlen}] [sql=" . substr($sql_result_file_data[$counter], 0, 75) . "...]");
		$dbquery_errs++;

	} elseif ($query_strlen > 0) {

		@mysqli_free_result(@mysqli_query($dbh, ($sql_result_file_data[$counter])));
		$err = mysqli_error($dbh);

		//Check to make sure the connection is alive
		if (!empty($err)) {

			if (!mysqli_ping($dbh)) {
				mysqli_close($dbh);
				$dbh = DUPX_DB::connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], $_POST['dbname'], $_POST['dbport'] );
				// Reset session setup
				@mysqli_query($dbh, "SET wait_timeout = {$GLOBALS['DB_MAX_TIME']}");
				DUPX_DB::setCharset($dbh, $_POST['dbcharset'], $_POST['dbcollate']);
			}
			DUPX_Log::info("**ERROR** database error write '{$err}' - [sql=" . substr($sql_result_file_data[$counter], 0, 75) . "...]");
			$dbquery_errs++;

		//Buffer data to browser to keep connection open
		} else {
			if ($GLOBALS['DB_FCGI_FLUSH'] && $fcgi_buffer_count++ > $fcgi_buffer_pool) {
				$fcgi_buffer_count = 0;
				DUPX_U::fcgiFlush();
			}
			$dbquery_rows++;
		}
	}
	$counter++;
}
@mysqli_commit($dbh);
@mysqli_autocommit($dbh, true);

DUPX_Log::info("ERRORS FOUND:\t{$dbquery_errs}");
DUPX_Log::info("TABLES DROPPED:\t{$drop_log}");
DUPX_Log::info("QUERIES RAN:\t{$dbquery_rows}\n");

$dbtable_count = 0;
if ($result = mysqli_query($dbh, "SHOW TABLES")) {
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		$table_rows = DUPX_DB::countTableRows($dbh, $row[0]);
		$dbtable_rows += $table_rows;
		DUPX_Log::info("{$row[0]}: ({$table_rows})");
		$dbtable_count++;
	}
	@mysqli_free_result($result);
}

if ($dbtable_count == 0) {
	DUPX_Log::error("No tables where created during step 2 of the install.  Please review the <a href='installer-log.txt' target='install_log'>installer-log.txt</a> file for
		ERROR messages.  You may have to manually run the installer-data.sql with a tool like phpmyadmin to validate the data input.  If you have enabled compatibility mode
		during the package creation process then the database server version your using may not be compatible with this script.\n");
}


//DATA CLEANUP: Perform Transient Cache Cleanup
//Remove all duplicator entries and record this one since this is a new install.
$dbdelete_count = 0;
@mysqli_query($dbh, "DELETE FROM `{$GLOBALS['FW_TABLEPREFIX']}duplicator_packages`");
$dbdelete_count1 = @mysqli_affected_rows($dbh) or 0;
@mysqli_query($dbh, "DELETE FROM `{$GLOBALS['FW_TABLEPREFIX']}options` WHERE `option_name` LIKE ('_transient%') OR `option_name` LIKE ('_site_transient%')");
$dbdelete_count2 = @mysqli_affected_rows($dbh) or 0;
$dbdelete_count = (abs($dbdelete_count1) + abs($dbdelete_count2));
DUPX_Log::info("\nRemoved '{$dbdelete_count}' cache/transient rows");
//Reset Duplicator Options
foreach ($GLOBALS['FW_OPTS_DELETE'] as $value) {
	mysqli_query($dbh, "DELETE FROM `{$GLOBALS['FW_TABLEPREFIX']}options` WHERE `option_name` = '{$value}'");
}

@mysqli_close($dbh);

//FINAL RESULTS
$profile_end	= DUPX_U::getMicrotime();
$ajax2_end		= DUPX_U::getMicrotime();
$ajax1_sum		= DUPX_U::elapsedTime($ajax2_end, $ajax2_start);
DUPX_Log::info("\nCREATE/INSTALL RUNTIME: " . DUPX_U::elapsedTime($profile_end, $profile_start));
DUPX_Log::info('STEP-2 COMPLETE @ ' . @date('h:i:s') . " - RUNTIME: {$ajax1_sum}");

$JSON['pass'] = 1;
$JSON['table_count'] = $dbtable_count;
$JSON['table_rows']  = $dbtable_rows;
$JSON['query_errs']  = $dbquery_errs;
echo json_encode($JSON);
error_reporting($ajax1_error_level);
die('');
?><?php break;

		case "3": ?><?php
// Exit if accessed directly from admin
if (function_exists('duplicator_secure_check')) {
	duplicator_secure_check();
}

/** JSON RESPONSE: Most sites have warnings turned off by default, but if they're turned on the warnings
cause errors in the JSON data Here we hide the status so warning level is reset at it at the end*/
$ajax2_error_level = error_reporting();
error_reporting(E_ERROR);

//====================================================================================================
//DATABASE UPDATES
//====================================================================================================

$ajax2_start = DUPX_U::getMicrotime();

//POST PARAMS
$_POST['dbhost']		= isset($_POST['dbhost'])   ? DUPX_U::sanitize(trim($_POST['dbhost'])) : null;
$_POST['dbname']		= isset($_POST['dbname'])   ? trim($_POST['dbname']) : null;
$_POST['dbuser']		= isset($_POST['dbuser'])   ? $_POST['dbuser'] : null;
$_POST['dbpass']		= isset($_POST['dbpass'])   ? $_POST['dbpass'] : null;
$_POST['blogname']		= isset($_POST['blogname']) ? DUPX_U::sanitize(trim($_POST['blogname'])): '';
$_POST['postguid']		= isset($_POST['postguid']) && $_POST['postguid'] == 1 ? 1 : 0;
$_POST['fullsearch']	= isset($_POST['fullsearch']) && $_POST['fullsearch'] == 1 ? 1 : 0;
$_POST['path_old']		= isset($_POST['path_old']) ? trim($_POST['path_old']) : null;
$_POST['path_new']		= isset($_POST['path_new']) ? trim($_POST['path_new']) : null;
$_POST['siteurl']		= isset($_POST['siteurl']) ? rtrim(trim($_POST['siteurl']), '/') : null;
$_POST['tables']		= isset($_POST['tables']) && is_array($_POST['tables']) ? array_map('stripcslashes', $_POST['tables']) : array();
$_POST['url_old']		= isset($_POST['url_old']) ? trim($_POST['url_old']) : null;
$_POST['url_new']		= isset($_POST['url_new']) ? rtrim(trim($_POST['url_new']), '/') : null;
$_POST['retain_config'] = (isset($_POST['retain_config']) && $_POST['retain_config'] == '1') ? true : false;
$_POST['exe_safe_mode']	= isset($_POST['exe_safe_mode']) ? $_POST['exe_safe_mode'] : 0;



//MYSQL CONNECTION
$dbh = DUPX_DB::connect($_POST['dbhost'], $_POST['dbuser'], html_entity_decode($_POST['dbpass']), $_POST['dbname'], $_POST['dbport']);
$charset_server = @mysqli_character_set_name($dbh);
@mysqli_query($dbh, "SET wait_timeout = {$GLOBALS['DB_MAX_TIME']}");
DUPX_DB::setCharset($dbh, $_POST['dbcharset'], $_POST['dbcollate']);


//LOGGING
$POST_LOG = $_POST;
unset($POST_LOG['tables']);
unset($POST_LOG['plugins']);
unset($POST_LOG['dbpass']);
ksort($POST_LOG);

$date = @date('h:i:s');
$charset_client = @mysqli_character_set_name($dbh);

$log = <<<LOG
\n\n********************************************************************************
* DUPLICATOR-LITE: INSTALL-LOG
* STEP-3 START @ {$date}
* NOTICE: Do NOT post to public sites or forums
********************************************************************************
CHARSET SERVER:\t{$charset_server}
CHARSET CLIENT:\t{$charset_client}
LOG;
DUPX_Log::info($log);

//Detailed logging
$log  = "--------------------------------------\n";
$log .= "POST DATA\n";
$log .= "--------------------------------------\n";
$log .= print_r($POST_LOG, true);		
$log .= "--------------------------------------\n";
$log .= "SCANNED TABLES\n";
$log .= "--------------------------------------\n";
$log .= (isset($_POST['tables']) && count($_POST['tables'] > 0)) 
		? print_r($_POST['tables'], true) 
		: 'No tables selected to update';
$log .= "--------------------------------------\n";
$log .= "KEEP PLUGINS ACTIVE\n";
$log .= "--------------------------------------\n";
$log .= (isset($_POST['plugins']) && count($_POST['plugins'] > 0)) 
		? print_r($_POST['plugins'], true) 
		: 'No plugins selected for activation';
DUPX_Log::info($log, 2);

//UPDATE SETTINGS
$blog_name   = $_POST['blogname'];
$plugin_list = (isset($_POST['plugins'])) ? $_POST['plugins'] : array();
// Force Duplicator active so we the security cleanup will be available
if (!in_array('duplicator/duplicator.php', $plugin_list)) {
	$plugin_list[] = 'duplicator/duplicator.php';
}
$serial_plugin_list	 = @serialize($plugin_list);

mysqli_query($dbh, "UPDATE `{$GLOBALS['FW_TABLEPREFIX']}options` SET option_value = '{$blog_name}' WHERE option_name = 'blogname' ");
mysqli_query($dbh, "UPDATE `{$GLOBALS['FW_TABLEPREFIX']}options` SET option_value = '{$serial_plugin_list}'  WHERE option_name = 'active_plugins' ");

$log  = "--------------------------------------\n";
$log .= "SERIALIZER ENGINE\n";
$log .= "[*] scan every column\n";
$log .= "[~] scan only text columns\n";
$log .= "[^] no searchable columns\n";
$log .= "--------------------------------------";
DUPX_Log::info($log);

$url_old_json = str_replace('"', "", json_encode($_POST['url_old']));
$url_new_json = str_replace('"', "", json_encode($_POST['url_new']));
$path_old_json = str_replace('"', "", json_encode($_POST['path_old']));
$path_new_json = str_replace('"', "", json_encode($_POST['path_new']));

//DIRS PATHS
array_push($GLOBALS['REPLACE_LIST'],
	array('search' => $_POST['path_old'],			 'replace' => $_POST['path_new']),
	array('search' => $path_old_json,				 'replace' => $path_new_json),
	array('search' => urlencode($_POST['path_old']), 'replace' => urlencode($_POST['path_new'])),
	array('search' => rtrim(DUPX_U::unsetSafePath($_POST['path_old']), '\\'), 'replace' => rtrim($_POST['path_new'], '/'))
);


//SEARCH WITH NO PROTOCAL: RAW "//"
$url_old_raw = str_ireplace(array('http://', 'https://'), '//', $_POST['url_old']);
$url_new_raw = str_ireplace(array('http://', 'https://'), '//', $_POST['url_new']);
$url_old_raw_json = str_replace('"',  "", json_encode($url_old_raw));
$url_new_raw_json = str_replace('"',  "", json_encode($url_new_raw));
array_push($GLOBALS['REPLACE_LIST'],
    //RAW
    array('search' => $url_old_raw,			 	'replace' => $url_new_raw),
    array('search' => $url_old_raw_json,		'replace' => $url_new_raw_json),
    array('search' => urlencode($url_old_raw), 	'replace' => urlencode($url_new_raw))
);


//SEARCH HTTP(S) EXPLICIT REQUEST
//Because the raw replace above has already changed all urls just fix https/http issue
//if the user has explicitly asked other-wise word boundary issues will occur:
//Old site: http://mydomain.com/somename/
//New site: http://mydomain.com/somename-dup/
//Result: http://mydomain.com/somename-dup-dup/
if (stristr($_POST['url_old'], 'http:') && stristr($_POST['url_new'], 'https:') ) {
    $url_old_http = str_ireplace('https:', 'http:', $_POST['url_new']);
    $url_new_http = $_POST['url_new'];
    $url_old_http_json = str_replace('"',  "", json_encode($url_old_http));
    $url_new_http_json = str_replace('"',  "", json_encode($url_new_http));

} elseif(stristr($_POST['url_old'], 'https:') && stristr($_POST['url_new'], 'http:')) {
    $url_old_http = str_ireplace('http:', 'https:', $_POST['url_new']);
    $url_new_http = $_POST['url_new'];
    $url_old_http_json = str_replace('"',  "", json_encode($url_old_http));
    $url_new_http_json = str_replace('"',  "", json_encode($url_new_http));
}
if(isset($url_old_http)){
    array_push($GLOBALS['REPLACE_LIST'],
        array('search' => $url_old_http,			 	 'replace' => $url_new_http),
        array('search' => $url_old_http_json,			 'replace' => $url_new_http_json),
        array('search' => urlencode($url_old_http),  	 'replace' => urlencode($url_new_http))
    );
}

//Remove trailing slashes
function _dupx_array_rtrim(&$value) {
    $value = rtrim($value, '\/');
}
array_walk_recursive($GLOBALS['REPLACE_LIST'], _dupx_array_rtrim);

@mysqli_autocommit($dbh, false);
$report = DUPX_UpdateEngine::load($dbh, $GLOBALS['REPLACE_LIST'], $_POST['tables'], $_POST['fullsearch']);
@mysqli_commit($dbh);
@mysqli_autocommit($dbh, true);


//BUILD JSON RESPONSE
$JSON = array();
$JSON['step2'] = json_decode(urldecode($_POST['json']));
$JSON['step3'] = $report;
$JSON['step3']['warn_all'] = 0;
$JSON['step3']['warnlist'] = array();

DUPX_UpdateEngine::logStats($report);
DUPX_UpdateEngine::logErrors($report);

//Reset the postguid data
if ($_POST['postguid']) {
	mysqli_query($dbh, "UPDATE `{$GLOBALS['FW_TABLEPREFIX']}posts` SET guid = REPLACE(guid, '{$_POST['url_new']}', '{$_POST['url_old']}')");
	$update_guid = @mysqli_affected_rows($dbh) or 0;
	DUPX_Log::info("Reverted '{$update_guid}' post guid columns back to '{$_POST['url_old']}'");
}

/** FINAL UPDATES: Must happen after the global replace to prevent double pathing
  http://xyz.com/abc01 will become http://xyz.com/abc0101  with trailing data */
mysqli_query($dbh, "UPDATE `{$GLOBALS['FW_TABLEPREFIX']}options` SET option_value = '{$_POST['url_new']}'  WHERE option_name = 'home' ");
mysqli_query($dbh, "UPDATE `{$GLOBALS['FW_TABLEPREFIX']}options` SET option_value = '{$_POST['siteurl']}'  WHERE option_name = 'siteurl' ");
mysqli_query($dbh, "INSERT INTO `{$GLOBALS['FW_TABLEPREFIX']}options` (option_value, option_name) VALUES('{$_POST['exe_safe_mode']}','duplicator_exe_safe_mode')");
//===============================================
//CONFIGURATION FILE UPDATES
//===============================================
DUPX_Log::info("\n====================================");
DUPX_Log::info('CONFIGURATION FILE UPDATES:');
DUPX_Log::info("====================================\n");
DUPX_WPConfig::updateStandard();
$config_file = DUPX_WPConfig::updateExtended();
DUPX_Log::info("UPDATED WP-CONFIG: {$root_path}/wp-config.php' (if present)");

//Web Server Config Updates
if (!isset($_POST['url_new']) || $_POST['retain_config']) {
	DUPX_Log::info("\nNOTICE: Manual update of permalinks required see:  Admin > Settings > Permalinks > Click Save Changes");
	DUPX_Log::info("Retaining the original htaccess, user.ini or web.config files may cause issues with the setup of this site.");
	DUPX_Log::info("If you run into issues during or after the install process please uncheck the 'Config Files' checkbox labeled:");
	DUPX_Log::info("'Retain original .htaccess, .user.ini and web.config' from Step 1 and re-run the installer. Backups of the");
	DUPX_Log::info("orginal config files will be made and can be merged per required directive.");
} else {
	DUPX_ServerConfig::setup($dbh);
}


//===============================================
//GENERAL UPDATES & CLEANUP
//===============================================
DUPX_Log::info("\n====================================");
DUPX_Log::info('GENERAL UPDATES & CLEANUP:');
DUPX_Log::info("====================================\n");

/** CREATE NEW USER LOGIC */
if (strlen($_POST['wp_username']) >= 4 && strlen($_POST['wp_password']) >= 6) {
	
	$newuser_check = mysqli_query($dbh, "SELECT COUNT(*) AS count FROM `{$GLOBALS['FW_TABLEPREFIX']}users` WHERE user_login = '{$_POST['wp_username']}' ");
	$newuser_row   = mysqli_fetch_row($newuser_check);
    $newuser_count = is_null($newuser_row) ? 0 : $newuser_row[0];
	
	if ($newuser_count == 0) {
	
		$newuser_datetime =	@date("Y-m-d H:i:s");
		$newuser_security = mysqli_real_escape_string($dbh, 'a:1:{s:13:"administrator";s:1:"1";}');

		$newuser_test1 = @mysqli_query($dbh, "INSERT INTO `{$GLOBALS['FW_TABLEPREFIX']}users` 
			(`user_login`, `user_pass`, `user_nicename`, `user_email`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) 
			VALUES ('{$_POST['wp_username']}', MD5('{$_POST['wp_password']}'), '{$_POST['wp_username']}', '', '{$newuser_datetime}', '', '0', '{$_POST['wp_username']}')");

		$newuser_insert_id = mysqli_insert_id($dbh);

		$newuser_test2 = @mysqli_query($dbh, "INSERT INTO `{$GLOBALS['FW_TABLEPREFIX']}usermeta` 
				(`user_id`, `meta_key`, `meta_value`) VALUES ('{$newuser_insert_id}', '{$GLOBALS['FW_TABLEPREFIX']}capabilities', '{$newuser_security}')");

		$newuser_test3 = @mysqli_query($dbh, "INSERT INTO `{$GLOBALS['FW_TABLEPREFIX']}usermeta` 
				(`user_id`, `meta_key`, `meta_value`) VALUES ('{$newuser_insert_id}', '{$GLOBALS['FW_TABLEPREFIX']}user_level', '10')");
				
		//Misc Meta-Data Settings:
		@mysqli_query($dbh, "INSERT INTO `{$GLOBALS['FW_TABLEPREFIX']}usermeta` (`user_id`, `meta_key`, `meta_value`) VALUES ('{$newuser_insert_id}', 'rich_editing', 'true')");
		@mysqli_query($dbh, "INSERT INTO `{$GLOBALS['FW_TABLEPREFIX']}usermeta` (`user_id`, `meta_key`, `meta_value`) VALUES ('{$newuser_insert_id}', 'admin_color',  'fresh')");
		@mysqli_query($dbh, "INSERT INTO `{$GLOBALS['FW_TABLEPREFIX']}usermeta` (`user_id`, `meta_key`, `meta_value`) VALUES ('{$newuser_insert_id}', 'nickname', '{$_POST['wp_username']}')");

		if ($newuser_test1 && $newuser_test2 && $newuser_test3) {
			DUPX_Log::info("NEW WP-ADMIN USER: New username '{$_POST['wp_username']}' was created successfully \n ");
		} else {
			$newuser_warnmsg = "NEW WP-ADMIN USER: Failed to create the user '{$_POST['wp_username']}' \n ";
			$JSON['step3']['warnlist'][] = $newuser_warnmsg;
			DUPX_Log::info($newuser_warnmsg);
		}			
	} 
	else {
		$newuser_warnmsg = "NEW WP-ADMIN USER: Username '{$_POST['wp_username']}' already exists in the database.  Unable to create new account \n";
		$JSON['step3']['warnlist'][] = $newuser_warnmsg;
		DUPX_Log::info($newuser_warnmsg);
	}
}

/** ==============================
 * MU Updates*/
$mu_newDomain = parse_url($_POST['url_new']);
$mu_oldDomain = parse_url($_POST['url_old']);
$mu_newDomainHost = $mu_newDomain['host'];
$mu_oldDomainHost = $mu_oldDomain['host'];
$mu_newUrlPath = parse_url($_POST['url_new'], PHP_URL_PATH);
$mu_oldUrlPath = parse_url($_POST['url_old'], PHP_URL_PATH);

//Force a path for PATH_CURRENT_SITE
$mu_newUrlPath = (empty($mu_newUrlPath) || ($mu_newUrlPath == '/')) ? '/'  : rtrim($mu_newUrlPath, '/') . '/';
$mu_oldUrlPath = (empty($mu_oldUrlPath) || ($mu_oldUrlPath == '/')) ? '/'  : rtrim($mu_oldUrlPath, '/') . '/';

$mu_updates = @mysqli_query($dbh, "UPDATE `{$GLOBALS['FW_TABLEPREFIX']}blogs` SET domain = '{$mu_newDomainHost}' WHERE domain = '{$mu_oldDomainHost}'");
if ($mu_updates) {
	DUPX_Log::info("Update MU table blogs: domain {$mu_newDomainHost} ");
	DUPX_Log::info("UPDATE `{$GLOBALS['FW_TABLEPREFIX']}blogs` SET domain = '{$mu_newDomainHost}' WHERE domain = '{$mu_oldDomainHost}'");
} 


//Create snapshots directory in order to
//compensate for permissions on some servers
if (!file_exists(DUPLICATOR_SSDIR_NAME)) {
	mkdir(DUPLICATOR_SSDIR_NAME, 0755);
	DUPX_Log::info("- Created directory ". DUPLICATOR_SSDIR_NAME);
}
$fp = fopen(DUPLICATOR_SSDIR_NAME . '/index.php', 'w');
fclose($fp);
DUPX_Log::info("- Created file ". DUPLICATOR_SSDIR_NAME . '/index.php');



//===============================================
//NOTICES TESTS
//===============================================
DUPX_Log::info("\n====================================");
DUPX_Log::info("NOTICES");
DUPX_Log::info("====================================\n");
$config_vars = array('WPCACHEHOME', 'COOKIE_DOMAIN', 'WP_SITEURL', 'WP_HOME', 'WP_TEMP_DIR');
$config_found = DUPX_U::getListValues($config_vars, $config_file);

//Config File:
if (! empty($config_found)) {
	$msg  = "NOTICE: The wp-config.php has the following values set [" . implode(", ", $config_found) . "]. \n";
	$msg .= 'Please validate these values are correct in your wp-config.php file.  See the codex link for more details: https://codex.wordpress.org/Editing_wp-config.php';
	$JSON['step3']['warnlist'][] = $msg;
	DUPX_Log::info($msg);
}

//Database: 
$result = @mysqli_query($dbh, "SELECT option_value FROM `{$GLOBALS['FW_TABLEPREFIX']}options` WHERE option_name IN ('upload_url_path','upload_path')");
if ($result) {
	while ($row = mysqli_fetch_row($result)) {
		if (strlen($row[0])) {
			$msg  = "NOTICE: The media settings values in the table '{$GLOBALS['FW_TABLEPREFIX']}options' has at least one the following values ['upload_url_path','upload_path'] set. \n";
			$msg .= "Please validate these settings by logging into your wp-admin and going to Settings->Media area and validating the 'Uploading Files' section";
			$JSON['step3']['warnlist'][] = $msg;
			DUPX_Log::info($msg);
			break;
		}
	}
}

if (empty($JSON['step3']['warnlist'])) {
	DUPX_Log::info("No Notices Found\n");
}

$JSON['step3']['warn_all'] = empty($JSON['step3']['warnlist']) ? 0 : count($JSON['step3']['warnlist']);

mysqli_close($dbh);

$ajax2_end = DUPX_U::getMicrotime();
$ajax2_sum = DUPX_U::elapsedTime($ajax2_end, $ajax2_start);
DUPX_Log::info("\nSTEP 3 COMPLETE @ " . @date('h:i:s') . " - RUNTIME: {$ajax2_sum}\n\n");

$JSON['step3']['pass'] = 1;
error_reporting($ajax2_error_level);
die(json_encode($JSON));
?><?php break;

	endswitch;

    @fclose($GLOBALS["LOG_FILE_HANDLE"]);
    die("");

endif;
?>
	
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex,nofollow">
	<title>Duplicator</title>
	<?php
	// Exit if accessed directly
	if (! defined('DUPLICATOR_INIT')) {
		$_baseURL = "http://" . strlen($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $_baseURL");
		exit; 
	}
?>
<?php if( DUPX_U::isURLActive("ajax.googleapis.com", 443) ): ?>
	<link rel='stylesheet' href='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css' type='text/css' media='all' />
<?php else: ?>
	<style type="text/css">
	/*! jQuery UI - v1.11.2 - 2014-12-20
	* http://jqueryui.com
	* Includes: core.css, progressbar.css, theme.css
	* To view and modify this theme, visit http://jqueryui.com/themeroller/?ffDefault=Verdana%2CArial%2Csans-serif&fwDefault=normal&fsDefault=1.1em&cornerRadius=4px&bgColorHeader=cccccc&bgTextureHeader=highlight_soft&bgImgOpacityHeader=75&borderColorHeader=aaaaaa&fcHeader=222222&iconColorHeader=222222&bgColorContent=ffffff&bgTextureContent=flat&bgImgOpacityContent=75&borderColorContent=aaaaaa&fcContent=222222&iconColorContent=222222&bgColorDefault=e6e6e6&bgTextureDefault=glass&bgImgOpacityDefault=75&borderColorDefault=d3d3d3&fcDefault=555555&iconColorDefault=888888&bgColorHover=dadada&bgTextureHover=glass&bgImgOpacityHover=75&borderColorHover=999999&fcHover=212121&iconColorHover=454545&bgColorActive=ffffff&bgTextureActive=glass&bgImgOpacityActive=65&borderColorActive=aaaaaa&fcActive=212121&iconColorActive=454545&bgColorHighlight=fbf9ee&bgTextureHighlight=glass&bgImgOpacityHighlight=55&borderColorHighlight=fcefa1&fcHighlight=363636&iconColorHighlight=2e83ff&bgColorError=fef1ec&bgTextureError=glass&bgImgOpacityError=95&borderColorError=cd0a0a&fcError=cd0a0a&iconColorError=cd0a0a&bgColorOverlay=aaaaaa&bgTextureOverlay=flat&bgImgOpacityOverlay=0&opacityOverlay=30&bgColorShadow=aaaaaa&bgTextureShadow=flat&bgImgOpacityShadow=0&opacityShadow=30&thicknessShadow=8px&offsetTopShadow=-8px&offsetLeftShadow=-8px&cornerRadiusShadow=8px
	* Copyright 2014 jQuery Foundation and other contributors; Licensed MIT */

	.ui-helper-hidden{display:none}.ui-helper-hidden-accessible{border:0;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px}.ui-helper-reset{margin:0;padding:0;border:0;outline:0;line-height:1.3;text-decoration:none;font-size:100%;list-style:none}.ui-helper-clearfix:before,.ui-helper-clearfix:after{content:"";display:table;border-collapse:collapse}.ui-helper-clearfix:after{clear:both}.ui-helper-clearfix{min-height:0}.ui-helper-zfix{width:100%;height:100%;top:0;left:0;position:absolute;opacity:0;filter:Alpha(Opacity=0)}.ui-front{z-index:100}.ui-state-disabled{cursor:default!important}.ui-icon{display:block;text-indent:-99999px;overflow:hidden;background-repeat:no-repeat}.ui-widget-overlay{position:fixed;top:0;left:0;width:100%;height:100%}.ui-progressbar{height:2em;text-align:left;overflow:hidden}.ui-progressbar .ui-progressbar-value{margin:-1px;height:100%}.ui-progressbar .ui-progressbar-overlay{background:url("data:image/gif;base64,R0lGODlhKAAoAIABAAAAAP///yH/C05FVFNDQVBFMi4wAwEAAAAh+QQJAQABACwAAAAAKAAoAAACkYwNqXrdC52DS06a7MFZI+4FHBCKoDeWKXqymPqGqxvJrXZbMx7Ttc+w9XgU2FB3lOyQRWET2IFGiU9m1frDVpxZZc6bfHwv4c1YXP6k1Vdy292Fb6UkuvFtXpvWSzA+HycXJHUXiGYIiMg2R6W459gnWGfHNdjIqDWVqemH2ekpObkpOlppWUqZiqr6edqqWQAAIfkECQEAAQAsAAAAACgAKAAAApSMgZnGfaqcg1E2uuzDmmHUBR8Qil95hiPKqWn3aqtLsS18y7G1SzNeowWBENtQd+T1JktP05nzPTdJZlR6vUxNWWjV+vUWhWNkWFwxl9VpZRedYcflIOLafaa28XdsH/ynlcc1uPVDZxQIR0K25+cICCmoqCe5mGhZOfeYSUh5yJcJyrkZWWpaR8doJ2o4NYq62lAAACH5BAkBAAEALAAAAAAoACgAAAKVDI4Yy22ZnINRNqosw0Bv7i1gyHUkFj7oSaWlu3ovC8GxNso5fluz3qLVhBVeT/Lz7ZTHyxL5dDalQWPVOsQWtRnuwXaFTj9jVVh8pma9JjZ4zYSj5ZOyma7uuolffh+IR5aW97cHuBUXKGKXlKjn+DiHWMcYJah4N0lYCMlJOXipGRr5qdgoSTrqWSq6WFl2ypoaUAAAIfkECQEAAQAsAAAAACgAKAAAApaEb6HLgd/iO7FNWtcFWe+ufODGjRfoiJ2akShbueb0wtI50zm02pbvwfWEMWBQ1zKGlLIhskiEPm9R6vRXxV4ZzWT2yHOGpWMyorblKlNp8HmHEb/lCXjcW7bmtXP8Xt229OVWR1fod2eWqNfHuMjXCPkIGNileOiImVmCOEmoSfn3yXlJWmoHGhqp6ilYuWYpmTqKUgAAIfkECQEAAQAsAAAAACgAKAAAApiEH6kb58biQ3FNWtMFWW3eNVcojuFGfqnZqSebuS06w5V80/X02pKe8zFwP6EFWOT1lDFk8rGERh1TTNOocQ61Hm4Xm2VexUHpzjymViHrFbiELsefVrn6XKfnt2Q9G/+Xdie499XHd2g4h7ioOGhXGJboGAnXSBnoBwKYyfioubZJ2Hn0RuRZaflZOil56Zp6iioKSXpUAAAh+QQJAQABACwAAAAAKAAoAAACkoQRqRvnxuI7kU1a1UU5bd5tnSeOZXhmn5lWK3qNTWvRdQxP8qvaC+/yaYQzXO7BMvaUEmJRd3TsiMAgswmNYrSgZdYrTX6tSHGZO73ezuAw2uxuQ+BbeZfMxsexY35+/Qe4J1inV0g4x3WHuMhIl2jXOKT2Q+VU5fgoSUI52VfZyfkJGkha6jmY+aaYdirq+lQAACH5BAkBAAEALAAAAAAoACgAAAKWBIKpYe0L3YNKToqswUlvznigd4wiR4KhZrKt9Upqip61i9E3vMvxRdHlbEFiEXfk9YARYxOZZD6VQ2pUunBmtRXo1Lf8hMVVcNl8JafV38aM2/Fu5V16Bn63r6xt97j09+MXSFi4BniGFae3hzbH9+hYBzkpuUh5aZmHuanZOZgIuvbGiNeomCnaxxap2upaCZsq+1kAACH5BAkBAAEALAAAAAAoACgAAAKXjI8By5zf4kOxTVrXNVlv1X0d8IGZGKLnNpYtm8Lr9cqVeuOSvfOW79D9aDHizNhDJidFZhNydEahOaDH6nomtJjp1tutKoNWkvA6JqfRVLHU/QUfau9l2x7G54d1fl995xcIGAdXqMfBNadoYrhH+Mg2KBlpVpbluCiXmMnZ2Sh4GBqJ+ckIOqqJ6LmKSllZmsoq6wpQAAAh+QQJAQABACwAAAAAKAAoAAAClYx/oLvoxuJDkU1a1YUZbJ59nSd2ZXhWqbRa2/gF8Gu2DY3iqs7yrq+xBYEkYvFSM8aSSObE+ZgRl1BHFZNr7pRCavZ5BW2142hY3AN/zWtsmf12p9XxxFl2lpLn1rseztfXZjdIWIf2s5dItwjYKBgo9yg5pHgzJXTEeGlZuenpyPmpGQoKOWkYmSpaSnqKileI2FAAACH5BAkBAAEALAAAAAAoACgAAAKVjB+gu+jG4kORTVrVhRlsnn2dJ3ZleFaptFrb+CXmO9OozeL5VfP99HvAWhpiUdcwkpBH3825AwYdU8xTqlLGhtCosArKMpvfa1mMRae9VvWZfeB2XfPkeLmm18lUcBj+p5dnN8jXZ3YIGEhYuOUn45aoCDkp16hl5IjYJvjWKcnoGQpqyPlpOhr3aElaqrq56Bq7VAAAOw==");height:100%;filter:alpha(opacity=25);opacity:0.25}.ui-progressbar-indeterminate .ui-progressbar-value{background-image:none}.ui-widget{font-family:Verdana,Arial,sans-serif;font-size:1.1em}.ui-widget .ui-widget{font-size:1em}.ui-widget input,.ui-widget select,.ui-widget textarea,.ui-widget button{font-family:Verdana,Arial,sans-serif;font-size:1em}.ui-widget-content{border:1px solid #aaa;background:#fff url("images/ui-bg_flat_75_ffffff_40x100.png") 50% 50% repeat-x;color:#222}.ui-widget-content a{color:#222}.ui-widget-header{border:1px solid #aaa;background:#ccc url("images/ui-bg_highlight-soft_75_cccccc_1x100.png") 50% 50% repeat-x;color:#222;font-weight:bold}.ui-widget-header a{color:#222}.ui-state-default,.ui-widget-content .ui-state-default,.ui-widget-header .ui-state-default{border:1px solid #d3d3d3;background:#e6e6e6 url("images/ui-bg_glass_75_e6e6e6_1x400.png") 50% 50% repeat-x;font-weight:normal;color:#555}.ui-state-default a,.ui-state-default a:link,.ui-state-default a:visited{color:#555;text-decoration:none}.ui-state-hover,.ui-widget-content .ui-state-hover,.ui-widget-header .ui-state-hover,.ui-state-focus,.ui-widget-content .ui-state-focus,.ui-widget-header .ui-state-focus{border:1px solid #999;background:#dadada url("images/ui-bg_glass_75_dadada_1x400.png") 50% 50% repeat-x;font-weight:normal;color:#212121}.ui-state-hover a,.ui-state-hover a:hover,.ui-state-hover a:link,.ui-state-hover a:visited,.ui-state-focus a,.ui-state-focus a:hover,.ui-state-focus a:link,.ui-state-focus a:visited{color:#212121;text-decoration:none}.ui-state-active,.ui-widget-content .ui-state-active,.ui-widget-header .ui-state-active{border:1px solid #aaa;background:#fff url("images/ui-bg_glass_65_ffffff_1x400.png") 50% 50% repeat-x;font-weight:normal;color:#212121}.ui-state-active a,.ui-state-active a:link,.ui-state-active a:visited{color:#212121;text-decoration:none}.ui-state-highlight,.ui-widget-content .ui-state-highlight,.ui-widget-header .ui-state-highlight{border:1px solid #fcefa1;background:#fbf9ee url("images/ui-bg_glass_55_fbf9ee_1x400.png") 50% 50% repeat-x;color:#363636}.ui-state-highlight a,.ui-widget-content .ui-state-highlight a,.ui-widget-header .ui-state-highlight a{color:#363636}.ui-state-error,.ui-widget-content .ui-state-error,.ui-widget-header .ui-state-error{border:1px solid #cd0a0a;background:#fef1ec url("images/ui-bg_glass_95_fef1ec_1x400.png") 50% 50% repeat-x;color:#cd0a0a}.ui-state-error a,.ui-widget-content .ui-state-error a,.ui-widget-header .ui-state-error a{color:#cd0a0a}.ui-state-error-text,.ui-widget-content .ui-state-error-text,.ui-widget-header .ui-state-error-text{color:#cd0a0a}.ui-priority-primary,.ui-widget-content .ui-priority-primary,.ui-widget-header .ui-priority-primary{font-weight:bold}.ui-priority-secondary,.ui-widget-content .ui-priority-secondary,.ui-widget-header .ui-priority-secondary{opacity:.7;filter:Alpha(Opacity=70);font-weight:normal}.ui-state-disabled,.ui-widget-content .ui-state-disabled,.ui-widget-header .ui-state-disabled{opacity:.35;filter:Alpha(Opacity=35);background-image:none}.ui-state-disabled .ui-icon{filter:Alpha(Opacity=35)}.ui-icon{width:16px;height:16px}.ui-icon,.ui-widget-content .ui-icon{background-image:url("images/ui-icons_222222_256x240.png")}.ui-widget-header .ui-icon{background-image:url("images/ui-icons_222222_256x240.png")}.ui-state-default .ui-icon{background-image:url("images/ui-icons_888888_256x240.png")}.ui-state-hover .ui-icon,.ui-state-focus .ui-icon{background-image:url("images/ui-icons_454545_256x240.png")}.ui-state-active .ui-icon{background-image:url("images/ui-icons_454545_256x240.png")}.ui-state-highlight .ui-icon{background-image:url("images/ui-icons_2e83ff_256x240.png")}.ui-state-error .ui-icon,.ui-state-error-text .ui-icon{background-image:url("images/ui-icons_cd0a0a_256x240.png")}.ui-icon-blank{background-position:16px 16px}.ui-icon-carat-1-n{background-position:0 0}.ui-icon-carat-1-ne{background-position:-16px 0}.ui-icon-carat-1-e{background-position:-32px 0}.ui-icon-carat-1-se{background-position:-48px 0}.ui-icon-carat-1-s{background-position:-64px 0}.ui-icon-carat-1-sw{background-position:-80px 0}.ui-icon-carat-1-w{background-position:-96px 0}.ui-icon-carat-1-nw{background-position:-112px 0}.ui-icon-carat-2-n-s{background-position:-128px 0}.ui-icon-carat-2-e-w{background-position:-144px 0}.ui-icon-triangle-1-n{background-position:0 -16px}.ui-icon-triangle-1-ne{background-position:-16px -16px}.ui-icon-triangle-1-e{background-position:-32px -16px}.ui-icon-triangle-1-se{background-position:-48px -16px}.ui-icon-triangle-1-s{background-position:-64px -16px}.ui-icon-triangle-1-sw{background-position:-80px -16px}.ui-icon-triangle-1-w{background-position:-96px -16px}.ui-icon-triangle-1-nw{background-position:-112px -16px}.ui-icon-triangle-2-n-s{background-position:-128px -16px}.ui-icon-triangle-2-e-w{background-position:-144px -16px}.ui-icon-arrow-1-n{background-position:0 -32px}.ui-icon-arrow-1-ne{background-position:-16px -32px}.ui-icon-arrow-1-e{background-position:-32px -32px}.ui-icon-arrow-1-se{background-position:-48px -32px}.ui-icon-arrow-1-s{background-position:-64px -32px}.ui-icon-arrow-1-sw{background-position:-80px -32px}.ui-icon-arrow-1-w{background-position:-96px -32px}.ui-icon-arrow-1-nw{background-position:-112px -32px}.ui-icon-arrow-2-n-s{background-position:-128px -32px}.ui-icon-arrow-2-ne-sw{background-position:-144px -32px}.ui-icon-arrow-2-e-w{background-position:-160px -32px}.ui-icon-arrow-2-se-nw{background-position:-176px -32px}.ui-icon-arrowstop-1-n{background-position:-192px -32px}.ui-icon-arrowstop-1-e{background-position:-208px -32px}.ui-icon-arrowstop-1-s{background-position:-224px -32px}.ui-icon-arrowstop-1-w{background-position:-240px -32px}.ui-icon-arrowthick-1-n{background-position:0 -48px}.ui-icon-arrowthick-1-ne{background-position:-16px -48px}.ui-icon-arrowthick-1-e{background-position:-32px -48px}.ui-icon-arrowthick-1-se{background-position:-48px -48px}.ui-icon-arrowthick-1-s{background-position:-64px -48px}.ui-icon-arrowthick-1-sw{background-position:-80px -48px}.ui-icon-arrowthick-1-w{background-position:-96px -48px}.ui-icon-arrowthick-1-nw{background-position:-112px -48px}.ui-icon-arrowthick-2-n-s{background-position:-128px -48px}.ui-icon-arrowthick-2-ne-sw{background-position:-144px -48px}.ui-icon-arrowthick-2-e-w{background-position:-160px -48px}.ui-icon-arrowthick-2-se-nw{background-position:-176px -48px}.ui-icon-arrowthickstop-1-n{background-position:-192px -48px}.ui-icon-arrowthickstop-1-e{background-position:-208px -48px}.ui-icon-arrowthickstop-1-s{background-position:-224px -48px}.ui-icon-arrowthickstop-1-w{background-position:-240px -48px}.ui-icon-arrowreturnthick-1-w{background-position:0 -64px}.ui-icon-arrowreturnthick-1-n{background-position:-16px -64px}.ui-icon-arrowreturnthick-1-e{background-position:-32px -64px}.ui-icon-arrowreturnthick-1-s{background-position:-48px -64px}.ui-icon-arrowreturn-1-w{background-position:-64px -64px}.ui-icon-arrowreturn-1-n{background-position:-80px -64px}.ui-icon-arrowreturn-1-e{background-position:-96px -64px}.ui-icon-arrowreturn-1-s{background-position:-112px -64px}.ui-icon-arrowrefresh-1-w{background-position:-128px -64px}.ui-icon-arrowrefresh-1-n{background-position:-144px -64px}.ui-icon-arrowrefresh-1-e{background-position:-160px -64px}.ui-icon-arrowrefresh-1-s{background-position:-176px -64px}.ui-icon-arrow-4{background-position:0 -80px}.ui-icon-arrow-4-diag{background-position:-16px -80px}.ui-icon-extlink{background-position:-32px -80px}.ui-icon-newwin{background-position:-48px -80px}.ui-icon-refresh{background-position:-64px -80px}.ui-icon-shuffle{background-position:-80px -80px}.ui-icon-transfer-e-w{background-position:-96px -80px}.ui-icon-transferthick-e-w{background-position:-112px -80px}.ui-icon-folder-collapsed{background-position:0 -96px}.ui-icon-folder-open{background-position:-16px -96px}.ui-icon-document{background-position:-32px -96px}.ui-icon-document-b{background-position:-48px -96px}.ui-icon-note{background-position:-64px -96px}.ui-icon-mail-closed{background-position:-80px -96px}.ui-icon-mail-open{background-position:-96px -96px}.ui-icon-suitcase{background-position:-112px -96px}.ui-icon-comment{background-position:-128px -96px}.ui-icon-person{background-position:-144px -96px}.ui-icon-print{background-position:-160px -96px}.ui-icon-trash{background-position:-176px -96px}.ui-icon-locked{background-position:-192px -96px}.ui-icon-unlocked{background-position:-208px -96px}.ui-icon-bookmark{background-position:-224px -96px}.ui-icon-tag{background-position:-240px -96px}.ui-icon-home{background-position:0 -112px}.ui-icon-flag{background-position:-16px -112px}.ui-icon-calendar{background-position:-32px -112px}.ui-icon-cart{background-position:-48px -112px}.ui-icon-pencil{background-position:-64px -112px}.ui-icon-clock{background-position:-80px -112px}.ui-icon-disk{background-position:-96px -112px}.ui-icon-calculator{background-position:-112px -112px}.ui-icon-zoomin{background-position:-128px -112px}.ui-icon-zoomout{background-position:-144px -112px}.ui-icon-search{background-position:-160px -112px}.ui-icon-wrench{background-position:-176px -112px}.ui-icon-gear{background-position:-192px -112px}.ui-icon-heart{background-position:-208px -112px}.ui-icon-star{background-position:-224px -112px}.ui-icon-link{background-position:-240px -112px}.ui-icon-cancel{background-position:0 -128px}.ui-icon-plus{background-position:-16px -128px}.ui-icon-plusthick{background-position:-32px -128px}.ui-icon-minus{background-position:-48px -128px}.ui-icon-minusthick{background-position:-64px -128px}.ui-icon-close{background-position:-80px -128px}.ui-icon-closethick{background-position:-96px -128px}.ui-icon-key{background-position:-112px -128px}.ui-icon-lightbulb{background-position:-128px -128px}.ui-icon-scissors{background-position:-144px -128px}.ui-icon-clipboard{background-position:-160px -128px}.ui-icon-copy{background-position:-176px -128px}.ui-icon-contact{background-position:-192px -128px}.ui-icon-image{background-position:-208px -128px}.ui-icon-video{background-position:-224px -128px}.ui-icon-script{background-position:-240px -128px}.ui-icon-alert{background-position:0 -144px}.ui-icon-info{background-position:-16px -144px}.ui-icon-notice{background-position:-32px -144px}.ui-icon-help{background-position:-48px -144px}.ui-icon-check{background-position:-64px -144px}.ui-icon-bullet{background-position:-80px -144px}.ui-icon-radio-on{background-position:-96px -144px}.ui-icon-radio-off{background-position:-112px -144px}.ui-icon-pin-w{background-position:-128px -144px}.ui-icon-pin-s{background-position:-144px -144px}.ui-icon-play{background-position:0 -160px}.ui-icon-pause{background-position:-16px -160px}.ui-icon-seek-next{background-position:-32px -160px}.ui-icon-seek-prev{background-position:-48px -160px}.ui-icon-seek-end{background-position:-64px -160px}.ui-icon-seek-start{background-position:-80px -160px}.ui-icon-seek-first{background-position:-80px -160px}.ui-icon-stop{background-position:-96px -160px}.ui-icon-eject{background-position:-112px -160px}.ui-icon-volume-off{background-position:-128px -160px}.ui-icon-volume-on{background-position:-144px -160px}.ui-icon-power{background-position:0 -176px}.ui-icon-signal-diag{background-position:-16px -176px}.ui-icon-signal{background-position:-32px -176px}.ui-icon-battery-0{background-position:-48px -176px}.ui-icon-battery-1{background-position:-64px -176px}.ui-icon-battery-2{background-position:-80px -176px}.ui-icon-battery-3{background-position:-96px -176px}.ui-icon-circle-plus{background-position:0 -192px}.ui-icon-circle-minus{background-position:-16px -192px}.ui-icon-circle-close{background-position:-32px -192px}.ui-icon-circle-triangle-e{background-position:-48px -192px}.ui-icon-circle-triangle-s{background-position:-64px -192px}.ui-icon-circle-triangle-w{background-position:-80px -192px}.ui-icon-circle-triangle-n{background-position:-96px -192px}.ui-icon-circle-arrow-e{background-position:-112px -192px}.ui-icon-circle-arrow-s{background-position:-128px -192px}.ui-icon-circle-arrow-w{background-position:-144px -192px}.ui-icon-circle-arrow-n{background-position:-160px -192px}.ui-icon-circle-zoomin{background-position:-176px -192px}.ui-icon-circle-zoomout{background-position:-192px -192px}.ui-icon-circle-check{background-position:-208px -192px}.ui-icon-circlesmall-plus{background-position:0 -208px}.ui-icon-circlesmall-minus{background-position:-16px -208px}.ui-icon-circlesmall-close{background-position:-32px -208px}.ui-icon-squaresmall-plus{background-position:-48px -208px}.ui-icon-squaresmall-minus{background-position:-64px -208px}.ui-icon-squaresmall-close{background-position:-80px -208px}.ui-icon-grip-dotted-vertical{background-position:0 -224px}.ui-icon-grip-dotted-horizontal{background-position:-16px -224px}.ui-icon-grip-solid-vertical{background-position:-32px -224px}.ui-icon-grip-solid-horizontal{background-position:-48px -224px}.ui-icon-gripsmall-diagonal-se{background-position:-64px -224px}.ui-icon-grip-diagonal-se{background-position:-80px -224px}.ui-corner-all,.ui-corner-top,.ui-corner-left,.ui-corner-tl{border-top-left-radius:4px}.ui-corner-all,.ui-corner-top,.ui-corner-right,.ui-corner-tr{border-top-right-radius:4px}.ui-corner-all,.ui-corner-bottom,.ui-corner-left,.ui-corner-bl{border-bottom-left-radius:4px}.ui-corner-all,.ui-corner-bottom,.ui-corner-right,.ui-corner-br{border-bottom-right-radius:4px}.ui-widget-overlay{background:#aaa url("images/ui-bg_flat_0_aaaaaa_40x100.png") 50% 50% repeat-x;opacity:.3;filter:Alpha(Opacity=30)}.ui-widget-shadow{margin:-8px 0 0 -8px;padding:8px;background:#aaa url("images/ui-bg_flat_0_aaaaaa_40x100.png") 50% 50% repeat-x;opacity:.3;filter:Alpha(Opacity=30);border-radius:8px}
	</style>
<?php endif; ?>

	
<style type="text/css">
/*! * CSS Modal
 * Copyright (c) 2015 CreativeDream
 * Website https://github.com/CreativeDream/jquery.modal
 * Version: 1.2.3 (10-04-2015)
*/
#modal-window{background-color:rgba(0,0,0,.35)}#modal-window>*{margin:0;padding:0;border:0;font:inherit;line-height:normal;vertical-align:baseline}#modal-window .modal-box{position:absolute;margin-bottom:10px;top:40%!important;background-color:#fff;font-family:sans-serif;color:#444;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;-webkit-background-clip:padding-box;-moz-background-clip:padding-box;background-clip:padding-box;-webkit-box-shadow:0 0 7px rgba(0,0,0,.3);-moz-box-shadow:0 0 7px rgba(0,0,0,.3);box-shadow:0 0 7px rgba(0,0,0,.3);outline:0;overflow:hidden}#modal-window .modal-box.modal-size-normal{width:560px}#modal-window .modal-box.modal-size-small{width:350px}#modal-window .modal-box.modal-size-large{width:1000px}@media only screen and (max-width :580px){#modal-window .modal-box.modal-size-normal{width:96%;left:0!important;margin-left:2%!important;margin-right:2%}}@media only screen and (max-width :1020px){#modal-window .modal-box.modal-size-large{width:96%;left:0!important;margin-left:2%!important;margin-right:2%}}@media only screen and (max-width :370px){#modal-window .modal-box.modal-size-small{width:96%;left:0!important;margin-left:2%!important;margin-right:2%}}#modal-window .modal-box .modal-title{position:relative;padding:12px 15px;border-bottom:1px solid #e5e5e5;font-size:20px;overflow:hidden}#modal-window .modal-box .modal-title h3{font-size:20px;font-weight:400;line-height:normal;display:inline-block;margin:0;padding:0}#modal-window .modal-box .modal-title .modal-close-btn{position:absolute;display:block;width:14px;height:14px;right:20px;top:50%;margin-top:-7px;cursor:pointer;background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpGNzdGMTE3NDA3MjA2ODExOEMxNDkyODc0N0NBMUEwNCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo3N0ZBOTUxNzNERkIxMUUyQUZGMEFDRjY0RjNFODlDOCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo3N0ZBOTUxNjNERkIxMUUyQUZGMEFDRjY0RjNFODlDOCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkY3N0YxMTc0MDcyMDY4MTE4MDgzRkQyMTE2MTM0QUNBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkY3N0YxMTc0MDcyMDY4MTE4QzE0OTI4NzQ3Q0ExQTA0Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+5Ke+4QAAAMlJREFUeNqkk90KwyAMha0dvp/ghfthsFcb67YLYe83EBdZlCxL3KCFU0nM+WqjTqUUs+bZ1Nd2d6jDDDqDHqCk1AeQBx1B+Xa9vAFovmNBwFwSzAvIoWKFWJxciNGxmJtp3FeQMDkziCEfcCTObYUUEPE3JAg3xwawZKJBMsm5kZkDNIhqlgC0+J/cFyAIDTOD3fkABKXbeQSxP8xRaWyHNIAfdFvbHU8BJ9JdqdscktDTD9ITtCcnTLpMDRLwMlWPmdZe55cAAwD+1kOdnSr5eQAAAABJRU5ErkJggg==) center no-repeat;background-size:14px,14px;opacity:.5;filter:alpha(opacity=50)}#modal-window .modal-box .modal-title .modal-close-btn:hover{opacity:1;filter:alpha(opacity=100)}#modal-window .modal-box .modal-text{font-size:14px;padding:18px 15px;overflow-y:auto}#modal-window .modal-box img{height:auto;max-width:100%;vertical-align:middle;border:0;-ms-interpolation-mode:bicubic}#modal-window .modal-box .modal-text input.modal-prompt-input{width:97%;width:-webkit-calc(100% - 14px);width:-moz-calc(100% - 14px);width:calc(100% - 14px);display:block;outline:0;border:1px solid #ddd;border-top:1px solid #ccc;margin:10px 0;padding:6px;color:#333;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:inset 0 0 2px #eee;-moz-box-shadow:inset 0 0 2px #eee;box-shadow:inset 0 0 2px #eee;-webkit-transition:all .1s linear;transition:all .1s linear}#modal-window .modal-box .modal-text input.modal-prompt-input:hover{border:1px solid #bbb;border-top:1px solid #aaa}#modal-window .modal-box .modal-text input.modal-prompt-input:active,#modal-window .modal-box .modal-text input.modal-prompt-input:focus{border-color:rgba(82,168,236,.8);-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(82,168,236,.3);-moz-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(82,168,236,.3);box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(82,168,236,.3)}#modal-window .modal-box .modal-buttons{padding:10px 15px;text-align:right;background-color:#f9f9f9;border-top:1px solid #ddd}#modal-window .modal-box .modal-buttons a.modal-btn{display:inline-block;padding:8px 12px;outline:0;border:1px solid transparent;cursor:pointer;text-decoration:none;text-align:center;white-space:nowrap;font-size:12px;font-weight:700;line-height:normal;color:#555;vertical-align:middle}#modal-window .modal-box .modal-buttons a.modal-btn:active,a.modal-btn:focus{outline:0!important}#modal-window .modal-box .modal-buttons a.modal-btn:active,a.modal-btn.active{-webkit-box-shadow:inset 0 0 7px rgba(0,0,0,.2);-moz-box-shadow:inset 0 0 7px rgba(0,0,0,.2);box-shadow:inset 0 0 7px rgba(0,0,0,.2)}#modal-window .modal-box .modal-buttons a.modal-btn+a.modal-btn{margin-left:5px}#modal-window .modal-box .modal-buttons a.modal-btn.btn-disabled{cursor:not-allowed;pointer-events:none;opacity:.65;filter:alpha(opacity=65)}#modal-window .modal-box .modal-buttons a.modal-btn.btn-large{padding:8px 14px;font-size:16px}#modal-window .modal-box .modal-buttons a.modal-btn.btn-small{padding:6px 8px;font-size:10px}#modal-window .modal-box .modal-buttons a.modal-btn.btn-rounded{-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}#modal-window .modal-box .modal-buttons a.modal-btn.btn-circle{-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px}#modal-window .modal-box .modal-buttons a.modal-btn.btn-square{-webkit-border-radius:0;-moz-border-radius:0;border-radius:0}#modal-window .modal-box .modal-buttons a.modal-btn i,#modal-window .modal-box .modal-buttons a.modal-btn img{vertical-align:middle;display:inline-block;float:left;max-height:16px;margin-right:5px}#modal-window .modal-box .modal-buttons a.modal-btn{background-color:#fcfcfc;border-color:#c9c9c9;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.08);-moz-box-shadow:0 1px 1px rgba(0,0,0,.08);box-shadow:0 1px 1px rgba(0,0,0,.08)}#modal-window .modal-box .modal-buttons a.modal-btn.btn-green{background-color:#5cb85c;border-color:#4cae4c;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-green:hover{background-color:#449d44;border-color:#398439;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-purple{background-color:#8149B4;border-color:#6922AD;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-purple:hover{background-color:#6f32a8;border-color:#5b149e;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-orange{background-color:#f7aa47;border-color:#eea236;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-orange:hover{background-color:#f69f2f;border-color:#d58512;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-pink{background-color:#ff6264;border-color:#eb5b5c;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-pink:hover{background-color:#ff484b;border-color:#e53a3d;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-turquoise{background-color:#00b19d;border-color:#11a594;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-turquoise:hover{background-color:#009886;border-color:#0b8173;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-light-green{background-color:#8dc63f;border-color:#7db432;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-light-green:hover{background-color:#82b838;border-color:#75a336;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-light-blue{background-color:#428bca;border-color:#357ebd;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-light-blue:hover{background-color:#3071a9;border-color:#285e8e;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-blue{background-color:#0e62c7;border-color:#0D54AA;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-blue:hover{background-color:#0c56af;border-color:#0B4992;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-red{background-color:#cc3f44;border-color:#bd1b21;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-red:hover{background-color:#ab2d32;border-color:#96050b;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-light-red{background-color:#d9534f;border-color:#d43f3a;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-light-red:hover{background-color:#c9302c;border-color:#ac2925;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-yellow{background-color:#ffba00;border-color:#e4a703;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-yellow:hover{background-color:#f0bb2e;border-color:#dba71a;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-black{background-color:#444;border-color:#313131;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-black:hover{background-color:#333;border-color:#222;color:#fff}#modal-window .modal-box .modal-buttons a.modal-btn.btn-white{background-color:#fff;color:#555;border:1px solid #ddd}#modal-window .modal-box .modal-buttons a.modal-btn.btn-white:hover{background-color:#f7f7f7;border:1px solid #ccc}#modal-window .modal-box .modal-buttons a.modal-btn.btn-white:active,#modal-window .modal-box .modal-buttons a.modal-btn.btn-white:focus{-webkit-box-shadow:inset 0 0 10px rgba(0,0,0,.1);-moz-box-shadow:inset 0 0 10px rgba(0,0,0,.1);box-shadow:inset 0 0 10px rgba(0,0,0,.1)}#modal-window .modal-box.modal-type-success .modal-title{background-color:#61b832}#modal-window .modal-box.modal-type-warning .modal-title{background-color:#f1b40e}#modal-window .modal-box.modal-type-error .modal-title{background-color:#de4343}#modal-window .modal-box.modal-type-info .modal-title{background-color:#4ea5cd}#modal-window .modal-box.modal-type-inverted .modal-title{background-color:#232B31}#modal-window .modal-box.modal-type-primary .modal-title{background-color:#428bca}#modal-window .modal-box.modal-type-error .modal-title,#modal-window .modal-box.modal-type-info .modal-title,#modal-window .modal-box.modal-type-inverted .modal-title,#modal-window .modal-box.modal-type-primary .modal-title,#modal-window .modal-box.modal-type-success .modal-title,#modal-window .modal-box.modal-type-warning .modal-title{color:#FFF;text-shadow:0 1px 3px rgba(0,0,0,.25);border-bottom-color:transparent}#modal-window .modal-box.modal-type-error .modal-title .modal-close-btn,#modal-window .modal-box.modal-type-info .modal-title .modal-close-btn,#modal-window .modal-box.modal-type-inverted .modal-title .modal-close-btn,#modal-window .modal-box.modal-type-primary .modal-title .modal-close-btn,#modal-window .modal-box.modal-type-success .modal-title .modal-close-btn,#modal-window .modal-box.modal-type-warning .modal-title .modal-close-btn{background:url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNYAMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAHvgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jkKmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBblCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc88SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmkAuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdfeLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5nwl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKAgDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCBKrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQiiGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRByAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUopUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBzPEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXACTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0JroR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTSEtJG0m5SI+ksqZs0SBoj k8naZGuyBzmULCAryIXkneTD5DPkG+Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQRNY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uhHdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+YTKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVKmqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2epO6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIWsNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSKtRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acKpxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6VhlWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7ppSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFostqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6TvZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsbxt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWTNz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw34MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1KNSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87fOH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAqqBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NXkkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqohTZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVFoo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqGnRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6ebeLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPSA/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4iNwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtbYlu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36RueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/pH1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suuFxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz/GMzLdsAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAAAKNJREFUeNqkk9EKwyAMRdMKfqG/WBD2hYWMs4epZBLjoBcEibnHNokHIE90mn0SkUtESpBfWk4aEUCABLz46gZKi9tV2hktNwEDUPnVDLHmrmoBBdAFxDNrv2D+RA+yNM+AFWRp9gARRL3inot2vf+MSdQqT3f0C6tqawTZmcumxQNwbQrmQS4LyGaUNRhlNaOc5xrkNp6e2UJqNwNyPH3OnwEACDCs273A8sIAAAAASUVORK5CYII=') center no-repeat}#modal-window .modal-box.modal-theme-reseted{background:0 0;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none}#modal-window .modal-box.modal-theme-reseted .modal-title{border-bottom:0;padding:0}#modal-window .modal-box.modal-theme-reseted .modal-title .modal-close-btn{right:0}#modal-window .modal-box.modal-theme-reseted .modal-text{padding:0}#modal-window .modal-box.modal-theme-reseted .modal-buttons{border-top:0;background:0 0;padding:0}

/*CSS ICONS 
http://androidcss.com/css-shape-icon-generator/
*/

.dupx-plus-square{display:inline-block!important;position:relative;width:14px;height:14px;border-radius:25%;background-color:#000000;box-sizing:content-box}
.dupx-plus-square:before{position:absolute;content:'';margin:auto;width:calc(14px/8);height:calc(14px/1.5);background-color:#fff;top:0;bottom:0;left:0;right:0}
.dupx-plus-square:after{position:absolute;content:'';margin:auto;width:calc(14px/1.5);height:calc(14px/8);background-color:#fff;top:0;bottom:0;left:0;right:0}

.dupx-minus-square{display:inline-block!important;position:relative;width:14px;height:14px;border-radius:25%;background-color:#000000;box-sizing:content-box}
.dupx-minus-square:after{position:absolute;content:'';margin:auto;width:calc(14px/1.5);height:calc(14px/10);background-color:#fff;top:0;bottom:0;left:0;right:0}


</style>
	
		
	<style>
	body {font-family:Verdana,Arial,sans-serif; font-size:13px;}
	fieldset {border:1px solid silver; border-radius:5px; padding:10px}
	h3 {margin:1px; padding:1px; font-size:13px;}
	a {color:#222}
	a:hover{color:gray}
	input[type=text], input[type=password], select {width:97%; border-radius:2px; border:1px solid silver; padding:4px;  font-family:Verdana,Arial,sans-serif;}
	select {padding-left:0; width:99%}
	select:disabled {background:#EBEBE4}
	input.readonly {background-color:#efefef;}

	/* ============================
	COMMON VIEWS
     ============================ */
	div#content {border:1px solid #CDCDCD; width:750px; min-height:550px; margin:auto; margin-top:18px; border-radius:5px; box-shadow:0 8px 6px -6px #333; font-size:13px}
	div#content-inner {padding:10px 25px; min-height:550px}
	form.content-form {min-height:550px; position:relative; line-height:17px}
    div.status-badge-pass {border-radius:4px; color:#fff; padding:0 4px 0 4px;  font-size:12px; min-width:30px; text-align:center; background-color:#418446;display:inline-block }
    div.status-badge-fail {border-radius:4px; color:#fff; padding:0 4px 0 4px;  font-size:12px; min-width:30px; text-align:center; background-color:maroon; display:inline-block}
	
	/* WIZARD STEPS */
	table.dupx-header {border-top-left-radius:5px; border-top-right-radius:5px; width:100%; box-shadow:0 5px 3px -3px #999;	background-color:#F1F1F1; font-weight:bold;}
    .dupx-header-version {white-space:nowrap; color:#777; font-size:11px; font-style:italic; text-align:right;  padding:0 15px 5px 0; line-height:14px; font-weight:normal;}
	.dupx-header-version a {color:#555;}
    div.dupx-logfile-link {float:right; font-weight:normal; font-size:11px; font-style:italic}
	div#progress-area {padding:5px; margin:150px 0 0 0px; text-align:center;}
	div#ajaxerr-data {padding:5px; height:350px; width:99%; border:1px solid silver; border-radius:5px; background-color:#efefef; font-size:13px; overflow-y:scroll; line-height:24px}

    /*TITLE HEADERS */
    div.hdr-main {font-size:22px; padding:0 0 5px 0; border-bottom:1px solid #D3D3D3; font-weight:bold; margin:15px 0 20px 0;}
	div.hdr-main span.step {color:#DB4B38}
	div.hdr-sub1 {font-size:18px; margin-bottom:5px;border:1px solid #D3D3D3;padding:7px; background-color:#f9f9f9; font-weight:bold; border-radius:4px}
	div.hdr-sub1 a {cursor:pointer; text-decoration: none !important}
	div.hdr-sub1:hover {cursor:pointer; background-color:#f1f1f1; border:1px solid #dcdcdc; }
	div.hdr-sub1:hover a{color:#000}
	div.hdr-sub2 {font-size:15px; padding:2px 2px 2px 0; border-bottom:1px solid #D3D3D3; font-weight:bold; margin-bottom:5px; border:none}
	div.hdr-sub3 {font-size:15px; padding:2px 2px 2px 0; border-bottom:1px solid #D3D3D3; font-weight:bold; margin-bottom:5px;}
	div.hdr-sub4 {font-size:15px; padding:7px; border:1px solid #D3D3D3;; font-weight:bold; background-color:#e9e9e9;}
	div.hdr-sub4:hover  {background-color:#dfdfdf; cursor:pointer}

    /* BUTTONS */
	div.dupx-footer-buttons {position:absolute; bottom:10px; padding:10px;  right:0}
	div.dupx-footer-buttons  input:hover, button:hover {border:1px solid #000}
	div.dupx-footer-buttons input[disabled=disabled]{background-color:#F4F4F4; color:silver; border:1px solid silver;}
	div.dupx-footer-buttons button[disabled]{background-color:#F4F4F4; color:silver; border:1px solid silver;}
    button.default-btn, input.default-btn {
		cursor:pointer; color:#fff; font-size:16px; border-radius:5px;	padding:8px 25px 6px 25px;
	    background-color:#13659C; border:1px solid gray;
	}
    table.dupx-opts {width:100%; border:0px;}
	table.dupx-opts td{white-space:nowrap; padding:3px;}
	table.dupx-opts td:first-child{width:125px; font-weight: bold}
	table.dupx-advopts td:first-child{width:125px; font-weight:bold}
	table.dupx-advopts td label{min-width:60px; display:inline-block; cursor:pointer}

    .dupx-pass {display:inline-block; color:green;}
	.dupx-fail {display:inline-block; color:#AF0000;}
	.dupx-notice {display:inline-block; color:#000;}
	div.dupx-ui-error {padding-top:2px; font-size:13px; line-height: 20px}

	 /*Dialog Info */
	div.dlg-serv-info {line-height:22px; font-size:12px; margin:0}
	div.dlg-serv-info div.info-txt {text-align: center; font-size:11px; font-style:italic}
	div.dlg-serv-info label {display:inline-block; width:175px; font-weight: bold}
    div.dlg-serv-info div.hdr {background-color: #dfdfdf; font-weight: bold; margin-top:5px; border-radius: 4px; padding:2px 5px 2px 5px; border: 1px solid silver; font-size: 16px}
	div#modal-window div.modal-title {background-color:#D0D0D0}
	div#modal-window div.modal-text {padding-top:10px !important}
	div.installer-mode {font-weight:normal; position:absolute; top:5px; right:20px; font-style:italic; font-size:11px}
	i.secure-unlocked {color:maroon;}

	
	/* ============================
	INIT 1:SECURE PASSWORD
	============================ */
    button.pass-toggle {height:26px; width:26px; position:absolute; top:0px; right:0px; border:1px solid silver;  border-radius:0 4px 4px 0;}
	button.pass-toggle  i { padding:0; display:block; margin:-4px 0 0 -5px}
	div.i1-pass-area {width:100%; text-align:center}
	div.i1-pass-data {padding:30px; margin:auto; text-align:center; width:300px}
	div.i1-pass-data table {width:100%; border-collapse:collapse; padding:0}
	div.i1-pass-data label {font-weight:bold}
	div.i1-pass-errmsg {color:maroon; font-weight:bold}
	div#i1-pass-input {position:relative; margin:2px 0 15px 0}
	input#secure-pass {border-radius:4px 0 0 4px; width:250px}
	div.error-pane {border:1px solid #efefef; border-left:4px solid #D54E21; padding:0 0 0 10px; margin:2px 0 10px 0}
	div.dupx-ui-error {padding-top:2px; font-size:13px; line-height: 20px}
	label.secure-lock {cursor:pointer}
	
	/* ======================================
	STEP 1 VIEW
    ====================================== */
	table.s1-archive-local {width:100%}
    table.s1-archive-local td {padding:4px 4px 4px 4px}
	table.s1-archive-local td:first-child {font-weight:bold; width:55px}
    div#s1-area-sys-setup {padding:5px 0 0 10px}
	div#s1-area-sys-setup div.info-top {text-align:center; font-style:italic; font-size:11px; padding:0 5px 5px 5px}
	table.s1-checks-area {width:100%; margin:0; padding:0}
	table.s1-checks-area td.title {font-size:16px; width:100%}
	table.s1-checks-area td.title small {font-size:11px; font-weight:normal}
	table.s1-checks-area td.toggle {font-size:11px; margin-right:7px; font-weight:normal}

	div.s1-reqs {background-color:#efefef; border:1px solid silver; border-radius:5px; margin-top:-5px}
	div.s1-reqs div.header {background-color:#E0E0E0; color:#000;  border-bottom: 1px solid silver; padding:2px; font-weight:bold }
	div.s1-reqs div.notice {background-color:#E0E0E0; color:#000; text-align:center; font-size:12px; border-bottom: 1px solid silver; padding:2px; font-style:italic}
	div.s1-reqs div.status {float:right; border-radius:4px; color:#fff; padding:0 4px 0 4px; margin:4px 5px 0 0; font-size:12px; min-width:30px; text-align:center; font-weight:bold}
	div.s1-reqs div.pass {background-color:green;}
	div.s1-reqs div.fail {background-color:maroon;}
	div.s1-reqs div.title {padding:4px; font-size:13px;}
	div.s1-reqs div.title:hover {background-color:#dfdfdf; cursor:pointer}
	div.s1-reqs div.info {padding:8px 8px 20px 8px; background-color:#fff; display:none; line-height:18px; font-size: 12px}
	div.s1-reqs div.info a {color:#485AA3;}
    div.s1-archive-failed-msg {padding:15px; border:1px dashed silver; font-size: 12px; border-radius:5px}
    div.s1-err-msg {padding:8px;  border:1px dashed #999; margin:20px 0 20px 0px; border-radius:5px; color:maroon}

    /*Terms and Notices*/
	div#s1-warning-check label{cursor:pointer;}
    div#s1-warning-msg {padding:5px;font-size:12px; color:#333; line-height:14px;font-style:italic; overflow-y:scroll; height:250px; border:1px solid #dfdfdf; background:#fff; border-radius:3px}
	div#s1-warning-check {padding:3px; font-size:14px; font-weight:normal;}
    input#accept-warnings {height: 17px; width:17px}
	
    /* ======================================
	STEP 2 VIEW
    ====================================== */
	/*Toggle Buttons */
	div.s2-btngrp {text-align:center; margin:0 auto 10px auto}
	div.s2-btngrp input[type=button] {font-size:14px; padding:6px; width:120px; border:1px solid silver;  cursor:pointer}
	div.s2-btngrp input[type=button]:first-child {border-radius:5px 0 0 5px; margin-right:-2px}
	div.s2-btngrp input[type=button]:last-child {border-radius:0 5px 5px 0; margin-left:-4px}
	div.s2-btngrp input[type=button].active {background-color:#13659C; color:#fff;}
	div.s2-btngrp input[type=button].in-active {background-color:#E4E4E4; }
	div.s2-btngrp input[type=button]:hover {border:1px solid #999}

	div.s2-modes {padding:0px 15px 0 0px;}
	div#s2-dbconn {margin:auto; text-align:center; margin:15px 0 10px 0px}
	input.s2-small-btn {height:25px; border:1px solid gray; border-radius:3px; cursor:pointer}
    table.s2-opts-dbhost td {padding:0; margin:0}
	input#s2-dbport-btn { width:80px}
	div.s2-db-test small{display:block; font-style:italic; color:#333; padding:3px 2px 5px 2px; border-bottom:1px dashed silver; margin-bottom:10px; text-align: center }
	table.s2-db-test-dtls {text-align: left; margin: auto}
	table.s2-db-test-dtls td:first-child {font-weight: bold}
	div#s2-dbconn-test-msg {font-size:12px}
	div#s2-dbconn-status {border:1px solid silver; border-radius:3px; background-color:#f9f9f9; padding:2px 5px; margin-top:10px; height:200px; overflow-y: scroll}
	div#s2-dbconn-status div.warn-msg {text-align: left; padding:5px; margin:10px 0 10px 0}
	div#s2-dbconn-status div.warn-msg b{color:maroon}

	/*cPanel Tab */
	div#s2-cpnl-pane {display: none; min-height: 190px;}
	div.s2-gopro {color: black; margin-top:10px; padding:0 20px 10px 20px; border: 1px solid silver; background-color:#F6F6F6; border-radius: 4px}
	div.s2-gopro h2 {text-align: center; margin:10px}
	div.s2-gopro small {font-style: italic}
	div.s2-cpanel-login {padding:15px; color:#fff; text-align:center; margin:15px 5px 15px 5px; border:1px solid silver; border-radius:5px; background-color:#13659C; font-size:14px; line-height:22px}
	div.s2-cpanel-off {padding:15px; color:#fff; text-align:center; margin:15px 5px 15px 5px; border:1px solid silver; border-radius:5px; background-color:#b54949; font-size:14px; line-height:22px}
	
	/*Advanced Options & Warning Area*/
	div#s2-area-adv-opts label {cursor: pointer}
	div#s2-warning {padding:5px;font-size:12px; color:gray; line-height:12px;font-style:italic; overflow-y:scroll; height:150px; border:1px solid #dfdfdf; background-color:#fff; border-radius:3px}
	div#s2-warning-check {padding:5px; font-size:12px; font-weight:normal; font-style:italic;}
    div#s2-warning-check label {cursor: pointer; line-height: 14px}
	div#s2-warning-emptydb {display:none; color:#AF2222; margin:2px 0 0 0; font-size: 11px}
	table.s2-advopts label.radio {width:50px; display:inline-block}

	/* ======================================
	STEP 3 VIEW
    ====================================== */
	table.s3-table-inputs {width:100%; border:0px;}
	table.s3-table-inputs td{white-space:nowrap; padding:2px;}
    table.s3-table-inputs td:first-child{font-weight: bold; width:125px}
	div#s3-adv-opts {margin-top:5px; }
	div.s3-allnonelinks {font-size:11px; float:right;}
	select#plugins {width:330px; height:100px}
	select#tables {width:330px; height:100px}

	/* password indicator */
	.top_testresult{font-weight:bold;	font-size:11px; color:#222;	padding:1px 1px 1px 4px; margin:4px 0 0 0px; width:495px; dislay:inline-block}
	.top_testresult span{margin:0;}
	.top_shortPass{background:#edabab; border:1px solid #bc0000;display:block;}
	.top_badPass{background:#edabab;border:1px solid #bc0000;display:block;}
	.top_goodPass{background:#ffffe0; border:1px solid #e6db55;	display:block;}
	.top_strongPass{background:#d3edab;	border:1px solid #73bc00; display:block;}

	/* ======================================
	STEP 4 VIEW
	====================================== */
	div.s4-final-title {color:#BE2323;font-size:18px}
	div.s4-connect {font-size:12px; text-align:center; font-style:italic; position:absolute; bottom:10px; padding:10px; width:100%; margin-top:20px}
	table.s4-report-results,
	table.s4-report-errs {border-collapse:collapse; border:1px solid #dfdfdf; }
	table.s4-report-errs  td {text-align:center; width:33%}
	table.s4-report-results th, table.s4-report-errs th {background-color:#efefef; padding:0px; font-size:13px; padding:0px}
	table.s4-report-results td, table.s4-report-errs td {padding:0px; white-space:nowrap; border:1px solid #dfdfdf; text-align:center; font-size:12px}
	table.s4-report-results td:first-child {text-align:left; font-weight:bold; padding-left:3px}
	div.s4-err-title {background-color:#dfdfdf; font-weight: bold; margin:-3px 0 15px 0; padding:5px; border-radius:3px; font-size:13px}

	div.s4-err-msg {padding:8px;  display:none; border:1px dashed #999; margin:10px 0 20px 0px; border-radius:5px;}
	div.s4-err-msg div.content{padding:5px; font-size:11px; line-height:17px; max-height:125px; overflow-y:scroll; border:1px solid silver; margin:3px;  }
	div.s4-err-msg div.info-error{padding:7px; background-color:#f9c9c9; border:1px solid silver; border-radius:2px; font-size:12px; line-height:16px }
	div.s4-err-msg div.info-notice{padding:7px; background-color:#FCFEC5; border:1px solid silver; border-radius:2px; font-size:12px; line-height:16px;}
	table.s4-final-step {width:100%;}
	table.s4-final-step td {padding:5px 15px 5px 5px}
	table.s4-final-step td:first-child {white-space:nowrap;}
	div.s4-go-back {border-top:1px dotted #dfdfdf; margin:auto; font-style:italic; font-size:10px; color:#333}
	a.s4-final-btns {display: block; width:145px; padding:5px; line-height: 1.4; background-color:#F1F1F1; border:1px solid silver;
		color: #000; box-shadow: 5px 5px 5px -5px #949494; text-decoration: none; text-align: center; border-radius: 4px;
	}
	a.s4-final-btns:hover {background-color: #dfdfdf;}
	div.s4-gopro-btn {text-align:center; font-size:14px; margin:auto; width:200px; font-style: italic; font-weight:bold}
	div.s4-gopro-btn a{color:green}


	/* PARSLEY:Overrides*/
	input.parsley-error, textarea.parsley-error, select.parsley-error {
	  color:#B94A48 !important;  background-color:#F2DEDE !important; border:1px solid #EED3D7 !important;
	}
	ul.parsley-errors-list {margin:1px 0 0 -40px; list-style-type:none; font-size:10px}

	/* ============================
	STEP 5 HELP
	============================	*/
	div.help-target {float:right; font-size:11px}
	div#main-help a.help-target {display:block; margin:5px}
	div#main-help sup {font-size:11px; font-weight:normal; font-style:italic; color:blue}
	div.help-online {text-align:center; font-size:18px; padding:10px 0 0 0; line-height:24px}
	div.help {color:#555; font-style:italic; font-size:11px; padding:4px; border-top:1px solid #dfdfdf}
	div.help-page {padding:5px 0 0 5px}
	div.help-page fieldset {margin-bottom:25px}
    div#main-help {font-size:13px; line-height:17px}
	div#main-help h2 {background-color:#F1F1F1; border:1px solid silver; border-radius:4px; padding:10px; margin:26px 0 8px 0; font-size:22px; }
	div#main-help h3 {border-bottom:1px solid silver; padding:8px; margin:4px 0 8px 0; font-size:20px}
    div#main-help span.step {color:#DB4B38}
	table.help-opt {width: 100%; border: none; border-collapse: collapse;  margin:5px 0 0 0;}
	table.help-opt td.section {background-color:#dfdfdf;}
	table.help-opt td, th {padding:7px; border:1px solid silver;}
	table.help-opt td:first-child {font-weight:bold; padding-right:10px; white-space:nowrap}
	table.help-opt th {background: #333; color: #fff;border:1px solid #333; padding:3px}


	<?php if ($GLOBALS['DUPX_DEBUG']) : ?>
		.dupx-debug {display:block; margin:4px 0 30px 0; font-size:11px;}
		.dupx-debug label {font-weight:bold; display:block; margin:6px 0 2px 0}
		.dupx-debug textarea {width:95%; height:100px; font-size:11px}
	<?php else : ?>
		.dupx-debug {display:none}
	<?php endif; ?>
	small.s3-warn {color: maroon;font-style: italic;}
	div.s4-warn {color: maroon;}

</style>	
	<?php
	// Exit if accessed directly
	if (! defined('DUPLICATOR_INIT')) {
		$_baseURL = "http://" . strlen($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $_baseURL");
		exit; 
	}
?>
<!-- ========================================
JQUERY ASSETS -->
<?php if(DUPX_U::isURLActive("ajax.googleapis.com", 443) ): ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<?php else: ?>
	<script type="text/javascript">
	/*! jQuery v2.1.3 | (c) 2005, 2014 jQuery Foundation, Inc. | jquery.org/license */
	!function(a,b){"object"==typeof module&&"object"==typeof module.exports?module.exports=a.document?b(a,!0):function(a){if(!a.document)throw new Error("jQuery requires a window with a document");return b(a)}:b(a)}("undefined"!=typeof window?window:this,function(a,b){var c=[],d=c.slice,e=c.concat,f=c.push,g=c.indexOf,h={},i=h.toString,j=h.hasOwnProperty,k={},l=a.document,m="2.1.3",n=function(a,b){return new n.fn.init(a,b)},o=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,p=/^-ms-/,q=/-([\da-z])/gi,r=function(a,b){return b.toUpperCase()};n.fn=n.prototype={jquery:m,constructor:n,selector:"",length:0,toArray:function(){return d.call(this)},get:function(a){return null!=a?0>a?this[a+this.length]:this[a]:d.call(this)},pushStack:function(a){var b=n.merge(this.constructor(),a);return b.prevObject=this,b.context=this.context,b},each:function(a,b){return n.each(this,a,b)},map:function(a){return this.pushStack(n.map(this,function(b,c){return a.call(b,c,b)}))},slice:function(){return this.pushStack(d.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},eq:function(a){var b=this.length,c=+a+(0>a?b:0);return this.pushStack(c>=0&&b>c?[this[c]]:[])},end:function(){return this.prevObject||this.constructor(null)},push:f,sort:c.sort,splice:c.splice},n.extend=n.fn.extend=function(){var a,b,c,d,e,f,g=arguments[0]||{},h=1,i=arguments.length,j=!1;for("boolean"==typeof g&&(j=g,g=arguments[h]||{},h++),"object"==typeof g||n.isFunction(g)||(g={}),h===i&&(g=this,h--);i>h;h++)if(null!=(a=arguments[h]))for(b in a)c=g[b],d=a[b],g!==d&&(j&&d&&(n.isPlainObject(d)||(e=n.isArray(d)))?(e?(e=!1,f=c&&n.isArray(c)?c:[]):f=c&&n.isPlainObject(c)?c:{},g[b]=n.extend(j,f,d)):void 0!==d&&(g[b]=d));return g},n.extend({expando:"jQuery"+(m+Math.random()).replace(/\D/g,""),isReady:!0,error:function(a){throw new Error(a)},noop:function(){},isFunction:function(a){return"function"===n.type(a)},isArray:Array.isArray,isWindow:function(a){return null!=a&&a===a.window},isNumeric:function(a){return!n.isArray(a)&&a-parseFloat(a)+1>=0},isPlainObject:function(a){return"object"!==n.type(a)||a.nodeType||n.isWindow(a)?!1:a.constructor&&!j.call(a.constructor.prototype,"isPrototypeOf")?!1:!0},isEmptyObject:function(a){var b;for(b in a)return!1;return!0},type:function(a){return null==a?a+"":"object"==typeof a||"function"==typeof a?h[i.call(a)]||"object":typeof a},globalEval:function(a){var b,c=eval;a=n.trim(a),a&&(1===a.indexOf("use strict")?(b=l.createElement("script"),b.text=a,l.head.appendChild(b).parentNode.removeChild(b)):c(a))},camelCase:function(a){return a.replace(p,"ms-").replace(q,r)},nodeName:function(a,b){return a.nodeName&&a.nodeName.toLowerCase()===b.toLowerCase()},each:function(a,b,c){var d,e=0,f=a.length,g=s(a);if(c){if(g){for(;f>e;e++)if(d=b.apply(a[e],c),d===!1)break}else for(e in a)if(d=b.apply(a[e],c),d===!1)break}else if(g){for(;f>e;e++)if(d=b.call(a[e],e,a[e]),d===!1)break}else for(e in a)if(d=b.call(a[e],e,a[e]),d===!1)break;return a},trim:function(a){return null==a?"":(a+"").replace(o,"")},makeArray:function(a,b){var c=b||[];return null!=a&&(s(Object(a))?n.merge(c,"string"==typeof a?[a]:a):f.call(c,a)),c},inArray:function(a,b,c){return null==b?-1:g.call(b,a,c)},merge:function(a,b){for(var c=+b.length,d=0,e=a.length;c>d;d++)a[e++]=b[d];return a.length=e,a},grep:function(a,b,c){for(var d,e=[],f=0,g=a.length,h=!c;g>f;f++)d=!b(a[f],f),d!==h&&e.push(a[f]);return e},map:function(a,b,c){var d,f=0,g=a.length,h=s(a),i=[];if(h)for(;g>f;f++)d=b(a[f],f,c),null!=d&&i.push(d);else for(f in a)d=b(a[f],f,c),null!=d&&i.push(d);return e.apply([],i)},guid:1,proxy:function(a,b){var c,e,f;return"string"==typeof b&&(c=a[b],b=a,a=c),n.isFunction(a)?(e=d.call(arguments,2),f=function(){return a.apply(b||this,e.concat(d.call(arguments)))},f.guid=a.guid=a.guid||n.guid++,f):void 0},now:Date.now,support:k}),n.each("Boolean Number String Function Array Date RegExp Object Error".split(" "),function(a,b){h["[object "+b+"]"]=b.toLowerCase()});function s(a){var b=a.length,c=n.type(a);return"function"===c||n.isWindow(a)?!1:1===a.nodeType&&b?!0:"array"===c||0===b||"number"==typeof b&&b>0&&b-1 in a}var t=function(a){var b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u="sizzle"+1*new Date,v=a.document,w=0,x=0,y=hb(),z=hb(),A=hb(),B=function(a,b){return a===b&&(l=!0),0},C=1<<31,D={}.hasOwnProperty,E=[],F=E.pop,G=E.push,H=E.push,I=E.slice,J=function(a,b){for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return c;return-1},K="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",L="[\\x20\\t\\r\\n\\f]",M="(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",N=M.replace("w","w#"),O="\\["+L+"*("+M+")(?:"+L+"*([*^$|!~]?=)"+L+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+N+"))|)"+L+"*\\]",P=":("+M+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+O+")*)|.*)\\)|)",Q=new RegExp(L+"+","g"),R=new RegExp("^"+L+"+|((?:^|[^\\\\])(?:\\\\.)*)"+L+"+$","g"),S=new RegExp("^"+L+"*,"+L+"*"),T=new RegExp("^"+L+"*([>+~]|"+L+")"+L+"*"),U=new RegExp("="+L+"*([^\\]'\"]*?)"+L+"*\\]","g"),V=new RegExp(P),W=new RegExp("^"+N+"$"),X={ID:new RegExp("^#("+M+")"),CLASS:new RegExp("^\\.("+M+")"),TAG:new RegExp("^("+M.replace("w","w*")+")"),ATTR:new RegExp("^"+O),PSEUDO:new RegExp("^"+P),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+L+"*(even|odd|(([+-]|)(\\d*)n|)"+L+"*(?:([+-]|)"+L+"*(\\d+)|))"+L+"*\\)|)","i"),bool:new RegExp("^(?:"+K+")$","i"),needsContext:new RegExp("^"+L+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+L+"*((?:-\\d)?\\d*)"+L+"*\\)|)(?=[^-]|$)","i")},Y=/^(?:input|select|textarea|button)$/i,Z=/^h\d$/i,$=/^[^{]+\{\s*\[native \w/,_=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,ab=/[+~]/,bb=/'|\\/g,cb=new RegExp("\\\\([\\da-f]{1,6}"+L+"?|("+L+")|.)","ig"),db=function(a,b,c){var d="0x"+b-65536;return d!==d||c?b:0>d?String.fromCharCode(d+65536):String.fromCharCode(d>>10|55296,1023&d|56320)},eb=function(){m()};try{H.apply(E=I.call(v.childNodes),v.childNodes),E[v.childNodes.length].nodeType}catch(fb){H={apply:E.length?function(a,b){G.apply(a,I.call(b))}:function(a,b){var c=a.length,d=0;while(a[c++]=b[d++]);a.length=c-1}}}function gb(a,b,d,e){var f,h,j,k,l,o,r,s,w,x;if((b?b.ownerDocument||b:v)!==n&&m(b),b=b||n,d=d||[],k=b.nodeType,"string"!=typeof a||!a||1!==k&&9!==k&&11!==k)return d;if(!e&&p){if(11!==k&&(f=_.exec(a)))if(j=f[1]){if(9===k){if(h=b.getElementById(j),!h||!h.parentNode)return d;if(h.id===j)return d.push(h),d}else if(b.ownerDocument&&(h=b.ownerDocument.getElementById(j))&&t(b,h)&&h.id===j)return d.push(h),d}else{if(f[2])return H.apply(d,b.getElementsByTagName(a)),d;if((j=f[3])&&c.getElementsByClassName)return H.apply(d,b.getElementsByClassName(j)),d}if(c.qsa&&(!q||!q.test(a))){if(s=r=u,w=b,x=1!==k&&a,1===k&&"object"!==b.nodeName.toLowerCase()){o=g(a),(r=b.getAttribute("id"))?s=r.replace(bb,"\\$&"):b.setAttribute("id",s),s="[id='"+s+"'] ",l=o.length;while(l--)o[l]=s+rb(o[l]);w=ab.test(a)&&pb(b.parentNode)||b,x=o.join(",")}if(x)try{return H.apply(d,w.querySelectorAll(x)),d}catch(y){}finally{r||b.removeAttribute("id")}}}return i(a.replace(R,"$1"),b,d,e)}function hb(){var a=[];function b(c,e){return a.push(c+" ")>d.cacheLength&&delete b[a.shift()],b[c+" "]=e}return b}function ib(a){return a[u]=!0,a}function jb(a){var b=n.createElement("div");try{return!!a(b)}catch(c){return!1}finally{b.parentNode&&b.parentNode.removeChild(b),b=null}}function kb(a,b){var c=a.split("|"),e=a.length;while(e--)d.attrHandle[c[e]]=b}function lb(a,b){var c=b&&a,d=c&&1===a.nodeType&&1===b.nodeType&&(~b.sourceIndex||C)-(~a.sourceIndex||C);if(d)return d;if(c)while(c=c.nextSibling)if(c===b)return-1;return a?1:-1}function mb(a){return function(b){var c=b.nodeName.toLowerCase();return"input"===c&&b.type===a}}function nb(a){return function(b){var c=b.nodeName.toLowerCase();return("input"===c||"button"===c)&&b.type===a}}function ob(a){return ib(function(b){return b=+b,ib(function(c,d){var e,f=a([],c.length,b),g=f.length;while(g--)c[e=f[g]]&&(c[e]=!(d[e]=c[e]))})})}function pb(a){return a&&"undefined"!=typeof a.getElementsByTagName&&a}c=gb.support={},f=gb.isXML=function(a){var b=a&&(a.ownerDocument||a).documentElement;return b?"HTML"!==b.nodeName:!1},m=gb.setDocument=function(a){var b,e,g=a?a.ownerDocument||a:v;return g!==n&&9===g.nodeType&&g.documentElement?(n=g,o=g.documentElement,e=g.defaultView,e&&e!==e.top&&(e.addEventListener?e.addEventListener("unload",eb,!1):e.attachEvent&&e.attachEvent("onunload",eb)),p=!f(g),c.attributes=jb(function(a){return a.className="i",!a.getAttribute("className")}),c.getElementsByTagName=jb(function(a){return a.appendChild(g.createComment("")),!a.getElementsByTagName("*").length}),c.getElementsByClassName=$.test(g.getElementsByClassName),c.getById=jb(function(a){return o.appendChild(a).id=u,!g.getElementsByName||!g.getElementsByName(u).length}),c.getById?(d.find.ID=function(a,b){if("undefined"!=typeof b.getElementById&&p){var c=b.getElementById(a);return c&&c.parentNode?[c]:[]}},d.filter.ID=function(a){var b=a.replace(cb,db);return function(a){return a.getAttribute("id")===b}}):(delete d.find.ID,d.filter.ID=function(a){var b=a.replace(cb,db);return function(a){var c="undefined"!=typeof a.getAttributeNode&&a.getAttributeNode("id");return c&&c.value===b}}),d.find.TAG=c.getElementsByTagName?function(a,b){return"undefined"!=typeof b.getElementsByTagName?b.getElementsByTagName(a):c.qsa?b.querySelectorAll(a):void 0}:function(a,b){var c,d=[],e=0,f=b.getElementsByTagName(a);if("*"===a){while(c=f[e++])1===c.nodeType&&d.push(c);return d}return f},d.find.CLASS=c.getElementsByClassName&&function(a,b){return p?b.getElementsByClassName(a):void 0},r=[],q=[],(c.qsa=$.test(g.querySelectorAll))&&(jb(function(a){o.appendChild(a).innerHTML="<a id='"+u+"'></a><select id='"+u+"-\f]' msallowcapture=''><option selected=''></option></select>",a.querySelectorAll("[msallowcapture^='']").length&&q.push("[*^$]="+L+"*(?:''|\"\")"),a.querySelectorAll("[selected]").length||q.push("\\["+L+"*(?:value|"+K+")"),a.querySelectorAll("[id~="+u+"-]").length||q.push("~="),a.querySelectorAll(":checked").length||q.push(":checked"),a.querySelectorAll("a#"+u+"+*").length||q.push(".#.+[+~]")}),jb(function(a){var b=g.createElement("input");b.setAttribute("type","hidden"),a.appendChild(b).setAttribute("name","D"),a.querySelectorAll("[name=d]").length&&q.push("name"+L+"*[*^$|!~]?="),a.querySelectorAll(":enabled").length||q.push(":enabled",":disabled"),a.querySelectorAll("*,:x"),q.push(",.*:")})),(c.matchesSelector=$.test(s=o.matches||o.webkitMatchesSelector||o.mozMatchesSelector||o.oMatchesSelector||o.msMatchesSelector))&&jb(function(a){c.disconnectedMatch=s.call(a,"div"),s.call(a,"[s!='']:x"),r.push("!=",P)}),q=q.length&&new RegExp(q.join("|")),r=r.length&&new RegExp(r.join("|")),b=$.test(o.compareDocumentPosition),t=b||$.test(o.contains)?function(a,b){var c=9===a.nodeType?a.documentElement:a,d=b&&b.parentNode;return a===d||!(!d||1!==d.nodeType||!(c.contains?c.contains(d):a.compareDocumentPosition&&16&a.compareDocumentPosition(d)))}:function(a,b){if(b)while(b=b.parentNode)if(b===a)return!0;return!1},B=b?function(a,b){if(a===b)return l=!0,0;var d=!a.compareDocumentPosition-!b.compareDocumentPosition;return d?d:(d=(a.ownerDocument||a)===(b.ownerDocument||b)?a.compareDocumentPosition(b):1,1&d||!c.sortDetached&&b.compareDocumentPosition(a)===d?a===g||a.ownerDocument===v&&t(v,a)?-1:b===g||b.ownerDocument===v&&t(v,b)?1:k?J(k,a)-J(k,b):0:4&d?-1:1)}:function(a,b){if(a===b)return l=!0,0;var c,d=0,e=a.parentNode,f=b.parentNode,h=[a],i=[b];if(!e||!f)return a===g?-1:b===g?1:e?-1:f?1:k?J(k,a)-J(k,b):0;if(e===f)return lb(a,b);c=a;while(c=c.parentNode)h.unshift(c);c=b;while(c=c.parentNode)i.unshift(c);while(h[d]===i[d])d++;return d?lb(h[d],i[d]):h[d]===v?-1:i[d]===v?1:0},g):n},gb.matches=function(a,b){return gb(a,null,null,b)},gb.matchesSelector=function(a,b){if((a.ownerDocument||a)!==n&&m(a),b=b.replace(U,"='$1']"),!(!c.matchesSelector||!p||r&&r.test(b)||q&&q.test(b)))try{var d=s.call(a,b);if(d||c.disconnectedMatch||a.document&&11!==a.document.nodeType)return d}catch(e){}return gb(b,n,null,[a]).length>0},gb.contains=function(a,b){return(a.ownerDocument||a)!==n&&m(a),t(a,b)},gb.attr=function(a,b){(a.ownerDocument||a)!==n&&m(a);var e=d.attrHandle[b.toLowerCase()],f=e&&D.call(d.attrHandle,b.toLowerCase())?e(a,b,!p):void 0;return void 0!==f?f:c.attributes||!p?a.getAttribute(b):(f=a.getAttributeNode(b))&&f.specified?f.value:null},gb.error=function(a){throw new Error("Syntax error, unrecognized expression: "+a)},gb.uniqueSort=function(a){var b,d=[],e=0,f=0;if(l=!c.detectDuplicates,k=!c.sortStable&&a.slice(0),a.sort(B),l){while(b=a[f++])b===a[f]&&(e=d.push(f));while(e--)a.splice(d[e],1)}return k=null,a},e=gb.getText=function(a){var b,c="",d=0,f=a.nodeType;if(f){if(1===f||9===f||11===f){if("string"==typeof a.textContent)return a.textContent;for(a=a.firstChild;a;a=a.nextSibling)c+=e(a)}else if(3===f||4===f)return a.nodeValue}else while(b=a[d++])c+=e(b);return c},d=gb.selectors={cacheLength:50,createPseudo:ib,match:X,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(a){return a[1]=a[1].replace(cb,db),a[3]=(a[3]||a[4]||a[5]||"").replace(cb,db),"~="===a[2]&&(a[3]=" "+a[3]+" "),a.slice(0,4)},CHILD:function(a){return a[1]=a[1].toLowerCase(),"nth"===a[1].slice(0,3)?(a[3]||gb.error(a[0]),a[4]=+(a[4]?a[5]+(a[6]||1):2*("even"===a[3]||"odd"===a[3])),a[5]=+(a[7]+a[8]||"odd"===a[3])):a[3]&&gb.error(a[0]),a},PSEUDO:function(a){var b,c=!a[6]&&a[2];return X.CHILD.test(a[0])?null:(a[3]?a[2]=a[4]||a[5]||"":c&&V.test(c)&&(b=g(c,!0))&&(b=c.indexOf(")",c.length-b)-c.length)&&(a[0]=a[0].slice(0,b),a[2]=c.slice(0,b)),a.slice(0,3))}},filter:{TAG:function(a){var b=a.replace(cb,db).toLowerCase();return"*"===a?function(){return!0}:function(a){return a.nodeName&&a.nodeName.toLowerCase()===b}},CLASS:function(a){var b=y[a+" "];return b||(b=new RegExp("(^|"+L+")"+a+"("+L+"|$)"))&&y(a,function(a){return b.test("string"==typeof a.className&&a.className||"undefined"!=typeof a.getAttribute&&a.getAttribute("class")||"")})},ATTR:function(a,b,c){return function(d){var e=gb.attr(d,a);return null==e?"!="===b:b?(e+="","="===b?e===c:"!="===b?e!==c:"^="===b?c&&0===e.indexOf(c):"*="===b?c&&e.indexOf(c)>-1:"$="===b?c&&e.slice(-c.length)===c:"~="===b?(" "+e.replace(Q," ")+" ").indexOf(c)>-1:"|="===b?e===c||e.slice(0,c.length+1)===c+"-":!1):!0}},CHILD:function(a,b,c,d,e){var f="nth"!==a.slice(0,3),g="last"!==a.slice(-4),h="of-type"===b;return 1===d&&0===e?function(a){return!!a.parentNode}:function(b,c,i){var j,k,l,m,n,o,p=f!==g?"nextSibling":"previousSibling",q=b.parentNode,r=h&&b.nodeName.toLowerCase(),s=!i&&!h;if(q){if(f){while(p){l=b;while(l=l[p])if(h?l.nodeName.toLowerCase()===r:1===l.nodeType)return!1;o=p="only"===a&&!o&&"nextSibling"}return!0}if(o=[g?q.firstChild:q.lastChild],g&&s){k=q[u]||(q[u]={}),j=k[a]||[],n=j[0]===w&&j[1],m=j[0]===w&&j[2],l=n&&q.childNodes[n];while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if(1===l.nodeType&&++m&&l===b){k[a]=[w,n,m];break}}else if(s&&(j=(b[u]||(b[u]={}))[a])&&j[0]===w)m=j[1];else while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if((h?l.nodeName.toLowerCase()===r:1===l.nodeType)&&++m&&(s&&((l[u]||(l[u]={}))[a]=[w,m]),l===b))break;return m-=e,m===d||m%d===0&&m/d>=0}}},PSEUDO:function(a,b){var c,e=d.pseudos[a]||d.setFilters[a.toLowerCase()]||gb.error("unsupported pseudo: "+a);return e[u]?e(b):e.length>1?(c=[a,a,"",b],d.setFilters.hasOwnProperty(a.toLowerCase())?ib(function(a,c){var d,f=e(a,b),g=f.length;while(g--)d=J(a,f[g]),a[d]=!(c[d]=f[g])}):function(a){return e(a,0,c)}):e}},pseudos:{not:ib(function(a){var b=[],c=[],d=h(a.replace(R,"$1"));return d[u]?ib(function(a,b,c,e){var f,g=d(a,null,e,[]),h=a.length;while(h--)(f=g[h])&&(a[h]=!(b[h]=f))}):function(a,e,f){return b[0]=a,d(b,null,f,c),b[0]=null,!c.pop()}}),has:ib(function(a){return function(b){return gb(a,b).length>0}}),contains:ib(function(a){return a=a.replace(cb,db),function(b){return(b.textContent||b.innerText||e(b)).indexOf(a)>-1}}),lang:ib(function(a){return W.test(a||"")||gb.error("unsupported lang: "+a),a=a.replace(cb,db).toLowerCase(),function(b){var c;do if(c=p?b.lang:b.getAttribute("xml:lang")||b.getAttribute("lang"))return c=c.toLowerCase(),c===a||0===c.indexOf(a+"-");while((b=b.parentNode)&&1===b.nodeType);return!1}}),target:function(b){var c=a.location&&a.location.hash;return c&&c.slice(1)===b.id},root:function(a){return a===o},focus:function(a){return a===n.activeElement&&(!n.hasFocus||n.hasFocus())&&!!(a.type||a.href||~a.tabIndex)},enabled:function(a){return a.disabled===!1},disabled:function(a){return a.disabled===!0},checked:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&!!a.checked||"option"===b&&!!a.selected},selected:function(a){return a.parentNode&&a.parentNode.selectedIndex,a.selected===!0},empty:function(a){for(a=a.firstChild;a;a=a.nextSibling)if(a.nodeType<6)return!1;return!0},parent:function(a){return!d.pseudos.empty(a)},header:function(a){return Z.test(a.nodeName)},input:function(a){return Y.test(a.nodeName)},button:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&"button"===a.type||"button"===b},text:function(a){var b;return"input"===a.nodeName.toLowerCase()&&"text"===a.type&&(null==(b=a.getAttribute("type"))||"text"===b.toLowerCase())},first:ob(function(){return[0]}),last:ob(function(a,b){return[b-1]}),eq:ob(function(a,b,c){return[0>c?c+b:c]}),even:ob(function(a,b){for(var c=0;b>c;c+=2)a.push(c);return a}),odd:ob(function(a,b){for(var c=1;b>c;c+=2)a.push(c);return a}),lt:ob(function(a,b,c){for(var d=0>c?c+b:c;--d>=0;)a.push(d);return a}),gt:ob(function(a,b,c){for(var d=0>c?c+b:c;++d<b;)a.push(d);return a})}},d.pseudos.nth=d.pseudos.eq;for(b in{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})d.pseudos[b]=mb(b);for(b in{submit:!0,reset:!0})d.pseudos[b]=nb(b);function qb(){}qb.prototype=d.filters=d.pseudos,d.setFilters=new qb,g=gb.tokenize=function(a,b){var c,e,f,g,h,i,j,k=z[a+" "];if(k)return b?0:k.slice(0);h=a,i=[],j=d.preFilter;while(h){(!c||(e=S.exec(h)))&&(e&&(h=h.slice(e[0].length)||h),i.push(f=[])),c=!1,(e=T.exec(h))&&(c=e.shift(),f.push({value:c,type:e[0].replace(R," ")}),h=h.slice(c.length));for(g in d.filter)!(e=X[g].exec(h))||j[g]&&!(e=j[g](e))||(c=e.shift(),f.push({value:c,type:g,matches:e}),h=h.slice(c.length));if(!c)break}return b?h.length:h?gb.error(a):z(a,i).slice(0)};function rb(a){for(var b=0,c=a.length,d="";c>b;b++)d+=a[b].value;return d}function sb(a,b,c){var d=b.dir,e=c&&"parentNode"===d,f=x++;return b.first?function(b,c,f){while(b=b[d])if(1===b.nodeType||e)return a(b,c,f)}:function(b,c,g){var h,i,j=[w,f];if(g){while(b=b[d])if((1===b.nodeType||e)&&a(b,c,g))return!0}else while(b=b[d])if(1===b.nodeType||e){if(i=b[u]||(b[u]={}),(h=i[d])&&h[0]===w&&h[1]===f)return j[2]=h[2];if(i[d]=j,j[2]=a(b,c,g))return!0}}}function tb(a){return a.length>1?function(b,c,d){var e=a.length;while(e--)if(!a[e](b,c,d))return!1;return!0}:a[0]}function ub(a,b,c){for(var d=0,e=b.length;e>d;d++)gb(a,b[d],c);return c}function vb(a,b,c,d,e){for(var f,g=[],h=0,i=a.length,j=null!=b;i>h;h++)(f=a[h])&&(!c||c(f,d,e))&&(g.push(f),j&&b.push(h));return g}function wb(a,b,c,d,e,f){return d&&!d[u]&&(d=wb(d)),e&&!e[u]&&(e=wb(e,f)),ib(function(f,g,h,i){var j,k,l,m=[],n=[],o=g.length,p=f||ub(b||"*",h.nodeType?[h]:h,[]),q=!a||!f&&b?p:vb(p,m,a,h,i),r=c?e||(f?a:o||d)?[]:g:q;if(c&&c(q,r,h,i),d){j=vb(r,n),d(j,[],h,i),k=j.length;while(k--)(l=j[k])&&(r[n[k]]=!(q[n[k]]=l))}if(f){if(e||a){if(e){j=[],k=r.length;while(k--)(l=r[k])&&j.push(q[k]=l);e(null,r=[],j,i)}k=r.length;while(k--)(l=r[k])&&(j=e?J(f,l):m[k])>-1&&(f[j]=!(g[j]=l))}}else r=vb(r===g?r.splice(o,r.length):r),e?e(null,g,r,i):H.apply(g,r)})}function xb(a){for(var b,c,e,f=a.length,g=d.relative[a[0].type],h=g||d.relative[" "],i=g?1:0,k=sb(function(a){return a===b},h,!0),l=sb(function(a){return J(b,a)>-1},h,!0),m=[function(a,c,d){var e=!g&&(d||c!==j)||((b=c).nodeType?k(a,c,d):l(a,c,d));return b=null,e}];f>i;i++)if(c=d.relative[a[i].type])m=[sb(tb(m),c)];else{if(c=d.filter[a[i].type].apply(null,a[i].matches),c[u]){for(e=++i;f>e;e++)if(d.relative[a[e].type])break;return wb(i>1&&tb(m),i>1&&rb(a.slice(0,i-1).concat({value:" "===a[i-2].type?"*":""})).replace(R,"$1"),c,e>i&&xb(a.slice(i,e)),f>e&&xb(a=a.slice(e)),f>e&&rb(a))}m.push(c)}return tb(m)}function yb(a,b){var c=b.length>0,e=a.length>0,f=function(f,g,h,i,k){var l,m,o,p=0,q="0",r=f&&[],s=[],t=j,u=f||e&&d.find.TAG("*",k),v=w+=null==t?1:Math.random()||.1,x=u.length;for(k&&(j=g!==n&&g);q!==x&&null!=(l=u[q]);q++){if(e&&l){m=0;while(o=a[m++])if(o(l,g,h)){i.push(l);break}k&&(w=v)}c&&((l=!o&&l)&&p--,f&&r.push(l))}if(p+=q,c&&q!==p){m=0;while(o=b[m++])o(r,s,g,h);if(f){if(p>0)while(q--)r[q]||s[q]||(s[q]=F.call(i));s=vb(s)}H.apply(i,s),k&&!f&&s.length>0&&p+b.length>1&&gb.uniqueSort(i)}return k&&(w=v,j=t),r};return c?ib(f):f}return h=gb.compile=function(a,b){var c,d=[],e=[],f=A[a+" "];if(!f){b||(b=g(a)),c=b.length;while(c--)f=xb(b[c]),f[u]?d.push(f):e.push(f);f=A(a,yb(e,d)),f.selector=a}return f},i=gb.select=function(a,b,e,f){var i,j,k,l,m,n="function"==typeof a&&a,o=!f&&g(a=n.selector||a);if(e=e||[],1===o.length){if(j=o[0]=o[0].slice(0),j.length>2&&"ID"===(k=j[0]).type&&c.getById&&9===b.nodeType&&p&&d.relative[j[1].type]){if(b=(d.find.ID(k.matches[0].replace(cb,db),b)||[])[0],!b)return e;n&&(b=b.parentNode),a=a.slice(j.shift().value.length)}i=X.needsContext.test(a)?0:j.length;while(i--){if(k=j[i],d.relative[l=k.type])break;if((m=d.find[l])&&(f=m(k.matches[0].replace(cb,db),ab.test(j[0].type)&&pb(b.parentNode)||b))){if(j.splice(i,1),a=f.length&&rb(j),!a)return H.apply(e,f),e;break}}}return(n||h(a,o))(f,b,!p,e,ab.test(a)&&pb(b.parentNode)||b),e},c.sortStable=u.split("").sort(B).join("")===u,c.detectDuplicates=!!l,m(),c.sortDetached=jb(function(a){return 1&a.compareDocumentPosition(n.createElement("div"))}),jb(function(a){return a.innerHTML="<a href='#'></a>","#"===a.firstChild.getAttribute("href")})||kb("type|href|height|width",function(a,b,c){return c?void 0:a.getAttribute(b,"type"===b.toLowerCase()?1:2)}),c.attributes&&jb(function(a){return a.innerHTML="<input/>",a.firstChild.setAttribute("value",""),""===a.firstChild.getAttribute("value")})||kb("value",function(a,b,c){return c||"input"!==a.nodeName.toLowerCase()?void 0:a.defaultValue}),jb(function(a){return null==a.getAttribute("disabled")})||kb(K,function(a,b,c){var d;return c?void 0:a[b]===!0?b.toLowerCase():(d=a.getAttributeNode(b))&&d.specified?d.value:null}),gb}(a);n.find=t,n.expr=t.selectors,n.expr[":"]=n.expr.pseudos,n.unique=t.uniqueSort,n.text=t.getText,n.isXMLDoc=t.isXML,n.contains=t.contains;var u=n.expr.match.needsContext,v=/^<(\w+)\s*\/?>(?:<\/\1>|)$/,w=/^.[^:#\[\.,]*$/;function x(a,b,c){if(n.isFunction(b))return n.grep(a,function(a,d){return!!b.call(a,d,a)!==c});if(b.nodeType)return n.grep(a,function(a){return a===b!==c});if("string"==typeof b){if(w.test(b))return n.filter(b,a,c);b=n.filter(b,a)}return n.grep(a,function(a){return g.call(b,a)>=0!==c})}n.filter=function(a,b,c){var d=b[0];return c&&(a=":not("+a+")"),1===b.length&&1===d.nodeType?n.find.matchesSelector(d,a)?[d]:[]:n.find.matches(a,n.grep(b,function(a){return 1===a.nodeType}))},n.fn.extend({find:function(a){var b,c=this.length,d=[],e=this;if("string"!=typeof a)return this.pushStack(n(a).filter(function(){for(b=0;c>b;b++)if(n.contains(e[b],this))return!0}));for(b=0;c>b;b++)n.find(a,e[b],d);return d=this.pushStack(c>1?n.unique(d):d),d.selector=this.selector?this.selector+" "+a:a,d},filter:function(a){return this.pushStack(x(this,a||[],!1))},not:function(a){return this.pushStack(x(this,a||[],!0))},is:function(a){return!!x(this,"string"==typeof a&&u.test(a)?n(a):a||[],!1).length}});var y,z=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,A=n.fn.init=function(a,b){var c,d;if(!a)return this;if("string"==typeof a){if(c="<"===a[0]&&">"===a[a.length-1]&&a.length>=3?[null,a,null]:z.exec(a),!c||!c[1]&&b)return!b||b.jquery?(b||y).find(a):this.constructor(b).find(a);if(c[1]){if(b=b instanceof n?b[0]:b,n.merge(this,n.parseHTML(c[1],b&&b.nodeType?b.ownerDocument||b:l,!0)),v.test(c[1])&&n.isPlainObject(b))for(c in b)n.isFunction(this[c])?this[c](b[c]):this.attr(c,b[c]);return this}return d=l.getElementById(c[2]),d&&d.parentNode&&(this.length=1,this[0]=d),this.context=l,this.selector=a,this}return a.nodeType?(this.context=this[0]=a,this.length=1,this):n.isFunction(a)?"undefined"!=typeof y.ready?y.ready(a):a(n):(void 0!==a.selector&&(this.selector=a.selector,this.context=a.context),n.makeArray(a,this))};A.prototype=n.fn,y=n(l);var B=/^(?:parents|prev(?:Until|All))/,C={children:!0,contents:!0,next:!0,prev:!0};n.extend({dir:function(a,b,c){var d=[],e=void 0!==c;while((a=a[b])&&9!==a.nodeType)if(1===a.nodeType){if(e&&n(a).is(c))break;d.push(a)}return d},sibling:function(a,b){for(var c=[];a;a=a.nextSibling)1===a.nodeType&&a!==b&&c.push(a);return c}}),n.fn.extend({has:function(a){var b=n(a,this),c=b.length;return this.filter(function(){for(var a=0;c>a;a++)if(n.contains(this,b[a]))return!0})},closest:function(a,b){for(var c,d=0,e=this.length,f=[],g=u.test(a)||"string"!=typeof a?n(a,b||this.context):0;e>d;d++)for(c=this[d];c&&c!==b;c=c.parentNode)if(c.nodeType<11&&(g?g.index(c)>-1:1===c.nodeType&&n.find.matchesSelector(c,a))){f.push(c);break}return this.pushStack(f.length>1?n.unique(f):f)},index:function(a){return a?"string"==typeof a?g.call(n(a),this[0]):g.call(this,a.jquery?a[0]:a):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(a,b){return this.pushStack(n.unique(n.merge(this.get(),n(a,b))))},addBack:function(a){return this.add(null==a?this.prevObject:this.prevObject.filter(a))}});function D(a,b){while((a=a[b])&&1!==a.nodeType);return a}n.each({parent:function(a){var b=a.parentNode;return b&&11!==b.nodeType?b:null},parents:function(a){return n.dir(a,"parentNode")},parentsUntil:function(a,b,c){return n.dir(a,"parentNode",c)},next:function(a){return D(a,"nextSibling")},prev:function(a){return D(a,"previousSibling")},nextAll:function(a){return n.dir(a,"nextSibling")},prevAll:function(a){return n.dir(a,"previousSibling")},nextUntil:function(a,b,c){return n.dir(a,"nextSibling",c)},prevUntil:function(a,b,c){return n.dir(a,"previousSibling",c)},siblings:function(a){return n.sibling((a.parentNode||{}).firstChild,a)},children:function(a){return n.sibling(a.firstChild)},contents:function(a){return a.contentDocument||n.merge([],a.childNodes)}},function(a,b){n.fn[a]=function(c,d){var e=n.map(this,b,c);return"Until"!==a.slice(-5)&&(d=c),d&&"string"==typeof d&&(e=n.filter(d,e)),this.length>1&&(C[a]||n.unique(e),B.test(a)&&e.reverse()),this.pushStack(e)}});var E=/\S+/g,F={};function G(a){var b=F[a]={};return n.each(a.match(E)||[],function(a,c){b[c]=!0}),b}n.Callbacks=function(a){a="string"==typeof a?F[a]||G(a):n.extend({},a);var b,c,d,e,f,g,h=[],i=!a.once&&[],j=function(l){for(b=a.memory&&l,c=!0,g=e||0,e=0,f=h.length,d=!0;h&&f>g;g++)if(h[g].apply(l[0],l[1])===!1&&a.stopOnFalse){b=!1;break}d=!1,h&&(i?i.length&&j(i.shift()):b?h=[]:k.disable())},k={add:function(){if(h){var c=h.length;!function g(b){n.each(b,function(b,c){var d=n.type(c);"function"===d?a.unique&&k.has(c)||h.push(c):c&&c.length&&"string"!==d&&g(c)})}(arguments),d?f=h.length:b&&(e=c,j(b))}return this},remove:function(){return h&&n.each(arguments,function(a,b){var c;while((c=n.inArray(b,h,c))>-1)h.splice(c,1),d&&(f>=c&&f--,g>=c&&g--)}),this},has:function(a){return a?n.inArray(a,h)>-1:!(!h||!h.length)},empty:function(){return h=[],f=0,this},disable:function(){return h=i=b=void 0,this},disabled:function(){return!h},lock:function(){return i=void 0,b||k.disable(),this},locked:function(){return!i},fireWith:function(a,b){return!h||c&&!i||(b=b||[],b=[a,b.slice?b.slice():b],d?i.push(b):j(b)),this},fire:function(){return k.fireWith(this,arguments),this},fired:function(){return!!c}};return k},n.extend({Deferred:function(a){var b=[["resolve","done",n.Callbacks("once memory"),"resolved"],["reject","fail",n.Callbacks("once memory"),"rejected"],["notify","progress",n.Callbacks("memory")]],c="pending",d={state:function(){return c},always:function(){return e.done(arguments).fail(arguments),this},then:function(){var a=arguments;return n.Deferred(function(c){n.each(b,function(b,f){var g=n.isFunction(a[b])&&a[b];e[f[1]](function(){var a=g&&g.apply(this,arguments);a&&n.isFunction(a.promise)?a.promise().done(c.resolve).fail(c.reject).progress(c.notify):c[f[0]+"With"](this===d?c.promise():this,g?[a]:arguments)})}),a=null}).promise()},promise:function(a){return null!=a?n.extend(a,d):d}},e={};return d.pipe=d.then,n.each(b,function(a,f){var g=f[2],h=f[3];d[f[1]]=g.add,h&&g.add(function(){c=h},b[1^a][2].disable,b[2][2].lock),e[f[0]]=function(){return e[f[0]+"With"](this===e?d:this,arguments),this},e[f[0]+"With"]=g.fireWith}),d.promise(e),a&&a.call(e,e),e},when:function(a){var b=0,c=d.call(arguments),e=c.length,f=1!==e||a&&n.isFunction(a.promise)?e:0,g=1===f?a:n.Deferred(),h=function(a,b,c){return function(e){b[a]=this,c[a]=arguments.length>1?d.call(arguments):e,c===i?g.notifyWith(b,c):--f||g.resolveWith(b,c)}},i,j,k;if(e>1)for(i=new Array(e),j=new Array(e),k=new Array(e);e>b;b++)c[b]&&n.isFunction(c[b].promise)?c[b].promise().done(h(b,k,c)).fail(g.reject).progress(h(b,j,i)):--f;return f||g.resolveWith(k,c),g.promise()}});var H;n.fn.ready=function(a){return n.ready.promise().done(a),this},n.extend({isReady:!1,readyWait:1,holdReady:function(a){a?n.readyWait++:n.ready(!0)},ready:function(a){(a===!0?--n.readyWait:n.isReady)||(n.isReady=!0,a!==!0&&--n.readyWait>0||(H.resolveWith(l,[n]),n.fn.triggerHandler&&(n(l).triggerHandler("ready"),n(l).off("ready"))))}});function I(){l.removeEventListener("DOMContentLoaded",I,!1),a.removeEventListener("load",I,!1),n.ready()}n.ready.promise=function(b){return H||(H=n.Deferred(),"complete"===l.readyState?setTimeout(n.ready):(l.addEventListener("DOMContentLoaded",I,!1),a.addEventListener("load",I,!1))),H.promise(b)},n.ready.promise();var J=n.access=function(a,b,c,d,e,f,g){var h=0,i=a.length,j=null==c;if("object"===n.type(c)){e=!0;for(h in c)n.access(a,b,h,c[h],!0,f,g)}else if(void 0!==d&&(e=!0,n.isFunction(d)||(g=!0),j&&(g?(b.call(a,d),b=null):(j=b,b=function(a,b,c){return j.call(n(a),c)})),b))for(;i>h;h++)b(a[h],c,g?d:d.call(a[h],h,b(a[h],c)));return e?a:j?b.call(a):i?b(a[0],c):f};n.acceptData=function(a){return 1===a.nodeType||9===a.nodeType||!+a.nodeType};function K(){Object.defineProperty(this.cache={},0,{get:function(){return{}}}),this.expando=n.expando+K.uid++}K.uid=1,K.accepts=n.acceptData,K.prototype={key:function(a){if(!K.accepts(a))return 0;var b={},c=a[this.expando];if(!c){c=K.uid++;try{b[this.expando]={value:c},Object.defineProperties(a,b)}catch(d){b[this.expando]=c,n.extend(a,b)}}return this.cache[c]||(this.cache[c]={}),c},set:function(a,b,c){var d,e=this.key(a),f=this.cache[e];if("string"==typeof b)f[b]=c;else if(n.isEmptyObject(f))n.extend(this.cache[e],b);else for(d in b)f[d]=b[d];return f},get:function(a,b){var c=this.cache[this.key(a)];return void 0===b?c:c[b]},access:function(a,b,c){var d;return void 0===b||b&&"string"==typeof b&&void 0===c?(d=this.get(a,b),void 0!==d?d:this.get(a,n.camelCase(b))):(this.set(a,b,c),void 0!==c?c:b)},remove:function(a,b){var c,d,e,f=this.key(a),g=this.cache[f];if(void 0===b)this.cache[f]={};else{n.isArray(b)?d=b.concat(b.map(n.camelCase)):(e=n.camelCase(b),b in g?d=[b,e]:(d=e,d=d in g?[d]:d.match(E)||[])),c=d.length;while(c--)delete g[d[c]]}},hasData:function(a){return!n.isEmptyObject(this.cache[a[this.expando]]||{})},discard:function(a){a[this.expando]&&delete this.cache[a[this.expando]]}};var L=new K,M=new K,N=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,O=/([A-Z])/g;function P(a,b,c){var d;if(void 0===c&&1===a.nodeType)if(d="data-"+b.replace(O,"-$1").toLowerCase(),c=a.getAttribute(d),"string"==typeof c){try{c="true"===c?!0:"false"===c?!1:"null"===c?null:+c+""===c?+c:N.test(c)?n.parseJSON(c):c}catch(e){}M.set(a,b,c)}else c=void 0;return c}n.extend({hasData:function(a){return M.hasData(a)||L.hasData(a)},data:function(a,b,c){return M.access(a,b,c)
	},removeData:function(a,b){M.remove(a,b)},_data:function(a,b,c){return L.access(a,b,c)},_removeData:function(a,b){L.remove(a,b)}}),n.fn.extend({data:function(a,b){var c,d,e,f=this[0],g=f&&f.attributes;if(void 0===a){if(this.length&&(e=M.get(f),1===f.nodeType&&!L.get(f,"hasDataAttrs"))){c=g.length;while(c--)g[c]&&(d=g[c].name,0===d.indexOf("data-")&&(d=n.camelCase(d.slice(5)),P(f,d,e[d])));L.set(f,"hasDataAttrs",!0)}return e}return"object"==typeof a?this.each(function(){M.set(this,a)}):J(this,function(b){var c,d=n.camelCase(a);if(f&&void 0===b){if(c=M.get(f,a),void 0!==c)return c;if(c=M.get(f,d),void 0!==c)return c;if(c=P(f,d,void 0),void 0!==c)return c}else this.each(function(){var c=M.get(this,d);M.set(this,d,b),-1!==a.indexOf("-")&&void 0!==c&&M.set(this,a,b)})},null,b,arguments.length>1,null,!0)},removeData:function(a){return this.each(function(){M.remove(this,a)})}}),n.extend({queue:function(a,b,c){var d;return a?(b=(b||"fx")+"queue",d=L.get(a,b),c&&(!d||n.isArray(c)?d=L.access(a,b,n.makeArray(c)):d.push(c)),d||[]):void 0},dequeue:function(a,b){b=b||"fx";var c=n.queue(a,b),d=c.length,e=c.shift(),f=n._queueHooks(a,b),g=function(){n.dequeue(a,b)};"inprogress"===e&&(e=c.shift(),d--),e&&("fx"===b&&c.unshift("inprogress"),delete f.stop,e.call(a,g,f)),!d&&f&&f.empty.fire()},_queueHooks:function(a,b){var c=b+"queueHooks";return L.get(a,c)||L.access(a,c,{empty:n.Callbacks("once memory").add(function(){L.remove(a,[b+"queue",c])})})}}),n.fn.extend({queue:function(a,b){var c=2;return"string"!=typeof a&&(b=a,a="fx",c--),arguments.length<c?n.queue(this[0],a):void 0===b?this:this.each(function(){var c=n.queue(this,a,b);n._queueHooks(this,a),"fx"===a&&"inprogress"!==c[0]&&n.dequeue(this,a)})},dequeue:function(a){return this.each(function(){n.dequeue(this,a)})},clearQueue:function(a){return this.queue(a||"fx",[])},promise:function(a,b){var c,d=1,e=n.Deferred(),f=this,g=this.length,h=function(){--d||e.resolveWith(f,[f])};"string"!=typeof a&&(b=a,a=void 0),a=a||"fx";while(g--)c=L.get(f[g],a+"queueHooks"),c&&c.empty&&(d++,c.empty.add(h));return h(),e.promise(b)}});var Q=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,R=["Top","Right","Bottom","Left"],S=function(a,b){return a=b||a,"none"===n.css(a,"display")||!n.contains(a.ownerDocument,a)},T=/^(?:checkbox|radio)$/i;!function(){var a=l.createDocumentFragment(),b=a.appendChild(l.createElement("div")),c=l.createElement("input");c.setAttribute("type","radio"),c.setAttribute("checked","checked"),c.setAttribute("name","t"),b.appendChild(c),k.checkClone=b.cloneNode(!0).cloneNode(!0).lastChild.checked,b.innerHTML="<textarea>x</textarea>",k.noCloneChecked=!!b.cloneNode(!0).lastChild.defaultValue}();var U="undefined";k.focusinBubbles="onfocusin"in a;var V=/^key/,W=/^(?:mouse|pointer|contextmenu)|click/,X=/^(?:focusinfocus|focusoutblur)$/,Y=/^([^.]*)(?:\.(.+)|)$/;function Z(){return!0}function $(){return!1}function _(){try{return l.activeElement}catch(a){}}n.event={global:{},add:function(a,b,c,d,e){var f,g,h,i,j,k,l,m,o,p,q,r=L.get(a);if(r){c.handler&&(f=c,c=f.handler,e=f.selector),c.guid||(c.guid=n.guid++),(i=r.events)||(i=r.events={}),(g=r.handle)||(g=r.handle=function(b){return typeof n!==U&&n.event.triggered!==b.type?n.event.dispatch.apply(a,arguments):void 0}),b=(b||"").match(E)||[""],j=b.length;while(j--)h=Y.exec(b[j])||[],o=q=h[1],p=(h[2]||"").split(".").sort(),o&&(l=n.event.special[o]||{},o=(e?l.delegateType:l.bindType)||o,l=n.event.special[o]||{},k=n.extend({type:o,origType:q,data:d,handler:c,guid:c.guid,selector:e,needsContext:e&&n.expr.match.needsContext.test(e),namespace:p.join(".")},f),(m=i[o])||(m=i[o]=[],m.delegateCount=0,l.setup&&l.setup.call(a,d,p,g)!==!1||a.addEventListener&&a.addEventListener(o,g,!1)),l.add&&(l.add.call(a,k),k.handler.guid||(k.handler.guid=c.guid)),e?m.splice(m.delegateCount++,0,k):m.push(k),n.event.global[o]=!0)}},remove:function(a,b,c,d,e){var f,g,h,i,j,k,l,m,o,p,q,r=L.hasData(a)&&L.get(a);if(r&&(i=r.events)){b=(b||"").match(E)||[""],j=b.length;while(j--)if(h=Y.exec(b[j])||[],o=q=h[1],p=(h[2]||"").split(".").sort(),o){l=n.event.special[o]||{},o=(d?l.delegateType:l.bindType)||o,m=i[o]||[],h=h[2]&&new RegExp("(^|\\.)"+p.join("\\.(?:.*\\.|)")+"(\\.|$)"),g=f=m.length;while(f--)k=m[f],!e&&q!==k.origType||c&&c.guid!==k.guid||h&&!h.test(k.namespace)||d&&d!==k.selector&&("**"!==d||!k.selector)||(m.splice(f,1),k.selector&&m.delegateCount--,l.remove&&l.remove.call(a,k));g&&!m.length&&(l.teardown&&l.teardown.call(a,p,r.handle)!==!1||n.removeEvent(a,o,r.handle),delete i[o])}else for(o in i)n.event.remove(a,o+b[j],c,d,!0);n.isEmptyObject(i)&&(delete r.handle,L.remove(a,"events"))}},trigger:function(b,c,d,e){var f,g,h,i,k,m,o,p=[d||l],q=j.call(b,"type")?b.type:b,r=j.call(b,"namespace")?b.namespace.split("."):[];if(g=h=d=d||l,3!==d.nodeType&&8!==d.nodeType&&!X.test(q+n.event.triggered)&&(q.indexOf(".")>=0&&(r=q.split("."),q=r.shift(),r.sort()),k=q.indexOf(":")<0&&"on"+q,b=b[n.expando]?b:new n.Event(q,"object"==typeof b&&b),b.isTrigger=e?2:3,b.namespace=r.join("."),b.namespace_re=b.namespace?new RegExp("(^|\\.)"+r.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,b.result=void 0,b.target||(b.target=d),c=null==c?[b]:n.makeArray(c,[b]),o=n.event.special[q]||{},e||!o.trigger||o.trigger.apply(d,c)!==!1)){if(!e&&!o.noBubble&&!n.isWindow(d)){for(i=o.delegateType||q,X.test(i+q)||(g=g.parentNode);g;g=g.parentNode)p.push(g),h=g;h===(d.ownerDocument||l)&&p.push(h.defaultView||h.parentWindow||a)}f=0;while((g=p[f++])&&!b.isPropagationStopped())b.type=f>1?i:o.bindType||q,m=(L.get(g,"events")||{})[b.type]&&L.get(g,"handle"),m&&m.apply(g,c),m=k&&g[k],m&&m.apply&&n.acceptData(g)&&(b.result=m.apply(g,c),b.result===!1&&b.preventDefault());return b.type=q,e||b.isDefaultPrevented()||o._default&&o._default.apply(p.pop(),c)!==!1||!n.acceptData(d)||k&&n.isFunction(d[q])&&!n.isWindow(d)&&(h=d[k],h&&(d[k]=null),n.event.triggered=q,d[q](),n.event.triggered=void 0,h&&(d[k]=h)),b.result}},dispatch:function(a){a=n.event.fix(a);var b,c,e,f,g,h=[],i=d.call(arguments),j=(L.get(this,"events")||{})[a.type]||[],k=n.event.special[a.type]||{};if(i[0]=a,a.delegateTarget=this,!k.preDispatch||k.preDispatch.call(this,a)!==!1){h=n.event.handlers.call(this,a,j),b=0;while((f=h[b++])&&!a.isPropagationStopped()){a.currentTarget=f.elem,c=0;while((g=f.handlers[c++])&&!a.isImmediatePropagationStopped())(!a.namespace_re||a.namespace_re.test(g.namespace))&&(a.handleObj=g,a.data=g.data,e=((n.event.special[g.origType]||{}).handle||g.handler).apply(f.elem,i),void 0!==e&&(a.result=e)===!1&&(a.preventDefault(),a.stopPropagation()))}return k.postDispatch&&k.postDispatch.call(this,a),a.result}},handlers:function(a,b){var c,d,e,f,g=[],h=b.delegateCount,i=a.target;if(h&&i.nodeType&&(!a.button||"click"!==a.type))for(;i!==this;i=i.parentNode||this)if(i.disabled!==!0||"click"!==a.type){for(d=[],c=0;h>c;c++)f=b[c],e=f.selector+" ",void 0===d[e]&&(d[e]=f.needsContext?n(e,this).index(i)>=0:n.find(e,this,null,[i]).length),d[e]&&d.push(f);d.length&&g.push({elem:i,handlers:d})}return h<b.length&&g.push({elem:this,handlers:b.slice(h)}),g},props:"altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),fixHooks:{},keyHooks:{props:"char charCode key keyCode".split(" "),filter:function(a,b){return null==a.which&&(a.which=null!=b.charCode?b.charCode:b.keyCode),a}},mouseHooks:{props:"button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "),filter:function(a,b){var c,d,e,f=b.button;return null==a.pageX&&null!=b.clientX&&(c=a.target.ownerDocument||l,d=c.documentElement,e=c.body,a.pageX=b.clientX+(d&&d.scrollLeft||e&&e.scrollLeft||0)-(d&&d.clientLeft||e&&e.clientLeft||0),a.pageY=b.clientY+(d&&d.scrollTop||e&&e.scrollTop||0)-(d&&d.clientTop||e&&e.clientTop||0)),a.which||void 0===f||(a.which=1&f?1:2&f?3:4&f?2:0),a}},fix:function(a){if(a[n.expando])return a;var b,c,d,e=a.type,f=a,g=this.fixHooks[e];g||(this.fixHooks[e]=g=W.test(e)?this.mouseHooks:V.test(e)?this.keyHooks:{}),d=g.props?this.props.concat(g.props):this.props,a=new n.Event(f),b=d.length;while(b--)c=d[b],a[c]=f[c];return a.target||(a.target=l),3===a.target.nodeType&&(a.target=a.target.parentNode),g.filter?g.filter(a,f):a},special:{load:{noBubble:!0},focus:{trigger:function(){return this!==_()&&this.focus?(this.focus(),!1):void 0},delegateType:"focusin"},blur:{trigger:function(){return this===_()&&this.blur?(this.blur(),!1):void 0},delegateType:"focusout"},click:{trigger:function(){return"checkbox"===this.type&&this.click&&n.nodeName(this,"input")?(this.click(),!1):void 0},_default:function(a){return n.nodeName(a.target,"a")}},beforeunload:{postDispatch:function(a){void 0!==a.result&&a.originalEvent&&(a.originalEvent.returnValue=a.result)}}},simulate:function(a,b,c,d){var e=n.extend(new n.Event,c,{type:a,isSimulated:!0,originalEvent:{}});d?n.event.trigger(e,null,b):n.event.dispatch.call(b,e),e.isDefaultPrevented()&&c.preventDefault()}},n.removeEvent=function(a,b,c){a.removeEventListener&&a.removeEventListener(b,c,!1)},n.Event=function(a,b){return this instanceof n.Event?(a&&a.type?(this.originalEvent=a,this.type=a.type,this.isDefaultPrevented=a.defaultPrevented||void 0===a.defaultPrevented&&a.returnValue===!1?Z:$):this.type=a,b&&n.extend(this,b),this.timeStamp=a&&a.timeStamp||n.now(),void(this[n.expando]=!0)):new n.Event(a,b)},n.Event.prototype={isDefaultPrevented:$,isPropagationStopped:$,isImmediatePropagationStopped:$,preventDefault:function(){var a=this.originalEvent;this.isDefaultPrevented=Z,a&&a.preventDefault&&a.preventDefault()},stopPropagation:function(){var a=this.originalEvent;this.isPropagationStopped=Z,a&&a.stopPropagation&&a.stopPropagation()},stopImmediatePropagation:function(){var a=this.originalEvent;this.isImmediatePropagationStopped=Z,a&&a.stopImmediatePropagation&&a.stopImmediatePropagation(),this.stopPropagation()}},n.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(a,b){n.event.special[a]={delegateType:b,bindType:b,handle:function(a){var c,d=this,e=a.relatedTarget,f=a.handleObj;return(!e||e!==d&&!n.contains(d,e))&&(a.type=f.origType,c=f.handler.apply(this,arguments),a.type=b),c}}}),k.focusinBubbles||n.each({focus:"focusin",blur:"focusout"},function(a,b){var c=function(a){n.event.simulate(b,a.target,n.event.fix(a),!0)};n.event.special[b]={setup:function(){var d=this.ownerDocument||this,e=L.access(d,b);e||d.addEventListener(a,c,!0),L.access(d,b,(e||0)+1)},teardown:function(){var d=this.ownerDocument||this,e=L.access(d,b)-1;e?L.access(d,b,e):(d.removeEventListener(a,c,!0),L.remove(d,b))}}}),n.fn.extend({on:function(a,b,c,d,e){var f,g;if("object"==typeof a){"string"!=typeof b&&(c=c||b,b=void 0);for(g in a)this.on(g,b,c,a[g],e);return this}if(null==c&&null==d?(d=b,c=b=void 0):null==d&&("string"==typeof b?(d=c,c=void 0):(d=c,c=b,b=void 0)),d===!1)d=$;else if(!d)return this;return 1===e&&(f=d,d=function(a){return n().off(a),f.apply(this,arguments)},d.guid=f.guid||(f.guid=n.guid++)),this.each(function(){n.event.add(this,a,d,c,b)})},one:function(a,b,c,d){return this.on(a,b,c,d,1)},off:function(a,b,c){var d,e;if(a&&a.preventDefault&&a.handleObj)return d=a.handleObj,n(a.delegateTarget).off(d.namespace?d.origType+"."+d.namespace:d.origType,d.selector,d.handler),this;if("object"==typeof a){for(e in a)this.off(e,b,a[e]);return this}return(b===!1||"function"==typeof b)&&(c=b,b=void 0),c===!1&&(c=$),this.each(function(){n.event.remove(this,a,c,b)})},trigger:function(a,b){return this.each(function(){n.event.trigger(a,b,this)})},triggerHandler:function(a,b){var c=this[0];return c?n.event.trigger(a,b,c,!0):void 0}});var ab=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,bb=/<([\w:]+)/,cb=/<|&#?\w+;/,db=/<(?:script|style|link)/i,eb=/checked\s*(?:[^=]|=\s*.checked.)/i,fb=/^$|\/(?:java|ecma)script/i,gb=/^true\/(.*)/,hb=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,ib={option:[1,"<select multiple='multiple'>","</select>"],thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};ib.optgroup=ib.option,ib.tbody=ib.tfoot=ib.colgroup=ib.caption=ib.thead,ib.th=ib.td;function jb(a,b){return n.nodeName(a,"table")&&n.nodeName(11!==b.nodeType?b:b.firstChild,"tr")?a.getElementsByTagName("tbody")[0]||a.appendChild(a.ownerDocument.createElement("tbody")):a}function kb(a){return a.type=(null!==a.getAttribute("type"))+"/"+a.type,a}function lb(a){var b=gb.exec(a.type);return b?a.type=b[1]:a.removeAttribute("type"),a}function mb(a,b){for(var c=0,d=a.length;d>c;c++)L.set(a[c],"globalEval",!b||L.get(b[c],"globalEval"))}function nb(a,b){var c,d,e,f,g,h,i,j;if(1===b.nodeType){if(L.hasData(a)&&(f=L.access(a),g=L.set(b,f),j=f.events)){delete g.handle,g.events={};for(e in j)for(c=0,d=j[e].length;d>c;c++)n.event.add(b,e,j[e][c])}M.hasData(a)&&(h=M.access(a),i=n.extend({},h),M.set(b,i))}}function ob(a,b){var c=a.getElementsByTagName?a.getElementsByTagName(b||"*"):a.querySelectorAll?a.querySelectorAll(b||"*"):[];return void 0===b||b&&n.nodeName(a,b)?n.merge([a],c):c}function pb(a,b){var c=b.nodeName.toLowerCase();"input"===c&&T.test(a.type)?b.checked=a.checked:("input"===c||"textarea"===c)&&(b.defaultValue=a.defaultValue)}n.extend({clone:function(a,b,c){var d,e,f,g,h=a.cloneNode(!0),i=n.contains(a.ownerDocument,a);if(!(k.noCloneChecked||1!==a.nodeType&&11!==a.nodeType||n.isXMLDoc(a)))for(g=ob(h),f=ob(a),d=0,e=f.length;e>d;d++)pb(f[d],g[d]);if(b)if(c)for(f=f||ob(a),g=g||ob(h),d=0,e=f.length;e>d;d++)nb(f[d],g[d]);else nb(a,h);return g=ob(h,"script"),g.length>0&&mb(g,!i&&ob(a,"script")),h},buildFragment:function(a,b,c,d){for(var e,f,g,h,i,j,k=b.createDocumentFragment(),l=[],m=0,o=a.length;o>m;m++)if(e=a[m],e||0===e)if("object"===n.type(e))n.merge(l,e.nodeType?[e]:e);else if(cb.test(e)){f=f||k.appendChild(b.createElement("div")),g=(bb.exec(e)||["",""])[1].toLowerCase(),h=ib[g]||ib._default,f.innerHTML=h[1]+e.replace(ab,"<$1></$2>")+h[2],j=h[0];while(j--)f=f.lastChild;n.merge(l,f.childNodes),f=k.firstChild,f.textContent=""}else l.push(b.createTextNode(e));k.textContent="",m=0;while(e=l[m++])if((!d||-1===n.inArray(e,d))&&(i=n.contains(e.ownerDocument,e),f=ob(k.appendChild(e),"script"),i&&mb(f),c)){j=0;while(e=f[j++])fb.test(e.type||"")&&c.push(e)}return k},cleanData:function(a){for(var b,c,d,e,f=n.event.special,g=0;void 0!==(c=a[g]);g++){if(n.acceptData(c)&&(e=c[L.expando],e&&(b=L.cache[e]))){if(b.events)for(d in b.events)f[d]?n.event.remove(c,d):n.removeEvent(c,d,b.handle);L.cache[e]&&delete L.cache[e]}delete M.cache[c[M.expando]]}}}),n.fn.extend({text:function(a){return J(this,function(a){return void 0===a?n.text(this):this.empty().each(function(){(1===this.nodeType||11===this.nodeType||9===this.nodeType)&&(this.textContent=a)})},null,a,arguments.length)},append:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=jb(this,a);b.appendChild(a)}})},prepend:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=jb(this,a);b.insertBefore(a,b.firstChild)}})},before:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this)})},after:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this.nextSibling)})},remove:function(a,b){for(var c,d=a?n.filter(a,this):this,e=0;null!=(c=d[e]);e++)b||1!==c.nodeType||n.cleanData(ob(c)),c.parentNode&&(b&&n.contains(c.ownerDocument,c)&&mb(ob(c,"script")),c.parentNode.removeChild(c));return this},empty:function(){for(var a,b=0;null!=(a=this[b]);b++)1===a.nodeType&&(n.cleanData(ob(a,!1)),a.textContent="");return this},clone:function(a,b){return a=null==a?!1:a,b=null==b?a:b,this.map(function(){return n.clone(this,a,b)})},html:function(a){return J(this,function(a){var b=this[0]||{},c=0,d=this.length;if(void 0===a&&1===b.nodeType)return b.innerHTML;if("string"==typeof a&&!db.test(a)&&!ib[(bb.exec(a)||["",""])[1].toLowerCase()]){a=a.replace(ab,"<$1></$2>");try{for(;d>c;c++)b=this[c]||{},1===b.nodeType&&(n.cleanData(ob(b,!1)),b.innerHTML=a);b=0}catch(e){}}b&&this.empty().append(a)},null,a,arguments.length)},replaceWith:function(){var a=arguments[0];return this.domManip(arguments,function(b){a=this.parentNode,n.cleanData(ob(this)),a&&a.replaceChild(b,this)}),a&&(a.length||a.nodeType)?this:this.remove()},detach:function(a){return this.remove(a,!0)},domManip:function(a,b){a=e.apply([],a);var c,d,f,g,h,i,j=0,l=this.length,m=this,o=l-1,p=a[0],q=n.isFunction(p);if(q||l>1&&"string"==typeof p&&!k.checkClone&&eb.test(p))return this.each(function(c){var d=m.eq(c);q&&(a[0]=p.call(this,c,d.html())),d.domManip(a,b)});if(l&&(c=n.buildFragment(a,this[0].ownerDocument,!1,this),d=c.firstChild,1===c.childNodes.length&&(c=d),d)){for(f=n.map(ob(c,"script"),kb),g=f.length;l>j;j++)h=c,j!==o&&(h=n.clone(h,!0,!0),g&&n.merge(f,ob(h,"script"))),b.call(this[j],h,j);if(g)for(i=f[f.length-1].ownerDocument,n.map(f,lb),j=0;g>j;j++)h=f[j],fb.test(h.type||"")&&!L.access(h,"globalEval")&&n.contains(i,h)&&(h.src?n._evalUrl&&n._evalUrl(h.src):n.globalEval(h.textContent.replace(hb,"")))}return this}}),n.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(a,b){n.fn[a]=function(a){for(var c,d=[],e=n(a),g=e.length-1,h=0;g>=h;h++)c=h===g?this:this.clone(!0),n(e[h])[b](c),f.apply(d,c.get());return this.pushStack(d)}});var qb,rb={};function sb(b,c){var d,e=n(c.createElement(b)).appendTo(c.body),f=a.getDefaultComputedStyle&&(d=a.getDefaultComputedStyle(e[0]))?d.display:n.css(e[0],"display");return e.detach(),f}function tb(a){var b=l,c=rb[a];return c||(c=sb(a,b),"none"!==c&&c||(qb=(qb||n("<iframe frameborder='0' width='0' height='0'/>")).appendTo(b.documentElement),b=qb[0].contentDocument,b.write(),b.close(),c=sb(a,b),qb.detach()),rb[a]=c),c}var ub=/^margin/,vb=new RegExp("^("+Q+")(?!px)[a-z%]+$","i"),wb=function(b){return b.ownerDocument.defaultView.opener?b.ownerDocument.defaultView.getComputedStyle(b,null):a.getComputedStyle(b,null)};function xb(a,b,c){var d,e,f,g,h=a.style;return c=c||wb(a),c&&(g=c.getPropertyValue(b)||c[b]),c&&(""!==g||n.contains(a.ownerDocument,a)||(g=n.style(a,b)),vb.test(g)&&ub.test(b)&&(d=h.width,e=h.minWidth,f=h.maxWidth,h.minWidth=h.maxWidth=h.width=g,g=c.width,h.width=d,h.minWidth=e,h.maxWidth=f)),void 0!==g?g+"":g}function yb(a,b){return{get:function(){return a()?void delete this.get:(this.get=b).apply(this,arguments)}}}!function(){var b,c,d=l.documentElement,e=l.createElement("div"),f=l.createElement("div");if(f.style){f.style.backgroundClip="content-box",f.cloneNode(!0).style.backgroundClip="",k.clearCloneStyle="content-box"===f.style.backgroundClip,e.style.cssText="border:0;width:0;height:0;top:0;left:-9999px;margin-top:1px;position:absolute",e.appendChild(f);function g(){f.style.cssText="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:block;margin-top:1%;top:1%;border:1px;padding:1px;width:4px;position:absolute",f.innerHTML="",d.appendChild(e);var g=a.getComputedStyle(f,null);b="1%"!==g.top,c="4px"===g.width,d.removeChild(e)}a.getComputedStyle&&n.extend(k,{pixelPosition:function(){return g(),b},boxSizingReliable:function(){return null==c&&g(),c},reliableMarginRight:function(){var b,c=f.appendChild(l.createElement("div"));return c.style.cssText=f.style.cssText="-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0",c.style.marginRight=c.style.width="0",f.style.width="1px",d.appendChild(e),b=!parseFloat(a.getComputedStyle(c,null).marginRight),d.removeChild(e),f.removeChild(c),b}})}}(),n.swap=function(a,b,c,d){var e,f,g={};for(f in b)g[f]=a.style[f],a.style[f]=b[f];e=c.apply(a,d||[]);for(f in b)a.style[f]=g[f];return e};var zb=/^(none|table(?!-c[ea]).+)/,Ab=new RegExp("^("+Q+")(.*)$","i"),Bb=new RegExp("^([+-])=("+Q+")","i"),Cb={position:"absolute",visibility:"hidden",display:"block"},Db={letterSpacing:"0",fontWeight:"400"},Eb=["Webkit","O","Moz","ms"];function Fb(a,b){if(b in a)return b;var c=b[0].toUpperCase()+b.slice(1),d=b,e=Eb.length;while(e--)if(b=Eb[e]+c,b in a)return b;return d}function Gb(a,b,c){var d=Ab.exec(b);return d?Math.max(0,d[1]-(c||0))+(d[2]||"px"):b}function Hb(a,b,c,d,e){for(var f=c===(d?"border":"content")?4:"width"===b?1:0,g=0;4>f;f+=2)"margin"===c&&(g+=n.css(a,c+R[f],!0,e)),d?("content"===c&&(g-=n.css(a,"padding"+R[f],!0,e)),"margin"!==c&&(g-=n.css(a,"border"+R[f]+"Width",!0,e))):(g+=n.css(a,"padding"+R[f],!0,e),"padding"!==c&&(g+=n.css(a,"border"+R[f]+"Width",!0,e)));return g}function Ib(a,b,c){var d=!0,e="width"===b?a.offsetWidth:a.offsetHeight,f=wb(a),g="border-box"===n.css(a,"boxSizing",!1,f);if(0>=e||null==e){if(e=xb(a,b,f),(0>e||null==e)&&(e=a.style[b]),vb.test(e))return e;d=g&&(k.boxSizingReliable()||e===a.style[b]),e=parseFloat(e)||0}return e+Hb(a,b,c||(g?"border":"content"),d,f)+"px"}function Jb(a,b){for(var c,d,e,f=[],g=0,h=a.length;h>g;g++)d=a[g],d.style&&(f[g]=L.get(d,"olddisplay"),c=d.style.display,b?(f[g]||"none"!==c||(d.style.display=""),""===d.style.display&&S(d)&&(f[g]=L.access(d,"olddisplay",tb(d.nodeName)))):(e=S(d),"none"===c&&e||L.set(d,"olddisplay",e?c:n.css(d,"display"))));for(g=0;h>g;g++)d=a[g],d.style&&(b&&"none"!==d.style.display&&""!==d.style.display||(d.style.display=b?f[g]||"":"none"));return a}n.extend({cssHooks:{opacity:{get:function(a,b){if(b){var c=xb(a,"opacity");return""===c?"1":c}}}},cssNumber:{columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{"float":"cssFloat"},style:function(a,b,c,d){if(a&&3!==a.nodeType&&8!==a.nodeType&&a.style){var e,f,g,h=n.camelCase(b),i=a.style;return b=n.cssProps[h]||(n.cssProps[h]=Fb(i,h)),g=n.cssHooks[b]||n.cssHooks[h],void 0===c?g&&"get"in g&&void 0!==(e=g.get(a,!1,d))?e:i[b]:(f=typeof c,"string"===f&&(e=Bb.exec(c))&&(c=(e[1]+1)*e[2]+parseFloat(n.css(a,b)),f="number"),null!=c&&c===c&&("number"!==f||n.cssNumber[h]||(c+="px"),k.clearCloneStyle||""!==c||0!==b.indexOf("background")||(i[b]="inherit"),g&&"set"in g&&void 0===(c=g.set(a,c,d))||(i[b]=c)),void 0)}},css:function(a,b,c,d){var e,f,g,h=n.camelCase(b);return b=n.cssProps[h]||(n.cssProps[h]=Fb(a.style,h)),g=n.cssHooks[b]||n.cssHooks[h],g&&"get"in g&&(e=g.get(a,!0,c)),void 0===e&&(e=xb(a,b,d)),"normal"===e&&b in Db&&(e=Db[b]),""===c||c?(f=parseFloat(e),c===!0||n.isNumeric(f)?f||0:e):e}}),n.each(["height","width"],function(a,b){n.cssHooks[b]={get:function(a,c,d){return c?zb.test(n.css(a,"display"))&&0===a.offsetWidth?n.swap(a,Cb,function(){return Ib(a,b,d)}):Ib(a,b,d):void 0},set:function(a,c,d){var e=d&&wb(a);return Gb(a,c,d?Hb(a,b,d,"border-box"===n.css(a,"boxSizing",!1,e),e):0)}}}),n.cssHooks.marginRight=yb(k.reliableMarginRight,function(a,b){return b?n.swap(a,{display:"inline-block"},xb,[a,"marginRight"]):void 0}),n.each({margin:"",padding:"",border:"Width"},function(a,b){n.cssHooks[a+b]={expand:function(c){for(var d=0,e={},f="string"==typeof c?c.split(" "):[c];4>d;d++)e[a+R[d]+b]=f[d]||f[d-2]||f[0];return e}},ub.test(a)||(n.cssHooks[a+b].set=Gb)}),n.fn.extend({css:function(a,b){return J(this,function(a,b,c){var d,e,f={},g=0;if(n.isArray(b)){for(d=wb(a),e=b.length;e>g;g++)f[b[g]]=n.css(a,b[g],!1,d);return f}return void 0!==c?n.style(a,b,c):n.css(a,b)},a,b,arguments.length>1)},show:function(){return Jb(this,!0)},hide:function(){return Jb(this)},toggle:function(a){return"boolean"==typeof a?a?this.show():this.hide():this.each(function(){S(this)?n(this).show():n(this).hide()})}});function Kb(a,b,c,d,e){return new Kb.prototype.init(a,b,c,d,e)}n.Tween=Kb,Kb.prototype={constructor:Kb,init:function(a,b,c,d,e,f){this.elem=a,this.prop=c,this.easing=e||"swing",this.options=b,this.start=this.now=this.cur(),this.end=d,this.unit=f||(n.cssNumber[c]?"":"px")},cur:function(){var a=Kb.propHooks[this.prop];return a&&a.get?a.get(this):Kb.propHooks._default.get(this)},run:function(a){var b,c=Kb.propHooks[this.prop];return this.pos=b=this.options.duration?n.easing[this.easing](a,this.options.duration*a,0,1,this.options.duration):a,this.now=(this.end-this.start)*b+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),c&&c.set?c.set(this):Kb.propHooks._default.set(this),this}},Kb.prototype.init.prototype=Kb.prototype,Kb.propHooks={_default:{get:function(a){var b;return null==a.elem[a.prop]||a.elem.style&&null!=a.elem.style[a.prop]?(b=n.css(a.elem,a.prop,""),b&&"auto"!==b?b:0):a.elem[a.prop]},set:function(a){n.fx.step[a.prop]?n.fx.step[a.prop](a):a.elem.style&&(null!=a.elem.style[n.cssProps[a.prop]]||n.cssHooks[a.prop])?n.style(a.elem,a.prop,a.now+a.unit):a.elem[a.prop]=a.now}}},Kb.propHooks.scrollTop=Kb.propHooks.scrollLeft={set:function(a){a.elem.nodeType&&a.elem.parentNode&&(a.elem[a.prop]=a.now)}},n.easing={linear:function(a){return a},swing:function(a){return.5-Math.cos(a*Math.PI)/2}},n.fx=Kb.prototype.init,n.fx.step={};var Lb,Mb,Nb=/^(?:toggle|show|hide)$/,Ob=new RegExp("^(?:([+-])=|)("+Q+")([a-z%]*)$","i"),Pb=/queueHooks$/,Qb=[Vb],Rb={"*":[function(a,b){var c=this.createTween(a,b),d=c.cur(),e=Ob.exec(b),f=e&&e[3]||(n.cssNumber[a]?"":"px"),g=(n.cssNumber[a]||"px"!==f&&+d)&&Ob.exec(n.css(c.elem,a)),h=1,i=20;if(g&&g[3]!==f){f=f||g[3],e=e||[],g=+d||1;do h=h||".5",g/=h,n.style(c.elem,a,g+f);while(h!==(h=c.cur()/d)&&1!==h&&--i)}return e&&(g=c.start=+g||+d||0,c.unit=f,c.end=e[1]?g+(e[1]+1)*e[2]:+e[2]),c}]};function Sb(){return setTimeout(function(){Lb=void 0}),Lb=n.now()}function Tb(a,b){var c,d=0,e={height:a};for(b=b?1:0;4>d;d+=2-b)c=R[d],e["margin"+c]=e["padding"+c]=a;return b&&(e.opacity=e.width=a),e}function Ub(a,b,c){for(var d,e=(Rb[b]||[]).concat(Rb["*"]),f=0,g=e.length;g>f;f++)if(d=e[f].call(c,b,a))return d}function Vb(a,b,c){var d,e,f,g,h,i,j,k,l=this,m={},o=a.style,p=a.nodeType&&S(a),q=L.get(a,"fxshow");c.queue||(h=n._queueHooks(a,"fx"),null==h.unqueued&&(h.unqueued=0,i=h.empty.fire,h.empty.fire=function(){h.unqueued||i()}),h.unqueued++,l.always(function(){l.always(function(){h.unqueued--,n.queue(a,"fx").length||h.empty.fire()})})),1===a.nodeType&&("height"in b||"width"in b)&&(c.overflow=[o.overflow,o.overflowX,o.overflowY],j=n.css(a,"display"),k="none"===j?L.get(a,"olddisplay")||tb(a.nodeName):j,"inline"===k&&"none"===n.css(a,"float")&&(o.display="inline-block")),c.overflow&&(o.overflow="hidden",l.always(function(){o.overflow=c.overflow[0],o.overflowX=c.overflow[1],o.overflowY=c.overflow[2]}));for(d in b)if(e=b[d],Nb.exec(e)){if(delete b[d],f=f||"toggle"===e,e===(p?"hide":"show")){if("show"!==e||!q||void 0===q[d])continue;p=!0}m[d]=q&&q[d]||n.style(a,d)}else j=void 0;if(n.isEmptyObject(m))"inline"===("none"===j?tb(a.nodeName):j)&&(o.display=j);else{q?"hidden"in q&&(p=q.hidden):q=L.access(a,"fxshow",{}),f&&(q.hidden=!p),p?n(a).show():l.done(function(){n(a).hide()}),l.done(function(){var b;L.remove(a,"fxshow");for(b in m)n.style(a,b,m[b])});for(d in m)g=Ub(p?q[d]:0,d,l),d in q||(q[d]=g.start,p&&(g.end=g.start,g.start="width"===d||"height"===d?1:0))}}function Wb(a,b){var c,d,e,f,g;for(c in a)if(d=n.camelCase(c),e=b[d],f=a[c],n.isArray(f)&&(e=f[1],f=a[c]=f[0]),c!==d&&(a[d]=f,delete a[c]),g=n.cssHooks[d],g&&"expand"in g){f=g.expand(f),delete a[d];for(c in f)c in a||(a[c]=f[c],b[c]=e)}else b[d]=e}function Xb(a,b,c){var d,e,f=0,g=Qb.length,h=n.Deferred().always(function(){delete i.elem}),i=function(){if(e)return!1;for(var b=Lb||Sb(),c=Math.max(0,j.startTime+j.duration-b),d=c/j.duration||0,f=1-d,g=0,i=j.tweens.length;i>g;g++)j.tweens[g].run(f);return h.notifyWith(a,[j,f,c]),1>f&&i?c:(h.resolveWith(a,[j]),!1)},j=h.promise({elem:a,props:n.extend({},b),opts:n.extend(!0,{specialEasing:{}},c),originalProperties:b,originalOptions:c,startTime:Lb||Sb(),duration:c.duration,tweens:[],createTween:function(b,c){var d=n.Tween(a,j.opts,b,c,j.opts.specialEasing[b]||j.opts.easing);return j.tweens.push(d),d},stop:function(b){var c=0,d=b?j.tweens.length:0;if(e)return this;for(e=!0;d>c;c++)j.tweens[c].run(1);return b?h.resolveWith(a,[j,b]):h.rejectWith(a,[j,b]),this}}),k=j.props;for(Wb(k,j.opts.specialEasing);g>f;f++)if(d=Qb[f].call(j,a,k,j.opts))return d;return n.map(k,Ub,j),n.isFunction(j.opts.start)&&j.opts.start.call(a,j),n.fx.timer(n.extend(i,{elem:a,anim:j,queue:j.opts.queue})),j.progress(j.opts.progress).done(j.opts.done,j.opts.complete).fail(j.opts.fail).always(j.opts.always)}n.Animation=n.extend(Xb,{tweener:function(a,b){n.isFunction(a)?(b=a,a=["*"]):a=a.split(" ");for(var c,d=0,e=a.length;e>d;d++)c=a[d],Rb[c]=Rb[c]||[],Rb[c].unshift(b)},prefilter:function(a,b){b?Qb.unshift(a):Qb.push(a)}}),n.speed=function(a,b,c){var d=a&&"object"==typeof a?n.extend({},a):{complete:c||!c&&b||n.isFunction(a)&&a,duration:a,easing:c&&b||b&&!n.isFunction(b)&&b};return d.duration=n.fx.off?0:"number"==typeof d.duration?d.duration:d.duration in n.fx.speeds?n.fx.speeds[d.duration]:n.fx.speeds._default,(null==d.queue||d.queue===!0)&&(d.queue="fx"),d.old=d.complete,d.complete=function(){n.isFunction(d.old)&&d.old.call(this),d.queue&&n.dequeue(this,d.queue)},d},n.fn.extend({fadeTo:function(a,b,c,d){return this.filter(S).css("opacity",0).show().end().animate({opacity:b},a,c,d)},animate:function(a,b,c,d){var e=n.isEmptyObject(a),f=n.speed(b,c,d),g=function(){var b=Xb(this,n.extend({},a),f);(e||L.get(this,"finish"))&&b.stop(!0)};return g.finish=g,e||f.queue===!1?this.each(g):this.queue(f.queue,g)},stop:function(a,b,c){var d=function(a){var b=a.stop;delete a.stop,b(c)};return"string"!=typeof a&&(c=b,b=a,a=void 0),b&&a!==!1&&this.queue(a||"fx",[]),this.each(function(){var b=!0,e=null!=a&&a+"queueHooks",f=n.timers,g=L.get(this);if(e)g[e]&&g[e].stop&&d(g[e]);else for(e in g)g[e]&&g[e].stop&&Pb.test(e)&&d(g[e]);for(e=f.length;e--;)f[e].elem!==this||null!=a&&f[e].queue!==a||(f[e].anim.stop(c),b=!1,f.splice(e,1));(b||!c)&&n.dequeue(this,a)})},finish:function(a){return a!==!1&&(a=a||"fx"),this.each(function(){var b,c=L.get(this),d=c[a+"queue"],e=c[a+"queueHooks"],f=n.timers,g=d?d.length:0;for(c.finish=!0,n.queue(this,a,[]),e&&e.stop&&e.stop.call(this,!0),b=f.length;b--;)f[b].elem===this&&f[b].queue===a&&(f[b].anim.stop(!0),f.splice(b,1));for(b=0;g>b;b++)d[b]&&d[b].finish&&d[b].finish.call(this);delete c.finish})}}),n.each(["toggle","show","hide"],function(a,b){var c=n.fn[b];n.fn[b]=function(a,d,e){return null==a||"boolean"==typeof a?c.apply(this,arguments):this.animate(Tb(b,!0),a,d,e)}}),n.each({slideDown:Tb("show"),slideUp:Tb("hide"),slideToggle:Tb("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(a,b){n.fn[a]=function(a,c,d){return this.animate(b,a,c,d)}}),n.timers=[],n.fx.tick=function(){var a,b=0,c=n.timers;for(Lb=n.now();b<c.length;b++)a=c[b],a()||c[b]!==a||c.splice(b--,1);c.length||n.fx.stop(),Lb=void 0},n.fx.timer=function(a){n.timers.push(a),a()?n.fx.start():n.timers.pop()},n.fx.interval=13,n.fx.start=function(){Mb||(Mb=setInterval(n.fx.tick,n.fx.interval))},n.fx.stop=function(){clearInterval(Mb),Mb=null},n.fx.speeds={slow:600,fast:200,_default:400},n.fn.delay=function(a,b){return a=n.fx?n.fx.speeds[a]||a:a,b=b||"fx",this.queue(b,function(b,c){var d=setTimeout(b,a);c.stop=function(){clearTimeout(d)}})},function(){var a=l.createElement("input"),b=l.createElement("select"),c=b.appendChild(l.createElement("option"));a.type="checkbox",k.checkOn=""!==a.value,k.optSelected=c.selected,b.disabled=!0,k.optDisabled=!c.disabled,a=l.createElement("input"),a.value="t",a.type="radio",k.radioValue="t"===a.value}();var Yb,Zb,$b=n.expr.attrHandle;n.fn.extend({attr:function(a,b){return J(this,n.attr,a,b,arguments.length>1)},removeAttr:function(a){return this.each(function(){n.removeAttr(this,a)})}}),n.extend({attr:function(a,b,c){var d,e,f=a.nodeType;if(a&&3!==f&&8!==f&&2!==f)return typeof a.getAttribute===U?n.prop(a,b,c):(1===f&&n.isXMLDoc(a)||(b=b.toLowerCase(),d=n.attrHooks[b]||(n.expr.match.bool.test(b)?Zb:Yb)),void 0===c?d&&"get"in d&&null!==(e=d.get(a,b))?e:(e=n.find.attr(a,b),null==e?void 0:e):null!==c?d&&"set"in d&&void 0!==(e=d.set(a,c,b))?e:(a.setAttribute(b,c+""),c):void n.removeAttr(a,b))
	},removeAttr:function(a,b){var c,d,e=0,f=b&&b.match(E);if(f&&1===a.nodeType)while(c=f[e++])d=n.propFix[c]||c,n.expr.match.bool.test(c)&&(a[d]=!1),a.removeAttribute(c)},attrHooks:{type:{set:function(a,b){if(!k.radioValue&&"radio"===b&&n.nodeName(a,"input")){var c=a.value;return a.setAttribute("type",b),c&&(a.value=c),b}}}}}),Zb={set:function(a,b,c){return b===!1?n.removeAttr(a,c):a.setAttribute(c,c),c}},n.each(n.expr.match.bool.source.match(/\w+/g),function(a,b){var c=$b[b]||n.find.attr;$b[b]=function(a,b,d){var e,f;return d||(f=$b[b],$b[b]=e,e=null!=c(a,b,d)?b.toLowerCase():null,$b[b]=f),e}});var _b=/^(?:input|select|textarea|button)$/i;n.fn.extend({prop:function(a,b){return J(this,n.prop,a,b,arguments.length>1)},removeProp:function(a){return this.each(function(){delete this[n.propFix[a]||a]})}}),n.extend({propFix:{"for":"htmlFor","class":"className"},prop:function(a,b,c){var d,e,f,g=a.nodeType;if(a&&3!==g&&8!==g&&2!==g)return f=1!==g||!n.isXMLDoc(a),f&&(b=n.propFix[b]||b,e=n.propHooks[b]),void 0!==c?e&&"set"in e&&void 0!==(d=e.set(a,c,b))?d:a[b]=c:e&&"get"in e&&null!==(d=e.get(a,b))?d:a[b]},propHooks:{tabIndex:{get:function(a){return a.hasAttribute("tabindex")||_b.test(a.nodeName)||a.href?a.tabIndex:-1}}}}),k.optSelected||(n.propHooks.selected={get:function(a){var b=a.parentNode;return b&&b.parentNode&&b.parentNode.selectedIndex,null}}),n.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){n.propFix[this.toLowerCase()]=this});var ac=/[\t\r\n\f]/g;n.fn.extend({addClass:function(a){var b,c,d,e,f,g,h="string"==typeof a&&a,i=0,j=this.length;if(n.isFunction(a))return this.each(function(b){n(this).addClass(a.call(this,b,this.className))});if(h)for(b=(a||"").match(E)||[];j>i;i++)if(c=this[i],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(ac," "):" ")){f=0;while(e=b[f++])d.indexOf(" "+e+" ")<0&&(d+=e+" ");g=n.trim(d),c.className!==g&&(c.className=g)}return this},removeClass:function(a){var b,c,d,e,f,g,h=0===arguments.length||"string"==typeof a&&a,i=0,j=this.length;if(n.isFunction(a))return this.each(function(b){n(this).removeClass(a.call(this,b,this.className))});if(h)for(b=(a||"").match(E)||[];j>i;i++)if(c=this[i],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(ac," "):"")){f=0;while(e=b[f++])while(d.indexOf(" "+e+" ")>=0)d=d.replace(" "+e+" "," ");g=a?n.trim(d):"",c.className!==g&&(c.className=g)}return this},toggleClass:function(a,b){var c=typeof a;return"boolean"==typeof b&&"string"===c?b?this.addClass(a):this.removeClass(a):this.each(n.isFunction(a)?function(c){n(this).toggleClass(a.call(this,c,this.className,b),b)}:function(){if("string"===c){var b,d=0,e=n(this),f=a.match(E)||[];while(b=f[d++])e.hasClass(b)?e.removeClass(b):e.addClass(b)}else(c===U||"boolean"===c)&&(this.className&&L.set(this,"__className__",this.className),this.className=this.className||a===!1?"":L.get(this,"__className__")||"")})},hasClass:function(a){for(var b=" "+a+" ",c=0,d=this.length;d>c;c++)if(1===this[c].nodeType&&(" "+this[c].className+" ").replace(ac," ").indexOf(b)>=0)return!0;return!1}});var bc=/\r/g;n.fn.extend({val:function(a){var b,c,d,e=this[0];{if(arguments.length)return d=n.isFunction(a),this.each(function(c){var e;1===this.nodeType&&(e=d?a.call(this,c,n(this).val()):a,null==e?e="":"number"==typeof e?e+="":n.isArray(e)&&(e=n.map(e,function(a){return null==a?"":a+""})),b=n.valHooks[this.type]||n.valHooks[this.nodeName.toLowerCase()],b&&"set"in b&&void 0!==b.set(this,e,"value")||(this.value=e))});if(e)return b=n.valHooks[e.type]||n.valHooks[e.nodeName.toLowerCase()],b&&"get"in b&&void 0!==(c=b.get(e,"value"))?c:(c=e.value,"string"==typeof c?c.replace(bc,""):null==c?"":c)}}}),n.extend({valHooks:{option:{get:function(a){var b=n.find.attr(a,"value");return null!=b?b:n.trim(n.text(a))}},select:{get:function(a){for(var b,c,d=a.options,e=a.selectedIndex,f="select-one"===a.type||0>e,g=f?null:[],h=f?e+1:d.length,i=0>e?h:f?e:0;h>i;i++)if(c=d[i],!(!c.selected&&i!==e||(k.optDisabled?c.disabled:null!==c.getAttribute("disabled"))||c.parentNode.disabled&&n.nodeName(c.parentNode,"optgroup"))){if(b=n(c).val(),f)return b;g.push(b)}return g},set:function(a,b){var c,d,e=a.options,f=n.makeArray(b),g=e.length;while(g--)d=e[g],(d.selected=n.inArray(d.value,f)>=0)&&(c=!0);return c||(a.selectedIndex=-1),f}}}}),n.each(["radio","checkbox"],function(){n.valHooks[this]={set:function(a,b){return n.isArray(b)?a.checked=n.inArray(n(a).val(),b)>=0:void 0}},k.checkOn||(n.valHooks[this].get=function(a){return null===a.getAttribute("value")?"on":a.value})}),n.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "),function(a,b){n.fn[b]=function(a,c){return arguments.length>0?this.on(b,null,a,c):this.trigger(b)}}),n.fn.extend({hover:function(a,b){return this.mouseenter(a).mouseleave(b||a)},bind:function(a,b,c){return this.on(a,null,b,c)},unbind:function(a,b){return this.off(a,null,b)},delegate:function(a,b,c,d){return this.on(b,a,c,d)},undelegate:function(a,b,c){return 1===arguments.length?this.off(a,"**"):this.off(b,a||"**",c)}});var cc=n.now(),dc=/\?/;n.parseJSON=function(a){return JSON.parse(a+"")},n.parseXML=function(a){var b,c;if(!a||"string"!=typeof a)return null;try{c=new DOMParser,b=c.parseFromString(a,"text/xml")}catch(d){b=void 0}return(!b||b.getElementsByTagName("parsererror").length)&&n.error("Invalid XML: "+a),b};var ec=/#.*$/,fc=/([?&])_=[^&]*/,gc=/^(.*?):[ \t]*([^\r\n]*)$/gm,hc=/^(?:about|app|app-storage|.+-extension|file|res|widget):$/,ic=/^(?:GET|HEAD)$/,jc=/^\/\//,kc=/^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,lc={},mc={},nc="*/".concat("*"),oc=a.location.href,pc=kc.exec(oc.toLowerCase())||[];function qc(a){return function(b,c){"string"!=typeof b&&(c=b,b="*");var d,e=0,f=b.toLowerCase().match(E)||[];if(n.isFunction(c))while(d=f[e++])"+"===d[0]?(d=d.slice(1)||"*",(a[d]=a[d]||[]).unshift(c)):(a[d]=a[d]||[]).push(c)}}function rc(a,b,c,d){var e={},f=a===mc;function g(h){var i;return e[h]=!0,n.each(a[h]||[],function(a,h){var j=h(b,c,d);return"string"!=typeof j||f||e[j]?f?!(i=j):void 0:(b.dataTypes.unshift(j),g(j),!1)}),i}return g(b.dataTypes[0])||!e["*"]&&g("*")}function sc(a,b){var c,d,e=n.ajaxSettings.flatOptions||{};for(c in b)void 0!==b[c]&&((e[c]?a:d||(d={}))[c]=b[c]);return d&&n.extend(!0,a,d),a}function tc(a,b,c){var d,e,f,g,h=a.contents,i=a.dataTypes;while("*"===i[0])i.shift(),void 0===d&&(d=a.mimeType||b.getResponseHeader("Content-Type"));if(d)for(e in h)if(h[e]&&h[e].test(d)){i.unshift(e);break}if(i[0]in c)f=i[0];else{for(e in c){if(!i[0]||a.converters[e+" "+i[0]]){f=e;break}g||(g=e)}f=f||g}return f?(f!==i[0]&&i.unshift(f),c[f]):void 0}function uc(a,b,c,d){var e,f,g,h,i,j={},k=a.dataTypes.slice();if(k[1])for(g in a.converters)j[g.toLowerCase()]=a.converters[g];f=k.shift();while(f)if(a.responseFields[f]&&(c[a.responseFields[f]]=b),!i&&d&&a.dataFilter&&(b=a.dataFilter(b,a.dataType)),i=f,f=k.shift())if("*"===f)f=i;else if("*"!==i&&i!==f){if(g=j[i+" "+f]||j["* "+f],!g)for(e in j)if(h=e.split(" "),h[1]===f&&(g=j[i+" "+h[0]]||j["* "+h[0]])){g===!0?g=j[e]:j[e]!==!0&&(f=h[0],k.unshift(h[1]));break}if(g!==!0)if(g&&a["throws"])b=g(b);else try{b=g(b)}catch(l){return{state:"parsererror",error:g?l:"No conversion from "+i+" to "+f}}}return{state:"success",data:b}}n.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:oc,type:"GET",isLocal:hc.test(pc[1]),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":nc,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/xml/,html:/html/,json:/json/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":n.parseJSON,"text xml":n.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(a,b){return b?sc(sc(a,n.ajaxSettings),b):sc(n.ajaxSettings,a)},ajaxPrefilter:qc(lc),ajaxTransport:qc(mc),ajax:function(a,b){"object"==typeof a&&(b=a,a=void 0),b=b||{};var c,d,e,f,g,h,i,j,k=n.ajaxSetup({},b),l=k.context||k,m=k.context&&(l.nodeType||l.jquery)?n(l):n.event,o=n.Deferred(),p=n.Callbacks("once memory"),q=k.statusCode||{},r={},s={},t=0,u="canceled",v={readyState:0,getResponseHeader:function(a){var b;if(2===t){if(!f){f={};while(b=gc.exec(e))f[b[1].toLowerCase()]=b[2]}b=f[a.toLowerCase()]}return null==b?null:b},getAllResponseHeaders:function(){return 2===t?e:null},setRequestHeader:function(a,b){var c=a.toLowerCase();return t||(a=s[c]=s[c]||a,r[a]=b),this},overrideMimeType:function(a){return t||(k.mimeType=a),this},statusCode:function(a){var b;if(a)if(2>t)for(b in a)q[b]=[q[b],a[b]];else v.always(a[v.status]);return this},abort:function(a){var b=a||u;return c&&c.abort(b),x(0,b),this}};if(o.promise(v).complete=p.add,v.success=v.done,v.error=v.fail,k.url=((a||k.url||oc)+"").replace(ec,"").replace(jc,pc[1]+"//"),k.type=b.method||b.type||k.method||k.type,k.dataTypes=n.trim(k.dataType||"*").toLowerCase().match(E)||[""],null==k.crossDomain&&(h=kc.exec(k.url.toLowerCase()),k.crossDomain=!(!h||h[1]===pc[1]&&h[2]===pc[2]&&(h[3]||("http:"===h[1]?"80":"443"))===(pc[3]||("http:"===pc[1]?"80":"443")))),k.data&&k.processData&&"string"!=typeof k.data&&(k.data=n.param(k.data,k.traditional)),rc(lc,k,b,v),2===t)return v;i=n.event&&k.global,i&&0===n.active++&&n.event.trigger("ajaxStart"),k.type=k.type.toUpperCase(),k.hasContent=!ic.test(k.type),d=k.url,k.hasContent||(k.data&&(d=k.url+=(dc.test(d)?"&":"?")+k.data,delete k.data),k.cache===!1&&(k.url=fc.test(d)?d.replace(fc,"$1_="+cc++):d+(dc.test(d)?"&":"?")+"_="+cc++)),k.ifModified&&(n.lastModified[d]&&v.setRequestHeader("If-Modified-Since",n.lastModified[d]),n.etag[d]&&v.setRequestHeader("If-None-Match",n.etag[d])),(k.data&&k.hasContent&&k.contentType!==!1||b.contentType)&&v.setRequestHeader("Content-Type",k.contentType),v.setRequestHeader("Accept",k.dataTypes[0]&&k.accepts[k.dataTypes[0]]?k.accepts[k.dataTypes[0]]+("*"!==k.dataTypes[0]?", "+nc+"; q=0.01":""):k.accepts["*"]);for(j in k.headers)v.setRequestHeader(j,k.headers[j]);if(k.beforeSend&&(k.beforeSend.call(l,v,k)===!1||2===t))return v.abort();u="abort";for(j in{success:1,error:1,complete:1})v[j](k[j]);if(c=rc(mc,k,b,v)){v.readyState=1,i&&m.trigger("ajaxSend",[v,k]),k.async&&k.timeout>0&&(g=setTimeout(function(){v.abort("timeout")},k.timeout));try{t=1,c.send(r,x)}catch(w){if(!(2>t))throw w;x(-1,w)}}else x(-1,"No Transport");function x(a,b,f,h){var j,r,s,u,w,x=b;2!==t&&(t=2,g&&clearTimeout(g),c=void 0,e=h||"",v.readyState=a>0?4:0,j=a>=200&&300>a||304===a,f&&(u=tc(k,v,f)),u=uc(k,u,v,j),j?(k.ifModified&&(w=v.getResponseHeader("Last-Modified"),w&&(n.lastModified[d]=w),w=v.getResponseHeader("etag"),w&&(n.etag[d]=w)),204===a||"HEAD"===k.type?x="nocontent":304===a?x="notmodified":(x=u.state,r=u.data,s=u.error,j=!s)):(s=x,(a||!x)&&(x="error",0>a&&(a=0))),v.status=a,v.statusText=(b||x)+"",j?o.resolveWith(l,[r,x,v]):o.rejectWith(l,[v,x,s]),v.statusCode(q),q=void 0,i&&m.trigger(j?"ajaxSuccess":"ajaxError",[v,k,j?r:s]),p.fireWith(l,[v,x]),i&&(m.trigger("ajaxComplete",[v,k]),--n.active||n.event.trigger("ajaxStop")))}return v},getJSON:function(a,b,c){return n.get(a,b,c,"json")},getScript:function(a,b){return n.get(a,void 0,b,"script")}}),n.each(["get","post"],function(a,b){n[b]=function(a,c,d,e){return n.isFunction(c)&&(e=e||d,d=c,c=void 0),n.ajax({url:a,type:b,dataType:e,data:c,success:d})}}),n._evalUrl=function(a){return n.ajax({url:a,type:"GET",dataType:"script",async:!1,global:!1,"throws":!0})},n.fn.extend({wrapAll:function(a){var b;return n.isFunction(a)?this.each(function(b){n(this).wrapAll(a.call(this,b))}):(this[0]&&(b=n(a,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&b.insertBefore(this[0]),b.map(function(){var a=this;while(a.firstElementChild)a=a.firstElementChild;return a}).append(this)),this)},wrapInner:function(a){return this.each(n.isFunction(a)?function(b){n(this).wrapInner(a.call(this,b))}:function(){var b=n(this),c=b.contents();c.length?c.wrapAll(a):b.append(a)})},wrap:function(a){var b=n.isFunction(a);return this.each(function(c){n(this).wrapAll(b?a.call(this,c):a)})},unwrap:function(){return this.parent().each(function(){n.nodeName(this,"body")||n(this).replaceWith(this.childNodes)}).end()}}),n.expr.filters.hidden=function(a){return a.offsetWidth<=0&&a.offsetHeight<=0},n.expr.filters.visible=function(a){return!n.expr.filters.hidden(a)};var vc=/%20/g,wc=/\[\]$/,xc=/\r?\n/g,yc=/^(?:submit|button|image|reset|file)$/i,zc=/^(?:input|select|textarea|keygen)/i;function Ac(a,b,c,d){var e;if(n.isArray(b))n.each(b,function(b,e){c||wc.test(a)?d(a,e):Ac(a+"["+("object"==typeof e?b:"")+"]",e,c,d)});else if(c||"object"!==n.type(b))d(a,b);else for(e in b)Ac(a+"["+e+"]",b[e],c,d)}n.param=function(a,b){var c,d=[],e=function(a,b){b=n.isFunction(b)?b():null==b?"":b,d[d.length]=encodeURIComponent(a)+"="+encodeURIComponent(b)};if(void 0===b&&(b=n.ajaxSettings&&n.ajaxSettings.traditional),n.isArray(a)||a.jquery&&!n.isPlainObject(a))n.each(a,function(){e(this.name,this.value)});else for(c in a)Ac(c,a[c],b,e);return d.join("&").replace(vc,"+")},n.fn.extend({serialize:function(){return n.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var a=n.prop(this,"elements");return a?n.makeArray(a):this}).filter(function(){var a=this.type;return this.name&&!n(this).is(":disabled")&&zc.test(this.nodeName)&&!yc.test(a)&&(this.checked||!T.test(a))}).map(function(a,b){var c=n(this).val();return null==c?null:n.isArray(c)?n.map(c,function(a){return{name:b.name,value:a.replace(xc,"\r\n")}}):{name:b.name,value:c.replace(xc,"\r\n")}}).get()}}),n.ajaxSettings.xhr=function(){try{return new XMLHttpRequest}catch(a){}};var Bc=0,Cc={},Dc={0:200,1223:204},Ec=n.ajaxSettings.xhr();a.attachEvent&&a.attachEvent("onunload",function(){for(var a in Cc)Cc[a]()}),k.cors=!!Ec&&"withCredentials"in Ec,k.ajax=Ec=!!Ec,n.ajaxTransport(function(a){var b;return k.cors||Ec&&!a.crossDomain?{send:function(c,d){var e,f=a.xhr(),g=++Bc;if(f.open(a.type,a.url,a.async,a.username,a.password),a.xhrFields)for(e in a.xhrFields)f[e]=a.xhrFields[e];a.mimeType&&f.overrideMimeType&&f.overrideMimeType(a.mimeType),a.crossDomain||c["X-Requested-With"]||(c["X-Requested-With"]="XMLHttpRequest");for(e in c)f.setRequestHeader(e,c[e]);b=function(a){return function(){b&&(delete Cc[g],b=f.onload=f.onerror=null,"abort"===a?f.abort():"error"===a?d(f.status,f.statusText):d(Dc[f.status]||f.status,f.statusText,"string"==typeof f.responseText?{text:f.responseText}:void 0,f.getAllResponseHeaders()))}},f.onload=b(),f.onerror=b("error"),b=Cc[g]=b("abort");try{f.send(a.hasContent&&a.data||null)}catch(h){if(b)throw h}},abort:function(){b&&b()}}:void 0}),n.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/(?:java|ecma)script/},converters:{"text script":function(a){return n.globalEval(a),a}}}),n.ajaxPrefilter("script",function(a){void 0===a.cache&&(a.cache=!1),a.crossDomain&&(a.type="GET")}),n.ajaxTransport("script",function(a){if(a.crossDomain){var b,c;return{send:function(d,e){b=n("<script>").prop({async:!0,charset:a.scriptCharset,src:a.url}).on("load error",c=function(a){b.remove(),c=null,a&&e("error"===a.type?404:200,a.type)}),l.head.appendChild(b[0])},abort:function(){c&&c()}}}});var Fc=[],Gc=/(=)\?(?=&|$)|\?\?/;n.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var a=Fc.pop()||n.expando+"_"+cc++;return this[a]=!0,a}}),n.ajaxPrefilter("json jsonp",function(b,c,d){var e,f,g,h=b.jsonp!==!1&&(Gc.test(b.url)?"url":"string"==typeof b.data&&!(b.contentType||"").indexOf("application/x-www-form-urlencoded")&&Gc.test(b.data)&&"data");return h||"jsonp"===b.dataTypes[0]?(e=b.jsonpCallback=n.isFunction(b.jsonpCallback)?b.jsonpCallback():b.jsonpCallback,h?b[h]=b[h].replace(Gc,"$1"+e):b.jsonp!==!1&&(b.url+=(dc.test(b.url)?"&":"?")+b.jsonp+"="+e),b.converters["script json"]=function(){return g||n.error(e+" was not called"),g[0]},b.dataTypes[0]="json",f=a[e],a[e]=function(){g=arguments},d.always(function(){a[e]=f,b[e]&&(b.jsonpCallback=c.jsonpCallback,Fc.push(e)),g&&n.isFunction(f)&&f(g[0]),g=f=void 0}),"script"):void 0}),n.parseHTML=function(a,b,c){if(!a||"string"!=typeof a)return null;"boolean"==typeof b&&(c=b,b=!1),b=b||l;var d=v.exec(a),e=!c&&[];return d?[b.createElement(d[1])]:(d=n.buildFragment([a],b,e),e&&e.length&&n(e).remove(),n.merge([],d.childNodes))};var Hc=n.fn.load;n.fn.load=function(a,b,c){if("string"!=typeof a&&Hc)return Hc.apply(this,arguments);var d,e,f,g=this,h=a.indexOf(" ");return h>=0&&(d=n.trim(a.slice(h)),a=a.slice(0,h)),n.isFunction(b)?(c=b,b=void 0):b&&"object"==typeof b&&(e="POST"),g.length>0&&n.ajax({url:a,type:e,dataType:"html",data:b}).done(function(a){f=arguments,g.html(d?n("<div>").append(n.parseHTML(a)).find(d):a)}).complete(c&&function(a,b){g.each(c,f||[a.responseText,b,a])}),this},n.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(a,b){n.fn[b]=function(a){return this.on(b,a)}}),n.expr.filters.animated=function(a){return n.grep(n.timers,function(b){return a===b.elem}).length};var Ic=a.document.documentElement;function Jc(a){return n.isWindow(a)?a:9===a.nodeType&&a.defaultView}n.offset={setOffset:function(a,b,c){var d,e,f,g,h,i,j,k=n.css(a,"position"),l=n(a),m={};"static"===k&&(a.style.position="relative"),h=l.offset(),f=n.css(a,"top"),i=n.css(a,"left"),j=("absolute"===k||"fixed"===k)&&(f+i).indexOf("auto")>-1,j?(d=l.position(),g=d.top,e=d.left):(g=parseFloat(f)||0,e=parseFloat(i)||0),n.isFunction(b)&&(b=b.call(a,c,h)),null!=b.top&&(m.top=b.top-h.top+g),null!=b.left&&(m.left=b.left-h.left+e),"using"in b?b.using.call(a,m):l.css(m)}},n.fn.extend({offset:function(a){if(arguments.length)return void 0===a?this:this.each(function(b){n.offset.setOffset(this,a,b)});var b,c,d=this[0],e={top:0,left:0},f=d&&d.ownerDocument;if(f)return b=f.documentElement,n.contains(b,d)?(typeof d.getBoundingClientRect!==U&&(e=d.getBoundingClientRect()),c=Jc(f),{top:e.top+c.pageYOffset-b.clientTop,left:e.left+c.pageXOffset-b.clientLeft}):e},position:function(){if(this[0]){var a,b,c=this[0],d={top:0,left:0};return"fixed"===n.css(c,"position")?b=c.getBoundingClientRect():(a=this.offsetParent(),b=this.offset(),n.nodeName(a[0],"html")||(d=a.offset()),d.top+=n.css(a[0],"borderTopWidth",!0),d.left+=n.css(a[0],"borderLeftWidth",!0)),{top:b.top-d.top-n.css(c,"marginTop",!0),left:b.left-d.left-n.css(c,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var a=this.offsetParent||Ic;while(a&&!n.nodeName(a,"html")&&"static"===n.css(a,"position"))a=a.offsetParent;return a||Ic})}}),n.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(b,c){var d="pageYOffset"===c;n.fn[b]=function(e){return J(this,function(b,e,f){var g=Jc(b);return void 0===f?g?g[c]:b[e]:void(g?g.scrollTo(d?a.pageXOffset:f,d?f:a.pageYOffset):b[e]=f)},b,e,arguments.length,null)}}),n.each(["top","left"],function(a,b){n.cssHooks[b]=yb(k.pixelPosition,function(a,c){return c?(c=xb(a,b),vb.test(c)?n(a).position()[b]+"px":c):void 0})}),n.each({Height:"height",Width:"width"},function(a,b){n.each({padding:"inner"+a,content:b,"":"outer"+a},function(c,d){n.fn[d]=function(d,e){var f=arguments.length&&(c||"boolean"!=typeof d),g=c||(d===!0||e===!0?"margin":"border");return J(this,function(b,c,d){var e;return n.isWindow(b)?b.document.documentElement["client"+a]:9===b.nodeType?(e=b.documentElement,Math.max(b.body["scroll"+a],e["scroll"+a],b.body["offset"+a],e["offset"+a],e["client"+a])):void 0===d?n.css(b,c,g):n.style(b,c,d,g)},b,f?d:void 0,f,null)}})}),n.fn.size=function(){return this.length},n.fn.andSelf=n.fn.addBack,"function"==typeof define&&define.amd&&define("jquery",[],function(){return n});var Kc=a.jQuery,Lc=a.$;return n.noConflict=function(b){return a.$===n&&(a.$=Lc),b&&a.jQuery===n&&(a.jQuery=Kc),n},typeof b===U&&(a.jQuery=a.$=n),n});
	</script>
	<script type="text/javascript">
	/*! jQuery UI - v1.11.2 - 2014-12-20
	* http://jqueryui.com
	* Includes: core.js, widget.js, progressbar.js
	* Copyright 2014 jQuery Foundation and other contributors; Licensed MIT */
	(function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e(jQuery)})(function(e){function t(t,s){var n,a,o,r=t.nodeName.toLowerCase();return"area"===r?(n=t.parentNode,a=n.name,t.href&&a&&"map"===n.nodeName.toLowerCase()?(o=e("img[usemap='#"+a+"']")[0],!!o&&i(o)):!1):(/input|select|textarea|button|object/.test(r)?!t.disabled:"a"===r?t.href||s:s)&&i(t)}function i(t){return e.expr.filters.visible(t)&&!e(t).parents().addBack().filter(function(){return"hidden"===e.css(this,"visibility")}).length}e.ui=e.ui||{},e.extend(e.ui,{version:"1.11.2",keyCode:{BACKSPACE:8,COMMA:188,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,LEFT:37,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SPACE:32,TAB:9,UP:38}}),e.fn.extend({scrollParent:function(t){var i=this.css("position"),s="absolute"===i,n=t?/(auto|scroll|hidden)/:/(auto|scroll)/,a=this.parents().filter(function(){var t=e(this);return s&&"static"===t.css("position")?!1:n.test(t.css("overflow")+t.css("overflow-y")+t.css("overflow-x"))}).eq(0);return"fixed"!==i&&a.length?a:e(this[0].ownerDocument||document)},uniqueId:function(){var e=0;return function(){return this.each(function(){this.id||(this.id="ui-id-"+ ++e)})}}(),removeUniqueId:function(){return this.each(function(){/^ui-id-\d+$/.test(this.id)&&e(this).removeAttr("id")})}}),e.extend(e.expr[":"],{data:e.expr.createPseudo?e.expr.createPseudo(function(t){return function(i){return!!e.data(i,t)}}):function(t,i,s){return!!e.data(t,s[3])},focusable:function(i){return t(i,!isNaN(e.attr(i,"tabindex")))},tabbable:function(i){var s=e.attr(i,"tabindex"),n=isNaN(s);return(n||s>=0)&&t(i,!n)}}),e("<a>").outerWidth(1).jquery||e.each(["Width","Height"],function(t,i){function s(t,i,s,a){return e.each(n,function(){i-=parseFloat(e.css(t,"padding"+this))||0,s&&(i-=parseFloat(e.css(t,"border"+this+"Width"))||0),a&&(i-=parseFloat(e.css(t,"margin"+this))||0)}),i}var n="Width"===i?["Left","Right"]:["Top","Bottom"],a=i.toLowerCase(),o={innerWidth:e.fn.innerWidth,innerHeight:e.fn.innerHeight,outerWidth:e.fn.outerWidth,outerHeight:e.fn.outerHeight};e.fn["inner"+i]=function(t){return void 0===t?o["inner"+i].call(this):this.each(function(){e(this).css(a,s(this,t)+"px")})},e.fn["outer"+i]=function(t,n){return"number"!=typeof t?o["outer"+i].call(this,t):this.each(function(){e(this).css(a,s(this,t,!0,n)+"px")})}}),e.fn.addBack||(e.fn.addBack=function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}),e("<a>").data("a-b","a").removeData("a-b").data("a-b")&&(e.fn.removeData=function(t){return function(i){return arguments.length?t.call(this,e.camelCase(i)):t.call(this)}}(e.fn.removeData)),e.ui.ie=!!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase()),e.fn.extend({focus:function(t){return function(i,s){return"number"==typeof i?this.each(function(){var t=this;setTimeout(function(){e(t).focus(),s&&s.call(t)},i)}):t.apply(this,arguments)}}(e.fn.focus),disableSelection:function(){var e="onselectstart"in document.createElement("div")?"selectstart":"mousedown";return function(){return this.bind(e+".ui-disableSelection",function(e){e.preventDefault()})}}(),enableSelection:function(){return this.unbind(".ui-disableSelection")},zIndex:function(t){if(void 0!==t)return this.css("zIndex",t);if(this.length)for(var i,s,n=e(this[0]);n.length&&n[0]!==document;){if(i=n.css("position"),("absolute"===i||"relative"===i||"fixed"===i)&&(s=parseInt(n.css("zIndex"),10),!isNaN(s)&&0!==s))return s;n=n.parent()}return 0}}),e.ui.plugin={add:function(t,i,s){var n,a=e.ui[t].prototype;for(n in s)a.plugins[n]=a.plugins[n]||[],a.plugins[n].push([i,s[n]])},call:function(e,t,i,s){var n,a=e.plugins[t];if(a&&(s||e.element[0].parentNode&&11!==e.element[0].parentNode.nodeType))for(n=0;a.length>n;n++)e.options[a[n][0]]&&a[n][1].apply(e.element,i)}};var s=0,n=Array.prototype.slice;e.cleanData=function(t){return function(i){var s,n,a;for(a=0;null!=(n=i[a]);a++)try{s=e._data(n,"events"),s&&s.remove&&e(n).triggerHandler("remove")}catch(o){}t(i)}}(e.cleanData),e.widget=function(t,i,s){var n,a,o,r,h={},l=t.split(".")[0];return t=t.split(".")[1],n=l+"-"+t,s||(s=i,i=e.Widget),e.expr[":"][n.toLowerCase()]=function(t){return!!e.data(t,n)},e[l]=e[l]||{},a=e[l][t],o=e[l][t]=function(e,t){return this._createWidget?(arguments.length&&this._createWidget(e,t),void 0):new o(e,t)},e.extend(o,a,{version:s.version,_proto:e.extend({},s),_childConstructors:[]}),r=new i,r.options=e.widget.extend({},r.options),e.each(s,function(t,s){return e.isFunction(s)?(h[t]=function(){var e=function(){return i.prototype[t].apply(this,arguments)},n=function(e){return i.prototype[t].apply(this,e)};return function(){var t,i=this._super,a=this._superApply;return this._super=e,this._superApply=n,t=s.apply(this,arguments),this._super=i,this._superApply=a,t}}(),void 0):(h[t]=s,void 0)}),o.prototype=e.widget.extend(r,{widgetEventPrefix:a?r.widgetEventPrefix||t:t},h,{constructor:o,namespace:l,widgetName:t,widgetFullName:n}),a?(e.each(a._childConstructors,function(t,i){var s=i.prototype;e.widget(s.namespace+"."+s.widgetName,o,i._proto)}),delete a._childConstructors):i._childConstructors.push(o),e.widget.bridge(t,o),o},e.widget.extend=function(t){for(var i,s,a=n.call(arguments,1),o=0,r=a.length;r>o;o++)for(i in a[o])s=a[o][i],a[o].hasOwnProperty(i)&&void 0!==s&&(t[i]=e.isPlainObject(s)?e.isPlainObject(t[i])?e.widget.extend({},t[i],s):e.widget.extend({},s):s);return t},e.widget.bridge=function(t,i){var s=i.prototype.widgetFullName||t;e.fn[t]=function(a){var o="string"==typeof a,r=n.call(arguments,1),h=this;return a=!o&&r.length?e.widget.extend.apply(null,[a].concat(r)):a,o?this.each(function(){var i,n=e.data(this,s);return"instance"===a?(h=n,!1):n?e.isFunction(n[a])&&"_"!==a.charAt(0)?(i=n[a].apply(n,r),i!==n&&void 0!==i?(h=i&&i.jquery?h.pushStack(i.get()):i,!1):void 0):e.error("no such method '"+a+"' for "+t+" widget instance"):e.error("cannot call methods on "+t+" prior to initialization; "+"attempted to call method '"+a+"'")}):this.each(function(){var t=e.data(this,s);t?(t.option(a||{}),t._init&&t._init()):e.data(this,s,new i(a,this))}),h}},e.Widget=function(){},e.Widget._childConstructors=[],e.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",defaultElement:"<div>",options:{disabled:!1,create:null},_createWidget:function(t,i){i=e(i||this.defaultElement||this)[0],this.element=e(i),this.uuid=s++,this.eventNamespace="."+this.widgetName+this.uuid,this.bindings=e(),this.hoverable=e(),this.focusable=e(),i!==this&&(e.data(i,this.widgetFullName,this),this._on(!0,this.element,{remove:function(e){e.target===i&&this.destroy()}}),this.document=e(i.style?i.ownerDocument:i.document||i),this.window=e(this.document[0].defaultView||this.document[0].parentWindow)),this.options=e.widget.extend({},this.options,this._getCreateOptions(),t),this._create(),this._trigger("create",null,this._getCreateEventData()),this._init()},_getCreateOptions:e.noop,_getCreateEventData:e.noop,_create:e.noop,_init:e.noop,destroy:function(){this._destroy(),this.element.unbind(this.eventNamespace).removeData(this.widgetFullName).removeData(e.camelCase(this.widgetFullName)),this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName+"-disabled "+"ui-state-disabled"),this.bindings.unbind(this.eventNamespace),this.hoverable.removeClass("ui-state-hover"),this.focusable.removeClass("ui-state-focus")},_destroy:e.noop,widget:function(){return this.element},option:function(t,i){var s,n,a,o=t;if(0===arguments.length)return e.widget.extend({},this.options);if("string"==typeof t)if(o={},s=t.split("."),t=s.shift(),s.length){for(n=o[t]=e.widget.extend({},this.options[t]),a=0;s.length-1>a;a++)n[s[a]]=n[s[a]]||{},n=n[s[a]];if(t=s.pop(),1===arguments.length)return void 0===n[t]?null:n[t];n[t]=i}else{if(1===arguments.length)return void 0===this.options[t]?null:this.options[t];o[t]=i}return this._setOptions(o),this},_setOptions:function(e){var t;for(t in e)this._setOption(t,e[t]);return this},_setOption:function(e,t){return this.options[e]=t,"disabled"===e&&(this.widget().toggleClass(this.widgetFullName+"-disabled",!!t),t&&(this.hoverable.removeClass("ui-state-hover"),this.focusable.removeClass("ui-state-focus"))),this},enable:function(){return this._setOptions({disabled:!1})},disable:function(){return this._setOptions({disabled:!0})},_on:function(t,i,s){var n,a=this;"boolean"!=typeof t&&(s=i,i=t,t=!1),s?(i=n=e(i),this.bindings=this.bindings.add(i)):(s=i,i=this.element,n=this.widget()),e.each(s,function(s,o){function r(){return t||a.options.disabled!==!0&&!e(this).hasClass("ui-state-disabled")?("string"==typeof o?a[o]:o).apply(a,arguments):void 0}"string"!=typeof o&&(r.guid=o.guid=o.guid||r.guid||e.guid++);var h=s.match(/^([\w:-]*)\s*(.*)$/),l=h[1]+a.eventNamespace,u=h[2];u?n.delegate(u,l,r):i.bind(l,r)})},_off:function(t,i){i=(i||"").split(" ").join(this.eventNamespace+" ")+this.eventNamespace,t.unbind(i).undelegate(i),this.bindings=e(this.bindings.not(t).get()),this.focusable=e(this.focusable.not(t).get()),this.hoverable=e(this.hoverable.not(t).get())},_delay:function(e,t){function i(){return("string"==typeof e?s[e]:e).apply(s,arguments)}var s=this;return setTimeout(i,t||0)},_hoverable:function(t){this.hoverable=this.hoverable.add(t),this._on(t,{mouseenter:function(t){e(t.currentTarget).addClass("ui-state-hover")},mouseleave:function(t){e(t.currentTarget).removeClass("ui-state-hover")}})},_focusable:function(t){this.focusable=this.focusable.add(t),this._on(t,{focusin:function(t){e(t.currentTarget).addClass("ui-state-focus")},focusout:function(t){e(t.currentTarget).removeClass("ui-state-focus")}})},_trigger:function(t,i,s){var n,a,o=this.options[t];if(s=s||{},i=e.Event(i),i.type=(t===this.widgetEventPrefix?t:this.widgetEventPrefix+t).toLowerCase(),i.target=this.element[0],a=i.originalEvent)for(n in a)n in i||(i[n]=a[n]);return this.element.trigger(i,s),!(e.isFunction(o)&&o.apply(this.element[0],[i].concat(s))===!1||i.isDefaultPrevented())}},e.each({show:"fadeIn",hide:"fadeOut"},function(t,i){e.Widget.prototype["_"+t]=function(s,n,a){"string"==typeof n&&(n={effect:n});var o,r=n?n===!0||"number"==typeof n?i:n.effect||i:t;n=n||{},"number"==typeof n&&(n={duration:n}),o=!e.isEmptyObject(n),n.complete=a,n.delay&&s.delay(n.delay),o&&e.effects&&e.effects.effect[r]?s[t](n):r!==t&&s[r]?s[r](n.duration,n.easing,a):s.queue(function(i){e(this)[t](),a&&a.call(s[0]),i()})}}),e.widget,e.widget("ui.progressbar",{version:"1.11.2",options:{max:100,value:0,change:null,complete:null},min:0,_create:function(){this.oldValue=this.options.value=this._constrainedValue(),this.element.addClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").attr({role:"progressbar","aria-valuemin":this.min}),this.valueDiv=e("<div class='ui-progressbar-value ui-widget-header ui-corner-left'></div>").appendTo(this.element),this._refreshValue()},_destroy:function(){this.element.removeClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow"),this.valueDiv.remove()},value:function(e){return void 0===e?this.options.value:(this.options.value=this._constrainedValue(e),this._refreshValue(),void 0)},_constrainedValue:function(e){return void 0===e&&(e=this.options.value),this.indeterminate=e===!1,"number"!=typeof e&&(e=0),this.indeterminate?!1:Math.min(this.options.max,Math.max(this.min,e))},_setOptions:function(e){var t=e.value;delete e.value,this._super(e),this.options.value=this._constrainedValue(t),this._refreshValue()},_setOption:function(e,t){"max"===e&&(t=Math.max(this.min,t)),"disabled"===e&&this.element.toggleClass("ui-state-disabled",!!t).attr("aria-disabled",t),this._super(e,t)},_percentage:function(){return this.indeterminate?100:100*(this.options.value-this.min)/(this.options.max-this.min)},_refreshValue:function(){var t=this.options.value,i=this._percentage();this.valueDiv.toggle(this.indeterminate||t>this.min).toggleClass("ui-corner-right",t===this.options.max).width(i.toFixed(0)+"%"),this.element.toggleClass("ui-progressbar-indeterminate",this.indeterminate),this.indeterminate?(this.element.removeAttr("aria-valuenow"),this.overlayDiv||(this.overlayDiv=e("<div class='ui-progressbar-overlay'></div>").appendTo(this.valueDiv))):(this.element.attr({"aria-valuemax":this.options.max,"aria-valuenow":t}),this.overlayDiv&&(this.overlayDiv.remove(),this.overlayDiv=null)),this.oldValue!==t&&(this.oldValue=t,this._trigger("change")),t===this.options.max&&this._trigger("complete")}})});
	</script>
<?php endif; ?>
	
<!-- ========================================
KNOCKOUT ASSETS -->
<?php if( DUPX_U::isURLActive("ajax.aspnetcdn.com", 443) ): ?>
	<script src="//ajax.aspnetcdn.com/ajax/knockout/knockout-2.2.1.js"></script>
<?php else: ?>
	<script type="text/javascript">
	// Knockout JavaScript library v2.2.1
	// (c) Steven Sanderson - http://knockoutjs.com/
	// License: MIT (http://www.opensource.org/licenses/mit-license.php)

	(function() {function j(w){throw w;}var m=!0,p=null,r=!1;function u(w){return function(){return w}};var x=window,y=document,ga=navigator,F=window.jQuery,I=void 0;
	function L(w){function ha(a,d,c,e,f){var g=[];a=b.j(function(){var a=d(c,f)||[];0<g.length&&(b.a.Ya(M(g),a),e&&b.r.K(e,p,[c,a,f]));g.splice(0,g.length);b.a.P(g,a)},p,{W:a,Ka:function(){return 0==g.length||!b.a.X(g[0])}});return{M:g,j:a.pa()?a:I}}function M(a){for(;a.length&&!b.a.X(a[0]);)a.splice(0,1);if(1<a.length){for(var d=a[0],c=a[a.length-1],e=[d];d!==c;){d=d.nextSibling;if(!d)return;e.push(d)}Array.prototype.splice.apply(a,[0,a.length].concat(e))}return a}function S(a,b,c,e,f){var g=Math.min,
	h=Math.max,k=[],l,n=a.length,q,s=b.length,v=s-n||1,G=n+s+1,J,A,z;for(l=0;l<=n;l++){A=J;k.push(J=[]);z=g(s,l+v);for(q=h(0,l-1);q<=z;q++)J[q]=q?l?a[l-1]===b[q-1]?A[q-1]:g(A[q]||G,J[q-1]||G)+1:q+1:l+1}g=[];h=[];v=[];l=n;for(q=s;l||q;)s=k[l][q]-1,q&&s===k[l][q-1]?h.push(g[g.length]={status:c,value:b[--q],index:q}):l&&s===k[l-1][q]?v.push(g[g.length]={status:e,value:a[--l],index:l}):(g.push({status:"retained",value:b[--q]}),--l);if(h.length&&v.length){a=10*n;var t;for(b=c=0;(f||b<a)&&(t=h[c]);c++){for(e=
	0;k=v[e];e++)if(t.value===k.value){t.moved=k.index;k.moved=t.index;v.splice(e,1);b=e=0;break}b+=e}}return g.reverse()}function T(a,d,c,e,f){f=f||{};var g=a&&N(a),g=g&&g.ownerDocument,h=f.templateEngine||O;b.za.vb(c,h,g);c=h.renderTemplate(c,e,f,g);("number"!=typeof c.length||0<c.length&&"number"!=typeof c[0].nodeType)&&j(Error("Template engine must return an array of DOM nodes"));g=r;switch(d){case "replaceChildren":b.e.N(a,c);g=m;break;case "replaceNode":b.a.Ya(a,c);g=m;break;case "ignoreTargetNode":break;
	default:j(Error("Unknown renderMode: "+d))}g&&(U(c,e),f.afterRender&&b.r.K(f.afterRender,p,[c,e.$data]));return c}function N(a){return a.nodeType?a:0<a.length?a[0]:p}function U(a,d){if(a.length){var c=a[0],e=a[a.length-1];V(c,e,function(a){b.Da(d,a)});V(c,e,function(a){b.s.ib(a,[d])})}}function V(a,d,c){var e;for(d=b.e.nextSibling(d);a&&(e=a)!==d;)a=b.e.nextSibling(e),(1===e.nodeType||8===e.nodeType)&&c(e)}function W(a,d,c){a=b.g.aa(a);for(var e=b.g.Q,f=0;f<a.length;f++){var g=a[f].key;if(e.hasOwnProperty(g)){var h=
	e[g];"function"===typeof h?(g=h(a[f].value))&&j(Error(g)):h||j(Error("This template engine does not support the '"+g+"' binding within its templates"))}}a="ko.__tr_ambtns(function($context,$element){return(function(){return{ "+b.g.ba(a)+" } })()})";return c.createJavaScriptEvaluatorBlock(a)+d}function X(a,d,c,e){function f(a){return function(){return k[a]}}function g(){return k}var h=0,k,l;b.j(function(){var n=c&&c instanceof b.z?c:new b.z(b.a.d(c)),q=n.$data;e&&b.eb(a,n);if(k=("function"==typeof d?
	d(n,a):d)||b.J.instance.getBindings(a,n)){if(0===h){h=1;for(var s in k){var v=b.c[s];v&&8===a.nodeType&&!b.e.I[s]&&j(Error("The binding '"+s+"' cannot be used with virtual elements"));if(v&&"function"==typeof v.init&&(v=(0,v.init)(a,f(s),g,q,n))&&v.controlsDescendantBindings)l!==I&&j(Error("Multiple bindings ("+l+" and "+s+") are trying to control descendant bindings of the same element. You cannot use these bindings together on the same element.")),l=s}h=2}if(2===h)for(s in k)(v=b.c[s])&&"function"==
	typeof v.update&&(0,v.update)(a,f(s),g,q,n)}},p,{W:a});return{Nb:l===I}}function Y(a,d,c){var e=m,f=1===d.nodeType;f&&b.e.Ta(d);if(f&&c||b.J.instance.nodeHasBindings(d))e=X(d,p,a,c).Nb;e&&Z(a,d,!f)}function Z(a,d,c){for(var e=b.e.firstChild(d);d=e;)e=b.e.nextSibling(d),Y(a,d,c)}function $(a,b){var c=aa(a,b);return c?0<c.length?c[c.length-1].nextSibling:a.nextSibling:p}function aa(a,b){for(var c=a,e=1,f=[];c=c.nextSibling;){if(H(c)&&(e--,0===e))return f;f.push(c);B(c)&&e++}b||j(Error("Cannot find closing comment tag to match: "+
	a.nodeValue));return p}function H(a){return 8==a.nodeType&&(K?a.text:a.nodeValue).match(ia)}function B(a){return 8==a.nodeType&&(K?a.text:a.nodeValue).match(ja)}function P(a,b){for(var c=p;a!=c;)c=a,a=a.replace(ka,function(a,c){return b[c]});return a}function la(){var a=[],d=[];this.save=function(c,e){var f=b.a.i(a,c);0<=f?d[f]=e:(a.push(c),d.push(e))};this.get=function(c){c=b.a.i(a,c);return 0<=c?d[c]:I}}function ba(a,b,c){function e(e){var g=b(a[e]);switch(typeof g){case "boolean":case "number":case "string":case "function":f[e]=
	g;break;case "object":case "undefined":var h=c.get(g);f[e]=h!==I?h:ba(g,b,c)}}c=c||new la;a=b(a);if(!("object"==typeof a&&a!==p&&a!==I&&!(a instanceof Date)))return a;var f=a instanceof Array?[]:{};c.save(a,f);var g=a;if(g instanceof Array){for(var h=0;h<g.length;h++)e(h);"function"==typeof g.toJSON&&e("toJSON")}else for(h in g)e(h);return f}function ca(a,d){if(a)if(8==a.nodeType){var c=b.s.Ua(a.nodeValue);c!=p&&d.push({sb:a,Fb:c})}else if(1==a.nodeType)for(var c=0,e=a.childNodes,f=e.length;c<f;c++)ca(e[c],
	d)}function Q(a,d,c,e){b.c[a]={init:function(a){b.a.f.set(a,da,{});return{controlsDescendantBindings:m}},update:function(a,g,h,k,l){h=b.a.f.get(a,da);g=b.a.d(g());k=!c!==!g;var n=!h.Za;if(n||d||k!==h.qb)n&&(h.Za=b.a.Ia(b.e.childNodes(a),m)),k?(n||b.e.N(a,b.a.Ia(h.Za)),b.Ea(e?e(l,g):l,a)):b.e.Y(a),h.qb=k}};b.g.Q[a]=r;b.e.I[a]=m}function ea(a,d,c){c&&d!==b.k.q(a)&&b.k.T(a,d);d!==b.k.q(a)&&b.r.K(b.a.Ba,p,[a,"change"])}var b="undefined"!==typeof w?w:{};b.b=function(a,d){for(var c=a.split("."),e=b,f=0;f<
	c.length-1;f++)e=e[c[f]];e[c[c.length-1]]=d};b.p=function(a,b,c){a[b]=c};b.version="2.2.1";b.b("version",b.version);b.a=new function(){function a(a,d){if("input"!==b.a.u(a)||!a.type||"click"!=d.toLowerCase())return r;var c=a.type;return"checkbox"==c||"radio"==c}var d=/^(\s|\u00A0)+|(\s|\u00A0)+$/g,c={},e={};c[/Firefox\/2/i.test(ga.userAgent)?"KeyboardEvent":"UIEvents"]=["keyup","keydown","keypress"];c.MouseEvents="click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave".split(" ");
	for(var f in c){var g=c[f];if(g.length)for(var h=0,k=g.length;h<k;h++)e[g[h]]=f}var l={propertychange:m},n,c=3;f=y.createElement("div");for(g=f.getElementsByTagName("i");f.innerHTML="\x3c!--[if gt IE "+ ++c+"]><i></i><![endif]--\x3e",g[0];);n=4<c?c:I;return{Na:["authenticity_token",/^__RequestVerificationToken(_.*)?$/],o:function(a,b){for(var d=0,c=a.length;d<c;d++)b(a[d])},i:function(a,b){if("function"==typeof Array.prototype.indexOf)return Array.prototype.indexOf.call(a,b);for(var d=0,c=a.length;d<
	c;d++)if(a[d]===b)return d;return-1},lb:function(a,b,d){for(var c=0,e=a.length;c<e;c++)if(b.call(d,a[c]))return a[c];return p},ga:function(a,d){var c=b.a.i(a,d);0<=c&&a.splice(c,1)},Ga:function(a){a=a||[];for(var d=[],c=0,e=a.length;c<e;c++)0>b.a.i(d,a[c])&&d.push(a[c]);return d},V:function(a,b){a=a||[];for(var d=[],c=0,e=a.length;c<e;c++)d.push(b(a[c]));return d},fa:function(a,b){a=a||[];for(var d=[],c=0,e=a.length;c<e;c++)b(a[c])&&d.push(a[c]);return d},P:function(a,b){if(b instanceof Array)a.push.apply(a,
	b);else for(var d=0,c=b.length;d<c;d++)a.push(b[d]);return a},extend:function(a,b){if(b)for(var d in b)b.hasOwnProperty(d)&&(a[d]=b[d]);return a},ka:function(a){for(;a.firstChild;)b.removeNode(a.firstChild)},Hb:function(a){a=b.a.L(a);for(var d=y.createElement("div"),c=0,e=a.length;c<e;c++)d.appendChild(b.A(a[c]));return d},Ia:function(a,d){for(var c=0,e=a.length,g=[];c<e;c++){var f=a[c].cloneNode(m);g.push(d?b.A(f):f)}return g},N:function(a,d){b.a.ka(a);if(d)for(var c=0,e=d.length;c<e;c++)a.appendChild(d[c])},
	Ya:function(a,d){var c=a.nodeType?[a]:a;if(0<c.length){for(var e=c[0],g=e.parentNode,f=0,h=d.length;f<h;f++)g.insertBefore(d[f],e);f=0;for(h=c.length;f<h;f++)b.removeNode(c[f])}},bb:function(a,b){7>n?a.setAttribute("selected",b):a.selected=b},D:function(a){return(a||"").replace(d,"")},Rb:function(a,d){for(var c=[],e=(a||"").split(d),f=0,g=e.length;f<g;f++){var h=b.a.D(e[f]);""!==h&&c.push(h)}return c},Ob:function(a,b){a=a||"";return b.length>a.length?r:a.substring(0,b.length)===b},tb:function(a,b){if(b.compareDocumentPosition)return 16==
	(b.compareDocumentPosition(a)&16);for(;a!=p;){if(a==b)return m;a=a.parentNode}return r},X:function(a){return b.a.tb(a,a.ownerDocument)},u:function(a){return a&&a.tagName&&a.tagName.toLowerCase()},n:function(b,d,c){var e=n&&l[d];if(!e&&"undefined"!=typeof F){if(a(b,d)){var f=c;c=function(a,b){var d=this.checked;b&&(this.checked=b.nb!==m);f.call(this,a);this.checked=d}}F(b).bind(d,c)}else!e&&"function"==typeof b.addEventListener?b.addEventListener(d,c,r):"undefined"!=typeof b.attachEvent?b.attachEvent("on"+
	d,function(a){c.call(b,a)}):j(Error("Browser doesn't support addEventListener or attachEvent"))},Ba:function(b,d){(!b||!b.nodeType)&&j(Error("element must be a DOM node when calling triggerEvent"));if("undefined"!=typeof F){var c=[];a(b,d)&&c.push({nb:b.checked});F(b).trigger(d,c)}else"function"==typeof y.createEvent?"function"==typeof b.dispatchEvent?(c=y.createEvent(e[d]||"HTMLEvents"),c.initEvent(d,m,m,x,0,0,0,0,0,r,r,r,r,0,b),b.dispatchEvent(c)):j(Error("The supplied element doesn't support dispatchEvent")):
	"undefined"!=typeof b.fireEvent?(a(b,d)&&(b.checked=b.checked!==m),b.fireEvent("on"+d)):j(Error("Browser doesn't support triggering events"))},d:function(a){return b.$(a)?a():a},ua:function(a){return b.$(a)?a.t():a},da:function(a,d,c){if(d){var e=/[\w-]+/g,f=a.className.match(e)||[];b.a.o(d.match(e),function(a){var d=b.a.i(f,a);0<=d?c||f.splice(d,1):c&&f.push(a)});a.className=f.join(" ")}},cb:function(a,d){var c=b.a.d(d);if(c===p||c===I)c="";if(3===a.nodeType)a.data=c;else{var e=b.e.firstChild(a);
	!e||3!=e.nodeType||b.e.nextSibling(e)?b.e.N(a,[y.createTextNode(c)]):e.data=c;b.a.wb(a)}},ab:function(a,b){a.name=b;if(7>=n)try{a.mergeAttributes(y.createElement("<input name='"+a.name+"'/>"),r)}catch(d){}},wb:function(a){9<=n&&(a=1==a.nodeType?a:a.parentNode,a.style&&(a.style.zoom=a.style.zoom))},ub:function(a){if(9<=n){var b=a.style.width;a.style.width=0;a.style.width=b}},Lb:function(a,d){a=b.a.d(a);d=b.a.d(d);for(var c=[],e=a;e<=d;e++)c.push(e);return c},L:function(a){for(var b=[],d=0,c=a.length;d<
	c;d++)b.push(a[d]);return b},Pb:6===n,Qb:7===n,Z:n,Oa:function(a,d){for(var c=b.a.L(a.getElementsByTagName("input")).concat(b.a.L(a.getElementsByTagName("textarea"))),e="string"==typeof d?function(a){return a.name===d}:function(a){return d.test(a.name)},f=[],g=c.length-1;0<=g;g--)e(c[g])&&f.push(c[g]);return f},Ib:function(a){return"string"==typeof a&&(a=b.a.D(a))?x.JSON&&x.JSON.parse?x.JSON.parse(a):(new Function("return "+a))():p},xa:function(a,d,c){("undefined"==typeof JSON||"undefined"==typeof JSON.stringify)&&
	j(Error("Cannot find JSON.stringify(). Some browsers (e.g., IE < 8) don't support it natively, but you can overcome this by adding a script reference to json2.js, downloadable from http://www.json.org/json2.js"));return JSON.stringify(b.a.d(a),d,c)},Jb:function(a,d,c){c=c||{};var e=c.params||{},f=c.includeFields||this.Na,g=a;if("object"==typeof a&&"form"===b.a.u(a))for(var g=a.action,h=f.length-1;0<=h;h--)for(var k=b.a.Oa(a,f[h]),l=k.length-1;0<=l;l--)e[k[l].name]=k[l].value;d=b.a.d(d);var n=y.createElement("form");
	n.style.display="none";n.action=g;n.method="post";for(var w in d)a=y.createElement("input"),a.name=w,a.value=b.a.xa(b.a.d(d[w])),n.appendChild(a);for(w in e)a=y.createElement("input"),a.name=w,a.value=e[w],n.appendChild(a);y.body.appendChild(n);c.submitter?c.submitter(n):n.submit();setTimeout(function(){n.parentNode.removeChild(n)},0)}}};b.b("utils",b.a);b.b("utils.arrayForEach",b.a.o);b.b("utils.arrayFirst",b.a.lb);b.b("utils.arrayFilter",b.a.fa);b.b("utils.arrayGetDistinctValues",b.a.Ga);b.b("utils.arrayIndexOf",
	b.a.i);b.b("utils.arrayMap",b.a.V);b.b("utils.arrayPushAll",b.a.P);b.b("utils.arrayRemoveItem",b.a.ga);b.b("utils.extend",b.a.extend);b.b("utils.fieldsIncludedWithJsonPost",b.a.Na);b.b("utils.getFormFields",b.a.Oa);b.b("utils.peekObservable",b.a.ua);b.b("utils.postJson",b.a.Jb);b.b("utils.parseJson",b.a.Ib);b.b("utils.registerEventHandler",b.a.n);b.b("utils.stringifyJson",b.a.xa);b.b("utils.range",b.a.Lb);b.b("utils.toggleDomNodeCssClass",b.a.da);b.b("utils.triggerEvent",b.a.Ba);b.b("utils.unwrapObservable",
	b.a.d);Function.prototype.bind||(Function.prototype.bind=function(a){var b=this,c=Array.prototype.slice.call(arguments);a=c.shift();return function(){return b.apply(a,c.concat(Array.prototype.slice.call(arguments)))}});b.a.f=new function(){var a=0,d="__ko__"+(new Date).getTime(),c={};return{get:function(a,d){var c=b.a.f.la(a,r);return c===I?I:c[d]},set:function(a,d,c){c===I&&b.a.f.la(a,r)===I||(b.a.f.la(a,m)[d]=c)},la:function(b,f){var g=b[d];if(!g||!("null"!==g&&c[g])){if(!f)return I;g=b[d]="ko"+
	a++;c[g]={}}return c[g]},clear:function(a){var b=a[d];return b?(delete c[b],a[d]=p,m):r}}};b.b("utils.domData",b.a.f);b.b("utils.domData.clear",b.a.f.clear);b.a.F=new function(){function a(a,d){var e=b.a.f.get(a,c);e===I&&d&&(e=[],b.a.f.set(a,c,e));return e}function d(c){var e=a(c,r);if(e)for(var e=e.slice(0),k=0;k<e.length;k++)e[k](c);b.a.f.clear(c);"function"==typeof F&&"function"==typeof F.cleanData&&F.cleanData([c]);if(f[c.nodeType])for(e=c.firstChild;c=e;)e=c.nextSibling,8===c.nodeType&&d(c)}
	var c="__ko_domNodeDisposal__"+(new Date).getTime(),e={1:m,8:m,9:m},f={1:m,9:m};return{Ca:function(b,d){"function"!=typeof d&&j(Error("Callback must be a function"));a(b,m).push(d)},Xa:function(d,e){var f=a(d,r);f&&(b.a.ga(f,e),0==f.length&&b.a.f.set(d,c,I))},A:function(a){if(e[a.nodeType]&&(d(a),f[a.nodeType])){var c=[];b.a.P(c,a.getElementsByTagName("*"));for(var k=0,l=c.length;k<l;k++)d(c[k])}return a},removeNode:function(a){b.A(a);a.parentNode&&a.parentNode.removeChild(a)}}};b.A=b.a.F.A;b.removeNode=
	b.a.F.removeNode;b.b("cleanNode",b.A);b.b("removeNode",b.removeNode);b.b("utils.domNodeDisposal",b.a.F);b.b("utils.domNodeDisposal.addDisposeCallback",b.a.F.Ca);b.b("utils.domNodeDisposal.removeDisposeCallback",b.a.F.Xa);b.a.ta=function(a){var d;if("undefined"!=typeof F)if(F.parseHTML)d=F.parseHTML(a);else{if((d=F.clean([a]))&&d[0]){for(a=d[0];a.parentNode&&11!==a.parentNode.nodeType;)a=a.parentNode;a.parentNode&&a.parentNode.removeChild(a)}}else{var c=b.a.D(a).toLowerCase();d=y.createElement("div");
	c=c.match(/^<(thead|tbody|tfoot)/)&&[1,"<table>","</table>"]||!c.indexOf("<tr")&&[2,"<table><tbody>","</tbody></table>"]||(!c.indexOf("<td")||!c.indexOf("<th"))&&[3,"<table><tbody><tr>","</tr></tbody></table>"]||[0,"",""];a="ignored<div>"+c[1]+a+c[2]+"</div>";for("function"==typeof x.innerShiv?d.appendChild(x.innerShiv(a)):d.innerHTML=a;c[0]--;)d=d.lastChild;d=b.a.L(d.lastChild.childNodes)}return d};b.a.ca=function(a,d){b.a.ka(a);d=b.a.d(d);if(d!==p&&d!==I)if("string"!=typeof d&&(d=d.toString()),
	"undefined"!=typeof F)F(a).html(d);else for(var c=b.a.ta(d),e=0;e<c.length;e++)a.appendChild(c[e])};b.b("utils.parseHtmlFragment",b.a.ta);b.b("utils.setHtml",b.a.ca);var R={};b.s={ra:function(a){"function"!=typeof a&&j(Error("You can only pass a function to ko.memoization.memoize()"));var b=(4294967296*(1+Math.random())|0).toString(16).substring(1)+(4294967296*(1+Math.random())|0).toString(16).substring(1);R[b]=a;return"\x3c!--[ko_memo:"+b+"]--\x3e"},hb:function(a,b){var c=R[a];c===I&&j(Error("Couldn't find any memo with ID "+
	a+". Perhaps it's already been unmemoized."));try{return c.apply(p,b||[]),m}finally{delete R[a]}},ib:function(a,d){var c=[];ca(a,c);for(var e=0,f=c.length;e<f;e++){var g=c[e].sb,h=[g];d&&b.a.P(h,d);b.s.hb(c[e].Fb,h);g.nodeValue="";g.parentNode&&g.parentNode.removeChild(g)}},Ua:function(a){return(a=a.match(/^\[ko_memo\:(.*?)\]$/))?a[1]:p}};b.b("memoization",b.s);b.b("memoization.memoize",b.s.ra);b.b("memoization.unmemoize",b.s.hb);b.b("memoization.parseMemoText",b.s.Ua);b.b("memoization.unmemoizeDomNodeAndDescendants",
	b.s.ib);b.Ma={throttle:function(a,d){a.throttleEvaluation=d;var c=p;return b.j({read:a,write:function(b){clearTimeout(c);c=setTimeout(function(){a(b)},d)}})},notify:function(a,d){a.equalityComparer="always"==d?u(r):b.m.fn.equalityComparer;return a}};b.b("extenders",b.Ma);b.fb=function(a,d,c){this.target=a;this.ha=d;this.rb=c;b.p(this,"dispose",this.B)};b.fb.prototype.B=function(){this.Cb=m;this.rb()};b.S=function(){this.w={};b.a.extend(this,b.S.fn);b.p(this,"subscribe",this.ya);b.p(this,"extend",
	this.extend);b.p(this,"getSubscriptionsCount",this.yb)};b.S.fn={ya:function(a,d,c){c=c||"change";var e=new b.fb(this,d?a.bind(d):a,function(){b.a.ga(this.w[c],e)}.bind(this));this.w[c]||(this.w[c]=[]);this.w[c].push(e);return e},notifySubscribers:function(a,d){d=d||"change";this.w[d]&&b.r.K(function(){b.a.o(this.w[d].slice(0),function(b){b&&b.Cb!==m&&b.ha(a)})},this)},yb:function(){var a=0,b;for(b in this.w)this.w.hasOwnProperty(b)&&(a+=this.w[b].length);return a},extend:function(a){var d=this;if(a)for(var c in a){var e=
	b.Ma[c];"function"==typeof e&&(d=e(d,a[c]))}return d}};b.Qa=function(a){return"function"==typeof a.ya&&"function"==typeof a.notifySubscribers};b.b("subscribable",b.S);b.b("isSubscribable",b.Qa);var C=[];b.r={mb:function(a){C.push({ha:a,La:[]})},end:function(){C.pop()},Wa:function(a){b.Qa(a)||j(Error("Only subscribable things can act as dependencies"));if(0<C.length){var d=C[C.length-1];d&&!(0<=b.a.i(d.La,a))&&(d.La.push(a),d.ha(a))}},K:function(a,b,c){try{return C.push(p),a.apply(b,c||[])}finally{C.pop()}}};
	var ma={undefined:m,"boolean":m,number:m,string:m};b.m=function(a){function d(){if(0<arguments.length){if(!d.equalityComparer||!d.equalityComparer(c,arguments[0]))d.H(),c=arguments[0],d.G();return this}b.r.Wa(d);return c}var c=a;b.S.call(d);d.t=function(){return c};d.G=function(){d.notifySubscribers(c)};d.H=function(){d.notifySubscribers(c,"beforeChange")};b.a.extend(d,b.m.fn);b.p(d,"peek",d.t);b.p(d,"valueHasMutated",d.G);b.p(d,"valueWillMutate",d.H);return d};b.m.fn={equalityComparer:function(a,
	b){return a===p||typeof a in ma?a===b:r}};var E=b.m.Kb="__ko_proto__";b.m.fn[E]=b.m;b.ma=function(a,d){return a===p||a===I||a[E]===I?r:a[E]===d?m:b.ma(a[E],d)};b.$=function(a){return b.ma(a,b.m)};b.Ra=function(a){return"function"==typeof a&&a[E]===b.m||"function"==typeof a&&a[E]===b.j&&a.zb?m:r};b.b("observable",b.m);b.b("isObservable",b.$);b.b("isWriteableObservable",b.Ra);b.R=function(a){0==arguments.length&&(a=[]);a!==p&&(a!==I&&!("length"in a))&&j(Error("The argument passed when initializing an observable array must be an array, or null, or undefined."));
	var d=b.m(a);b.a.extend(d,b.R.fn);return d};b.R.fn={remove:function(a){for(var b=this.t(),c=[],e="function"==typeof a?a:function(b){return b===a},f=0;f<b.length;f++){var g=b[f];e(g)&&(0===c.length&&this.H(),c.push(g),b.splice(f,1),f--)}c.length&&this.G();return c},removeAll:function(a){if(a===I){var d=this.t(),c=d.slice(0);this.H();d.splice(0,d.length);this.G();return c}return!a?[]:this.remove(function(d){return 0<=b.a.i(a,d)})},destroy:function(a){var b=this.t(),c="function"==typeof a?a:function(b){return b===
	a};this.H();for(var e=b.length-1;0<=e;e--)c(b[e])&&(b[e]._destroy=m);this.G()},destroyAll:function(a){return a===I?this.destroy(u(m)):!a?[]:this.destroy(function(d){return 0<=b.a.i(a,d)})},indexOf:function(a){var d=this();return b.a.i(d,a)},replace:function(a,b){var c=this.indexOf(a);0<=c&&(this.H(),this.t()[c]=b,this.G())}};b.a.o("pop push reverse shift sort splice unshift".split(" "),function(a){b.R.fn[a]=function(){var b=this.t();this.H();b=b[a].apply(b,arguments);this.G();return b}});b.a.o(["slice"],
	function(a){b.R.fn[a]=function(){var b=this();return b[a].apply(b,arguments)}});b.b("observableArray",b.R);b.j=function(a,d,c){function e(){b.a.o(z,function(a){a.B()});z=[]}function f(){var a=h.throttleEvaluation;a&&0<=a?(clearTimeout(t),t=setTimeout(g,a)):g()}function g(){if(!q)if(n&&w())A();else{q=m;try{var a=b.a.V(z,function(a){return a.target});b.r.mb(function(c){var d;0<=(d=b.a.i(a,c))?a[d]=I:z.push(c.ya(f))});for(var c=s.call(d),e=a.length-1;0<=e;e--)a[e]&&z.splice(e,1)[0].B();n=m;h.notifySubscribers(l,
	"beforeChange");l=c}finally{b.r.end()}h.notifySubscribers(l);q=r;z.length||A()}}function h(){if(0<arguments.length)return"function"===typeof v?v.apply(d,arguments):j(Error("Cannot write a value to a ko.computed unless you specify a 'write' option. If you wish to read the current value, don't pass any parameters.")),this;n||g();b.r.Wa(h);return l}function k(){return!n||0<z.length}var l,n=r,q=r,s=a;s&&"object"==typeof s?(c=s,s=c.read):(c=c||{},s||(s=c.read));"function"!=typeof s&&j(Error("Pass a function that returns the value of the ko.computed"));
	var v=c.write,G=c.disposeWhenNodeIsRemoved||c.W||p,w=c.disposeWhen||c.Ka||u(r),A=e,z=[],t=p;d||(d=c.owner);h.t=function(){n||g();return l};h.xb=function(){return z.length};h.zb="function"===typeof c.write;h.B=function(){A()};h.pa=k;b.S.call(h);b.a.extend(h,b.j.fn);b.p(h,"peek",h.t);b.p(h,"dispose",h.B);b.p(h,"isActive",h.pa);b.p(h,"getDependenciesCount",h.xb);c.deferEvaluation!==m&&g();if(G&&k()){A=function(){b.a.F.Xa(G,arguments.callee);e()};b.a.F.Ca(G,A);var D=w,w=function(){return!b.a.X(G)||D()}}return h};
	b.Bb=function(a){return b.ma(a,b.j)};w=b.m.Kb;b.j[w]=b.m;b.j.fn={};b.j.fn[w]=b.j;b.b("dependentObservable",b.j);b.b("computed",b.j);b.b("isComputed",b.Bb);b.gb=function(a){0==arguments.length&&j(Error("When calling ko.toJS, pass the object you want to convert."));return ba(a,function(a){for(var c=0;b.$(a)&&10>c;c++)a=a();return a})};b.toJSON=function(a,d,c){a=b.gb(a);return b.a.xa(a,d,c)};b.b("toJS",b.gb);b.b("toJSON",b.toJSON);b.k={q:function(a){switch(b.a.u(a)){case "option":return a.__ko__hasDomDataOptionValue__===
	m?b.a.f.get(a,b.c.options.sa):7>=b.a.Z?a.getAttributeNode("value").specified?a.value:a.text:a.value;case "select":return 0<=a.selectedIndex?b.k.q(a.options[a.selectedIndex]):I;default:return a.value}},T:function(a,d){switch(b.a.u(a)){case "option":switch(typeof d){case "string":b.a.f.set(a,b.c.options.sa,I);"__ko__hasDomDataOptionValue__"in a&&delete a.__ko__hasDomDataOptionValue__;a.value=d;break;default:b.a.f.set(a,b.c.options.sa,d),a.__ko__hasDomDataOptionValue__=m,a.value="number"===typeof d?
	d:""}break;case "select":for(var c=a.options.length-1;0<=c;c--)if(b.k.q(a.options[c])==d){a.selectedIndex=c;break}break;default:if(d===p||d===I)d="";a.value=d}}};b.b("selectExtensions",b.k);b.b("selectExtensions.readValue",b.k.q);b.b("selectExtensions.writeValue",b.k.T);var ka=/\@ko_token_(\d+)\@/g,na=["true","false"],oa=/^(?:[$_a-z][$\w]*|(.+)(\.\s*[$_a-z][$\w]*|\[.+\]))$/i;b.g={Q:[],aa:function(a){var d=b.a.D(a);if(3>d.length)return[];"{"===d.charAt(0)&&(d=d.substring(1,d.length-1));a=[];for(var c=
	p,e,f=0;f<d.length;f++){var g=d.charAt(f);if(c===p)switch(g){case '"':case "'":case "/":c=f,e=g}else if(g==e&&"\\"!==d.charAt(f-1)){g=d.substring(c,f+1);a.push(g);var h="@ko_token_"+(a.length-1)+"@",d=d.substring(0,c)+h+d.substring(f+1),f=f-(g.length-h.length),c=p}}e=c=p;for(var k=0,l=p,f=0;f<d.length;f++){g=d.charAt(f);if(c===p)switch(g){case "{":c=f;l=g;e="}";break;case "(":c=f;l=g;e=")";break;case "[":c=f,l=g,e="]"}g===l?k++:g===e&&(k--,0===k&&(g=d.substring(c,f+1),a.push(g),h="@ko_token_"+(a.length-
	1)+"@",d=d.substring(0,c)+h+d.substring(f+1),f-=g.length-h.length,c=p))}e=[];d=d.split(",");c=0;for(f=d.length;c<f;c++)k=d[c],l=k.indexOf(":"),0<l&&l<k.length-1?(g=k.substring(l+1),e.push({key:P(k.substring(0,l),a),value:P(g,a)})):e.push({unknown:P(k,a)});return e},ba:function(a){var d="string"===typeof a?b.g.aa(a):a,c=[];a=[];for(var e,f=0;e=d[f];f++)if(0<c.length&&c.push(","),e.key){var g;a:{g=e.key;var h=b.a.D(g);switch(h.length&&h.charAt(0)){case "'":case '"':break a;default:g="'"+h+"'"}}e=e.value;
	c.push(g);c.push(":");c.push(e);e=b.a.D(e);0<=b.a.i(na,b.a.D(e).toLowerCase())?e=r:(h=e.match(oa),e=h===p?r:h[1]?"Object("+h[1]+")"+h[2]:e);e&&(0<a.length&&a.push(", "),a.push(g+" : function(__ko_value) { "+e+" = __ko_value; }"))}else e.unknown&&c.push(e.unknown);d=c.join("");0<a.length&&(d=d+", '_ko_property_writers' : { "+a.join("")+" } ");return d},Eb:function(a,d){for(var c=0;c<a.length;c++)if(b.a.D(a[c].key)==d)return m;return r},ea:function(a,d,c,e,f){if(!a||!b.Ra(a)){if((a=d()._ko_property_writers)&&
	a[c])a[c](e)}else(!f||a.t()!==e)&&a(e)}};b.b("expressionRewriting",b.g);b.b("expressionRewriting.bindingRewriteValidators",b.g.Q);b.b("expressionRewriting.parseObjectLiteral",b.g.aa);b.b("expressionRewriting.preProcessBindings",b.g.ba);b.b("jsonExpressionRewriting",b.g);b.b("jsonExpressionRewriting.insertPropertyAccessorsIntoJson",b.g.ba);var K="\x3c!--test--\x3e"===y.createComment("test").text,ja=K?/^\x3c!--\s*ko(?:\s+(.+\s*\:[\s\S]*))?\s*--\x3e$/:/^\s*ko(?:\s+(.+\s*\:[\s\S]*))?\s*$/,ia=K?/^\x3c!--\s*\/ko\s*--\x3e$/:
	/^\s*\/ko\s*$/,pa={ul:m,ol:m};b.e={I:{},childNodes:function(a){return B(a)?aa(a):a.childNodes},Y:function(a){if(B(a)){a=b.e.childNodes(a);for(var d=0,c=a.length;d<c;d++)b.removeNode(a[d])}else b.a.ka(a)},N:function(a,d){if(B(a)){b.e.Y(a);for(var c=a.nextSibling,e=0,f=d.length;e<f;e++)c.parentNode.insertBefore(d[e],c)}else b.a.N(a,d)},Va:function(a,b){B(a)?a.parentNode.insertBefore(b,a.nextSibling):a.firstChild?a.insertBefore(b,a.firstChild):a.appendChild(b)},Pa:function(a,d,c){c?B(a)?a.parentNode.insertBefore(d,
	c.nextSibling):c.nextSibling?a.insertBefore(d,c.nextSibling):a.appendChild(d):b.e.Va(a,d)},firstChild:function(a){return!B(a)?a.firstChild:!a.nextSibling||H(a.nextSibling)?p:a.nextSibling},nextSibling:function(a){B(a)&&(a=$(a));return a.nextSibling&&H(a.nextSibling)?p:a.nextSibling},jb:function(a){return(a=B(a))?a[1]:p},Ta:function(a){if(pa[b.a.u(a)]){var d=a.firstChild;if(d){do if(1===d.nodeType){var c;c=d.firstChild;var e=p;if(c){do if(e)e.push(c);else if(B(c)){var f=$(c,m);f?c=f:e=[c]}else H(c)&&
	(e=[c]);while(c=c.nextSibling)}if(c=e){e=d.nextSibling;for(f=0;f<c.length;f++)e?a.insertBefore(c[f],e):a.appendChild(c[f])}}while(d=d.nextSibling)}}}};b.b("virtualElements",b.e);b.b("virtualElements.allowedBindings",b.e.I);b.b("virtualElements.emptyNode",b.e.Y);b.b("virtualElements.insertAfter",b.e.Pa);b.b("virtualElements.prepend",b.e.Va);b.b("virtualElements.setDomNodeChildren",b.e.N);b.J=function(){this.Ha={}};b.a.extend(b.J.prototype,{nodeHasBindings:function(a){switch(a.nodeType){case 1:return a.getAttribute("data-bind")!=
	p;case 8:return b.e.jb(a)!=p;default:return r}},getBindings:function(a,b){var c=this.getBindingsString(a,b);return c?this.parseBindingsString(c,b,a):p},getBindingsString:function(a){switch(a.nodeType){case 1:return a.getAttribute("data-bind");case 8:return b.e.jb(a);default:return p}},parseBindingsString:function(a,d,c){try{var e;if(!(e=this.Ha[a])){var f=this.Ha,g,h="with($context){with($data||{}){return{"+b.g.ba(a)+"}}}";g=new Function("$context","$element",h);e=f[a]=g}return e(d,c)}catch(k){j(Error("Unable to parse bindings.\nMessage: "+
	k+";\nBindings value: "+a))}}});b.J.instance=new b.J;b.b("bindingProvider",b.J);b.c={};b.z=function(a,d,c){d?(b.a.extend(this,d),this.$parentContext=d,this.$parent=d.$data,this.$parents=(d.$parents||[]).slice(0),this.$parents.unshift(this.$parent)):(this.$parents=[],this.$root=a,this.ko=b);this.$data=a;c&&(this[c]=a)};b.z.prototype.createChildContext=function(a,d){return new b.z(a,this,d)};b.z.prototype.extend=function(a){var d=b.a.extend(new b.z,this);return b.a.extend(d,a)};b.eb=function(a,d){if(2==
	arguments.length)b.a.f.set(a,"__ko_bindingContext__",d);else return b.a.f.get(a,"__ko_bindingContext__")};b.Fa=function(a,d,c){1===a.nodeType&&b.e.Ta(a);return X(a,d,c,m)};b.Ea=function(a,b){(1===b.nodeType||8===b.nodeType)&&Z(a,b,m)};b.Da=function(a,b){b&&(1!==b.nodeType&&8!==b.nodeType)&&j(Error("ko.applyBindings: first parameter should be your view model; second parameter should be a DOM node"));b=b||x.document.body;Y(a,b,m)};b.ja=function(a){switch(a.nodeType){case 1:case 8:var d=b.eb(a);if(d)return d;
	if(a.parentNode)return b.ja(a.parentNode)}return I};b.pb=function(a){return(a=b.ja(a))?a.$data:I};b.b("bindingHandlers",b.c);b.b("applyBindings",b.Da);b.b("applyBindingsToDescendants",b.Ea);b.b("applyBindingsToNode",b.Fa);b.b("contextFor",b.ja);b.b("dataFor",b.pb);var fa={"class":"className","for":"htmlFor"};b.c.attr={update:function(a,d){var c=b.a.d(d())||{},e;for(e in c)if("string"==typeof e){var f=b.a.d(c[e]),g=f===r||f===p||f===I;g&&a.removeAttribute(e);8>=b.a.Z&&e in fa?(e=fa[e],g?a.removeAttribute(e):
	a[e]=f):g||a.setAttribute(e,f.toString());"name"===e&&b.a.ab(a,g?"":f.toString())}}};b.c.checked={init:function(a,d,c){b.a.n(a,"click",function(){var e;if("checkbox"==a.type)e=a.checked;else if("radio"==a.type&&a.checked)e=a.value;else return;var f=d(),g=b.a.d(f);"checkbox"==a.type&&g instanceof Array?(e=b.a.i(g,a.value),a.checked&&0>e?f.push(a.value):!a.checked&&0<=e&&f.splice(e,1)):b.g.ea(f,c,"checked",e,m)});"radio"==a.type&&!a.name&&b.c.uniqueName.init(a,u(m))},update:function(a,d){var c=b.a.d(d());
	"checkbox"==a.type?a.checked=c instanceof Array?0<=b.a.i(c,a.value):c:"radio"==a.type&&(a.checked=a.value==c)}};b.c.css={update:function(a,d){var c=b.a.d(d());if("object"==typeof c)for(var e in c){var f=b.a.d(c[e]);b.a.da(a,e,f)}else c=String(c||""),b.a.da(a,a.__ko__cssValue,r),a.__ko__cssValue=c,b.a.da(a,c,m)}};b.c.enable={update:function(a,d){var c=b.a.d(d());c&&a.disabled?a.removeAttribute("disabled"):!c&&!a.disabled&&(a.disabled=m)}};b.c.disable={update:function(a,d){b.c.enable.update(a,function(){return!b.a.d(d())})}};
	b.c.event={init:function(a,d,c,e){var f=d()||{},g;for(g in f)(function(){var f=g;"string"==typeof f&&b.a.n(a,f,function(a){var g,n=d()[f];if(n){var q=c();try{var s=b.a.L(arguments);s.unshift(e);g=n.apply(e,s)}finally{g!==m&&(a.preventDefault?a.preventDefault():a.returnValue=r)}q[f+"Bubble"]===r&&(a.cancelBubble=m,a.stopPropagation&&a.stopPropagation())}})})()}};b.c.foreach={Sa:function(a){return function(){var d=a(),c=b.a.ua(d);if(!c||"number"==typeof c.length)return{foreach:d,templateEngine:b.C.oa};
	b.a.d(d);return{foreach:c.data,as:c.as,includeDestroyed:c.includeDestroyed,afterAdd:c.afterAdd,beforeRemove:c.beforeRemove,afterRender:c.afterRender,beforeMove:c.beforeMove,afterMove:c.afterMove,templateEngine:b.C.oa}}},init:function(a,d){return b.c.template.init(a,b.c.foreach.Sa(d))},update:function(a,d,c,e,f){return b.c.template.update(a,b.c.foreach.Sa(d),c,e,f)}};b.g.Q.foreach=r;b.e.I.foreach=m;b.c.hasfocus={init:function(a,d,c){function e(e){a.__ko_hasfocusUpdating=m;var f=a.ownerDocument;"activeElement"in
	f&&(e=f.activeElement===a);f=d();b.g.ea(f,c,"hasfocus",e,m);a.__ko_hasfocusUpdating=r}var f=e.bind(p,m),g=e.bind(p,r);b.a.n(a,"focus",f);b.a.n(a,"focusin",f);b.a.n(a,"blur",g);b.a.n(a,"focusout",g)},update:function(a,d){var c=b.a.d(d());a.__ko_hasfocusUpdating||(c?a.focus():a.blur(),b.r.K(b.a.Ba,p,[a,c?"focusin":"focusout"]))}};b.c.html={init:function(){return{controlsDescendantBindings:m}},update:function(a,d){b.a.ca(a,d())}};var da="__ko_withIfBindingData";Q("if");Q("ifnot",r,m);Q("with",m,r,function(a,
	b){return a.createChildContext(b)});b.c.options={update:function(a,d,c){"select"!==b.a.u(a)&&j(Error("options binding applies only to SELECT elements"));for(var e=0==a.length,f=b.a.V(b.a.fa(a.childNodes,function(a){return a.tagName&&"option"===b.a.u(a)&&a.selected}),function(a){return b.k.q(a)||a.innerText||a.textContent}),g=a.scrollTop,h=b.a.d(d());0<a.length;)b.A(a.options[0]),a.remove(0);if(h){c=c();var k=c.optionsIncludeDestroyed;"number"!=typeof h.length&&(h=[h]);if(c.optionsCaption){var l=y.createElement("option");
	b.a.ca(l,c.optionsCaption);b.k.T(l,I);a.appendChild(l)}d=0;for(var n=h.length;d<n;d++){var q=h[d];if(!q||!q._destroy||k){var l=y.createElement("option"),s=function(a,b,c){var d=typeof b;return"function"==d?b(a):"string"==d?a[b]:c},v=s(q,c.optionsValue,q);b.k.T(l,b.a.d(v));q=s(q,c.optionsText,v);b.a.cb(l,q);a.appendChild(l)}}h=a.getElementsByTagName("option");d=k=0;for(n=h.length;d<n;d++)0<=b.a.i(f,b.k.q(h[d]))&&(b.a.bb(h[d],m),k++);a.scrollTop=g;e&&"value"in c&&ea(a,b.a.ua(c.value),m);b.a.ub(a)}}};
	b.c.options.sa="__ko.optionValueDomData__";b.c.selectedOptions={init:function(a,d,c){b.a.n(a,"change",function(){var e=d(),f=[];b.a.o(a.getElementsByTagName("option"),function(a){a.selected&&f.push(b.k.q(a))});b.g.ea(e,c,"value",f)})},update:function(a,d){"select"!=b.a.u(a)&&j(Error("values binding applies only to SELECT elements"));var c=b.a.d(d());c&&"number"==typeof c.length&&b.a.o(a.getElementsByTagName("option"),function(a){var d=0<=b.a.i(c,b.k.q(a));b.a.bb(a,d)})}};b.c.style={update:function(a,
	d){var c=b.a.d(d()||{}),e;for(e in c)if("string"==typeof e){var f=b.a.d(c[e]);a.style[e]=f||""}}};b.c.submit={init:function(a,d,c,e){"function"!=typeof d()&&j(Error("The value for a submit binding must be a function"));b.a.n(a,"submit",function(b){var c,h=d();try{c=h.call(e,a)}finally{c!==m&&(b.preventDefault?b.preventDefault():b.returnValue=r)}})}};b.c.text={update:function(a,d){b.a.cb(a,d())}};b.e.I.text=m;b.c.uniqueName={init:function(a,d){if(d()){var c="ko_unique_"+ ++b.c.uniqueName.ob;b.a.ab(a,
	c)}}};b.c.uniqueName.ob=0;b.c.value={init:function(a,d,c){function e(){h=r;var e=d(),f=b.k.q(a);b.g.ea(e,c,"value",f)}var f=["change"],g=c().valueUpdate,h=r;g&&("string"==typeof g&&(g=[g]),b.a.P(f,g),f=b.a.Ga(f));if(b.a.Z&&("input"==a.tagName.toLowerCase()&&"text"==a.type&&"off"!=a.autocomplete&&(!a.form||"off"!=a.form.autocomplete))&&-1==b.a.i(f,"propertychange"))b.a.n(a,"propertychange",function(){h=m}),b.a.n(a,"blur",function(){h&&e()});b.a.o(f,function(c){var d=e;b.a.Ob(c,"after")&&(d=function(){setTimeout(e,
	0)},c=c.substring(5));b.a.n(a,c,d)})},update:function(a,d){var c="select"===b.a.u(a),e=b.a.d(d()),f=b.k.q(a),g=e!=f;0===e&&(0!==f&&"0"!==f)&&(g=m);g&&(f=function(){b.k.T(a,e)},f(),c&&setTimeout(f,0));c&&0<a.length&&ea(a,e,r)}};b.c.visible={update:function(a,d){var c=b.a.d(d()),e="none"!=a.style.display;c&&!e?a.style.display="":!c&&e&&(a.style.display="none")}};b.c.click={init:function(a,d,c,e){return b.c.event.init.call(this,a,function(){var a={};a.click=d();return a},c,e)}};b.v=function(){};b.v.prototype.renderTemplateSource=
	function(){j(Error("Override renderTemplateSource"))};b.v.prototype.createJavaScriptEvaluatorBlock=function(){j(Error("Override createJavaScriptEvaluatorBlock"))};b.v.prototype.makeTemplateSource=function(a,d){if("string"==typeof a){d=d||y;var c=d.getElementById(a);c||j(Error("Cannot find template with ID "+a));return new b.l.h(c)}if(1==a.nodeType||8==a.nodeType)return new b.l.O(a);j(Error("Unknown template type: "+a))};b.v.prototype.renderTemplate=function(a,b,c,e){a=this.makeTemplateSource(a,e);
	return this.renderTemplateSource(a,b,c)};b.v.prototype.isTemplateRewritten=function(a,b){return this.allowTemplateRewriting===r?m:this.makeTemplateSource(a,b).data("isRewritten")};b.v.prototype.rewriteTemplate=function(a,b,c){a=this.makeTemplateSource(a,c);b=b(a.text());a.text(b);a.data("isRewritten",m)};b.b("templateEngine",b.v);var qa=/(<[a-z]+\d*(\s+(?!data-bind=)[a-z0-9\-]+(=(\"[^\"]*\"|\'[^\']*\'))?)*\s+)data-bind=(["'])([\s\S]*?)\5/gi,ra=/\x3c!--\s*ko\b\s*([\s\S]*?)\s*--\x3e/g;b.za={vb:function(a,
	d,c){d.isTemplateRewritten(a,c)||d.rewriteTemplate(a,function(a){return b.za.Gb(a,d)},c)},Gb:function(a,b){return a.replace(qa,function(a,e,f,g,h,k,l){return W(l,e,b)}).replace(ra,function(a,e){return W(e,"\x3c!-- ko --\x3e",b)})},kb:function(a){return b.s.ra(function(d,c){d.nextSibling&&b.Fa(d.nextSibling,a,c)})}};b.b("__tr_ambtns",b.za.kb);b.l={};b.l.h=function(a){this.h=a};b.l.h.prototype.text=function(){var a=b.a.u(this.h),a="script"===a?"text":"textarea"===a?"value":"innerHTML";if(0==arguments.length)return this.h[a];
	var d=arguments[0];"innerHTML"===a?b.a.ca(this.h,d):this.h[a]=d};b.l.h.prototype.data=function(a){if(1===arguments.length)return b.a.f.get(this.h,"templateSourceData_"+a);b.a.f.set(this.h,"templateSourceData_"+a,arguments[1])};b.l.O=function(a){this.h=a};b.l.O.prototype=new b.l.h;b.l.O.prototype.text=function(){if(0==arguments.length){var a=b.a.f.get(this.h,"__ko_anon_template__")||{};a.Aa===I&&a.ia&&(a.Aa=a.ia.innerHTML);return a.Aa}b.a.f.set(this.h,"__ko_anon_template__",{Aa:arguments[0]})};b.l.h.prototype.nodes=
	function(){if(0==arguments.length)return(b.a.f.get(this.h,"__ko_anon_template__")||{}).ia;b.a.f.set(this.h,"__ko_anon_template__",{ia:arguments[0]})};b.b("templateSources",b.l);b.b("templateSources.domElement",b.l.h);b.b("templateSources.anonymousTemplate",b.l.O);var O;b.wa=function(a){a!=I&&!(a instanceof b.v)&&j(Error("templateEngine must inherit from ko.templateEngine"));O=a};b.va=function(a,d,c,e,f){c=c||{};(c.templateEngine||O)==I&&j(Error("Set a template engine before calling renderTemplate"));
	f=f||"replaceChildren";if(e){var g=N(e);return b.j(function(){var h=d&&d instanceof b.z?d:new b.z(b.a.d(d)),k="function"==typeof a?a(h.$data,h):a,h=T(e,f,k,h,c);"replaceNode"==f&&(e=h,g=N(e))},p,{Ka:function(){return!g||!b.a.X(g)},W:g&&"replaceNode"==f?g.parentNode:g})}return b.s.ra(function(e){b.va(a,d,c,e,"replaceNode")})};b.Mb=function(a,d,c,e,f){function g(a,b){U(b,k);c.afterRender&&c.afterRender(b,a)}function h(d,e){k=f.createChildContext(b.a.d(d),c.as);k.$index=e;var g="function"==typeof a?
	a(d,k):a;return T(p,"ignoreTargetNode",g,k,c)}var k;return b.j(function(){var a=b.a.d(d)||[];"undefined"==typeof a.length&&(a=[a]);a=b.a.fa(a,function(a){return c.includeDestroyed||a===I||a===p||!b.a.d(a._destroy)});b.r.K(b.a.$a,p,[e,a,h,c,g])},p,{W:e})};b.c.template={init:function(a,d){var c=b.a.d(d());if("string"!=typeof c&&!c.name&&(1==a.nodeType||8==a.nodeType))c=1==a.nodeType?a.childNodes:b.e.childNodes(a),c=b.a.Hb(c),(new b.l.O(a)).nodes(c);return{controlsDescendantBindings:m}},update:function(a,
	d,c,e,f){d=b.a.d(d());c={};e=m;var g,h=p;"string"!=typeof d&&(c=d,d=c.name,"if"in c&&(e=b.a.d(c["if"])),e&&"ifnot"in c&&(e=!b.a.d(c.ifnot)),g=b.a.d(c.data));"foreach"in c?h=b.Mb(d||a,e&&c.foreach||[],c,a,f):e?(f="data"in c?f.createChildContext(g,c.as):f,h=b.va(d||a,f,c,a)):b.e.Y(a);f=h;(g=b.a.f.get(a,"__ko__templateComputedDomDataKey__"))&&"function"==typeof g.B&&g.B();b.a.f.set(a,"__ko__templateComputedDomDataKey__",f&&f.pa()?f:I)}};b.g.Q.template=function(a){a=b.g.aa(a);return 1==a.length&&a[0].unknown||
	b.g.Eb(a,"name")?p:"This template engine does not support anonymous templates nested within its templates"};b.e.I.template=m;b.b("setTemplateEngine",b.wa);b.b("renderTemplate",b.va);b.a.Ja=function(a,b,c){a=a||[];b=b||[];return a.length<=b.length?S(a,b,"added","deleted",c):S(b,a,"deleted","added",c)};b.b("utils.compareArrays",b.a.Ja);b.a.$a=function(a,d,c,e,f){function g(a,b){t=l[b];w!==b&&(z[a]=t);t.na(w++);M(t.M);s.push(t);A.push(t)}function h(a,c){if(a)for(var d=0,e=c.length;d<e;d++)c[d]&&b.a.o(c[d].M,
	function(b){a(b,d,c[d].U)})}d=d||[];e=e||{};var k=b.a.f.get(a,"setDomNodeChildrenFromArrayMapping_lastMappingResult")===I,l=b.a.f.get(a,"setDomNodeChildrenFromArrayMapping_lastMappingResult")||[],n=b.a.V(l,function(a){return a.U}),q=b.a.Ja(n,d),s=[],v=0,w=0,B=[],A=[];d=[];for(var z=[],n=[],t,D=0,C,E;C=q[D];D++)switch(E=C.moved,C.status){case "deleted":E===I&&(t=l[v],t.j&&t.j.B(),B.push.apply(B,M(t.M)),e.beforeRemove&&(d[D]=t,A.push(t)));v++;break;case "retained":g(D,v++);break;case "added":E!==I?
	g(D,E):(t={U:C.value,na:b.m(w++)},s.push(t),A.push(t),k||(n[D]=t))}h(e.beforeMove,z);b.a.o(B,e.beforeRemove?b.A:b.removeNode);for(var D=0,k=b.e.firstChild(a),H;t=A[D];D++){t.M||b.a.extend(t,ha(a,c,t.U,f,t.na));for(v=0;q=t.M[v];k=q.nextSibling,H=q,v++)q!==k&&b.e.Pa(a,q,H);!t.Ab&&f&&(f(t.U,t.M,t.na),t.Ab=m)}h(e.beforeRemove,d);h(e.afterMove,z);h(e.afterAdd,n);b.a.f.set(a,"setDomNodeChildrenFromArrayMapping_lastMappingResult",s)};b.b("utils.setDomNodeChildrenFromArrayMapping",b.a.$a);b.C=function(){this.allowTemplateRewriting=
	r};b.C.prototype=new b.v;b.C.prototype.renderTemplateSource=function(a){var d=!(9>b.a.Z)&&a.nodes?a.nodes():p;if(d)return b.a.L(d.cloneNode(m).childNodes);a=a.text();return b.a.ta(a)};b.C.oa=new b.C;b.wa(b.C.oa);b.b("nativeTemplateEngine",b.C);b.qa=function(){var a=this.Db=function(){if("undefined"==typeof F||!F.tmpl)return 0;try{if(0<=F.tmpl.tag.tmpl.open.toString().indexOf("__"))return 2}catch(a){}return 1}();this.renderTemplateSource=function(b,c,e){e=e||{};2>a&&j(Error("Your version of jQuery.tmpl is too old. Please upgrade to jQuery.tmpl 1.0.0pre or later."));
	var f=b.data("precompiled");f||(f=b.text()||"",f=F.template(p,"{{ko_with $item.koBindingContext}}"+f+"{{/ko_with}}"),b.data("precompiled",f));b=[c.$data];c=F.extend({koBindingContext:c},e.templateOptions);c=F.tmpl(f,b,c);c.appendTo(y.createElement("div"));F.fragments={};return c};this.createJavaScriptEvaluatorBlock=function(a){return"{{ko_code ((function() { return "+a+" })()) }}"};this.addTemplate=function(a,b){y.write("<script type='text/html' id='"+a+"'>"+b+"\x3c/script>")};0<a&&(F.tmpl.tag.ko_code=
	{open:"__.push($1 || '');"},F.tmpl.tag.ko_with={open:"with($1) {",close:"} "})};b.qa.prototype=new b.v;w=new b.qa;0<w.Db&&b.wa(w);b.b("jqueryTmplTemplateEngine",b.qa)}"function"===typeof require&&"object"===typeof exports&&"object"===typeof module?L(module.exports||exports):"function"===typeof define&&define.amd?define(["exports"],L):L(x.ko={});m;
	})();
	</script>
<?php endif; ?>
	
<script type="text/javascript">
/* json2.js 
 * See www.JSON.org/js.html*/
if(!this.JSON){JSON=function(){function f(n){return n<10?'0'+n:n;}
Date.prototype.toJSON=function(){return this.getUTCFullYear()+'-'+
f(this.getUTCMonth()+1)+'-'+
f(this.getUTCDate())+'T'+
f(this.getUTCHours())+':'+
f(this.getUTCMinutes())+':'+
f(this.getUTCSeconds())+'Z';};var m={'\b':'\\b','\t':'\\t','\n':'\\n','\f':'\\f','\r':'\\r','"':'\\"','\\':'\\\\'};function stringify(value,whitelist){var a,i,k,l,r=/["\\\x00-\x1f\x7f-\x9f]/g,v;switch(typeof value){case'string':return r.test(value)?'"'+value.replace(r,function(a){var c=m[a];if(c){return c;}
c=a.charCodeAt();return'\\u00'+Math.floor(c/16).toString(16)+
(c%16).toString(16);})+'"':'"'+value+'"';case'number':return isFinite(value)?String(value):'null';case'boolean':case'null':return String(value);case'object':if(!value){return'null';}
if(typeof value.toJSON==='function'){return stringify(value.toJSON());}
a=[];if(typeof value.length==='number'&&!(value.propertyIsEnumerable('length'))){l=value.length;for(i=0;i<l;i+=1){a.push(stringify(value[i],whitelist)||'null');}
return'['+a.join(',')+']';}
if(whitelist){l=whitelist.length;for(i=0;i<l;i+=1){k=whitelist[i];if(typeof k==='string'){v=stringify(value[k],whitelist);if(v){a.push(stringify(k)+':'+v);}}}}else{for(k in value){if(typeof k==='string'){v=stringify(value[k],whitelist);if(v){a.push(stringify(k)+':'+v);}}}}
return'{'+a.join(',')+'}';}}
return{stringify:stringify,parse:function(text,filter){var j;function walk(k,v){var i,n;if(v&&typeof v==='object'){for(i in v){if(Object.prototype.hasOwnProperty.apply(v,[i])){n=walk(i,v[i]);if(n!==undefined){v[i]=n;}}}}
return filter(k,v);}
if(/^[\],:{}\s]*$/.test(text.replace(/\\./g,'@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,']').replace(/(?:^|:|,)(?:\s*\[)+/g,''))){j=eval('('+text+')');return typeof filter==='function'?walk('',j):j;}
throw new SyntaxError('parseJSON');}};}();}
</script>

<script type="text/javascript">
/**
 * password_strength_plugin.js
 * Copyright (c) 20010 myPocket technologies (www.mypocket-technologies.com)
 * @author Darren Mason (djmason9@gmail.com)
 * @date 3/13/2009
 * @projectDescription Password Strength Meter is a jQuery plug-in provide you smart algorithm to detect a password strength. 
 * Based on Firas Kassem orginal plugin - phiras.wordpress.com/2007/04/08/password-strength-meter-a-jquery-plugin/
 * @version 1.0.1	*/
(function(a){a.fn.shortPass="Too short";a.fn.badPass="Weak";a.fn.goodPass="Good";a.fn.strongPass="Strong";a.fn.samePassword="Username and Password identical.";a.fn.resultStyle="";a.fn.passStrength=function(b){var d={shortPass:"shortPass",badPass:"badPass",goodPass:"goodPass",strongPass:"strongPass",baseStyle:"testresult",userid:"",messageloc:1};
var c=a.extend(d,b);return this.each(function(){var e=a(this);a(e).unbind().keyup(function(){var f=a.fn.teststrength(a(this).val(),a(c.userid).val(),c);if(c.messageloc===1){a(this).next("."+c.baseStyle).remove();a(this).after('<span class="'+c.baseStyle+'"><span></span></span>');a(this).next("."+c.baseStyle).addClass(a(this).resultStyle).find("span").text(f)
}else{a(this).prev("."+c.baseStyle).remove();a(this).before('<span class="'+c.baseStyle+'"><span></span></span>');a(this).prev("."+c.baseStyle).addClass(a(this).resultStyle).find("span").text(f)}});a.fn.teststrength=function(f,i,g){var h=0;if(f.length<4){this.resultStyle=g.shortPass;return a(this).shortPass
}if(f.toLowerCase()==i.toLowerCase()){this.resultStyle=g.badPass;return a(this).samePassword}h+=f.length*4;h+=(a.fn.checkRepetition(1,f).length-f.length)*1;h+=(a.fn.checkRepetition(2,f).length-f.length)*1;h+=(a.fn.checkRepetition(3,f).length-f.length)*1;h+=(a.fn.checkRepetition(4,f).length-f.length)*1;
if(f.match(/(.*[0-9].*[0-9].*[0-9])/)){h+=5}if(f.match(/(.*[!,@,#,$,%,^,&,*,?,_,~].*[!,@,#,$,%,^,&,*,?,_,~])/)){h+=5}if(f.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)){h+=10}if(f.match(/([a-zA-Z])/)&&f.match(/([0-9])/)){h+=15}if(f.match(/([!,@,#,$,%,^,&,*,?,_,~])/)&&f.match(/([0-9])/)){h+=15}if(f.match(/([!,@,#,$,%,^,&,*,?,_,~])/)&&f.match(/([a-zA-Z])/)){h+=15
}if(f.match(/^\w+$/)||f.match(/^\d+$/)){h-=10}if(h<0){h=0}if(h>100){h=100}if(h<34){this.resultStyle=g.badPass;return a(this).badPass}if(h<68){this.resultStyle=g.goodPass;return a(this).goodPass}this.resultStyle=g.strongPass;return a(this).strongPass}})}})(jQuery);$.fn.checkRepetition=function(a,f){var d="";
for(var c=0;c<f.length;c++){var e=true;for(var b=0;b<a&&(b+c+a)<f.length;b++){e=e&&(f.charAt(b+c)==f.charAt(b+c+a))}if(b<a){e=false}if(e){c+=a-1;e=false}else{d+=f.charAt(c)}}return d};
</script>


<script type="text/javascript">
/*!
* Parsley.js
* Version 2.3.5 - built Sun, Feb 28th 2016, 6:25 am
* http://parsleyjs.org
* Guillaume Potier - <guillaume@wisembly.com>
* Marc-Andre Lafortune - <petroselinum@marc-andre.ca>
* MIT Licensed
*/
function _toConsumableArray(e){if(Array.isArray(e)){for(var t=0,i=Array(e.length);t<e.length;t++)i[t]=e[t];return i}return Array.from(e)}var _slice=Array.prototype.slice;!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],t):e.parsley=t(e.jQuery)}(this,function(e){"use strict";function t(e,t){return e.parsleyAdaptedCallback||(e.parsleyAdaptedCallback=function(){var i=Array.prototype.slice.call(arguments,0);i.unshift(this),e.apply(t||A,i)}),e.parsleyAdaptedCallback}function i(e){return 0===e.lastIndexOf(D,0)?e.substr(D.length):e}var n=1,r={},s={attr:function(e,t,i){var n,r,s,a=new RegExp("^"+t,"i");if("undefined"==typeof i)i={};else for(n in i)i.hasOwnProperty(n)&&delete i[n];if("undefined"==typeof e||"undefined"==typeof e[0])return i;for(s=e[0].attributes,n=s.length;n--;)r=s[n],r&&r.specified&&a.test(r.name)&&(i[this.camelize(r.name.slice(t.length))]=this.deserializeValue(r.value));return i},checkAttr:function(e,t,i){return e.is("["+t+i+"]")},setAttr:function(e,t,i,n){e[0].setAttribute(this.dasherize(t+i),String(n))},generateID:function(){return""+n++},deserializeValue:function(t){var i;try{return t?"true"==t||("false"==t?!1:"null"==t?null:isNaN(i=Number(t))?/^[\[\{]/.test(t)?e.parseJSON(t):t:i):t}catch(n){return t}},camelize:function(e){return e.replace(/-+(.)?/g,function(e,t){return t?t.toUpperCase():""})},dasherize:function(e){return e.replace(/::/g,"/").replace(/([A-Z]+)([A-Z][a-z])/g,"$1_$2").replace(/([a-z\d])([A-Z])/g,"$1_$2").replace(/_/g,"-").toLowerCase()},warn:function(){var e;window.console&&"function"==typeof window.console.warn&&(e=window.console).warn.apply(e,arguments)},warnOnce:function(e){r[e]||(r[e]=!0,this.warn.apply(this,arguments))},_resetWarnings:function(){r={}},trimString:function(e){return e.replace(/^\s+|\s+$/g,"")},namespaceEvents:function(t,i){return t=this.trimString(t||"").split(/\s+/),t[0]?e.map(t,function(e){return e+"."+i}).join(" "):""},objectCreate:Object.create||function(){var e=function(){};return function(t){if(arguments.length>1)throw Error("Second argument not supported");if("object"!=typeof t)throw TypeError("Argument must be an object");e.prototype=t;var i=new e;return e.prototype=null,i}}()},a=s,o={namespace:"data-parsley-",inputs:"input, textarea, select",excluded:"input[type=button], input[type=submit], input[type=reset], input[type=hidden]",priorityEnabled:!0,multiple:null,group:null,uiEnabled:!0,validationThreshold:3,focus:"first",trigger:!1,triggerAfterFailure:"input",errorClass:"parsley-error",successClass:"parsley-success",classHandler:function(e){},errorsContainer:function(e){},errorsWrapper:'<ul class="parsley-errors-list"></ul>',errorTemplate:"<li></li>"},l=function(){};l.prototype={asyncSupport:!0,actualizeOptions:function(){return a.attr(this.$element,this.options.namespace,this.domOptions),this.parent&&this.parent.actualizeOptions&&this.parent.actualizeOptions(),this},_resetOptions:function(e){this.domOptions=a.objectCreate(this.parent.options),this.options=a.objectCreate(this.domOptions);for(var t in e)e.hasOwnProperty(t)&&(this.options[t]=e[t]);this.actualizeOptions()},_listeners:null,on:function(e,t){this._listeners=this._listeners||{};var i=this._listeners[e]=this._listeners[e]||[];return i.push(t),this},subscribe:function(t,i){e.listenTo(this,t.toLowerCase(),i)},off:function(e,t){var i=this._listeners&&this._listeners[e];if(i)if(t)for(var n=i.length;n--;)i[n]===t&&i.splice(n,1);else delete this._listeners[e];return this},unsubscribe:function(t,i){e.unsubscribeTo(this,t.toLowerCase())},trigger:function(e,t,i){t=t||this;var n,r=this._listeners&&this._listeners[e];if(r)for(var s=r.length;s--;)if(n=r[s].call(t,t,i),n===!1)return n;return this.parent?this.parent.trigger(e,t,i):!0},reset:function(){if("ParsleyForm"!==this.__class__)return this._resetUI(),this._trigger("reset");for(var e=0;e<this.fields.length;e++)this.fields[e].reset();this._trigger("reset")},destroy:function(){if(this._destroyUI(),"ParsleyForm"!==this.__class__)return this.$element.removeData("Parsley"),this.$element.removeData("ParsleyFieldMultiple"),void this._trigger("destroy");for(var e=0;e<this.fields.length;e++)this.fields[e].destroy();this.$element.removeData("Parsley"),this._trigger("destroy")},asyncIsValid:function(e,t){return a.warnOnce("asyncIsValid is deprecated; please use whenValid instead"),this.whenValid({group:e,force:t})},_findRelated:function(){return this.options.multiple?this.parent.$element.find("["+this.options.namespace+'multiple="'+this.options.multiple+'"]'):this.$element}};var u={string:function(e){return e},integer:function(e){if(isNaN(e))throw'Requirement is not an integer: "'+e+'"';return parseInt(e,10)},number:function(e){if(isNaN(e))throw'Requirement is not a number: "'+e+'"';return parseFloat(e)},reference:function(t){var i=e(t);if(0===i.length)throw'No such reference: "'+t+'"';return i},"boolean":function(e){return"false"!==e},object:function(e){return a.deserializeValue(e)},regexp:function(e){var t="";return/^\/.*\/(?:[gimy]*)$/.test(e)?(t=e.replace(/.*\/([gimy]*)$/,"$1"),e=e.replace(new RegExp("^/(.*?)/"+t+"$"),"$1")):e="^"+e+"$",new RegExp(e,t)}},d=function(e,t){var i=e.match(/^\s*\[(.*)\]\s*$/);if(!i)throw'Requirement is not an array: "'+e+'"';var n=i[1].split(",").map(a.trimString);if(n.length!==t)throw"Requirement has "+n.length+" values when "+t+" are needed";return n},h=function(e,t){var i=u[e||"string"];if(!i)throw'Unknown requirement specification: "'+e+'"';return i(t)},p=function(e,t,i){var n=null,r={};for(var s in e)if(s){var a=i(s);"string"==typeof a&&(a=h(e[s],a)),r[s]=a}else n=h(e[s],t);return[n,r]},f=function(t){e.extend(!0,this,t)};f.prototype={validate:function(t,i){if(this.fn)return arguments.length>3&&(i=[].slice.call(arguments,1,-1)),this.fn.call(this,t,i);if(e.isArray(t)){if(!this.validateMultiple)throw"Validator `"+this.name+"` does not handle multiple values";return this.validateMultiple.apply(this,arguments)}if(this.validateNumber)return isNaN(t)?!1:(arguments[0]=parseFloat(arguments[0]),this.validateNumber.apply(this,arguments));if(this.validateString)return this.validateString.apply(this,arguments);throw"Validator `"+this.name+"` only handles multiple values"},parseRequirements:function(t,i){if("string"!=typeof t)return e.isArray(t)?t:[t];var n=this.requirementType;if(e.isArray(n)){for(var r=d(t,n.length),s=0;s<r.length;s++)r[s]=h(n[s],r[s]);return r}return e.isPlainObject(n)?p(n,t,i):[h(n,t)]},requirementType:"string",priority:2};var c=function(e,t){this.__class__="ParsleyValidatorRegistry",this.locale="en",this.init(e||{},t||{})},m={email:/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i,number:/^-?(\d*\.)?\d+(e[-+]?\d+)?$/i,integer:/^-?\d+$/,digits:/^\d+$/,alphanum:/^\w+$/i,url:new RegExp("^(?:(?:https?|ftp)://)?(?:\\S+(?::\\S*)?@)?(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,})))(?::\\d{2,5})?(?:/\\S*)?$","i")};m.range=m.number;var g=function(e){var t=(""+e).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);return t?Math.max(0,(t[1]?t[1].length:0)-(t[2]?+t[2]:0)):0};c.prototype={init:function(t,i){this.catalog=i,this.validators=e.extend({},this.validators);for(var n in t)this.addValidator(n,t[n].fn,t[n].priority);window.Parsley.trigger("parsley:validator:init")},setLocale:function(e){if("undefined"==typeof this.catalog[e])throw new Error(e+" is not available in the catalog");return this.locale=e,this},addCatalog:function(e,t,i){return"object"==typeof t&&(this.catalog[e]=t),!0===i?this.setLocale(e):this},addMessage:function(e,t,i){return"undefined"==typeof this.catalog[e]&&(this.catalog[e]={}),this.catalog[e][t]=i,this},addMessages:function(e,t){for(var i in t)this.addMessage(e,i,t[i]);return this},addValidator:function(e,t,i){if(this.validators[e])a.warn('Validator "'+e+'" is already defined.');else if(o.hasOwnProperty(e))return void a.warn('"'+e+'" is a restricted keyword and is not a valid validator name.');return this._setValidator.apply(this,arguments)},updateValidator:function(e,t,i){return this.validators[e]?this._setValidator(this,arguments):(a.warn('Validator "'+e+'" is not already defined.'),this.addValidator.apply(this,arguments))},removeValidator:function(e){return this.validators[e]||a.warn('Validator "'+e+'" is not defined.'),delete this.validators[e],this},_setValidator:function(e,t,i){"object"!=typeof t&&(t={fn:t,priority:i}),t.validate||(t=new f(t)),this.validators[e]=t;for(var n in t.messages||{})this.addMessage(n,e,t.messages[n]);return this},getErrorMessage:function(e){var t;if("type"===e.name){var i=this.catalog[this.locale][e.name]||{};t=i[e.requirements]}else t=this.formatMessage(this.catalog[this.locale][e.name],e.requirements);return t||this.catalog[this.locale].defaultMessage||this.catalog.en.defaultMessage},formatMessage:function(e,t){if("object"==typeof t){for(var i in t)e=this.formatMessage(e,t[i]);return e}return"string"==typeof e?e.replace(/%s/i,t):""},validators:{notblank:{validateString:function(e){return/\S/.test(e)},priority:2},required:{validateMultiple:function(e){return e.length>0},validateString:function(e){return/\S/.test(e)},priority:512},type:{validateString:function(e,t){var i=arguments.length<=2||void 0===arguments[2]?{}:arguments[2],n=i.step,r=void 0===n?"1":n,s=i.base,a=void 0===s?0:s,o=m[t];if(!o)throw new Error("validator type `"+t+"` is not supported");if(!o.test(e))return!1;if("number"===t&&!/^any$/i.test(r||"")){var l=Number(e),u=Math.max(g(r),g(a));if(g(l)>u)return!1;var d=function(e){return Math.round(e*Math.pow(10,u))};if((d(l)-d(a))%d(r)!=0)return!1}return!0},requirementType:{"":"string",step:"string",base:"number"},priority:256},pattern:{validateString:function(e,t){return t.test(e)},requirementType:"regexp",priority:64},minlength:{validateString:function(e,t){return e.length>=t},requirementType:"integer",priority:30},maxlength:{validateString:function(e,t){return e.length<=t},requirementType:"integer",priority:30},length:{validateString:function(e,t,i){return e.length>=t&&e.length<=i},requirementType:["integer","integer"],priority:30},mincheck:{validateMultiple:function(e,t){return e.length>=t},requirementType:"integer",priority:30},maxcheck:{validateMultiple:function(e,t){return e.length<=t},requirementType:"integer",priority:30},check:{validateMultiple:function(e,t,i){return e.length>=t&&e.length<=i},requirementType:["integer","integer"],priority:30},min:{validateNumber:function(e,t){return e>=t},requirementType:"number",priority:30},max:{validateNumber:function(e,t){return t>=e},requirementType:"number",priority:30},range:{validateNumber:function(e,t,i){return e>=t&&i>=e},requirementType:["number","number"],priority:30},equalto:{validateString:function(t,i){var n=e(i);return n.length?t===n.val():t===i},priority:256}}};var y={},v=function T(e,t,i){for(var n=[],r=[],s=0;s<e.length;s++){for(var a=!1,o=0;o<t.length;o++)if(e[s].assert.name===t[o].assert.name){a=!0;break}a?r.push(e[s]):n.push(e[s])}return{kept:r,added:n,removed:i?[]:T(t,e,!0).added}};y.Form={_actualizeTriggers:function(){var e=this;this.$element.on("submit.Parsley",function(t){e.onSubmitValidate(t)}),this.$element.on("click.Parsley",'input[type="submit"], button[type="submit"]',function(t){e.onSubmitButton(t)}),!1!==this.options.uiEnabled&&this.$element.attr("novalidate","")},focus:function(){if(this._focusedField=null,!0===this.validationResult||"none"===this.options.focus)return null;for(var e=0;e<this.fields.length;e++){var t=this.fields[e];if(!0!==t.validationResult&&t.validationResult.length>0&&"undefined"==typeof t.options.noFocus&&(this._focusedField=t.$element,"first"===this.options.focus))break}return null===this._focusedField?null:this._focusedField.focus()},_destroyUI:function(){this.$element.off(".Parsley")}},y.Field={_reflowUI:function(){if(this._buildUI(),this._ui){var e=v(this.validationResult,this._ui.lastValidationResult);this._ui.lastValidationResult=this.validationResult,this._manageStatusClass(),this._manageErrorsMessages(e),this._actualizeTriggers(),!e.kept.length&&!e.added.length||this._failedOnce||(this._failedOnce=!0,this._actualizeTriggers())}},getErrorsMessages:function(){if(!0===this.validationResult)return[];for(var e=[],t=0;t<this.validationResult.length;t++)e.push(this.validationResult[t].errorMessage||this._getErrorMessage(this.validationResult[t].assert));return e},addError:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],i=t.message,n=t.assert,r=t.updateClass,s=void 0===r?!0:r;this._buildUI(),this._addError(e,{message:i,assert:n}),s&&this._errorClass()},updateError:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],i=t.message,n=t.assert,r=t.updateClass,s=void 0===r?!0:r;this._buildUI(),this._updateError(e,{message:i,assert:n}),s&&this._errorClass()},removeError:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],i=t.updateClass,n=void 0===i?!0:i;this._buildUI(),this._removeError(e),n&&this._manageStatusClass()},_manageStatusClass:function(){this.hasConstraints()&&this.needsValidation()&&!0===this.validationResult?this._successClass():this.validationResult.length>0?this._errorClass():this._resetClass()},_manageErrorsMessages:function(t){if("undefined"==typeof this.options.errorsMessagesDisabled){if("undefined"!=typeof this.options.errorMessage)return t.added.length||t.kept.length?(this._insertErrorWrapper(),0===this._ui.$errorsWrapper.find(".parsley-custom-error-message").length&&this._ui.$errorsWrapper.append(e(this.options.errorTemplate).addClass("parsley-custom-error-message")),this._ui.$errorsWrapper.addClass("filled").find(".parsley-custom-error-message").html(this.options.errorMessage)):this._ui.$errorsWrapper.removeClass("filled").find(".parsley-custom-error-message").remove();for(var i=0;i<t.removed.length;i++)this._removeError(t.removed[i].assert.name);for(i=0;i<t.added.length;i++)this._addError(t.added[i].assert.name,{message:t.added[i].errorMessage,assert:t.added[i].assert});for(i=0;i<t.kept.length;i++)this._updateError(t.kept[i].assert.name,{message:t.kept[i].errorMessage,assert:t.kept[i].assert})}},_addError:function(t,i){var n=i.message,r=i.assert;this._insertErrorWrapper(),this._ui.$errorsWrapper.addClass("filled").append(e(this.options.errorTemplate).addClass("parsley-"+t).html(n||this._getErrorMessage(r)))},_updateError:function(e,t){var i=t.message,n=t.assert;this._ui.$errorsWrapper.addClass("filled").find(".parsley-"+e).html(i||this._getErrorMessage(n))},_removeError:function(e){this._ui.$errorsWrapper.removeClass("filled").find(".parsley-"+e).remove()},_getErrorMessage:function(e){var t=e.name+"Message";return"undefined"!=typeof this.options[t]?window.Parsley.formatMessage(this.options[t],e.requirements):window.Parsley.getErrorMessage(e)},_buildUI:function(){if(!this._ui&&!1!==this.options.uiEnabled){var t={};this.$element.attr(this.options.namespace+"id",this.__id__),t.$errorClassHandler=this._manageClassHandler(),t.errorsWrapperId="parsley-id-"+(this.options.multiple?"multiple-"+this.options.multiple:this.__id__),t.$errorsWrapper=e(this.options.errorsWrapper).attr("id",t.errorsWrapperId),t.lastValidationResult=[],t.validationInformationVisible=!1,this._ui=t}},_manageClassHandler:function(){if("string"==typeof this.options.classHandler&&e(this.options.classHandler).length)return e(this.options.classHandler);var t=this.options.classHandler.call(this,this);return"undefined"!=typeof t&&t.length?t:!this.options.multiple||this.$element.is("select")?this.$element:this.$element.parent()},_insertErrorWrapper:function(){var t;if(0!==this._ui.$errorsWrapper.parent().length)return this._ui.$errorsWrapper.parent();if("string"==typeof this.options.errorsContainer){if(e(this.options.errorsContainer).length)return e(this.options.errorsContainer).append(this._ui.$errorsWrapper);a.warn("The errors container `"+this.options.errorsContainer+"` does not exist in DOM")}else"function"==typeof this.options.errorsContainer&&(t=this.options.errorsContainer.call(this,this));if("undefined"!=typeof t&&t.length)return t.append(this._ui.$errorsWrapper);var i=this.$element;return this.options.multiple&&(i=i.parent()),i.after(this._ui.$errorsWrapper)},_actualizeTriggers:function(){var e=this,t=this._findRelated();t.off(".Parsley"),this._failedOnce?t.on(a.namespaceEvents(this.options.triggerAfterFailure,"Parsley"),function(){e.validate()}):t.on(a.namespaceEvents(this.options.trigger,"Parsley"),function(t){e._eventValidate(t)})},_eventValidate:function(e){(!/key|input/.test(e.type)||this._ui&&this._ui.validationInformationVisible||!(this.getValue().length<=this.options.validationThreshold))&&this.validate()},_resetUI:function(){this._failedOnce=!1,this._actualizeTriggers(),"undefined"!=typeof this._ui&&(this._ui.$errorsWrapper.removeClass("filled").children().remove(),this._resetClass(),this._ui.lastValidationResult=[],this._ui.validationInformationVisible=!1)},_destroyUI:function(){this._resetUI(),"undefined"!=typeof this._ui&&this._ui.$errorsWrapper.remove(),delete this._ui},_successClass:function(){this._ui.validationInformationVisible=!0,this._ui.$errorClassHandler.removeClass(this.options.errorClass).addClass(this.options.successClass)},_errorClass:function(){this._ui.validationInformationVisible=!0,this._ui.$errorClassHandler.removeClass(this.options.successClass).addClass(this.options.errorClass)},_resetClass:function(){this._ui.$errorClassHandler.removeClass(this.options.successClass).removeClass(this.options.errorClass)}};var _=function(t,i,n){this.__class__="ParsleyForm",this.__id__=a.generateID(),this.$element=e(t),this.domOptions=i,this.options=n,this.parent=window.Parsley,this.fields=[],this.validationResult=null},w={pending:null,resolved:!0,rejected:!1};_.prototype={onSubmitValidate:function(e){var t=this;if(!0!==e.parsley){var i=this._$submitSource||this.$element.find('input[type="submit"], button[type="submit"]').first();if(this._$submitSource=null,this.$element.find(".parsley-synthetic-submit-button").prop("disabled",!0),!i.is("[formnovalidate]")){var n=this.whenValidate({event:e});"resolved"===n.state()&&!1!==this._trigger("submit")||(e.stopImmediatePropagation(),e.preventDefault(),"pending"===n.state()&&n.done(function(){t._submit(i)}))}}},onSubmitButton:function(t){this._$submitSource=e(t.target)},_submit:function(t){if(!1!==this._trigger("submit")){if(t){var i=this.$element.find(".parsley-synthetic-submit-button").prop("disabled",!1);0===i.length&&(i=e('<input class="parsley-synthetic-submit-button" type="hidden">').appendTo(this.$element)),i.attr({name:t.attr("name"),value:t.attr("value")})}this.$element.trigger(e.extend(e.Event("submit"),{parsley:!0}))}},validate:function(t){if(arguments.length>=1&&!e.isPlainObject(t)){a.warnOnce("Calling validate on a parsley form without passing arguments as an object is deprecated.");var i=_slice.call(arguments),n=i[0],r=i[1],s=i[2];t={group:n,force:r,event:s}}return w[this.whenValidate(t).state()]},whenValidate:function(){var t=this,i=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],n=i.group,r=i.force,s=i.event;this.submitEvent=s,s&&(this.submitEvent=e.extend({},s,{preventDefault:function(){a.warnOnce("Using `this.submitEvent.preventDefault()` is deprecated; instead, call `this.validationResult = false`"),t.validationResult=!1}})),this.validationResult=!0,this._trigger("validate"),this._refreshFields();var o=this._withoutReactualizingFormOptions(function(){return e.map(t.fields,function(e){return e.whenValidate({force:r,group:n})})}),l=function(){var i=e.Deferred();return!1===t.validationResult&&i.reject(),i.resolve().promise()};return e.when.apply(e,_toConsumableArray(o)).done(function(){t._trigger("success")}).fail(function(){t.validationResult=!1,t.focus(),t._trigger("error")}).always(function(){t._trigger("validated")}).pipe(l,l)},isValid:function(t){if(arguments.length>=1&&!e.isPlainObject(t)){a.warnOnce("Calling isValid on a parsley form without passing arguments as an object is deprecated.");var i=_slice.call(arguments),n=i[0],r=i[1];t={group:n,force:r}}return w[this.whenValid(t).state()]},whenValid:function(){var t=this,i=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],n=i.group,r=i.force;this._refreshFields();var s=this._withoutReactualizingFormOptions(function(){return e.map(t.fields,function(e){return e.whenValid({group:n,force:r})})});return e.when.apply(e,_toConsumableArray(s))},_refreshFields:function(){return this.actualizeOptions()._bindFields()},_bindFields:function(){var t=this,i=this.fields;return this.fields=[],this.fieldsMappedById={},this._withoutReactualizingFormOptions(function(){t.$element.find(t.options.inputs).not(t.options.excluded).each(function(e,i){var n=new window.Parsley.Factory(i,{},t);"ParsleyField"!==n.__class__&&"ParsleyFieldMultiple"!==n.__class__||!0===n.options.excluded||"undefined"==typeof t.fieldsMappedById[n.__class__+"-"+n.__id__]&&(t.fieldsMappedById[n.__class__+"-"+n.__id__]=n,t.fields.push(n))}),e(i).not(t.fields).each(function(e,t){t._trigger("reset")})}),this},_withoutReactualizingFormOptions:function(e){var t=this.actualizeOptions;this.actualizeOptions=function(){return this};var i=e();return this.actualizeOptions=t,i},_trigger:function(e){return this.trigger("form:"+e)}};var b=function(t,i,n,r,s){if(!/ParsleyField/.test(t.__class__))throw new Error("ParsleyField or ParsleyFieldMultiple instance expected");var a=window.Parsley._validatorRegistry.validators[i],o=new f(a);e.extend(this,{validator:o,name:i,requirements:n,priority:r||t.options[i+"Priority"]||o.priority,isDomConstraint:!0===s}),this._parseRequirements(t.options)},F=function(e){var t=e[0].toUpperCase();return t+e.slice(1)};b.prototype={validate:function(e,t){var i=this.requirementList.slice(0);return i.unshift(e),i.push(t),this.validator.validate.apply(this.validator,i)},_parseRequirements:function(e){var t=this;this.requirementList=this.validator.parseRequirements(this.requirements,function(i){return e[t.name+F(i)]})}};var C=function(t,i,n,r){this.__class__="ParsleyField",this.__id__=a.generateID(),this.$element=e(t),"undefined"!=typeof r&&(this.parent=r),this.options=n,this.domOptions=i,this.constraints=[],this.constraintsByName={},this.validationResult=[],this._bindConstraints()},$={pending:null,resolved:!0,rejected:!1};C.prototype={validate:function(t){arguments.length>=1&&!e.isPlainObject(t)&&(a.warnOnce("Calling validate on a parsley field without passing arguments as an object is deprecated."),t={options:t});var i=this.whenValidate(t);if(!i)return!0;switch(i.state()){case"pending":return null;case"resolved":return!0;case"rejected":return this.validationResult}},whenValidate:function(){var e=this,t=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],i=t.force,n=t.group;return this.refreshConstraints(),!n||this._isInGroup(n)?(this.value=this.getValue(),this._trigger("validate"),this.whenValid({force:i,value:this.value,_refreshed:!0}).always(function(){e._reflowUI()}).done(function(){e._trigger("success")}).fail(function(){e._trigger("error")}).always(function(){e._trigger("validated")})):void 0},hasConstraints:function(){return 0!==this.constraints.length},needsValidation:function(e){return"undefined"==typeof e&&(e=this.getValue()),e.length||this._isRequired()||"undefined"!=typeof this.options.validateIfEmpty?!0:!1},_isInGroup:function(t){return e.isArray(this.options.group)?-1!==e.inArray(t,this.options.group):this.options.group===t},isValid:function(t){if(arguments.length>=1&&!e.isPlainObject(t)){a.warnOnce("Calling isValid on a parsley field without passing arguments as an object is deprecated.");var i=_slice.call(arguments),n=i[0],r=i[1];t={force:n,value:r}}var s=this.whenValid(t);return s?$[s.state()]:!0},whenValid:function(){var t=this,i=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],n=i.force,r=void 0===n?!1:n,s=i.value,a=i.group,o=i._refreshed;if(o||this.refreshConstraints(),!a||this._isInGroup(a)){if(this.validationResult=!0,!this.hasConstraints())return e.when();if(("undefined"==typeof s||null===s)&&(s=this.getValue()),!this.needsValidation(s)&&!0!==r)return e.when();var l=this._getGroupedConstraints(),u=[];return e.each(l,function(i,n){var r=e.when.apply(e,_toConsumableArray(e.map(n,function(e){return t._validateConstraint(s,e)})));return u.push(r),"rejected"===r.state()?!1:void 0}),e.when.apply(e,u)}},_validateConstraint:function(t,i){var n=this,r=i.validate(t,this);return!1===r&&(r=e.Deferred().reject()),e.when(r).fail(function(e){!0===n.validationResult&&(n.validationResult=[]),n.validationResult.push({assert:i,errorMessage:"string"==typeof e&&e})})},getValue:function(){var e;return e="function"==typeof this.options.value?this.options.value(this):"undefined"!=typeof this.options.value?this.options.value:this.$element.val(),"undefined"==typeof e||null===e?"":this._handleWhitespace(e)},refreshConstraints:function(){return this.actualizeOptions()._bindConstraints()},addConstraint:function(e,t,i,n){if(window.Parsley._validatorRegistry.validators[e]){var r=new b(this,e,t,i,n);"undefined"!==this.constraintsByName[r.name]&&this.removeConstraint(r.name),this.constraints.push(r),this.constraintsByName[r.name]=r}return this},removeConstraint:function(e){for(var t=0;t<this.constraints.length;t++)if(e===this.constraints[t].name){this.constraints.splice(t,1);break}return delete this.constraintsByName[e],this},updateConstraint:function(e,t,i){return this.removeConstraint(e).addConstraint(e,t,i)},_bindConstraints:function(){for(var e=[],t={},i=0;i<this.constraints.length;i++)!1===this.constraints[i].isDomConstraint&&(e.push(this.constraints[i]),t[this.constraints[i].name]=this.constraints[i]);this.constraints=e,this.constraintsByName=t;for(var n in this.options)this.addConstraint(n,this.options[n],void 0,!0);return this._bindHtml5Constraints()},_bindHtml5Constraints:function(){(this.$element.hasClass("required")||this.$element.attr("required"))&&this.addConstraint("required",!0,void 0,!0),"string"==typeof this.$element.attr("pattern")&&this.addConstraint("pattern",this.$element.attr("pattern"),void 0,!0),"undefined"!=typeof this.$element.attr("min")&&"undefined"!=typeof this.$element.attr("max")?this.addConstraint("range",[this.$element.attr("min"),this.$element.attr("max")],void 0,!0):"undefined"!=typeof this.$element.attr("min")?this.addConstraint("min",this.$element.attr("min"),void 0,!0):"undefined"!=typeof this.$element.attr("max")&&this.addConstraint("max",this.$element.attr("max"),void 0,!0),"undefined"!=typeof this.$element.attr("minlength")&&"undefined"!=typeof this.$element.attr("maxlength")?this.addConstraint("length",[this.$element.attr("minlength"),this.$element.attr("maxlength")],void 0,!0):"undefined"!=typeof this.$element.attr("minlength")?this.addConstraint("minlength",this.$element.attr("minlength"),void 0,!0):"undefined"!=typeof this.$element.attr("maxlength")&&this.addConstraint("maxlength",this.$element.attr("maxlength"),void 0,!0);var e=this.$element.attr("type");return"undefined"==typeof e?this:"number"===e?this.addConstraint("type",["number",{step:this.$element.attr("step"),base:this.$element.attr("min")||this.$element.attr("value")}],void 0,!0):/^(email|url|range)$/i.test(e)?this.addConstraint("type",e,void 0,!0):this},_isRequired:function(){return"undefined"==typeof this.constraintsByName.required?!1:!1!==this.constraintsByName.required.requirements},_trigger:function(e){return this.trigger("field:"+e)},_handleWhitespace:function(e){return!0===this.options.trimValue&&a.warnOnce('data-parsley-trim-value="true" is deprecated, please use data-parsley-whitespace="trim"'),"squish"===this.options.whitespace&&(e=e.replace(/\s{2,}/g," ")),("trim"===this.options.whitespace||"squish"===this.options.whitespace||!0===this.options.trimValue)&&(e=a.trimString(e)),e},_getGroupedConstraints:function(){if(!1===this.options.priorityEnabled)return[this.constraints];for(var e=[],t={},i=0;i<this.constraints.length;i++){var n=this.constraints[i].priority;t[n]||e.push(t[n]=[]),t[n].push(this.constraints[i])}return e.sort(function(e,t){return t[0].priority-e[0].priority}),e}};var x=C,P=function(){this.__class__="ParsleyFieldMultiple"};P.prototype={addElement:function(e){return this.$elements.push(e),this},refreshConstraints:function(){var t;if(this.constraints=[],this.$element.is("select"))return this.actualizeOptions()._bindConstraints(),this;for(var i=0;i<this.$elements.length;i++)if(e("html").has(this.$elements[i]).length){t=this.$elements[i].data("ParsleyFieldMultiple").refreshConstraints().constraints;for(var n=0;n<t.length;n++)this.addConstraint(t[n].name,t[n].requirements,t[n].priority,t[n].isDomConstraint)}else this.$elements.splice(i,1);return this},getValue:function(){if("function"==typeof this.options.value)value=this.options.value(this);else if("undefined"!=typeof this.options.value)return this.options.value;if(this.$element.is("input[type=radio]"))return this._findRelated().filter(":checked").val()||"";if(this.$element.is("input[type=checkbox]")){var t=[];return this._findRelated().filter(":checked").each(function(){t.push(e(this).val())}),t}return this.$element.is("select")&&null===this.$element.val()?[]:this.$element.val()},_init:function(){return this.$elements=[this.$element],this}};var E=function(t,i,n){this.$element=e(t);var r=this.$element.data("Parsley");if(r)return"undefined"!=typeof n&&r.parent===window.Parsley&&(r.parent=n,r._resetOptions(r.options)),r;if(!this.$element.length)throw new Error("You must bind Parsley on an existing element.");if("undefined"!=typeof n&&"ParsleyForm"!==n.__class__)throw new Error("Parent instance must be a ParsleyForm instance");return this.parent=n||window.Parsley,this.init(i)};E.prototype={init:function(e){return this.__class__="Parsley",this.__version__="2.3.5",this.__id__=a.generateID(),this._resetOptions(e),this.$element.is("form")||a.checkAttr(this.$element,this.options.namespace,"validate")&&!this.$element.is(this.options.inputs)?this.bind("parsleyForm"):this.isMultiple()?this.handleMultiple():this.bind("parsleyField")},isMultiple:function(){return this.$element.is("input[type=radio], input[type=checkbox]")||this.$element.is("select")&&"undefined"!=typeof this.$element.attr("multiple")},handleMultiple:function(){var t,i,n=this;if(this.options.multiple||("undefined"!=typeof this.$element.attr("name")&&this.$element.attr("name").length?this.options.multiple=t=this.$element.attr("name"):"undefined"!=typeof this.$element.attr("id")&&this.$element.attr("id").length&&(this.options.multiple=this.$element.attr("id"))),this.$element.is("select")&&"undefined"!=typeof this.$element.attr("multiple"))return this.options.multiple=this.options.multiple||this.__id__,this.bind("parsleyFieldMultiple");if(!this.options.multiple)return a.warn("To be bound by Parsley, a radio, a checkbox and a multiple select input must have either a name or a multiple option.",this.$element),this;this.options.multiple=this.options.multiple.replace(/(:|\.|\[|\]|\{|\}|\$)/g,""),
"undefined"!=typeof t&&e('input[name="'+t+'"]').each(function(t,i){e(i).is("input[type=radio], input[type=checkbox]")&&e(i).attr(n.options.namespace+"multiple",n.options.multiple)});for(var r=this._findRelated(),s=0;s<r.length;s++)if(i=e(r.get(s)).data("Parsley"),"undefined"!=typeof i){this.$element.data("ParsleyFieldMultiple")||i.addElement(this.$element);break}return this.bind("parsleyField",!0),i||this.bind("parsleyFieldMultiple")},bind:function(t,i){var n;switch(t){case"parsleyForm":n=e.extend(new _(this.$element,this.domOptions,this.options),window.ParsleyExtend)._bindFields();break;case"parsleyField":n=e.extend(new x(this.$element,this.domOptions,this.options,this.parent),window.ParsleyExtend);break;case"parsleyFieldMultiple":n=e.extend(new x(this.$element,this.domOptions,this.options,this.parent),new P,window.ParsleyExtend)._init();break;default:throw new Error(t+"is not a supported Parsley type")}return this.options.multiple&&a.setAttr(this.$element,this.options.namespace,"multiple",this.options.multiple),"undefined"!=typeof i?(this.$element.data("ParsleyFieldMultiple",n),n):(this.$element.data("Parsley",n),n._actualizeTriggers(),n._trigger("init"),n)}};var V=e.fn.jquery.split(".");if(parseInt(V[0])<=1&&parseInt(V[1])<8)throw"The loaded version of jQuery is too old. Please upgrade to 1.8.x or better.";V.forEach||a.warn("Parsley requires ES5 to run properly. Please include https://github.com/es-shims/es5-shim");var M=e.extend(new l,{$element:e(document),actualizeOptions:null,_resetOptions:null,Factory:E,version:"2.3.5"});e.extend(x.prototype,y.Field,l.prototype),e.extend(_.prototype,y.Form,l.prototype),e.extend(E.prototype,l.prototype),e.fn.parsley=e.fn.psly=function(t){if(this.length>1){var i=[];return this.each(function(){i.push(e(this).parsley(t))}),i}return e(this).length?new E(this,t):void a.warn("You must bind Parsley on an existing element.")},"undefined"==typeof window.ParsleyExtend&&(window.ParsleyExtend={}),M.options=e.extend(a.objectCreate(o),window.ParsleyConfig),window.ParsleyConfig=M.options,window.Parsley=window.psly=M,window.ParsleyUtils=a;var O=window.Parsley._validatorRegistry=new c(window.ParsleyConfig.validators,window.ParsleyConfig.i18n);window.ParsleyValidator={},e.each("setLocale addCatalog addMessage addMessages getErrorMessage formatMessage addValidator updateValidator removeValidator".split(" "),function(t,i){window.Parsley[i]=e.proxy(O,i),window.ParsleyValidator[i]=function(){var e;return a.warnOnce("Accessing the method '"+i+"' through ParsleyValidator is deprecated. Simply call 'window.Parsley."+i+"(...)'"),(e=window.Parsley)[i].apply(e,arguments)}}),window.Parsley.UI=y,window.ParsleyUI={removeError:function(e,t,i){var n=!0!==i;return a.warnOnce("Accessing ParsleyUI is deprecated. Call 'removeError' on the instance directly. Please comment in issue 1073 as to your need to call this method."),e.removeError(t,{updateClass:n})},getErrorsMessages:function(e){return a.warnOnce("Accessing ParsleyUI is deprecated. Call 'getErrorsMessages' on the instance directly."),e.getErrorsMessages()}},e.each("addError updateError".split(" "),function(e,t){window.ParsleyUI[t]=function(e,i,n,r,s){var o=!0!==s;return a.warnOnce("Accessing ParsleyUI is deprecated. Call '"+t+"' on the instance directly. Please comment in issue 1073 as to your need to call this method."),e[t](i,{message:n,assert:r,updateClass:o})}}),/firefox/i.test(navigator.userAgent)&&e(document).on("change","select",function(t){e(t.target).trigger("input")}),!1!==window.ParsleyConfig.autoBind&&e(function(){e("[data-parsley-validate]").length&&e("[data-parsley-validate]").parsley()});var A=e({}),R=function(){a.warnOnce("Parsley's pubsub module is deprecated; use the 'on' and 'off' methods on parsley instances or window.Parsley")},D="parsley:";e.listen=function(e,n){var r;if(R(),"object"==typeof arguments[1]&&"function"==typeof arguments[2]&&(r=arguments[1],n=arguments[2]),"function"!=typeof n)throw new Error("Wrong parameters");window.Parsley.on(i(e),t(n,r))},e.listenTo=function(e,n,r){if(R(),!(e instanceof x||e instanceof _))throw new Error("Must give Parsley instance");if("string"!=typeof n||"function"!=typeof r)throw new Error("Wrong parameters");e.on(i(n),t(r))},e.unsubscribe=function(e,t){if(R(),"string"!=typeof e||"function"!=typeof t)throw new Error("Wrong arguments");window.Parsley.off(i(e),t.parsleyAdaptedCallback)},e.unsubscribeTo=function(e,t){if(R(),!(e instanceof x||e instanceof _))throw new Error("Must give Parsley instance");e.off(i(t))},e.unsubscribeAll=function(t){R(),window.Parsley.off(i(t)),e("form,input,textarea,select").each(function(){var n=e(this).data("Parsley");n&&n.off(i(t))})},e.emit=function(e,t){var n;R();var r=t instanceof x||t instanceof _,s=Array.prototype.slice.call(arguments,r?2:1);s.unshift(i(e)),r||(t=window.Parsley),(n=t).trigger.apply(n,_toConsumableArray(s))};e.extend(!0,M,{asyncValidators:{"default":{fn:function(e){return e.status>=200&&e.status<300},url:!1},reverse:{fn:function(e){return e.status<200||e.status>=300},url:!1}},addAsyncValidator:function(e,t,i,n){return M.asyncValidators[e]={fn:t,url:i||!1,options:n||{}},this}}),M.addValidator("remote",{requirementType:{"":"string",validator:"string",reverse:"boolean",options:"object"},validateString:function(t,i,n,r){var s,a,o={},l=n.validator||(!0===n.reverse?"reverse":"default");if("undefined"==typeof M.asyncValidators[l])throw new Error("Calling an undefined async validator: `"+l+"`");i=M.asyncValidators[l].url||i,i.indexOf("{value}")>-1?i=i.replace("{value}",encodeURIComponent(t)):o[r.$element.attr("name")||r.$element.attr("id")]=t;var u=e.extend(!0,n.options||{},M.asyncValidators[l].options);s=e.extend(!0,{},{url:i,data:o,type:"GET"},u),r.trigger("field:ajaxoptions",r,s),a=e.param(s),"undefined"==typeof M._remoteCache&&(M._remoteCache={});var d=M._remoteCache[a]=M._remoteCache[a]||e.ajax(s),h=function(){var t=M.asyncValidators[l].fn.call(r,d,i,n);return t||(t=e.Deferred().reject()),e.when(t)};return d.then(h,h)},priority:-1}),M.on("form:submit",function(){M._remoteCache={}}),window.ParsleyExtend.addAsyncValidator=function(){return ParsleyUtils.warnOnce("Accessing the method `addAsyncValidator` through an instance is deprecated. Simply call `Parsley.addAsyncValidator(...)`"),M.addAsyncValidator.apply(M,arguments)},M.addMessages("en",{defaultMessage:"This value seems to be invalid.",type:{email:"This value should be a valid email.",url:"This value should be a valid url.",number:"This value should be a valid number.",integer:"This value should be a valid integer.",digits:"This value should be digits.",alphanum:"This value should be alphanumeric."},notblank:"This value should not be blank.",required:"This value is required.",pattern:"This value seems to be invalid.",min:"This value should be greater than or equal to %s.",max:"This value should be lower than or equal to %s.",range:"This value should be between %s and %s.",minlength:"This value is too short. It should have %s characters or more.",maxlength:"This value is too long. It should have %s characters or fewer.",length:"This value length is invalid. It should be between %s and %s characters long.",mincheck:"You must select at least %s choices.",maxcheck:"You must select %s choices or fewer.",check:"You must select between %s and %s choices.",equalto:"This value should be the same."}),M.setLocale("en");var q=M;return q});
</script>

<script type="text/javascript">
/*!
 * jQuery Modal (minified)
 * Copyright (c) 2015 CreativeDream
 * https://github.com/CreativeDream/jquery.modal
 * Version: 1.2.3 (10-04-2015)
 * Requires: jQuery v1.7.1 or later
 * type: 'inverted', //Type of Modal Box (alert | confirm | prompt | success | warning | error | info | inverted | primary)
 */
function modal(t){return $.cModal(t)}!function(t){t.cModal=function(n){var e,o={type:"default",title:null,text:null,size:"normal",buttons:[{text:"OK",val:!0,onClick:function(){return!0}}],center:!0,autoclose:!1,callback:null,onShow:null,animate:!0,closeClick:!0,closable:!0,theme:"default",background:null,zIndex:1050,buttonText:{ok:"OK",yes:"Yes",cancel:"Cancel"},template:'<div class="modal-box"><div class="modal-inner"><div class="modal-title"><a class="modal-close-btn"></a></div><div class="modal-text"></div><div class="modal-buttons"></div></div></div>',_classes:{box:".modal-box",boxInner:".modal-inner",title:".modal-title",content:".modal-text",buttons:".modal-buttons",closebtn:".modal-close-btn"}},n=t.extend({},o,n),a=t("<div id='modal-window' />").hide(),l=n._classes.box,s=a.append(n.template),i={init:function(){t("#modal-window").remove(),i._setStyle(),i._modalShow(),i._modalConent(),a.on("click","a.modal-btn",function(){i._modalBtn(t(this))}).on("click",n._classes.closebtn,function(){e=!1,i._modalHide()}).click(function(t){n.closeClick&&"modal-window"==t.target.id&&(e=!1,i._modalHide())}),t(window).bind("keyup",i._keyUpF).resize(function(){var t=n.animate;n.animate=!1,i._position(),n.animate=t})},_setStyle:function(){a.css({position:"fixed",width:"100%",height:"100%",top:"0",left:"0","z-index":n.zIndex,overflow:"auto"}),a.find(n._classes.box).css({position:"absolute"})},_keyUpF:function(t){switch(t.keyCode){case 13:if(s.find("input:not(.modal-prompt-input),textarea").is(":focus"))return!1;i._modalBtn(a.find(n._classes.buttons+" a.modal-btn"+("undefined"!=typeof i.btnForEKey&&a.find(n._classes.buttons+" a.modal-btn:eq("+i.btnForEKey+")").size()>0?":eq("+i.btnForEKey+")":":last-child")));break;case 27:i._modalHide()}},_modalShow:function(){t("body").css({overflow:"hidden",width:t("body").innerWidth()}).append(s)},_modalHide:function(o){if(n.closable===!1)return!1;e="undefined"==typeof e?!1:e;var s=function(){if(null!=n.callback&&"function"==typeof n.callback&&0==n.callback(e,a,i.actions)?!1:!0){a.fadeOut(200,function(){t(this).remove(),t("body").css({overflow:"",width:""})});var o=100*parseFloat(t(l).css("top"))/parseFloat(t(l).parent().css("height"));t(l).stop(!0,!0).animate({top:o+(n.animate?3:0)+"%"},"fast")}};o?setTimeout(function(){s()},o):s(),t(window).unbind("keyup",i._keyUpF)},_modalConent:function(){var e=n._classes.title,o=n._classes.content,s=n._classes.buttons,d=n.buttonText,c=["alert","confirm","prompt"],u=["xenon","atlant","reseted"];if(-1==t.inArray(n.type,c)&&"default"!=n.type&&t(l).addClass("modal-type-"+n.type),t(l).addClass(n.size&&null!=n.size?"modal-size-"+n.size:"modal-size-normal"),n.theme&&null!=n.theme&&"default"!=n.theme&&t(l).addClass((-1==t.inArray(n.theme,u)?"":"modal-theme-")+n.theme),n.background&&null!=n.background&&a.css("background-color",n.background),n.title||null!=n.title?t(e).prepend("<h3>"+n.title+"</h3>"):t(e).remove(),"prompt"==n.type?n.text=(null!=n.text?n.text:"")+'<input type="text" name="modal-prompt-input" class="modal-prompt-input" autocomplete="off" autofocus="on" />':"",t(o).html(n.text),n.buttons||null!=n.buttons){var r="";switch(n.type){case"alert":r='<a class="modal-btn'+(n.buttons[0].addClass?" "+n.buttons[0].addClass:"")+'">'+d.ok+"</a>";break;case"confirm":r='<a class="modal-btn'+(n.buttons[0].addClass?" "+n.buttons[0].addClass:"")+'">'+d.cancel+'</a><a class="modal-btn '+(n.buttons[1]&&n.buttons[1].addClass?" "+n.buttons[1].addClass:"btn-light-blue")+'">'+d.yes+"</a>";break;case"prompt":r='<a class="modal-btn'+(n.buttons[0].addClass?" "+n.buttons[0].addClass:"")+'">'+d.cancel+'</a><a class="modal-btn '+(n.buttons[1]&&n.buttons[1].addClass?" "+n.buttons[1].addClass:"btn-light-blue")+'">'+d.ok+"</a>";break;default:n.buttons.length>0&&t.isArray(n.buttons)?t.each(n.buttons,function(t,n){var e=n.addClass&&"undefined"!=typeof n.addClass?" "+n.addClass:"";r+='<a class="modal-btn'+e+'">'+n.text+"</a>",n.eKey&&(i.btnForEKey=t)}):r+='<a class="modal-btn">'+d.ok+"</a>"}t(s).html(r)}else t(s).remove();if("prompt"==n.type&&$(".modal-prompt-input").focus(),n.autoclose){var m=n.buttons||null!=n.buttons?32*t(o).text().length:900;i._modalHide(900>m?900:m)}a.fadeIn(200,function(){null!=n.onShow?n.onShow(i.actions):null}),i._position()},_position:function(){var e,o,a;n.center?(e={top:t(window).height()<t(l).outerHeight()?1:50,left:50,marginTop:t(window).height()<t(l).outerHeight()?0:-t(l).outerHeight()/2,marginLeft:-t(l).outerWidth()/2},o={top:e.top-(n.animate?3:0)+"%",left:e.left+"%","margin-top":e.marginTop,"margin-left":e.marginLeft},a={top:e.top+"%"}):(e={top:t(window).height()<t(l).outerHeight()?1:10,left:50,marginTop:0,marginLeft:-t(l).outerWidth()/2},o={top:e.top-(n.animate?3:0)+"%",left:e.left+"%","margin-top":e.marginTop,"margin-left":e.marginLeft},a={top:e.top+"%"}),t(l).css(o).stop(!0,!0).animate(a,"fast")},_modalBtn:function(o){var l=!1,s=n.type,d=o.index(),c=n.buttons[d];if(t.inArray(s,["alert","confirm","prompt"])>-1)e=l=1==d?!0:!1,"prompt"==s&&(e=l=l&&a.find("input.modal-prompt-input").size()>0!=0?a.find("input.modal-prompt-input").val():!1),i._modalHide();else{if(o.hasClass("btn-disabled"))return!1;e=l=c&&c.val?c.val:!0,(!c.onClick||c.onClick(t.extend({val:l,bObj:o,bOpts:c},i.actions)))&&i._modalHide()}e=l},actions:{html:a,close:function(){i._modalHide()},getModal:function(){return a},getBox:function(){return a.find(n._classes.box)},getInner:function(){return a.find(n._classes.boxInner)},getTitle:function(){return a.find(n._classes.title)},getContet:function(){return a.find(n._classes.content)},getButtons:function(){return a.find(n._classes.buttons).find("a")},setTitle:function(t){return a.find(n._classes.title+" h3").html(t),a.find(n._classes.title+" h3").size()>0},setContent:function(t){return a.find(n._classes.content).html(t),a.find(n._classes.content).size()>0}}};return i.init(),i.actions}}(jQuery);
</script>
	<script>
	//Unique namespace
    DUPX = new Object();

	DUPX.showProgressBar = function ()
    {
		DUPX.animateProgressBar('progress-bar');
		$('#ajaxerr-area').hide();
		$('#progress-area').show();
	}

	DUPX.hideProgressBar = function ()
    {
		$('#progress-area').hide(100);
		$('#ajaxerr-area').fadeIn(400);
	}

	DUPX.animateProgressBar = function(id)
    {
		//Create Progress Bar
		var $mainbar   = $("#" + id);
		$mainbar.progressbar({ value: 100 });
		$mainbar.height(25);
		runAnimation($mainbar);

		function runAnimation($pb) {
			$pb.css({ "padding-left": "0%", "padding-right": "90%" });
			$pb.progressbar("option", "value", 100);
			$pb.animate({ paddingLeft: "90%", paddingRight: "0%" }, 3500, "linear", function () { runAnimation($pb); });
		}
	}

    DUPX.toggleAll = function(id)
    {
		$(id + " *[data-type='toggle']").each(function() {
			$(this).trigger('click');
		});
	}


    DUPX.toggleClick = function()
    {
		var id     = $(this).attr('data-target');
		var text   = $(this).text().replace(/\+|\-/, "");
		var icon   = $(this).find('i.dupx-plus-square, i.dupx-minus-square');
		var target = $(id);
		$(icon).removeClass('dupx-plus-square dupx-minus-square');

		if (target.is(':hidden') ) {
			(icon.length)
				? $(icon).addClass('dupx-minus-square')
				: $(this).html("- " + text );
			target.show();
		} else {
			(icon.length)
				? $(icon).addClass('dupx-plus-square')
				: $(this).html("+ " + text );
			target.hide();
		}
	}
	
	$(document).ready(function()
    {
		<?php if ($GLOBALS['DUPX_DEBUG']) : ?>
			$("div.dupx-debug input[type=hidden], div.dupx-debug textarea").each(function() {
				var label = '<label>' + $(this).attr('name') + ':</label>';
				$(this).before(label);
				$(this).after('<br/>');
			 });
			 $("div.dupx-debug input[type=hidden]").each(function() {
				$(this).attr('type', 'text');
			 });

			 $("div.dupx-debug").prepend('<h2>Debug View</h2>');
		<?php endif; ?>
	});
</script>

</head>
<body>

<div id="content">
<!-- =========================================
HEADER TEMPLATE: Common header on all steps -->
<table cellspacing="0" class="dupx-header">
    <tr>
        <td style="width:100%;">
            <div style="font-size:26px; padding:7px 0 7px 0">
                <!-- !!DO NOT CHANGE/EDIT OR REMOVE PRODUCT NAME!!
                If your interested in Private Label Rights please contact us at the URL below to discuss
                customizations to product labeling: http://snapcreek.com	-->
                &nbsp; Duplicator
            </div>
        </td>
        <td class="dupx-header-version">
            version: <?php echo $GLOBALS['FW_DUPLICATOR_VERSION'] ?><br/>
			&raquo; <a href="javascript:void(0)" onclick="DUPX.showServerInfo()">info</a>
			&raquo; <a href="?help=1" target="_blank">help</a>
			<?php
				echo ' &raquo; <a href="?help=1#secure" target="_blank">';
				echo ($GLOBALS['FW_SECUREON']) ? 'locked</a>' : '<i class="secure-unlocked">unlocked</i></a>';

			?>

        </td>
    </tr>
</table>

<div style="position: relative">
	<div class="installer-mode">
		<?php
			echo 'Mode: ';
			echo ($GLOBALS['FW_ARCHIVE_ONLYDB']) ? 'Database Only' : 'Standard';
		?>
	</div>
</div>

<!-- =========================================
FORM DATA: Data Steps -->
<div id="content-inner">
<?php

if (! isset($_GET['help'])) {
switch ($_POST['action_step']) {
	case "0" :
	?> <?php
/** IDE HELPERS */
/* @var $GLOBALS['DUPX_AC'] DUPX_ArchiveConfig */

$_POST['secure-pass'] = isset($_POST['secure-pass']) ? $_POST['secure-pass'] : '' ;
$_POST['secure-try']  = isset($_POST['secure-try'])  ? 1 : 0 ;
$_GET['debug']        = isset($_GET['debug']) ? $_GET['debug'] : 0;
$page_url = DUPX_HTTP::get_request_uri();
$page_err = 0;
$pass_hasher = new DUPX_PasswordHash(8, FALSE);
$pass_check  = $pass_hasher->CheckPassword(base64_encode($_POST['secure-pass']), $GLOBALS['FW_SECUREPASS']);

//FORWARD: password not enabled
if (! $GLOBALS['FW_SECUREON'] && ! $_GET['debug']) {
	DUPX_HTTP::post_with_html($page_url, array('action_step' => '1'));
	exit;
}

//POSTBACK: valid password
if ($pass_check) {
	DUPX_HTTP::post_with_html($page_url,
		array(
			'action_step' => '1',
			'secure-pass' => $_POST['secure-pass']));
	exit;
}

//ERROR: invalid password
if ($_POST['secure-try'] && ! $pass_check) {
	$page_err = 1;
}
?>

<!-- =========================================
VIEW: STEP 0 - PASSWORD -->
<form method="post" id="i1-pass-form" class="content-form"  data-parsley-validate="" autocomplete="oldpassword">
	<input type="hidden" name="view" value="secure" />
	<input type="hidden" name="secure-try" value="1" />

	<div class="hdr-main">
		Installer Password
	</div>

	<?php if ($page_err) : ?>
		<div class="error-pane">
			<p>Invalid Password! Please try again. If the problem persists see the more details link below.</p>
		</div>
	<?php endif; ?>

	<div style="text-align: center">
		This file was password protected when it was created.   If you do not remember the password	check the details of the package on	the site where it was created or visit
		the online FAQ for <a href="https://snapcreek.com/duplicator/docs/faqs-tech/#faq-installer-030-q" target="_blank">more details</a>.
		<br/><br/><br/>

		<div class="i1-pass-area">
			<label for="secure-pass">Enter Password</label>
			<div id="i1-pass-input">
				<input type="password" name="secure-pass" id="secure-pass" required="required"  autocomplete="oldpassword" /><br/>
				<div style="margin-top:7px">
					<input type="checkbox" class="pass-toggle" id="secure-lock" onclick="DUPX.togglePassword()" title="Show/Hide the password">
					<label class="secure-lock" for="secure-lock">Show Password</label>
				</div>
			</div>
			<div style="margin-top: 15px">
				<button type="button" class="default-btn" name="secure-btn" id="secure-btn" onclick="DUPX.checkPassword()">Submit</button>
			</div>
		</div>
	</div>
</form>

<script>
	/**
	 * Submits the password for validation
	 */
	DUPX.checkPassword = function()
	{
		var $form = $('#i1-pass-form');
		$form.parsley().validate();
		if (! $form.parsley().isValid()) {
			return;
		}
		$form.submit();
	}

	/**
	 * Submits the password for validation
	 */
	DUPX.togglePassword = function()
	{
		var $input = $('#secure-pass');
		var $lock  = $('#secure-lock');
		if (($input).attr('type') == 'text') {
			//$lock.html('<i class="fa fa-lock"></i>');
			$input.attr('type', 'password');
		} else {
			//$lock.html('<i class="fa fa-unlock"></i>');
			$input.attr('type', 'text');
		}
	}
</script>
<!-- END OF VIEW INIT 1 --> <?php
	break;
	case "1" :
	?> <?php
//VIEW: STEP 1- INPUT

//ARCHIVE FILE
$arcStatus	= (file_exists($GLOBALS['ARCHIVE_PATH']))	? 'Pass' : 'Fail';
$arcFormat  = ($arcStatus == 'Pass') ? 'Pass' : 'StatusFailed';
$arcSize    = @filesize($GLOBALS['ARCHIVE_PATH']);
$arcSize    = is_numeric($arcSize) ? $arcSize : 0;
$zip_archive_enabled = class_exists('ZipArchive') ? 'Enabled' : 'Not Enabled';

$arcSizeRatio  = (((1.0) * $arcSize)  / $GLOBALS['FW_PACKAGE_EST_SIZE']) * 100;
$arcSizeStatus = ($arcSizeRatio > 90) ? 'Pass' : 'Fail';

//ARCHIVE FORMAT
if ($arcStatus) {
	if (class_exists('ZipArchive')){
		$zip = new ZipArchive();
		if($zip->open($GLOBALS['ARCHIVE_PATH']) === TRUE ) {

			$arcFilePath = basename($GLOBALS['ARCHIVE_PATH']);
			$arcFilePath = substr($arcFilePath, 0, strrpos($arcFilePath, "."));
			//Some systems the __MACOSX folder can cause issues on others it works fine removing
			//until further reports are discovered, removed on 04-06-2018
			//$badFiles  = array('__MACOSX', $arcFilePath);
			$badFiles  = array('', $arcFilePath);
			$goodFiles = array('database.sql', 'installer-backup.php');
			$goodFilesFound = true;
			$badFilesFound  = false;

			foreach ($badFiles as $val) {
				if (is_numeric($zip->locateName("{$val}/"))) {
					$badFilesFound = true;
					break;
				}
			}

			foreach ($goodFiles as $val) {
				if ($zip->locateName($val) !== true) {
					$goodFilesFound = false;
				}
			}

			$arcFormat = ($goodFilesFound == false && $badFilesFound == true) ? 'Fail' : 'Pass';
		}
	} else {
		$arcFormat = 'NoZipArchive';
	}
}

$all_arc = ($arcStatus == 'Pass' && $arcFormat != 'Fail' && $arcSizeStatus == 'Pass') ? 'Pass' : 'Fail';

//REQUIRMENTS
$req      	= array();
$req['01']	= DUPX_Server::isDirWritable($GLOBALS["CURRENT_ROOT_PATH"]) ? 'Pass' : 'Fail';
$req['02']	= 'Pass'; //Place-holder for future check
$req['03']	= 'Pass'; //Place-holder for future check; 
$req['04']	= function_exists('mysqli_connect')	 ? 'Pass' : 'Fail';
$req['05']	= DUPX_Server::$php_version_safe	 ? 'Pass' : 'Fail';
$all_req  	= in_array('Fail', $req) 			 ? 'Fail' : 'Pass';

//NOTICES
$openbase		= ini_get("open_basedir");
$scanfiles		= @scandir($GLOBALS["CURRENT_ROOT_PATH"]);
$scancount		= is_array($scanfiles) ? (count($scanfiles)) : -1;
$datetime1		= $GLOBALS['FW_CREATED'];
$datetime2		= date("Y-m-d H:i:s");
$fulldays		= round(abs(strtotime($datetime1) - strtotime($datetime2))/86400);
$root_path		= DUPX_U::setSafePath($GLOBALS['CURRENT_ROOT_PATH']);
$wpconf_path	= "{$root_path}/wp-config.php";
$max_time_zero  = @set_time_limit(0);
$max_time_size  = 314572800;  //300MB
$max_time_ini   = ini_get('max_execution_time');
$max_time_warn  = (is_numeric($max_time_ini) && $max_time_ini < 31  && $max_time_ini > 0) && $arcSize > $max_time_size;


$notice		    = array();
if (!$GLOBALS['FW_ARCHIVE_ONLYDB']) {
	$notice['01']   = ! file_exists($wpconf_path)	? 'Good' : 'Warn';
	$notice['02']   = $scancount <= 35 ? 'Good' : 'Warn';
}
$notice['03']	= $fulldays <= 120 ? 'Good' : 'Warn';
$notice['04']	= 'Good'; //Place-holder for future check
$notice['05']	= DUPX_Server::$php_version_53_plus	 ? 'Good' : 'Warn';
$notice['06']	= empty($openbase)	 ? 'Good' : 'Warn';
$notice['07']	= ! $max_time_warn	 ? 'Good' : 'Warn';
$all_notice  	= in_array('Warn', $notice) ? 'Warn' : 'Good';

//SUMMATION
$req_success  = ($all_req == 'Pass');
$req_notice   = ($all_notice == 'Good');
$all_success  = ($req_success && $req_notice);
$agree_msg    = "To enable this button the checkbox above under the 'Terms & Notices' must be checked.";
?>


<form id='s1-input-form' method="post" class="content-form" >
<input type="hidden" name="action_ajax" value="1" />
<input type="hidden" name="action_step" value="1" />
<input type="hidden" name="archive_name"  value="<?php echo $GLOBALS['FW_PACKAGE_NAME'] ?>" />
<input type="hidden" name="secure-pass" value="<?php echo $_POST['secure-pass']; ?>" />

<div class="hdr-main">
    Step <span class="step">1</span> of 4: Deployment
</div>
<br/>
	

<!-- ====================================
ARCHIVE
==================================== -->
<div class="hdr-sub1" id="s1-area-archive-file-link" data-type="toggle" data-target="#s1-area-archive-file">
    <a href="javascript:void(0)"><i class="dupx-plus-square"></i> Archive</a>
	<div class="<?php echo ($all_arc == 'Pass') ? 'status-badge-pass' : 'status-badge-fail'; ?>" style="float:right">
		<?php echo ($all_arc == 'Pass') ? 'Pass' : 'Fail'; ?>
	</div>
</div>
<div id="s1-area-archive-file" style="display:none">

    <table class="s1-archive-local">
		<tr>
			<td colspan="2"><div class="hdr-sub3">Site Details</div></td>
		</tr>
		 <tr>
            <td>Site:</td>
            <td><?php echo $GLOBALS['FW_BLOGNAME'];?> </td>
        </tr>
        <tr>
            <td>Notes:</td>
            <td><?php echo strlen($GLOBALS['FW_PACKAGE_NOTES']) ? "{$GLOBALS['FW_PACKAGE_NOTES']}" : " - no notes - ";?></td>
        </tr>
		<?php if ($GLOBALS['FW_ARCHIVE_ONLYDB']) :?>
		<tr>
			<td>Mode:</td>
			<td>Archive only database was enabled during package package creation.</td>
		</tr>
		<?php endif; ?>
	</table>

	<table class="s1-archive-local">
		<tr>
			<td colspan="2"><div class="hdr-sub3">File Details</div></td>
		</tr>
        <tr style="vertical-align:top">
            <td>Size:</td>
            <td>
			<?php
				$projectedSize = DUPX_U::readableByteSize($GLOBALS['FW_PACKAGE_EST_SIZE']);
				$actualSize	= DUPX_U::readableByteSize($arcSize);
				echo "{$actualSize}<br/>";
				if ($arcSizeStatus == 'Fail' ) {
					echo "<span class='dupx-fail'>The archive file size is currently <b>{$actualSize}</b> and its estimated file size should be around <b>{$projectedSize}</b>.  "
					. "The archive file may not have been fully downloaded to the server.  If so please wait for the file to completely download and then refresh this page.<br/><br/>";

					echo "This warning is only shown when the file has more than a 10% size ratio difference from when it was originally built.  Please review the file sizes "
					. "to make sure the archive was downloaded to this server correctly if the download is complete.</span>";
				}
			?>
			</td>
        </tr>
        <tr>
            <td>Name:</td>
            <td><?php echo "{$GLOBALS['FW_PACKAGE_NAME']}";?> </td>
        </tr>
        <tr>
            <td>Path:</td>
            <td><?php echo "{$GLOBALS['CURRENT_ROOT_PATH']}";?> </td>
        </tr>
		<tr>
			<td>Status:</td>
			<td>
				<?php if ($arcStatus != 'Fail') : ?>
					<span class="dupx-pass">File Found</span>
				<?php else : ?>
					<div class="s1-archive-failed-msg">
						<b class="dupx-fail">Archive File Not Found!</b><br/>
						The archive file name below must be the <u>exact</u> name of the archive file placed in the deployment path (character for character).
						If the file does not have the same name then rename it to the name above.
						<br/><br/>

						When downloading the package files make sure both files are from the same package line in the packages view.  The archive file also
						must be completely downloaded to the server before starting the install.  The following zip files were found at the deployment path:
						<?php
							//DETECT ARCHIVE FILES
							$zip_files = DUPX_Server::getZipFiles();
							$zip_count = count($zip_files);

							if ($zip_count >= 1) {
								echo "<ol style='padding:10px 20px 0 20px; font-style:italic'>";
								foreach($zip_files as $file) {
									echo "<li> '{$file}'</li>";
								}
								echo "</ol>";
							} else {
								echo  "<br/><br/> <i>- No zip files found -</i>";
							}
						?>
					</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td>Format:</td>
			<td>
				<?php if ($arcFormat == 'Pass') : ?>
					<span class="dupx-pass">Good structure</span>
				<?php elseif ($arcFormat == 'StatusFailed') : ?>
					<span class="dupx-fail">Unable to validate format</span><br/>
				<?php elseif ($arcFormat == 'NoZipArchive') : ?>
					<div class="s1-archive-failed-msg">
						The PHP extraction library <a href="http://php.net/manual/en/book.zip.php" target="_help">ZipArchive</a> was not found on this server.  There are a few options:
						<ol>
							<li>Contact your host to enable the this PHP library. <a href="http://php.net/manual/en/zip.installation.php" target="_help">[more info]</a></li>
							<li>Enable 'Manual package extraction' in the options menu and <a href="https://snapcreek.com/duplicator/docs/faqs-tech/#faq-installer-015-q" target="_help">Manually extract the archive</a></li>
						</ol>
					</div>
				<?php else : ?>
					<div class="s1-archive-failed-msg">
						<b class="dupx-fail">Invalid Archive Format Detected!</b><br/>
						The archive files contents must be laid out in a specific format.  If the format has been changed the install process will error out.
						<br/><br/>

						This scenario is rare but can happen on some systems during the download and upload process of the zip without a user being aware of
						the issue. Please check the contents of the zip archive and be sure its contents match the layout of your site.
						<br/><br/>

						Files such as database.sql and wp-config.php should be at the root of the archive.  For more details see the FAQ article
						<a href="https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=invalid_ar_fmt#faq-installer-020-q" target="_help">The archive format is changing on my Mac what might be the problem?</a>
					</div>
				<?php endif; ?>
			</td>
		</tr>
    </table>

</div>
<br/><br/>


<!-- ====================================
VALIDATION
==================================== -->
<div class="hdr-sub1" id="s1-area-sys-setup-link" data-type="toggle" data-target="#s1-area-sys-setup">
	<a href="javascript:void(0)"><i class="dupx-plus-square"></i> Validation</a>
	<div class="<?php echo ($req_success) ? 'status-badge-pass' : 'status-badge-fail'; ?>" style="float:right">
		<?php echo ($req_success) ? 'Pass' : 'Fail'; ?>
	</div>
</div>
<div id="s1-area-sys-setup" style="display:none">
	<div class='info-top'>The system validation checks help to make sure the system is ready for install.</div>

    <!-- *** REQUIREMENTS ***  -->
	<div class="s1-reqs" id="s1-reqs-all">
		<div class="header">
			<table class="s1-checks-area">
				<tr>
					<td class="title">Requirements <small>(must pass)</small></td>
					<td class="toggle"><a href="javascript:void(0)" onclick="DUPX.toggleAll('#s1-reqs-all')">[toggle]</a></td>
				</tr>
			</table>
		</div>

		<!-- REQ 1 -->
		<div class="status <?php echo strtolower($req['01']); ?>"><?php echo $req['01']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-reqs01">+ Permissions</div>
		<div class="info" id="s1-reqs01">
			<table>
				<tr>
					<td><b>Deployment Path:</b> </td>
					<td><i><?php echo "{$GLOBALS['CURRENT_ROOT_PATH']}"; ?></i> </td>
				</tr>
				<tr>
					<td><b>Suhosin Extension:</b> </td>
					<td><?php echo extension_loaded('suhosin') ? "<i class='dupx-fail'>Enabled</i>" : "<i class='dupx-pass'>Disabled</i>"; ?> </td>
				</tr>
				<tr>
					<td><b>PHP Safe Mode:</b> </td>
					<td><?php echo (DUPX_Server::$php_safe_mode_on)  ? "<i class='dupx-fail'>Enabled</i>" : "<i class='dupx-pass'>Disabled</i>"; ?> </td>
				</tr>
			</table><br/>

			The deployment path above must be writable by PHP in order to extract the archive file.  Incorrect permissions and extension such as
			<a href="https://suhosin.org/stories/index.html" target="_blank">suhosin</a> can sometimes interfere with PHP being able to write/extract files.
			Please see the <a href="https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=installer_perms#faq-trouble-055-q" target="_blank">FAQ permission</a> help link for complete details.
			PHP with <a href='http://php.net/manual/en/features.safe-mode.php' target='_blank'>safe mode</a> should be disabled.  If this test fails
			please contact your hosting provider or server administrator to disable PHP safe mode.
		</div>

		<!-- REQ 2
		<div class="status <?php echo strtolower($req['02']); ?>"><?php echo $req['02']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-reqs02">+ Place Holder</div>
		<div class="info" id="s1-reqs02"></div>-->

		<!-- REQ 3
		<div class="status <?php echo strtolower($req['03']); ?>"><?php echo $req['03']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-reqs03">+ Place Holder</div>
		<div class="info" id="s1-reqs03"></div> -->

		<!-- REQ 4 -->
		<div class="status <?php echo strtolower($req['04']); ?>"><?php echo $req['04']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-reqs04">+ PHP Mysqli</div>
		<div class="info" id="s1-reqs04">
			Support for the PHP <a href='http://us2.php.net/manual/en/mysqli.installation.php' target='_blank'>mysqli extension</a> is required.
			Please contact your hosting provider or server administrator to enable the mysqli extension.  <i>The detection for this call uses
			the function_exists('mysqli_connect') call.</i>
		</div>

		<!-- REQ 5 -->
		<div class="status <?php echo strtolower($req['05']); ?>"><?php echo $req['05']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-reqs05">+ PHP Min Version</div>
		<div class="info" id="s1-reqs05">
			This server is running PHP: <b><?php echo DUPX_Server::$php_version ?></b>. <i>A minimum of PHP 5.2.17 is required</i>.
			Contact your hosting provider or server administrator and let them know you would like to upgrade your PHP version.
		</div>
	</div><br/>


	<!-- *** NOTICES ***  -->
	<div class="s1-reqs" id="s1-notice-all">
		<div class="header">
			<table class="s1-checks-area">
				<tr>
					<td class="title">Notices <small>(optional)</small></td>
					<td class="toggle"><a href="javascript:void(0)" onclick="DUPX.toggleAll('#s1-notice-all')">[toggle]</a></td>
				</tr>
			</table>
		</div>

		<?php if (!$GLOBALS['FW_ARCHIVE_ONLYDB']) :?>

			<!-- NOTICE 1 -->
			<div class="status <?php echo ($notice['01'] == 'Good') ? 'pass' : 'fail' ?>"><?php echo $notice['01']; ?></div>
			<div class="title" data-type="toggle" data-target="#s1-notice01">+ Configuration File</div>
			<div class="info" id="s1-notice01">
				Duplicator works best by placing the installer and archive files into an empty directory.  If a wp-config.php file is found in the extraction
				directory it might indicate that a pre-existing WordPress site exists which can lead to a bad install.
				<br/><br/>
				<b>Options:</b>
				<ul style="margin-bottom: 0">
					<li>If the archive was already manually extracted then <a href="javascript:void(0)" onclick="DUPX.getManaualArchiveOpt()">[Enable Manual Archive Extraction]</a></li>
					<li>If the wp-config file is not needed then remove it.</li>
				</ul>
			</div>

			<!-- NOTICE 2 -->
			<div class="status <?php echo ($notice['02'] == 'Good') ? 'pass' : 'fail' ?>"><?php echo $notice['02']; ?></div>
			<div class="title" data-type="toggle" data-target="#s1-notice02">+ Directory Setup</div>
			<div class="info" id="s1-notice02">
				<b>Deployment Path:</b> <i><?php echo "{$GLOBALS['CURRENT_ROOT_PATH']}"; ?></i>
				<br/><br/>
				There are currently <?php echo "<b>[{$scancount}]</b>";?>  items in the deployment path. These items will be overwritten if they also exist
				inside the archive file.  The notice is to prevent overwriting an existing site or trying to install on-top of one which
				can have un-intended results. <i>This notice shows if it detects more than 40 items.</i>

				<br/><br/>
				<b>Options:</b>
				<ul style="margin-bottom: 0">
					<li>If the archive was already manually extracted then <a href="javascript:void(0)" onclick="DUPX.getManaualArchiveOpt()">[Enable Manual Archive Extraction]</a></li>
					<li>If the files/directories are not the same as those in the archive then this notice can be ignored.</li>
					<li>Remove the files if they are not needed and refresh this page.</li>
				</ul>
			</div>

		<?php endif; ?>

		<!-- NOTICE 3 -->
		<div class="status <?php echo ($notice['03'] == 'Good') ? 'pass' : 'fail' ?>"><?php echo $notice['03']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-notice03">+ Package Age</div>
		<div class="info" id="s1-notice03">
			<?php echo "The package is {$fulldays} day(s) old. Packages older than 120 days might be considered stale.  If you are comfortable with a package that that was created over "
			. "four months ago please ignore this notice."; ?>
		</div>

        <!-- NOTICE 4
		<div class="status <?php echo ($notice['04'] == 'Good') ? 'pass' : 'fail' ?>"><?php echo $notice['04']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-notice04">+ Placeholder</div>
		<div class="info" id="s1-notice04">
		</div>-->

		<!-- NOTICE 5 -->
		<div class="status <?php echo ($notice['05'] == 'Good') ? 'pass' : 'fail' ?>"><?php echo $notice['05']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-notice05">+ PHP Version 5.2</div>
		<div class="info" id="s1-notice05">
			<?php
				$currentPHP = DUPX_Server::$php_version;
				$cssStyle   = DUPX_Server::$php_version_53_plus	 ? 'color:green' : 'color:red';
				echo "<b style='{$cssStyle}'>This server is currently running PHP version [{$currentPHP}]</b>.<br/>"
				. "Duplicator allows PHP 5.2 to be used during install but does not officially support it.  If your using PHP 5.2 we strongly recommend NOT using it and having your "
				. "host upgrade to a newer more stable, secure and widely supported version.  The <a href='http://php.net/eol.php' target='_blank'>end of life for PHP 5.2</a> "
				. "was in January of 2011 and is not recommended for use.<br/><br/>";

				echo "Many plugin and theme authors are no longer supporting PHP 5.2 and trying to use it can result in site wide problems and compatibility warnings and errors.  "
				. "Please note if you continue with the install using PHP 5.2 the Duplicator support team will not be able to help with issues or troubleshooting your site.  "
				. "If your server is running <b>PHP 5.3+</b> please feel free to reach out for help if you run into issues with your migration/install.";
			?>
		</div>

		<!-- NOTICE 6 -->
		<div class="status <?php echo ($notice['06'] == 'Good') ? 'pass' : 'fail' ?>"><?php echo $notice['06']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-notice06">+ PHP Open Base</div>
		<div class="info" id="s1-notice06">
			<b>Open BaseDir:</b> <i><?php echo $notice['06'] == 'Good' ? "<i class='dupx-pass'>Disabled</i>" : "<i class='dupx-fail'>Enabled</i>"; ?></i>
			<br/><br/>

			If <a href="http://www.php.net/manual/en/ini.core.php#ini.open-basedir" target="_blank">open_basedir</a> is enabled and you're
			having issues getting your site to install properly; please work with your host and follow these steps to prevent issues:
			<ol style="margin:7px; line-height:19px">
				<li>Disable the open_basedir setting in the php.ini file</li>
				<li>If the host will not disable, then add the path below to the open_basedir setting in the php.ini<br/>
					<i style="color:maroon">"<?php echo str_replace('\\', '/', dirname( __FILE__ )); ?>"</i>
				</li>
				<li>Save the settings and restart the web server</li>
			</ol>
			Note: This warning will still show if you choose option #2 and open_basedir is enabled, but should allow the installer to run properly.  Please work with your
			hosting provider or server administrator to set this up correctly.
		</div>

		<!-- NOTICE 7 -->
		<div class="status <?php echo ($notice['07'] == 'Good') ? 'pass' : 'fail' ?>"><?php echo $notice['07']; ?></div>
		<div class="title" data-type="toggle" data-target="#s1-notice07">+ PHP Timeout</div>
		<div class="info" id="s1-notice07">
			<b>Archive Size:</b> <?php echo DUPX_U::readableByteSize($arcSize) ?>  <small>(detection limit is set at <?php echo DUPX_U::readableByteSize($max_time_size) ?>) </small><br/>
			<b>PHP max_execution_time:</b> <?php echo "{$max_time_ini}"; ?> <small>(zero means no limit)</small> <br/>
			<b>PHP set_time_limit:</b> <?php echo ($max_time_zero) ? '<i style="color:green">Success</i>' : '<i style="color:maroon">Failed</i>' ?>
			<br/><br/>

			The PHP <a href="http://php.net/manual/en/info.configuration.php#ini.max-execution-time" target="_blank">max_execution_time</a> setting is used to
			determine how long a PHP process is allowed to run.  If the setting is too small and the archive file size is too large then PHP may not have enough
			time to finish running before the process is killed causing a timeout.
			<br/><br/>

			Duplicator attempts to turn off the timeout by using the
			<a href="http://php.net/manual/en/function.set-time-limit.php" target="_blank">set_time_limit</a> setting.   If this notice shows as a warning then it is
			still safe to continue with the install.  However, if a timeout occurs then you will need to consider working with the max_execution_time setting or extracting the
			archive file using the 'Manual package extraction' method.
			Please see the	<a href="https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=installer_timeout#faq-trouble-100-q" target="_blank">FAQ timeout</a> help link for more details.

		</div>
	</div>
</div>
<br/><br/>
	

<!-- ====================================
OPTIONS
==================================== -->
<div class="hdr-sub1" data-type="toggle" data-target="#s1-area-adv-opts">
	<a href="javascript:void(0)"><i class="dupx-plus-square"></i> Options</a>
</div>
<div id="s1-area-adv-opts" style="display:none">
	<div class="help-target"><a href="?help#help-s1" target="_blank">[help]</a></div>
	<br/>
	<div class="hdr-sub3">General</div>
	<table class="dupx-opts dupx-advopts">
		<tr>
			<td>Extraction:</td>
			<td>

				<select id="archive_engine" name="archive_engine" size="2">
					<option value="manual">Manual Archive Extraction</option>
					<?php
					//ZIP-ARCHIVE
					echo (! $zip_archive_enabled)
						? '<option disabled="true">PHP ZipArchive (not detected on server)</option>'
						: '<option value="ziparchive" selected="true">PHP ZipArchive</option>';
					?>
				</select>
			</td>
		</tr>
	</table>
	<br>
	<br>
	<div class="hdr-sub3">Advanced</div>
	<table class="dupx-opts dupx-advopts">
                <tr>
			<td>Safe Mode:</td>
			<td>
                            <select name="exe_safe_mode" id="exe_safe_mode" onchange="DUPX.onSafeModeSwitch();" style="width:200px;">
                                <option value="0">Off</option>
                                <option value="1">Basic</option>
                                <option value="2">Advance</option>
                            </select>
			</td>
		</tr>
		<tr>
			<td>Config Files:</td>
			<td>
				<input type="checkbox" name="retain_config" id="retain_config" value="1" />
				<label for="retain_config" style="font-weight: normal">Retain original .htaccess, .user.ini and web.config</label>
			</td>
		</tr>
		<tr>
			<td>File Times:</td>
			<td>
				<input type="radio" name="archive_filetime" id="archive_filetime_now" value="current" checked="checked" /> <label class="radio" for="archive_filetime_now" title='Set the files current date time to now'>Current</label>
				<input type="radio" name="archive_filetime" id="archive_filetime_orginal" value="original" /> <label class="radio" for="archive_filetime_orginal" title="Keep the files date time the same">Original</label>
			</td>
		</tr>
		<tr>
			<td>Logging:</td>
			<td>
				<input type="radio" name="logging" id="logging-light" value="1" checked="true"> <label for="logging-light">Light</label>
				<input type="radio" name="logging" id="logging-detailed" value="2"> <label for="logging-detailed">Detailed</label>
				<input type="radio" name="logging" id="logging-debug" value="3"> <label for="logging-debug">Debug</label>
			</td>
		</tr>
	</table>
     <br/><br/>

     <!-- *** SETUP HELP *** -->
     <div class="hdr-sub3">Setup Help</div>
     <div id='s1-area-setup-help'>
        <div style="padding:10px 0px 0px 10px;line-height:22px">
			<table style='width:100%'>
				<tr>
					<td style="width:200px">
						&raquo; Watch the <a href="https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=installer_vid_tutor#faq-resource-070-q" target="_blank">video tutorials</a> <br/>
						&raquo; Read helpful <a href="https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=installer_help_art" target="_blank">articles</a> <br/>
					</td>
					<td>
						 &raquo; Visit the <a href="https://snapcreek.com/duplicator/docs/quick-start/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_quickstart" target="_blank">quick start guides</a> <br/>
						 &raquo; Browse the <a href="https://snapcreek.com/duplicator/docs/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=installer_online_docs" target="_blank">online docs</a> <br/>
					</td>
				</tr>
			</table>
        </div>
     </div><br/>

</div>
<br/><br/>

<!-- ====================================
NOTICES
==================================== -->
<div id="dialog-server-notice" style="display:none">
	<div id="s1-warning-msg">
		<b>TERMS &amp; NOTICES</b> <br/><br/>

		<b>Disclaimer:</b>
		The Duplicator software and installer should be used at your own risk.  Users should always back up or have backups of your database and files before running this installer.
		If you're not sure about how to use this tool then please enlist the guidance of a technical professional.  <u>Always</u> test this installer in a sandbox environment
		before trying to deploy into a production environment.  Be sure that if anything happens during the install that you have a backup recovery plan in place.   By accepting
		this agreement the users of this software do not hold liable Snapcreek LLC or any of its affiliates/members liable for any issues that might occur during use of this software.
		<br/><br/>


		<b>Database:</b>
		Do not connect to an existing database unless you are 100% sure you want to remove all of it's data. Connecting to a database that already exists will permanently
		DELETE all data in that database. This tool is designed to populate and fill a database with NEW data from a duplicated database using the SQL script in the
		package name above.
		<br/><br/>

		<b>Setup:</b>
		Only the archive and installer file should be in the install directory, unless you have manually extracted the package and checked the
		'Manual Package Extraction' checkbox. All other files will be OVERWRITTEN during install.  Make sure you have full backups of all your databases and files
		before continuing with an installation. Manual extraction requires that all contents in the package are extracted to the same directory as the installer file.
		Manual extraction is only needed when your server does not support the ZipArchive extension.  Please see the online help for more details.
		<br/><br/>

		<b>After Install:</b> When you are done with the installation you must remove the these files/directories:
		<ul>
			<li>installer.php</li>
			<li>installer-data.sql</li>
			<li>installer-backup.php</li>
			<li>installer-log.txt</li>
			<li>database.sql</li>
		</ul>

		These files contain sensitive information and should not remain on a production system for system integrity and security protection.
		<br/><br/>

		<b>License Overview</b><br/>
		Duplicator is licensed under the GPL v3 https://www.gnu.org/licenses/gpl-3.0.en.html including the following disclaimers and limitation of liability.
		<br/><br/>

		<b>Disclaimer of Warranty</b><br/>
		THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW. EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
		PROVIDE THE PROGRAM “AS IS” WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
		FITNESS FOR A PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU. SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME
		THE COST OF ALL NECESSARY SERVICING, REPAIR OR CORRECTION.
		<br/><br/>

		<b>Limitation of Liability</b><br/>
		IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS THE PROGRAM AS
		PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE USE OR INABILITY TO USE THE
		PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO
		OPERATE WITH ANY OTHER PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.
		<br/><br/>
	</div>
</div>

<div id="s1-warning-check">
	<input id="accept-warnings" name="accpet-warnings" type="checkbox" onclick="DUPX.acceptWarning()" />
	<label for="accept-warnings">I have read and accept all <a href="javascript:void(0)" onclick="DUPX.showNotices()">terms &amp; notices</a> <small style="font-style:italic">(required to continue)</small></label><br/>
</div>


<?php if (! $req_success  ||  $all_arc == 'Fail') :?>
	<div class="s1-err-msg">
		<i>
			This installation will not be able to proceed until the 'Archive' and 'Validation' sections pass. Please adjust your servers settings or contact your
			server administrator, hosting provider or visit the resources below for additional help.
		</i>
		<div style="padding:10px">
			&raquo; <a href="https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_validfail_techfaq" target="_blank">Technical FAQs</a> <br/>
			&raquo; <a href="https://snapcreek.com/support/docs/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_validfail_onlinedocs" target="_blank">Online Documentation</a> <br/>
		</div>
	</div> <br/><br/>
<?php else : ?>
    <br/><br/><br/>
    <br/><br/><br/>
    <div class="dupx-footer-buttons">
        <button id="s1-deploy-btn" type="button" class="default-btn" onclick="DUPX.runExtraction()" title="<?php echo $agree_msg; ?>"> Next </button>
    </div>
<?php endif; ?>

</form>



<!-- =========================================
VIEW: STEP 1 - AJAX RESULT
Auto Posts to view.step2.php
========================================= -->
<form id='s1-result-form' method="post" class="content-form" style="display:none">

	 <div class="dupx-logfile-link"><a href="installer-log.txt" target="install_log">installer-log.txt</a></div>
	<div class="hdr-main">
        Step <span class="step">1</span> of 4: Deployment
	</div>

	<!--  POST PARAMS -->
	<div class="dupx-debug">
		<input type="hidden" name="action_step" value="2" />
		<input type="hidden" name="secure-pass" value="<?php echo $_POST['secure-pass']; ?>" />
		<input type="hidden" name="archive_name" value="<?php echo $GLOBALS['FW_PACKAGE_NAME'] ?>" />
		<input type="hidden" name="logging" id="ajax-logging"  />
                <input type="hidden" name="exe_safe_mode" id="exe-safe-mode"  value="0" />
		<input type="hidden" name="retain_config" id="ajax-retain-config"  />
		<input type="hidden" name="json"    id="ajax-json" />
		<textarea id='ajax-json-debug' name='json_debug_view'></textarea>
		<input type='submit' value='manual submit'>
	</div>

	<!--  PROGRESS BAR -->
	<div id="progress-area">
	    <div style="width:500px; margin:auto">
		<h3>Running Deployment Processes Please Wait...</h3>
		<div id="progress-bar"></div>
		<i>This may take several minutes</i>
	    </div>
	</div>

	<!--  AJAX SYSTEM ERROR -->
	<div id="ajaxerr-area" style="display:none">
	    <p>Please try again an issue has occurred.</p>
	    <div style="padding: 0px 10px 10px 0px;">
			<div id="ajaxerr-data">An unknown issue has occurred with the file and database set up process.  Please see the installer-log.txt file for more details.</div>
			<div style="text-align:center; margin:10px auto 0px auto">
				<input type="button" class="default-btn" onclick="DUPX.hideErrorResult()" value="&laquo; Try Again" /><br/><br/>
				<i style='font-size:11px'>See online help for more details at <a href='https://snapcreek.com/ticket?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_ajaxerr_ticket' target='_blank'>snapcreek.com</a></i>
			</div>
	    </div>
	</div>
</form>

<script>
    DUPX.getManaualArchiveOpt = function ()
    {
        $("html, body").animate({scrollTop: $(document).height()}, 1500);
        $("a[data-target='#s1-area-adv-opts']").find('i').removeClass('dupx-plus-square').addClass('dupx-minus-square');
        $('#s1-area-adv-opts').show(1000);
        $('select#archive_engine').val('manual').focus();
    };

	/** Performs Ajax post to extract files and create db
	 * Timeout (10000000 = 166 minutes) */
	DUPX.runExtraction = function()
	{
		var $form = $('#s1-input-form');

		//1800000 = 30 minutes
		//If the extraction takes longer than 30 minutes then user
		//will probably want to do a manual extraction or even FTP
		$.ajax({
			type: "POST",
			timeout:1800000,
			dataType: "json",
			url: window.location.href,
			data: $form.serialize(),
			beforeSend: function() {
				DUPX.showProgressBar();
				$form.hide();
				$('#s1-result-form').show();
			},			
			success: function(data) {
				var dataJSON = JSON.stringify(data);
				$("#ajax-json-debug").val(dataJSON);
                if (typeof(data) != 'undefined' && data.pass == 1) {
					$("#ajax-logging").val($("input:radio[name=logging]:checked").val());
					 $("#ajax-retain-config").val($("#retain_config").is(":checked") ? 1 : 0);
                                         $("#exe-safe-mode").val($("#exe_safe_mode").val());
					$("#ajax-json").val(escape(dataJSON));
					<?php if (! $GLOBALS['DUPX_DEBUG']) : ?>
						setTimeout(function() {$('#s1-result-form').submit();}, 500);
					<?php endif; ?>
					$('#progress-area').fadeOut(1000);
				} else {
					$('#ajaxerr-data').html('Error Processing Step 1');
					DUPX.hideProgressBar();
				}
			},
			error: function(xhr) {
				var status  = "<b>Server Code:</b> "	+ xhr.status		+ "<br/>";
					status += "<b>Status:</b> "			+ xhr.statusText	+ "<br/>";
					status += "<b>Response:</b> "		+ xhr.responseText  + "";
					status += "<hr/><b>Additional Troubleshooting Tips:</b><br/>";
					status += "- Check the <a href='installer-log.txt' target='install_log'>installer-log.txt</a> file for warnings or errors.<br/>";
					status += "- Check the web server and PHP error logs. <br/>";
					status += "- For timeout issues visit the <a href='https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_ajaxextract_tofaq#faq-trouble-100-q' target='_blank'>Timeout FAQ Section</a><br/>";
				$('#ajaxerr-data').html(status);
				DUPX.hideProgressBar();
			}
		});	
		
	};

	/** Accetps Useage Warning */
	DUPX.acceptWarning = function()
    {
		if ($("#accept-warnings").is(':checked')) {
            $("#s1-deploy-btn").removeAttr("disabled");
			$("#s1-deploy-btn").removeAttr("title");
        } else {
            $("#s1-deploy-btn").attr("disabled", "true");
			$("#s1-deploy-btn").attr("title", "<?php echo $agree_msg; ?>");
        }
	}

	/** Server Terms Dialog*/
	DUPX.showNotices = function()
	{
		modal({
			type: 'alert',
			title: 'Terms and Notices',
			text: $('#dialog-server-notice').html()
		});
	}


	/** Go back on AJAX result view */
	DUPX.hideErrorResult = function()
    {
		$('#s1-result-form').hide();
		$('#s1-input-form').show(200);
	}

        DUPX.onSafeModeSwitch = function ()
        {
            var mode = $('#exe_safe_mode').val();
            if(mode == 0){
                $("#retain_config").removeAttr("disabled");
            }else if(mode == 1 || mode ==2){
                if($("#retain_config").is(':checked'))
                            $("#retain_config").removeAttr("checked");
                $("#retain_config").attr("disabled", true);
            }

            $('#exe-safe-mode').val(mode);
            console.log("mode set to"+mode);
        }
        
	//DOCUMENT LOAD
	$(document).ready(function()
    {
		DUPX.acceptWarning();
        $("*[data-type='toggle']").click(DUPX.toggleClick);
        <?php echo ($all_arc == 'Fail') 	? "$('#s1-area-archive-file-link').trigger('click');" 	: ""; ?>
		<?php echo (! $all_success)         ? "$('#s1-area-sys-setup-link').trigger('click');"      : ""; ?>
	})
</script>
 <?php
	break;
	case "2" :
	?> <?php
    $_POST['logging'] = isset($_POST['logging']) ? trim(DUPX_U::sanitize($_POST['logging'])) : 1;
    $_POST['exe_safe_mode'] = (isset($_POST['exe_safe_mode'])) ? DUPX_U::sanitize($_POST['exe_safe_mode']) : 0;
?>


<!-- =========================================
VIEW: STEP 2- INPUT -->
<form id='s2-input-form' method="post" class="content-form"  data-parsley-validate="true" data-parsley-excluded="input[type=hidden], [disabled], :hidden">
<input type="hidden" name="action_ajax" value="2" />
<input type="hidden" name="action_step" value="2" />
<input type="hidden" name="archive_name"  value="<?php echo $GLOBALS['FW_PACKAGE_NAME'] ?>" />
<input type="hidden" name="logging" id="logging" value="<?php echo $_POST['logging'] ?>" />
<input type="hidden" name="secure-pass" value="<?php echo $_POST['secure-pass']; ?>" />

    <div class="dupx-logfile-link"><a href="installer-log.txt?now=<?php echo $GLOBALS['NOW_DATE'] ?>" target="install_log">installer-log.txt</a></div>
	<div class="hdr-main">
        Step <span class="step">2</span> of 4: Install Database
	</div>

	<div class="s2-btngrp">
		<input id="s2-basic-btn" type="button" value="Basic" class="active" onclick="DUPX.togglePanels('basic')" />
		<input id="s2-cpnl-btn" type="button" value="cPanel" class="in-active" onclick="DUPX.togglePanels('cpanel')" />
	</div>


	<!-- =========================================
	BASIC PANEL -->
	<div id="s2-basic-pane">
		<div class="hdr-sub1" data-type="toggle" data-target="#s2-area-setup">
			<a href="javascript:void(0)"><i class="dupx-minus-square"></i> Setup</a>
		</div>
		<div id="s2-area-setup">
			<table class="dupx-opts">
				<tr>
					<td>Action:</td>
					<td>
						<select name="dbaction" id="dbaction">
							<option value="create">Create New Database</option>
							<option value="empty" selected="true">Connect and Remove All Data</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Host:</td>
					<td>
						<table class="s2-opts-dbhost">
							<tr>
								<td><input type="text" name="dbhost" id="dbhost" required="true" value="<?php echo htmlspecialchars($GLOBALS['FW_DBHOST']); ?>" placeholder="localhost" style="width:450px" /></td>
								<td style="vertical-align:top">
									<input id="s2-dbport-btn" type="button" onclick="DUPX.togglePort()" class="s2-small-btn" value="Port: <?php echo htmlspecialchars($GLOBALS['FW_DBPORT']); ?>" />
									<input name="dbport" id="dbport" type="text" style="width:80px; display:none" value="<?php echo htmlspecialchars($GLOBALS['FW_DBPORT']); ?>" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>Database:</td>
					<td>
						<input type="text" name="dbname" id="dbname"  required="true" value="<?php echo htmlspecialchars($GLOBALS['FW_DBNAME']); ?>"  placeholder="new or existing database name"  />
						 <div id="s2-warning-emptydb">
							 <label for="accept-warnings">Warning: The selected 'Action' above will remove <u>all data</u> from this database!</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>User:</td>
					<td><input type="text" name="dbuser" id="dbuser" required="true" value="<?php echo htmlspecialchars($GLOBALS['FW_DBUSER']); ?>" placeholder="valid database username" /></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="text" name="dbpass" id="dbpass" value="<?php echo htmlspecialchars($GLOBALS['FW_DBPASS']); ?>"  placeholder="valid database user password"   /></td>
				</tr>
			</table>
		</div>
	</div>


	<!-- =========================================
	C-PANEL PANEL -->
	<div id="s2-cpnl-pane">
		<div class="s2-gopro">
			<h2>cPanel Connectivity</h2>

			<?php if( DUPX_U::isURLActive($_SERVER['SERVER_NAME'], 2083) ): ?>
				<div class='s2-cpanel-login'>
					<b>Login to this server's cPanel</b><br/>
					<a href="https://<?php echo $_SERVER['SERVER_NAME'] ?>:2083" target="cpanel" style="color:#fff">[<?php echo $_SERVER['SERVER_NAME'] ?>:2083]</a>
				</div>
			<?php else : ?>
				<div class='s2-cpanel-off'>
					<b>This server does not appear to support cPanel!</b><br/>
					Consider <a href="https://snapcreek.com/wordpress-hosting/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=free_install_no_cpanel&utm_campaign=duplicator_pro" target="cpanel" style="color:#fff;font-weight:bold">upgrading</a> to a host that does.<br/>
				</div>
			<?php endif; ?>


			<div style="text-align: center; font-size: 14px">
                                Want <span style="font-style: italic;">even easier</span> installs?  
				<a target="_blank" href="https://snapcreek.com/duplicator/?utm_source=duplicator_free&amp;utm_medium=wordpress_plugin&amp;utm_content=free_install_step2&amp;utm_campaign=duplicator_pro"><b>Duplicator Pro</b></a>
                                 allows the following <b>right from the installer:</b>
			</div>
			<ul>
				<li>Directly login to cPanel</li>
				<li>Instantly create new databases &amp; users</li>
				<li>Preview and select existing databases  &amp; users</li>
			</ul>
			<small>
				Note: Hosts that support cPanel provide remote access to server resources, allowing operations such as direct database and user creation.
				Since the <a target="_blank" href="https://snapcreek.com/duplicator/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=free_install_cpanel_note&utm_campaign=duplicator_pro">Duplicator Pro</a>
			        installer can directly access cPanel, it dramatically speeds up your workflow.
				</small>
		</div>
	</div>

    <!-- =========================================
    DIALOG: DB CONNECTION CHECK  -->
    <div id="s2-dbconn">
        <div id="s2-dbconn-status" style="display:none">
            <div style="padding: 0px 10px 10px 10px;">
                <div id="s2-dbconn-test-msg" style="min-height:80px"></div>
            </div>
            <small><input type="button" onclick="$('#s2-dbconn-status').hide(500)" class="s2-small-btn" value="Hide Message" /></small>
        </div>
    </div>


    <br/>

    <!-- ====================================
    OPTIONS
    ==================================== -->
    <div class="hdr-sub1" data-type="toggle" data-target="#s2-area-adv-opts">
        <a  href="javascript:void(0)"><i class="dupx-plus-square"></i> Options</a>
    </div>
    <div id='s2-area-adv-opts' style="display:none">
		<div class="help-target"><a href="?help#help-s2" target="_blank">[help]</a></div>
		
		<table class="dupx-opts dupx-advopts">
			<tr>
				<td>Legacy:</td>
				<td><input type="checkbox" name="dbcollatefb" id="dbcollatefb" value="1" /> <label for="dbcollatefb">Apply legacy collation fallback support for unknown collations types</label></td>
			</tr>
			<tr>
				<td>Spacing:</td>
				<td colspan="2">
					<input type="checkbox" name="dbnbsp" id="dbnbsp" value="1" /> <label for="dbnbsp">Fix non-breaking space characters</label>
				</td>
			</tr>
			<tr>
				<td style="vertical-align:top">Mode:</td>
				<td colspan="2">
					<input type="radio" name="dbmysqlmode" id="dbmysqlmode_1" checked="true" value="DEFAULT"/> <label for="dbmysqlmode_1">Default</label> &nbsp;
					<input type="radio" name="dbmysqlmode" id="dbmysqlmode_2" value="DISABLE"/> <label for="dbmysqlmode_2">Disable</label> &nbsp;
					<input type="radio" name="dbmysqlmode" id="dbmysqlmode_3" value="CUSTOM"/> <label for="dbmysqlmode_3">Custom</label> &nbsp;
					<div id="dbmysqlmode_3_view" style="display:none; padding:5px">
						<input type="text" name="dbmysqlmode_opts" value="" /><br/>
						<small>Separate additional <a href="?help#help-mysql-mode" target="_blank">sql modes</a> with commas &amp; no spaces.<br/>
							Example: <i>NO_ENGINE_SUBSTITUTION,NO_ZERO_IN_DATE,...</i>.</small>
					</div>
				</td>
			</tr>
			<tr><td style="width:130px">Charset:</td><td><input type="text" name="dbcharset" id="dbcharset" value="<?php echo $_POST['dbcharset'] ?>" /> </td></tr>
			<tr><td>Collation:</td><td><input type="text" name="dbcollate" id="dbcollate" value="<?php echo $_POST['dbcollate'] ?>" /> </tr>
		</table>
    
    </div>
    <br/><br/><br/>
    <br/><br/><br/>

    <div class="dupx-footer-buttons">
        <input type="button" onclick="DUPX.testDatabase()" class="default-btn" value="Test Database" />
        <input id="dup-step2-deploy-btn" type="button" class="default-btn" value=" Next " onclick="DUPX.confirmDeployment()" />
    </div>

</form>


<!-- =========================================
VIEW: STEP 2 - AJAX RESULT
Auto Posts to view.step3.php
========================================= -->
<form id='s2-result-form' method="post" class="content-form" style="display:none">

    <div class="dupx-logfile-link"><a href="installer-log.txt" target="install_log">installer-log.txt</a></div>
	<div class="hdr-main">
        Step <span class="step">2</span> of 4: Install Database
	</div>

	<!--  POST PARAMS -->
	<div class="dupx-debug">
		<input type="hidden" name="secure-pass" value="<?php echo $_POST['secure-pass']; ?>" />
		<input type="hidden" name="action_step" value="3" />
		<input type="hidden" name="archive_name" value="<?php echo $GLOBALS['FW_PACKAGE_NAME'] ?>" />
		<input type="hidden" name="logging" id="ajax-logging"  />
		<input type="hidden" name="retain_config" value="<?php echo $_POST['retain_config']; ?>" />
        <input type="hidden" name="exe_safe_mode" id="exe-safe-mode"  value="<?php echo $_POST['exe_safe_mode']; ?>"/>
		<input type="hidden" name="dbhost" id="ajax-dbhost" />
		<input type="hidden" name="dbport" id="ajax-dbport" />
		<input type="hidden" name="dbuser" id="ajax-dbuser" />
		<input type="hidden" name="dbpass" id="ajax-dbpass" />
		<input type="hidden" name="dbname" id="ajax-dbname" />
		<input type="hidden" name="json"   id="ajax-json" />
		<input type="hidden" name="dbcharset" id="ajax-dbcharset" />
		<input type="hidden" name="dbcollate" id="ajax-dbcollate" />
		<br/>
		<input type='submit' value='manual submit'>
	</div>

	<!--  PROGRESS BAR -->
	<div id="progress-area">
	    <div style="width:500px; margin:auto">
		<h3>Installing Database Please Wait...</h3>
		<div id="progress-bar"></div>
		<i>This may take several minutes</i>
	    </div>
	</div>

	<!--  AJAX SYSTEM ERROR -->
	<div id="ajaxerr-area" style="display:none">
	    <p>Please try again an issue has occurred.</p>
	    <div style="padding: 0px 10px 10px 0px;">
			<div id="ajaxerr-data">An unknown issue has occurred with the file and database set up process.  Please see the installer-log.txt file for more details.</div>
			<div style="text-align:center; margin:10px auto 0px auto">
				<input type="button" class="default-btn" onclick='DUPX.hideErrorResult()' value="&laquo; Try Again" /><br/><br/>
				<i style='font-size:11px'>See online help for more details at <a href='https://snapcreek.com/ticket?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_ajaxstep2_ticket' target='_blank'>snapcreek.com</a></i>
			</div>
	    </div>
	</div>
</form>



<!-- CONFIRM DIALOG -->
<div id="dialog-confirm-content" style="display:none">
	<div style="padding:0 0 25px 0">
		<b>Run installer with these settings?</b>
	</div>

	<b>Database Settings:</b><br/>
	<table style="margin-left:20px">
		<tr>
			<td><b>Server:</b></td>
			<td><i id="dlg-dbhost"></i></td>
		</tr>
		<tr>
			<td><b>Name:</b></td>
			<td><i id="dlg-dbname"></i></td>
		</tr>
		<tr>
			<td><b>User:</b></td>
			<td><i id="dlg-dbuser"></i></td>
		</tr>
	</table>
	<br/><br/>

	<small> WARNING: Be sure these database parameters are correct! Entering the wrong information WILL overwrite an existing database.
	Make sure to have backups of all your data before proceeding.</small><br/>
</div>


<script>
/* Confirm Dialog to validate run */
DUPX.confirmDeployment = function()
{
	var $form = $('#s2-input-form');
	$form.parsley().validate();
	if (!$form.parsley().isValid()) {
		return;
	}

	$('#dlg-dbhost').html($("#dbhost").val());
	$('#dlg-dbname').html($("#dbname").val());
	$('#dlg-dbuser').html($("#dbuser").val());

	modal({
		type: 'confirm',
		title: 'Install Confirmation',
		text: $('#dialog-confirm-content').html(),
		callback: function(result)
		{
			if (result == true) {
				DUPX.runDeployment();
			}
		}
	});
}


/* Performs Ajax post to extract files and create db
 * Timeout (10000000 = 166 minutes) */
DUPX.runDeployment = function()
{
	var $form = $('#s2-input-form');
	var dbhost = $("#dbhost").val();
	var dbname = $("#dbname").val();
	var dbuser = $("#dbuser").val();

	$.ajax({
		type: "POST",
		timeout: 1800000,
		dataType: "json",
		url: window.location.href,
		data: $form.serialize(),
		beforeSend: function() {
			DUPX.showProgressBar();
			$form.hide();
			$('#s2-result-form').show();
		},
		success: function(data, textStatus, xhr){
			if (typeof(data) != 'undefined' && data.pass == 1) {
				$("#ajax-dbhost").val($("#dbhost").val());
				$("#ajax-dbport").val($("#dbport").val());
				$("#ajax-dbuser").val($("#dbuser").val());
				$("#ajax-dbpass").val($("#dbpass").val());
				$("#ajax-dbname").val($("#dbname").val());
				$("#ajax-dbcharset").val($("#dbcharset").val());
				$("#ajax-dbcollate").val($("#dbcollate").val());
				$("#ajax-logging").val($("#logging").val());
				$("#ajax-json").val(escape(JSON.stringify(data)));
				<?php if (! $GLOBALS['DUPX_DEBUG']) : ?>
					setTimeout(function() {$('#s2-result-form').submit();}, 500);
				<?php endif; ?>
				$('#progress-area').fadeOut(1000);
			} else {
				DUPX.hideProgressBar();
			}
		},
		error: function(xhr) {
			var status  = "<b>Server Code:</b> "	+ xhr.status		+ "<br/>";
			status += "<b>Status:</b> "				+ xhr.statusText	+ "<br/>";
			status += "<b>Response:</b> "			+ xhr.responseText  + "";
			status += "<hr/><b>Additional Troubleshooting Tips:</b><br/>";
			status += "- Check the <a href='installer-log.txt' target='install_log'>installer-log.txt</a> file for warnings or errors.<br/>";
			status += "- Check the web server and PHP error logs. <br/>";
			status += "- For timeout issues visit the <a href='https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_step2deploy_timout#faq-trouble-100-q' target='_blank'>Timeout FAQ Section</a><br/>";
			$('#ajaxerr-data').html(status);
			DUPX.hideProgressBar();
		}
	});

}

/**
 *  Toggles the cpanel Login area  */
DUPX.togglePanels = function (pane)
{
	$('#s2-basic-pane, #s2-cpnl-pane').hide();
	$('#s2-basic-btn, #s2-cpnl-btn').removeClass('active in-active');
	if (pane == 'basic') {
		$('#s2-basic-pane').show();
		$('#s2-basic-btn').addClass('active');
		$('#s2-cpnl-btn').addClass('in-active');
	} else {
		$('#s2-cpnl-pane').show(200);
		$('#s2-cpnl-btn').addClass('active');
		$('#s2-basic-btn').addClass('in-active');
	}
}


/** Go back on AJAX result view */
DUPX.hideErrorResult = function()
{
	$('#s2-result-form').hide();
	$('#s2-input-form').show(200);
}


/** Shows results of database connection
* Timeout (45000 = 45 secs) */
DUPX.testDatabase = function ()
{
	$.ajax({
		type: "POST",
		timeout: 45000,
		url: window.location.href + '?' + 'dbtest=1',
		data: $('#s2-input-form').serialize(),
		success: function(data){ $('#s2-dbconn-test-msg').html(data); },
		error:   function(data){ alert('An error occurred while testing the database connection!  Contact your server admin to make sure the connection inputs are correct!'); }
	});

	$('#s2-dbconn-test-msg').html("Attempting Connection.  Please wait...");
	$("#s2-dbconn-status").show(100);

}


DUPX.showDeleteWarning = function ()
{
	($('#dbaction').val() == 'empty')
		? $('#s2-warning-emptydb').show(200)
		: $('#s2-warning-emptydb').hide(200);
}


DUPX.togglePort = function ()
{
	$('#s2-dbport-btn').hide();
	$('#dbport').show();
}


//DOCUMENT LOAD
$(document).ready(function()
{
	$('#dup-s2-dialog-data').appendTo('#dup-s2-result-container');
	$("select#dbaction").click(DUPX.showDeleteWarning);
	DUPX.showDeleteWarning();

	//MySQL Mode
	$("input[name=dbmysqlmode]").click(function() {
		if ($(this).val() == 'CUSTOM') {
			$('#dbmysqlmode_3_view').show();
		} else {
			$('#dbmysqlmode_3_view').hide();
		}
	});

	if ($("input[name=dbmysqlmode]:checked").val() == 'CUSTOM') {
		$('#dbmysqlmode_3_view').show();
	}
	$("*[data-type='toggle']").click(DUPX.toggleClick);
});
</script>
 <?php
	break;
	case "3" :
	?> <?php
	$dbh = DUPX_DB::connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], $_POST['dbname'], $_POST['dbport']);

	$all_tables     = DUPX_DB::getTables($dbh);
	$active_plugins = DUPX_U::getActivePlugins($dbh);

	$old_path = $GLOBALS['FW_WPROOT'];
	$new_path = DUPX_U::setSafePath($GLOBALS['CURRENT_ROOT_PATH']);
	$new_path = ((strrpos($old_path, '/') + 1) == strlen($old_path)) ? DUPX_U::addSlash($new_path) : $new_path;
    $_POST['exe_safe_mode']	= isset($_POST['exe_safe_mode']) ? $_POST['exe_safe_mode'] : 0;
?>


<!-- =========================================
VIEW: STEP 3- INPUT -->
<form id='s3-input-form' method="post" class="content-form">

	<!--  POST PARAMS -->
	<input type="hidden" name="action_ajax"	 value="3" />
	<input type="hidden" name="action_step"	 value="3" />
	<input type="hidden" name="logging"		 value="<?php echo $_POST['logging'] ?>" />
	<input type="hidden" name="retain_config" value="<?php echo $_POST['retain_config']; ?>" />
	<input type="hidden" name="archive_name" value="<?php echo $_POST['archive_name'] ?>" />
	<input type="hidden" name="json"		 value="<?php echo $_POST['json']; ?>" />
	<input type="hidden" name="dbhost"		 value="<?php echo $_POST['dbhost'] ?>" />
	<input type="hidden" name="dbport"		 value="<?php echo $_POST['dbport'] ?>" />
	<input type="hidden" name="dbuser" 		 value="<?php echo $_POST['dbuser'] ?>" />
	<input type="hidden" name="dbpass" 		 value="<?php echo htmlentities($_POST['dbpass']) ?>" />
	<input type="hidden" name="dbname" 		 value="<?php echo $_POST['dbname'] ?>" />
	<input type="hidden" name="dbcharset" 	 value="<?php echo $_POST['dbcharset'] ?>" />
	<input type="hidden" name="dbcollate" 	 value="<?php echo $_POST['dbcollate'] ?>" />
	<input type="hidden" name="exe_safe_mode" id="exe-safe-mode" value="<?php echo $_POST['exe_safe_mode'] ?>" />
	<input type="hidden" name="secure-pass" value="<?php echo $_POST['secure-pass']; ?>" />

	<div class="dupx-logfile-link"><a href="installer-log.txt?now=<?php echo $GLOBALS['NOW_DATE'] ?>" target="install_log">installer-log.txt</a></div>
	<div class="hdr-main">
		Step <span class="step">3</span> of 4: Update Data
	</div>

	<!-- ====================================
    NEW SETTINGS
    ==================================== -->
	<div class="hdr-sub1" style="margin-top:8px" data-type="toggle" data-target="#s3-new-settings">
		<a href="javascript:void(0)"><i class="dupx-minus-square"></i> New Settings</a>
	</div>
	<div id='s3-new-settings'>
		<table class="s3-table-inputs">
			<tr>
				<td style="width:80px">URL:</td>
				<td>
					<input type="text" name="url_new" id="url_new" value="" />
					<a href="javascript:DUPX.getNewURL('url_new')" style="font-size:12px">get</a>
				</td>
			</tr>
			<tr>
				<td>Path:</td>
				<td><input type="text" name="path_new" id="path_new" value="<?php echo $new_path ?>" /></td>
			</tr>
			<tr>
				<td>Title:</td>
				<td><input type="text" name="blogname" id="blogname" value="<?php echo $GLOBALS['FW_BLOGNAME'] ?>" /></td>
			</tr>
		</table>
	</div>
	<br/><br/>

    <!-- ====================================
    OPTIONS
    ==================================== -->
    <div class="hdr-sub1" data-type="toggle" data-target="#s3-adv-opts">
        <a href="javascript:void(0)"><i class="dupx-plus-square"></i> Options</a>
    </div>
	<div id='s3-adv-opts' style="display:none;">
		<div class="help-target"><a href="?help#help-s3" target="_blank">[help]</a></div>
		<br/>

		<div class="hdr-sub3">New Admin Account</div>
		<div style="text-align: center; margin-top:7px">
			<i style="color:gray;font-size: 11px">This feature is optional.  If the username already exists the account will NOT be created or updated.</i>
		</div>
		<table class="s3-table-inputs">
			<tr>
				<td>Username:</td>
				<td><input type="text" name="wp_username" id="wp_username" value="" title="4 characters minimum" placeholder="(4 or more characters)" /></td>
			</tr>
			<tr>
				<td valign="top">Password:</td>
				<td><input type="text" name="wp_password" id="wp_password" value="" title="6 characters minimum"  placeholder="(6 or more characters)" /></td>
			</tr>
		</table>
		<br/><br/>

		<div class="hdr-sub3">Scan Options</div>
        <table class="s3-table-inputs">
			<tr>
				<td>Site URL:</td>
				<td>
					<input type="text" name="siteurl" id="siteurl" value="" />
					<a href="javascript:DUPX.getNewURL('siteurl')" style="font-size:12px">get</a><br/>
				</td>
			</tr> 
            <tr>
                <td>Old URL:</td>
                <td>
                    <input type="text" name="url_old" id="url_old" value="<?php echo $GLOBALS['FW_URL_OLD'] ?>" readonly="readonly"  class="readonly" />
                    <a href="javascript:DUPX.editOldURL()" id="edit_url_old" style="font-size:12px">edit</a>
                </td>
            </tr>
            <tr>
                <td>Old Path:</td>
                <td>
                    <input type="text" name="path_old" id="path_old" value="<?php echo $old_path ?>" readonly="readonly"  class="readonly" />
                    <a href="javascript:DUPX.editOldPath()" id="edit_path_old" style="font-size:12px">edit</a>
                </td>
            </tr>
        </table><br/>
        
		<table>
			<tr>
				<td style="padding-right:10px">
                    <b>Scan Tables:</b>
					<div class="s3-allnonelinks">
						<a href="javascript:void(0)" onclick="$('#tables option').prop('selected',true);">[All]</a>
						<a href="javascript:void(0)" onclick="$('#tables option').prop('selected',false);">[None]</a>
					</div><br style="clear:both" />
					<select id="tables" name="tables[]" multiple="multiple">
						<?php
							foreach( $all_tables as $table ) {
								echo '<option selected="selected" value="' . DUPX_U::escapeHTML( $table ) . '">' . $table . '</option>';
							}
						?>
					</select>
				</td>
				<td valign="top">
                    <b>Activate Plugins:</b>
					<?php echo ($_POST['exe_safe_mode'] > 0) ? '<small class="s3-warn">Safe Mode Enabled</small>' : '' ; ?>
					<div class="s3-allnonelinks"  style="<?php echo  ($_POST['exe_safe_mode']>0)? 'display:none':''; ?>">
						<a href="javascript:void(0)" onclick="$('#plugins option').prop('selected',true);">[All]</a>
						<a href="javascript:void(0)" onclick="$('#plugins option').prop('selected',false);">[None]</a>
					</div><br style="clear:both" />
					<select id="plugins" name="plugins[]" multiple="multiple" <?php echo ($_POST['exe_safe_mode'] > 0) ? 'disabled="disabled"' : ''; ?>>
						<?php
							$selected_string = ($_POST['exe_safe_mode'] > 0) ? '' : 'selected="selected"';
							foreach ($active_plugins as $plugin) {
								$plug_val  = DUPX_U::escapeHTML($plugin);
								$plug_name = dirname($plugin);
								echo "<option {$selected_string} value='{$plug_val}'>{$plug_name}</option>";
							}
						?>
					</select>
				</td>
			</tr>
		</table>
		<br/>

		<input type="checkbox" name="fullsearch" id="fullsearch" value="1" /> <label for="fullsearch">Use Database Full Search Mode </label><br/>
		<input type="checkbox" name="postguid" id="postguid" value="1" /> <label for="postguid">Keep Post GUID Unchanged</label><br/>
		<br/><br/>
		
		<!-- WP-CONFIG -->
		<div class="hdr-sub3">WP-Config File</div>
		<table class="dupx-opts dupx-advopts">
			<tr>
				<td>Cache:</td>
				<td style="width:125px"><input type="checkbox" name="cache_wp" id="cache_wp" /> <label for="cache_wp">Keep Enabled</label></td>
				<td><input type="checkbox" name="cache_path" id="cache_path" /> <label for="cache_path">Keep Home Path</label></td>
			</tr>
			<tr>
				<td>SSL:</td>
				<td><input type="checkbox" name="ssl_admin" id="ssl_admin" /> <label for="ssl_admin">Enforce on Admin</label></td>
				<td></td>
			</tr>
		</table>
		<br/><br/><br/>
		<br/><br/>
	</div>

	<div class="dupx-footer-buttons">
		<input id="dup-step3-next"  class="default-btn" type="button" value=" Next " onclick="DUPX.runUpdate()"  />
	</div>
</form>


<!-- =========================================
VIEW: STEP 3 - AJAX RESULT 
========================================= -->
<form id='s3-result-form' method="post" class="content-form" style="display:none">

	<div class="dupx-logfile-link"><a href="installer-log.txt" target="install_log">installer-log.txt</a></div>
	<div class="hdr-main">
		Step <span class="step">3</span> of 4: Update Data
	</div>

	<!--  POST PARAMS -->
	<div class="dupx-debug">
		<input type="hidden" name="secure-pass" value="<?php echo $_POST['secure-pass']; ?>" />
		<input type="hidden" name="action_step"  value="4" />
		<input type="hidden" name="archive_name" value="<?php echo $_POST['archive_name'] ?>" />
		<input type="hidden" name="retain_config" value="<?php echo $_POST['retain_config']; ?>" />
                <input type="hidden" name="exe_safe_mode" id="exe-safe-mode"  value="<?php echo $_POST['exe_safe_mode']; ?>"/>
		<input type="hidden" name="url_new" id="ajax-url_new"  />
		<input type="hidden" name="json"    id="ajax-json" />
		<br/>
		<input type='submit' value='manual submit'>
	</div>

	<!--  PROGRESS BAR -->
	<div id="progress-area">
		<div style="width:500px; margin:auto">
			<h3>Updating Data Replacements Please Wait...</h3>
			<div id="progress-bar"></div>
			<i>This may take several minutes</i>
		</div>
	</div>

	<!--  AJAX SYSTEM ERROR -->
	<div id="ajaxerr-area" style="display:none">
		<p>Please try again an issue has occurred.</p>
		<div style="padding: 0px 10px 10px 10px;">
			<div id="ajaxerr-data">An unknown issue has occurred with the update data set up process.  Please see the installer-log.txt file for more details.</div>
			<div style="text-align:center; margin:10px auto 0px auto">
				<input type="button"  class="default-btn" onclick='DUPX.hideErrorResult2()' value="&laquo; Try Again" /><br/><br/>
				<i style='font-size:11px'>See online help for more details at <a href='https://snapcreek.com/ticket?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_step3_ajax' target='_blank'>snapcreek.com</a></i>
			</div>
		</div>
	</div>
</form>

<script>
/** 
* Timeout (10000000 = 166 minutes) */
DUPX.runUpdate = function()
{
	//Validation
	var wp_username = $.trim($("#wp_username").val()).length || 0;
	var wp_password = $.trim($("#wp_password").val()).length || 0;

	if ( $.trim($("#url_new").val()) == "" )  {alert("The 'New URL' field is required!"); return false;}
	if ( $.trim($("#siteurl").val()) == "" )  {alert("The 'Site URL' field is required!"); return false;}
	if (wp_username >= 1 && wp_username < 4) {alert("The New Admin Account 'Username' must be four or more characters"); return false;}
	if (wp_username >= 4 && wp_password < 6) {alert("The New Admin Account 'Password' must be six or more characters"); return false;}

	$.ajax({
		type: "POST",
		timeout: 1800000,
		dataType: "json",
		url: window.location.href,
		data: $('#s3-input-form').serialize(),
		beforeSend: function() {
			DUPX.showProgressBar();
			$('#s3-input-form').hide();
			$('#s3-result-form').show();
		},
		success: function(data){
			if (typeof(data) != 'undefined' && data.step3.pass == 1) {
				$("#ajax-url_new").val($("#url_new").val());
				$("#ajax-json").val(escape(JSON.stringify(data)));
				<?php if (! $GLOBALS['DUPX_DEBUG']) : ?>
					setTimeout(function(){$('#s3-result-form').submit();}, 500);
				<?php endif; ?>
				$('#progress-area').fadeOut(1000);
			} else {
				DUPX.hideProgressBar();
			}
		},
		error: function(xhr) {
			var status  = "<b>Server Code:</b> "	+ xhr.status		+ "<br/>";
			status += "<b>Status:</b> "				+ xhr.statusText	+ "<br/>";
			status += "<b>Response:</b> "			+ xhr.responseText  + "";
			status += "<hr/><b>Additional Troubleshooting Tips:</b><br/>";
			status += "- Check the <a href='installer-log.txt' target='install_log'>installer-log.txt</a> file for warnings or errors.<br/>";
			status += "- Check the web server and PHP error logs. <br/>";
			status += "- For timeout issues visit the <a href='https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_step3_ajax_rundepl#faq-trouble-100-q' target='_blank'>Timeout FAQ Section</a><br/>";
			$('#ajaxerr-data').html(status);
			DUPX.hideProgressBar();
		}
	});
}

/** Returns the windows active url */
DUPX.getNewURL = function(id)
{
	var filename= window.location.pathname.split('/').pop() || 'installer.php' ;
	var path = window.location.href.replace(filename, '').replace(/\/$/, '');
	$("#" + id).val(path);
}

/** Allows user to edit the package url  */
DUPX.editOldURL = function()
{
	var msg = 'This is the URL that was generated when the package was created.\n';
	msg += 'Changing this value may cause issues with the install process.\n\n';
	msg += 'Only modify  this value if you know exactly what the value should be.\n';
	msg += 'See "General Settings" in the WordPress Administrator for more details.\n\n';
	msg += 'Are you sure you want to continue?';

	if (confirm(msg)) {
		$("#url_old").removeAttr('readonly');
		$("#url_old").removeClass('readonly');
		$('#edit_url_old').hide('slow');
	}
}

/** Allows user to edit the package path  */
DUPX.editOldPath = function()
{
	var msg = 'This is the SERVER URL that was generated when the package was created.\n';
	msg += 'Changing this value may cause issues with the install process.\n\n';
	msg += 'Only modify  this value if you know exactly what the value should be.\n';
	msg += 'Are you sure you want to continue?';

	if (confirm(msg)) {
		$("#path_old").removeAttr('readonly');
		$("#path_old").removeClass('readonly');
		$('#edit_path_old').hide('slow');
	}
}

/** Go back on AJAX result view */
DUPX.hideErrorResult2 = function()
{
	$('#s3-result-form').hide();
	$('#s3-input-form').show(200);
}

//DOCUMENT LOAD
$(document).ready(function()
{
	DUPX.getNewURL('url_new');
	DUPX.getNewURL('siteurl');
	$("*[data-type='toggle']").click(DUPX.toggleClick);
	$("#wp_password").passStrength({
			shortPass: 		"top_shortPass",
			badPass:		"top_badPass",
			goodPass:		"top_goodPass",
			strongPass:		"top_strongPass",
			baseStyle:		"top_testresult",
			userid:			"#wp_username",
			messageloc:		1	});
});
</script> <?php
	break;
	case "4" :
	?> <?php

	$_POST['url_new']	    = isset($_POST['url_new'])      ? DUPX_U::sanitize($_POST['url_new']) : '';
	$_POST['archive_name']  = isset($_POST['archive_name']) ? $_POST['archive_name'] : '';
	$_POST['retain_config'] = isset($_POST['retain_config']) && $_POST['retain_config'] == '1' ? true : false;
    $_POST['exe_safe_mode']	= isset($_POST['exe_safe_mode']) ? $_POST['exe_safe_mode'] : 0;
        
	$admin_base		= basename($GLOBALS['FW_WPLOGIN_URL']);

    $safe_mode	= $_POST['exe_safe_mode'];
	$admin_redirect = rtrim($_POST['url_new'], "/") . "/wp-admin/admin.php?page=duplicator-tools&tab=diagnostics&section=info&package={$_POST['archive_name']}&safe_mode={$safe_mode}";
	$admin_redirect = urlencode($admin_redirect);
	$admin_url_qry  = (strpos($admin_base, '?') === false) ? '?' : '&';
	$admin_login	= rtrim($_POST['url_new'], '/') . "/{$admin_base}{$admin_url_qry}redirect_to={$admin_redirect}";
	$url_new_rtrim  = rtrim($_POST['url_new'], '/');

?>

<script>
	/** Posts to page to remove install files */
	DUPX.getAdminLogin = function() {
		window.open('<?php echo $admin_login; ?>', 'wp-admin');
	};
</script>


<!-- =========================================
VIEW: STEP 4 - INPUT -->
<form id='s4-input-form' method="post" class="content-form" style="line-height:20px">
	<input type="hidden" name="url_new" id="url_new" value="<?php echo $url_new_rtrim; ?>" />
	<div class="dupx-logfile-link"><a href="installer-log.txt?now=<?php echo $GLOBALS['NOW_DATE'] ?>" target="install_log">installer-log.txt</a></div>

	<div class="hdr-main">
        Step <span class="step">4</span> of 4: Test Site
	</div><br />

	<table class="s4-final-step">
		<tr style="vertical-align:top">
			<td><a class="s4-final-btns" href="javascript:void(0)" onclick="DUPX.getAdminLogin()">Site Login</a></td>
			<td>
				<i>Login to finalize the setup</i>
				<?php if ($_POST['retain_config']) :?>
					<br/> <i>Update of Permalinks required see: Admin &gt; Settings &gt; Permalinks &gt; Save</i>
				<?php endif;?>
				<br/><br/>

				<!-- WARN: SAFE MODE MESSAGES -->
				<div class="s4-warn" style="display:<?php echo ($safe_mode > 0 ? 'block' : 'none')?>">
					<b>Safe Mode</b><br/>
					Safe mode has <u>deactivated</u> all plugins. Please be sure to enable your plugins after logging in. <i>If you notice that problems arise when activating
					the plugins then active them one-by-one to isolate the plugin that	could be causing the issue.</i>
				</div>
			</td>
		</tr>
		<tr>
			<td><a class="s4-final-btns" href="javascript:void(0)" onclick="$('#dup-step3-install-report').toggle(400)">Show Report</a></td>
			<td>
				<i>Optionally review the migration report</i><br/>
				<i id="dup-step3-install-report-count">
					<span data-bind="with: status.step2">Install Notices: (<span data-bind="text: query_errs"></span>)</span> &nbsp;
					<span data-bind="with: status.step3">Update Notices: (<span data-bind="text: err_all"></span>)</span> &nbsp; &nbsp;
					<span data-bind="with: status.step3" style="color:#888"><b>General Notices:</b> (<span data-bind="text: warn_all"></span>)</span>
				</i>
			</td>
		</tr>
	</table>
	<br/><br/>

	<div class="s4-go-back">
		Final Steps:
		<ul style="margin-top: 1px">
			<li>
				Review the <a href="<?php echo $url_new_rtrim; ?>" target="_blank">front-end</a> or
				re-run installer at <a href="<?php echo "{$url_new_rtrim}/installer.php"; ?>">step 1</a>
			</li>
			<li>Finalize installation by logging into the WordPress Admin Login and removing installation files</li>
		</ul>
		
		Additional Notes:
		<ul style="margin-top: 1px">
			<li>The .htaccess file was reset.  Resave plugins that write to this file.</li>
			<li>
				Visit the <a href="installer.php?help=1#troubleshoot" target="_blank">troubleshoot</a> section or
				<a href='https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst4_step4_troubleshoot' target='_blank'>online FAQs</a> for additional help.
			</li>
		</ul>
	</div>

	<!-- ========================
	INSTALL REPORT -->
	<div id="dup-step3-install-report" style='display:none'>
		<table class='s4-report-results' style="width:100%">
			<tr><th colspan="4">Database Report</th></tr>
			<tr style="font-weight:bold">
				<td style="width:150px"></td>
				<td>Tables</td>
				<td>Rows</td>
				<td>Cells</td>
			</tr>
			<tr data-bind="with: status.step2">
				<td>Created</td>
				<td><span data-bind="text: table_count"></span></td>
				<td><span data-bind="text: table_rows"></span></td>
				<td>n/a</td>
			</tr>
			<tr data-bind="with: status.step3">
				<td>Scanned</td>
				<td><span data-bind="text: scan_tables"></span></td>
				<td><span data-bind="text: scan_rows"></span></td>
				<td><span data-bind="text: scan_cells"></span></td>
			</tr>
			<tr data-bind="with: status.step3">
				<td>Updated</td>
				<td><span data-bind="text: updt_tables"></span></td>
				<td><span data-bind="text: updt_rows"></span></td>
				<td><span data-bind="text: updt_cells"></span></td>
			</tr>
		</table>
		<br/>

		<table class='s4-report-errs' style="width:100%; border-top:none">
			<tr><th colspan="4">Report Notices</th></tr>
			<tr>
				<td data-bind="with: status.step2">
					<a href="javascript:void(0);" onclick="$('#dup-step3-errs-create').toggle(400)">Step 2: Install Notices (<span data-bind="text: query_errs"></span>)</a><br/>
				</td>
				<td data-bind="with: status.step3">
					<a href="javascript:void(0);" onclick="$('#dup-step3-errs-upd').toggle(400)">Step 3: Update Notices (<span data-bind="text: err_all"></span>)</a>
				</td>
				<td data-bind="with: status.step3">
					<a href="#dup-step3-errs-warn-anchor" onclick="$('#dup-step3-warnlist').toggle(400)">General Notices (<span data-bind="text: warn_all"></span>)</a>
				</td>
			</tr>
			<tr><td colspan="4"></td></tr>
		</table>

		<div id="dup-step3-errs-create" class="s4-err-msg">
			<div class="s4-err-title">STEP 2 - INSTALL NOTICES:</div>
			<b data-bind="with: status.step2">ERRORS (<span data-bind="text: query_errs"></span>)</b><br/>
			<div class="info-error">
				Queries that error during the deploy step are logged to the <a href="installer-log.txt" target="dpro-installer">install-log.txt</a> file and
				and marked with an **ERROR** status.   If you experience a few errors (under 5), in many cases they can be ignored as long as your site is working correctly.
				However if you see a large amount of errors or you experience an issue with your site then the error messages in the log file will need to be investigated.
				<br/><br/>

				<b>COMMON FIXES:</b>
				<ul>
					<li>
						<b>Unknown collation:</b> See Online FAQ:
						<a href="https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst_step4_unknowncoll#faq-installer-110-q" target="_blank">What is Compatibility mode & 'Unknown collation' errors?</a>
					</li>
					<li>
						<b>Query Limits:</b> Update MySQL server with the <a href="https://dev.mysql.com/doc/refman/5.5/en/packet-too-large.html" target="_blank">max_allowed_packet</a>
						setting for larger payloads.
					</li>
				</ul>
				
			</div>
		</div>

		<div id="dup-step3-errs-upd" class="s4-err-msg">
			<div class="s4-err-title">STEP 3 - UPDATE NOTICES:</div>
			<!-- MYSQL QUERY ERRORS -->
			<b data-bind="with: status.step3">ERRORS (<span data-bind="text: errsql_sum"></span>) </b><br/>
			<div class="info-error">
				Update errors that show here are queries that could not be performed because the database server being used has issues running it.  Please validate the query, if
				it looks to be of concern please try to run the query manually.  In many cases if your site performs well without any issues you can ignore the error.
			</div>
			<div class="content">
				<div data-bind="foreach: status.step3.errsql"><div data-bind="text: $data"></div></div>
				<div data-bind="visible: status.step3.errsql.length == 0">No MySQL query errors found</div>
			</div>
			<br/>

			<!-- TABLE KEY ERRORS -->
			<b data-bind="with: status.step3">TABLE KEY NOTICES (<span data-bind="text: errkey_sum"></span>)</b><br/>
			<div class="info-notice">
				Notices should be ignored unless issues are found after you have tested an installed site. This notice indicates that a primary key is required to run the
				update engine. Below is a list of tables and the rows that were not updated.  On some databases you can remove these notices by checking the box 'Enable Full Search'
				under advanced options in step3 of the installer.
				<br/><br/>
				<small>
					<b>Advanced Searching:</b><br/>
					Use the following query to locate the table that was not updated: <br/>
					<i>SELECT @row := @row + 1 as row, t.* FROM some_table t, (SELECT @row := 0) r</i>
				</small>
			</div>
			<div class="content">
				<div data-bind="foreach: status.step3.errkey"><div data-bind="text: $data"></div></div>
				<div data-bind="visible: status.step3.errkey.length == 0">No missing primary key errors</div>
			</div>
			<br/>

			<!-- SERIALIZE ERRORS -->
			<b data-bind="with: status.step3">SERIALIZATION NOTICES  (<span data-bind="text: errser_sum"></span>)</b><br/>
			<div class="info-notice">
				Notices should be ignored unless issues are found after you have tested an installed site.  The SQL below will show data that may have not been
				updated during the serialization process.  Best practices for serialization notices is to just re-save the plugin/post/page in question.
			</div>
			<div class="content">
				<div data-bind="foreach: status.step3.errser"><div data-bind="text: $data"></div></div>
				<div data-bind="visible: status.step3.errser.length == 0">No serialization errors found</div>
			</div>
			<br/>

		</div>


		<!-- WARNINGS-->
		<div id="dup-step3-warnlist" class="s4-err-msg">
			<a href="#" id="dup-step3-errs-warn-anchor"></a>
			<b>GENERAL NOTICES</b><br/>
			<div class="info">
				The following is a list of notices that may need to be fixed in order to finalize your setup.  These values should only be investigated if your running into
				issues with your site. For more details see the <a href="https://codex.wordpress.org/Editing_wp-config.php" target="_blank">WordPress Codex</a>.
			</div>
			<div class="content">
				<div data-bind="foreach: status.step3.warnlist">
					 <div data-bind="text: $data"></div>
				</div>
				<div data-bind="visible: status.step3.warnlist.length == 0">
					No notices found
				</div>
			</div>
		</div><br/>

	</div><br/>

	<?php
		$num = rand(1,2);
		switch ($num) {
			case 1:
				$key = 'free_inst_s3btn1';
				$txt = 'Want More Power?';
				break;
			case 2:
				$key = 'free_inst_s3btn2';
				$txt = 'Go Pro Today!';
				break;
			default :
				$key = 'free_inst_s3btn2';
				$txt = 'Go Pro Today!';
		}
	?>

	<div class="s4-gopro-btn">
		<a href="https://snapcreek.com/duplicator/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=duplicator_pro&utm_content=<?php echo $key;?>" target="_blank"> 
			<?php echo $txt;?>
		</a>
	</div>
	<br/><br/><br/>
</form>

<?php
	//Sanitize
	$json_result = true;
	$json_data   = utf8_decode(urldecode($_POST['json']));
	$json_decode = json_decode($json_data);
	if ($json_decode == NULL || $json_decode == FALSE) {
		$json_data  = "{'json reset invalid form value sent'}";
		$json_result = false;
	}
?>

<script>
<?php if ($json_result) : ?>
	MyViewModel = function() {
		this.status = <?php echo $json_data; ?>;
		var errorCount =  this.status.step2.query_errs || 0;
		(errorCount >= 1 )
			? $('#dup-step3-install-report-count').css('color', '#BE2323')
			: $('#dup-step3-install-report-count').css('color', '#197713');
	};
	ko.applyBindings(new MyViewModel());
<?php else: ?>
	console.log("Cross site script attempt detected, unable to create final report!");
<?php endif; ?>
</script>
 <?php
	break;
}
} else {
	?> <?php
	//The help for both pro and lite are shared.  Pro is where the master lives.  Use the flag below to
    //indicate if this help lives in lite or pro
	$pro_version = false;
?>
<!-- =========================================
HELP FORM -->
<div id="main-help">
<div class="help-online"><br/>
	<i class="fa fa-file-text-o"></i> For complete help visit the
	<a href="https://snapcreek.com/support/docs/" target="_blank">Online Knowledge-Base</a> <br/>
	<small>Features available only in Duplicator Pro are flagged with a <sup>pro</sup> tag.</small>
</div>

<h2>Installer Security</h2>
<a name="help-s1-init"></a>
<div id="dup-help-installer" class="help-page">
    The installer security screen will allow for basic password protection on the installer. The password is set at package creation time.  The password
	input on this screen must be entered before proceeding with an install.   This setting is optional and can be turned on/off via the package creation screens.
    <br/><br/>

    If you do not recall the password then login to the site where the package was created and click the details of the package to view the original password.
    To validate the password just typed you can toggle the view by clicking on the lock icon.	For detail on how to override this setting visit the online FAQ for
	<a href="https://snapcreek.com/duplicator/docs/faqs-tech/#faq-installer-030-q" target="_blank">more details</a>.

	<table class="help-opt">
		<tr>
			<th>Option</th>
			<th>Details</th>
		</tr>
		<tr>
			<td>Locked</td>
			<td>
				"Locked" means a password is protecting each step of the installer.  This option is recommended on all installers
				that are accessible via a public URL but not required.
			</td>
		</tr>
		<tr>
			<td>Unlocked</td>
			<td>
				"Unlocked" means that if your installer is on a public server that anyone can access it.  This is a less secure way to run your installer. If you are running the
				installer very quickly then removing all the installer files, then the chances of exposing it is going to be low depending	on your sites access history.
				<br/><br/>

				While it is not required to	have a password set it is recommended.  If your URL has little to no traffic or has never been the target of an attack
				then running the installer without a password is going to be relatively safe if ran quickly.  However, a password is always a good idea.  Also, it is
				absolutely required and recommended to remove <u>all</u> installer files after installation is completed by logging into the WordPress admin and
				following the Duplicator prompts.
			</td>
		</tr>
	</table>
</div>

<!-- ============================================
STEP 1
============================================== -->
<a class="help-target" name="help-s1"></a>
<h2>Step <span class="step">1</span> of 4: Deployment</h2>
<div id="dup-help-scanner" class="help-page">
	There are currently several modes that the installer can be in.  The mode will be shown at the top of each screen. Below is an overview of the various modes.

	<table class="help-opt">
	<tr>
		<th>Option</th>
		<th>Details</th>
	</tr>
	<tr>
		<td>Standard Install</td>
		<td>
			This mode indicates that the installer and archive have been placed into an empty directory and the site is ready for a fresh/new redeployment.
			This is the most common mode and the mode that has been around the longest.
		</td>
	</tr>
	<tr>
		<td>Standard Install <br/> Database Only</td>
		<td>
			This mode indicates that the installer and archive were manually moved or transferred to a location and that only the Database will be installed
			at this location.
		</td>
	</tr>
	<?php if ($pro_version) : ?>
		<tr>
			<td>Overwrite Install</td>
			<td>
				This mode indicates that the installer was started in a location that contains an existing site -or- the archive file was imported into an existing site using
				Duplicator Pro on the destination site (see Duplicator Pro &gt; Tools &gt; Import). In both cases <b>the existing site will be overwritten.</b>
			</td>
		</tr>
		<tr>
			<td>Overwrite Install <br/> Database Only</td>
			<td>
				This mode indicates that the installer was started in a location that contains an existing site -or- the archive file was imported into an existing site using
				Duplicator Pro on the destination site (see Duplicator Pro &gt; Tools &gt; Import).  In both cases <b>the existing site's database will be overwritten.</b>
			</td>
		</tr>
	<?php endif; ?>
	</table>
	<br/><br/>


    The "Extract Archive" screen is separated into four sections:
	<br/><br/>

	<h3>Archive</h3>
	This is the archive file the installer must use in order to extract the web site files and database.   The 'Name' is a unique key that
	ties both the archive and installer together.   The installer needs the archive file name to match the 'Name' value exactly character for character in order
	for	this section to get a pass status.
	<br/><br/>
	If the archive name	is ever changed then it should be renamed back to the 'Name' value in order for the installer to properly identify it as part of a
	complete package.  Additional information such as the archive size and the package notes are mentioned in this section.
	<br/><br/>

	<h3>Validation</h3>
	This section shows the installers system requirements and notices.  All requirements must pass in order to proceed to Step 2.  Each requirement will show
	a <b class="dupx-pass">Pass</b>/<b class="dupx-fail">Fail</b> status.  Notices on the other hand are <u>not</u> required in order to continue with the install.
	<br/><br/>

	Notices are simply checks that will help you identify any possible issues that might occur.  If this section shows a
	<b class="dupx-pass">Good</b>/<b class="dupx-fail">Warn</b> for various checks. 	Click on the title link and	read the overview for how to solve the test.
	<br/><br/>

	<h3>Multisite <sup>pro</sup></h3>
	The multisite option allows users with a Pro Business or Gold license to perform additional multi-site tasks.  All licenses can backup & migrate standalone sites
	and full multisite networks. Multisite Plus+ (business and above) adds the  ability to install a subsite as a standalone site.
	<br/><br/>

	<h3>Options</h3>
	The options for step 1 can help better prepare your site should your server need additional settings beyond most general configuration.
	<table class="help-opt">
		<tr>
			<th>Option</th>
			<th>Details</th>
		</tr>
		<tr>
			<td colspan="2" class="section">General Options</td>
		</tr>
		<tr>
			<td>Extraction</td>
			<td>
				<b>Manual Archive Extraction</b><br/>
				Set the Extraction value to "Manual Archive Extraction" when the archive file has already been manually extracted on the server.  This can be done through your hosts
				control panel such as cPanel or by your host directly. This setting can be helpful if you have a large archive files or are having issues with the installer extracting
				the file due to timeout issues.
				<br/><br/>

				<b>PHP ZipArchive</b><br/>
				This extraction method will use the PHP <a href="http://php.net/manual/en/book.zip.php" target="_blank">ZipArchive</a> code to extract the archive zip file.
				<br/><br/>

				<b>Shell-Exec Unzip</b><br/>
				This extraction method will use the PHP <a href="http://php.net/manual/en/function.shell-exec.php" target="_blank">shell_exec</a> to call the system unzip
				command on the server.  This is the default mode that is used if its avail on the server.
				<br/><br/>

			</td>
		</tr>
		<tr>
			<td>Permissions</td>
			<td>
				<b>All Files:</b> Check the 'All Files' check-box and enter in the desired <a href="http://php.net/manual/en/function.chmod.php" target="_blank">chmod command</a>
				to recursively set the octal value on all the files being extracted. Typically this value is 644 on most servers and hosts.
				<br/><br/>

				<b>All Directories:</b> Check the 'All Directories' check-box and enter in the desired <a href="http://php.net/manual/en/function.chmod.php" target="_blank">chmod command</a>
				to recursively set octal value on all the directories being extracted.  Typically this value is 755 on most servers and hosts.
			</td>
		</tr>
		<tr>
			<td colspan="2" class="section">Advanced Options</td>
		</tr>
		<tr>
			<td>Safe Mode</td>
			<td>
				Safe mode is designed to configure the site with specific options at install time to help over come issues that may happen during the install were the site
				is having issues.  These options should only be used if you run into issues after you have tried to run an install.
				<br/><br/>
				<b>Basic:</b> This safe mode option will disable all the plugins at install time.  When this option is set you will need to re-enable all plugins after the
				install has full ran.
				<br/><br/>

				<b>Advanced:</b> This option applies all settings used in basic and will also de-activate and reactivate your theme when logging in for the first time.  This
				options should be used only if the Basic option did not work.
			</td>
		</tr>
		<tr>
			<td>Config Files </td>
			<td>
				When dealing with configuration files (.htaccess, web.config and .user.ini) the installer can apply different modes:
				<br/><br/>

				<b>Create New:</b> This is the default recommended option which will create either a new .htaccess or web.config file.  The new file is streamlined to help
				guarantee no conflicts are created during install.   The config files generated with this mode will be simple and basic.  The WordFence .user.ini file if
				present will be removed.
				<br/><br/>

				<b>Restore Original:</b> This option simply renames the htaccess.orig or web.config.orig	files to .htaccess or web.config. The *.orig files come from the original
				web server where the package was built.	Please note this option will cause issues with the install process if the configuration files are not properly setup to
				handle the new server environment.  This is an	advanced option and should only be used if you know how to properly configure your web servers configuration.
				<br/><br/>

<!--				<b>Ignore All:</b> This option simply does nothing.  No files are backed up, nothing is renamed or created.  This advanced option assumes you already have your
				config files setup and know how they should behave in the new environment.
				<br/><br/>-->

				<small>
				<b>Additional Notes:</b>
				Inside the archive.zip will be a copy of the original .htaccess (Apache) or the web.config (IIS) files that were setup with your packaged site.  They are both
				renamed to htaccess.orig and web.config.orig.  Using either Create New or Restore Original if any existing config files exist for the extraction process they will
				be backed up with a .bak extension.</small>
				<br/><br/>
			</td>
		</tr>

		<tr>
			<td>File Times</td>
			<td>When the archive is extracted should it show the current date-time or keep the original time it had when it was built.  This setting will be applied to
			all files and directories.</td>
		</tr>
		<tr>
			<td>Logging</td>
			<td>
				The level of detail that will be sent to the log file (installer-log.txt).  The recommend setting for most installs should be 'Light'.
				Note if you use Debug the amount of data written can be very large.  Debug is only recommended for support.
			</td>
		</tr>

	</table>
    <br/><br/>

	<h3>Notices</h3>
	To proceed with the install users must check the checkbox labeled " I have read and accept all terms &amp; notices".   This means you accept the term of using the software
	and are aware of any notices.
	<br/><br/>

</div>
<br/>


<!-- ============================================
STEP 2
============================================== -->
<a class="help-target" name="help-s2"></a>
<h2>Step <span class="step">2</span> of 4: Install Database</h2>
<div id="dup-help-step1" class="help-page">

    <h3>Basic/cPanel:</h3>
    There are currently two options you can use to perform the database setup.  The "Basic" option requires knowledge about the existing server and on most hosts
    will require that the database be setup ahead of time.  The cPanel option is for hosts that support <a href="http://cpanel.com/" target="_blank">cPanel Software</a>.
    This option will automatically show you the existing databases and users on your cPanel server and allow you to create new databases directly
    from the installer.
    <br/><br/>

	<h3>cPanel Login <sup>pro</sup></h3>
	<i>The cPanel connectivity option is only available for Duplicator Pro.</i>
	<table class="help-opt">
		<tr>
			<th>Option</th>
			<th>Details</th>
		</tr>
		<tr>
			<td>Host</td>
			<td>This should be the primary domain account URL that is associated with your host.  Most hosts will require you to register a primary domain name.
			This should be the URL that you place in the host field.  For example if your primary domain name is "mysite.com" then you would enter in
			"https://mysite.com:2083".  The port 2038 is the common	port number that cPanel works on.  If you do not know your primary domain name please contact your
			hosting provider or server administrator.</td>
		</tr>
		<tr>
			<td>Username</td>
			<td>The cPanel username used to login to your cPanel account.  <i>This is <b>not</b> the same thing as your WordPress administrator account</i>.
			If your unsure of this name please contact your hosting provider or server administrator.</td>
		</tr>
		<tr>
			<td>Password</td>
			<td>The password of the cPanel user</td>
		</tr>
		<tr>
			<td>Troubleshoot</td>
			<td>
				<b>Common cPanel Connection Issues:</b><br/>
				- Your host does not use <a href="http://cpanel.com/" target="_blank">cPanel Software</a> <br/>
				- Your host has disabled cPanel API access <br/>
				- Your host has configured cPanel to work differently (please contact your host) <br/>
				- View a list of valid cPanel <a href='https://snapcreek.com/wordpress-hosting/' target='_blank'>Supported Hosts</a>
			</td>
		</tr>
	</table>
	<br/><br/>

    <!-- DATABASE SETUP-->
	<h3>Setup</h3>
	The database setup options allow you to connect to an existing database or in the case of cPanel connect or create a new database.
	<table class="help-opt">
		<tr>
			<th>Option</th>
			<th>Details</th>
		</tr>
		<tr>
			<td>Action</td>
			<td>
				<b>Create New Database:</b> Will attempt to create a new database if it does not exist.  When using the 'Basic' option this option will not work on many
				hosting	providers as the ability to create new databases is normally locked down.  If the database does not exist then you will need to login to your
				control panel and create the database.  If your host supports 'cPanel' then you can use this option to create a new database after logging in via your
				cPanel account.
				<br/><br/>

				<b>Connect and Remove All Data:</b> This options will DELETE all tables in the database you are connecting to.  Please make sure you have
				backups of all your data before using an portion of the installer, as this option WILL remove all data.
				<br/><br/>

				<b>Connect and Backup Any Existing Data:</b><sup>pro</sup> This options will RENAME all tables in the database you are connecting to with a prefix of
				"<?php echo $GLOBALS['DB_RENAME_PREFIX'] ?>".
				<br/><br/>

				<b>Manual SQL Execution:</b><sup>pro</sup> This options requires that you manually run your own SQL import to an existing database before running the installer.
				When this action is selected the dup-database__[hash].sql file found inside the dup-installer folder of the archive.zip file will NOT be ran.   The database your connecting to should already
				be a valid WordPress installed database.  This option is viable when you need to run advanced search and replace options on the database.
				<br/><br/>

			</td>
		</tr>
		<tr>
			<td>Host</td>
			<td>The name of the host server that the database resides on.  Many times this will be 'localhost', however each hosting provider will have it's own naming
			convention please check with your server administrator or host to valid for sure the name needed.  To add a port number just append it to the host i.e.
			'localhost:3306'.</td>
		</tr>
		<tr>
			<td>Database</td>
			<td>The name of the database to which this installation will connect and install the new tables and data into.  Some hosts will require a prefix while others
			do not.  Be sure to know exactly how your host requires the database name to be entered.</td>
		</tr>
		<tr>
			<td>User</td>
			<td>The name of a MySQL database server user. This is special account that has privileges to access a database and can read from or write to that database.
			<i>This is <b>not</b> the same thing as your WordPress administrator account</i>.</td>
		</tr>
		<tr>
			<td>Password</td>
			<td>The password of the MySQL database server user.</td>
		</tr>

	</table>
	<br/><br/>

    <!-- OPTIONS-->
    <h3>Options</h3>
	<table class="help-opt">
		<tr>
			<th>Option</th>
			<th>Details</th>
		</tr>
		<tr>
			<td>Prefix<sup>pro*</sup></td>
			<td>By default, databases are prefixed with the cPanel account's username (for example, myusername_databasename).  However you can ignore this option if
			your host does not use the default cPanel username prefix schema.  Check the 'Ignore cPanel Prefix' and the username prefixes will be ignored.
			This will still require you to enter in the cPanels required setup prefix if they require one.  The checkbox will be set to read-only if your host has
			disabled prefix settings.  Please see your host full requirements when using the cPanel options.</td>
		</tr>
		<tr>
			<td>Legacy</td>
			<td>When creating a database table, the Mysql version being used may not support the collation type of the Mysql version where the table was created.
			In this scenario, the installer will fallback to a legacy collation type to try and create the table. This value should only be checked if you receive an error when
			testing the database.
			<br/><br/>
			For example, if the database was created on MySQL 5.7 and the tables collation type was 'utf8mb4_unicode_520_ci', however your trying to run the installer
			on an older MySQL 5.5 engine that does not support that type then an error will be thrown.  If this option is checked  then the legacy setting will try to
			use 'utf8mb4_unicode_520', then 'utf8mb4', then 'utf8' and so on until it runs out of options.
			<br/><br/>
			For more information about this feature see the online FAQ question titled
			<a href="https://snapcreek.com/duplicator/docs/faqs-tech/#faq-installer-110-q" target="_blank">"What is compatibility mode & 'unknown collation' errors"</a>
			</td>
		</tr>
		<tr>
			<td>Spacing</td>
			<td>The process will remove utf8 characters represented as 'xC2' 'xA0' and replace with a uniform space.  Use this option if you find strange question
			marks in you posts</td>
		</tr>
		<tr>
			<td>Mode</td>
			<td>The MySQL mode option will allow you to set the mode for this session.  It is very useful when running into conversion issues.  For a full overview please
			see the	<a href="https://dev.mysql.com/doc/refman/5.7/en/sql-mode.html" target="_blank">MySQL mode documentation</a> specific to your version.</td>
		</tr>
		<tr>
			<td>Charset</td>
			<td>When the database is populated from the SQL script it will use this value as part of its connection.  Only change this value if you know what your
			databases character set should be.</td>
		</tr>
		<tr>
			<td>Collation</td>
			<td>When the database is populated from the SQL script it will use this value as part of its connection.  Only change this value if you know what your
			databases collation set should be.</td>
		</tr>
	</table>
	<sup>*cPanel Only Option</sup>
	<br/><br/>

	<h3>Validation</h3>
	Testing the database connection is important and can help isolate possible issues that may arise with database version and compatibility issues.

	<table class="help-opt">
		<tr>
			<th>Option</th>
			<th>Details</th>
		</tr>
		<tr>
			<td>Test<br/>Database</td>
			<td>
				The 'Test Database' button will help validate if the connection parameters are correct for this server and help with details about any issues
				that may arise.
			</td>
		</tr>
		<tr>
			<td>Troubleshoot</td>
			<td>
				<b>Common Database Connection Issues:</b><br/>
				- Double check case sensitive values 'User', 'Password' &amp; the 'Database Name' <br/>
				- Validate the database and database user exist on this server <br/>
				- Check if the database user has the correct permission levels to this database <br/>
				- The host 'localhost' may not work on all hosting providers <br/>
				- Contact your hosting provider for the exact required parameters <br/>
				- Visit the online resources 'Common FAQ page' <br/>

			</td>
		</tr>
	</table>
	<br/><br/>
</div><br/>


<!-- ============================================
STEP 3
============================================== -->
<a class="help-target" name="help-s3"></a>
<h2>Step <span class="step">3</span> of 4: Update Data</h2>
<div id="dup-help-step2" class="help-page">

    <!-- SETTINGS-->
    <h3>New Settings</h3>
    These are the new values (URL, Path and Title) you can update for the new location at which your site will be installed at.
    <br/><br/>

    <h3>Replace <sup>pro</sup></h3>
	This section will allow you to add as many custom search and replace items that you would like.  For example you can search for other URLs to replace.  Please use high
	caution when using this feature as it can have unintended consequences as it will search the entire database.   It is recommended to only use highly unique items such as
	full URL or file paths with this option.
	<br/><br/>

    <!-- ADVANCED OPTS -->
    <h3>Options</h3>
	<table class="help-opt">
		<tr>
			<th>Option</th>
			<th>Details</th>
		</tr>
		<tr>
			<td colspan="2" class="section">New Admin Account</td>
		</tr>
		<tr>
			<td>Username</td>
			<td>A new WordPress username to create.  This will create a new WordPress administrator account.  Please note that usernames are not changeable from the within the UI.</td>
		</tr>
		<tr>
			<td>Password</td>
			<td>The new password for the new user.  Must be at least 6 characters long.</td>
		</tr>
		<tr>
			<td colspan="2" class="section">Scan Options</td>
		</tr>
		<tr>
			<td>Cleanup <sup>pro</sup></td>
			<td>The checkbox labeled Remove schedules &amp; storage endpoints will empty the Duplicator schedule and storage settings.  This is recommended to keep enabled so that you do not have unwanted schedules and storage options enabled.</td>
		</tr>
		<tr>
			<td>Old URL</td>
			<td>The old URL of the original values that the package was created with.  These values should not be changed, unless you know the underlying reasons</td>
		</tr>
		<tr>
			<td>Old Path</td>
			<td>The old path of the original values that the package was created with.  These values should not be changed, unless you know the underlying reasons</td>
		</tr>
		<tr>
			<td>Site URL</td>
			<td> For details see WordPress <a href="http://codex.wordpress.org/Changing_The_Site_URL" target="_blank">Site URL</a> &amp; <a href="http://codex.wordpress.org/Giving_WordPress_Its_Own_Directory" target="_blank">Alternate Directory</a>.  If you're not sure about this value then leave it the same as the new settings URL.</td>
		</tr>
		<tr>
			<td>Scan Tables</td>
			<td>Select the tables to be updated. This process will update all of the 'Old Settings' with the 'New Settings'. Hold down the 'ctrl key' to select/deselect multiple.</td>
		</tr>
		<tr>
			<td>Activate Plugins</td>
			<td>These plug-ins are the plug-ins that were activated when the package was created and represent the plug-ins that will be activated after the install.</td>
		</tr>
		<tr>
			<td>Full Search</td>
			<td>Full search forces a scan of every single cell in the database. If it is not checked then only text based columns are searched which makes the update process much faster.
			Use this option if you have issues with data not updating correctly.</td>
		</tr>
		<tr>
			<td>Post GUID</td>
			<td>If your moving a site keep this value checked. For more details see the <a href="http://codex.wordpress.org/Changing_The_Site_URL#Important_GUID_Note" target="_blank">notes on GUIDS</a>.	Changing values in the posts table GUID column can change RSS readers to evaluate that the posts are new and may show them in feeds again.</td>
		</tr>
		<tr>
			<td colspan="2" class="section">WP-Config File</td>
		</tr>
		<tr>
			<td>Config SSL</td>
			<td>Turn off SSL support for WordPress. This sets FORCE_SSL_ADMIN in your wp-config file to false if true, otherwise it will create the setting if not set.  The "Enforce on Login"
				will turn off SSL support for WordPress Logins.</td>
		</tr>
		<tr>
			<td>Config Cache</td>
			<td>Turn off Cache support for WordPress. This sets WP_CACHE in your wp-config file to false if true, otherwise it will create the setting if not set.  The "Keep Home Path"
			sets WPCACHEHOME in your wp-config file to nothing if true, otherwise nothing is changed.</td>
		</tr>
	</table>
	<br/><br/>
</div><br/>


<!-- ============================================
STEP 4
============================================== -->
<a class="help-target" name="help-s4"></a>
<h2>Step <span class="step">4</span> of 4: Test Site</h2>
<div id="dup-help-step3" class="help-page">
    <h3>Final Steps</h3>

	<b>Review Install Report</b><br/>
	The install report is designed to give you a synopsis of the possible errors and warnings that may exist after the installation is completed.
	<br/><br/>

	<b>Test Site</b><br/>
	After the install is complete run through your entire site and test all pages and posts.
	<br/><br/>

	<b>Final Security Cleanup</b><br/>
	When completed with the installation please delete all installation files.  Leaving these files on your server can impose a security risk!   You can remove
	all the security files by logging into your WordPress admin and following the remove notification links.   Be sure these files/directories are removed.  Optionally
	it is also recommended to remove the archive.zip/daf file.
	<ul>
		<li>dup-installer</li>
		<li>installer.php</li>
		<li>installer-backup.php</li>
		<li>installer-bootlog.txt</li>
		<li>archive.zip/daf</li>
	</ul>
	<br/><br/>

</div>


<a class="help-target" name="help-s5"></a>
<h2>Troubleshooting Tips</h2>
<div id="troubleshoot" class="help-page">

	<div style="padding: 0px 10px 10px 10px;">
		<b>Common Quick Fix Issues:</b>
		<ul>
			<li>Use an <a href='https://snapcreek.com/wordpress-hosting/' target='_blank'>approved hosting provider</a></li>
			<li>Validate directory and file permissions (see below)</li>
			<li>Validate web server configuration file (see below)</li>
			<li>Clear your browsers cache</li>
			<li>Deactivate and reactivate all plugins</li>
			<li>Resave a plugins settings if it reports errors</li>
			<li>Make sure your root directory is empty</li>
		</ul>

		<b>Permissions:</b><br/>
		Not all operating systems are alike.  Therefore, when you move a package (zip file) from one location to another the file and directory permissions may not always stick.  If this is the case then check your WordPress directories and make sure it's permissions are set to 755. For files make sure the permissions are set to 644 (this does not apply to windows servers).   Also pay attention to the owner/group attributes.  For a full overview of the correct file changes see the <a href='http://codex.wordpress.org/Hardening_WordPress#File_permissions' target='_blank'>WordPress permissions codex</a>
		<br/><br/>

		<b>Web server configuration files:</b><br/>
		For Apache web server the root .htaccess file was copied to htaccess.orig. A new stripped down .htaccess file was created to help simplify access issues.  For IIS web server the web.config file was copied to web.config.orig, however no new web.config file was created.  If you have not altered this file manually then resaving your permalinks and resaving your plugins should resolve most all changes that were made to the root web configuration file.   If your still experiencing issues then open the .orig file and do a compare to see what changes need to be made. <br/><br/><b>Plugin Notes:</b><br/> It's impossible to know how all 3rd party plugins function.  The Duplicator attempts to fix the new install URL for settings stored in the WordPress options table.   Please validate that all plugins retained there settings after installing.   If you experience issues try to bulk deactivate all plugins then bulk reactivate them on your new duplicated site. If you run into issues were a plugin does not retain its data then try to resave the plugins settings.
		<br/><br/>

		 <b>Cache Systems:</b><br/>
		 Any type of cache system such as Super Cache, W3 Cache, etc. should be emptied before you create a package.  Another alternative is to include the cache directory in the directory exclusion path list found in the options dialog. Including a directory such as \pathtowordpress\wp-content\w3tc\ (the w3 Total Cache directory) will exclude this directory from being packaged. In is highly recommended to always perform a cache empty when you first fire up your new site even if you excluded your cache directory.
		 <br/><br/>

		 <b>Trying Again:</b><br/>
		 If you need to retry and reinstall this package you can easily run the process again by deleting all files except the installer and package file and then browse to the installer again.
		 <br/><br/>

		 <b>Additional Notes:</b><br/>
		 If you have made changes to your PHP files directly this might have an impact on your duplicated site.  Be sure all changes made will correspond to the sites new location.
		 Only the package (zip file) and the installer (php file) should be in the directory where you are installing the site.  Please read through our knowledge base before submitting any issues.
		 If you have a large log file that needs evaluated please email the file, or attach it to a help ticket.
		 <br/><br/>

	</div>

</div>

<div style="text-align:center">For additional help please visit the <a href="https://snapcreek.com/support/docs/" target="_blank">online resources</a></div>

<br/><br/>
</div>
<!-- END OF VIEW HELP -->
 <?php
}
	
?>
</div>
</div><br/>


<!-- CONFIRM DIALOG -->
<div id="dialog-server-info" style="display:none">
	<!-- DETAILS -->
	<div class="dlg-serv-info">
		<?php
			$ini_path 		= php_ini_loaded_file();
			$ini_max_time 	= ini_get('max_execution_time');
			$ini_memory 	= ini_get('memory_limit');
		?>
         <div class="hdr">Current Server</div>
		<label>Web Server:</label>  			<?php echo $_SERVER['SERVER_SOFTWARE']; ?><br/>
		<label>Operating System:</label>        <?php echo PHP_OS ?><br/>
        <label>PHP Version:</label>  			<?php echo DUPX_Server::$php_version; ?><br/>
		<label>PHP INI Path:</label> 			<?php echo empty($ini_path ) ? 'Unable to detect loaded php.ini file' : $ini_path; ?>	<br/>
		<label>PHP SAPI:</label>  				<?php echo php_sapi_name(); ?><br/>
		<label>PHP ZIP Archive:</label> 		<?php echo class_exists('ZipArchive') ? 'Is Installed' : 'Not Installed'; ?> <br/>
		<label>PHP max_execution_time:</label>  <?php echo $ini_max_time === false ? 'unable to find' : $ini_max_time; ?><br/>
		<label>PHP memory_limit:</label>  		<?php echo empty($ini_memory)      ? 'unable to find' : $ini_memory; ?><br/>

        <br/>
        <div class="hdr">Package Server</div>
		<div class="info-txt">The server where the package was created</div>
        <label>Plugin Version:</label>  		<?php echo $GLOBALS['FW_VERSION_DUP'] ?><br/>
        <label>WordPress Version:</label>  		<?php echo $GLOBALS['FW_VERSION_WP'] ?><br/>
        <label>PHP Version:</label>             <?php echo $GLOBALS['FW_VERSION_PHP'] ?><br/>
        <label>Database Version:</label>        <?php echo $GLOBALS['FW_VERSION_DB'] ?><br/>
        <label>Operating System:</label>        <?php echo $GLOBALS['FW_VERSION_OS'] ?><br/>
		<br/><br/>
	</div>
</div>

<script>
/* Server Info Dialog*/
DUPX.showServerInfo = function()
{
	modal({
		type: 'alert',
		title: 'Server Information',
		text: $('#dialog-server-info').html()
	});
}
</script>

</body>
</html>