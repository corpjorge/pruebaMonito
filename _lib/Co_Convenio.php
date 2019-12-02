<?php
/**
 * Table Definition for co_convenio
 */
require_once 'DB/DataObject.php';

class DOCo_Convenio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_convenio'; // table name
    var $convenio;
    var $fechainicio;
    var $fechafin;
    var $estudiante;
    var $dependencia;
    var $tipomonitor;
    var $tipolabor;
    var $periodoacademico;
    var $valorhora;
    var $horassemanales;
    var $descripcion;
    var $estado;
    var $consecutivo;
    var $usuariocreacion;
    var $fechacreacion;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_Convenio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
