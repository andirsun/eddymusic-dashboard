var typeDocument = 0;
var checkDocument_ = false;
var dataTableOptions = {
	'language': {
		'search': 'Buscar:',
		'zeroRecords': 'No se encontraron coincidencias',
		'info': 'Total categorias: _TOTAL_ ',
		'lengthMenu': "Mostrar _MENU_ entradas",
		'paginate': {
			'previous': 'anterior',
			'next': 'siguiente'
		}
	},
};
$(function(){
	console.log(666);
	clearInputFileCv();
	checkDoucument();
	sendTeacher();
	getTeachers();
	editarUsuario();
	cancelEditUser();
	updateUserInfo();
	deleteTeacher();
	uplaodFileCv();
	viewModalCv();
});
function base64toBlob(base64Data, contentType) {
  contentType = contentType || '';
  var sliceSize = 1024;
  var byteCharacters = atob(base64Data);
  var bytesLength = byteCharacters.length;
  var slicesCount = Math.ceil(bytesLength / sliceSize);
  var byteArrays = new Array(slicesCount);

  for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
      var begin = sliceIndex * sliceSize;
      var end = Math.min(begin + sliceSize, bytesLength);

      var bytes = new Array(end - begin);
      for (var offset = begin, i = 0; offset < end; ++i, ++offset) {
          bytes[i] = byteCharacters[offset].charCodeAt(0);
      }
      byteArrays[sliceIndex] = new Uint8Array(bytes);
  }
  return new Blob(byteArrays, { type: contentType });	
}
function clearInputFileCv() {
	$("#clearInputFileCv").click(function(event) {
		var form = $(this).closest('form');
		$(form)[0].reset();
	});
}
function checkDoucument(){
	$('input[name="document"]').change(function(event){
		var val = $(this).val();
		var data = {doc:val, type: typeDocument};
		var loader = $('#loader');
		$.ajax({
			url: base_url+'admin_ajax/checkDocument',
			type: 'GET',
			dataType: 'json',
			data: data,
			beforeSend:function(){
				$(loader).show();
			},
			success:function(r){
				if(r.response==2){
					$(loader).html('<i class="fa fa-check success"></i>');
					checkDocument_ = true;
				}else{
					checkDocument_ = false;
					$(loader).html('<i class="fa fa-times danger"></i> Documento ya existe');
				}
				console.log(r);
			},
			error:function(xhr, status, msg){
				console.log(xhr.responseText);
			}
		});
	});
}
function deleteTeacher(){
	$("body").on("click","#tablaProfesores #borrarUsuario",function(event){
		idseleccion=$(this).attr("value");
		$.ajax({
			url: base_url+'admin_ajax/deleteUser',
			type: 'GET',
			dataType: 'json',
			data:{id:idseleccion},
			beforeSend:function(){
			},
			success:function(r){
				if(r.response==2){
					alert("Profesor Eliminado");
				}
				getTeachers();//para volver a refrezcar la tabla con el profesor ya eliminado
				
			},
			error:function(xhr, status, msg){
				console.log(xhr.responseText);
			}
		});
	});
}
function cancelEditUser() {
	$("#cancel-edit").click(function(event) {
		var btn = this;
		var form = $(btn).closest('form');
		$(form).find("#id").attr('value', 0);
		$(form).find("#level").attr('value', 2);
		$(form)[0].reset();
		$(form).find("button[type=submit]").text('Añadir Profesor');
		$(btn).fadeOut('fast');
	});
}
function editarUsuario(){
	$("body").on("click","#tablaProfesores #editarUsuario",function(event){
		idseleccion=$(this).attr("value");
		$.ajax({
			url: base_url+'admin_ajax/getUserById',
			type: 'GET',
			dataType: 'json',
			data:{idseleccion:idseleccion},
			beforeSend:function(){
			},
			success:function(r){	
				console.log(r);
				if(r.response==2){
					$("#addUserForm #id").attr('value', r.content[0].id);
					$("#addUserForm #level").attr('value', r.content[0].level);
					$("#addUserForm #name").val(r.content[0].name);
					//$("#addUserForm button[data-type]").removeClass('active');
					//$("#addUserForm button[data-type="+r.content[0].type_document+"]").addClass('active');
					$("#addUserForm input[name=type_document]").attr('value', r.content[0].type_document);
					$("#addUserForm #numIdentidicacion").val(r.content[0].document);
					$("#addUserForm #email").val(r.content[0].email);
					$("#addUserForm #telProfe").val(r.content[0].tel);
					$("#addUserForm #birthday").val(r.content[0].birthday);
					$("#addUserForm #cancel-edit").fadeIn('fast');
					$("#addUserForm button[type=submit]").text('Añadir Profesor');
					$("#pills-home-tab").trigger('click'); //asi se le da click a un elemento con jquery 
					checkDocument_ = true;			
				}
			},
			error:function(xhr, status, msg){
				console.log(xhr.responseText);
			}
		});
	});
}
function getTeachers(){
	$.ajax({
		url: base_url+'admin_ajax/getTeachers',
		type: 'GET',
		dataType: 'json',
		beforeSend:function(){
	
		},
		success:function(r){
			var table = $('#tablaProfesores').find("tbody");
			var str = '';
			$.each(r.content,function(index, el){
				str += 
				'<tr>'+
					'<th scope="row">'+el.id+'</th>'+
					'<td>'+el.name+'</td>'+
					'<td>'+el.document+'</td>'+
					'<td>'+el.tel+'</td>'+
					'<td>'+(el.birthday ? el.birthday : '--')+'</td>'+
					'<td>'+el.email+'</td>'+
					'<td>'+'<button type="button"'+'value ="'+el.id+'"class="btn btn-danger" id="btn-modal-cv">Hoja de vida<i class="far fa-file-pdf ml-2"></i></button>'+'</td>'+
					'<td>'+
						'<div id="editarUsuario" class="btn btn-warning mr-2" value='+el.id+' data-toggle="modal" data-target="#modalEditarUser"><i class="fas fa-edit"></i></div>'+
						((level==0|| level==4) ? '<div id="borrarUsuario" class="btn btn-danger" value='+el.id+'><i class="fas fa-trash"></i></div>': '')+
					'</td>'+
				'</tr>';
			});
			$(table).html(str);
			$("#tablaProfesores").DataTable(dataTableOptions);
		},
		error:function(xhr, status, msg){
			console.log(xhr.responseText);
		}
	});
}
function sendTeacher(){
	$('#addUserForm').submit(function(e){ 
		e.preventDefault();
		var form = $(this);
		var data = $(form).serialize();
		var btn = $(form).find('button[type="submit"]');
		if(checkDocument_){ //si se evalua como True
			$.ajax({
				url: base_url+'admin_ajax/sendTeacher',
				type: 'GET',
				dataType: 'json',
				data: data,
				beforeSend:function(){
					$(btn).attr('disabled', true);
					$(btn).html('<i class="fa fa-spin fa-spinner"></i>');
				},
				success:function(r){
					console.log(r);
					if(r.response==2){
						$(btn).attr('disabled', false);
						$(btn).html('AÑADIDO');		
						setTimeout(function(){
						}, 5000);
						var table = $('#tablaProfesores').find("tbody");
						var str = '';
						$.each(r.content,function(index, el){
							str += 
								'<tr>'+
									'<th scope="row">'+el.id+'</th>'+
									'<td>'+el.name+'</td>'+
									'<td>'+el.document+'</td>'+
									'<td>'+el.tel+'</td>'+
									'<td>'+(el.birthday ? el.birthday : '--')+'</td>'+
									'<td>'+el.email+'</td>'+
									'<td>'+'<button type="button"'+'value ="'+el.id+'"class="btn btn-primary" id="btn-cv"><i class="far fa-file-pdf"></i></button>'+'</td>'+
									'<td>'+
										'<div id="editarUsuario" class="btn btn-warning" value='+el.id+' data-toggle="modal" data-target="#modalEditarUser"><i class="fas fa-edit"></i></div>'+
										'<div id="borrarUsuario" class="btn btn-danger" value='+el.id+'><i class="fas fa-trash"></i></div>'+
									'</td>'+
								'</tr>';
						});
						$(table).append(str);
						alert("Profesor añadido con exito");
					}
				},
				error:function(xhr, status, msg){
					console.log(xhr.responseText);
				}
			});
		}else{
			alert('Documento invalido, Revisalo e intenta de nuevo');
		}

	});
}
function updateUserInfo(){
	$("body").on("click","#modalEditarUser #btnEditarProfe" ,function(event){
		id=$("#nombreprofe").attr("value");
		name=$("#nombreprofe").val();
		type_document=$("#profetipodocumento").val();
		document=$("#profedocumento").val();
		birthday=$("#profecumpleaños").val();	
		
		$.ajax({
			url: base_url+'admin_ajax/editTeacher',
			type: 'GET',
			dataType: 'json',
			data:{id:id,type_document:typeDocument,document:document,birthday:birthday},
			beforeSend:function(){
			},
			success:function(r){
				console.log(r.content);	
				if(r.response==2){
					console.log(id);
					alert("Usario Actualizado con exito");				
				}
				else{
					alert("algo no salio bien");
				}
				getTeachers();//para volver a cargar la tabla
				
			},
			error:function(xhr, status, msg){
				console.log(xhr.responseText);
			}
		});
		
	});
}
function uplaodFileCv() {
	$("#form-file-cv").submit(function(event) {
		event.preventDefault();
		var form = this;
		var formData = new FormData();
		formData.append('idMaster', $(form).find('#idTeacher').attr('value'));
		formData.append('file', $(form).find('input[type=file]').prop('files')[0]);
		var classCss = '';
		var textMsgResponse = '';
		console.log(formData);
		$.ajax({
			url: base_url+'admin_ajax/sendHojaVideMaestro',
			type: 'POST',
			dataType: 'json',
			data: formData,
			cache: false,
			contentType:false,
			processData: false,
			beforeSend: function() {
				$(form).find('input').prop('disabled', true);
				$(form).find('button').prop('disabled', true);
			},
	     	xhr: function() {
		        var myXhr = $.ajaxSettings.xhr();
		        $(form).find("#progress").fadeIn('slow');
		        if(myXhr.upload){
		            myXhr.upload.addEventListener('progress',function(e){
							    if(e.lengthComputable){
							        var max = e.total;
							        var current = e.loaded;
							        var Percentage = (current * 100)/max;
							        $(form).find("#progress").css('width', Percentage+'%');
							        $(form).find("#progress").text((Percentage).toFixed(2)+'% completado');
							    }  
							 }, false);
		        }
		        return myXhr;
	      	},
			success: function(r) {
				console.log(r);
				if(r.response == 2) {
					classCss = 'alert-success';
					textMsgResponse = 'Guardado correctamente, para verlo por favor cierra y vuelve abrilo';
				} else {
					classCss = 'alert-danger';
					textMsgResponse = 'Ups!, No se pudo guardar :(';
				}
			},
			error: function(xhr, status, msg) {
				console.log(xhr.responseText);
				classCss = 'alert-danger';
				textMsgResponse = 'Ups!, ocurrio un error no se pudo guardar :(';
			},
			complete: function() {
				$(form)[0].reset();
				$(form).find('input').prop('disabled', false);
				$(form).find('button').prop('disabled', false);
				$(form).find("#progress").fadeOut('fast', function() {
					$(form).find("#progress").text('');
					$(form).find("#progress").removeAttr('style');
					$(form).find("#progress").fadeOut('fast');
				});
				$("#msg-cv").addClass(classCss);
				$("#msg-cv").text(textMsgResponse);
				$("#msg-cv").fadeIn('fast', function() {
					setTimeout(function() {
						$("#msg-cv").fadeOut('fast', function() {
							$("#msg-cv").removeClass(classCss);
							$("#msg-cv").text('');
						});
					}, 2000);
				});
			}
		});
	});
}
function viewModalCv() {
	$("body").on('click', 'button#btn-modal-cv', function(evt) {
		var btn = this;
		var btnContent = $(btn).html();
		var idTeacher = $(btn).attr('value');
		console.log(idTeacher);
		$("#form-file-cv #idTeacher").attr('value', idTeacher);
		$.ajax({
			url: base_url+'admin_ajax/getHojaVidaMaestro',
			type: 'GET',
			dataType: 'json',
			data: { idMaster: idTeacher },
			beforeSend: function() {
				var loader = '<i class="fa fa-spin fa-spinner"></i>';
				$(btn).html(loader);
				$(btn).prop('disabled', true);
			},
			success: function(r) {
				console.log(r);
				if(r.response == 2) {
					if(r.file) {					
						$("#iframe-pdf").fadeIn('fast', function() {
							var pdfBlob = base64toBlob(r.file, 'application/pdf');
							var url = URL.createObjectURL(pdfBlob);
							$("#iframe-pdf").attr('src', url);
						});
					} else {
						$("#iframe-pdf").fadeOut(0);
					}
					$("#btn-open-modal-cv").trigger('click');
				}
			},
			error: function(xhr, status, msg) {
				console.log(xhr.responseText);
			},
			complete: function() {
				$(btn).html(btnContent);
				$(btn).prop('disabled', false);
			}
		});
	});
}
