<ul class="nav nav-pills mb-3 px-3 pt-2" id="pills-tab" role="tablist">
    <li class="nav-item">
         <a class="nav-link " id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Nuev Estudiante</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Estudiantes</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <h1 class="h2">Nuevo estudiante</h1>
        
        <form id="addUserForm"> 
            <input type="hidden" id="id" name="id" value="0">
            <input type="hidden" id="level" name="level" value="3">
            <div class="form-group row no-gutters">
                <label for="userName" class="col-sm-2 col-form-label">Nombre Completo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  name="name" id="userName" placeholder="Nombre de Usuario" required>
                </div>
            </div>
            <div class="form-group row no-gutters">
                <div class="col-sm-2">
                    Documento <span id="loader" style="display: none"><i class="fa fa-spin fa-spinner"></i></span>
                </div>
                <div class="col-sm-10">
                    <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                        <input type="hidden" name="type_document" value="0">
                        <div class="btn-group" role="group" aria-label="First group">
                            <button type="button" class="btn btn-secondary " data-type="0" id="typeDocument">T.I.</button>
                            <button type="button" class="btn btn-secondary active" data-type="1" id="typeDocument">C.C.</button>
                        </div>
                        <div class="input-group col-8">
                            <input type="number" required class="form-control" name="document" id="numIdentidicacion" placeholder="Numero identificacion" aria-label="Input group example" aria-describedby="btnGroupAddon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row no-gutters">
                <label for="password" class="col-sm-2 col-form-label">Num Huellero</label>
                <div class="col-sm-10">
                    <input type="number"  class="form-control" name="idHuellero" id="idHuellero" placeholder="Numero">
                </div>
            </div>
            <div class="form-group row no-gutters">
                <label for="NumeroInscripcion" class="col-sm-2 col-form-label">Numero Inscripcion</label>
                <div class="col-sm-10">
                    <input type="number"  class="form-control" name="numeroInscripcion" id="NumeroInscripcion" placeholder="Numero">
                </div>
            </div>
			<div class="form-group row no-gutters">
                <label for="Email" class="col-sm-2 col-form-label">Correo Electronico</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" id="Email" placeholder="Correo Electronico">
                </div>
			</div>
			<div class="form-group row no-gutters">
                <label for="PNumber" class="col-sm-2 col-form-label">Telefono Principal</label>
                <div class="col-sm-10">
                    <input type="number"class="form-control" name="tel" id="Pnumber" placeholder="Numero" required>
                </div>
			</div>
			<div class="form-group row no-gutters">
                <label for="SNumber" class="col-sm-2 col-form-label">Telefono Secundario</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="tel2" id="Snumber" placeholder="Numero">
                </div>
            </div>
            <div class="form-group row no-gutters">
                <label for="direccion" class="col-sm-2 col-form-label">Direccion</label>
                <div class="col-sm-10">
                    <input type="text"class="form-control" name="direccion" id="adress" placeholder="Direccion.">
                </div>
            </div>
			<div class="form-group row no-gutters">
                <label for="nombreAcudiente" class="col-sm-2 col-form-label">Acudiente</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nombreAcudiente" id="nombreAcudiente" placeholder="Nombre Completo">
                </div>
            </div>
            <div class="form-group row no-gutters">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Cumpleaños</label>
                <div class="col-sm-10">
                    <input type="date" name="birthday" class="form-control" id="birthday" placeholder="YYYY-MM-DD">
                </div>
			</div>
			<div class="form-group">
				<label for="exampleFormControlTextarea1">Observaciones</label>
				<textarea class="form-control" name="observaciones" id="observaciones" rows="3"></textarea>
			</div>
            <div class="form-group row no-gutters">
                <div class="col-sm-10">
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> -->
					<button type="submit" class="btn btn-primary">  
  						Añadir Estudiante
					</button>
                    <button type="button" id="cancel-edit" style="display: none;" class="btn btn-danger">
                        Cancelar edicion
                    </button>
                </div>
            </div>
            <div class="alert" id="msg-add-user" style="display: none;">
                <h3 id="text-add-form" class="m-0"></h3>
            </div>
        </form>
	</div>
	
    <!-- ------------------------------------------------------------------>
    <div class="tab-pane fade show active ml-2 mr-2" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Listado de estudiantes</h1>
        </div>
        <div class="shadow p-3 mb-5 bg-white rounded ">
            <table class="table table-borderless table-hover table-responsive-sm" id="tablaEstudiantes">
                <thead >
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">numHuellero</th>
                        <th scope="col">Nombre completo </th>
                        <th scope="col">Tipo Documento</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Fecha Cumpleaños</th>
                        <th scope="col">Observaciones </th>
                        <th scope="col">Acciones</th>
                        <th scope="col">Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal para editar usuario -->
<div class="modal fade" id="modalEditarUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar Informacion de usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formUserEdit" >
            <div class="form-group row">
                <label for="userName" class="col-sm-4 col-form-label">Nombre </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nameEdit" id="userNameEdit" placeholder="Nombre de Usuario">
                </div>
            </div>
            <div class="form-group row">
                <label for="type_document" class="col-sm-4 col-form-label">Tipo documento</label>
                <div class="col-sm-8">          
                    <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups" id="btnGroupType">
                        <input type="hidden" name="type_document" id="type_document_edit" value="0">
                        <div class="btn-group" role="group" aria-label="First group">
                            <button type="button" class="btn btn-secondary " data-type="0">T.I.</button>
                            <button type="button" class="btn btn-secondary active" data-type="1">C.C.</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-4 col-form-label">Documento</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="documentoEdit" id="documentoEdit" placeholder="Numero">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Cumpleaños</label>
                <div class="col-sm-8">
                    <input type="date" name="birthdayEdit" class="form-control" id="birthdayEdit" placeholder="YYYY-MM-DD">
                </div>
			</div>
            <div class="form-group">
				<label for="exampleFormControlTextarea1">Observaciones</label>
				<textarea class="form-control" name="observacionesEdit" id="observacionesEdit" rows="3"></textarea>
			</div>
            <button type="submit" id="btnActualizar" class="btn btn-success" data-toggle="modal">
  			    Editar Datos
		    </button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="d-none">
    <table>
        <tbody>
            <tr id="trClone">
              <th scope="row" id="id_user"></th>
              <td id="idHuellero"></td>
              <td id="name"></td>
              <td id="type_document"></td>
              <td id="document"></td>
              <td id="birthday"></td>
              <td id="observaciones"></td>
              <td class="d-inline-flex">
                <button type="button" id="editarUsuario" class="btn btn-warning" value=''>
                  <i class="fas fa-edit"></i>
                </button>
                <?php if ($level==0 || $level==4): ?>
                    <button type="button" id="borrarUsuario" class="btn btn-danger ml-4" value=''>
                      <i class="fas fa-trash"></i>
                    </button>
                <?php endif ?>
                <a href="#" id="usuarioCalendario"  class="btn btn-primary ml-4" value=''>
                  <i class="fas fa-calendar"></i>
                </a>
              </td>
              <td id="status">Activo</td>
            </tr>
        </tbody>
    </table>
</div>
<script src="<?echo base_url() ?>assets/js/admin/addUser.js?<?echo time_unix(); ?>"></script>
