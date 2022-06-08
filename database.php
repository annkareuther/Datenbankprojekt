<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database {

    private $host = 'localhost';
    private $user = 'root';
    private $password = 'root';
    private $db = 'projektlogin';


    /**
     * Creates a simple database-connection.
     *
     * @return PDO
     */
    private function create_connection() {
        $conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return $conn;
    }

    private function check_if_table_exist($connection, $table) {
        try {
            $connection->query("SELECT 1 FROM $table");
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    /**
     * Create User Table
     * ---
     * Checks if "user" table exists already.
     * Creates the table if not already exist.
     *
     * TABLE user:
     *  - user_id
     *  - username
     *  - password
     *  - email
     *  - register_date
     */
    private function create_user_table() {
        // here: create table if not exist.
        try {
            $conn = $this->create_connection();
            if (!$this->check_if_table_exist($conn, 'user')) {
                // sql to create table
                $sql = "CREATE TABLE user (
                    user_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(40) NOT NULL,
                    password VARCHAR(160) NOT NULL,
                    email VARCHAR(60),
                    register_date TIMESTAMP )";
                // use exec() because no results are returned
                $conn->exec($sql);
                echo "user table erfolgreich erstellt <br>";
            } else {
                // echo "user table already exist.";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $conn = null;
    }

//create all the tables needed
    private function create_spieler_table () {
        // here: create table if not exist.
        try {
            $conn = $this->create_connection();
            if (!$this->check_if_table_exist($conn, 'spieler')) {
                // sql to create table
                $sql = "CREATE TABLE spieler (
                    spieler_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    spielername VARCHAR(40) NOT NULL,
                    verein_id INT(11) UNSIGNED NOT NULL,
                    geburtsdatum  DATE,
                    mannschaft_id INT(11) UNSIGNED NOT NULL,
                    nationalitaet_id INT(11) UNSIGNED NOT NULL,
                    nationalteam_id INT(11) UNSIGNED NOT NULL,
                    position_id INT(11) UNSIGNED NOT NULL,
                    spielernummer INT (10)
                    )";
                // use exec() because no results are returned
                $conn->exec($sql);
                echo "spieler table erfolgreich erstellt <br>";
                $sql = "ALTER TABLE `spieler`  
                        ADD CONSTRAINT `FK_verein` 
                        FOREIGN KEY (`verein_id`) REFERENCES `verein`(`verein_id`) 
                        ON UPDATE CASCADE 
                        ON DELETE CASCADE;
                ";
                $conn->exec($sql);
                echo "Relation Verein aufgebaut <br>";
                $sql = "ALTER TABLE `spieler`  
                        ADD CONSTRAINT `FK_nationalteam` 
                        FOREIGN KEY (`nationalteam_id`) REFERENCES `nationalteam`(`nationalteam_id`) 
                        ON UPDATE CASCADE 
                        ON DELETE CASCADE;
                ";
                $conn->exec($sql);
                echo "Relation Nationalteam aufgebaut <br>";
                $sql = "ALTER TABLE `spieler`  
                        ADD CONSTRAINT `FK_positon` 
                        FOREIGN KEY (`position_id`) REFERENCES `position`(`position_id`) 
                        ON UPDATE CASCADE 
                        ON DELETE CASCADE;
                ";
                $conn->exec($sql);
                echo "Relation Position aufgebaut <br>";
                $sql = "ALTER TABLE `spieler`  
                ADD CONSTRAINT `FK_nationalitaet` 
                FOREIGN KEY (`nationalitaet_id`) REFERENCES `nationalitaet`(`nationalitaet_id`) 
                ON UPDATE CASCADE 
                ON DELETE CASCADE;
                ";
                $conn->exec($sql);
                echo "Relation nationalitaet aufgebaut <br>";
            } else {
                // echo "spieler table already exist.";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $conn = null; 
    }

    private function create_nationalteam_table() {
        // here: create table if not exist.
        try {
            $conn = $this->create_connection();
            if (!$this->check_if_table_exist($conn, 'nationalteam')) {
                // sql to create table
                $sql = "CREATE TABLE nationalteam (
                    nationalteam_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    land VARCHAR(20) NOT NULL
                    )"; 
                // use exec() because no results are returned
                $conn->exec($sql);
                echo "nationalteam table erfolgreich erstellt <br>";
            } else {
                // echo "nationalteam table already exist.";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $conn = null;
    }

    private function create_nationalitaet_table() {
        // here: create table if not exist.
        try {
            $conn = $this->create_connection();
            if (!$this->check_if_table_exist($conn, 'nationalitaet')) {
                // sql to create table
                $sql = "CREATE TABLE nationalitaet (
                    nationalitaet_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    `name`  VARCHAR(40),
                    kuerzel VARCHAR(11)
                    )";
                // use exec() because no results are returned
                $conn->exec($sql);
                echo "nationalitaet table erfolgreich erstellt <br>";
            } else {
                // echo "nationalitaet table already exist.";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $conn = null;
    }

    private function create_verein_table() {
        // here: create table if not exist.
        try {
            $conn = $this->create_connection();
            if (!$this->check_if_table_exist($conn, 'verein')) {
                // sql to create table
                $sql = "CREATE TABLE verein(
                    verein_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(40),
                    ort VARCHAR(30)
                    )";
                // use exec() because no results are returned
                $conn->exec($sql);
                echo "verein table erfolgreich erstellt <br>";
            } else {
                // echo "verein table already exist.";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $conn = null;
    }

    private function create_position_table() {
        // here: create table if not exist.
        try {
            $conn = $this->create_connection();
            if (!$this->check_if_table_exist($conn, 'position')) {
                // sql to create table
                $sql = "CREATE TABLE position (
                    position_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    positionsname VARCHAR(20)
                    )";
                // use exec() because no results are returned
                $conn->exec($sql);
                echo "position table erfolgreich erstellt <br>";
            } else {
                // echo "position table already exist.";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $conn = null;
    }

    private function create_mannschaft_table() {
            // here: create table if not exist.
            try {
                $conn = $this->create_connection();
                if (!$this->check_if_table_exist($conn, 'mannschaft')) {
                    // sql to create table
                    $sql = "CREATE TABLE mannschaft (
                        mannschaft_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        spieler_id INT(11) UNSIGNED NOT NULL,
                        mannschaftsname VARCHAR(40),
                        captain VARCHAR(11)
                        )";
                    // use exec() because no results are returned
                    $conn->exec($sql);
                    echo "mannschaft table erfolgreich erstellt <br>";
                    $sql = "ALTER TABLE `mannschaft`  
                    ADD CONSTRAINT `FK_captain` 
                    FOREIGN KEY (`spieler_id`) REFERENCES `spieler`(`spieler_id`) 
                    ON UPDATE CASCADE 
                    ON DELETE CASCADE;
                    ";
                    $conn->exec($sql);
                    echo "Relation Captain aufgebaut <br>";
                    $sql = "ALTER TABLE `spieler`  
                    ADD CONSTRAINT `FK_hauptmannschaft` 
                    FOREIGN KEY (`mannschaft_id`) REFERENCES `mannschaft`(`mannschaft_id`) 
                    ON UPDATE CASCADE 
                    ON DELETE CASCADE;
                    ";
                    $conn->exec($sql);
                    echo "Relation Hauptmannschaft aufgebaut <br>";
                } else {
                    // echo "mannschaft table already exist.";
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $conn = null;
    }

    public function prepare_tables() {
        $this->create_user_table(); 
        $this->create_verein_table(); 
        $this->create_nationalteam_table();
        $this->create_nationalitaet_table(); 
        $this->create_position_table(); 
        $this->create_spieler_table();
        $this->create_mannschaft_table();
        return true;
    }

    public function prepare_login() {
        $this->create_user_table();
        return true;
    }

    public function prepare_registration() {
        $this->create_user_table();
        return true;
    }

    public function login_user($username, $password) {
        try {
            $conn = $this->create_connection();
            $query = "SELECT * FROM `user` WHERE username = ?";
            $statement = $conn->prepare($query);
            $statement->execute([$username]);

            $user = $statement->fetchAll(PDO::FETCH_CLASS);

            // echo für schönere Darstellung
            echo '<pre>';
            var_dump($user);
            echo '</pre>';


            if (empty($user)) {

                return false;
            }

            // user exist, we only look at the first entry.

            $user = $user[0];

            $password_saved = $user->password;
            if (!password_verify($password, $password_saved)) {
                return false;
            }

            // remove the password, we don't want to transfer this anywhere.
            unset($user->password);

            return $user;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }
    /*public function register_user($username, $password, $email=null) {
        // here: insert a new user into the database.
        // @todo: check if username is free.
        try {
            $conn = $this->create_connection();
            $sql = 'INSERT INTO user(username, password, email, register_date)
            VALUES(?, ?, ?, NOW())';
            $statement = $conn->prepare($sql);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $statement->execute([$username, $password_hash, $email]);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }
    */
    public function register_user($username, $password, $email=null) {
        // here: insert a new user into the database.
        try {
            $conn = $this->create_connection();
            $query = "SELECT * FROM `user` WHERE username = ?";
            $statement = $conn->prepare($query);
            $statement->execute([$username]);
            $user = $statement->fetchAll(PDO::FETCH_CLASS);
            if (!empty($user)) {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        // now: save user.
        try {
            $conn = $this->create_connection();

            $sql = 'INSERT INTO user(username, password, email, register_date)
            VALUES(?, ?, ?, NOW())';
            $statement = $conn->prepare($sql);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $statement->execute([$username, $password_hash, $email]);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }


    public function drop_all() {
        try {
            $conn = $this->create_connection();

        /*    $sql = 'ALTER TABLE `order`
                DROP FOREIGN KEY `FK_order_user`;';
            $conn->exec($sql); */

            $sql = 'DROP TABLE `user`';
            $conn->exec($sql);

            $sql = 'DROP TABLE `order`';
            $conn->exec($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

}
