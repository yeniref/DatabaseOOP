# Database OOP


## Tek Satır Çekme

$getir = $DB->Getir("Select * from user Where id = :id", ['id' => '1'])[0]; //tek satır

print_r($getir);

## Tüm Satırları Çekme

$getir = $DB->Getir("Select * from user"); //tüm tablo

print_r($getir);

## Satır Ekleme

$data = [
    'username' => 'username',
    'email' => 'energyspor21@gmail.com',
    'password' => '012345678910',
    'create_date' => date('Y-m-d H:i:s', time())
];

$id = $DB->Ekle("INSERT INTO `user` (`username`, `email`, `password`, `created_date`) values ( :username , :email, :password, :create_date)", $data);

print_r($id); //son id

## Satır Güncelleme

$data = [
    'id' => 1,
    'username' => 'username',
    'email' => 'energyspor21@gmail.com',
    'password' => '012345678910',
];


$id = $DB->Guncelle("Update `user` SET `username` = :username, `email` = :email, `password` = :password where id = :id", $data);

print_r($id); //donus 1 / 0

## Satır Silme

$data = [
    'id' => 31
];

$id =     $DB->Sil("Delete from user where id = :id", $data);

print_r($id); //donus 1 / 0
