<?php



namespace scandiweb\Factory;

use mysqli;

require_once "config.php";


class DBMan
{
    /**
     * @var mysqli $connection
     */
    private mysqli $connection;


    function __construct()
    {
        $this->connection = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBNAME);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }

    }

    /**
     * @return mysqli
     */
    public function get():mysqli
    {
        return $this->connection;
    }


}