var dataTableOptions = {
	'language': {
		'search': 'Buscar:',
		'zeroRecords': 'No se encontraron coincidencias',
		'info': 'Total categorias: _TOTAL_ ',
		'lengthMenu': "Mostrar _MENU_ entradas",
		'paginate': {
			'previous': '<',
			'next': '>'
		}
	},
};
$(function () {
	getDirectory();
	editarUsuario();
	filterUsersDirectory();
});

function editarUsuario() {
	$("body").on("click", "#tablaDirectorio #editarUsuario", function (event) {
		idseleccion = $(this).attr("value");

		console.log()
		$.ajax({
			url: base_url + 'admin_ajax/getUserByIdDirectory',
			type: 'GET',
			dataType: 'json',
			data: {
				idseleccion: idseleccion
			},
			beforeSend: function () {},
			success: function (r) {
				if (r.response == 2) {
					console.log(idseleccion);
					$("#userNameEdit").val(r.content[0].nombre);
					$("#acudienteEdit").val(r.content[0].acudiente);
					$("#addressEdit").val(r.content[0].address);
					$("#mainTelEdit").val(r.content[0].mainTel);
					$("#optionalTelEdit").val(r.content[0].optionalTel);
					$("#cumpleañosEdit").val(r.content[0].cumpleaños);
					$("#correoEdit").val(r.content[0].correo);
				}


			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}

function getDirectory() {
	$.ajax({
		url: base_url + 'admin_ajax/getUsersDirectory',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {

		},
		success: function (r) {
			console.log(r);
			if (r.response == 2) {
				var table = $('#tablaDirectorio').find("tbody");
				var str = '';
				if (r.content.length) {
					$.each(r.content, function (index, user) {
						var tr = $("#cloneTr").clone();
						console.log(user.id);
						$(tr).find("#id").text(user.id);
						$(tr).find("#name").text(user.name);
						$(tr).find("#nombreAcudiente").text(user.nombreAcudiente);
						$(tr).find("#direccion").text(user.direccion);
						$(tr).find("#tel").text(user.tel);
						$(tr).find("#tel2").text(user.tel2);
						$(tr).find("#birthday").text(user.birthday);
						$(tr).find("#email").text(user.email);
						$(tr).find("#type_document").text(user.type_document == 0 ? 'T.I' : 'C.C');
						$(tr).find("#document").text(user.document);
						$(tr).find("#idHuellero").text(user.idHuellero);
						$(tr).find("#idSucursal").text(user.idSucursal);
						$(tr).find("#numeroInscripcion").text(user.numeroInscripcion);

						str += $(tr).prop('outerHTML');
					});
				}
				$(table).html(str);
				$("#tablaDirectorio").DataTable(dataTableOptions);
			}
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});
}

function filterUsersDirectory() {
	$("body").on("click", "#buttonSearch", function (event) {
		dato = $("#caja_busqueda").val();
		campo = '';
		filtro = $("#filterStudent option:selected").attr("value");
		if (filtro == '0') {
			campo = 'nombre';
		} else {
			if (filtro == '1') {
				campo = 'mainTel';
			}
		}
		console.log(campo);
		$.ajax({
			url: base_url + 'admin_ajax/filterTableDirectory',
			type: 'GET',
			dataType: 'json',
			data: {
				dato: dato,
				campo: campo
			},
			beforeSend: function () {},
			success: function (r) {
				var table = $('#tablaDirectorio').find("tbody");
				var str = "";
				if (r.response == 2) {
					$.each(r.content, function (index, el) {
						str +=
							'<tr>' +
							'<th scope="row">' + el.idUser + '</th>' +
							'<td>' + el.nombre + '</td>' +
							'<td>' + el.acudiente + '</td>' +
							'<td>' + el.address + '</td>' +
							'<td>' + el.mainTel + '</td>' +
							'<td>' + el.optionalTel + '</td>' +
							'<td>' + el.cumpleaños + '</td>' +
							'<td>' + el.correo + '</td>' +
							'</tr>';
					});
					$(table).html(str);

				} else {
					getDirectory();
					alert("Usuario no encontrado");
				}
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}