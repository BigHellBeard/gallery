<?php 
require_once (__DIR__ . '/constants.php');
if (!is_dir(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755);
}

if (empty($_FILES['files']['name'][0])) { 
    $notification['style'][0] = 'error';
    $notification['msg'][0] = 'Выберите файл для загрузки';
    echo json_encode($notification);
    die;
} 
        //цикл с проверкой всех условий 
foreach ($_FILES['files']['name'] as $index => $value) { 
    if ($index == FILE_LIM_REQUEST) {
        $notification['style'][$index] = 'error';
        $notification['msg'][$index] = 'Достигнут лимит колличества одновременно загружаемых файлов';
        break;
    } 
    if (file_exists( UPLOAD_PATH . $_FILES['files']['name'][$index] )) {
        $notification['style'][$index] = 'error';
        $notification['msg'][$index] = 'Файл с именем' . ' ' . $_FILES['files']['name'][$index] . ' ' . 'уже существует';
        continue;
    } 
    if ($_FILES['files']['size'][$index] > MAX_FILE_SIZE) {
        $notification['style'][$index] = 'error';
        $notification['msg'][$index] = $_FILES['files']['name'][$index] . ' ' . 'превысил лимит размера загружаемого файла';
        continue;
    }
    if (!in_array($_FILES['files']['type'][$index], ACCEPT_FILE_TYPES)) {
        $notification['style'][$index] = 'error';
        $notification['msg'][$index] = $_FILES['files']['name'][$index] . ' ' . 'неправильный тип загружаемого файла';
        continue;
    }
    if (!move_uploaded_file($_FILES['files']['tmp_name'][$index], UPLOAD_PATH . $_FILES['files']['name'][$index])) {
        $notification['style'][$index] = 'error';
        $notification['msg'][$index] = 'При загрузке файла' . ' ' . $_FILES['files']['name'][$index] . ' ' . 'произошла ошибка';
        continue;
    }
    $notification['style'][$index] = 'success';
    $notification['msg'][$index] = 'Файл' . ' ' . $_FILES['files']['name'][$index] . ' ' . 'успешно загружен';
} 
//json массив с ответом от сервера 
echo json_encode($notification);
