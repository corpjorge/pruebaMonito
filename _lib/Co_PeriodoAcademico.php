<?php
/**
 * Table Definition for co_periodoacademico
 */
require_once 'DB/DataObject.php';

class DOCo_PeriodoAcademico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_periodoacademico'; // table name
    var $periodoacademico;                  
    var $fechainicio;                      
    var $fechafin;                        
    var $fechainicioreceso;                
    var $fechafinreceso;                  
    var $minhoras;                       
    var $maxhoras;                       
    var $periodosemestre;                    
    var $minvalorhora;                   
    var $maxvalorhora;                   
    var $fechalimite;                       

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_PeriodoAcademico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
