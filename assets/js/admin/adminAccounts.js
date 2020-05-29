/* esta funcion se ejecuta automaticamente */
$(function () {
  loadAccounts();
});
/* 
	Esta funcion carga las cuentas de usuario
	Automaticamente en la tabla
*/
function loadAccounts(){
	/* Peticion ajax al backend */
	$.ajax({
		url: base_url + 'admin_ajax/getAccounts',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
			$("#tableAccounts").dataTable().fnDestroy();
		},
		success: function (r) {
			//console.log('list accounts \n', r);
			var tableBody = $('#tableAccounts').find("tbody");
			var str = buildTr(r.content);
			// Selecciono la tabla y le agrego el html
			$(tableBody).html(str);
			/* plugin para ordenar el contenido por la primera columna */
			table = $("#tableAccounts").DataTable( {
				"order": [[ 1, "asc" ]]
			} );
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});

}
/* THis funcion change the password of any user */
function changePassword(id){
	let pass = prompt("Nueva contraseña");
	$.ajax({
		url: base_url + 'admin_ajax/changePasswordAccount',
		type: 'GET',
		data:{
			idUser : id,
			password : pass
		},	
		dataType: 'json',
		beforeSend: function () {
			
		},
		success: function (response) {
			//console.log('response', response);
			if(response.response ===2){
				alert("Se actualizo correctamente la contraseña");
			}else{
				alert("No se pudo actualizar la contraseña")
			}
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});
}
/* FUncion para llenar la tabla con informacion */
function buildTr(listUser) {
	var str = '';
	$.each(listUser, function (index, el) {
		var tr = $(trClone).clone();
		$(tr).find('#user').text(el.user);
		$(tr).find('#sucursal').text(el.sucursal);
		$(tr).find('#lastAccess').text(el.lastAccess);
		$(tr).find('#changePassword').attr('value', el.id);
		$(tr).find('#changePassword').attr('onClick',`changePassword(${el.id})`);
		//$(tr).find('#borrarUsuario').attr('value', el.id);

		str += $(tr).prop('outerHTML');
	});
	return str;
}