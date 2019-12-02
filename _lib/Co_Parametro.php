<?php
/**
 * Table Definition for co_parametro
 */
require_once 'DB/DataObject.php';

class DOCo_Parametro extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_parametro'; // table name
    var $parametro;
    var $nombre;
    var $descripcion;
    var $valor;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_Parametro',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
