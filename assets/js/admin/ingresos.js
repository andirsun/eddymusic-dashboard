var dataTableOptions = {
	language: {
		search: 'Busqueda:',
		zeroRecords: 'UPS, No encontramos nada :(',
		info: 'Total de Datos: _TOTAL_ ',
		lengthMenu: "Mostrar _MENU_ entradas",
		paginate: {
			'previous': '<',
			'next': '>'
		}
	},
};
$(function () {
	console.log(666);
	flujoDeCajaEfectivo();
	flujoDeCajaBanco();
	ponerIngresosEfectivoPorFecha();
	ponerIngresosBancoPorFecha();
	getingresosEfectivo();
	getingresosBanco();
	agregarIngreso();
	agregarIngresoBanco();
	filtrarIngresosEfectivo();
	filtrarIngresosBanco();
	deleteIngresoEfectivo();
	deleteIngresoBanco();
	formatoDineroIngreso();
});
function deleteIngresoEfectivo(){
	$("body").on("click","#tablaIngresosEfectivo #borrarIngresoEfectivo",function(event){
		var id = $(this).attr('value');
		if (confirm("Eliminar Ingreso?")){
			$.ajax({
				url: base_url + 'admin_ajax/deleteIngreso',
				type: 'GET',
				dataType: 'json',
				data: {
					id: id
				},
				beforeSend: function () {
					$("#tablaIngresosEfectivo").dataTable().fnDestroy();
				},
				success: function (r) {
					console.log("Ingreso Eliminado");
					getingresosEfectivo();
					flujoDeCajaEfectivo();
				},
				error: function (xhr, status, msg) {
					console.log(xhr.responseText);
				}
			});
		}
		
	});
}
function deleteIngresoBanco(){
	$("body").on("click","#tablaIngresosBanco #borrarIngresoBanco",function(event){
		var id = $(this).attr('value');
		if (confirm("Eliminar Ingreso?")){
			$.ajax({
				url: base_url + 'admin_ajax/deleteIngreso',
				type: 'GET',
				dataType: 'json',
				data: {
					id: id
				},
				beforeSend: function () {
					$("#tablaIngresosBanco").dataTable().fnDestroy();
				},
				success: function (r) {
					console.log("Ingreso Eliminado");
					getingresosBanco();
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
function ponerIngresosEfectivoPorFecha(){
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
	$("#inicioFiltroDateIngresosEfectivo").val(firstDay);
	$("#finFiltroDateIngresosEfectivo").val(today);
	$("#botonFiltrarIngresos").on("click",function(event){
		var fechaInicio = $("#inicioFiltroDateIngresosEfectivo").val();
		var fechaFin = $("#finFiltroDateIngresosEfectivo").val();
		//console.log(fechaInicio,fechaFin);
		$.ajax({
			url: base_url + 'admin_ajax/calcularDineroIngresos',
			type: 'GET',
			dataType: 'json',
			data:{
				fechaInicio:fechaInicio,
				fechaFin:fechaFin
			},
			beforeSend: function () {
				
			},
			success: function (r) {
				console.log("Ingresos Sumatoria",r.content);
				console.log("Sucursal",r.sucursal);
				var precio = r.content[0].price;
				var contenido = "Saldo: $"+$.number(precio, 0, '', '.')+" Pesos.";
				$("#dineroIngresos").val(contenido);
				///$("#dineroIngresos").val(r.content[0].price);	
				
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});	
}
function ponerIngresosBancoPorFecha(){
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
	$("#inicioFiltroDateIngresosBanco").val(firstDay);
	$("#finFiltroDateIngresosBanco").val(today);
	$("#botonFiltrarIngresosBanco").on("click",function(event){
		var fechaInicio = $("#inicioFiltroDateIngresosBanco").val();
		var fechaFin = $("#finFiltroDateIngresosBanco").val();
		$.ajax({
			url: base_url + 'admin_ajax/calcularDineroIngresosBanco',
			type: 'GET',
			dataType: 'json',
			data:{
				fechaInicio:fechaInicio,
				fechaFin:fechaFin
			},
			beforeSend: function () {
				
			},
			success: function (r) {
				var precio = r.content[0].price;
				var contenido = "Saldo: $"+$.number(precio, 0, '', '.')+" Pesos.";
				$("#dineroIngresosBanco").val(contenido);
				//$("#dineroIngresosBanco").val(r.content[0].price);	
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});	
}
function filtrarIngresosEfectivo() {
	$("#botonFiltrarIngresos").on("click",function(event){
		console.log("Click Boton Filtrar Ingresos");
		var fechaInicio = $("#inicioFiltroDateIngresosEfectivo").val();
		var fechaFin = $("#finFiltroDateIngresosEfectivo").val();
		console.log(fechaInicio);
		console.log(fechaFin);
		$.ajax({
			url: base_url + 'admin_ajax/filtrarIngresosEfectivo',
			type: 'GET',
			dataType: 'json',
			data:{
				fechaInicio:fechaInicio,
				fechaFin:fechaFin
			},
			beforeSend: function () {
				$("#tablaIngresosEfectivo").dataTable().fnDestroy();//Toca Hacer esto para que no aparezca el error de  DataTables warning: table id={id} - Cannot reinitialise DataTable.
			},
			success: function (r) {
				console.log('list users \n', r);
				var tableBody = $('#tablaIngresosEfectivo').find("tbody");
				var str = buildTrUserEfectivo(r.content);
				$(tableBody).html(str);
				table = $("#tablaIngresosEfectivo").DataTable(dataTableOptions);
				console.log(table);
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}
function filtrarIngresosBanco() {
	$("#botonFiltrarIngresosBanco").on("click",function(event){
		console.log("Click Boton Filtrar Ingresos");
		var fechaInicio = $("#inicioFiltroDateIngresosBanco").val();
		var fechaFin = $("#finFiltroDateIngresosBanco").val();
		console.log(fechaInicio);
		console.log(fechaFin);
		$.ajax({
			url: base_url + 'admin_ajax/filtrarIngresosBanco',
			type: 'GET',
			dataType: 'json',
			data:{
				fechaInicio:fechaInicio,
				fechaFin:fechaFin
			},
			beforeSend: function () {
				$("#tablaIngresosBanco").dataTable().fnDestroy();//Toca Hacer esto para que no aparezca el error de  DataTables warning: table id={id} - Cannot reinitialise DataTable.
			},
			success: function (r) {
				console.log('list users \n', r.content);
				var tableBody = $('#tablaIngresosBanco').find("tbody");
				var str = buildTrUserBanco(r.content);
				$(tableBody).html(str);
				table = $("#tablaIngresosBanco").DataTable(dataTableOptions);
				console.log(table);
			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}
function getingresosEfectivo() {
	$.ajax({
		url: base_url + 'admin_ajax/getIngresosEfectivo',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
			$("#tablaIngresosEfectivo").dataTable().fnDestroy();
		},
		success: function (r) {
			console.log('list users \n', r);
			var tableBody = $('#tablaIngresosEfectivo').find("tbody");
			var str = buildTrUserEfectivo(r.content);
			$(tableBody).html(str);
			table = $("#tablaIngresosEfectivo").DataTable(dataTableOptions);
			flujoDeCajaEfectivo();
			console.log(table);
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});	
}
function getIngresosEfectivo2(){
	$.ajax({
		url: base_url + 'admin_ajax/getIngresosEfectivo2',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
		},
		success: function (r) {
			console.log('lista de ingresos  \n', r);
			var tableBody = $('#tablaIngresosEfectivo').find("tbody");
			var str = buildTrUserEfectivo(r.content);
			$(tableBody).html(str);
			table = $("#tablaIngresosEfectivo").DataTable(dataTableOptions);
			//console.log(table);
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});
}
function getingresosBanco() {
	$.ajax({
		url: base_url + 'admin_ajax/getIngresosBanco',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
			$("#tablaIngresosBanco").dataTable().fnDestroy();
		},
		success: function (r) {
			console.log('list users \n', r);
			var tableBody = $('#tablaIngresosBanco').find("tbody");
			var str = buildTrUserBanco(r.content);
			$(tableBody).html(str);
			table = $("#tablaIngresosBanco").DataTable(dataTableOptions);
			console.log(table);
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});
}
function agregarIngreso() {
	$("#botonAgregarIngreso").on("click",function(event){
		event.preventDefault();
		var valor = $("#valorAddIngreso").val();
		var concepto = $("#conceptoAddIngreso").val();
		var nRecibo = $("#nReciboAddIngreso").val();
		
		$.ajax({
			url: base_url + 'admin_ajax/addIngreso',
			type: 'GET',
			dataType: 'json',
			data: {
				valor: valor,
				concepto: concepto,
				nRecibo:nRecibo
			},
			beforeSend: function () {
				$("#tablaIngresosEfectivo").dataTable().fnDestroy();
			},
			success: function (r) {
				console.log("Ingreso Añadido");
				getingresosEfectivo();
				flujoDeCajaEfectivo();

			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}
function agregarIngresoBanco() {
	$("#botonAgregarIngresoBanco").on("click",function(event){
		event.preventDefault();
		var valor = $("#valorAddIngresoBanco").val();
		var concepto = $("#conceptoAddIngresoBanco").val();
		var nRecibo = $("#nReciboAddIngresoBanco").val();
		
		$.ajax({
			url: base_url + 'admin_ajax/addIngresoBanco',
			type: 'GET',
			dataType: 'json',
			data: {
				valor: valor,
				concepto: concepto,
				nRecibo:nRecibo
			},
			beforeSend: function () {
				$("#tablaIngresosBanco").dataTable().fnDestroy();
			},
			success: function (r) {
				console.log("Ingreso Banco Añadido");
				getingresosBanco();
				flujoDeCajaBanco();

			},
			error: function (xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	});
}
function formatoDineroIngreso() {
	$("#valorAddIngreso").keyup(function(event) {
		var val = Number($(this).val());
		$("#modalIngresoEfectivo #valAddIngresoFormated").text($.number(val, 0, '', ' '));
	});
	$("#valorAddIngresoBanco").keyup(function(event) {
		var val = Number($(this).val());
		$("#modalIngresoBanco #valAddIngresoFormated").text($.number(val, 0, '', ' '));
	});
}

function buildTrUserEfectivo(listUser) {
	var str = '';
	$.each(listUser, function (index, el) {
		var tr = $("#trClone").clone();
		if (el.conceptoIngreso == null) {
			el.conceptoIngreso = "No Hay concepto";
		}
		//$(tr).removeAttr('id');
		$(tr).find('#fecha').text(el.date);
		$(tr).find('#estudiante').text(el.nombre);
		$(tr).find('#concepto').text(el.conceptoIngreso);
		$(tr).find('#numClases').text(el.hours);
		$(tr).find('#instrumento').text(el.name);
		$(tr).find('#numRecibo').text(el.nRecibo);
		$(tr).find('#valor').text($.number(Number(el.price), 0, ',', '.'));
		$(tr).find('#borrarIngresoEfectivo').attr('value', el.id);
		//$(tr).find('#borrarUsuario').attr('value', el.id);

		str += $(tr).prop('outerHTML');
	});
	return str;
}
function buildTrUserBanco(listUser) {
	var str = '';
	$.each(listUser, function (index, el) {
		var tr = $(trClone1).clone();
		//var birthday = '--';
		//if(el.birthday != "0000-00-00" && el.birthday != null) {
		//	birthday = el.birthday;
		//}
		//$(tr).removeAttr('id');
		$(tr).find('#fecha').text(el.date);
		$(tr).find('#estudiante').text(el.nombre);
		$(tr).find('#concepto').text(el.conceptoIngreso);
		$(tr).find('#numClases').text(el.hours);
		$(tr).find('#instrumento').text(el.name);
		$(tr).find('#numRecibo').text(el.nRecibo);
		$(tr).find('#valor').text($.number(Number(el.price), 0, ',', '.'));
		$(tr).find('#borrarIngresoBanco').attr('value', el.id);
		//$(tr).find('#borrarUsuario').attr('value', el.id);

		str += $(tr).prop('outerHTML');
	});
	return str;
}

