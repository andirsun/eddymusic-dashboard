var typeDocument = 0;
var checkDocument_ = false;
var typeDocumentList = Object.freeze(['T.I', 'C.C']);
var table;
var dataTableOptions = {
	'language': {
		'search': 'Busqueda:',
		'zeroRecords': 'Upss, No encontramos a nadie',
		'info': 'Total Datos: _TOTAL_ ',
		'lengthMenu': "Mostrar _MENU_ entradas",
		'paginate': {
			'previous': '<',
			'next': '>'
		}
	},
};

$(function() {
	getInstruments();
	getUsers();
	checkDoucument();
	sendUser();
	changeType();
	confirmarEliminar();
	editarUsuario();
	handleClasesUser();
	selectTypeDocumentToEdit();
	cancelEditUser();
});

function confirmarEliminar(){
	$("body").on("click","#tablaEstudiantes #borrarUsuario",function(event){
		idseleccion=$(this).attr("value");
		if(confirm('Seguro Quieres Eliminar Al Estudiante??')){
			$.ajax({
				url: base_url+'admin_ajax/deleteUser',
				type: 'GET',
				dataType: 'json',
				data:{id:idseleccion},
				beforeSend:function(){
				},
				success:function(r){
					if(r.response==2){
						alert("Usuario Eliminado");
					}
					getUsers();//para volver a cargar la tabla
					
				},
				error:function(xhr, status, msg){
					console.log(xhr.responseText);
				}
			});
		}
	});
}
function changeType(){
	$('[id="typeDocument"]').click(function(){
		$('[id="typeDocument"]').removeClass('active');
		$(this).addClass('active');
		var val = $(this).attr('data-type');
		typeDocument = val;
		$('input[name="type_document"]').val(val);
	});
} 
function checkDoucument(){
	$('body').on('change', 'input[name^="document"]', function(event) {
		var val = $(this).val();
		var data = {doc:val, type: typeDocument};
		var loader = $('#loader');
		// console.log('check document', data);
		$.ajax({
			url: base_url+'admin_ajax/checkDocument',
			type: 'GET',
			dataType: 'json',
			data: data,
			async: false,
			beforeSend:function(){
				$(loader).show();
			},
			success:function(r){
				if(r.response==2){
					$(loader).html('<i class="fa fa-check text-success"></i>');
					checkDocument_ = true;
				}else{
					checkDocument_ = false;
					$(loader).html('<i class="fa fa-times text-danger"></i> <span class="d-block">Documento ya existe</span>');
				}
				console.log(r);
			},
			error:function(xhr, status, msg){
				console.log(xhr.responseText);
			}
		});
	});
	// $('input[name="document"]').change(function(event){
	// });
}
function cancelEditUser() {
	$("#cancel-edit").click(function(event) {
		var btn = this;
		var form = $(btn).closest('form');
		$(form).find("#id").attr('value', 0);
		$(form).find("#level").attr('value', 3);
		$(form)[0].reset();
		$(form).find("button[type=submit]").text('Añadir estudiante');
		$(btn).fadeOut('fast');
	});
}
function editarUsuario(){
	$("body").on("click","#tablaEstudiantes #editarUsuario",function(event){
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
					// console.log(idseleccion);
					$("#addUserForm #id").attr('value', r.content[0].id);
					$("#addUserForm #level").attr('value', r.content[0].level);
					$("#addUserForm #userName").val(r.content[0].name);
					$("#addUserForm button[data-type]").removeClass('active');
					$("#addUserForm button[data-type="+r.content[0].type_document+"]").addClass('active');
					$("#addUserForm input[name=type_document]").attr('value', r.content[0].type_document);
					$("#addUserForm #numIdentidicacion").val(r.content[0].document);
					$("#addUserForm #idHuellero").val(r.content[0].idHuellero);
					$("#addUserForm #NumeroInscripcion").val(r.content[0].numeroInscripcion)
					$("#addUserForm #Email").val(r.content[0].email);
					$("#addUserForm #Pnumber").val(r.content[0].tel);
					$("#addUserForm #Snumber").val(r.content[0].tel2);
					$("#addUserForm #adress").val(r.content[0].direccion);
					$("#addUserForm #nombreAcudiente").val(r.content[0].nombreAcudiente);
					$("#addUserForm #birthday").val(r.content[0].birthday);
					$("#addUserForm #observaciones").val(r.content[0].observaciones);
					$("#addUserForm #cancel-edit").fadeIn('fast');
					$("#addUserForm button[type=submit]").text('Editar estudiante');
					$("#pills-home-tab").trigger('click');
					checkDocument_ = true;			
				}
			},
			error:function(xhr, status, msg){
				console.log(xhr.responseText);
			}
		});
	});
}
function getInstruments(){
	$.ajax({
		url: base_url+'admin_ajax/getInstruments',
		type: 'GET',
		dataType: 'json',
		beforeSend:function(){
		},
		success:function(r){
			var select = $('select#instrument');
			var str = '<option value="" selected>Seleccione...</option>';
			if(r.response==2){
				$.each(r.content,function(index, el){
					str += '<option value="'+el.id+'">'+el.name+'</option>';
				});
				$(select).html(str);
			}
			// console.log(r);
		},
		error:function(xhr, status, msg){
			console.log(xhr.responseText);
		}
	});
}
function getUsers(){
	$.ajax({
		url: base_url+'admin_ajax/getUsers',
		type: 'GET',
		dataType: 'json',
		beforeSend:function(){
		},
		success:function(r){
			// console.log('list users \n', r);
			var tableBody = $('#tablaEstudiantes').find("tbody");
			var str = buildTrUser(r.content);
			$(tableBody).html(str);
			table = $("#tablaEstudiantes").DataTable(dataTableOptions);
			// console.log(table);
		},
		error:function(xhr, status, msg){
			console.log(xhr.responseText);
		}
	});
}
function sendUser() {
	$('#addUserForm').submit(function(e){  
		e.preventDefault();
		var form = $(this);
		var data = $(form).serialize();
		var btn = $(form).find('button[type="submit"]');
		var classMsg = '';
		var textMsg  = '';
		// console.log(data);
		if(checkDocument_){ //si se evalua como True
			$.ajax({
				url: base_url+'admin_ajax/addUser',
				type: 'GET',
				dataType: 'json',
				data: data,
				beforeSend:function(){
					$(btn).attr('disabled', true);
					$(btn).html('<i class="fa fa-spin fa-spinner"></i>');
				},
				success:function(r){
					// console.log('respuesta al ingresar un usuario', r);
					if(r.response==2){
						$(btn).html('AÑADIDO');		
						setTimeout(function(){
						}, 5000);
						var tableBody = $('#tablaEstudiantes').find("tbody");
						var str = buildTrUser(r.content);
						try {
							// console.log(table);						
							table.destroy();
						} catch(e) {
							// console.log(e);
						}
						// console.log(str);
						var idUser = $(form).find("#id").attr('value');
						classMsg = 'alert-success';
						if(idUser == 0) {
							$(tableBody).append(str);
							textMsg = 'Usuario agregado Correctamente';
						} else {
							// console.log($(tableBody).find('tr[data-id='+idUser+']'));
							$(tableBody).find('tr[data-id='+idUser+']').replaceWith(str);
							textMsg = 'Usuario actualizado Correctamente';
						}
						table = $("#tablaEstudiantes").DataTable(dataTableOptions);
						checkDocument_ = false;
					} else {
						classMsg = 'alert-danger';
					}
				},
				error:function(xhr, status, msg){
					console.log(xhr.responseText);
					classMsg = 'alert-danger';
					textMsg = 'Ups!, ocurrio un error';
				},
				complete: function() {
					$(form)[0].reset();
					$(form).find("#id").attr('value', 0);
					$(form).find("#level").attr('value', 3);
					$(form).find("#cancel-edit").fadeOut('fast');
					$(btn).attr('disabled', false);
					$(form).find("#loader").fadeOut('fast');
					$(btn).text('Añadir estudiante');
					var body = $("html, body");
					$(form).find('#msg-add-user').addClass(classMsg);
					$(form).find('#msg-add-user #text-add-form').text(textMsg);
			    $(form).find('#msg-add-user').slideDown('fast', function() {
						body.stop().animate({scrollTop: $(form).find('#msg-add-user').offset().top }, 500, 'swing', function() { 
					  	setTimeout(function() {
					  		$(form).find('#msg-add-user').slideUp('fast', function() {
					  			$(form).find('#msg-add-user').removeClass(classMsg);
					  		});
					  	}, 1800);
					  });
					});
				}
			});
		}else{
			alert('Documento invalido');
		}
	});
}
function handleClasesUser(){
	$('body').on('click','[id="handleClases"]',function(){
		var btn = $(this);
		var idUser = $(this).attr('value');
		var data = {idUser:idUser}
		$.ajax({
			url: base_url+'admin_ajax/formClassUser',
			type: 'GET',
			dataType: 'HTML',
			data: data,
			beforeSend:function(){
				$(btn).html('<i class="fa fa-spin fa-spinner"></i>');
			},
			success:function(r){
				$(btn).html('<i class="fas fa-calendar"></i>');
				loadModal('Adminitrador de Clases', r,'Cerrar');
				console.log(r);
			},
			error:function(xhr, status, msg){
				console.log(xhr.responseText);
			}
		});
	})
}
function buildTrUser(listUser) {
	var str = '';
	$.each(listUser,function(index, el){
		var tr = $(trClone).clone();
		var birthday = '--';
		if(el.birthday != "0000-00-00" && el.birthday != null) {
			birthday = el.birthday;
		}
		$(tr).removeAttr('id');
		$(tr).attr('data-id', el.id);
		$(tr).find('#id_user').text(el.id);
		$(tr).find('#idHuellero').text(el.idHuellero);
		$(tr).find('#name').text(el.name);
		$(tr).find('#type_document').text(typeDocumentList[el.type_document]);
		$(tr).find('#document').text(el.document);
		$(tr).find('#birthday').text(birthday);
		$(tr).find('#observaciones').text(el.observaciones);
		$(tr).find('#editarUsuario').attr('value', el.id);
		$(tr).find('#borrarUsuario').attr('value', el.id);
		$(tr).find("#usuarioCalendario").attr('href', base_url+'admin/nav/clasesStudent/'+el.id);
		$(tr).find("#usuarioCalendario").attr('value', el.id);
		str += $(tr).prop('outerHTML');
	});
	return str;
}
function selectTypeDocumentToEdit() {
	$("#btnGroupType button").click(function(event) {
		// console.log($(this).closest('#btnGroupType button'));
		$("#btnGroupType").find("button").removeClass('active');
		$(this).addClass('active');
		var type = $(this).data('type');
		var inputTypeDocument = $(this).closest('#btnGroupType').find("#type_document_edit");
		$(inputTypeDocument).attr('value', type);
	});
}