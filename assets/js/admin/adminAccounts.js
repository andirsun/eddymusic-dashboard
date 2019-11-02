$(function () {
    console.log("From AdminAccounts");
    loadAccounts();
});

function loadAccounts(){
    $.ajax({
		url: base_url + 'admin_ajax/getAccounts',
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
			$("#tableAccounts").dataTable().fnDestroy();
		},
		success: function (r) {
			console.log('list accounts \n', r);
			var tableBody = $('#tableAccounts').find("tbody");
			var str = buildTr(r.content);
			$(tableBody).html(str);
			table = $("#tableAccounts").DataTable( {
				"order": [[ 1, "asc" ]]
			} );
			console.log(table);
		},
		error: function (xhr, status, msg) {
			console.log(xhr.responseText);
		}
	});

}

function buildTr(listUser) {
	var str = '';
	$.each(listUser, function (index, el) {
		var tr = $(trClone).clone();
		$(tr).find('#user').text(el.user);
        $(tr).find('#sucursal').text(el.sucursal);
        $(tr).find('#lastAccess').text(el.lastAccess);
		$(tr).find('#changePassword').attr('value', el.id);
		//$(tr).find('#borrarUsuario').attr('value', el.id);

		str += $(tr).prop('outerHTML');
	});
	return str;
}