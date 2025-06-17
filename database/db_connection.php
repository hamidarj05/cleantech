<?php 
try {
        $dbhost = 'localhost';
        $dbname='cleanmaroc_db';
        $dbuser = 'root';
        $dbpass = 'hamid';
        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    }
   catch (PDOException $e) {
        echo "Error : " . $e->getMessage() . "<br/>";
        die();
    }   

?>