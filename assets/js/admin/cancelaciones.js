$(function(){
   loadData();
   revisarRegistro();
   deshacerRegistro();
   
   
});

function loadData(){
   //this function load the data of query and build the table with the info
   $.ajax({
		url: base_url + 'admin_ajax/getCancelaciones',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
		},
		success: function (r) {
         if (r.response == 2) {
				//console.log('data \n', r.content);
            var tableBody = $('#tableCancelations').find("tbody");//pick the body of the table
            var str = buildTable(r.content);//build the table with the info 
            $(tableBody).html(str); //load the data into the html of the table
            table = $("#tableCancelations").DataTable({
               "order": [[ 0, "desc" ]]
           } );//apply data table format
         }
         
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	}); 
}

function revisarRegistro(){
   $("body").on("click","#tableCancelations input",function(event){
      $(this).attr('disabled',true);
      var objeto = $(this).closest('td').find('label').html("Revisado <i style='color:green;' class='fas fa-check-circle'></i>");
      var id = $(this).attr("id");
      console.log(id);
      $.ajax({
         url: base_url + 'admin_ajax/setRevisarCancelacion',
         type: 'GET',
         dataType: 'json',
         data:{id:id},
         beforeSend: function () {
      
         },
         success: function (r) {
            if (r.response == 2) {
              console.log("estado cambiado correctamente");
            }else{
               alert("Ups algo malo paso, reporta el error y recarga la pagina ");
            }
            
         },
         error: function (xhr, status, msg) {
            console.log(xhr.responseText);
         }
      }); 
      
   });
}

function deshacerRegistro(){
   $("body").on("click","#tableCancelations span",function(event){
      $(this).closest('td').find('label').html("No revisado <i style='color:red;' class='fas fa-times-circle'></i>");
      //$(this).closest('td').find('input').attr("disabled",false)
      $(this).closest('td').find('input').trigger("click");
      var id = $(this).attr("id");
      
      
      $.ajax({
         url: base_url + 'admin_ajax/setRevertirRevisionCancelacion',
         type: 'GET',
         dataType: 'json',
         data:{id:id},
         beforeSend: function () {
      
         },
         success: function (r) {
            if (r.response == 2) {
              console.log("estado desactivado correctamente");
            }else{
               alert("Ups algo malo paso, reporta el error y recarga la pagina ");
            }
            location.reload();
         },
         error: function (xhr, status, msg) {
            console.log(xhr.responseText);
         }
      }); 
      
      
   });
}
function buildTable(data){
   //this function complete and build the table cancelaciones with de data of the query
   var str = '';
	$.each(data, function (index, el) {
		var tr = $(trClone1).clone();
		$(tr).find('#fecha').text(el.date);
		$(tr).find('#estudiante').text(el.name);
		$(tr).find('#instrumento').text(el.instrumento);
      $(tr).find('#fechaReprogramacion').text(el.dateStart);

      

      console.log(el.status);
      $(tr).find('#estado').html("No revisado <i style='color:red;' class='fas fa-times-circle'></i>");
      if(el.status ==1){
         $(tr).find('#customSwitch1').attr("checked",true);
         $(tr).find('#customSwitch1').attr("disabled",true);
         $(tr).find('#estado').html("Revisado <i style='color:green;' class='fas fa-check-circle'></i>");
      }
      $(tr).find('#customSwitch1').attr("id",el.id);
      $(tr).find('#estado').attr("for",el.id);
      $(tr).find('#revertir').attr("id",el.id)
		$(tr).find('#customSwitch1').attr('value', el.id);//este id es el de guia para hacer los checks 
      
		str += $(tr).prop('outerHTML');
	});
	return str;
}

