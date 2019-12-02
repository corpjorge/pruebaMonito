<?php

   	//Variables de manejo de Dataobjects.
	require_once('DB/DataObject.php');
	$config = parse_ini_file(CONFIG_FILE, TRUE);
	foreach($config as $class => $values) {
    	$options = &PEAR::getStaticProperty($class, 'options');
   		$options = $values;
	}

	$genero = array(
		'M' => 'Masculino',
		'F' => 'Femenino'
	);

	$tipoObjeto = array(
		'CC' => 'Centro Costo',
		'OI' => 'Orden Interna',
		'EP' => 'Elemento PEP'
	);
	
	$tipoCuenta = array(
		'01' => 'Cuenta Corriente',
		'02' => 'Cuenta de Ahorros'
	);
	
	$estadoConvenio = array(
		'C' => 'Creado',
		'A' => 'Aprobado',
		'R1' => 'Pago Reportado a Financiera - 50%',
		'R2' => 'Pago Reportado a Financiera - 100%'
	);

	$estadoConvenioMostrarPDF = array(
		'A',
		'R1',
		'R2'
	);
	
	/*
	 * Listado completo de estados laborales
	 * 
		'1' => 'Activos',
		'2' => 'Pensionados',
		'3' => 'Jubilado anticipado',
		'4' => 'Practicantes',
		'5' => 'Retirados',
		'6' => 'Empleado inactio',
		'7' => 'temporal/estacional',
		'8' => 'Empl.deleg.extranj.',
		'9' => 'Externos',
		'B' => 'Sin nombrar',
		'C' => 'Nombrados',
	 */
	$estadoLaboral = array(
		'5' => 'Retirados',
		'6' => 'Empleado inactio'
	);
	
	$tipoDocumentoBanner = array(
		'C' => '13',
		'D' => '42',
		'E' => '22',
		'N' => '31',
		'R' => '11',
		'S' => '42',
		'T' => '12',
		'P' => '41',
		'I' => '13'
	);
	
?>