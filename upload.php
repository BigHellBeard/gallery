<?php 
    $maxFileSize = 5000000; // максимальный размер одного загружаемого файла
    $downloadFilesLimit = 5; // лимит одновременно загружаемых файлов
    $acceptFileTypes = array('image/png', 'image/jpeg', 'image/jpg'); // типы принимаемых файлов
    $uploadPath = __DIR__ . '/upload/'; //дирректория загрузки файлов
    $i=0;
    //цикл с проверкой всех условий 

    if(empty($_FILES['files']['name'][0])) { 
        $notification['style'][0] = 'error';
        $notification['msg'][0] = 'Выберите файл для загрузки';

    } else { 
        foreach ($_FILES['files']['name'] as $index => $value) { 
            if ($index == $downloadFilesLimit){
                $notification['style'][$i] = 'error';
                $notification['msg'][$i] = 'Достигнут лимит колличества одновременно загружаемых файлов';
                break;
            } elseif (file_exists( $uploadPath . $_FILES['files']['name'][$index] )) {
                $notification['style'][$i] = 'error';
                $notification['msg'][$i] = 'Файл с именем' . ' ' . $_FILES['files']['name'][$index] .' '. 'уже существует';
                $i++;
                continue;
            } elseif($_FILES['files']['size'][$index] > $maxFileSize){
                $notification['style'][$i] = 'error';
                $notification['msg'][$i] = $_FILES['files']['name'][$index] . ' ' . 'превысил лимит размера загружаемого файла';
                $i++;
                continue;
            } elseif (!in_array($_FILES['files']['type'][$index], $acceptFileTypes)) {
                $notification['style'][$i] = 'error';
                $notification['msg'][$i] = $_FILES['files']['name'][$index] .' '. 'неправильный тип загружаемого файла';
                $i++;
                continue;
            } else {
                if(move_uploaded_file($_FILES['files']['tmp_name'][$index], $uploadPath . $_FILES['files']['name'][$index])){
                    $notification['style'][$i] = 'success';
                    $notification['msg'][$i] = 'Файл' . ' ' . $_FILES['files']['name'][$index] . ' ' . 'успешно загружен';
                    $i++;
                    continue;
                } else {
                    $notification['style'][$i] = 'error';
                    $notification['msg'][$i] = 'При загрузке файла' . ' ' . $_FILES['files']['name'][$index] . ' ' . 'произошла ошибка';
                    $i++;
                    continue;
                }
            } 
        }
    }  //json массив с ответом от сервера 
    echo json_encode($notification);
?>