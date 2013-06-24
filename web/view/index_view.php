<html>
<head>
<title>Простой блог</title>
</head>
<body>
<h1>Привет!</h1>
<p>Содержание блога:</p>
<ul>
<?php foreach ($result as $row) { ?>
<li><a href="/<?=$row['alias'];?>"><?=$row['name'];?></a> <?php if($this->loggedin()) { ?>(<a href="edit/<?=$row['alias'];?>">правка</a>)<?php };?></li>
<?php }; ?>
</ul><br>
<?php if ($this->loggedin()) {?>
<a href="/add">добавить</a><br><a href="/logout">выйти</a>
<?php } else { ?>
<a href="/login">вход</a>
<?php }; ?>
</body>
</html>