<?php

/**
 * Created by PhpStorm.
 * User: Levani
 * Date: 26.07.2017
 * Time: 1:01
 */
class DatabaseConnector
{

    private $connection;

    function __construct(){
        $this->connection = mysqli_connect( DatabaseConfig::HOST,
                                            DatabaseConfig::USER,
                                            DatabaseConfig::PASSWORD,
                                            DatabaseConfig::DATABASE,
                                            DatabaseConfig::PORT);
    }

    function execute($query){
        return mysqli_query($this->connection, $query);
    }

    function next($resultSet){
        $result = mysqli_fetch_array($resultSet);
        if(!$result){
            mysqli_free_result($resultSet);
        }
        return $result;
    }
}