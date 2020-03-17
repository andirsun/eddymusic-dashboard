<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="tabIngresos" data-toggle="pill" href="#egresoEfectivo" role="tab" aria-controls="pills-home" aria-selected="true">Efectivo</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#egresoBancos" role="tab" aria-controls="pills-profile" aria-selected="false">Bancos</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="egresoEfectivo" role="tabpanel" aria-labelledby="pills-home-tab">
        <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modalEgresoEfectivo" data-whatever="@mdo">Agregar Nuevo Egreso</button>
        <div  id="flujoCaja" class="container-fluid">
            

        </div>
        <div class="form-group  row no-gutters">
            <label for="inputEmail3" class="col-sm-1 col-form-label">Mostrar Desde :</label>
            <div class="col-sm-3 mr-2">
                <input type="date" class="form-control" id="inicioFiltroDateEgresosEfectivo" placeholder="YYYY-MM-DD">
            </div>
            <label for="inputEmail3" class="col-sm-0 col-form-label mr-2">Hasta:</label>
            <div class="col-sm-3 mr-2">
                <input type="date" class="form-control" id="finFiltroDateEgresosEfectivo" placeholder="YYYY-MM-DD"  >
            </div>
            
            <div class="col-sm-0 mr-2">
                <button type="button" class="btn btn-primary" id="botonFiltrarEgresosEfectivo">
                    <i class="fas fa-search"></i>
                </button> 
            </div>
            <div class="col-sm-2 mr-2 ml-2"> 
                <input type="text"  class="form-control" id="dineroEgresos" placeholder="Dinero" readonly>
            </div>
    </div>
        <table class="table table-borderless table-hover table-responsive-sm" id="tablaEgresosEfectivo">
            <thead  class="thead-dark" >
                <tr>
                    <th id="fecha">Fecha</th>
                    <th id="concepto">Concepto Egreso</th>
                    <th id="descripcion">Descripcion</th>
                    <th id="valor">Valor</th>
                    <th id="accionesEgreso">Acciones</th>

                </tr>
            </thead>
            <tbody>
                <tr id="trClone">
                        <th scope="row" id="fecha"></th>
                        <td id="concepto"></td>          
                        <td id="descripcion"></td>
                        <td id="valor"></td>
                        <td class="d-inline-flex">
                            <?php if ($level==0 /*|| $level==4*/): ?>
                                <button type="button" id="borrarEgresoEfectivo" class="btn btn-danger ml-4" value=''>
                                  <i class="fas fa-trash"></i>
                                </button>
                            <?php endif ?>
                        </td>
                    </tr>  
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="egresoBancos" role="tabpanel" aria-labelledby="pills-profile-tab">
        <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modalEgresoBancos" data-whatever="@mdo">Agregar Nuevo Egreso</button>
        <div  id="flujoCajaBanco" class="container-fluid">
            

            </div>
        <div class="form-group  row no-gutters ">
            <label for="inputEmail3" class="col-sm-1 col-form-label">Mostrar Desde :</label>
            <div class="col-sm-3 mr-2 mb-2">
                <input type="date" class="form-control" id="inicioFiltroDateEgresosBanco" placeholder="YYYY-MM-DD">
            </div>
            <label for="inputEmail3" class="col-sm-0 col-form-label mr-2">Hasta:</label>
            <div class="col-sm-3 mr-2">
                <input type="date" class="form-control" id="finFiltroDateEgresosBanco" placeholder="YYYY-MM-DD">
            </div>
            <div class="col-sm-0 mr-2">
                <button type="button" class="btn btn-primary" id="botonFiltrarEgresosBanco">
                    <i class="fas fa-search"></i>
                </button> 
            </div>
            <div class="col-sm-2 mr-2 ml-2"> 
                <input type="text"  class="form-control" id="dineroEgresosBanco" placeholder="Dinero" readonly>
            </div>
        </div>
        <table class="table table-borderless table-hover table-responsive-sm" id="tablaEgresosBanco">
            <thead  class="thead-dark">
                <tr >
                    <th id="fecha">Fecha</th>
                    <th id="concepto">Concepto Gasto</th>
                    <th id="banco">Banco</th>
                    <th id="descripcion">Descripcion</th>
                    <th id="valor">Valor</th>
                    <th id="accionesEgreso">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr id="trClone1">
                    <th scope="row" id="fecha"></th>
                    <td id="concepto"></td>  
                    <td id="banco"></td>         
                    <td id="descripcion"></td>
                    <td id="valor"></td>
                    <td class="d-inline-flex">
                        <?php if ($level==0 /*|| $level==4*/): ?>
                            <button type="button" id="borrarEgresoBanco" class="btn btn-danger ml-4" value=''>
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
<div class="modal fade" id="modalEgresoEfectivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Egreso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formEgresoEfectivo">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Valor Egreso: <span id="valEgresoFormated">0</span></label>
                <input name="valorEgresoEfectivo"type="number" class="form-control" id="valorEgresoEfectivo">
            </div>
            <div class="form-row align-items-center">
                <div class="col-auto my-1">
                    <label class="mr-sm-2" for="conceptoEgresoEfectivo">Concepto</label>
                    <select name="conceptoEgresoEfectivo"class="custom-select mr-sm-2" id="conceptoEgresoEfectivo">
                        <option selected>Seleccione...</option>
                        <option value="Inversion">Inversion</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                        <option value="Papeleria y utiles">Papeleria y utiles</option>
                        <option value="Servicios">Servicios</option>
                        <option value="Transporte">Transporte</option>
                        <option value="Nomina">Nomina</option>
                        <option value="Viaticos">Viaticos</option>
                        <option value="Gastos Financieros">Gastos Financieros</option>
                        <option value="Cafeteria">Cafeteria</option>
                        <option value="Restaurante">Restaurante</option>
                        <option value="Publicidad">Publicidad</option>
                        <option value="Elementos Aseo">Elementos de Aseo</option>
                        <option value="Otros">Otros</option>
                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-form-label">Descripcion Egreso:</label>
                <textarea name="descripcionEgresoEfectivo"class="form-control" id="descripcionEgresoEfectivo"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" id="addEgresoEfectivo">Agregar</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            
        </div>
        </div>
    </div>
</div>
<!-- Aca se acaba el modal para agregar un nuevo ingreso-->

<!-- Modal para agregar un nuevo Gasto En la pag de boostrap esta para colocar la peticion ajax y cambiar los textos con jquery-->
<div class="modal fade" id="modalEgresoBancos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Gasto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formEgresoBanco">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Valor Egreso: <span id="valEgresoFormated2">0</span></label>
                <input name="valorEgresoBanco" type="number" class="form-control" id="valorEgresoBanco">
            </div>
            <div class="form-group">
                <label  class="col-form-label">Banco:</label>
                <input name="bancoEgreso"type="text" class="form-control" >
            </div>
            <div class="form-row align-items-center">
                <div class="col-auto my-1">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Concepto</label>
                    <select name="conceptoEgresoBanco"class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                        <option selected>Seleccione...</option>
                        <option value="Inversion">Inversion</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                        <option value="Papeleria y Utiles">Papeleria y utiles</option>
                        <option value="Servicios">Servicios</option>
                        <option value="Transporte">Transporte</option>
                        <option value="Nomina">Nomina</option>
                        <option value="Viaticos">Viaticos</option>
                        <option value="Gastos Financieros">Gastos Financieros</option>
                        <option value="Cafeteria">Cafeteria</option>
                        <option value="Restaurante">Restaurante</option>
                        <option value="Publicidad">Publicidad</option>
                        <option value="Elementos Aseo">Elementos de Aseo</option>
                        <option value="Otros">Otros</option>
                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="message-text" class="col-form-label">Descripcion :</label>
                <textarea name="descripcionEgresoBanco"class="form-control" id="message-text"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" id="addEgresoBanco">Agregar</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            
        </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/admin/egresos.js?<?php echo time_unix(); ?>"></script>
<!-- Aca se acaba el modal para agregar un nuevo ingreso-->
