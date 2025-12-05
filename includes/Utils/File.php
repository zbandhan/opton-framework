<?php

namespace Giganteck\Opton\Utils;

use RuntimeException;
use WP_Filesystem_Base;

class File {
    /**
     * The WordPress filesystem instance.
     *
     * @var WP_Filesystem_Base|null
     */
    protected static $filesystem = null;

    /**
     * Whether to throw exceptions on failure.
     *
     * @var bool
     */
    public static $throw_exceptions = false;

    /**
     * Log file path (false to disable).
     *
     * @var string|bool
     */
    public static $log_file = WP_CONTENT_DIR . '/opton-files.log';

    /**
     * Initialize the WP_Filesystem API if not already.
     *
     * @return bool True if initialized, false on failure.
     */
    protected static function init_filesystem() {
        if (self::$filesystem instanceof WP_Filesystem_Base) {
            return true;
        }

        if (! function_exists('WP_Filesystem')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        if (! WP_Filesystem()) {
            self::log_error('WP_Filesystem initialization failed.');
            if (self::$throw_exceptions) {
                throw new RuntimeException('WP_Filesystem initialization failed.');
            }

            return false;
        }

        global $wp_filesystem;
        self::$filesystem = $wp_filesystem;

        return true;
    }

    /**
     * Safely log an error message.
     *
     * @param string $message
     */
    protected static function log_error($message) {
        if (! self::$log_file) {
            return;
        }

        $timestamp = gmdate('Y-m-d H:i:s');
        $line = "[$timestamp] $message\n";

        // If filesystem is ready, use it; else fallback to native.
        if (self::$filesystem instanceof WP_Filesystem_Base) {
            @self::$filesystem->put_contents(self::$log_file, $line, FILE_APPEND);
        } else {
            // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
            @file_put_contents(self::$log_file, $line, FILE_APPEND);
        }
    }

    /**
     * Write contents to a file (like file_put_contents).
     *
     * @param string $file_path
     * @param string $content
     * @param int    $mode
     * @param bool   $append
     * @return int|false
     */
    public static function put_contents($file_path, $content, $mode = FS_CHMOD_FILE, $append = false) {
        if (! self::init_filesystem()) {
            return false;
        }

        // Ensure directory exists
        $dir = dirname($file_path);
        if (! self::mkdir($dir, FS_CHMOD_DIR)) {
            return false;
        }

        if ($append && self::$filesystem->exists($file_path)) {
            $existing = self::$filesystem->get_contents($file_path);
            $content  = $existing . $content;
        }

        $result = self::$filesystem->put_contents($file_path, $content, $mode);
        if (! $result) {
            $msg = "Failed to write file: $file_path";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
            return false;
        }

        return strlen($content);
    }

    /**
     * Read a file or URL (like file_get_contents).
     *
     * @param string $file_or_url
     * @return string|false
     */
    public static function get_contents($file_or_url) {
        // Remote URL case
        if (filter_var($file_or_url, FILTER_VALIDATE_URL)) {
            $response = wp_remote_get($file_or_url);
            if (is_wp_error($response)) {
                self::log_error('Failed to fetch URL: ' . $file_or_url . ' (' . $response->get_error_message() . ')');
                if (self::$throw_exceptions) {
                    throw new RuntimeException(sprintf('Failed to fetch URL: %s', esc_html($file_or_url)));
                }
                return false;
            }
            return wp_remote_retrieve_body($response);
        }

        if (! self::init_filesystem()) {
            return false;
        }

        if (! self::$filesystem->exists($file_or_url)) {
            $msg = "File not found: $file_or_url";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
            return false;
        }

        $content = self::$filesystem->get_contents($file_or_url);
        if ($content === false) {
            $msg = "Failed to read file: $file_or_url";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
        }

        return $content;
    }

    /**
     * Delete a file (like unlink).
     *
     * @param string $file
     * @return bool
     */
    public static function unlink($file) {
        if (! file_exists($file)) {
            self::log_error("File not found for deletion: $file");
            return false;
        }

        $result = wp_delete_file($file);
        if (! $result) {
            $msg = "Failed to delete file: $file";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
        }

        return (bool) $result;
    }

    /**
     * Change file permissions (like chmod).
     *
     * @param string $file
     * @param int    $mode
     * @return bool
     */
    public static function chmod($file, $mode) {
        if (! self::init_filesystem()) {
            return false;
        }

        if (! self::$filesystem->exists($file)) {
            self::log_error("File does not exist for chmod: $file");
            return false;
        }

        $result = self::$filesystem->chmod($file, $mode);
        if (! $result) {
            $msg = "Failed to chmod file: $file";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
        }

        return $result;
    }

    /**
     * Recursively create directories (like mkdir with recursive = true).
     *
     * @param string $dir
     * @param int    $mode
     * @return bool
     */
    public static function mkdir($dir, $mode = FS_CHMOD_DIR) {
        if (! self::init_filesystem()) {
            return false;
        }

        $dir = rtrim(wp_normalize_path($dir), '/');

        if (self::$filesystem->is_dir($dir)) {
            return true;
        }

        $parts = explode('/', $dir);
        $path  = '';
        foreach ($parts as $part) {
            if (empty($part)) {
                continue;
            }
            $path .= '/' . $part;
            if (! self::$filesystem->is_dir($path)) {
                if (! self::$filesystem->mkdir($path, $mode)) {
                    $msg = "Failed to create directory: $path";
                    self::log_error($msg);
                    if (self::$throw_exceptions) {
                        throw new RuntimeException(esc_html($msg));
                    }
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Remove a directory and its contents recursively.
     *
     * @param string $dir
     * @return bool
     */
    public static function rmdir($dir) {
        if (! self::init_filesystem()) {
            return false;
        }

        if (! self::$filesystem->is_dir($dir)) {
            self::log_error("Directory does not exist for removal: $dir");
            return false;
        }

        $result = self::$filesystem->rmdir($dir, true);
        if (! $result) {
            $msg = "Failed to remove directory: $dir";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
        }

        return $result;
    }

    /**
     * Copy a file.
     *
     * @param string $source
     * @param string $destination
     * @param int    $mode
     * @return bool
     */
    public static function copy($source, $destination, $mode = FS_CHMOD_FILE) {
        if (! self::init_filesystem()) {
            return false;
        }

        if (! self::$filesystem->exists($source)) {
            $msg = "Source file does not exist: $source";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
            return false;
        }

        $dest_dir = dirname($destination);
        if (! self::mkdir($dest_dir, FS_CHMOD_DIR)) {
            return false;
        }

        $content = self::$filesystem->get_contents($source);
        if ($content === false) {
            $msg = "Failed to read source file for copy: $source";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
            return false;
        }

        $result = self::$filesystem->put_contents($destination, $content, $mode);
        if (! $result) {
            $msg = "Failed to copy file to: $destination";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
            return false;
        }

        return true;
    }

    /**
     * Rename or move a file.
     *
     * @param string $source
     * @param string $destination
     * @return bool
     */
    public static function rename($source, $destination) {
        if (! self::init_filesystem()) {
            return false;
        }

        if (! self::$filesystem->exists($source)) {
            $msg = "Source file does not exist for rename: $source";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
            return false;
        }

        $dest_dir = dirname($destination);
        if (! self::mkdir($dest_dir, FS_CHMOD_DIR)) {
            return false;
        }

        $result = self::$filesystem->move($source, $destination);
        if (! $result) {
            $msg = "Failed to rename file from $source to $destination";
            self::log_error($msg);
            if (self::$throw_exceptions) {
                throw new RuntimeException(esc_html($msg));
            }
            return false;
        }

        return true;
    }

}
