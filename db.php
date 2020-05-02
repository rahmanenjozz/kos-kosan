<?php
class DB {  
	public static $host = "localhost";
  	public static $user = "root";
  	public static $pass = "";
  	public static $dbName = "kos";
  	public static $open = FALSE;

	public function __construct() {  
    	// static::$host = $host;
    	// static::$user = $user;
    	// static::$pass = $pass;
    	// static::$dbName = $dbName;
    	static::$open = @mysqli_connect(static::$host, static::$user, static::$pass, static::$dbName); 
    	if(!static::$open) die(mysqli_connect_error() . PHP_EOL);
  	} 

  	public static function close() {
    	return mysqli_close(static::$open);
  	}

 	public function query($Q="") {
    	return mysqli_query(static::$open,$Q);
  	}  
	
	public function error() {
    	return mysqli_error(static::$open);
  	} 

  	public function escape_string($Q="") {
  		return mysqli_real_escape_string(static::$open, $Q);
  	}
}
 
class CRUD extends DB { 
	private $table   = "";
	private $select  = "";
	private $join    = "";
	private $where   = "";
	private $order   = "";
	private $limit   = "";
	
	public static function begin() { $this->query("BEGIN"); }
	public static function commit() { $this->query("COMMIT"); }
	public static function rollback() { $this->query("ROLLBACK"); }

	public function getPrimary($table="") {
		try { 
			$Q = $this->query("SHOW INDEX FROM $table WHERE Key_name = 'PRIMARY'");  
			if(!$Q) throw new Exception($this->error()); 
			if(is_resource($Q) OR is_object($Q)) { 
				if(mysqli_num_rows($Q) == 0) throw new Exception("Tidak ada Field sebagai PrimaryKey");
				$D = mysqli_fetch_array($Q, MYSQLI_ASSOC);
				extract($D); 
				return ["key" => $Column_name]; 
			}
		} catch (Exception $e) {
		    return $e->getMessage(); 
		} 
	}
	public function select($select="") {
		$S = "";
		if(is_array($select)) {
			$no = 0;
			foreach ($select as $key => $value) {
				$no++;
				$S .= (is_numeric($key) ? $value:$value." AS ".$key);
				$S .= ($no < count($select) ? ", ":"");
			}
		} else {
			$S .= $select;
		}  
		if(!empty($S)) $this->select .= ($this->select == "" ? $S:", $S");
		return $this;
	}
	public function leftJoin($table="", $kondisi="") { 
		$COND = "";
		if(is_array($kondisi)) {
			$no = 0;
			foreach ($kondisi as $key => $value) {
				$no++;
				$COND .= $value.($no < count($kondisi) ? " AND ":""); 
			}
		} else {
			$COND = $kondisi;
		}  
		$this->join .= " LEFT JOIN $table ON $COND ";
		return $this;
	}
	public function where($kondisi="") { 
		$COND = "";
		if(is_array($kondisi)) {
			$no = 0;
			foreach ($kondisi as $key => $value) {
				$no++;
				$COND .= $value.($no < count($kondisi) ? " AND ":""); 
			}
		} else {
			$COND = $kondisi;
		}   
		if(!empty($COND))
			$this->where .= ($this->where == "" ? " $COND ":" AND $COND ");
		return $this;
	} 
	public function orderBy($order="") { 
		$O = "";
		if(is_array($order)) {
			$no = 0;
			foreach ($order as $key => $value) {
				$no++;
				$O .= (is_numeric($key) ? $value:$key." ".$value);
				$O .= ($no < count($order) ? ", ":"");
			}
		} else {
			$O .= $order;
		}  
		$this->order .= (strlen($this->order) == 0 ? $O:", $O");
		return $this;
	}
	public function limit($offset="", $limit="") { 
		if(is_numeric($offset) AND !is_numeric($limit)) $this->limit = "LIMIT $offset";
		if(is_numeric($offset) AND is_numeric($limit))  $this->limit = "LIMIT $offset, $limit";
		return $this;
	}
	public function get($table="") {
		return $this->getArray($this->_get($table));
	}
	public function one($table="") {
		$this->limit = "LIMIT 1";
		$temp = $this->getArray($this->_get($table));
		$temp = count($temp) > 0 ? $temp[0]:[];
		return $temp;
	}
	public function json($table="") {
		try {
			$Q = $this->get($table);
			if(!is_array($Q)) throw new Exception($Q);
			return json_encode($Q);
		} catch (Exception $e) {
			return $e->getMessage(); 
		} 
	}
	public function oneJSON($table="") {
		try {
			$Q = $this->one($table);
			if(!is_array($Q)) throw new Exception($Q);
			return json_encode($Q);
		} catch (Exception $e) {
			return $e->getMessage(); 
		} 
	}

	public function insert($table="") {  
		try {
			if(!isset($_POST[$table])) throw new Exception("Data yang disimpan tidak ada");  
			$no    = 0; 
			$field = "";
			$val   = "";
			// if($table != 'pengguna') $_POST[$table]["user"] = USER::$USERNAME;
			foreach ($_POST[$table] as $key => $value) {
				$no++;
				$field .= "`".$key."`";
				$val   .= "'".$this->escape_string($value)."'";
				if($no<count($_POST[$table])) {
					$field .= ", ";
					$val   .= ", ";
				}  
			}   
			$Q = $this->query("INSERT INTO `$table`($field) VALUES($val)");  
			if(!$Q) throw new Exception($this->error()); 
			return TRUE;
		} catch (Exception $e) {
		    return $e->getMessage(); 
		} 
	}

	public function update($table="", $where=array()) { 
		try {
			$COND = "";
			if(!isset($_POST[$table])) throw new Exception("Data yang disimpan tidak ada");  
			if(count($where) > 0) { 
				if(is_array($where)) {
					$nos = 0;
					foreach ($where as $key => $value) {
						$nos++;
						$COND .= " $key = '$value' ".($nos < count($where) ? " AND ":""); 
					}
				} else {
					$COND = $where;
				}   
			} else {
				if(empty($_POST["_id"])) throw new Exception("ID tidak ada"); 
				else {
					$primary = $this->getPrimary($table);
					if(!is_array($primary)) throw new Exception($primary); 
					$COND = "`$primary[key]` = '$_POST[_id]' ";
				} 
			} 
			$COND = empty($COND) ? "":"WHERE $COND";
			$no  = 0;  
			$val = "";
			// if($table != 'pengguna') $_POST[$table]["user"] = USER::$USERNAME;
			foreach ($_POST[$table] as $key => $value) {
				$no++; 
				$val .= "`$key`='".$this->escape_string($value)."'";
				if($no<count($_POST[$table])) { 
					$val .= ", ";
				}  
			}   
			$Q = $this->query("UPDATE `$table` SET $val $COND");  
			if(!$Q) throw new Exception($this->error()); 
			return TRUE;
		} catch (Exception $e) {
		    return $e->getMessage(); 
		} 
	}

	public function delete($table="", $where=array()) { 
		try {
			$COND = ""; 
			if(count($where) > 0) { 
				if(is_array($where)) {
					$nos = 0;
					foreach ($where as $key => $value) {
						$nos++;
						$COND .= $value.($nos < count($where) ? " AND ":""); 
					}
				} else {
					$COND = $where;
				}   
			} else {
				if(empty($_POST["_id"])) throw new Exception("ID tidak ada"); 
				else {
					$primary = $this->getPrimary($table);
					if(!is_array($primary)) throw new Exception($primary); 
					$COND = "`$primary[key]` = '$_POST[_id]' ";
				} 
			} 
			$COND = empty($COND) ? "":"WHERE $COND";   
			$Q = $this->query("DELETE FROM `$table` $COND");  
			if(!$Q) throw new Exception($this->error()); 
			return TRUE;
		} catch (Exception $e) {
		    return $e->getMessage(); 
		} 
	}

	private function _get($table="") { 
		try {
		    $this->select = strlen($this->select) == 0 ? "*":$this->select;
			$this->join   = strlen($this->join)   == 0 ?  "":$this->join;
			$this->where  = strlen($this->where) == 0 ?   "":" WHERE ".$this->where;
			$this->order  = strlen($this->order) == 0 ?   "":" ORDER BY ".$this->order;
			$Q = $this->query("SELECT ".$this->select." FROM $table ".$this->join." ".$this->where." ".$this->order." ".$this->limit); 
			if(!$Q) throw new Exception($this->error()); 
			return $Q;
		} catch (Exception $e) {
		    return $e->getMessage(); 
		} 
	}
	private function getArray($Q=array()) { 
		try {  
			if(!is_resource($Q) AND !is_object($Q)) throw new Exception($Q); 
			$field = [];
			while($temp = mysqli_fetch_field($Q)) {
				array_push($field, $temp->name);
			}
			$D = [];
			while($t = mysqli_fetch_array($Q, MYSQLI_ASSOC)) {
				$A = [];
				foreach ($field as $key => $value) {
					$A[$value] = $t[$value];
				}
				array_push($D, $A);
			} 
			return $D;
		} catch (Exception $e) {
			return $e->getMessage(); 
		}
	} 
}
  

// $Q = new CRUD(); 
// var_dump($Q->select()
// 		   ->get("jenis_arsip")); 
// die();

?>