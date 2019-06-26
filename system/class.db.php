<?php
/**
* temel veritabanı işlemlerini kolaylaştıran veritabanı sınıfı
*/
class Db extends PDO
{
	/**
	* [$sql veritabanı sorgu cümlesi]
	* @var [private]
	*/
	private $sql;
	/**
	* [$data array halinde işlenecek olan veri]
	* @var [private]
	*/
	private $data;
	/**
	* [$son_eklenen_id veritabanına son eklenen kaydın id değeri]
	* @var [private]
	*/
	private $son_eklenen_id;
	/**
	* [$count listeleme sonucundan dönen kayıt sayısı]
	* @var [private]
	*/
	private $count;
	/**
	* [$error pdo sorgularında hata oluşursa oluşan hatayı tutan değişken]
	* @var [private]
	*/
	private $error;
	/**
	* [__construct pdo üzerinden veritabanı bağlantısını sağlayan kısım]
	* @param [string] $host    [sunucu adı]
	* @param [string] $db      [veritabanı adı]
	* @param [string] $user    [veritabanı kullanıcı adı]
	* @param [string] $pass    [veritabanı kullanıcı şifresi]
	* @param string $charset [veritabanı bağlantı karakter seti]
	*/
	function __construct($host,$db,$user,$pass,$charset="utf8")
	{
		try {
			/**
			* veritabanı bağlantısını sağla
			*/
			parent::__construct("mysql:host={$host};dbname={$db};charset={$charset}",$user,$pass);
			parent::setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			/**
			* oluşan hatayı ekrana bas
			*/
			die("<p style='background:red;padding:8px 20px;'><strong style='color:white;'>Bağlantı Hatası..</strong></p>");
		}
	}
	/**
	* [query kullanıcıdan sql sorgusu alır]
	* @param  [string] $sql [sorgu cumlesi]
	* @return [function]      [zincirleme metod kullanımı için ]
	*/
	public function query($sql)
	{
		$this->sql = $sql;
		return $this;
	}
	/**
	* [data kullanıcıdan alınan  veri]
	* @param  [array] $array [dizi verisi]
	* @return [function]      [zincirleme metod kullanımı için ]
	*/
	public function data($array)
	{
		$this->data = $array;
		return $this;
	}
	/**
	* [insert ekleme işlemi]
	* @return [boolen] []
	*/
	public function insert()
	{
		try{
			$sorgu = parent::prepare( $this->sql );
			$sorgu->execute( $this->data );
			/**
			* [$this->son_eklenen_id son eklenen kaydın ıd değeri]
			* @var [integer]
			*/
			$this->son_eklenen_id = parent::lastInsertId();
			if ($this->son_eklenen_id>0) {
				return true;
			}else{
				return false;
			}
		}catch(PDOException $e){
			$this->error=$e->getMessage();
			return false;
		}
	}
	/**
	* [select seçme işlemi]
	* @param  integer/null $value [1 ise tek kayıt değil ise birden fazla kayıt döndürür.]
	* @return [data/false]        []
	*/
	public function select($value="")
	{
		try {
			if (trim($value)==1) {
				$sorgu=parent::prepare( $this->sql );
				$sorgu->execute( $this->data );
				/**
				* [$donen_kayit_adedi sorgu sonucundan etilenen satır sayısı]
				* @var [integer]
				*/
				$donen_kayit_adedi = $sorgu->rowCount();
				if ( $donen_kayit_adedi>0) {
					$this->count=$donen_kayit_adedi;
					return $sorgu->fetch(PDO::FETCH_ASSOC);
				}else{
					return false;
				}
			}else{
				$sorgu=parent::prepare( $this->sql );
				$sorgu->execute( $this->data );
				/**
				* [$donen_kayit_adedi sorgu sonucundan etilenen satır sayısı]
				* @var [integer]
				*/
				$donen_kayit_adedi = $sorgu->rowCount();
				if ( $donen_kayit_adedi>0) {
					$this->count=$donen_kayit_adedi;
					return $sorgu->fetchAll(PDO::FETCH_ASSOC);
				}else{
					return false;
				}
			}
		} catch (Exception $e) {
			$this->error=$e->getMessage();
			return false;
		}
	}
	public function update()
	{
		try{
			$sorgu = parent::prepare( $this->sql );
			$sorgu->execute( $this->data );
			/**
			* sorgu sonucundan etilenen satır sayısı var ise
			*/
			if ($sorgu->rowCount()) {
				return true;
			}else{
				return false;
			}
		}catch(PDOException $e){
			$this->error=$e->getMessage();
			return false;
		}
	}
	public function delete()
	{
		try{
			$sorgu = parent::prepare( $this->sql );
			$sorgu->execute( $this->data );
			/**
			* sorgu sonucundan etilenen satır sayısı var ise
			*/
			if ($sorgu->rowCount()) {
				return true;
			}else{
				return false;
			}
		}catch(PDOException $e){
			$this->error=$e->getMessage();
			return false;
		}
	}
	/**
	* [getError sorguda oluşan hata]
	* @return [string] [hata]
	*/
	public function getError()
	{
		return $this->error;
	}
	/**
	* [getCount sorgudan dönen kayıt adedi]
	* @return [integer] [kayıt adedi]
	*/
	public function getCount()
	{
		return $this->count;
	}
	/**
	* [last_insert_id son eklenen kaydın id idsi]
	* @return [integer] [son eklenen kayıt]
	*/
	public function last_insert_id()
	{
		return $this->son_eklenen_id;
	}
}
