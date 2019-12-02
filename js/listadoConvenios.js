var ajaxLoader = '<img width="16" height="16" src="./img/ajax-loader.gif">';

function enviarPaginacion(paginaActual, pagina) {
	if (paginaActual == "") {
		paginaActual = $("#paginacion_paginaActual").val();
	}
	var parametros = {
		"clase" : "Convenio",
		"controlador" : "List",
		"metodo" : "usrMostrarListado",
		"request" : "ajax",
		"pagina" : pagina,
		"paginaActual" : paginaActual,
		"totalRegistros" : $("#paginacion_totalRegistros").val(),
		"filtroPeriodoAcademico" : $("#paginacion_filtroPeriodoAcademico").val(),
		"filtroDependencia" : $("#paginacion_filtroDependencia").val(),
		"filtroEstado" : $("#paginacion_filtroEstado").val(),
		"filtroCodigo" : $("#paginacion_filtroCodigo").val()
	};
	$.ajax({
		data:  parametros,
		url:   url,
		type:  'POST',
		cache: false,
		dataType : 'html',
        error: function( htmlResponse ){
            alert('<!--' + htmlResponse + '-->');
        },
		beforeSend: function () {
			$(".divLoadListado").html(ajaxLoader);
		},
		success:  function (response) {
			$('#divListadoConvenios').empty();
			$('#divListadoConvenios').html(response);
			$(".divLoadListado").empty();
		}
 	});
}
