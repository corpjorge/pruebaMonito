<?php
/**
 * Table Definition for co_usuario
 */
require_once 'DB/DataObject.php';

class DOCo_Usuario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'co_usuario'; // table name
    var $usuario;
    var $nombreusuario;
    var $nombre;
    var $apellido;
    var $correo;
    var $estado;
    var $fechacreacion;
    var $ultimoingres;
    var $rol;
    var $comentarios;
    var $dependencia;
    
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DOCo_Usuario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
