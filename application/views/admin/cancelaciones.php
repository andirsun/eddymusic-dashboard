
<div class="container mt-5 mb-5 shadow p-3 mb-5 bg-white rounded">
    <div clas="row">
        <div class="col ">
            <h2>Reprogramaciones de clase</h2>
            
            <table class="table table-borderless table-hover table-responsive-sm" id="tableCancelations">
                <thead >
                    <tr>
                        <th>Fecha/hora</th>
                        <th>Estudiante</th>
                        <th>Instrumento</th>
                        <th>Clase Cancelada</th>
                        <th>Clase Agendada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="trClone1">
                        <th scope="row" id="fecha"></th>
                        <td id="estudiante"></td>
                        <td id="instrumento"></td>
                        <td >
                            <a id="fechaCancelacion" href="" >
                            <i class="fas fa-calendar-alt fa-2x"></i>
                            </a>
                        </td>
                        <td id="fechaReprogramacion"></td>
                        <td id="acciones">
                            <div class="custom-control custom-switch">
                                <input value="" type="checkbox" class="custom-control-input" id="customSwitch1">
                                    <label id="estado" class="custom-control-label" for="customSwitch1"></label>
                                    <?php if ($level==0 || $level==4): ?>
                                        <span id="revertir"><i class="fas fa-history"></i></span>
                                    <?php endif ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/admin/cancelaciones.js?<?php echo time_unix(); ?>" type="text/javascript"></script>
<!--Switches, Documentation in https://gitbrent.github.io/bootstrap4-toggle/-->

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>