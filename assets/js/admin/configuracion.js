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
$(function () {
	cargarInstrumentos();
	añadirinstrumento();
	confirmarEliminar();
	traerInstrumentoPorId();
	cancelarEdicion();
});

function añadirinstrumento() {
	$('form#addInstrument').submit(function (e) {
		e.preventDefault();
		var form = $(this);
		var data = $(form).serialize();
		$.ajax({
			url: base_url + 'admin_ajax/sendInstrument',
			type: 'GET',
			dataType: 'json',
			data: data,
			beforeSend: function () {
				$('#tablaInstrumentos').dataTable().fnDestroy();

			},
			success: function (r) {
				var tbody = $('#tablaInstrumentos').find("tbody");
				var str = '';
				if (r.response == 2) {
					$.each(r.content, function (index, el) {
						var tr = $("#trClone").clone();
						$(tr).removeAttr('id');
						$(tr).attr('data-id', el.id);
						$(tr).find('#id-instrument').text(el.id);
						$(tr).find('#name').text(el.name);
						$(tr).find('#editarInstrumento').attr('value', el.id);
						$(tr).find('#borrarInstrumento').attr('value', el.id);
						str += $(tr).prop('outerHTML');
						// str += 
						//     '<tr data-id="'+el.id+'">'+
						//         '<td>'+el.id+'</td>'+
						//         '<td>'+el.name+'</td>'+
						//         '<td>'+
						//             '<div id="borrarInstrumento" class="btn btn-danger" value='+el.id+'><i class="fas fa-trash"></i></div>'+
						//     '</tr>';
					});
					if($('td.dataTables_empty').length>0){
						$('td.dataTables_empty').closest('tr').remove();
					}
					$(tbody).append(str);
				}
				console.log(r);
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}

function cargarInstrumentos() {
	$.ajax({
		url: base_url + 'admin_ajax/getInstruments',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
			
		},
		success: function (r) {
			console.log(r);
			var tbody = $('#tablaInstrumentos').find("tbody");
			var str = '';
			if (r.response == 2) {
				$.each(r.content, function (index, el) {
					var tr = $("#trClone").clone();
					$(tr).attr('data-id', el.id);
					$(tr).find('#id-instrument').text(el.id);
					$(tr).find('#name').text(el.name);
					$(tr).find('#editarInstrumento').attr('value', el.id);
					$(tr).find('#borrarInstrumento').attr('value', el.id);
					str += $(tr).prop('outerHTML');
					// str += 
					//     '<tr data-id="'+el.id+'">'+
					//         '<td>'+el.id+'</td>'+
					//         '<td>'+el.name+'</td>'+
					//         '<td>'+
					//             '<div id="borrarInstrumento" class="btn btn-danger" value='+el.id+'><i class="fas fa-trash"></i></div>'+
					//     '</tr>';
				});
				$(tbody).html(str);
				$('#tablaInstrumentos').DataTable(dataTableOptions);
			}
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});
}

function cancelarEdicion() {
	$('body').on('click', '#close-form-edit', function(event) {
		var btn = this;
		var form = $(btn).closest('form');
		$(form)[0].reset();
		$(form).find("#id_instrumento").val(0);
		$(btn).fadeOut('fast');
		$('#tablaInstrumentos').dataTable().fnDestroy();
		cargarInstrumentos();
	});
}

function confirmarEliminar() {
	$("body").on("click", "#tablaInstrumentos #borrarInstrumento", function (event) {
		idseleccion = $(this).attr("value");
		if(confirm('Estas Seguro que Quieres Eliminar el Instrumento?')){
			$.ajax({
				url: base_url + 'admin_ajax/deleteInstrument',
				type: 'GET',
				dataType: 'json',
				data: {
					id: idseleccion
				},
				beforeSend: function () {},
				success: function (r) {
					if (r.response == 2) {
						alert("se elimino el registro");
					}
					cargarInstrumentos(); //para volver a cargar la tabla

				},
				error: function (xhr, status, msg) {
					console.log(xhr.responseText);
				}
			});
		}
	});
}

function traerInstrumentoPorId() {
	$("#tablaInstrumentos").on('click', 'button#editarInstrumento', function (evt) {
		var btn = this;
		var btnContent = $(btn).html();
		var idInstrumento = $(btn).attr('value');
		$.ajax({
			url: base_url + 'admin_ajax/getInstruments',
			type: 'GET',
			dataType: 'json',
			data: {
				id: idInstrumento
			},
			beforeSend: function () {
				var loader = '<i class="fa fa-spin fa-spinner"></i>';
				$(btn).prop('disabled', false);
				$(btn).html(loader);
			},
			success: function (r) {
				console.log(r);
				console.log(r.response == 2);
				if (r.response == 2) {
					console.log(r.content[0].name);
					console.log();
					$("#addInstrument").find("#id_instrumento").attr('value', r.content[0].id);
					$("#addInstrument").find("#name_instrumento").val(r.content[0].name);
					$("#addInstrument").find("#cupos_instrumento").val(r.content[0].cupos);
					$("#addInstrument").find("#precioHora").val(r.content[0].precioHora);
					$("#addInstrument").find("#precioHora8").val(r.content[0].precioHora8);
					$("#addInstrument").find("#precioHora12").val(r.content[0].precioHora12);
					$("#addInstrument").find("#precioHora16").val(r.content[0].precioHora16);
					$("#addInstrument").find("#precioHora20").val(r.content[0].precioHora20);
					$("#addInstrument").find("#precioHora24").val(r.content[0].precioHora24);
					$("#addInstrument").find("#precioHora72").val(r.content[0].precioHora72);
					$("#close-form-edit").fadeIn('fast');
				}
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			},
			complete: function () {
				$(btn).prop('disabled', false);
				$(btn).html(btnContent);
			}
		});
	});
}
