<!DOCTYPE html>
	<html>
		<head>
			<link rel="stylesheet" href="style.css">
			<script type="text/javascript" src="jquery-3.3.1.min.js" ></script>
			<script type="text/javascript" src="script.js"></script>
		</head>
		<body>
			<form id="upload_form" enctype="multipart/form-data" action="index.php"  method="POST" >
				<input type="file" name="files[]" multiple accept="image/jpg, image/jpeg, image/png">
				<input type="submit" name="upload" value="загрузить">
 			</form>
 			<div id="upload-notfication"></div>
 			<form id="delete_form" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        		<input type="submit" value="Удалить" >
        	<div id="output"></div>
    		</form>
		</body>
	</html>