<?php
/**
 * Table Definition for co_estadoestudiante
 */
require_once 'DB/DataObject.php';

class DOCo_EstadoEstudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_estadoestudiante'; // table name
    var $estadoestudiante;
    var $nombres;
    var $descripcion;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_EstadoEstudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
