<?php
/**
 * Table Definition for co_pago
 */
require_once 'DB/DataObject.php';

class DOCo_Pago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_pago'; // table name
    var $pago;
    var $valor;
    var $convenio;
    var $porcentajepagos;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_Pago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
