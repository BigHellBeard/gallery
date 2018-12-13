<?php
require_once (__DIR__ . '/constants.php');
//удаление файлов 
if (isset($_POST['delete'])) {
	foreach ($_POST['delete'] as $key => $fileName) {
		unlink(UPLOAD_PATH . $fileName);
	}
}
