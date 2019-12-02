var ajaxLoader = '<img width="16" height="16" src="./img/ajax-loader.gif">';

function cambioPais(activo) {
    pais = $('#pais').val();
	if(pais != "") {
		var parametros = {
			"clase" : "Estudiante",
			"controlador" : "List",
			"metodo" : "usrCambioPais",
			"request" : "ajax",
			"pais" : pais
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divDepartamento").html(ajaxLoader);
			},
	        success:  function (response) {
				$('#departamento').empty();
				$('#departamento').html(llenarElementosActivo(response, activo));
				$('#departamento').removeAttr('disabled');
				$('#ciudad').empty();
				$('#ciudad').html("<option value=''>Seleccionar...</option>");
				$('#ciudad').attr('disabled', 'disabled');
				$("#divDepartamento").empty();
			}
	 	});
	 } else {
	 	$('#departamento').empty();
	 	$('#departamento').html("<option value=''>Seleccionar...</option>");
		$('#departamento').attr('disabled', 'disabled');
	 	$('#ciudad').empty();
	 	$('#ciudad').html("<option value=''>Seleccionar...</option>");
		$('#ciudad').attr('disabled', 'disabled');
	 }
}


function cambioDepartamento(activo) {
    pais = $('#pais').val();
	departamento = $('#departamento').val();
	if(departamento != "") {
		var parametros = {
			"clase" : "Estudiante",
			"controlador" : "List",
			"metodo" : "usrCambioDepartamento",
			"request" : "ajax",
			"pais" : pais,
			"departamento" : departamento
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divCiudad").html(ajaxLoader);
			},
			success:  function (response) {
				$('#ciudad').empty();
				$('#ciudad').html(llenarElementosActivo(response, activo));
				$('#ciudad').removeAttr('disabled');
				$("#divCiudad").empty();
			}
	 	});
	 } else {
	 	$('#ciudad').empty();
	 	$('#ciudad').html("<option value=''>Seleccionar...</option>");
		$('#ciudad').attr('disabled', 'disabled');
	 }
}

function cambioDependenciaPadre(activo) {
    dependenciaPadre = $('#dependenciapadre').val();
    if(dependenciaPadre != "") {
		var parametros = {
			"clase" : "Convenio",
			"controlador" : "List",
			"metodo" : "usrCambioDependenciaPadre",
			"request" : "ajax",
			"dependenciapadre" : dependenciaPadre
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divDependencia").html(ajaxLoader);
				$("#divTipoLabor").html(ajaxLoader);
				$("#divTipoMonitor").html(ajaxLoader);
			},
			success:  function (response) {
				$('#dependencia').empty();
				$('#dependencia').html(llenarElementosActivo(response["dependencias"], activo));
				$('#dependencia').removeAttr('disabled');
				$("#divDependencia").empty();
				
				$('#tipolabor').empty();
				$('#tipolabor').html(llenarElementosActivo(response["tiposLabor"], activo));
				$('#tipolabor').removeAttr('disabled');
				$("#divTipoLabor").empty();
				$('#tipomonitor').empty();
				$('#tipomonitor').html("<option value=''>Seleccionar...</option>");
				$('#tipomonitor').attr('disabled', 'disabled');
				$("#divTipoMonitor").empty();

			}
	 	});
	} else {
	 	$('#dependencia').empty();
	 	$('#dependencia').html("<option value=''>Seleccionar...</option>");
		$('#dependencia').attr('disabled', 'disabled');
	 	$('#tipolabor').empty();
	 	$('#tipolabor').html("<option value=''>Seleccionar...</option>");
		$('#tipolabor').attr('disabled', 'disabled');

	}
	$('#tipomonitor').empty();
	$('#tipomonitor').html("<option value=''>Seleccionar...</option>");
	$('#tipomonitor').attr('disabled', 'disabled');
	$('#divTituloTipoLabor').empty();
	$("#divTablaTipoLabor").hide("slow");
	$("#divTablaTipoLaborI").hide("slow");
	$("#divTablaTipoLaborD").hide("slow");
	$("#divTablaMateria").hide("slow");
	 //cambioDependencia('');
}

function cambioDependencia(activo) {
    dependencia = $('#dependencia').val();
    dependenciaPadre = $('#dependenciapadre').val();
    if(dependencia != "") {
		var parametros = {
			"clase" : "Convenio",
			"controlador" : "List",
			"metodo" : "usrCambioDependencia",
			"request" : "ajax",
			"dependencia" : dependencia,
			"dependenciapadre" : dependenciaPadre
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divTipoLabor").html(ajaxLoader);
				$("#divTipoMonitor").html(ajaxLoader);
			},
			success:  function (response) {
				$('#tipolabor').empty();
				$('#tipolabor').html(llenarElementosActivo(response["tiposLabor"], activo));
				$('#tipolabor').removeAttr('disabled');
				$("#divTipoLabor").empty();
				$('#tipomonitor').empty();
				$('#tipomonitor').html("<option value=''>Seleccionar...</option>");
				$('#tipomonitor').attr('disabled', 'disabled');
				$("#divTipoMonitor").empty();
				if(activo == "") {
					$('#divTituloTipoLabor').empty();
					$("#divTablaTipoLabor").hide("slow");
					$("#divTablaTipoLaborI").hide("slow");
					$("#divTablaTipoLaborD").hide("slow");
					$("#divTablaMateria").hide("slow");
				}
			}
	 	});
	} else {
	 	$('#tipolabor').empty();
	 	$('#tipolabor').html("<option value=''>Seleccionar...</option>");
		$('#tipolabor').attr('disabled', 'disabled');

	 	$('#tipomonitor').empty();
	 	$('#tipomonitor').html("<option value=''>Seleccionar...</option>");
		$('#tipomonitor').attr('disabled', 'disabled');
		$('#divTituloTipoLabor').empty();
		$("#divTablaTipoLabor").hide("slow");
		$("#divTablaTipoLaborI").hide("slow");
		$("#divTablaTipoLaborD").hide("slow");
		$("#divTablaMateria").hide("slow");
	}
	//cambioTipoLabor('');
}

function cambioTipoLabor(activo) {
    dependencia = $('#dependencia').val();
    dependenciaPadre = $('#dependenciapadre').val();
    tipoLabor = $('#tipolabor').val();
    if(tipoLabor != "") {
		var parametros = {
			"clase" : "Convenio",
			"controlador" : "List",
			"metodo" : "usrCambioTipoLabor",
			"request" : "ajax",
			"dependencia" : dependencia,
			"dependenciapadre" : dependenciaPadre,
			"tipolabor" : tipoLabor
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divTipoMonitor").html(ajaxLoader);
			},
			success:  function (response) {
				if(activo == "") {
					activo = response["tipoMonitorDefecto"];
				}
				$('#tipomonitor').empty();
				$('#tipomonitor').html(llenarElementosActivo(response["tiposMonitor"], activo));
				$('#tipomonitor').removeAttr('disabled');
				$('#divTituloTipoLabor').html($('#tipolabor option:selected').text());
				$("#divTablaTipoLabor").show("slow");
				if(response["labor"] == "I") {
					$('#curso1000').removeAttr('disabled');
					$('#seccion1000').removeAttr('disabled');
					$('#nombre1000').removeAttr('disabled');
					$('#crn1000').removeAttr('disabled');

					$("#divTablaTipoLaborI").show("slow");
					$("#divTablaTipoLaborD").hide("slow");
					$("#divTablaMateria").hide("slow");
				} else if(response["labor"] == "D") {
					$('#curso1000').attr('disabled', 'disabled');
					$('#seccion1000').attr('disabled', 'disabled');
					$('#nombre1000').attr('disabled', 'disabled');
					$('#crn1000').attr('disabled', 'disabled');

					$("#divTablaTipoLaborI").hide("slow");
					$("#divTablaTipoLaborD").show("slow");
					$("#divTablaMateria").show("slow");
					if (numeroMaterias == 0) {
						adicionarMateria();
					}
				}
				$("#divTipoMonitor").empty();
			}
	 	});
	} else {
	 	$('#tipomonitor').empty();
	 	$('#tipomonitor').html("<option value=''>Seleccionar...</option>");
		$('#tipomonitor').attr('disabled', 'disabled');
		$('#divTituloTipoLabor').empty();
		$("#divTablaTipoLabor").hide("slow");
		$("#divTablaTipoLaborI").hide("slow");
		$("#divTablaTipoLaborD").hide("slow");
		$("#divTablaMateria").hide("slow");
	}
}

function buscarMateria(orden) {
    textoMateria = $('#textomateria' + orden).val();
    if(textoMateria != "") {
		var parametros = {
			"clase" : "Convenio",
			"controlador" : "List",
			"metodo" : "usrBuscarMateria",
			"request" : "ajax",
			"textomateria" : textoMateria
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divNombreMateria" + orden).html(ajaxLoader);
			},
			success:  function (response) {
				$('#curso' + orden).removeAttr('disabled');
				$('#curso' + orden).empty();
				$('#curso' + orden).html(llenarElementosActivo(response, ''));
				$('#seccion' + orden).empty();
				$('#seccion' + orden).html("<option value=''>Seleccionar...</option>");
				$('#seccion' + orden).attr('disabled', 'disabled');
				$('#nombre' + orden).val("");
				$('#crn' + orden).val("");
				$('#divNombreMateria' + orden).empty();
			}
	 	});
	 } else {
		$('#curso' + orden).empty();
		$('#curso' + orden).html("<option value=''>Seleccionar...</option>");
		$('#curso' + orden).attr('disabled', 'disabled');
		$('#seccion' + orden).empty();
		$('#seccion' + orden).html("<option value=''>Seleccionar...</option>");
		$('#seccion' + orden).attr('disabled', 'disabled');
		$('#nombre' + orden).val("");
		$('#crn' + orden).val("");
	 }
}

function cambioMateria(orden, activo) {
    curso = $('#curso' + orden).val();
    /*Ajuste*/
    if(curso == 'VICE3001' || curso == 'VICE3002'){
    	htmlHoras = '<option value="">Seleccionar...</option>';
		for(i=3;i<=24;i++){
			htmlHoras += '<option value="'+i+'">'+i+'</option>';
		}
		if(orden == 1000){
			$("#horassemanales" ).html(htmlHoras);
			$("#valorhora").val(12783);
			$("#valorhora").attr('readonly','readonly');
		}else{
			$("#horassemanales" + orden).html(htmlHoras);
			$("#valorhora" + orden).val(12313);
			$("#valorhora" + orden).attr('readonly','readonly');
		}
    }else{
    	htmlHoras = '<option value="">Seleccionar...</option>';
		for(i=minHoras;i<=maxHoras;i++){
			htmlHoras += '<option value="'+i+'">'+i+'</option>';
		}
		if(orden == 1000){
			$("#horassemanales" ).html(htmlHoras);
			$("#valorhora").removeAttr('readonly');
			$("#valorhora").val(0);
		}else{
			$("#horassemanales" + orden).html(htmlHoras);
			$("#valorhora" + orden).removeAttr('readonly');
			$("#valorhora" + orden).val(0);
		}
    }
    /*Ajuste*/
    if(curso != "") {
		var parametros = {
			"clase" : "Convenio",
			"controlador" : "List",
			"metodo" : "usrCambioMateria",
			"request" : "ajax",
			"curso" : curso
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divSeccionMateria" + orden).html(ajaxLoader);
			},
			success:  function (response) {
				$('#seccion' + orden).removeAttr('disabled');
				$('#seccion' + orden).empty();
				$('#seccion' + orden).html(llenarElementosActivo(response['secciones'], activo));
				$('#nombre' + orden).val("");
				$('#crn' + orden).val("");
				$('#divSeccionMateria' + orden).empty();
			}
	 	});
	 } else {
		$('#seccion' + orden).empty();
		$('#seccion' + orden).html("<option value=''>Seleccionar...</option>");
		$('#seccion' + orden).attr('disabled', 'disabled');
		$('#nombre' + orden).val("");
		$('#crn' + orden).val("");
	 }
}

function cambioSeccion(orden) {
	curso = $('#curso' + orden).val();
    seccion = $('#seccion' + orden).val();
    if(seccion != "") {
		var parametros = {
			"clase" : "Convenio",
			"controlador" : "List",
			"metodo" : "usrCambioSeccion",
			"request" : "ajax",
			"curso" : curso,
			"seccion" : seccion
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divNombreMateria" + orden).html(ajaxLoader);
				$("#divCrnMateria" + orden).html(ajaxLoader);
			},
			success:  function (response) {
				var nombre = response['nombre'];
				nombre = nombre.replace('&aacute;', 'á');
				nombre = nombre.replace('&eacute;', 'é');
				nombre = nombre.replace('&iacute;', 'í');
				nombre = nombre.replace('&oacute;', 'ó');
				nombre = nombre.replace('&uacute;', 'ú');
				nombre = nombre.replace('&agrave;', 'à');
				nombre = nombre.replace('&egrave;', 'è');
				nombre = nombre.replace('&igrave;', 'ì');
				nombre = nombre.replace('&ograve;', 'ò');
				nombre = nombre.replace('&ugrave;', 'ù');
				nombre = nombre.replace('&ntilde;', 'ñ');
				nombre = nombre.replace('&Aacute;', 'Á');
				nombre = nombre.replace('&Eacute;', 'É');
				nombre = nombre.replace('&Iacute;', 'Í');
				nombre = nombre.replace('&Oacute;', 'Ó');
				nombre = nombre.replace('&Uacute;', 'Ú');
				nombre = nombre.replace('&Agrave;', 'À');
				nombre = nombre.replace('&Egrave;', 'È');
				nombre = nombre.replace('&Igrave;', 'Ì');
				nombre = nombre.replace('&Ograve;', 'Ò');
				nombre = nombre.replace('&Ugrave;', 'Ò');
				nombre = nombre.replace('&Ntilde;', 'Ñ');
				$('#nombre' + orden).val(nombre);
				$('#divNombreMateria' + orden).empty();
				$('#crn' + orden).val(response['crn']);
				$('#divCrnMateria' + orden).empty();
			}
	 	});
	 } else {
		$('#nombre' + orden).val("");
		$('#crn' + orden).val("");
	 }
}

function cambioTipoObjeto(orden, activo) {
    tipoObjeto = $('#tipoobjeto' + orden).val();
    if(tipoObjeto != "") {
		var parametros = {
			"clase" : "Convenio",
			"controlador" : "List",
			"metodo" : "usrCambioTipoObjeto",
			"request" : "ajax",
			"tipoobjeto" : tipoObjeto
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divObjetoCosto" + orden).html(ajaxLoader);
			},
			success:  function (response) {
				$('#objetocosto' + orden).removeAttr('disabled');
				$('#objetocosto' + orden).empty();
				$('#objetocosto' + orden).html(llenarElementosActivo(response, activo));
				$('#divObjetoCosto' + orden).empty();
			}
	 	});
	 } else {
		$('#objetocosto' + orden).empty();
		$('#objetocosto' + orden).html("<option value=''>Seleccionar...</option>");
		$('#objetocosto' + orden).attr('disabled', 'disabled');
	 }
}

function calcularValorConvenio() {
	$('#divErroresCalculoValorConvenio').empty();

    var clase = $('#clase').val();
    var controlador = $('#controlador').val();
    var metodo = $('#metodo').val();
    $('#clase').val("Convenio");
    $('#controlador').val("List");
    $('#metodo').val("usrCalcularValorConvenio");
    forma = $('#frmSolicitudConvenio').serialize();
	$.ajax({
		data:  forma + "&request=ajax",
		url:   url,
		type:  'POST',
		cache: false,
		dataType : 'json',
		processData:true,
        error: function( htmlResponse ){
            alert('<!--' + htmlResponse + '-->');
        },
		beforeSend: function () {
			$("#divValor").html(ajaxLoader);
		},
		success:  function (response) {
			$('#valor').val(response['valor']);
			if (response['mensaje'] != "") {
				$('#divErroresCalculoValorConvenio').html(cargarTablaErrores(response['errores']));
				alert(response['mensaje']);
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
			$('#divValor').empty();
		}
 	});
    $('#clase').val(clase);
    $('#controlador').val(controlador);
    $('#metodo').val(metodo);
}

function cambioPeriodoAcademicoR(activo) {
    periodoacademico = $('#periodoacademico').val();
    if(periodoacademico != "") {
		var parametros = {
			"clase" : "Convenio",
			"controlador" : "List",
			"metodo" : "usrCambioPeriodoAcademicoR",
			"request" : "ajax",
			"periodoacademico" : periodoacademico
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	        },
			beforeSend: function () {
				$("#divPlanPagos").html(ajaxLoader);
				$("#divCorte").html(ajaxLoader);
			},
			success:  function (response) {
				$('#corte').removeAttr('disabled');
				$('#corte').empty();
				$('#corte').html(llenarElementosActivo(response, activo));
				$('#divCorte').empty();
			}
	 	});
	 } else {
			$('#corte').empty();
			$('#corte').html("<option value=''>Seleccionar...</option>");
			$('#corte').attr('disabled', 'disabled');
	 }
}

function aprobarPago(convenio) {
	var error = '<img src="./img/dialog-error.png" title="Error">';
	var aprobado = '<img src="./img/money_add.png" title="Aprobado">';
	
    if(convenio != "") {
		var parametros = {
			"clase" : "Convenio",
			"controlador" : "Item",
			"metodo" : "usrAprobarPago",
			"request" : "ajax",
			"convenio" : convenio
		};
		$.ajax({
			data:  parametros,
			url:   url,
			type:  'POST',
			cache: false,
			dataType : 'json',
	        error: function( htmlResponse ){
	            alert('<!--' + htmlResponse + '-->');
	            $("#divAprobar" + convenio).html(error);
	        },
			beforeSend: function () {
				$("#divAprobar" + convenio).html(ajaxLoader);
			},
			success:  function (response) {
				if (response['error'] == "") {
					$("#divAprobar" + convenio).html(aprobado);
				} else {
					$("#divAprobar" + convenio).html(error);
				}
			}
	 	});
	 } else {
		 $("#divAprobar" + convenio).html(error);
	 }
}

function llenarElementosActivo(elementos, activo){
    valores = "<option value='' selected='selected'>Seleccionar...</option>";
    for(kElementos in elementos){
    	if(kElementos == activo){
    		 valores += "<option value='" + kElementos + "' selected='selected'>" + elementos[kElementos] + "</option>";
    	}else{
        	valores += "<option value='" + kElementos + "'>" + elementos[kElementos] + "</option>";
        }
    }
    return valores;
}

function cargarTablaErrores(elementos){
    valores = "<table border='0' cellspacing='0' cellpadding='4' width='100%'>";
    for(kElementos in elementos){
		valores += "<tr>";
		valores += "<td align='center' valign='middle' colspan='2' class='Warning'><h3>" + elementos[kElementos] + "</h3></td>";
		valores += "</tr>";
    }
	valores += "</table>";
    return valores;
}
