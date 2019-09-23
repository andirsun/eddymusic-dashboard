var dataTableOptions = {
  'language': {
    'search': 'Buscar:',
    'zeroRecords': 'No se encontraron coincidencias',
    'info': 'Total categorias: _TOTAL_ ',
    'lengthMenu': "Mostrar _MENU_ entradas",
    'paginate': {
      'previous': '<',
      'next': '>'
    }
  },
};
var options = {
  "columns": [
    { "width": "10%" },
    { "width": "10%" },
    { "width": "10%" },
    { "width": "10%" },
    { "width": "60%" },
  ]
} 
$(function () {
  $("#tablaBitacoras").DataTable(dataTableOptions);
  console.log("AnderDev");
  loadTabs();
  cargarTablasBitacoras();

});

function loadTabs() {
  $.ajax({
    url: base_url + 'admin_ajax/getInstrumentosSucursal',
    type: 'GET',
    async: false,
    beforeSend: function () {},
    success: function (r) {
      var res = JSON.parse(r);
      console.log(res);
      if (res.response == 2) {
        var strTabs = '';
        var strContentTabs = '';
        $.each(res.content, function (index, instrument) {
          var itemInstrument = $("#item-instrument").clone();
          //var contentCloneTab = $("#tab-content-clone").clone();

          // tab instrument
          $(itemInstrument).removeAttr('id');
          $(itemInstrument).find('a').attr('data-id', instrument.id);
          $(itemInstrument).find('a').attr('id', 'tab');
          $(itemInstrument).find('a').attr('isLoaded', 'false');
          $(itemInstrument).find('a').attr('href', '#instrument-' + instrument.id);
          $(itemInstrument).find('a').text(instrument.name);
          // para el contenido de cada tab
          //$(contentCloneTab).removeAttr('id');

          //$(contentCloneTab).attr('data-id', instrument.id);
          //$(contentCloneTab).removeAttr('id');
          // $(contentCloneTab).attr('id','instrument-'+instrument.id);//esto se debe colocar igual que el id del tab para que abra el tabpane o si no no abre ese tab con ese id 
          //$(contentCloneTab).text(instrument.id);



          ///Esto Es para agregarselo a cada item en esos tabs
          // strContentTabs += $(contentCloneTab).prop('outerHTML'); // lo que va a llenar en cada iteracion del contenido de los
          strTabs += $(itemInstrument).prop('outerHTML');
        });

        // $("#tabContentInstruments").html(strContentTabs);
        $("#list-instruments").html(strTabs);
      }
    },
    error: function (xhr, status, msg) {
      console.log(xhr.responseText);
    }
  });
}

function cargarTablasBitacoras() {
  $("#list-instruments").find('a').on("click", function (event) {
    var id = $(this).attr('data-id');
    //console.log(id);
    $.ajax({
      url: base_url + 'admin_ajax/getBitacoras',
      type: 'GET',
      dataType: 'json',
      data: {
        id: id
      },
      beforeSend: function () {
        $("#tablaBitacoras").dataTable().fnDestroy();
      },
      success: function (r) {
        //console.log(r);
        if (r.response == 2) {
          console.log('list clases \n', r.content);
          var tableBody = $('#tablaBitacoras').find("tbody");
          var str = construirTablaBitacoras(r.content);
          $(tableBody).html(str);
          table = $("#tablaBitacoras").DataTable(options);
          //console.log(table);
        } else {
          table = $("#tablaBitacoras").DataTable();
          alert("Aun No hay bitacoras para mostrar de este instrumento, Revisa mas tarde");
        }


      },
      error: function (xhr, status, msg) {
        console.log(xhr.responseText);
      }
    });


  });


  //$("#instrument-1").html("<h1>Prueba</h1>");

}

function construirTablaBitacoras(listUser) {
  var str = '';
  $.each(listUser, function (index, el) {
    var tr = $(cuerpoTabla).clone();
    $(tr).find('#fecha').text(el.fecha);
    $(tr).find('#estudiante').text(el.estudiante);
    $(tr).find('#bitacora').text(el.bitacora);
    $(tr).find('#instrumento').text(el.instrumento);
    $(tr).find('#profesor').text(el.profesor);
    str += $(tr).prop('outerHTML');
  });
  return str;
}