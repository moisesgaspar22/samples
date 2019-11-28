<?php

namespace BeeGame\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class Log
 *
 * @package BigCommerce\Logging
 */
class JustLog {
    const EMERGENCY = 'emergency';
    const ALERT     = 'alert';
    const CRITICAL  = 'critical';
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const NOTICE    = 'notice';
    const INFO      = 'info';
    const DEBUG     = 'debug';

    const LOG_NAME  = 'app-name';

    /**
     * @var Logger
     */
    public $log;

    /**
     * @var string This log file path
     */
    public $log_path;

    /**
     * Log constructor.
     *
     * @param string $log_path File system path to the log file
     */
    public function __construct( $log_path ) {
        $this->log_path = $log_path;
    }

    /**
     * Set up the import errors log
     */
    public function init_log() {
        $this->init_log_dir();

        // Format lines as json objects
        $formatter =  new \Monolog\Formatter\LineFormatter();

        // Logger message
        $logger_name  = self::LOG_NAME;
        $this->log    = new Logger( $logger_name );
        $logger_level = $this->log_level();

        try {
            $handler = new StreamHandler( $this->log_path, $logger_level );

            // Logger Handler
            $handler->setFormatter( $formatter );

            $this->log->pushHandler( $handler );
        } catch ( \Exception $e ) {
            // log is not writeable
            error_log( __( 'Unable to initialize import error log', 'bigcommerce' ) );
        }
    }

    private function log_level() {
        /**
         * Filter the logging level. Defaults to 'debug'.
         *
         * @param string|int The logging level, as either a PSR-3 LogLevel string or a Monolog integer.
         */
        $level = self::DEBUG ;
        switch ( $level ) {
            case self::DEBUG:
                return Logger::DEBUG;
            case self::INFO:
                return Logger::INFO;
            case self::NOTICE:
                return Logger::NOTICE;
            case self::WARNING:
                return Logger::WARNING;
            case self::ERROR:
                return Logger::ERROR;
            case self::CRITICAL:
                return Logger::CRITICAL;
            case self::ALERT:
                return Logger::ALERT;
            case self::EMERGENCY:
                return Logger::EMERGENCY;
            default:
                if ( is_numeric( $level ) ) {
                    return (int) $level;
                }
                return Logger::DEBUG;
        }
    }

    /**
     * Set up the import error log directory
     */
    private function init_log_dir() {
        $file_log_dir = dirname( $this->log_path );

        // Check if Dir already exists, if not create using wp_mkdir_p
        if ( ! is_dir( $file_log_dir ) ) {
            mkdir($file_log_dir, 0777, true);

            // Builds a .htaccess file to prevent direct download
            $this->write_htaccess( $file_log_dir );
        }
    }

    /**
     * Generates a .htaccess file to prevent direct downloads
     *
     * @param $directory_path
     */
    private function write_htaccess( $directory_path ) {
        $htaccess_file = fopen( $directory_path . ".htaccess", "a+" );

        $rulles = <<<HTACCESS
# BigCommerce Plugin Rule  
<FilesMatch ".*">
    Order Allow,Deny
    Deny from All
</FilesMatch>
HTACCESS;

        fwrite( $htaccess_file, $rulles );
        fclose( $htaccess_file );
    }

    /**
     * Get data from log
     *
     * @return array
     */
    public function get_log_data() {
        if ( file_exists( $this->log_path ) ) {
            if ( filesize( $this->log_path ) == 0 ) {
                return [
                    'message'       => __( 'The log file is empty', 'app' ),
                    'log_content'   => '',
                    'log_date_time' => '',
                ];
            }
            $log_content            = file_get_contents( $this->log_path );
            $log_creation_date_time = date( "F-d-Y H:i:s.", filemtime( $this->log_path ) );

            return [
                'message'       => __( 'ok', 'app' ),
                'log_content'   => $log_content,
                'log_date_time' => $log_creation_date_time,
            ];
        } else {
            return [
                'message'       => __( 'Log not found -> ' . $this->log_path, 'app' ),
                'log_content'   => '',
                'log_date_time' => '',
            ];

        }
    }

    /**
     * Delete Log content
     */
    public function truncate_log() {
        if ( file_exists( $this->log_path ) ) {
            // Truncate file
            $file = fopen( $this->log_path, "w" );
            fclose( $file );
        }
    }

    public function log( $level, $message, $context ) {
        if ( ! isset( $this->log ) ) {
            $this->init_log();
        }
        if ( ! is_array( $context ) ) {
            $context = [];
        }
        switch ( $level ) {
            case self::EMERGENCY:
                $this->log->emergency( $message, $context );
                break;
            case self::ALERT:
                $this->log->alert( $message, $context );
                break;
            case self::CRITICAL:
                $this->log->critical( $message, $context );
                break;
            case self::ERROR:
                $this->log->error( $message, $context );
                break;
            case self::WARNING:
                $this->log->warning( $message, $context );
                break;
            case self::NOTICE:
                $this->log->notice( $message, $context );
                break;
            case self::INFO:
                $this->log->info( $message, $context );
                break;
            case self::DEBUG:
            default:
                $this->log->debug( $message, $context );
                break;
        }
    }
}