var dataTableOptions = {
  'language': {
    'search': 'Buscar:',
    'zeroRecords': 'Upss!!, No Encontramos Coincidencias',
    'info': 'Total de Datos: _TOTAL_ ',
    'lengthMenu': "Mostrar _MENU_ entradas",
    'paginate': {
      'previous': '<',
      'next': '>'
    }
  },
};
$(function(){
	console.log(666);
	//$('#tableEgresos').DataTable(dataTableOptions);
	//$('#tableEgresosBancos').DataTable(dataTableOptions);
	flujoDeCajaBanco();
	deleteEgresoEfectivo();
	deleteEgresoBanco();
	flujoDeCajaEfectivo();
	añadirEgresoEfectivo();
	añadirEgresoBanco();
	ponerEgresosEfectivoPorFecha();
	ponerEgresosBancoPorFecha();
	getEgresosEfectivo();
	getEgresosBancos();
	filtrarEgresosEfectivo();
	filtrarEgresosBanco();
  formatoMoneda();
});
function deleteEgresoEfectivo(){
	$("body").on("click","#tablaEgresosEfectivo #borrarEgresoEfectivo",function(event){
		var id = $(this).attr('value');
		if (confirm("Eliminar Egreso?")){
			$.ajax({
				url: base_url + 'admin_ajax/deleteEgreso',
				type: 'GET',
				dataType: 'json',
				data: {
					id: id
				},
				beforeSend: function () {
					$("#tablaEgresosEfectivo").dataTable().fnDestroy();
				},
				success: function (r) {
					console.log("Egreso Eliminado");
					getEgresosEfectivo();
					flujoDeCajaEfectivo();
				},
				error: function (xhr, status, msg) {
					console.log(xhr.responseText);
				}
			});
		}
		
	});

}
function deleteEgresoBanco(){
	$("body").on("click","#tablaEgresosBanco #borrarEgresoBanco",function(event){
		var id = $(this).attr('value');
		if (confirm("Eliminar Ingreso?")){
			$.ajax({
				url: base_url + 'admin_ajax/deleteEgreso',
				type: 'GET',
				dataType: 'json',
				data: {
					id: id
				},
				beforeSend: function () {
					$("#tablaEgresoBanco").dataTable().fnDestroy();
				},
				success: function (r) {
					console.log("Egreso Eliminado");
					getEgresosBancos();
					flujoDeCajaBanco();
				},
				error: function (xhr, status, msg) {
					console.log(xhr.responseText);
				}
			});
		}
		
	});

}
function flujoDeCajaEfectivo(){
	$.ajax({
		url: base_url + 'admin_ajax/flujoDeCajaEfectivo',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
			
		},
		success: function (r) {
			console.log("Ingresos Sumatoria - egresos",r.content);
			
			var precio = r.content;
			
			var contenido = "<h1> Saldo: $ "+$.number(Number(precio), 0, ',', '.')+"</h1>";
			$("#flujoCaja").html(contenido);
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});
}
function flujoDeCajaBanco(){
	$.ajax({
		url: base_url + 'admin_ajax/flujoDeCajaBanco',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
			
		},
		success: function (r) {
			console.log("Ingresos Sumatoria - egresos",r.content);
			
			var precio = r.content;
			
			var contenido = "<h1> Saldo: $ "+$.number(Number(precio), 0, ',', '.')+"</h1>";
			$("#flujoCajaBanco").html(contenido);
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});
}
function añadirEgresoEfectivo(){
	$("#formEgresoEfectivo").submit(function(e){
		e.preventDefault();
		var form = $(this);
		var data = $(form).serialize();
		$.ajax({
			url: base_url + 'admin_ajax/addEgresoEfectivo',
			type: 'GET',
			dataType: 'json',
			data:data,
			beforeSend: function () {
				//$("#tablaEgresosEfectivo").dataTable().fnDestroy();//Toca Hacer esto para que no aparezca el error de  DataTables warning: table id={id} - Cannot reinitialise DataTable.
			},
			success: function (r) {
				location.reload(true);
				//getEgresosEfectivo();
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			},
			complete: function(){
				$(form)[0].reset();
			}
		});
		
	});
}
function añadirEgresoBanco(){
	$("#formEgresoBanco").submit(function(e){
		e.preventDefault();
		var form = $(this);
		var data = $(form).serialize();
		$.ajax({
			url: base_url + 'admin_ajax/addEgresoBanco',
			type: 'GET',
			dataType: 'json',
			data:data,
			beforeSend: function () {
				//$("#tablaEgresosEfectivo").dataTable().fnDestroy();//Toca Hacer esto para que no aparezca el error de  DataTables warning: table id={id} - Cannot reinitialise DataTable.
			},
			success: function (r) {
				location.reload(true);
				//$("#tablaEgresosBanco").dataTable().fnDestroy();//Toca Hacer esto para que no aparezca el error de  DataTables warning: table id={id} - Cannot reinitialise DataTable.
				///getEgresosBancos();
				//flujoDeCajaBanco();
				
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			},
			complete: function(){
				$(form)[0].reset();
			}
		});
	});
}
function ponerEgresosEfectivoPorFecha(){
	var dateIncio = new Date();
	//var lastDay = new Date(date.getFullYear(), date.getMonth() , date.getDay());
	//var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
	var day = dateIncio.getDate();
	var month = dateIncio.getMonth() + 1;
	var year = dateIncio.getFullYear();
	if (month < 10) month = "0" + month;//formato que se vea de dos digitos
	if (day < 10) day = "0" + day;
	var today = year + "-" + month + "-" + day;     
	var firstDay = year + "-" + month + "-" + "01";    
	$("#inicioFiltroDateEgresosEfectivo").val(firstDay);
	$("#finFiltroDateEgresosEfectivo").val(today);
	$("#botonFiltrarEgresosEfectivo").on("click",function(event){
		var fechaInicio = $("#inicioFiltroDateEgresosEfectivo").val();
		var fechaFin = $("#finFiltroDateEgresosEfectivo").val();
		$.ajax({
			url: base_url + 'admin_ajax/calcularDineroEgresos',
			type: 'GET',
			dataType: 'json',
			data:{
				fechaInicio:fechaInicio,
				fechaFin:fechaFin
			},
			beforeSend: function () {
				
			},
			success: function (r) {
				//console.log("Ingresos Sumatoria",r.content);
				var precio = r.content[0].valor;
				var contenido = "Saldo: $"+$.number(precio, 0, '', '.')+" Pesos.";
				$("#dineroEgresos").val(contenido);
				//$("#dineroEgresos").val(r.content[0].valor);	
				
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}
function ponerEgresosBancoPorFecha(){
	var dateIncio = new Date();
	//var lastDay = new Date(date.getFullYear(), date.getMonth() , date.getDay());
	//var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
	var day = dateIncio.getDate();
	var month = dateIncio.getMonth() + 1;
	var year = dateIncio.getFullYear();
	if (month < 10) month = "0" + month;//formato que se vea de dos digitos
	if (day < 10) day = "0" + day;
	var today = year + "-" + month + "-" + day;     
	var firstDay = year + "-" + month + "-" + "01";    
	$("#inicioFiltroDateEgresosBanco").val(firstDay);
	$("#finFiltroDateEgresosBanco").val(today);
	$("#botonFiltrarEgresosBanco").on("click",function(event){
		var fechaInicio = $("#inicioFiltroDateEgresosBanco").val();
		var fechaFin = $("#finFiltroDateEgresosBanco").val();
		$.ajax({
			url: base_url + 'admin_ajax/calcularDineroEgresosBanco',
			type: 'GET',
			dataType: 'json',
			data:{
				fechaInicio:fechaInicio,
				fechaFin:fechaFin
			},
			beforeSend: function () {
				
			},
			success: function (r) {
				var precio = r.content[0].valor;
				var contenido = "Saldo: $"+$.number(precio, 0, '', '.')+" Pesos.";
				$("#dineroEgresosBanco").val(contenido);
				//$("#dineroEgresosBanco").val(r.content[0].valor);	
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
	
}
function getEgresosEfectivo(){
    $.ajax({
		url: base_url+'admin_ajax/getEgresosEfectivo',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
			$("#tablaEgresosEfectivo").dataTable().fnDestroy();
		},
		success: function (r) {
			console.log('list users \n', r);
			var tableBody = $('#tablaEgresosEfectivo').find("tbody");
			var str = buildTrUserEfectivo(r.content);
			$(tableBody).html(str);
			table = $("#tablaEgresosEfectivo").DataTable(dataTableOptions);
			flujoDeCajaEfectivo();
			console.log(table);
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});
}
function getEgresosBancos(){
	$.ajax({
	url: base_url+'admin_ajax/getEgresosBancos',
	type: 'GET',
	dataType: 'json',
	beforeSend: function () {
			$("#tablaEgresosBanco").dataTable().fnDestroy();
	},
	success: function (r) {
		console.log('list Egresos \n', r);
		var tableBody = $('#tablaEgresosBanco').find("tbody");
		var str = buildTrUserBanco(r.content);
		$(tableBody).html(str);
		table = $("#tablaEgresosBanco").DataTable(dataTableOptions);
		flujoDeCajaBanco();
		console.log(table);
	},
	error: function (xhr, status, msg) {
		console.log(xhr.responseText);
	}
	});
}
function filtrarEgresosEfectivo() {
	$("#botonFiltrarEgresosEfectivo").on("click",function(event){
		console.log("Click Boton Filtrar Egresos");
		var fechaInicio = $("#inicioFiltroDateEgresosEfectivo").val();
		var fechaFin = $("#finFiltroDateEgresosEfectivo").val();
		console.log(fechaInicio);
		console.log(fechaFin);
		$.ajax({
			url: base_url + 'admin_ajax/filtrarEgresosEfectivo',
			type: 'GET',
			dataType: 'json',
			data:{
				fechaInicio:fechaInicio,
				fechaFin:fechaFin
			},
			beforeSend: function () {
				$("#tablaEgresosEfectivo").dataTable().fnDestroy();//Toca Hacer esto para que no aparezca el error de  DataTables warning: table id={id} - Cannot reinitialise DataTable.
			},
			success: function (r) {
				console.log('list users \n', r);
				var tableBody = $('#tablaEgresosEfectivo').find("tbody");
				var str = buildTrUserEfectivo(r.content);
				$(tableBody).html(str);
				table = $("#tablaEgresosEfectivo").DataTable(dataTableOptions);
				console.log(table);
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}
function filtrarEgresosBanco() {
	$("#botonFiltrarEgresosBanco").on("click",function(event){
		console.log("Click Boton Filtrar Egresos");
		var fechaInicio = $("#inicioFiltroDateEgresosBanco").val();
		var fechaFin = $("#finFiltroDateEgresosBanco").val();
		console.log(fechaInicio);
		console.log(fechaFin);
		$.ajax({
			url: base_url + 'admin_ajax/filtrarEgresosBanco',
			type: 'GET',
			dataType: 'json',
			data:{
				fechaInicio:fechaInicio,
				fechaFin:fechaFin
			},
			beforeSend: function () {
				$("#tablaEgresosBanco").dataTable().fnDestroy();//Toca Hacer esto para que no aparezca el error de  DataTables warning: table id={id} - Cannot reinitialise DataTable.
			},
			success: function (r) {
				console.log('list users \n', r);
				var tableBody = $('#tablaEgresosBanco').find("tbody");
				var str = buildTrUserBanco(r.content);
				$(tableBody).html(str);
				table = $("#tablaEgresosBanco").DataTable(dataTableOptions);
				console.log(table);
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}
function formatoMoneda() {
	$("#valorEgresoEfectivo").keyup(function(event) {
		var val = Number($(this).val());
		$("#valEgresoFormated").text($.number(val, 0, '', '.'));
	});
	$("#valorEgresoBanco").keyup(function(event) {
		var val = Number($(this).val());
		$("#valEgresoFormated2").text($.number(val, 0, '', '.'));
	});
}
function buildTrUserEfectivo(listUser) {
	var str = '';
	$.each(listUser, function (index, el) {
		var tr = $("#trClone").clone();
		//if (el.conceptoIngreso == null) {
		//	el.conceptoIngreso = "No Hay concepto";
		//}
		//$(tr).removeAttr('id');
		$(tr).find('#fecha').text(el.fecha);
		$(tr).find('#concepto').text(el.tipo);
		$(tr).find('#descripcion').text(el.concepto);
		$(tr).find('#valor').text($.number(Number(el.valor), 0, '', '.'));
		$(tr).find('#borrarEgresoEfectivo').attr('value', el.id);
		//$(tr).find('#borrarUsuario').attr('value', el.id);

		str += $(tr).prop('outerHTML');
	});
	return str;
}
function buildTrUserBanco(listUser) {
	var str = '';
	$.each(listUser, function (index, el) {
		var tr = $("#trClone1").clone();
		//var birthday = '--';
		//if(el.birthday != "0000-00-00" && el.birthday != null) {
		//	birthday = el.birthday;
		//}
		//$(tr).removeAttr('id');
		$(tr).find('#fecha').text(el.fecha);
		$(tr).find('#concepto').text(el.tipo);
		$(tr).find('#descripcion').text(el.concepto);
		$(tr).find('#valor').text($.number(Number(el.valor), 0, '', '.'));
		$(tr).find('#borrarEgresoBanco').attr('value', el.id);
		//$(tr).find('#borrarUsuario').attr('value', el.id);

		str += $(tr).prop('outerHTML');
	});
	return str;
}



