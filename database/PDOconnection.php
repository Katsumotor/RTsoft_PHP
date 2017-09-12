<?php

require_once 'Config_DB.php';

abstract class PDOconnection {

    private static $instance = null;
    private static $conn;

    private static function setConnection() {
        if (self::$instance == null) {
            try {
                self::$conn = new PDO("mysql:host=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

    public function getConnection() {
        self::setConnection();
        return self::$conn;
    }

}
