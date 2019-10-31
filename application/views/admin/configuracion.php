<div class="container-fluid my-4">
    <div class="row">
        
        <div class="col-4">
            <div class="shadow p-3 mb-5 bg-white rounded ">
            <h2>Informacion de Instrumentos</h2>
            <form id="addInstrument">
                <input type="hidden" name="id" id="id_instrumento" value="0">
                <fieldset class="form-group">
                    <label for="">Nombre</label>
                    <input type="text" name="name" id="name_instrumento" class="form-control">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Cupos</label>
                    <input type="number" name="nCupo" id="cupos_instrumento" class="form-control">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Precio Paquete 4 horas</label>
                    <input type="number" name="precioHora" id="precioHora" class="form-control">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Precio Paquete 8 horas</label>
                    <input type="number" name="precioHora8" id="precioHora8" class="form-control">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Precio Paquete 12 horas</label>
                    <input type="number" name="precioHora12" id="precioHora12" class="form-control">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Precio Paquete 16 horas</label>
                    <input type="number" name="precioHora16" id="precioHora16" class="form-control">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Precio Paquete 20 horas</label>
                    <input type="number" name="precioHora20" id="precioHora20" class="form-control">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Precio Paquete 24 horas</label>
                    <input type="number" name="precioHora24" id="precioHora24" class="form-control">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Precio Paquete 72 horas</label>
                    <input type="number" name="precioHora72" id="precioHora72" class="form-control">
                </fieldset>
                <button type="submit" class="btn btn-sm btn-success">
                    Guardar
                </button>
                <button type="button" class="btn btn-sm btn-danger" style="display:none;" id="close-form-edit">
                    <i class="fa fa-times"></i> Cancelar edicion
                </button>
                <div class="alert my-2" id="msg-edit-form">  
                </div>
            </form>
            </div>
        </div>
        <div class="col" id="col-form-edit" style="display: none;">

        </div>
        <div class="col"> 
            <div class="shadow p-3 mb-5 bg-white rounded ">
                <h2>Listado Instrumentos</h2>
                <table class="table table-striped  table-hover" id="tablaInstrumentos">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="d-none">
    <table>
        <tbody>
            <tr id="trClone" data-id="">
                <td id="id-instrument"></td>
                <td id="name">el.name+'</td>
                <td>
                    <?php if ($level==0): ?>
                    <button type="button" id="borrarInstrumento" class="btn btn-danger mx-1" value=''>
                        <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" id="editarInstrumento" class="btn btn-warning mx-1">
                        <i class="fa fa-wrench"></i>
                    </button>
                    <?php endif ?>
            </tr>
        </tbody>
    </table>
</div>
<!--
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <h1>Añadido.</h1>
    </div>
  </div>
</div>
-->
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/bootstrap.min.css"/>
<script src="<?echo base_url() ?>assets/js/admin/configuracion.js?<?echo time_unix(); ?>"></script>