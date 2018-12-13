<?php
require_once (__DIR__ . '/constants.php');
function fileSizeScale ($value) {
	if ($value <= 10000) {
		return round($value, 2) . ' b';
	}
	if ($value > 10000 && $value <= 1000000) {
		return round($value / 1000, 2) . ' kb';
	}
	if ($value > 1000000 && $value <= 5000000) {
		return round($value / 1000000, 2) . ' Mb';
	}
}

$files = [];
if ($handle = opendir(UPLOAD_PATH)) {
	while ($entry = readdir($handle)) {
        if (!is_file(UPLOAD_PATH . $entry)) {
        	continue;
        }
		$files[] = [
    		'name' => $entry,
    		'size' => fileSizeScale(filesize(UPLOAD_PATH . $entry)),
    		'date' => date("d.m.Y H:i:s", filemtime(UPLOAD_PATH . $entry)),
		];
	}
	closedir($handle);
} // отправка json массива
echo json_encode($files);
