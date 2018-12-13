// функция генерирующа html код отображения загруженных файлов 
function galleryLayout(data) {
    $.each(data, function(i, array) {
       	$('#output').append(
           	$('<div>', {class: 'layout'}).append(
               	$('<img>', {src: '/upload/' + array.name}), $('<div>', {class: 'info'}).append(
                   	$('<input>', {type: 'checkbox', name: 'delete[]', value: array.name}),
                   	$('<p>').append(array.size),
                   	$('<p>').append(array.date),
               	)
           	)
       	);
    })    
}

function updateContent() {
	    $.ajax({
        method: 'POST',
        url: 'file_list.php',
        cache: false,
        dataType: 'json',
        success: function(data) {
        	$('.layout').remove();
        	if (data != null) {
            	galleryLayout (data);
            }
        }
    }); 
}


$(function() {
	updateContent();
	$('#upload_form').on('submit', function(e) {
	 	e.preventDefault();
	 	$.ajax({
	 		url: 'upload.php',
	 		method: 'POST',
	 		data: new FormData(this),
	 		contentType: false,
	 		processData: false,
	 		cache: false,
	 		dataType: 'json',
			success: function(data) {
			    $.each(data, function(i, array) {
	 			    $('#upload-notfication').prepend($('<p>', {class: array.style}).append(array.msg));
	 		    });
	 		    updateContent();
	 	    }
	 	});
	});
	// ajax запрос на удаление выделенных файлов, после удаления обновляет содержимое
    $('#delete_form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'remove.php',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            dataType: 'json',
        });
        updateContent();
    });
});
