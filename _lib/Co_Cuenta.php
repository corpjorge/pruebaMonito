<?php
/**
 * Table Definition for co_cuenta
 */
require_once 'DB/DataObject.php';

class DOCo_Cuenta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_cuenta'; // table name
    var $cuenta;
    var $estudiante;
    var $tipocuenta;
    var $banco;
    var $numerocuenta;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_Cuenta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
