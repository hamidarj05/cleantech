<?php 
try {
        $dbhost = 'sql311.infinityfree.com';
        $dbname='if0_39257603_cleanmaroc';
        $dbuser = 'if0_39257603';
        $dbpass = 'Pm7qSS5ptxHZc';
        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    }
   catch (PDOException $e) {
        echo "Error : " . $e->getMessage() . "<br/>";
        die();
    }   

?>
