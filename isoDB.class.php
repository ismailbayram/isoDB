<?php
class isoDB extends PDO{
	private $host,$user,$pass,$db,$sql,$where,$limit,$like,$orderby,$count;
	
	public function __construct($host,$user,$pass,$db){
		parent::__construct('mysql:host='.$host.';dbname='.$db,$user,$pass);
		$this->query('SET CHARACTER SET UTF8');
        $this->query('SET NAMES UTF8');
	}

	public function select_from($table_name,$column_name = "*"){
		$this->sql = 'SELECT '.$column_name.' FROM '.$table_name;
		return $this;
	}

	public function where($query,$condition = "and"){
		$sql_where = ' WHERE ';
		foreach($query as $key => $value){
			$sql_where .= $key." = '".$value."' ".$condition." ";
		}
		$this->where = substr($sql_where, 0,-4);
		return $this;
	}	

	public function like($column_name,$string){
		$this->like = " WHERE ".$column_name." LIKE '".$string."'";
		return $this;
	}

	public function orderby($column_name,$type = "ASC"){ # bu metod kullanılırsa run() metodunun ikinci parametresi true olamaz!!
		$this->orderby = " ORDER BY ".$column_name." ".$type;
		return $this;
	}

	public function limit($start,$limit){
		$this->limit = " LIMIT ".$start.",".$limit." ";
		return $this;
	}

	public function run($single = false, $orderbyrand = false){ #$single -> bir tek veri getirir, $orderbyrand -> rastgele mi değil mi?
		if($this->where){
			$this->sql .= $this->where;
		}		

		if($this->like){
			$this->sql .= $this->like;
		}

		if($this->orderby){
			$this->sql .= $this->orderby;
		}

		if($orderbyrand){
			$this->sql .= " ORDER BY RAND() ";
		}

		if($this->limit){
			$this->sql .= $this->limit;
		}

		$query = $this->query($this->sql);

		if($single){
			return $query->fetch(parent::FETCH_ASSOC);
		}else{
			return $query->fetchAll(parent::FETCH_ASSOC);
		}
	}

	public function count_datas($table_name){
		$this->count = "SELECT COUNT(*) as toplam FROM ".$table_name;
		$sonuc = $this->query($this->count);
		return $sonuc->fetch(parent::FETCH_ASSOC);
	}

	public function insert($table_name,$datas){		
		$keys = [];
		$vals = [];
		foreach($datas as $col => $val){
			$keys[] = $col;
			$vals[] = "'".$val."'";
		}
		$columns = implode(",",$keys);
		$values = implode(",", $vals);
		$this->sql = "INSERT INTO ".$table_name."(".$columns.") VALUES (".$values.")";
		$sonuc = $this->exec($this->sql);
		return $sonuc;
	}

	public function update($table_name,$datas,$where){
		$query = "";
		foreach($datas as $col => $val){
			$query .= $col."='".$val."', ";
		}
		$query_last = substr($query, 0,-2);
		$update = "UPDATE ".$table_name." SET ".$query_last." WHERE ".$where;
		$sonuc = $this->exec($update);
		return $sonuc;
	}

	public function delete($table_name,$where){
		$delete = "DELETE FROM ".$table_name." WHERE ".$where;
		$sonuc = $this->exec($delete);
		return $sonuc;
	}

	public function lastID(){
        return $this->lastInsertId();
    }
}

// $isoDB = new isoDB("localhost","root","","whatisyourfont");
// $sonuc = $isoDB->select_from("personel")->where(array("pozisyon" => "yazılım","maas" => 1300),"or")->run();
// $ekle = $isoDB->insert("personel",["adsoyad"=>"yeni kayıt","pozisyon"=>"yeni makam","maas" => 3500]);
// $guncelle = $isoDB->update("personel",["adsoyad"=>"aaa","pozisyon"=>"güvenlik","maas" => 1300],"id=10");
// $sil = $isoDB->delete("personel","pozisyon='yeni makam'");
// $sayi = $isoDB->count_datas('fonts');
?>
