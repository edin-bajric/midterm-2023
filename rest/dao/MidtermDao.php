<?php

class MidtermDao {

    private $conn;

    /**
    * constructor of dao class
    */
    public function __construct(){
        try {

        /** TODO
        * List parameters such as servername, username, password, schema. Make sure to use appropriate port
        */

        $hostname = "db-mysql-nyc1-51552-do-user-3246313-0.b.db.ondigitalocean.com:25060";
        $database = "midterm-2023";
        $username = "doadmin";
        $password = "AVNS_sQwKZryHF62wtg6XNoi";


        /*options array neccessary to enable ssl mode - do not change*/
        $options = array(
        	PDO::MYSQL_ATTR_SSL_CA => 'https://drive.google.com/file/d/1g3sZDXiWK8HcPuRhS0nNeoUlOVSWdMAg/view?usp=share_link',
        	PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,

        );
        /** TODO
        * Create new connection
        * Use $options array as last parameter to new PDO call after the password
        */

        $this -> conn = new PDO("mysql:host=$hostname;dbname=$database;", $username, $password, $options);

        // set the PDO error mode to exception
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    /** TODO
    * Implement DAO method used to get cap table
    */
    public function cap_table(){
        $query = $this -> conn -> prepare("SELECT * FROM cap_table");
        $query -> execute();
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    /** TODO
    * Implement DAO method used to get summary
    */
    public function summary(){
        $investorQuery = $this -> conn -> prepare("SELECT COUNT(*) AS total_investors FROM investors");
        $investorQuery -> execute();
        return $investorQuery -> fetchAll(PDO::FETCH_ASSOC);
        

        $sharesQuery = $this -> conn -> prepare("SELECT SUM(diluted_shares) AS total_shares FROM cap_table");
        $sharesQuery -> execute();
        return $sharesQuery -> fetchAll(PDO::FETCH_ASSOC);

        
    }

    /** TODO
    * Implement DAO method to return list of investors with their total shares amount
    */
    public function investors(){

      // ovaj query radi u mysql workbenchu izbacuje tacan output
      $query = $this -> conn -> prepare("SELECT company i, first_name i, last_name i, SUM(diluted_shares) AS total_shares
      FROM cap_table ct
      JOIN investors i ON ct.investor_id = i.id
      GROUP BY(i.id)");
      $query -> execute();
      return $query -> fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
