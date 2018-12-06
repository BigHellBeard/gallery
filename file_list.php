<?php
	
	function fileSizeScale($value) {
		if ($value <= 10000)
			return round($value, 2) . ' b';
		if ($value > 10000 && $value <= 1000000)
			return round($value / 1000, 2) .' kb';
		if ($value > 1000000 && $value <= 5000000)
			return round($value / 1000000, 2) .' Mb';
	}

	$i = 0;
	$path = __DIR__.'/upload/';

	if ($handle = opendir($path)) {
    	while (false !== ($entry = readdir($handle))) {
        	if (is_file($path.$entry)) {
        		$file['fileName'][$i] = $entry;
        		$file['fileSize'][$i] = fileSizeScale(filesize($path.$entry));
        		$file['fileDate'][$i] = date("d.m.Y H:i:s",filemtime($path.$entry));
        		$i++;
        	}
    	}
    closedir($handle);
	} // отправка json массива
	echo json_encode($file);
?>
