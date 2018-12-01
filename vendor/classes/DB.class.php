<?php
    /**
 * Created by PhpStorm.
 * User: jitendra
 * Date: 01/12/18
 * Time: 10:10 AM
 */

    namespace classes;

    use PDO;
    use classes\Log as DbLog;

    class DB
    {
        /*private static variable*/
        private static $connection;


        /*private static variable
         * PDO instance in order to establish the database connection.
         * The instance takes the connection settings as a parameter
         */

        private static $settings = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_EMULATE_PREPARES => false,
        );


        /**
         *   Default Constructor
         *
         *	1. Connect to database.
         *	2. Creates the parameter array.
         */
        public function __construct($configuration = array()){
            self::connect($configuration['DB_HOST'], $configuration['DB_DATABASE'], $configuration['DB_USERNAME'], $configuration['DB_PASSWORD']);
        }


        /*The method simply creates a PDO instance using the usual parameters for establishing database connections
         *(host, username, password and database name)
         */
        public static function connect($host, $database, $user, $password)
        {
            if (!isset(self::$connection))
            {
                try {
                    self::$connection = new PDO(
                        "mysql:host=$host;dbname=$database",
                        $user,
                        $password,
                        self::$settings
                    );
                }
                catch (\PDOException $e){
                    self::ExceptionLog($e->getMessage());
                    return false;
                }
            }
        }

        /*method for retrieving a row from the database*/
        public static function _fetch_single($query, $params = array())
        {
            try{
                $result = self::$connection->prepare($query);
                $result->execute($params);
                return $result->fetch(PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e){
                self::ExceptionLog($e->getMessage());
                return false;
            }
        }


        /*Querying all rows*/
        public static function _fetch_all($query, $params = array()){
            try{
                $result = self::$connection->prepare($query);
                $result->execute($params);
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e){
                self::ExceptionLog($e->getMessage());
                return false;
            }

        }



        /* Querying the number of affected rows
         * Executes a query and returns the number of affected rows
         */
        public static function query($query, $params = array()){
            try{
                $result = self::$connection->prepare($query);
                $result->execute($params);
                return $result->rowCount();
            }
            catch (\PDOException $e){
                self::ExceptionLog($e->getMessage());
                return false;
            }
        }

        /**
         * Writes the log and returns the exception
         *
         * @param  string $message
         * @param  string $sql
         * @return string
         */
        private static function ExceptionLog($message)
        {
            $log = new DbLog();
            $log->write($message);
            return false;
        }


    }
?>
