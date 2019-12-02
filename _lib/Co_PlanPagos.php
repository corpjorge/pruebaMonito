<?php
/**
 * Table Definition for co_planpagos
 */
require_once 'DB/DataObject.php';

class DOCo_PlanPagos extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_planpagos'; // table name
    var $planpagos;
    var $nombre;
    var $periodoacademico;
    var $aplicafechalimite;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_PlanPagos',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
