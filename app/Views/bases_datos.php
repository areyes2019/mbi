<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<h1>Panel de bases de datos</h1>
	<a href="<?php echo base_url('regresar'); ?>">Limpiar todas las migraciones</a><br>
	<small>Solo si estas totalmente seguro</small>
	<br>
	<br>
	<a href="<?php echo base_url('migrar'); ?>">Migrar todo</a><br>
	<small>Solo si estas totalmente seguro</small>
	<br>
	<br>
	<form action="<?php echo base_url('batch'); ?>" method="POST">
		<label for="">Seleciona los pasos hacia a atras</label>
		<br>
		<select name="pasos" id="">
			<option value="">Selecciona  un paso</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
		<input type="submit" value="Ejecutar">
	</form>
</body>
</html>