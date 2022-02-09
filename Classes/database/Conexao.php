<?php


class Conexao {
    static protected $db;
    
    function __construct() {
        if (!isset(Conexao::$db)){
          Conexao::$db = new PDO("mysql:host=localhost;port=3307;dbname=projeto_api","root","");
          Conexao::$db->exec("SET CHARACTER SET utf8");
        }
    }
}
