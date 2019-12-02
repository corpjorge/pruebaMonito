<?php
/**
 * Table Definition for co_estudiante
 */
require_once 'DB/DataObject.php';

class DOCo_Estudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_estudiante'; // table name
    var $estudiante;
    var $nombres;
    var $apellidos;
    var $direccion;
    var $telefono;
    var $email;
    var $genero;
    var $expediciondoc;
    var $codigo;
    var $documento;
    var $estadoestudiante;
    var $tipodocumento;
    var $ciudad;
   	var $departamento;
    var $pais;
        
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_Estudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
