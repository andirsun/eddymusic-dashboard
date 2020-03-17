<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="tabIngresos" data-toggle="pill" href="#ingresosEfectivo" role="tab" aria-controls="pills-home" aria-selected="true">Efectivo</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#ingresosBancos" role="tab" aria-controls="pills-profile" aria-selected="false">Bancos</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="ingresosEfectivo" role="tabpanel" aria-labelledby="pills-home-tab">
        <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalIngresoEfectivo" data-whatever="@mdo">Agregar Nuevo Ingreso</button>
        <div  class="container-fluid ">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-3 text-center shadow p-3 mb-5 bg-white rounded" id="flujoCaja"></div>
            </div>
            

        </div>
        <div class="form-group row no-gutters">
            <label for="inputEmail3" class="col-sm-0 col-form-label mr-2">Mostrar Desde:</label>
            <div class="col-sm-3 mr-2">
                <input type="date"class="form-control" id="inicioFiltroDateIngresosEfectivo" placeholder="YYYY-MM-DD"> 
            </div>
            <label for="inputEmail3" class="col-sm-0 col-form-label mr-2">Hasta:</label>
            <div class="col-sm-3 mr-2">
                <input type="date"  class="form-control" id="finFiltroDateIngresosEfectivo" placeholder="YYYY-MM-DD">
            </div>
            <div class="col-sm-0">
                <button type="button" class="btn btn-primary" id="botonFiltrarIngresos">
                    <i class="fas fa-search"></i>
                </button> 
            </div>
            <div class="col-sm-2 mr-2 ml-2"> 
                <input type="text"  class="form-control" id="dineroIngresos" placeholder="Dinero" readonly>
            </div>
        </div>
        <table class="table table-borderless table-hover table-responsive-sm ml-2 mt-2 mr-2 shadow p-3 mb-5 bg-white rounded" id="tablaIngresosEfectivo">
            <thead>
                <tr >
                    <th id="fecha">Fecha/Hora</th>
                    <th id="estudiante">Estudiante</th>
                    <th id="concepto">Concepto ingreso</th>
                    <th id="numClases">Cantidad de clases</th>
                    <th id="instrumento">Instrumento</th>
                    <th id="numRecibo">Num Recibo</th>
                    <th id="valor">Valor</th>
                    <th id="accionesEfectivo">Acciones</th>
                </tr>
            </thead>
            <tbody>
                    <tr id="trClone">
                        <th scope="row" id="fecha"></th>
                        <td id="estudiante"></td>
                        <td id="concepto"></td>
                        <td id="numClases"></td>
                        <td id="instrumento"></td>
                        <td id="numRecibo"></td>
                        <td id="valor"></td>
                        <td class="d-inline-flex">
                            <?php if ($level==0 /*|| $level==4*/): ?>
                                <button type="button" id="borrarIngresoEfectivo" class="btn btn-danger ml-4" value=''>
                                  <i class="fas fa-trash"></i>
                                </button>
                            <?php endif ?>
                        </td>
                    </tr>  
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="ingresosBancos" role="tabpanel" aria-labelledby="pills-profile-tab">
        <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalIngresoBanco" data-whatever="@mdo">Agregar Nuevo Ingreso</button>
    
        
        <div  class="container-fluid ">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-3 text-center shadow p-3 mb-5 bg-white rounded" id="flujoCajaBanco"></div>
            </div>
            

        </div>
        <div class="form-group  row no-gutters">
            <label for="inputEmail3" class="col-sm-1 col-form-label">Mostrar Desde :</label>
            <div class="col-sm-3 mr-2">
                <input type="date" class="form-control" id="inicioFiltroDateIngresosBanco" placeholder="YYYY-MM-DD">
            </div>
            <label for="inputEmail3" class="col-sm-0 col-form-label mr-2">Hasta:</label>
            <div class="col-sm-3 mr-2">
                <input type="date" class="form-control" id="finFiltroDateIngresosBanco" placeholder="YYYY-MM-DD">
            </div>
            <div class="col-sm-0">
                <button type="button" class="btn btn-primary" id="botonFiltrarIngresosBanco">
                    <i class="fas fa-search"></i>
                </button> 
            </div>
            <div class="col-sm-2 mr-2 ml-2"> 
                <input type="text"  class="form-control" id="dineroIngresosBanco" placeholder="Dinero" readonly>
            </div>
            

        </div>
        <table class="table table-borderless table-hover table-responsive-sm ml-2 mt-2 mr-2 shadow p-3 mb-5 bg-white rounded" id="tablaIngresosBanco">
            <thead >
                <tr> 
                    <th id="fecha">Fecha</th>
                    <th id="estudiante">Estudiante</th>
                    <th id="concepto">Concepto ingreso</th>
                    <th id="numClases">Cantidad de clases</th>
                    <th id="instrumento">Instrumento</th>
                    <th id="numRecibo">Num Recibo</th>
                    <th id="valor">Valor</th>
                    <th id="accionesBanco">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr id="trClone1">
                <th scope="row" id="fecha"></th>
                <td id="estudiante"></td>
                <td id="concepto"></td>
                <td id="numClases"></td>
                <td id="instrumento"></td>
                <td id="numRecibo"></td>
                <td id="valor"></td>
                <td class="d-inline-flex">
                    <?php if ($level==0 /*|| $level==4*/): ?>
                        <button type="button" id="borrarIngresoBanco" class="btn btn-danger ml-4" value=''>
                        <i class="fas fa-trash"></i>
                        </button>
                    <?php endif ?>
                </td>
                </tr>  
            </tbody>
        </table>   
    </div>
</div>
<!-- Modal para agregar un nuevo ingreso En la pag de boostrap esta para colocar la peticion ajax y cambiar los textos con jquery-->
<div class="modal fade" id="modalIngresoEfectivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Ingreso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formAddIngreso">
                <div class="form-group">
                    <label  class="col-form-label">Valor Ingreso: <span id="valAddIngresoFormated">0</span></label>
                    <input  name="valorAddIngreso"class="form-control" type="number" id="valorAddIngreso"> <!--El name se usa para poder hacer el submit del formulario-->
                </div>
                <div class="form-group">
                    <label class="col-form-label">Concepto Ingreso</label>
                    <input name="conceptoAddIngreso"type="text" class="form-control" id="conceptoAddIngreso">
                </div>
                 <div class="form-group">
                    <label class="col-form-label">Numero Recibo:</label>
                    <input name="nReciboAddIngreso"type="number" class="form-control" id="nReciboAddIngreso">
                </div>
                <button type="submit" class="btn btn-primary" id="botonAgregarIngreso">Agregar</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            
        </div>
        </div>
    </div>
</div>
<!-- Aca se acaba el modal para agregar un nuevo ingreso-->

<!-- Modal para agregar un nuevo ingreso En la pag de boostrap esta para colocar la peticion ajax y cambiar los textos con jquery-->
<div class="modal fade" id="modalIngresoBanco" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Ingreso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formAddIngresoBanco">
                <div class="form-group">
                    <label  class="col-form-label">Valor Ingreso: <span id="valAddIngresoFormated">0</span></label>
                    <input  name="valorAddIngresoBanco"class="form-control" type="number" id="valorAddIngresoBanco"> <!--El name se usa para poder hacer el submit del formulario-->
                </div>
                <div class="form-group">
                    <label class="col-form-label">Concepto Ingreso</label>
                    <input name="conceptoAddIngresoBanco"type="text" class="form-control" id="conceptoAddIngresoBanco">
                </div>
                 <div class="form-group">
                    <label class="col-form-label">Numero Recibo:</label>
                    <input name="nReciboAddIngresoBanco"type="number" class="form-control" id="nReciboAddIngresoBanco">
                </div>
                <button type="submit" class="btn btn-primary" id="botonAgregarIngresoBanco">Agregar</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            
        </div>
        </div>
    </div>
</div>
<!-- Aca se acaba el modal para agregar un nuevo ingreso-->

<!-- Aca se acaba el modal para agregar un nuevo ingreso-->
<script src="<?php echo base_url() ?>assets/js/admin/ingresos.js?<?php echo time_unix(); ?>"></script>
