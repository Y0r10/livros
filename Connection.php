<?php 
//Classe para efetuar a conexão ao banco de dados

class Connection {

    private static $conn = null;

    public static function getConnection() {

        if(self::$conn == null) {
            $opcoes = array(
                //Define o charset da conexão
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                //Define o tipo do erro como exceção
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

            //ATENÇÃO: 
            //lembrar de alterar os dados da base de dados
            //de acordo com o ambiente
            self::$conn = new PDO(
                "mysql:host=mysql-server;dbname=dblivros", 
                "root", "root", $opcoes);
        }

        return self::$conn;
    }
}
