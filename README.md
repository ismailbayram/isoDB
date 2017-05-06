# isoDB
A PHP class for DB processes with PDO
$isoDB = new isoDB("localhost","root","","whatisyourfont");
$sonuc = $isoDB->select_from("personel")->where(array("pozisyon" => "yazılım","maas" => 1300),"or")->run();
$ekle = $isoDB->insert("personel",["adsoyad"=>"yeni kayıt","pozisyon"=>"yeni makam","maas" => 3500]);
$guncelle = $isoDB->update("personel",["adsoyad"=>"aaa","pozisyon"=>"güvenlik","maas" => 1300],"id=10");
$sil = $isoDB->delete("personel","pozisyon='yeni makam'");
$sayi = $isoDB->count_datas('fonts');
