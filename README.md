# isoDB
A PHP class for DB processes with PDO

## Conection
$isoDB = new isoDB("localhost","root","","whatisyourfont");
## Selecting
$sonuc = $isoDB->select_from("personel")->where(array("pozisyon" => "yazılım","maas" => 1300),"or")->run();
## Inserting
$ekle = $isoDB->insert("personel",["adsoyad"=>"yeni kayıt","pozisyon"=>"yeni makam","maas" => 3500]);
## Updating
$guncelle = $isoDB->update("personel",["adsoyad"=>"aaa","pozisyon"=>"güvenlik","maas" => 1300],"id=10");
## Deleting
$sil = $isoDB->delete("personel","pozisyon='yeni makam'");
## Counting
$sayi = $isoDB->count_datas('fonts');
