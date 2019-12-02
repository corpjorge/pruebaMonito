<?php
/**
 * Table Definition for g_departamento
 */
require_once 'DB/DataObject.php';

class DOG_Departamento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'g_departamento'; // table name
    var $departamento;
    var $nombre;
    var $pais;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOG_Departamento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
