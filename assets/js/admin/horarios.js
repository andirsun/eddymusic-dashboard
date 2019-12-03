var btnModalClases = $("#btnClases");
var listInstruments = [];
var statusEstudents = {
    1: 'Asistio',
    2: 'Cancelar',
    3: 'No asistio'
};
$(function () {
    $('[id=dateformAddHeadClass]').datetimepicker({
        format: 'YYYY-MM-DD',
        daysOfWeekDisabled: [0]
    });
    $("#datepicker").datetimepicker({
        format: 'MM-DD-YYYY'
    });
    $("#datepicker").keydown(function (event) {
        return false;
    });

    $("#datepicker").val(
        moment(new Date(firstDayWeek + ' ')).format("MM-DD-YYYY") +
        " - " +
        moment(new Date(firstDayWeek + ' ')).day(6).format("MM-DD-YYYY")
    );
    //Get the value of Start and End of Week
    var lastWeekSelected = $("#datepicker").val();
    // no se hizo en change porque por solo abrir llama la funcion getSchedule 
    $('#datepicker').on('dp.hide', function (e) {
        var value = new Date($("#datepicker").val());
        value = value == "Invalid Date" ? new Date() : value;
        var firstDate = moment(value).day(0).format("MM-DD-YYYY");
        var lastDate = moment(value).day(6).format("MM-DD-YYYY");
        var dataDate = firstDate + " - " + lastDate;
        $("#datepicker").val(dataDate);
        var data = pipeDateFormatSend(new Date(new Date(firstDate).setHours(24)));
        if (firstDate != lastWeekSelected) {
            lastWeekSelected = firstDate;
            getSchedule(data.split(' ')[0]);
        }
    });

    blockAllClases();
    changeDateClassByStudent();
    closeFormChangeDateClassByStudent();
    changeClassPrivate();
    deleteClassHead();
    formAddHeadClass();
    getClassInstruments();
    getSchedule();
    getClassInstruments();
    getListStudentClassByInstrument();
    noNegative();
    openListClassAndLoadHandleClassInstruments();
    nextOrPrevWeek();
    sendTeacher();
    selectStatusStudent();

});

function changeClassPrivate() {
    // console.log('changeprivate class');
    $("#accordionList").on('change', 'input[private]', function (evt) {
        var blocked = $(this).prop('checked') ? 1 : 0;
        var input = this;
        var label = $(this).next('label');
        var labelContent = $(label).html();
        var idClassHead = $(this).closest('[data-head]').data('head');
        var data = {
            idClassHead,
            val: blocked
        };
        $.ajax({
            url: base_url + 'admin_ajax/toggleBlockedClass',
            type: 'GET',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                var loader = 'Bloqueando <i class="fa fa-spin fa-spinner"></i>';
                $(input).prop('disabled', true);
                $(label).html(loader);
                $(label).css('cursor', 'no-drop');
            },
            success: function (r) {
                // console.log(r);
                if (r.response == 2) {
                    $(label).toggleClass('active');
                } else if (r.response == 1) {
                    $(label).next("#msg-alert-blocked").slideDown('fade', function () {
                        setTimeout(function () {
                            $(label).next("#msg-alert-blocked").slideUp('fast');
                        }, 2000);
                    });
                }
            },
            error: function (xhr, status, msg) {
                console.log(xhr.responseText);
                $(label).next("#msg-alert-blocked").slideDown('fade', function () {
                    setTimeout(function () {
                        $(label).next("#msg-alert-blocked").slideUp('fast');
                    }, 2000);
                });
            },
            complete: function () {
                $(label).html(labelContent);
                $(input).prop('disabled', false);
                $(label).css('cursor', 'pointer');
            }
        });
    });
}

function blockAllClases() {
    $("body").on('click', '#armor-plating', function (event) {
        //esta funcion lo que hace es que cuando le doy en el boton grande del modal de bloquear clases le da un click al boton que bloquea cada clase y eso lo hace con todas
        //las que esten a esa hora
        var modalBody = $(this).parents(".modal-body");
        var sons = $(modalBody).find(".armor-input").trigger("click");
        //console.log(sons);
    });

}

function changeDateClassByStudent() {
    $("#clases").on('submit', 'form#reasigndateform', function (event) {
        event.preventDefault();
        var tr = $(this).closest('tr');
        var form = this;

        var dateStart = $(form).find("#date-reasign").val();
        var idClassHead = $(form).closest('[data-head]').data('head');
        var idUser = $(tr).data('student');
        var idInstrument = $(tr).data('instrument');
        // var time = $(tr).data('time');
        var time = $(form).find("select[name='time']").val();
        var nHours = $(tr).data('hours');
        var nDay = new Date(dateStart + ' ').getDay();

        var text = '';
        var classCss = '';

        var data = {
            idClassHead,
            dateStart,
            idUser,
            idInstrument,
            time,
            nDay,
            nHours,
            type: 2
        };
        console.log("datos para enviar", data)
        $.ajax({
            url: base_url + 'admin_ajax/reasignClassUser',
            type: 'GET',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                var loader = '<i class="fa fa-spin fa-spinner"></i> Asignando...';
                $(form).find("button[type=submit]").attr('disabled', true);
                $(form).find("button[type=submit]").html(loader);
            },
            success: function (r) {
                console.log(r);
                if (r.response == 2) {
                    text = 'Guardado correctamente';
                    classCss = 'alert-success';
                } else if (r.response == 1) {
                    classCss = 'alert-danger';
                    switch (r.content) {
                        case 'exceededHours':
                            text = 'La cantidad de horas no es suficiente';
                            break;
                        case 'classRegistered':
                            text = 'La clase ya fue registrada con anterioridad';
                            break;
                        case 'alumnsExceded':
                            text = 'Los cupos de esta clase Estan llenos, Por favor escoge otra hora';
                            break
                        case 'classPrivate':
                            text = 'La Clase es privada y esta bloqueada por el administrador';
                            break
                        case 'classNotExist':
                            text = 'La clase no existe, primero intenta crearla y luego asignala.';
                            break
                        default:
                            text = 'No se puede registrar esta clase';
                            break;
                    }
                }
            },
            error: function (xhr, status, msg) {
                classCss = 'alert-danger';
                text = 'Ups ocurrio un error';
                console.log(xhr.responseText);
            },
            complete: function () {
                $(form).find("button[type=submit]").attr('disabled', false);
                $(form).find("button[type=submit]").text('Asignar');

                $(form).find("#msg-new-date").addClass(classCss);
                $(form).find("#msg-new-date #text-msg").text(text);

                $(form).find("#msg-new-date").slideDown('fast', function () {
                    setTimeout(function () {
                        $(form).find("#msg-new-date").slideUp('fast', function () {
                            $(form).find("#msg-new-date").removeClass(classCss);
                        });
                    }, 1800);
                });
            }
        });
    });
}

function closeFormChangeDateClassByStudent() {
    $("#clases").on("click", "#btn-close-form-asign-date", function (evt) {
        var btn = this;
        var form = $(btn).closest('form');
        $(form).slideUp('fast');
    });
}

function formAddHeadClass() {
    $("body").on('submit', 'form#formAddHeadClass', function (evt) {
        evt.preventDefault();
        var form = this;
        var idInstrument = $(form).find("#list-instrument-select").val();
        var dateVal = $(form).find("#dateformAddHeadClass").val();
        // console.log(dateVal);
        var hourInit = 1;
        // var nHours = $(form).find("#cantHours").val();
        var nHours = 1;
        var blocked = $(form).find("#armor-plating").prop('checked') ? 1 : 0;
        var time = $(form).find("#HorasformAddHeadClass").attr('time') + ':00:00';

        var data = {
            idInstrument,
            date: dateVal,
            nHours,
            blocked,
            dayWeek: new Date(dateVal + ' ').getDay(),
            time: time
        };
        console.log(data);
        $.ajax({
            url: base_url + 'admin_ajax/addHeadClass',
            type: 'GET',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                var loader = '<i class="fa fa-spin fa-spinner"></i>';
                $(form).find('button[type=submit]').html(loader);
                $(form).find('button[type=submit]').prop('disabled', true);
            },
            success: function (r) {
                // console.log('cabeceras de la clase');
                // console.log(r);
                if (r.response == 2) {
                    $(form).find("#msgHeadClass #text-msg").text('Clase asignada correctamente');
                    $(form).find("#msgHeadClass").addClass('alert-success');
                    $(form).find("#msgHeadClass").slideDown('fast', function () {
                        setTimeout(function () {
                            $(form).find("#msgHeadClass").slideUp('fast', function () {
                                $(form).find("#msgHeadClass #text-msg").text('');
                                $(form).find("#msgHeadClass").removeClass('alert-success');
                            });
                        }, 1800);
                    });

                    var classAsign = r.content[0];

                    var instrumentIndex = listInstruments.findIndex(function (instrument) {
                        return instrument.id == classAsign.idInstrument
                    });
                    var name = '';
                    if (instrumentIndex >= 0) {
                        name = listInstruments[instrumentIndex].name;
                    }
                    var cardClone = $("#cardClone").clone();
                    var idCollapse = $(cardClone).find("#btnHeadClass").data('target');
                    $(cardClone).removeAttr('id');
                    $(cardClone).attr('data-head', classAsign.id);
                    $(cardClone).find(idCollapse).attr('id', 'collapse-' + classAsign.id);
                    $(cardClone).find("#btnHeadClass").attr('data-target', '#collapse-' + classAsign.id);
                    // revisar
                    $(cardClone).find('#btnHeadClass').attr('data-instrument', classAsign.idInstrument);
                    // 
                    $(cardClone).find("#btnHeadClass").text(name);

                    $(cardClone).find("input#armor-plating").attr('private', classAsign.private);
                    $(cardClone).find("input#armor-plating").attr('id', 'armor-plating-head-class-' + classAsign.id);
                    $(cardClone).find("label[for=armor-plating]").attr('for', 'armor-plating-head-class-' + classAsign.id);
                    //$(cardClone).find("label[for=clase-borrada]").attr('for', 'armor-plating-head-class-'+classAsign.id);
                    //$(cardClone).find("input#borrarClase").attr('value',"hola");
                    $("#accordionList").append($(cardClone).prop('outerHTML'));

                } else if (r.response == 1) {
                    var contentMsg = $(form).find('#msgHeadClass');
                    $(contentMsg).addClass('alert-danger');
                    switch (r.content) {
                        case "relationExisted":
                            $(contentMsg).find("#text-msg").text('Este instrumento ya fue asignado anteriormente con este horario');
                            break;
                        case "dataError":
                            $(contentMsg).find("#text-msg").text('Error al enviar, los datos enviados no son correctos');
                            break;
                    }
                    $(contentMsg).slideDown('fast', function () {
                        setTimeout(function () {
                            $(contentMsg).slideUp('fast', function () {
                                $(contentMsg).find("#text-msg").text('');
                                $(contentMsg).removeClass('alert-danger');
                            });
                        }, 1800);
                    });
                }
            },
            error: function (xhr, status, msg) {
                console.log(xhr.responseText);
            },
            complete: function () {
                $(form).find('button[type=submit]').prop('disabled', false);
                $(form).find('button[type=submit]').html('Crear');
            }
        });
    });
}

function getTeachers(func) {
    $.ajax({
        url: base_url + 'admin_ajax/getUserLevel',
        type: 'GET',
        dataType: 'json',
        async: false,
        data: {
            level: 2
        },
        success: function (r) {
            console.log('listprofesors');
            console.log(r);
            func(true, r);
        },
        error: function (xhr, status, msg) {
            func(false);
        }
    });
}

function getListStudentClassByInstrument() {
    $("#accordionList").on('click', 'button#btnHeadClass', function (evt) {
        var dataTargetId = $(this).data('target');
        var idInstrument = $(this).data('instrument');
        var idClassHead = $(this).closest('[data-head]').data('head');
        var contentList = $(dataTargetId);
        var date = $(this).data('dateclass');
        var time = $(this).data('datehour') + ':00:00';
        if (!$(contentList).hasClass('show')) {
            var data = {
                idClassHead,
                date,
                time,
            };
            console.log(data);
            $.ajax({
                url: base_url + 'admin_ajax/getListStudentClass',
                type: 'GET',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                    var loader = $("#trStudentCloneLoader").clone().detach();
                    $(contentList).find("#tbody-list-students").html($(loader).prop('outerHTML'));
                },
                success: function (r) {
                    console.log('clase de estudiantes');
                    console.log(r);
                    if (r.response == 2) {
                        var str = '';
                        if (r.content.length) {
                            var strOptionsTeachers = '<option value="">-- Seleccionar profesor --</option>';
                            getTeachers(function (success, response) {
                                if (success) {
                                    if (response.response == 2) {
                                        $.each(response.content, function (index, teacher) {
                                            var opt = new Option(teacher.name, teacher.id);
                                            strOptionsTeachers += $(opt).prop('outerHTML');
                                        });
                                    }
                                }
                            });
                            $.each(r.content, function (index, student) {
                                var trItemClone = $("#trStudentClone").clone();
                                var dataStudentToGetHoursResidual = {
                                    idUser: student.idStudent,
                                    idInstrument
                                };
                                console.log(dataStudentToGetHoursResidual);
                                getHourResidualByStudent(dataStudentToGetHoursResidual, function (err, _hours) {
                                    if (!err) {
                                        $(trItemClone).find("#hour-class").text(_hours);
                                    } else {
                                        console.log(err);
                                        $(trItemClone).find("#hour-class").text('--');
                                    }
                                });
                                $(trItemClone).removeAttr('id');
                                $(trItemClone).attr('data-instrument', idInstrument);
                                $(trItemClone).attr('data-class', student.idClass);
                                $(trItemClone).attr('data-student', student.idStudent);
                                $(trItemClone).attr('data-datestart', student.dateStart);
                                $(trItemClone).attr('data-time', student.time);
                                $(trItemClone).attr('data-hours', student.hours);
                                $(trItemClone).find("#name-student").text(student.nameStudent);

                                $(trItemClone).find("form#selectTeacher #idStudent").attr('value', student.idStudent);
                                $(trItemClone).find("form#selectTeacher #idClassHead").attr('value', idClassHead);

                                $(trItemClone).find("#list-professors").html(strOptionsTeachers);
                                $(trItemClone).find("#list-professors").find('option[value="' + student.idTeacher + '"]').attr('selected', true);
                                if (student.asistenciaClase != null) {
                                    var opt = $(trItemClone).find("#select-status-student").find('option[value=' + student.asistenciaClase + ']').attr('selected', true);
                                    var newOption = new Option(statusEstudents[student.asistenciaClase], student.asistenciaClase, true, true);
                                    //$(trItemClone).find("#select-status-student option[value="+student.asistenciaClase+"]").replaceWith($(newOption).prop('outerHTML'));
                                    if (student.asistenciaClase == 3 || student.asistenciaClase == 2 || student.asistenciaClase == 1) {
                                        $(trItemClone).find("#select-status-student").prop('disabled', false);
                                    }
                                    var datetimer = new Date(student.dateStart).getTime();
                                    var datenow = new Date().getTime();
                                    if (student.asistenciaClase == 2 && datenow < (datetimer - 21600000) || datenow > (datetimer + 21600000)) {
                                        $(trItemClone).find("#select-status-student").prop('disabled', false);
                                    }
                                }
                                str += $(trItemClone).prop('outerHTML');
                            });
                        } else {
                            var noContent = $("#trStudentCloneLoader").clone();
                            $(noContent).removeAttr('id');
                            $(noContent).html('<td colspan="5" class="text-center"><h2 class="m-0">No hay estudiantes en esta clase</h2></td>');
                            str = $(noContent).prop('outerHTML');
                        }
                        $(contentList).find("#tbody-list-students").html(str);
                    } else if (r.response == 1) {
                        var txt = '';
                        if (r.content == "dataError") {
                            txt = 'Datos incorrectos';
                        } else {
                            txt = 'Ocurrio un error';
                        }
                        $(contentList).find("#msg-card #msg-card").slideDown('fast', function () {
                            setTimeout(function () {
                                $(contentList).find("#msg-card #msg-card").slideUp('fast');
                            }, 1800);
                        });
                    }
                },
                error: function (xhr, status, msg) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
}

function getSchedule(firtsDay = '') {
    var monday;
    if (firtsDay != '') {
        monday = firtsDay;
    } else {
        monday = firstDayWeek;
    };
    var data = {
        dateStart: monday
    };
    $.ajax({
        url: base_url + 'admin_ajax/getClassWeek',
        type: 'GET',
        dataType: 'json',
        data: data,
        beforeSend: function () {
            $("button[btn-week]").prop('disabled', true);
            $("#loader-schedule").fadeIn('fast');
        },
        success: function (r) {
            console.log('clases de la semana');
            console.log(r);
            if (r.response == 2) {
                var week = r.content;
                var days = Object.keys(week);
                var str = '';
                var count = 0;
                $("#prevWeek").attr('date', days[0]);
                $("#nextWeek").attr('date', days[days.length - 1]);
                $("#prevWeekDay").text(pipeDate(days[0] + ' 00:00:00'));
                $("#nextWeekDay").text(pipeDate(days[days.length - 2] + ' 00:00:00'));
                $("#datepicker").val(days[0] + ' - ' + days[days.length - 1]);
                var str = '';
                var headWeek = $("#days-of-week").clone();
                for (var d of days) {
                    var _date_ = new Date(d + ' ');
                    $(headWeek).find('th[data-position=' + _date_.getDay() + '] #date_number').text(_date_.getDate());
                }
                $("#days-of-week").replaceWith($(headWeek).prop('outerHTML'));
                for (var i = 8; i < 20; i++) {
                    var trHour = $("#trHourClone").clone();
                    $(trHour).removeAttr('id');
                    $(trHour).attr('data-hour', i);
                    var h;
                    if (i > 12 && i != 12) {
                        h = i - 12 + ' pm';
                    } else if (i < 12) {
                        h = i + ' am';
                    } else {
                        h = i + ' pm';
                    }
                    $(trHour).find("td#hora").text(h);
                    $.each(days, function (index, _date) {
                        var btnAsign = $("#btnAsignClone").clone();
                        $(btnAsign).attr('id', 'btnAsign');
                        $(btnAsign).text('--');
                        var tdDay = $(trHour).find('td[data-day=' + (index + 1) + ']');
                        $(tdDay).attr('data-date', _date);
                        $(tdDay).html($(btnAsign).prop('outerHTML'));
                    });
                    str += $(trHour).prop('outerHTML');
                }
                $("#tbody-schedule").html(str);
                $.each(days, function (index, day) {
                    if (week[day].regular.length || week[day].single.length) {
                        $.each(week[day].regular, function (index, regularClass) {
                            addDays(regularClass);
                        });
                        $.each(week[day].single, function (index, singleClass) {
                            addDays(singleClass);
                        });
                    }

                    function addDays(_class) {
                        var time = Number(_class.time.split(":")[0]);
                        var tdDay = $("#tbody-schedule tr[data-hour=" + time + "] td[data-date=" + day + "]");
                        var btnAsign = $(tdDay).find('#btnAsign');
                        $(btnAsign).text('Clase');
                        $(btnAsign).addClass('btn-primary');
                    }
                });
            } else if (r.response == 1) {
                // error
                $("#alert-msg-datepicker-calendar").slideDown('fast', function () {
                    setTimeout(function () {
                        $("#alert-msg-datepicker-calendar").slideUp('fast');
                    }, 1800);
                });
            }
            $("#loader-schedule").fadeOut('fast');
        },
        error: function (xhr, status, msg) {
            console.log(xhr.responseText);
            $("#loader-schedule").fadeIn('fast');
        },
        complete: function () {
            $("button[btn-week]").prop('disabled', false);
        }
    });
}

function getClassInstruments() {
    $.ajax({
        url: base_url + 'admin_ajax/getInstruments',
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function (r) {
            if (r.response == 2) {
                listInstruments = r.content;
                var str = '<option value="">Instrumentos</option>';
                $.each(listInstruments, function (index, instrument) {
                    var opt = new Option(instrument.name, instrument.id);
                    str += $(opt).prop('outerHTML');
                });
                $("#list-instrument-select").html(str);
            }
        },
        error: function (xhr, status, msg) {
            console.log(xhr.responseText);
        }
    })
}

function getHourResidualByStudent(data, cb) {
    $.ajax({
        url: base_url + 'admin_ajax/getHoursResidual',
        type: 'GET',
        dataType: 'json',
        data: data,
        async: false,
        success: function (r) {
            console.log(r);
            if (r.response == 2) {
                cb(false, r.content);
            } else {
                cb(true, r.content);
            }
        },
        error: function (xhr, status, msg) {
            cb(true, xhr.responseText);
        }
    });
}

function noNegative() {
    $('body').on('change', 'input[type=number]', function (evt) {
        var input = this;
        var val = Number($(input).val());
        if (isNaN(val) || val < 0) {
            $(input).val('');
        }
    });
}

function nextOrPrevWeek() {
    $("#control-week").on('click', 'button[btn-week]', function (evt) {
        var btn = this;
        var typeControl = $(btn).attr('btn-week');
        var date = pipeDateFormatSend($(btn).attr('date'));
        // console.log(date);
        var dataDate;
        if (typeControl == "prev") {
            var d = new Date(date);
            dataDate = new Date(d.setDate(d.getDate() - 7));
        } else {
            dataDate = new Date(new Date(date).setHours(24));
        }
        var data = pipeDateFormatSend(dataDate);
        // console.log(data.split(' ')[0]);
        getSchedule(data.split(' ')[0]);
    });
}

function deleteClassHead() {
    $("#accordionList").on('click', '#botonBorrarClase', function (event) {
        event.preventDefault();
        var btn = this;
        var idseleccion = $(btn).attr('value');
        console.log("el id de la clase a borrar es ", idseleccion);
        if (confirm('Deseas Realmente Eliminar la clase ?')) {
            $.ajax({
                url: base_url + 'admin_ajax/deleteClassHead',
                type: 'GET',
                dataType: 'json',
                data: {
                    id: idseleccion
                },
                beforeSend: function () {},
                success: function (r) {
                    if (r.response == 2) {
                        alert("Clase Eliminada, Cierra y vuelve a abrir la hora");
                    }


                },
                error: function (xhr, status, msg) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
}


function openListClassAndLoadHandleClassInstruments() {
    $("#tbody-schedule").on('click', 'button#btnAsign', function (event) {
        var fechaBoton = $(this).closest('td').attr("data-date");

        var btn = this;
        var hasClassBtnPrimary = $(btn).hasClass('btn-primary');
        //console.log('has class btn-primary', hasClassBtnPrimary);
        var hour = $(btn).closest('tr').data('hour');
        var date = $(btn).closest('td').data('date');
        var nDay = $(btn).closest('td').data('day');
        // console.log(date);
        var meridian = hour >= 12 ? 'PM' : 'AM';
        var dataHour = (hour > 12 ? (hour - 12) : hour) + ':00 ' + meridian;

        if (hour >= 13) {
            dataHour = (hour - 12) + ':00 ' + meridian;
        } else {
            dataHour = hour + ':00 ' + meridian;
        }
        $("#HorasformAddHeadClass").attr('time', hour);
        $("#HorasformAddHeadClass").text(dataHour);

        var dataSend = pipeDateFormatSend(date, hour + ':00:00').split(" ");
        var data = {
            time: dataSend[1],
            nDay
        };
        console.log(data);
        $.ajax({
            url: base_url + 'admin_ajax/getHeadClassInstrumentHour',
            type: 'GET',
            dataType: 'json',
            data: data,
            success: function (r) {
                console.log('headClasses');
                console.log(r);
                if (r.response == 2) {
                    var str = '';
                    var daysDisabled = [0, 1, 2, 3, 4, 5, 6].filter(function (_day) {
                        return _day != nDay;
                    });
                    console.log("voy a ponerle la fecha", fechaBoton);
                    $('[id=dateformAddHeadClass]').val(fechaBoton);
                    /*
                    $('[id=dateformAddHeadClass]').data('DateTimePicker').destroy();
                    $('[id=dateformAddHeadClass]').datetimepicker({
                    	format: 'YYYY-MM-DD',
                    	daysOfWeekDisabled: daysDisabled,
                    	minDate: new Date(date),
                    	defaultDate: new Date(date)
                    });
                    */
                    if (hasClassBtnPrimary) {
                        $.each(r.content, function (index, classInstrument) {
                            // console.log(classInstrument.idInstrument);
                            var instrumentIndex = listInstruments.findIndex(function (instrument) {
                                return instrument.id == classInstrument.idInstrument
                            });
                            if (instrumentIndex >= 0) {
                                var instrument = listInstruments[instrumentIndex];
                                var cardClone = $("#cardClone").clone();
                                var idCollapse = $(cardClone).find("#btnHeadClass").data('target');
                                $(cardClone).find("#btnHeadClass").attr('data-dateclass', date);
                                $(cardClone).find("#btnHeadClass").attr('data-datehour', hour);
                                $(cardClone).removeAttr('id');
                                $(cardClone).attr('data-head', classInstrument.id);
                                $(cardClone).find("#tbody-list-students").attr('data-nday', nDay);
                                $(cardClone).find("#tbody-list-students").attr('data-startdateclass', date);
                                $(cardClone).find("#tbody-list-students").attr('data-startdatehour', hour);
                                $(cardClone).find(idCollapse).attr('id', 'collapse-' + classInstrument.id);
                                $(cardClone).find("#btnHeadClass").attr('data-target', '#collapse-' + classInstrument.id);
                                $(cardClone).find('#btnHeadClass').attr('data-instrument', classInstrument.idInstrument);
                                $(cardClone).find("#btnHeadClass").text(instrument.name);
                                $(cardClone).find("input#armor-plating").attr('private', classInstrument.private);
                                $(cardClone).find("#botonBorrarClase").attr('value', classInstrument.id); ////////asi pongo en el boron de borrar clase el id de la classhead
                                $(cardClone).find("input#armor-plating").attr('id', 'armor-plating-head-class-' + classInstrument.id);
                                $(cardClone).find("label[for=armor-plating]").addClass(classInstrument.private == 1 ? 'active' : '');
                                $(cardClone).find("label[for=armor-plating]").attr('for', 'armor-plating-head-class-' + classInstrument.id);
                                str += $(cardClone).prop('outerHTML');
                            }
                        });
                    }
                    $("#accordionList").html(str);
                    var classPrivates = $("#accordionList").find('input[private=1]');
                    $(classPrivates).prop('checked', true);
                }
            }
        });
        $("#btnClases").trigger('click');
    });
}

function pipeDateFormatSend(date, hour = '') {
    var d = new Date(date + ' ' + hour);
    if (d != 'Invalid Date') {
        var date = d.getFullYear().toString() + "-" +
            ((d.getMonth() + 1).toString().length == 2 ? (d.getMonth() + 1).toString() : "0" +
                (d.getMonth() + 1).toString()) + "-" + (d.getDate().toString().length == 2 ? d.getDate().toString() : "0" +
                d.getDate().toString()) + " " + (d.getHours().toString().length == 2 ? d.getHours().toString() : "0" +
                d.getHours().toString()) + ":" + ((parseInt(d.getMinutes() / 5) * 5).toString().length == 2 ? (parseInt(d.getMinutes() / 5) * 5).toString() : "0" +
                (parseInt(d.getMinutes() / 5) * 5).toString()) + ":00";
        return date;
    } else {
        return '--';
    }
}

function pipeDate(date, widthHour = false) {
    var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

    var dataDate = new Date(date);
    var data;

    if (dataDate != 'Invalid Date') {
        data = days[dataDate.getDay()] + ' ' + dataDate.getDate() + ' de ' + months[dataDate.getMonth()] + ' del ' + dataDate.getFullYear();
        if (widthHour) {
            var meridian = dataDate.getHours() > 12 ? 'pm' : 'am';
            var h = dataDate.getHours() > 12 ? dataDate.getHours() - 12 : dataDate.getHours();
            var txt = '';
            if (h > 1) {
                txt = ' a las ';
            } else {
                txt = ' a la ';
            }
            data += txt + h + ' ' + meridian;
        }
    } else {
        data = '--';
    }
    return data;
}

function removeDuplicates(myArr, prop) {
    return myArr.filter((obj, pos, arr) => {
        return arr.map(mapObj => mapObj[prop]).indexOf(obj[prop]) === pos;
    });
}

function sendTeacher() {
    $("#clases").on('submit', 'form#selectTeacher', function (event) {
        event.preventDefault();
        var form = this;
        var d = new Date();
        var currentDate = $('input#dateformAddHeadClass').val();
        // d.getFullYear()+'-'+
        // (d.getMonth()+1 < 10 ? '0'+(d.getMonth()+1) : (d.getMonth()+1))+'-'+
        // (d.getDate() < 10 ? '0'+d.getDate() : d.getDate());

        var data = {
            idStudent: $(form).find("#idStudent").val(),
            idClassHead: $(form).find("#idClassHead").attr('value'),
            idTeacher: $(form).find("#list-professors").val(),
            currentDate,
        };
        var msgClass = '';
        var textMsg = '';
        console.log(data);
        $.ajax({
            url: base_url + 'admin_ajax/addTeacherToClass',
            type: 'GET',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                $(form).find('button[type=submit]').prop('disabled', true);
            },
            success: function (r) {
                console.log(r);
                if (r.response == 2) {
                    if (r.content == "Asignado") {
                        msgClass = 'alert-success';
                        textMsg = 'Se Asigno Correctamente!';
                    }
                    if (r.content == "Actualizado") {
                        msgClass = 'alert-success';
                        textMsg = 'El Profesor se actualizo correctamente.';
                    }
                } else {
                    msgClass = 'alert-danger';
                    textMsg = r.content;
                }
            },
            error: function (xhr, status, msg) {
                console.log(xhr.responseText);
                msgClass = 'alert-danger';
                textMsg = 'Ocurrio un error';
            },
            complete: function () {
                $(form).find("#msg-alert").addClass(msgClass);
                $(form).find("#msg-alert #text-alert").text(textMsg);
                $(form).find("#msg-alert").slideDown('fast', function () {
                    setTimeout(function () {
                        $(form).find("#msg-alert").slideUp('fast', function () {
                            $(form).find("#msg-alert").removeClass(msgClass);
                        })
                    }, 1800);
                });
                $(form).find('button[type=submit]').prop('disabled', false);
            }
        });
    });
}

function showAndHideMessage(classMsg, txtMsg, tr) {
    var msgContent = $("#trStudentCloneLoader").clone();
    $(msgContent).removeAttr('id');
    $(msgContent).css('display', 'none');
    $(msgContent).find('h2').addClass(classMsg);
    $(msgContent).find('h2').text(txtMsg);
    $(msgContent).insertAfter(tr);
    $(msgContent).fadeIn('fast', function () {
        setTimeout(function () {
            $(msgContent).fadeOut('fast', function () {
                $(msgContent).remove();
            });
        }, 2500);
    });
}

function selectStatusStudent() {
    $('body').on('submit', 'form#formSendStateStudent', function (evt) {
        evt.preventDefault();
        var form = this;
        var tr = $(this).closest('tr');
        var idStudent = $(tr).data('student');
        var tbody = $(this).closest('tbody');
        var idClassHead = $(this).closest('[card]').data('head');
        var val = $(form).find('#select-status-student').val();
        var date_in_week = $(tbody).data('startdateclass');
        var dateStart = new Date(date_in_week + ' ' + $(tr).data('time'));
        // console.log($(tbody).data('startdateclass')+' '+$(tr).data('time'));
        var select = $(form).find("#select-status-student");
        var dateNow = new Date().getTime();
        var data = {
            val,
            idClassHead,
            currentDate: date_in_week,
            idStudent
        };
        // console.log(data);
        var classMsg = '';
        var txtMsg = '';

        var hourBefore = new Date(dateStart.setHours(dateStart.getHours() - 6)).getTime();
        if (level != 0 && level != 4) {
            if (!val) {
                return false;
            }
            if (val == 3 && (dateNow > hourBefore)) {
                classMsg = 'alert-warning';
                txtMsg = 'No se puede cancelar debido se ha expirado el tiempo para cancelar!';
                showAndHideMessage(classMsg, txtMsg, tr);
                return false;
            }
        }
        console.log(data);
        $.ajax({
            url: base_url + 'admin_ajax/statusClass',
            type: 'GET',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                $(select).prop('disabled', true);
                $(select).next("#msg-status").fadeIn('fast');
            },
            success: function (r) {
                console.log(r);
                if (r.response == 2) {
                    currentHours
                    var currentHours = $(select).closest('tr').find('td#hour-class').text();
                    console.log(currentHours);
                    if (val != "3") {
                        $(select).closest('tr').find('td#hour-class').text(currentHours - 1);
                    }
                    classMsg = 'alert-success';
                    txtMsg = 'Guardado correctamente';
                    if (val == 3) {
                        $(tr).find("form#reasigndateform #date-reasign").datetimepicker({
                            format: 'YYYY-MM-DD',
                            minDate: moment(),
                        });
                        $(tr).find("form#reasigndateform").slideDown('fast');
                    }
                } else if (r.response == 1) {
                    classMsg = 'alert-danger';
                    $(select).val("");
                    switch (r.content.trim()) {
                        case "classNotFound":
                            txtMsg = 'Ups! clase no encontrada';
                            break;
                        case "classWasSetted":
                            txtMsg = 'Esta accion ya fue realizada con anterioridad';
                            break;
                        case "laClaseYaFueActuliazada":
                            txtMsg = 'Esta accion ya fue realizada con anterioridad';
                            break;
                        case "Accion Bloqueada Por que no tienes Horas Disponibles":
                            txtMsg = 'Accion Bloqueada No tienes Horas Disponibles';
                            break;
                        default:
                            txtMsg = 'Ocurrio un error al realizar esta accion';
                            break;
                    }

                }
            },
            error: function (xhr, status, msg) {
                console.log(xhr.responseText);
                classMsg = 'alert-danger';
                txtMsg = 'Ups! ocurrio un error';
            },
            complete: function () {
                $(select).prop('disabled', false);
                $(select).next("#msg-status").fadeOut('fast');
                showAndHideMessage(classMsg, txtMsg, tr);
            }
        });
    });
}