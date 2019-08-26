<div class="container mt-5 mb-5 shadow p-3 mb-5 bg-white rounded">
    <div clas="row">
        <div class="col ">
            <h2>Reprogramaciones de clase --EN construccion--</h2>
            <table class="table table-borderless table-hover table-responsive-sm" id="tableCancelations">
                <thead >
                    <tr>
                        <th>Fecha</th>
                        <th>Estudiante</th>
                        <th>Concepto ingreso</th>
                        <th>Cantidad de clases</th>
                        <th>Instrumento</th>
                        <th>Num Recibo</th>
                        <th>Valor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="trClone1">
                        <th scope="row" id="fecha">asd</th>
                        <td id="estudiante">asd</td>
                        <td id="concepto">asd</td>
                        <td id="numClases">asd</td>
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

   
</div>