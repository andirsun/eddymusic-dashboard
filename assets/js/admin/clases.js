(function(){
	var listTeachers = [];
	var statusUser = ['--', 'Asistido', 'No asistido', 'Cancelado'];
	$(function(){
		setNombreStudent();
		getTeachers();
		getInstrumentByStudent();
		getInstrumentsClases();
		addInstrumentByStudent();
		addHourClass();
		getInstrumentPackageStudentById();
		openModalListClasesAvailable();
		formAgendClass();
		getHistoryByStrumentAndStundent();
		removeHistoryClassStudent();
		selectBono();
		//selectTypeOption();
		changeDateSelectedClass();
		activeHistoryTab();
		changeDateFormInputHistroy();
		removeClassStudent();
		keydownPrice();
		calcularPrecio();
		descuentoEspecial();
		// $("#price-view").text($.number(0, 2, ',', ' '));
	});
	function descuentoEspecial(){
		var descuento = $("#form1").find('select#discount').val();
		console.log("aqui estoy");
	}
	function calcularPrecio(){
		

		$("#tabContentInstruments").on('click', '#calcularPrecio', function(evt) {
			evt.preventDefault();
			//evt.stopImmediatePropagation();
			var padre = $(this).closest(".tab-pane.fade.show.active"); //asi se selecciona el padre en un tab para agarrar la informacion de un div en especifico de un tab
			var clase=$(padre).attr('id').split("-"); //para sacar el id del padre separando el id que es largo con un split
			var idInstrument=clase[2];//asi asco el id
			var data = {
				idUser: idUserStudent,
				idInstrument,
				nHours:$(padre).find('input[name=hours]').val(),
				tipoDescuento: $(padre).find('select#discount').val(),
			};
			console.log(data);
			$.ajax({
				url: base_url+'admin_ajax/precioHoraClase',
				type: 'GET',
				dataType: 'json',
				data:data,
				beforeSend:function() {
					
				},
				success:function(r) {
					var valor = r.content;
					var descuento = $(padre).find('select#discount').val();
					var porcentaje = $(padre).find('input[name=porcentaje]').val();
					var descuento ;
					if(descuento == 2){
						valor = valor/2;
					}
					if(descuento == 3){
						valor = 0;
					}
					
					if(descuento == 1){
						descuento = (porcentaje*valor)/100;
						valor = valor - descuento;
					}
					
					
					$(padre).find("#price").val(valor);
				},
				error:function(xhr, status, msg) {
					console.log(xhr.responseText);
				}
			});			
		});
		
	}
	function setNombreStudent(){
	$.ajax({
			url: base_url+'admin_ajax/nameStudent',
			type: 'GET',
			dataType: 'json',
			data:{id:idUserStudent},
			beforeSend:function() {
				
			},
			success:function(r) {
				console.log("nombre del estudiante",r.content);
				if(r.response == 2) {
					$("#titulo2").append(r.content.name);
					
				}
			},
			error:function(xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	}
	function activeHistoryTab() {
		$(document).on('click', '#histroy-tab', function(event) {
			event.preventDefault();
			/* Act on the event */
			var tagAncle = this;
			var idContentHistory = $(tagAncle).attr('href');
			var isClickBefore = $(tagAncle).attr('is-click');
			console.log(isClickBefore);
			if(isClickBefore == "false") {
				$(tagAncle).attr('is-click', 'true');
				// console.log($(idContentHistory).find('#form-history input[id^=from]'));
				$(idContentHistory).find('#form-history input[id^=from]').datetimepicker({ 
					format:'L', 
					maxDate: new Date() 
				});
				$(idContentHistory).find('#form-history input[id^=to]').datetimepicker({ 
					format:'L', 
					maxDate: new Date() 
				});
			}
		});
	}
	function addInstrumentByStudent() {
		$("#addInstrument").click(function(event) {
			event.stopImmediatePropagation();
			var btn = this;
			var idInstrument = $("#list-instrument-no-selected").val();
			var data = {
				idUser: idUserStudent,
				idInstrument
			};
			// console.log(data);
			$.ajax({
				url: base_url+'admin_ajax/addInstrumentToUser',
				type: 'GET',
				data: data,
				dataType: 'json',
				beforeSend: function() {
					var loader = '<i class="fa fa-spin fa-spinner"></i> Agregando';
					$(btn).prop('disabled', true);
					$(btn).html(loader);
				},
				success: function(r) {
					console.log(r);
					var res = r;
					if(res.response == 2) {
						var idInstrument = res.content.idInstrument;
						var nameInstrument = $("#list-instrument-no-selected option[value="+idInstrument+"]").text();

						var itemInstrument = $("#item-instrument").clone();
						var contentCloneTab = $("#tab-content-clone").clone();

						// instrument
						$(itemInstrument).removeAttr('id');
						$(itemInstrument).find('a').attr('href', '#instrument-'+idInstrument);
						$(itemInstrument).find('a').attr('data-id', idInstrument);
						$(itemInstrument).find('a').attr('isLoaded', 'false');
						$(itemInstrument).find('a').text(nameInstrument);

						// content instrument
						$(contentCloneTab).attr('id', 'instrument-'+idInstrument) 
						var tabInformation = $(contentCloneTab).find("#list #information-tab");
						var tabHistory = $(contentCloneTab).find("#histroy-tab");


						var idContentTabInformation = $(tabInformation).attr('href');
						var idContentTabHistory = $(tabHistory).attr('href');

						$(tabInformation).attr('href', '#infomation-instrument-'+idInstrument);
						$(tabHistory).attr('href', '#histroy-instrument-'+idInstrument);

						$(contentCloneTab).find(idContentTabInformation).attr('id', 'infomation-instrument-'+idInstrument);

						$(contentCloneTab).find("input#bono").attr('id', 'bono-instrument-'+idInstrument);
						$(contentCloneTab).find("label[for=bono]").attr('for', 'bono-instrument-'+idInstrument);

						$(contentCloneTab).find('form[addPackageInstrument]').attr('addPackageInstrument', idInstrument);

						$(contentCloneTab).find('#form-history #idInstrument').attr('value', idInstrument);
						$(contentCloneTab).find('#form-history #idInstrument').attr('value', idUserStudent);
						$(contentCloneTab).find('#form-history input#from').attr('id', 'from-'+idInstrument);
						$(contentCloneTab).find('#form-history input#to').attr('id', 'to-'+idInstrument);

						// console.log($(contentCloneTab).find('#history'), 'history');

						$(contentCloneTab).find(idContentTabHistory).attr('id', 'histroy-instrument-'+idInstrument);
						$(contentCloneTab).find("#btn-see-class-available").attr('id-instrument', idInstrument);

						$("#list-instruments").append($(itemInstrument).prop('outerHTML'));
						$("#tabContentInstruments").append($(contentCloneTab).prop('outerHTML'));

						$("#list-instrument-no-selected").find('option[value='+idInstrument+']').remove();
						// console.log(idInstrument, nameInstrument);
					} else if(r.response == 1) {
						if(r.response == "relationExisted") {
							$("#msg-add-instrument #txt-add-instrument").text('Este instrumento ya se encuentra agregado');
						} else if(r.response == "dataError") {
							$("#msg-add-instrument #txt-add-instrument").text('Error de datos');
						}
						$("#msg-add-instrument").slideDown('fast', function() {
							setTimeout(function() {
								$("#msg-add-instrument").slideUp('fast');
							}, 1800);
						});
					}
				},
				error:function(xhr, status, msg) {
					console.log(xhr.responseText);
					$("#msg-add-instrument #txt-add-instrument").text('Error de datos');
					$("#msg-add-instrument").slideDown('fast', function() {
						setTimeout(function() {
							$("#msg-add-instrument").slideUp('fast');
						}, 1800);
					});
				},
				complete: function() {
					$(btn).prop('disabled', false);
					$(btn).text('Agregar instrumento');
				}
			});
		});
	}
	function addHourClass() {
		// console.log('addd');
		$("#tabContentInstruments").on('submit', 'form[addPackageInstrument]', function(evt) {
			evt.preventDefault();
			evt.stopImmediatePropagation();
			var form = this;
			var idInstrument = $(form).attr('addPackageInstrument');
			var data = {
				idUser: idUserStudent,
				idInstrument,
				nHours: $(form).find('input[name=hours]').val(),
				price: $(form).find('input#price').val()/*.replace(/,./g, '')*/,
				bono: $(form).find('input[name=bono]').prop('checked') ? 1 : 0,
				medioPago: $(form).find('select#medio').val(), 
				tipoDescuento: $(form).find('select#discount').val(),
				nRecibo: $(form).find('input#nRecibo').val(),
				pago: $(form).find('select#pago').val(),
				porcentaje: $(form).find('input[name=porcentaje]').val(),
				conceptoPaquete: $(form).find('input#conceptoPaquete').val()
			};
			console.log(data);
			var classCssAlert = '';
			var msg = $(form).find("#msg-form");
			$.ajax({
				url: base_url+'admin_ajax/addHoursToInstrumentStudent',
				type: 'GET',
				dataType: 'json',
				data: data,
				beforeSend: function() {
					var loader = '<i class="fa fa-spin fa-spinner"></i>';
					$(form).find('button[type=submit]').prop('disabled', true);
					$(form).find('button[type=submit]').html(loader);
				},
				success: function(r) {
					console.log(r);
					if(r.response == 2) {
						classCssAlert = 'alert-success';
						$(msg).addClass(classCssAlert);
						$(msg).text('Horas agregadas existosamente!');

						var content = $(form).closest("[role=tabpanel]");
						var packageHours = r.content;
						var itemClone = $("#item-package-clone").clone();
						$(itemClone).removeAttr('id');
						$(itemClone).find("#hours").text(packageHours.hours);
						$(itemClone).find("#price").text(packageHours.price);
						$(itemClone).find("#date").text(packageHours.date);
						$(itemClone).find("#pago").text(packageHours.pago);
						$(itemClone).find("#concept").text(packageHours.conceptoIngreso);
						$(itemClone).find("#discount").text(packageHours.tipoDescuento);
						$(content).find("#list-package").append($(itemClone).prop('outerHTML'));

					} else if(r.response == 1) {
						if(r.content == "relationExisted") {
							classCssAlert = 'alert-warning';
							$(msg).text('Ya se han añadido horas anteriormente!');
						} else if(r.content == 'dataError') {
							classCssAlert = 'alert-danger';
							$(msg).text('Error de datos!');
						}
						$(msg).addClass(classCssAlert);
					}
				},
				error:function(xhr, status, msg) {
					console.log(xhr.responseText);
					classCssAlert = 'alert-danger';
					$(msg).addClass(classCssAlert);
					$(msg).text('Ocurrio un error');
				},
				complete: function() {
					$(form)[0].reset();
					$(form).find('button[type=submit]').prop('disabled', false);
					$(form).find('button[type=submit]').html('Agregar paquete horas');
					$(msg).slideDown('fast', function() {
						setTimeout(function() {
							$(msg).slideUp('fast', function() {
								$(msg).removeClass(classCssAlert);
								$(msg).text('');
							});
						}, 2000);
					});	
				}
			});
		});
	}
	function changeDateFormInputHistroy() {
		$(document).on('dp.hide', 'input[data-date]', function(event) {
			console.log(event);
			var input = this;
			var form = $(input).closest('form');
			var typeInput = $(input).attr('data-date');
			var val = $(input).val();
			if(val) {
				var _minDate = new Date(val); 			
				console.log($(input).val());
				if(typeInput == 'from') {
					$(form).find('input[id^=to]').data('DateTimePicker').minDate(_minDate);
				}
			}
		});
	}
	function changeDateSelectedClass() {
		// console.log('data change');
		$("#mainModal").on('dp.change', "#date-select-class", function(evt) {
			//console.log(evt);
			var val = $(this).val();
			var content = $(this).closest('#content-date');
			$(content).find("#date-text").text(pipeDate(val+' '));
			// console.log(pipeDate(val+' '));
		});
	}
	function formAgendClass() {
		$('body').on('submit', 'form#formAgendClass', function(evt) {
			evt.preventDefault();
			evt.stopImmediatePropagation();
			var form = this;
			var cardbody = $(this).closest('[card-body]');
			var idInstrument = $(form).find("#idInstrument").attr('value');
			var type = $(cardbody).find('input[type=radio]:checked').val();
			var dateStart = $(form).find("#dateStart").attr('value');
			var classAlert = '';
			var msgContent = $(cardbody).find("#msg-card-class");
			var contentTxt = $(msgContent).find('#text-msg-card-class');
			var dateSelectedWithOptions = $(cardbody).find("#date-select-class").val();
			// console.log($(cardbody).find("#date-select-class").val())
			if(type == 0) {
				dateStart = "0000-00-00"; 
			} else if(!dateSelectedWithOptions) {
				classAlert = 'alert-warning';
				$(contentTxt).html('La fecha es requerida <i class="fas fa-exclamation-triangle"></i>');
				closeMessage();
			} else {
				dateStart = dateSelectedWithOptions;
			}
			var data = {
				idInstrument:idInstrument,
				idUser: idUserStudent,
				idClassHead: $(form).find("#idClassHead").attr('value'),
				nHours: $(form).find("#nHours").attr('value'),
				dateStart,
				nDay: $(form).find("#nDay").attr('value'),
				time: $(form).find("#time_send").attr('value'),
				type,
			};
			console.log(data);
			$.ajax({
				url: base_url+'admin_ajax/addClassUser',
				type: 'GET',
				dataType: 'json',
				data: data,
				beforeSend: function() {
					var loader = '<i class="fas fa-spin fa-spinner"></i>';
					$(form).find('button[type=submit]').prop('disabled', true);
					$(form).find('button[type=submit]').html(loader);
				},
				success: function(r) {
					console.log(r);
					if(r.response == 2) {
						$(msgContent).find('#text-msg-card-class').text('Genial! La Clase Quedo Agendada');
						classAlert = 'alert-success';
						getHoursResidual(idInstrument, idUserStudent, $("#mainModal").find("#remaining-hour"));
						setTimeout(function() {
							var _card = $(cardbody).closest('[card]');
							$(_card).slideUp('fast', function() {
								$(_card).remove();
							});
						}, 2100);
					} else if(r.response == 1) {
						switch(r.content) {
							case "exceededHours":
								classAlert = 'alert-danger';
								$(contentTxt).html(' Ups..! No tienes Horas suficientes para esta clase <i class="fas fa-exclamation-circle"></i>');
								break;
							case "classNotExist":
								classAlert = 'alert-danger';
								$(contentTxt).html('Es Lamentable :(  La clase no existe <i class="fas fa-exclamation-circle"></i>');
								break;
							case "classPrivate":
								classAlert = 'alert-warning';
								$(contentTxt).text('Ups!!! La Clase Esta Bloqueada por la Administracion <i class="fas fa-exclamation-triangle"></i>');
								break;
							case "classRegistered":
								classAlert = 'alert-warning';
								$(contentTxt).html('Ya ten encuentras inscrito en esta clase  <i class="fas fa-exclamation-triangle"></i>');
								break;
							case "alumnsExceded":
								classAlert = 'alert-warning';
								$(contentTxt).html('Cupo de alumnos lleno, intenta otra clase o pide cups extra con un Administrador <i class="fas fa-exclamation-triangle"></i>');
								break;
						}
						$(form).find('button[type=submit]').prop('disabled', false);
					}
				},
				error: function(xhr, status, msg) {
					console.log(xhr.responseText);
					$(form).find('button[type=submit]').prop('disabled', false);
				},
				complete: function() {
					closeMessage();
					$(form).find('button[type=submit]').html('<i class="fas fa-check"></i>');
				}
			});
			function closeMessage() {
				$(msgContent).addClass(classAlert);
				$(msgContent).slideDown('fast', function() {
					setTimeout(function() {
						$(msgContent).slideUp('fast', function() {
							$(msgContent).removeClass(classAlert);
							$(msgContent).find('#text-msg-card-class').text('');
						});
					}, 5000);
				});
			}			
		});
	}
	function getTeachers() {
		$.ajax({
			url: base_url+'admin_ajax/getUserLevel',
			type: 'GET',
			dataType: 'json',
			async: false,
			data: { level:2 },
			success: function(r) {
				if(r.response == 2) {
					listTeachers = r.content;
				} else {
					listTeachers = [];
				}
			},
			error:function(xhr, status, msg) {
				console.log(xhr.responseText);
				listTeachers = [];
			}
		});
	}
	function getInstrumentsClases(){
		$.ajax({
			url: base_url+'admin_ajax/getInstruments',
			type: 'GET',
			dataType: 'json',
			beforeSend: function() {},
			success: function(r) {
				console.log('instruments');
				console.log(r);
				if(r.response == 2) {
					var options = '';
					if(r.content.length) {
						$.each(r.content, function(index, instrument) { 
							var opt = new Option(instrument.name, instrument.id);
							var instrumentSelected = $("#list-instruments").find('a[data-id='+instrument.id+']');
							// console.log(instrumentSelected);
							if(instrumentSelected.length) {
								$(opt).addClass('d-none');
							}
							options += $(opt).prop('outerHTML');
						});
					} else {
					}
					$("#list-instrument-no-selected").html(options);
					$("#list-instrument-no-selected").find('option').not('.d-none').first().attr('selected', true);
					$("#list-instrument-no-selected").trigger('change');
				}
			},
			error: function(xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	}
	function getInstrumentByStudent() {
		try {		
			$.ajax({
				url: base_url+'admin_ajax/getInstrumentsStudent',
				type: 'GET',
				async :false,
				data: { idUser: idUserStudent },
				beforeSend: function() {},
				success: function(r) {
					var res = JSON.parse(r);
					console.log(res);
					if(res.response == 2) {
						var strTabs = '';
						var strContentTabs = '';
						$.each(res.content, function(index, instrument) {
							var itemInstrument = $("#item-instrument").clone();
							var contentCloneTab = $("#tab-content-clone").clone();

							// tab instrument
							$(itemInstrument).removeAttr('id');
							$(itemInstrument).find('a').attr('data-id', instrument.id);
							$(itemInstrument).find('a').attr('isLoaded', 'false');
							$(itemInstrument).find('a').attr('href', '#instrument-'+instrument.id);
							$(itemInstrument).find('a').text(instrument.name);

							// content tab instrument
							$(contentCloneTab).attr('id', 'instrument-'+instrument.id);
							var tabInformation = $(contentCloneTab).find("#list #information-tab");
							var tabHistory = $(contentCloneTab).find("#histroy-tab");

							var idContentTabInformation = $(tabInformation).attr('href');
							var idContentTabHistory = $(tabHistory).attr('href');

							$(tabInformation).attr('href', '#infomation-instrument-'+instrument.id);
							$(tabHistory).attr('href', '#histroy-instrument-'+instrument.id);

							$(contentCloneTab).find(idContentTabInformation).attr('id', 'infomation-instrument-'+instrument.id);
							$(contentCloneTab).find("input#bono").attr('id', 'bono-instrument-'+instrument.id);
							$(contentCloneTab).find("label[for=bono]").attr('for', 'bono-instrument-'+instrument.id);

							$(contentCloneTab).find('form[addPackageInstrument]').attr('addPackageInstrument', instrument.id);

							$(contentCloneTab).find('#form-history #idInstrument').attr('value', instrument.id);
							$(contentCloneTab).find('#form-history #idStudent').attr('value', idUserStudent);
							$(contentCloneTab).find('#form-history input#from').attr('id', 'from-'+instrument.id);
							$(contentCloneTab).find('#form-history input#to').attr('id', 'to-'+instrument.id);

							$(contentCloneTab).find("#btn-see-class-available").attr('id-instrument', instrument.id);
							$(contentCloneTab).find(idContentTabHistory).attr('id', 'histroy-instrument-'+instrument.id);

							strContentTabs += $(contentCloneTab).prop('outerHTML');
							strTabs += $(itemInstrument).prop('outerHTML');
						});

						$("#tabContentInstruments").html(strContentTabs);
						$("#list-instruments").html(strTabs);
					}
				},
				error: function(xhr, status, msg) {
					console.log(xhr.responseText);
				}
			});
		} catch(e) {
			// console.log(e);
		}
	}
	function getInstrumentPackageStudentById() {
		$("#list-instruments").on('shown.bs.tab', 'a[data-toggle="tab"]', function(evt) {
			var idContentInstrument = $(this).attr('href'); 
			var idInstrument = $(this).data('id');
			var data = { 
				idUser: idUserStudent,
				idInstrument
			};
			// console.log(data);
			$.ajax({
				url: base_url+'admin_ajax/getInstrumentPackageStudent',
				type: 'GET',
				dataType: 'json',
				data: data,
				beforeSend: function() {
					var loader = '<i class="fa fa-spin fa-spinner"></i>';
					var itemClone = $("#item-package-clone").clone();
					$(itemClone).removeAttr('id');
					$(itemClone).html(loader);
					$(idContentInstrument).find("#list-package").html($(itemClone).prop('outerHTML'));
				},
				success: function(r) {
					console.log('traer paquete de clase por estudiante');
					console.log(r);
					if(r.response == 2) {
						var str = '';
						if(r.content.length) {
							$.each(r.content, function(index, item) {
								var itemClone = $("#item-package-clone").clone().detach();
								var descuento = "";
								var porcentaje = "";
								if( item.porcentaje != 0){
									porcentaje = item.porcentaje;
								}else{
									porcentaje = "100";
								}
								if (item.tipoDescuento==0){
									descuento = "Regular";
								}
								if (item.tipoDescuento==1){
									descuento = "Descuento Especial";
								}
								if (item.tipoDescuento==2){
									descuento = "Media Beca";
								}
								if (item.tipoDescuento==3){
									descuento = "Beca Completa";
								}
								$(itemClone).removeAttr('id');
								$(itemClone).find("#hours").text(item.hours);
								$(itemClone).find("#price").text($.number(item.price, 0, '', '.'));
								$(itemClone).find("#date").text(item.date); // AQUI IBA EL PIPE DATE 
								$(itemClone).find("#discount").text(descuento);
								$(itemClone).find("#pago").text(item.pago);
								$(itemClone).find("#concept").text(item.conceptoIngreso);
								$(itemClone).find("#porcentaje").text(porcentaje+"%");
								str += $(itemClone).prop('outerHTML');
							});
						} else {
							str = '<li class="list-group-item">No hay paquetes comprados anteriormente</li>';
						}
					} else if(r.response == 1) {
						str = '<li class="list-group-item">Los datos enviado son incorrectos</li>';
					}
					$(idContentInstrument).find("#list-package").html(str);
				},
				error: function(xhr, status, msg) {
					console.log(xhr.responseText);
				}
			});
			$.ajax({
				url: base_url+'admin_ajax/getSoonClassStudentInstrument',
				type: 'GET',
				dataType: 'json',
				data: data,
				beforeSend: function() {
					var loader = '<i class="fa fa-spin fa-spinner"></i>';
					var itemClone = $("#item-package-clone").clone();
					$(itemClone).removeAttr('id');
					$(itemClone).html(loader);
					$(idContentInstrument).find("#next-class").html($(itemClone).prop('outerHTML'));
				},
				success: function(r) {
					console.log('clases futuras por instrumento');
					console.log(r);
					if(r.response == 2) {
						var str = '';
						if(r.content.length) {
							$.each(r.content, function(index, item) {
								var itemClone = $("#item-next-class").clone();
								$(itemClone).removeAttr('id');
								$(itemClone).attr('data-id',item.id);
								var _h = item.dateStart.split(' ')[1];
								/*
								if(_h != "00:00:00") {
									var _date_ = new Date();
									var date = new Date(_date_.getFullYear()+' '+_date_.getMonth()+' '+_date_.getDate()+' '+_h);
									if(date.getHours() > 12) {
										_h = (date.getHours() - 12) + ' pm';
									} else if(date.getHours() <= 11) {
										_h = date.getHours() + ' am';
									} else {
										_h = date.getHours() + ' pm';
									}
								}
								*/
								var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
								var _d = item.dateStart.split(' ')[0];
								console.log(_d);
								$(itemClone).find("#date").text(days[item.nDay]);
								//$(itemClone).find("#hours").text(_h != "00:00:00" ? _h :'--');
								$(itemClone).find("#hours").text(_h);
								str += $(itemClone).prop('outerHTML');
							});
						} else {
							str = '<li class="list-group-item">No hay proximas clases</li>';
						}
						$(idContentInstrument).find("#next-class").html(str);
					} else if(r.response == 1) {

					}
				},
				error: function(xhr, status, msg) {
					console.log(xhr.responseText);
				}
			});
		});
	}
	function removeHistoryClassStudent(){
		$('body').on('click','[id="deleteClass"]',function(){
			if(confirm('Esta seguro que desea eliminar esta clase Vista del estudiante ?')){
				var id = $(this).attr('value');
				var data = {id:id};
				$.ajax({
					url: base_url+'admin_ajax/deleteClassHistoryStudent',
					type: 'GET',
					dataType: 'json',
					data: data,
					beforeSend:function(){
					},
					success:function(r){
						if(r.response==2){
							location.reload(true);
						}
						console.log(r);
					},
					error:function(xhr, status, msg){
						console.log(xhr.responseText);
					}
				});
				
			}
		});
	}
	function removeClassStudent(){
		$('body').on('click','[id="removeClass"]',function(){
			if(confirm('Esta seguro que desea remover esta clase del estudiante?')){
				var content = $(this).closest('.list-group-item');
				var idClass = $(content).attr('data-id');
				var data = {id:idClass};
				$.ajax({
					url: base_url+'admin_ajax/removeClassStudent',
					type: 'GET',
					dataType: 'json',
					data: data,
					beforeSend:function(){
				
					},
					success:function(r){
						if(r.response==2){
							$(content).remove();
						}
						console.log(r);
					},
					error:function(xhr, status, msg){
						console.log(xhr.responseText);
					}
				});
			}
		});
	}
	function getHistoryByStrumentAndStundent() {
		$("body").on('submit', '#form-history', function(event) {
			event.preventDefault();
			var form = this;
			var content = $(form).closest('#instrument-content-information');
			var data = {
				idInstrument: $(form).find('#idInstrument').val(),
				dateFrom: $(form).find('input[id^=from]').val(),
				dateEnd: $(form).find('input[id^=to]').val(),
				idStudent: $(form).find('#idStudent').val()
			};
			console.log(data);
			$.ajax({
				url: base_url+'admin_ajax/historyClassStudent',
				type: 'GET',
				dataType: 'json',
				data: data,
				beforeSend: function() {
					var loader = '<i class="fa fa-spin fa-spinner"></i>';
					$(form).find('button[type=submit]').html(loader);
					$(form).find('button[type=submit]').prop('disabled', true);
				},
				success: function(r) {
					console.log(r);
					if(r.response == 2) {
						var str = '';
						if(r.content.length) {
							var cont=0;
							$.each(r.content, function(index, history) {
								var tr = $("#trClone").clone();
								//console.log(listTeachers)
								var indexTacher = listTeachers.indexOf(function(teacher) {
									return teacher.id == history.idProfesor;
								});
								$(tr).removeAttr('id');
								$(tr).find('#dateClass').text(history.dateClass); //con pipeDate(history.date) lo podria dejar con formato ex 7 de enero 2019
								$(tr).find('#idProfesor').text(r.content[cont].name);
								$(tr).find('#status').text(statusUser[history.status]);
								$(tr).find('#deleteClass').attr("value", r.content[cont].id);
								str += $(tr).prop('outerHTML'); 
								cont = cont+1;
							});
						}
					} 
					if(r.response == 1){
						console.log("no hay historial");
						var trNotFound = $("#trClone").clone();
						$(trNotFound).removeAttr('id');
						var title = '<td colspan="3"><h3 class="text-center">Ups.. Este Estudiante aun no tiene clases vistas</h3></td>';
						$(trNotFound).html(title);
						str = $(trNotFound).prop('outerHTML');
					}
					$(content).find("#table-history").html(str);
					
				},
				error: function(xhr, status, msg) {
					console.log(xhr.responseText);
				},
				complete: function() {
					$(form).find('button[type=submit]').text('Generar');
					$(form).find('button[type=submit]').prop('disabled', false);
				}
			});			
		});
	}
	function getHoursResidual(idInstrument, idUser, el) {
		$.ajax({
			url: base_url+'admin_ajax/getHoursResidual',
			type: 'GET',
			dataType: 'json',
			data: {idInstrument, idUser},
			beforeSend: function() {},
			success: function(r) {
				console.log('horas residuales');
				console.log(r);
				if(r.response == 2) {
					$(el).text(r.content);
				}
			},
			error: function(xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	}
	function getUserStudent() {
		$.ajax({
			url: base_url+'',
			type: 'GET',
			dataType: 'json',
			data: { idUser: idUserStudent},
			beforeSend: function() {},
			success:function(r) {
				console.log(r);
				if(r.response == 2) {
					console.log('usuario traido');
				}
			},
			error: function(xhr, status, msg) {
				console.log(xhr.responseText);
			}
		});
	}
	function openModalListClasesAvailable() {
		$("#tabContentInstruments").on('click', 'button#btn-see-class-available', function(event) {
			var btn = this;
			var contentBtn = $(btn).html();
			var idInstrument = $(this).attr('id-instrument');
			var data = {
				idUser: idUserStudent,
				idInstrument,
			}
			$.ajax({
				url: base_url+'admin_ajax/getClassAvailableStudent',
				type: 'GET',
				dataType: 'json',
				async: false,
				data: data,
				beforeSend: function() {
					var loader = '<i class="fa fa-spin fa-spinner"></i>';
					$(btn).prop('disabled', true);
					$(btn).html(loader);
				},
				success: function(r) {
					console.log(r);
					if(r.response == 2) {
						var str = '<h4>Horas restantes: <span id="remaining-hour"></span></h2>';
						var _days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
						var instrument = r.instrument;
						var nCupos = instrument.cupos;
						if(r.content.length) {
							var listClass = r.content.filter(function(_class) {
								return _class.dataClass.idStudent === null;
							});
							// console.log('lista de class para inscribir');
							// console.log(listClass);
							// console.log('lista de clases recibibdas por el servicio');
							// console.log(r.content);
							var nameInstrument = $("#list-instruments a[href='#instrument-"+r.content[0].dataClass.idInstrument+"']").text();
							if(listClass.length) {
								$.each(listClass, function(index, classAvailable) {
									console.log(classAvailable);
									var cardClone = $("#card-clone").clone();
									$(cardClone).removeAttr('id');

									$(cardClone).find('[card-body]').attr('data-nday', classAvailable.dataClass.nDay);
									$(cardClone).find('[card-body]').attr('data-time', classAvailable.dataClass.time);
									$(cardClone).find("input#general").attr('name', 'type-'+classAvailable.dataClass.id);
									$(cardClone).find("input#general").attr('id', 'general-'+classAvailable.dataClass.id);
									$(cardClone).find("label[for=general]").attr('for', 'general-'+classAvailable.dataClass.id);
									$(cardClone).find("input#bono").attr('name', 'type-'+classAvailable.dataClass.id);
									$(cardClone).find("input#bono").attr('id', 'bono-'+classAvailable.dataClass.id);
									$(cardClone).find("label[for=bono]").attr('for', 'bono-'+classAvailable.dataClass.id);
									$(cardClone).find("input#reprogramado").attr('name', 'type-'+classAvailable.dataClass.id);
									$(cardClone).find("input#reprogramado").attr('id', 'reprogramado-'+classAvailable.dataClass.id);
									$(cardClone).find("label[for=reprogramado]").attr('for', 'reprogramado-'+classAvailable.dataClass.id);
									var timer = classAvailable.dataClass.time.split(':');
									timer.pop();
									var _hour = Number(timer[0]);
									if(!isNaN(_hour)) {
										if(_hour >= 12) {
											if(_hour > 12) {
												timer[0] = _hour - 12;
											}
											timer = timer.join(':') + ' pm';
										} else {
											timer = timer.join(':') + ' am';
										}
									}
									$(cardClone).find("#time").text(timer);
									
									$(cardClone).find("#name_instrument").text(nameInstrument);
									$(cardClone).find("#n_students").text(classAvailable.studentsInscribed);

									$(cardClone).find("#n_hours").text(classAvailable.dataClass.hours);
									$(cardClone).find("#day").text(_days[classAvailable.dataClass.nDay]);
									$(cardClone).find("form#formAgendClass #time_send").attr('value', classAvailable.dataClass.time);
									$(cardClone).find("form#formAgendClass #nDay").attr('value', classAvailable.dataClass.nDay);
									$(cardClone).find("form#formAgendClass #idInstrument").attr('value', classAvailable.dataClass.idInstrument);
									$(cardClone).find('form#formAgendClass #idClassHead').attr('value', classAvailable.dataClass.id);
									$(cardClone).find('form#formAgendClass #nHours').attr('value', classAvailable.dataClass.hours);
									$(cardClone).find('form#formAgendClass #dateStart').attr('value', classAvailable.dataClass.dateStart);
									console.log('comparacion 666',classAvailable.studentsInscribed, nCupos, classAvailable.studentsInscribed >= nCupos)
									if(classAvailable.studentsInscribed >= nCupos){
										$(cardClone).find('#addClassStudent').attr('disabled','disabled');
									}

									str += $(cardClone).prop('outerHTML');
								});
							} else {
								str += '<h5>No hay clases disponibles para inscribir</h5>';
							}
						} else {
							str += '<h5>No hay clases disponibles</h5>';
						}
						loadModal('Clases disponibles', str, 'Cerrar');
						var calendars = $("#bodyModal").find('input[data-calendar]');
						$.each(calendars, function(index, inputCalendar) {
							var days = [0,1,2,3,4,5,6];
							var nday = Number($(inputCalendar).closest('[card-body]').data("nday"));
							console.log(nday);
							var index = days.indexOf(nday);
							if(index >= 0) {
								days.splice(index, 1);				
							}
							//console.log(days);
							$(inputCalendar).datetimepicker({
								format: 'YYYY-MM-DD',
								minDate: moment(),
								daysOfWeekDisabled: days,
							});
						});
					} else if(r.response == 1) {
						$("#msg-error-class-available").slideDown('fast', function() {
							setTimeout(function() {
								$("#msg-error-class-available").slideUp('fast');
							}, 1800);
						});
					}
				},
				error: function(xhr, status, msg) {
					console.log(xhr.responseText);
				},
				complete: function() {
					$(btn).prop('disabled', false);
					$(btn).html(contentBtn);
				}
			});
			getHoursResidual(idInstrument, idUserStudent, $("#mainModal").find("#remaining-hour"));
		});
	}
	function pipeDate(date, widthHour = false) {
		var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
		var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

		var dataDate = new Date(date);
		var data;

		if(dataDate != 'Invalid Date') {
			data = days[dataDate.getDay()]+' '+dataDate.getDate()+' de '+months[dataDate.getMonth()]+' del '+dataDate.getFullYear();
			if(widthHour) {
				var meridian = dataDate.getHours() >= 12 ? 'pm' : 'am';
				var h = dataDate.getHours() > 12 ? dataDate.getHours() - 12 : dataDate.getHours();
				var txt = '';
				if(h > 1) {
					txt = ' a las ';
				} else {
					txt = ' a la ';
				}
				data += txt+h+' '+meridian;
			}
		} else {
			data = '--';
		}
		return data;		
	}
	function selectBono() {
		$("#tabContentInstruments").on('click', 'label[for^="bono-instrument"]', function(evt) {
			evt.stopImmediatePropagation();
			var label = this;
			var idInput = $(this).attr('for');
			var form = $(this).closest('form');
			var input = $(form).find('input#'+idInput);
			var hasBono;
			if($(input).prop('checked')) {
				hasBono = 'No';
				$(form).find("#price").val('');
				$(form).find("#price").prop('disabled', false);
				$(form).find("#nRecibo").val('');
				$(form).find("#nRecibo").prop('disabled', false);
				$(form).find("#medio").prop('disabled', false);
				$(form).find("#discount").prop('disabled', false);
				$(form).find("#hours").prop('disabled', false);
				$(form).find("#calcularPrecio").prop('disabled', false);
				$(form).find("#porcentaje").prop('disabled', false);
				$(form).find("#pago").prop('disabled', false);
			} else {
				$(form).find("#price").val('0');
				$(form).find("#price").prop('disabled', true);
				$(form).find("#nRecibo").val('0');
				$(form).find("#nRecibo").prop('disabled', true);
				$(form).find("#medio").prop('disabled', true);
				$(form).find("#discount").prop('disabled', true);
				$(form).find("#hours").prop('disabled', true);
				$(form).find("#calcularPrecio").prop('disabled', true);
				$(form).find("#porcentaje").prop('disabled', true);
				$(form).find("#pago").prop('disabled', true);

				
				hasBono = 'Si';
			}
			$(form).find("#has-bono").text(hasBono);
		});
	}
	function selectTypeOption() {
		$("#mainModal").on('click', 'label[data-option]', function(event) {
			console.log(this);
			var type = $(this).data('option');
			var contentOptions = $(this).closest('[card-body]');
			if(type >= 1) {
				$(contentOptions).find('#content-date-calendar-class').slideDown('fast');
			} else {
				$(contentOptions).find('#content-date-calendar-class').slideUp('fast');
			}
		});
	}
	function keydownPrice() {
		$("#tabContentInstruments").on('keyup', 'input#price', function(event) {
			console.log($(this).val(), Number($(this).val()));

			// var maxNumber = 57;
			// var minNumber = 48;
			// var maxNumberSide = 105;
			// var minNumberSide = 96;
			var form = $(this).closest('[addpackageinstrument]');
			$(form).find("#price-view").text($.number(Number($(this).val()), 0, '', ' '));
		});
	}
})();
