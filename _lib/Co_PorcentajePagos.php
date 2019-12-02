<?php
/**
 * Table Definition for co_porcentajepagos
 */
require_once 'DB/DataObject.php';

class DOCo_PorcentajePagos extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_porcentajepagos'; // table name
    var $porcentajepagos;
    var $posicion;
    var $porcentaje;
    var $planpagos;
    var $fecha;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_PorcentajePagos',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
