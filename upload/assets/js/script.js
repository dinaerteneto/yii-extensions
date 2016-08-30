$(function(){
    
    var dropbox = $('#dropbox'),
    message = $('.message', dropbox);
    
    var templateOptions = '<span class="remove-attach">x</span>';
	
    dropbox.filedrop({
        // The name of the $_FILES entry:
        paramname:'pic',
        maxfiles: 20,
        maxfilesize: 2,
        url: 'upload',
		
        uploadFinished:function(i,file,response){
            
            $.data(file).addClass('done');
            
            $.data(file).find('.progressHolder').hide();
            //$("#upload-container #dropbox").css('width', ($("#upload-container #dropbox > div").length * 246));
            
            $.data(file).append($(templateOptions.replace(/{index}/g, ($("#upload-container #dropbox > div.done").length - 1))));
            
            if( $("#upload-container #dropbox > div").length > 0 ) {
                $("#upload-container .message-bottom").css('display', 'block');
            }

            if( $("#upload-container #dropbox > div").length > 1 ) {
                $("#upload-container #dropbox").addClass('more');
            }

            $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'Upload[]')
            .attr('value', response.name)
            .appendTo( $.data(file) );
    
            //marcar que existem fotos na barra de acoes anexos
            $('.btn-adicionar .bg-foto').addClass('c-itens');
            // response is the JSON object that post_file.php returns
        },
		
        error: function(err, file) {
            switch(err) {
                case 'BrowserNotSupported':
                    showMessage('Seu navegador não suporta o upload de arquivos em HTML5!');
                    break;
                case 'TooManyFiles':
                    alert('Muitos arquivos! Por favor selecione 20 no máximo!');
                    break;
                case 'FileTooLarge':
                    alert(file.name+' é muito grande! Faça upload de arquivos de até 2mb.');
                    break;
                default:
                    break;
            }
        },
		
        // Called before each upload is started
        beforeEach: function(file){
            if(!file.type.match(/^image\//)){
                alert('Só é possivel enviar arquivos de imagem ( jpg, gif e png )');
				
                // Returning false will cause the
                // file to be rejected
                return false;
            }
        },
		
        uploadStarted:function(i, file, len){
            createImage(file);
        },
		
        progressUpdated: function(i, file, progress) {
            $.data(file).find('.progress').width(progress);
        }
    	 
    });
	
    var template = '<div class="preview">'+
    '<span class="imageHolder">'+
    '<img />'+
    '<span class="uploaded"></span>'+
    '</span>'+
    '<div class="progressHolder">'+
    '<div class="progress"></div>'+
    '</div>'+
    '</div>';
	
	
    function createImage(file){
        var preview = $(template), 
        image = $('img', preview);
			
        var reader = new FileReader();
		
        image.width = 236;
        //image.height = 100;
		
        reader.onload = function(e){
			
            // e.target.result holds the DataURL which
            // can be used as a source of the image:
			
            image.attr('src',e.target.result);
        };
		
        // Reading the file as a DataURL. When finished,
        // this will trigger the onload function above:
        reader.readAsDataURL(file);
		
        message.hide();
        preview.appendTo(dropbox);
		
        // Associating a preview container
        // with the file, using jQuery's $.data():
		
        $.data(file,preview);
    }

    function showMessage(msg){
        message.html(msg);
    }
    
    $('#upload-container').on('click', '.remove-attach', function() {
        $(this).parent().remove();
        if( $("#upload-container #dropbox > div").length < 1 ) {
            $("#upload-container .message-bottom").css('display', 'none');
            $("#upload-container .message").css('display', 'block');
        }
    });

});