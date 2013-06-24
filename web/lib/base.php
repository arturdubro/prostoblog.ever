<?php
class app {
	public function __construct($path) {
		$this->db = new db;
		$this->url = explode('/', $path);
		$this->run();
	}
	private function run() {
		$url = array_shift($this->url);
		if (!preg_match('#^[a-zA-Z0-9.,-]*$#', $url))
			throw new Exception('Неправильно набран номер');
		if ($url == 'add') { if ($this->db->loggedin()) include 'add_view.php'; };
		if ($url == 'addpost') $this->add();
		if ($url == 'logout') $this->logout();
		if ($url == 'login') include 'view/login_view.php';
		if ($url == 'auth') $this->login();
		if ($url == 'edit') $this->edit(array_shift($this->url));
		if ($url == 'editpost') $this->editpost();
		$this->db->post($url);
	}
	function login() {
		if (!empty($_POST)) {
		$sql = 'SELECT * FROM login WHERE name="'.$_POST['name'].'" AND password="'.md5($_POST['pass']).'"';
		$user = $this->db->query($sql);
		$user = array_shift($user);
		if ($user) {
			$key = md5(microtime().rand(0,100));
			setcookie('userid', $user['id'], time()+86400*30, '/');
			setcookie('key', $key, time()+86400*30, '/');
			$sql = 'UPDATE login SET cookie="'.$key.'" WHERE id="'.$user['id'].'"';
			$result = $this->db->query($sql);
			header("Location: /");
		} else
				$this->error = 'Неправильный логин или пароль';
		}		
		else header("Location: /");
	}
	function logout() {
		setcookie("userid", "", time()-3600);
		setcookie("key", "", time()-3600);
		header("Location: /");
	}
	function add() {
		$sql = 'SELECT * FROM entry WHERE alias="'.$_POST['alias'].'"';
		$result = $this->db->query($sql);
		if ($_POST['text'] == 'содержание поста') throw new Exception('не ленись!');
		if (!empty($result)) throw new Exception('такой алиас уже есть');
		if ($_POST['alias'] == 'add' | 'addpost' | 'login' | 'auth' | 'logout' ) throw new Exception('нельзя такой алиас!');
		$sql = 'INSERT INTO entry SET alias="'.$_POST['alias'].'", text="'.$_POST['text'].'", name="'.$_POST['name'].'"';
		$result = $this->db->query($sql);
		header("Location: /");
	}
	function edit($id) {
		if (!$this->db->loggedin()) header("Location:/login");
		$sql = 'SELECT * FROM entry WHERE alias="'.$id.'"';
		$result = $this->db->query($sql);
		include 'view/edit_view.php';
	}
	function editpost() {
		$sql = 'UPDATE entry SET alias="'.$_POST['alias'].'", text="'.$_POST['text'].'", name="'.$_POST['name'].'" WHERE id="'.$_POST['id'].'"';
		$result = $this->db->query($sql);
		header("Location:/");
		
	}
}