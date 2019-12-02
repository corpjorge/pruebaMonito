<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr">
<head>
  <base href="{URL_SITIO}" />
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <meta http-equiv="Script-Content-Type" content="text/javascript; charset=iso-8859-1">
  <meta name="robots" content="index, follow" />
  <title>{APLICACION}</title>

	<link href="./css/normal.css" rel="stylesheet" type="text/css">
	<link href="./css/estilos.css" rel="stylesheet" type="text/css">
	<link href="./css/tea/position.css" rel="stylesheet" type="text/css">
	<link href="./css/tea/layout.css" rel="stylesheet" type="text/css">
	<link href="./css/tea/print.css" rel="stylesheet" type="text/css">
	<link href="./css/tea/general.css" rel="stylesheet" type="text/css">
	<link href="./css/tea/personal.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="all">
  <div class="logoheader">
    <h1 id="logo">
      <img src="/img/uniandes_logo.jpg"  alt="TEA" align="left" />
      <img src="/img/tea_uniandes.jpg" width="201" height="88"  align="right"/>
    </h1>
  </div>
  <div id="back">
    <div id="contentarea">
      <!-- BEGIN CONSESION -->
      <div id="nav" class="left1 leftbigger" role="navigation">
        <div class="moduletable_js ">
          <div class="module_content " id="module_92" tabindex="-1">
            <br>
            <strong><a href="/index.php" >Bienvenido</a>:<br>{nombreusuario}</strong>&nbsp;&nbsp;
            <a href="/index.php?accion=Salir" ><img title="Salir" src="./icons/door_open.png" style="cursor:pointer" /></a>
            <!-- BEGIN MODULO -->
            <h3>&nbsp;<strong>{nombremodulo}</strong></h3>
            <ul class="menu">
              <!-- BEGIN PERMISO -->
              <li><a href="./index.php?clase={clase}&controlador={controlador}&metodo={metodo}">{nombrepermiso}</a></li>
              <!-- END PERMISO -->
            </ul>
            <!-- END MODULO -->
          </div>
        </div>
      </div>
      <div id="wrapper2">
      <!-- END CONSESION -->
      <!-- BEGIN SINSESION -->
      <div id="wrapper3">
      <!-- END SINSESION -->  