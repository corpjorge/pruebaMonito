<?php
	$db = new mysqli('apolo.uniandes.edu.co', "hmrios", "zaq12wsx", "","3307");
	if ($db->connect_error)
		die('Error de Conexion ('.$db->connect_errno.')'.$db->connect_error);

	//Consultar todas las bases de datos
	$dbs = $db->query("SHOW DATABASES");
	$array_bds = array();
	while ($obj = $dbs->fetch_object())
	{
		$array_bds[] = $obj->Database;
	}
	
	$index = array_search('mysql', $array_bds);
	unset($array_bds[$index]);
	
	//Consultar Tamaño y Hora de modificación de las tablas de cada DB
	$array_final = array();
	foreach($array_bds as $row)
	{
		$tables = $db->query("SHOW TABLE STATUS FROM ".$row);
		$sumSize       = 0;
		$ultimoActuali = "0000-00-00 00:00:00";
		while ($obj = $tables->fetch_object())
		{
			$sumSize += ( (($obj->Data_length+ $obj->Index_length)/1024)/1024 );
			if (strtotime($obj->Update_time)>=strtotime($ultimoActuali))
			{
				$ultimoActuali = $obj->Update_time;
			}
		}
		
		$array_final[] = array('bd'=>$row,'size'=>$sumSize,'ultimamodificacion'=>$ultimoActuali);
	}
	echo "<table border =11'>";
	foreach($array_final as $row)
	{
		echo "<tr><td>".$row['bd']."</td><td>".$row['size']."</td><td>".$row['ultimamodificacion']."</td>"."</tr>";
	}
	echo "</table>";

	echo "Conexion correcta con la base de datos... ".$db->host_info;
	$db->close();
?>