<?php
/**
 * Table Definition for co_distribucion
 */
require_once 'DB/DataObject.php';

class DOCo_Distribucion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_distribucion'; // table name
    var $distribucion;
    var $fondopresupuestal;
    var $porcentaje;
    var $objetocosto;
    var $convenio;
    var $tipoobjeto;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_Distribucion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
