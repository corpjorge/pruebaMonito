<?php
/**
 * Clase Validacion
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co> 
 */

Class Validacion {
    // Variables publicas
    var $acumuladoErrores; //Vector de acumulación de errores
    var $objeto; //Objeto de la clase a validar (instanciado)
    /**
     * Validacion::Validacion()
     * Constructor de la clase
     * 
     * @return 
     */
    function Validacion (&$objeto) {
        $this->resetErrores();
        $this->objeto = &$objeto;
    } 

    /**
     * Validacion::esVacio()
     * 
     * Revisa si el campo que recibe esta vacio, o solamente contiene espacios
     * tabuladores o fines de linea.
     * 
     * @param  $cadena cadena a revisar
     * @return boolean 
     */
    function esVacio($cadena) {
        // Determina si la cadena recibida es nula
        $returnValue = ($cadena == null) || (empty($cadena));
        return $returnValue;
    } 

    function esNoVacio ($cadena, $maxAncho = 0, $nombreCampo = null, $esObligatorio = true, $mensaje = null) {
        $returnValue = !($this->esVacio($cadena));
        return $returnValue;
    } 

    /**
     * Validacion::esNoValidable()
     * 
     * Retorna verdadero para todas las validaciones que recibe, se usa como metodo dummy
     * cuando hay algun valor que no sea necesario validar
     * 
     * @param  $valor 
     * @param  $maxAncho 
     * @param  $nombreCampo 
     * @param boolean $esObligatorio 
     * @param string $mensaje 
     * @return 
     */
    function esNoValidable ($valor, $maxAncho, $nombreCampo, $esObligatorio = true, $mensaje = null) {
        return true;
    } 

    /**
     * Validacion::esCorreoValido()
     * Revisa que el formato del correo electronico sea correcto
     * 
     * @param  $email email que se va ha validar
     * @param  $maxAncho máximo de calacteres del email
     * @param  $nombreCampo nombre del campo que se esta validando
     * @param boolean $esObligatorio determina si el campo es obligatorio
     * @param string $mensaje Mensaje
     * @return 
     */
    function esCorreoValido($email, $maxAncho, $nombreCampo, $esObligatorio = true, $mensaje = null) {
        // Determina si el email es nulo
        if ($this->esVacio($email)) {
            // Determina si el campo de email es obligatorio
            if ($esObligatorio) {
                // Asigna al vector de acumulador el nombre del campo y el mensaje de error
                $this->acumuladoErrores[$nombreCampo] = "$nombreCampo no puede ser vacio!";
                $returnValue = false;
            } else {
                $returnValue = true;
            } 
        } elseif (strlen($email) > $maxAncho) {
            // Determina que el numero de caractes del email no sobrepase el maximo determinado
            // si es mayor Asigna al vector de acumulador el error
            $this->acumuladoErrores[$nombreCampo] = "$nombreCampo sobrepasa la cantidad de caracteres permitida!";
            $returnValue = false;
        } else {
            // determina si el correo es valido
            $returnValue = ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $email, $regs); 
            // si no encontro coincidencias en la cadena
            if (!($returnValue)) {
                // si el mensaje el vacio adiciona el acumulado mesaje determinado
                if (!(isset($mensaje)) || empty($mensaje)) {
                    $this->acumuladoErrores[$nombreCampo] = 'El Correo Electronico es invalido!';
                } else {
                    // En caso de no Asigan el mensaje
                    $this->acumuladoErrores[$nombreCampo] = $mensaje;
                } 
            } else {
                $returnValue = true;
            } 
        } 

        return $returnValue;
    } 

    /**
     * Validacion::esUrlValida()
     * Revisa que la URL digitada tenga el formato requerido por internet
     * 
     * @param  $url Cadena que tiene la url
     * @param  $maxAncho Máximo de caracteres permitidos
     * @param  $nombreCampo Nombre del campo afectado
     * @param boolean $esObligatorio Determina si el campo es Obligatorio
     * @param string $mensaje Mensaje de error
     * @return 
     */
    function esUrlValida($url, $maxAncho, $nombreCampo, $esObligatorio = true, $mensaje = null) {
        // Determina si el email es nulo
        if ($this->esVacio($url)) {
            // Determina si el campo es obligatorio
            if ($esObligatorio) {
                // Si es Obligatorio adiciona al acumulador de errores el tipo de error
                $this->acumuladoErrores[$nombreCampo] = "$nombreCampo no puede ser vacio!";
                $returnValue = false;
            } else {
                $returnValue = true;
            } 
        } elseif (strlen($url) > $maxAncho) {
            // Determina si el campo exede el maximo de caracteres permitidos
            $this->acumuladoErrores[$nombreCampo] = "$nombreCampo sobrepasa la cantidad de caracteres permitida!";
            $returnValue = false;
        } else {
            // Revisa que la URL digitada tenga el formato requerido por internet
            $returnValue = ereg("^[a-zA-Z0-9]+://[^ ]+$", $url, $regs);

            if (!($returnValue)) {
                // En caso de que la URL no sea valida
                if (!(isset($mensaje)) || empty($mensaje)) {
                    // Adiciona al acumulador de errores el tipo de error
                    $this->acumuladoErrores[$nombreCampo] = 'La URL es invalida!';
                } else {
                    // Adiciona al acumulador de errores el tipo de error digitado por el usuario
                    $this->acumuladoErrores[$nombreCampo] = $mensaje;
                } 
            } 
        } 
        // Retorna True o False
        return $returnValue;
    } 

    /**
     * Validacion::esAlfanumerico()
     * Revisa que el campo sea alfanumerico(numeros y letras solamente)
     * 
     * @param  $alfanumer Cadena alfa numerica a validar
     * @param  $maxAncho Maximo de caracteres permitidos
     * @param  $nombreCampo Nombre del campo
     * @param boolean $esObligatorio Determina si el campo es Obligatorio
     * @param string $mensaje Mensaje de error envaido por el administrador
     * @return 
     */
    function esAlfanumerico($alfanumer, $maxAncho, $nombreCampo, $esObligatorio = true, $mensaje = null) {
        // Determina si el campo es nulo o vacio
        if ($this->esVacio($alfanumer)) {
            // Si el campo es vacio determina si el campo es obligatorio
            if ($esObligatorio) {
                // Adicina al vector de errores el campo y tipo de error
                $this->acumuladoErrores[$nombreCampo] = "$nombreCampo no puede ser vacio!";
                $returnValue = false;
            } else {
                $returnValue = true;
            } 
        } elseif (strlen($alfanumer) > $maxAncho) {
            // Determina si el número de caracteres es mayor que el determinado por el usuario
            // asigna al vector de errores el tipo de error
            $this->acumuladoErrores[$nombreCampo] = "$nombreCampo sobrepasa la cantidad de caracteres permitida!";
            $returnValue = false;
        } else {
            // Determna si la cadena contine caracteres que no estan en la cadena determinada
            $returnValue = ereg("^[áéíóúña-zÁÉÍÓÚÑA-Z0-9]+$", $alfanumer, $regs);

            if (!($returnValue)) {
                // Si encuentra caracteres Asigna al vector el campo y el tipo de error
                if (!(isset($mensaje)) || empty($mensaje)) {
                    // error por defecto
                    $this->acumuladoErrores[$nombreCampo] = 'El campo alfamunerico es invalido!';
                } else {
                    // error determinado por el usuario
                    $this->acumuladoErrores[$nombreCampo] = $mensaje;
                } 
            } 
        } 
        // Retorna TRUE o FALSE dependiendo el caso
        return $returnValue;
    } 

    /**
     * Validacion::esCadenaValida()
     * Revisa que el campo sea apto para una cadena(letras, numeros y _-)
     * 
     * @param  $cadena Cadena a validar
     * @param  $maxAncho Maximo de caracteres permitidos
     * @param  $nombreCampo Nombre del campo
     * @param boolean $esObligatorio Determina si el campo es obligatorio
     * @param string $mensaje 
     * @return 
     */
    function esCadenaValida($cadena, $maxAncho = null, $nombreCampo, $esObligatorio = true, $mensaje = null) {
        // Valida que la cadena este vacia o no
        if ($this->esVacio($cadena)) {
            // Si la cadena esta vacia determina si el campo es obligatorio
            if ($esObligatorio) {
                // En caso de que el campo sea obligatorio
                // Asigna al vector el campo y el error determindo
                $this->acumuladoErrores[$nombreCampo] = "$nombreCampo no puede ser vacio!";
                $returnValue = false;
            } else {
                $returnValue = true;
            } 
        } elseif (!empty($maxAncho) && strlen($cadena) > $maxAncho) {
            // Determina si el numero de caracteres de la cadema es mayot que el de los permitidos
            // Asigna al vector el campo y el error determindo
            $this->acumuladoErrores[$nombreCampo] = "$nombreCampo sobrepasa la cantidad de caracteres permitida!";
            $returnValue = false;
        } else {
            // determina si la cadena de contiene caracteres que no estan en los caracteres permitidos
            $returnValue = ereg("^[ _(\015\012)|(\015)|(\012)<>=?¿¡!'\"&#\$;\-\.·,a-zA-Z0-9áéíóúñÁÉÍÓÚÑ*ÀàÂâÃãÄäËëÊêÇçÎîÕõÔôÙùÛûÜüÆ%/:\-]+$", $cadena, $regs);

            if (!($returnValue)) {
                // Si contiene caracteres invalidos
                // Asigana al vector el campo y el mensaje de error
                if (!(isset($mensaje)) || empty($mensaje)) {
                    // error del sistemas
                    $this->acumuladoErrores[$nombreCampo] = "$nombreCampo contiene caracteres invalidos!";
                } else {
                    // error digitado por el usuario
                    $this->acumuladoErrores[$nombreCampo] = $mensaje;
                } 
            } 
        } 
        // Retorna TRUE o FALSE dependiendo el caso
        return $returnValue;
    } 

    /**
     * Validacion::esRutaValida()
     * Revisa que el campo sea apto para una ruta(numeros y letras solamente)
     * 
     * @param  $ruta Cadena de a validar
     * @param  $maxAncho maximo de caracteres permitidos
     * @param  $nombreCampo nombre del campo
     * @param boolean $esObligatorio Determina si el campo es obligatorio
     * @param string $mensaje Mensaje de erro del usuario
     * @return 
     */
    function esRutaValida($ruta, $maxAncho, $nombreCampo, $esObligatorio = true, $mensaje = null) {
        // Valida que la cadena este vacia o no
        if ($this->esVacio($ruta)) {
            // Si la cadena esta vacia determina si el campo es obligatorio
            if ($esObligatorio) {
                // En caso de que el campo sea obligatorio
                // Asigna al vector el campo y el error determindo
                $this->acumuladoErrores[$nombreCampo] = "$nombreCampo no puede ser vacio!";
                $returnValue = false;
            } else {
                $returnValue = true;
            } 
        } elseif (strlen($ruta) > $maxAncho) {
            // Determina si el campo es mayor que el numero permitido
            // Asigna al vector el campo y el error determindo
            $this->acumuladoErrores[$nombreCampo] = "$nombreCampo sobrepasa la cantidad de caracteres permitida!";
            $returnValue = false;
        } else {
            // Determina si la cadena contiene caracteres invalidos
            $returnValue = ereg("^[ _<>\-\.\\/,a-zA-Z0-9áéíóúñÁÉÍÓÚÑ]+$", $ruta, $regs);
            if (!($returnValue)) {
                // Si contiene caracteres que no estan en la cadena
                if (!(isset($mensaje)) || empty($mensaje)) {
                    // Asigna al vector el campo y el error determindo
                    // error por del sistema
                    $this->acumuladoErrores[$nombreCampo] = "$nombreCampo contiene caracteres invalidos!";
                } else {
                    // error por del usuario
                    $this->acumuladoErrores[$nombreCampo] = $mensaje;
                } 
            } 
        } 
        // Retorna TRUE o FALSE dependiendo el caso
        return $returnValue;
    } 

    /**
     * Validacion::esEntero()
     * Revisa que el campo tega numeros enteros positivos (digitos) solamente
     * 
     * @param  $entero Numero a validar
     * @param  $maxAncho Maximo del numero
     * @param  $nombreCampo Nombre del campo
     * @param boolean $esObligatorio Determina si el campo es obligatorio
     * @param string $mensaje Mensaje de error
     * @return 
     */
    function esEntero($entero, $maxAncho, $nombreCampo, $esObligatorio = true, $mensaje = null) {
        // Valida que la cadena este vacia o no
        if ($this->esVacio($entero)) {
            // Si la cadena esta vacia determina si el campo es obligatorio
            if ($esObligatorio) {
                // En caso de que el campo sea obligatorio
                // Asigna al vector el campo y el error determindo
                $this->acumuladoErrores[$nombreCampo] = "$nombreCampo no puede ser vacio!";
                $returnValue = false;
            } else {
                $returnValue = true;
            } 
        } elseif (strlen($entero) > $maxAncho) {
            // Determina si el campo es mayor que el numero permitido
            // Asigna al vector el campo y el error determindo
            $this->acumuladoErrores[$nombreCampo] = "$nombreCampo sobrepasa la cantidad de caracteres permitida!";
            $returnValue = false;
        } else {
            // Valida que la variable entero solo tenga numeros enteros
            $returnValue = ereg("^[0-9]+$", $entero, $regs); 
            // Si contiene caracteres que no estan en la cadena
            if (!($returnValue)) {
                // Si contiene caracteres que no estan en la cadena
                // Asigna al vector el campo y el error determindo
                if (!(isset($mensaje)) || empty($mensaje)) {
                    // error determinado por el usuario
                    $this->acumuladoErrores[$nombreCampo] = "$nombreCampo no es un entero valido!";
                } else {
                    // error determinado por el usuario
                    $this->acumuladoErrores[$nombreCampo] = $mensaje;
                } 
            } 
        } 
        // Retorna TRUE o FALSE dependiendo el caso
        return $returnValue;
    } 

    /**
     * Validacion::esNumero()
     * Revisa que el campo tega numeros, ya sean enteros o decimales positivos solamente
     * 
     * @param  $numero Numero que se va ha validar
     * @param  $maxAncho Maximo de caracteres permitidos
     * @param  $nombreCampo Nombre del campo
     * @param boolean $esObligatorio Determina si el campos es obligatorio
     * @param string $mensaje Mensaje de error del usuario
     * @return 
     */
    function esNumero($numero, $maxAncho, $nombreCampo, $textoCampo, $esObligatorio = true, $mensaje = null) {
        // Valida que la cadena este vacia o no
        if ($this->esVacio($numero)) {
            // Si la cadena esta vacia determina si el campo es obligatorio
            if ($esObligatorio) {
                // En caso de que el campo sea obligatorio
                // Asigna al vector el campo y el error determindo
                $this->acumuladoErrores[$nombreCampo] = "$textoCampo no puede ser vacio!";
                $returnValue = false;
            } else {
                $returnValue = true;
            } 
        } elseif (strlen($numero) > $maxAncho) {
            // Determina si el campo es mayor que el numero permitido
            // Asigna al vector el campo y el error determindo
            $this->acumuladoErrores[$nombreCampo] = "$textoCampo sobrepasa la cantidad de caracteres permitida!";
            $returnValue = false;
        } else {
            // Valida que el numero sea valida
            $returnValue = ereg("^[0-9.]+$", $numero, $regs); 
            // Si contiene caracteres que no estan en la cadena
            if (!($returnValue)) {
                // Si contiene caracteres que no estan en la cadena
                // Asigna al vector el campo y el error determindo
                if (!(isset($mensaje)) || empty($mensaje)) {
                    // error determinado por el usuario
                    $this->acumuladoErrores[$nombreCampo] = 'El campo numerico es invalido!';
                } else {
                    // error determinado por el usuario
                    $this->acumuladoErrores[$nombreCampo] = $mensaje;
                } 
            } 
        } 
        // Retorna TRUE o FALSE dependiendo el caso
        return $returnValue;
    } 

    /**
     * Validacion::esFechaValida()
     * Revisa que la fecha digitada tenga el formato requerido
     * Recibe dd/mm/yyyy y para que la funcion que revisa esto funcione toca transformarlo
     * a mm/dd/yyyy
     * 
     * @param  $fecha Fecha a validar
     * @param  $maxAncho Maximo de la fecha
     * @param  $nombreCampo Nombre del campo
     * @param boolean $esObligatorio Determina si el campo es Obligatorio
     * @param string $mensaje Mensaje de error del Usuario
     * @return 
     */
    function esFechaValida($fecha, $maxAncho, $nombreCampo, $esObligatorio = true, $mensaje = null) {
        // Valida que la cadena este vacia o no
        if ($this->esVacio($fecha)) {
            // Si la cadena esta vacia determina si el campo es obligatorio
            if ($esObligatorio) {
                // En caso de que el campo sea obligatorio
                // Asigna al vector el campo y el error determindo
                $this->acumuladoErrores[$nombreCampo] = "$nombreCampo no puede ser vacio!";
                $returnValue = false;
            } else {
                $returnValue = true;
            } 
        } elseif (strlen($fecha) > $maxAncho) {
            // Determina si el campo es mayor que el numero permitido
            // Asigna al vector el campo y el error determindo
            $this->acumuladoErrores[$nombreCampo] = "$nombreCampo sobrepasa la cantidad de caracteres permitida!";
            $returnValue = false;
        } else {
            // Separa el formato de la fecha en dia mes año
            list($dia, $mes, $ano) = split ('[/.-]', $fecha); 
            // Valida que la fecha sea valida
            $returnValue = checkdate($mes, $dia, $ano);
            if (!($returnValue)) {
                // En caso  de que la fecha no sea valida
                // Asigna al vector el campo y el error determindo
                if (!(isset($mensaje)) || empty($mensaje)) {
                    // Error del sistemas
                    $this->acumuladoErrores[$nombreCampo] = 'La fecha es invalida!';
                } else {
                    // error del usuario
                    $this->acumuladoErrores[$nombreCampo] = $mensaje;
                } 
            } 
        } 
        // Retorna TRUE o FALSE dependiendo el caso
        return $returnValue;
    } 
	
    /**
     * Validacion::multiple()
     * 
     * Realiza la validacion segun el arreglo de campos a validar que recibe por parametro,
     * $arregloCampos = array (
     * 			'nombrecampo' => array ( //nombre del campo
     * 			'fnc' => 'esEntero',	 //Metodo de validacion
     * 			'max' => 10,			 //Maximo de caracteres
     * 			'req' => true,			 //Si el campo es Obligatorio
     * 			'msg' => 'El Id ...'	 //Mensaje en caso de error [Opcional]
     * 		)
     * 
     * @param  $arregloCampos 
     * @return boolean 
     */
    function multiple($arregloCampos) {
        $returnValue = true;
        foreach ($arregloCampos as $campo => $opciones) {
			if (!isset($opciones['msg'])) {
				$opciones['msg'] = null;
			}
			
            $returnValue = 
				$this->$opciones['fnc']($this->objeto->$campo, $opciones['max'], $campo, $opciones['req'], $opciones['msg'])
				&&
				$returnValue
				;
        } 
        return $returnValue;
    } 

    /**
     * Validacion::huboError()
     * 
     * Retorna si hubo errores durante el proceso de validacion
     * 
     * @return boolean 
     */
    function huboError() {
        if (sizeof($this->acumuladoErrores) > 0) {
            return true;
        } else {
            return false;
        } 
    } 

    /**
     * Validacion::getErrores()
     * 
     * Retorna el arreglo con el acumulado de los errores, el arreglo es un arreglo
     * asociativo por el nombre del campo, con el mensaje de error.
     * 
     * @return array 
     */
    function getErrores() {
        return $this->acumuladoErrores;
    } 

    /**
     * Validacion::resetErrores()
     * 
     * Limpiar el arreglo acumulado de errores
     * 
     * @return void 
     */
    function resetErrores() {
        $this->acumuladoErrores = array();
    } 

    /**
     * Validacion::_Validacion()
     * Destructor de la clase
     * 
     * @return 
     */
    function _Validacion() {
        $this->acumuladoErrores = 0;
    } 
} 

?>
