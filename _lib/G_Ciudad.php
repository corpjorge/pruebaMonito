<?php
/**
 * Table Definition for g_ciudad
 */
require_once 'DB/DataObject.php';

class DOG_Ciudad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'g_ciudad'; // table name
    var $ciudad;
    var $nombre;
    var $pais;
    var $departamento;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOG_Ciudad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
