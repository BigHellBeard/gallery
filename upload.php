<?php 
require_once (__DIR__ . '/constants.php');
if (!is_dir(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755);
}

$notification = [];

if (empty($_FILES['files']['name'][0])) { 
    $notification [] = [
    'style' => 'error',
    'msg' => 'Выберите файл для загрузки',
    ];
    echo json_encode($notification);
    die;
} 
        //цикл с проверкой всех условий 
foreach ($_FILES['files']['name'] as $index => $value) { 
    if ($index == FILE_LIM_REQUEST) {
        $notification [] = [
            'style' => 'error',
            'msg' => 'Достигнут лимит колличества одновременно загружаемых файлов',
        ];
        break;
    } 
    if (file_exists( UPLOAD_PATH . $_FILES['files']['name'][$index] )) {
        $notification [] = [
            'style' => 'error',
            'msg' => 'Файл с именем' . ' ' . $_FILES['files']['name'][$index] . ' ' . 'уже существует',
        ];
        continue;
    } 
    if ($_FILES['files']['size'][$index] > MAX_FILE_SIZE) {
        $notification [] = [
            'style' => 'error',
            'msg' => $_FILES['files']['name'][$index] . ' ' . 'превысил лимит размера загружаемого файла',
        ];
        continue;
    }
    if (!in_array($_FILES['files']['type'][$index], ACCEPT_FILE_TYPES)) {
        $notification [] = [
            'style' => 'error',
            'msg' => $_FILES['files']['name'][$index] . ' ' . 'неправильный тип загружаемого файла'
        ];
        continue;
    }
    if (!move_uploaded_file($_FILES['files']['tmp_name'][$index], UPLOAD_PATH . $_FILES['files']['name'][$index])) {
        $notification [] = [
            'style' => 'error',
            'msg' => 'При загрузке файла' . ' ' . $_FILES['files']['name'][$index] . ' ' . 'произошла ошибка',
        ];
        continue;
    }
        $notification [] = [
            'style' => 'success',
            'msg' => 'Файл' . ' ' . $_FILES['files']['name'][$index] . ' ' . 'успешно загружен',
        ];
} 
//json массив с ответом от сервера 
echo json_encode($notification);
