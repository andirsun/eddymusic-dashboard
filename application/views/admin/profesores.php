<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Añadir Nuevo Profesor</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Lista de Profesores</a>
    </li>
   
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
    <form id="addUserForm"> 
      <input type="hidden" name="id" id="id" value="0">
      <input type="hidden" id="level" name="level" value="2">
      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Nombre</label>
        <div class="col-sm-10">
          <input type="text" name="name" class="form-control" id="name" placeholder="Nombre">
        </div>
      </div>
      <div class="form-group row">
        <label name="tel" class="col-sm-2 col-form-label">Telefono</label>
        <div class="col-sm-10">
          <input name ="tel"type="number" class="form-control" id="telProfe" placeholder="celular">
        </div>
      </div>
      <div class="form-group row">
        <label  class="col-sm-2 col-form-label">Correo</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" name="email" id="email" placeholder="Correo" >
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2">
          Documento <span id="loader" style="display: none"><i class="fa fa-spin fa-spinner"></i></span>
        </div>
          <div class="col-sm-10">
              <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                  <input type="hidden" name="type_document" value="0">
                  <div class="btn-group" role="group" aria-label="First group">
                      <button type="button" class="btn btn-secondary active" data-type="1" id="typeDocument">C.C.</button>
                  </div>
                  <div class="input-group col-8">
                      <input type="text" class="form-control" name="document" id="numIdentidicacion" placeholder="Numero identificacion" aria-label="Input group example" aria-describedby="btnGroupAddon" required>
                  </div>
              </div>
          </div>
      </div>
      <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Cumpleaños</label>
        <div class="col-sm-10">
            <input type="date" name="birthday" class="form-control" id="birthday" placeholder="YYYY-MM-DD" >
        </div>
			</div>
      <div class="form-group row">
        <label for="exampleFormControlFile1" class="col-sm-2 col-form-label" >Hoja De Vida</label>
        <div class="col-sm-10">
          <input type="file" class="form-control-file" id="hojaVida" name="hojaVida">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary">Añadir Profesor</button>
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

  
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Listado de Profesores</h1>
    </div>
    <table class="table table-striped table-hover table-lg table-responsive-sm " id="tablaProfesores">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Documento</th>
          <th scope="col">Celular</th>
          <th scope="col">Fecha Cumpleaños</th>
          <th scope="col">Email</th>
          <th scope="col">H.V</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

</div>
<button type="hidden" hidden data-toggle="modal" data-target=".bd-example-modal-lg" id="btn-open-modal-cv"></button>
<!-- Modal para ver el archivo pdf de la hoja de vida usuario -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-2">
      <h2>Hoja de vida</h2>
      <iframe src="" id="iframe-pdf" class="mb-2" style="display:none;width:100%;height:400pt;" frameborder="0"></iframe>
      <form class="d-inline-block mt-4" id="form-file-cv">
        <input type="text" id="idTeacher">
        <div class="d-flex mb-2">
          <input type="file" name="file" id="file-cv" class="file-cv" accept="application/pdf" required>
          <label for="file-cv" class="label-cv">
            <span class="one-file">1 archivo</span>
            <i class="fas fa-file-upload mr-1"></i>
            Seleccionar archivo
          </label>
          <button type="submit" class="btn btn-success rounded-0">
            <i class="fas fa-save mr-1"></i> Guardar 
          </button>
          <button type="button" class="ml-1 btn btn-danger rounded-0" id="clearInputFileCv">
            <i class="fas fa-eraser mr-1"></i> Limpiar
          </button>
        </div>
        <div class="progress-bard-file" id="progress" style="display: none;"></div>
        <div id="msg-cv" class="alert" style="display: none;"></div>
<!--         <span class="num-files" id="file-cv-info">
          nombre del archivo
        </span> -->
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"></script>
<script src="<?echo base_url() ?>assets/js/admin/profesor.js?<?echo time_unix(); ?>"></script>


       