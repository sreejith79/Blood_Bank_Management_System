<?php
    class DBConnect
    {
        const DB_SERVER = "127.0.0.1";
        const DB_USER = "user";
        const DB_PASSWORD = "12345";
        const DB_NAME = "blood_bank";
        public $db;

        public function __construct()
        {
            $dsn = 'mysql:dbname=' . self::DB_NAME . ';host=' . self::DB_SERVER;
            try {
                $this->db = new PDO($dsn, self::DB_USER, self::DB_PASSWORD);
            } catch (PDOException $err) {
                throw new Exception('Connection failed: ' . $err->getMessage());
            }
        }

        public function auth() {
            session_start();
            if(!isset($_SESSION['username'])) {
                header("Location: http://localhost/Blood_Bank_Management_System/login.php");
                // exit();
            }
        }

        public function authLogin() {
            session_start();
            if(isset($_SESSION['username'])) {
                header("Location: http://localhost/Blood_Bank_Management_System/home.php");
            }
        }

        public function checkAuth() {
            session_start();
            if(!isset($_SESSION['username'])) {
                return false;
            } else {
                return true;
            }
        }

        public function login($username, $password) {
            $stmt = $this->db->prepare("SELECT * FROM employees WHERE username=? AND password=?");
            $stmt->execute([$username,$password]);
            if($stmt->rowCount() > 0){
                session_start();
                $emp = $stmt->fetchAll();
                foreach($emp as $e){
                    $_SESSION['id'] = $e['id'];
                    $_SESSION['username'] = $e['username'];
                    $_SESSION['password'] = $e['password'];
                    $_SESSION['firstName'] = $e['f_name'];
                    $_SESSION['middleName'] = $e['m_name'];
                    $_SESSION['lastName'] = $e['l_name'];
                    $_SESSION['birthDay'] = $e['b_day'];
                    $_SESSION['pcrNumber'] = $e['prc_nr'];
                    $_SESSION['designation'] = $e['designation'];
                    $_SESSION['landline'] = $e['landline'];
                    $_SESSION['mobile'] = $e['mobile'];     
                }
                return true;
            } else {
                return false;
            }
        }

        public function addDonor($fname, $lname, $sex, $bType, $dob, $address, $city, $donationDate, $weight, $phone, $mobile) {
            $stmt = $this->db->prepare("INSERT INTO donors (first_name, last_name, sex, blood_type, dob, address, city, donation_date, weight, phone, mobile) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$fname, $lname, $sex, $bType, $dob, $address, $city, $donationDate, $weight, $phone, $mobile]);
            return true;
        }
        

        public function searchDonorWithBloodGroup($bloodGroup) {
            $stmt = $this -> db -> prepare("SELECT * FROM donors WHERE blood_type LIKE ?");
            $stmt->execute([$bloodGroup]);
            return $stmt->fetchAll();
        }

        public function searchDonorByCity($city) {
            $stmt = $this->db->prepare("SELECT * FROM donors WHERE city LIKE ?");
            $stmt->execute(["%".$city."%"]);
            return $stmt->fetchAll();
        }

        public function logout() {
            session_start();
            session_unset();
            session_destroy();
            header("Location: http://localhost/Blood_Bank_Management_System/login.php");
        }
    }
?>