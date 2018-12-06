// функция генерирующа html код отображения загруженных файлов 
function galleryLayout (data){
    $.each(data.fileName, function(i,value){
        $('#output').append(
            $('<div>', {class: "layout"}).append(
                $('<img>',{src: '/upload/'+value}),$('<div>', {class: "info"}).append(
                    $('<input>',{type: "checkbox", name: "delete[]", value: value}),
                    $('<p>').append(data.fileSize[i]),
                    $('<p>').append(data.fileDate[i])
                )
            )
        );
    })    
}

function updateContent() {
	    $.ajax({
        method: 'POST',
        url: 'download.php',
        dataType: 'json',
        success: function(data){
        	$( '.layout' ).remove();
            galleryLayout (data);
        }
    }); 
}


$(function() {
	updateContent();
	$('#upload_form').on('submit',function(e) {
	 	e.preventDefault();
	 	$.ajax({
	 		url: 'upload.php',
	 		method: 'POST',
	 		data: new FormData(this),
	 		contentType: false,
	 		processData: false,
	 		dataType: 'json',
			success: function(data){
			    $.each(data.msg, function(i,value){
	 			    $('#upload-notfication').prepend($('<p>',{class: data.style[i]}).append(value));
	 		    });
	 		    updateContent();
	 	    }
	 	});
	});
    // ajax запрос для первичной загрузки файлов 
// ajax запрос на удаление выделенных файлов, после удаления обновляет содержимое
    $('#delete_form').on('submit',function(e) {
        e.preventDefault();
        $.ajax({
            url: 'delete.php',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: 'json',
        });
        updateContent();
    });
});

