<html>
<head>
<title>Простой блог: редактирование</title>
</head>
<body>
<a href="./../">назад</a>
<?php foreach ($result as $row) { ?>
<form method="post" action="/editpost">
	<input type=text name="name" value=<?=$row['name'];?>><br>
	<input type=text name="alias" value=<?=$row['alias'];?>><br>
	<input type=hidden name="id" value=<?=$row['id'];?>>
	<textarea name="text"><?=$row['text'];?></textarea><br>
	<input type="submit" value="Сохранить">
</form>
<?php }; ?>
</body>
</html>