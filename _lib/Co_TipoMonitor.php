<?php
/**
 * Table Definition for co_tipomonitor
 */
require_once 'DB/DataObject.php';

class DOCo_TipoMonitor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_tipomonitor'; // table name
    var $tipomonitor;
    var $nombre;
    var $minvalorhora;
    var $maxvalorhora;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_TipoMonitor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
