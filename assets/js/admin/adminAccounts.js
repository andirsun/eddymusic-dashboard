// Modal
const modalElement = document.createElement('ion-modal');
let sucursales = [];
$(function () {
	loadAccounts();
	getSucursales();
	
});
customElements.define('modal-page', class extends HTMLElement {
  connectedCallback() {
		var sucursalesSelect = '';
		sucursales.map((sucursal)=>{
			sucursalesSelect+=`<option value=${sucursal.id}>${sucursal.name}</option>`
		})
    this.innerHTML = `
			<ion-header mode="ios">
				<ion-toolbar>
					<ion-title>Nuevo Usuaro</ion-title>
					<ion-buttons slot="primary">
					<ion-button onClick="dismissModal()">
						<ion-icon slot="icon-only" name="close"></ion-icon>
					</ion-button>
				</ion-buttons>
				</ion-toolbar>
			</ion-header>
			<ion-content class="ion-padding">
				<ion-item>
					<ion-label>Sucursal</ion-label>
					<select onchange="modalElement.componentProps.sucursal = this.value">
						<option value="">Selecciona...</option>
						${sucursalesSelect}
					</select>
				</ion-item>
				<ion-item>
					<ion-label for="cars">Rol</ion-label>
					<select  onchange="modalElement.componentProps.level = this.value">
						<option value="">Selecciona...</option>
						<option value="0">Super Administrador</option>
						<option value="4">Administrador Sucursal</option>
						<option value="1">Asistente</option>
					</select>
				</ion-item>
				<ion-item>
					<ion-label>Nombre de usuario</ion-label>
					<input type="username" placeholder="usuario" onkeypress="modalElement.componentProps.userName = this.value"></input>
				</ion-item>
				<ion-item>
					<ion-label>Contraseña</ion-label>
					<input type="password" onkeypress="modalElement.componentProps.password = this.value"></input>
				</ion-item>
				<ion-button color="primary" onclick="createUser()">Crear</ion-button>
			</ion-content>`;
  }
});

const getSucursales = async () => {
	await fetch(base_url + 'admin_ajax/getSucursales')
  .then(response => response.json())
  .then(data => {
		sucursales = data.content;
	});
}

const presentModal = () => {
  // create the modal with the `modal-page` component
  modalElement.component = 'modal-page';
	modalElement.cssClass = 'my-custom-class';
	modalElement.componentProps = {
		'sucursal': '',
		'level': 0,
		'userName': '',
		'password' :''
	};
  // present the modal
	document.body.appendChild(modalElement);
  return modalElement.present();
}

async function dismissModal() {
  await modalElement.dismiss({
    'dismissed': true
  });
}

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

const createUser = async() =>{
	modalElement.componentProps.sucursal = parseInt(modalElement.componentProps.sucursal);
	modalElement.componentProps.level = parseInt(modalElement.componentProps.level);
	$.ajax({
		url: base_url + 'admin_ajax/createUser',
		type: 'GET',
		dataType: 'json',
		data:modalElement.componentProps,
		beforeSend: function () {},
		success: function (r) {
				if (r.response == 'OK') {
					alert("Creado");
				}
				dismissModal();
				loadAccounts();
				
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