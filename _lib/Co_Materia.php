<?php
/**
 * Table Definition for co_materia
 */
require_once 'DB/DataObject.php';

class DOCo_Materia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_materia'; // table name
    var $materia;
    var $curso;
    var $convenio;
    var $crn;
    var $nombre;
    var $valorhora;
    var $horassemanales;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_Materia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
