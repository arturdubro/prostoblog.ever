<?php
class db {
	public function __construct() {
		$host = 'mysql:dbname=prostoblog;host=127.0.0.1';
		$user = 'root';
		$password = '';
		$this->mysql = new PDO($host,$user,$password);
	}
	public function query($param) {
		$sql = $this->mysql->prepare($param);
		$sql->execute();
		$this->result = $sql->fetchAll();
		return $this->result;
	}
	public function post($url) {
		if (empty($url)) {
			$this->query('SELECT * FROM entry ORDER BY id DESC');
			$result = $this->result;
			include 'view/index_view.php';
		};
		if (is_string($url)) {
			$sql = 'SELECT * FROM entry WHERE alias="'.$url.'"';
			$result = $this->query($sql);
			$result = $this->result;
			include 'view/post_view.php';
		};
	}
	public function loggedin() {
		@$key = $_COOKIE['key'];
		@$userid = $_COOKIE['userid'];
		$sql = 'SELECT * FROM login WHERE id="'.$userid.'" AND cookie="'.$key.'"';
		$result = $this->query($sql);
		if (!empty($result)) return TRUE;
	}
}