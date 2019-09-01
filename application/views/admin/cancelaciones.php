<div class="container mt-5 mb-5 shadow p-3 mb-5 bg-white rounded">
    <div clas="row">
        <div class="col ">
            <h2>Reprogramaciones de clase --EN construccion al 80%----</h2>
            <table class="table table-borderless table-hover table-responsive-sm" id="tableCancelations">
                <thead >
                    <tr>
                        <th>Fecha/hora</th>
                        <th>Estudiante</th>
                        <th>Instrumento</th>
                        <th>Fecha Reprogramacion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="trClone1">
                        <th scope="row" id="fecha"></th>
                        <td id="estudiante"></td>
                        <td id="instrumento"></td>
                        <td id="fechaReprogramacion"></td>
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
</div>
<script src="<?echo base_url() ?>assets/js/admin/cancelaciones.js?<? echo time_unix(); ?>" type="text/javascript"></script>