<?php
/**
 * Table Definition for co_tipolabor
 */
require_once 'DB/DataObject.php';

class DOCo_TipoLabor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_tipolabor'; // table name
    var $tipolabor;
    var $nombre;
    var $descripcion;
    var $tipomonitor;
    var $labor;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_TipoLabor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
