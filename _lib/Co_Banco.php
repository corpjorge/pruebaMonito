<?php
/**
 * Table Definition for co_banco
 */
require_once 'DB/DataObject.php';

class DOCo_Banco extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_banco'; // table name
    var $banco;
    var $nombre;
    var $pais;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_Banco',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
