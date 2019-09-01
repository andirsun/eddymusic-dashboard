$(function(){
   loadData();
});

function loadData(){
   //this function load the data of query and build the table with the info
   $.ajax({
		url: base_url + 'admin_ajax/cancelaciones',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
         //$("#tableCancelations").dataTable().fnDestroy();
		},
		success: function (r) {
         
         if (r.response == 2) {
				console.log('data \n', r.content);
            var tableBody = $('#tableCancelations').find("tbody");//pick the body of the table
            var str = buildTable(r.content);//build the table with the info 
            $(tableBody).html(str); //load the data into the html of the table
            //table = $("#tablaIngresosEfectivo").DataTable(dataTableOptions);//apply data table format
         }
         
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});
    
}
function buildTable(data){
   //this function complete and build the table cancelaciones with de data of the query
   var str = '';
	$.each(data, function (index, el) {
		var tr = $(trClone1).clone();
		$(tr).find('#fecha').text(el.date);
		$(tr).find('#estudiante').text(el.nombre);
		$(tr).find('#instrumento').text(el.instrumento);
		$(tr).find('#fechaReprogramacion').text(el.dateStart);
		
		$(tr).find('#fecha').attr('value', el.id);//este id es el de guia para hacer los checks 

		str += $(tr).prop('outerHTML');
	});
	return str;
}