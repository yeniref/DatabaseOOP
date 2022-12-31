<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'yonet');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8mb4');
define('DB_COLLATE', '');

class Database
{

    private $baglanti = null;

    // bağlantı oluşturur
    public function __construct($dbhost = DB_HOST, $dbname = DB_NAME, $username = DB_USER, $password  = DB_PASS, $char = DB_CHAR)
    {

        try {

            $this->baglanti = new PDO("mysql:host={$dbhost};dbname={$dbname};charset={$char}", $username, $password);
            $this->baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->baglanti->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Veritabanı Tablosuna bir satır/satırlar ekler
    public function Ekle($sorgu = "", $parametre = [])
    {
        try {

            $this->Calistir($sorgu, $parametre);
            return $this->baglanti->lastInsertId();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Veritabanı Tablosunda bir satır/satırlar seçme
    public function Getir($sorgu = "", $parametre = [])
    {
        try {

            $hazirla = $this->Calistir($sorgu, $parametre);
            return $hazirla->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Veritabanı Tablosundaki bir satırı/satırları günceller
    public function Guncelle($sorgu = "", $parametre = [])
    {
        try {

            $hazirla = $this->Calistir($sorgu, $parametre);
           return $hazirla->rowCount();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Veritabanı Tablosundaki bir satırı/satırları kaldırma
    public function Sil($sorgu = "", $parametre = [])
    {
        try {

           $hazirla = $this->Calistir($sorgu, $parametre);
            return $hazirla->rowCount();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // döngü çalıştır
    private function Calistir($sorgu = "", $parametre = [])
    {
        try {

            $hazirla = $this->baglanti->prepare($sorgu);
            $hazirla->execute($parametre);
            return $hazirla;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

$DB = new Database(
    DB_HOST,
    DB_NAME,
    DB_USER,
    DB_PASS
);


$getir = $DB->Getir("Select * from user Where id = :id", ['id' => '1'])[0]; //tek satır

print_r($getir);

$getir = $DB->Getir("Select * from user"); //tüm tablo

print_r($getir);


$data = [
    'username' => 'username',
    'email' => 'energyspor21@gmail.com',
    'password' => '012345678910',
    'create_date' => date('Y-m-d H:i:s', time())
];

$id = $DB->Ekle("INSERT INTO `user` (`username`, `email`, `password`, `created_date`) values ( :username , :email, :password, :create_date)", $data);

print_r($id); //son id



$data = [
    'id' => 1,
    'username' => 'username',
    'email' => 'energyspor21@gmail.com',
    'password' => '012345678910',
];


$id = $DB->Guncelle("Update `user` SET `username` = :username, `email` = :email, `password` = :password where id = :id", $data);

print_r($id); //donus 1 / 0


$data = [
    'id' => 31
];

$id =     $DB->Sil("Delete from user where id = :id", $data);
print_r($id); //donus 1 / 0