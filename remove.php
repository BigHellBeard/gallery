<?php
$path = __DIR__.'/upload/';
//удаление файлов 
if (isset($_POST['delete'])){
	foreach ($_POST['delete'] as $key => $fileName) {
		unlink($path.$fileName);
	}
}
?>

