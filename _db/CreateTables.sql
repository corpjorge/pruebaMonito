CREATE TABLE Co_Banco ( 
  banco VARCHAR2 (8 CHAR)  NOT NULL , 
  nombre VARCHAR2 (200 CHAR)  NOT NULL, 
  pais VARCHAR2 (8 CHAR)  NOT NULL
) LOGGING;

CREATE TABLE Co_Convenio ( 
  convenio NUMBER  NOT NULL , 
  fechaInicio DATE  NOT NULL , 
  fechaFin DATE  NOT NULL , 
  estudiante NUMBER  NOT NULL , 
  dependencia NUMBER  NOT NULL , 
  tipoMonitor NUMBER  NOT NULL , 
  tipoLabor NUMBER  NOT NULL , 
  periodoAcademico NUMBER  NOT NULL , 
  valorHora NUMBER , 
  horasSemanales INTEGER , 
  descripcion VARCHAR2 (4000 CHAR) , 
  estado VARCHAR2 (4 CHAR) NOT NULL, 
  consecutivo NUMBER NOT NULL
) LOGGING;

CREATE TABLE Co_Cuenta ( 
  cuenta NUMBER  NOT NULL , 
  convenio NUMBER  NOT NULL , 
  tipoCuenta VARCHAR2 (50 CHAR)  NOT NULL , 
  numeroCuenta VARCHAR2 (100 CHAR)  NOT NULL , 
  banco VARCHAR2 (8 CHAR) NOT NULL 
) LOGGING;

CREATE TABLE Co_Dependencia ( 
  dependencia VARCHAR2 (8 CHAR) NOT NULL , 
  nombre VARCHAR2 (150 CHAR)  NOT NULL , 
  dependenciaPadre VARCHAR2 (8 CHAR)
) LOGGING;

CREATE TABLE Co_Distribucion ( 
  distribucion NUMBER  NOT NULL , 
  fondoPresupuestal VARCHAR2 (100 CHAR)  NOT NULL , 
  porcentaje NUMBER (8,3)  NOT NULL , 
  objetoCosto VARCHAR2 (200 CHAR)  NOT NULL , 
  convenio NUMBER  NOT NULL , 
  tipoObjeto VARCHAR2 (200 CHAR) 
) LOGGING;

CREATE TABLE Co_EstadoEstudiante ( 
  estadoEstudiante VARCHAR2 (2 CHAR)  NOT NULL , 
  nombre VARCHAR2 (100 CHAR)  NOT NULL , 
  descripcion VARCHAR2 (1000), 
  activo VARCHAR2 (2) 
) LOGGING;

CREATE TABLE Co_Estudiante ( 
  estudiante NUMBER  NOT NULL , 
  nombres VARCHAR2 (250 CHAR)  NOT NULL , 
  apellidos VARCHAR2 (250 CHAR)  NOT NULL , 
  direccion VARCHAR2 (250 CHAR)  NOT NULL , 
  telefono VARCHAR2 (50 CHAR)  NOT NULL , 
  email VARCHAR2 (100 CHAR)  NOT NULL , 
  genero VARCHAR2 (1 CHAR)  NOT NULL , 
  expedicionDoc VARCHAR2 (100 CHAR)  NOT NULL , 
  codigo VARCHAR2 (16 CHAR)  NOT NULL , 
  documento VARCHAR2 (16 CHAR)  NOT NULL , 
  estadoEstudiante VARCHAR2 (2 CHAR) , 
  tipoDocumento NUMBER  NOT NULL, 
  ciudad VARCHAR2 (8 CHAR)  NOT NULL , 
  departamento VARCHAR2 (8 CHAR)  NOT NULL , 
  pais VARCHAR2 (8 CHAR)  NOT NULL  
) LOGGING;

CREATE TABLE Co_Materia ( 
  materia NUMBER  NOT NULL , 
  curso VARCHAR2 (100 CHAR)  NOT NULL , 
  convenio NUMBER , 
  crn INTEGER  NOT NULL , 
  nombre VARCHAR2 (500 CHAR)  NOT NULL, 
  valorHora NUMBER NOT NULL, 
  horasSemanales INTEGER NOT NULL 
) LOGGING;

CREATE TABLE Co_Pago ( 
  pago NUMBER  NOT NULL , 
  valor NUMBER (8,3) NOT NULL , 
  convenio NUMBER  NOT NULL , 
  porcentajePagos NUMBER NOT NULL 
) LOGGING;

CREATE TABLE Co_Parametro ( 
  parametro NUMBER  NOT NULL , 
  nombre VARCHAR2 (128 CHAR)  NOT NULL , 
  descripcion VARCHAR2 (1024 CHAR)  ,
  valor VARCHAR2 (256 CHAR)  NOT NULL 
) LOGGING;

CREATE TABLE Co_PeriodoAcademico ( 
  periodoAcademico NUMBER  NOT NULL , 
  fechaInicio DATE  NOT NULL , 
  fechaFin DATE  NOT NULL , 
  fechaInicioReceso DATE  NOT NULL , 
  fechaFinReceso DATE  NOT NULL , 
  minHoras INTEGER  NOT NULL , 
  maxHoras INTEGER  NOT NULL , 
  periodoSemestre VARCHAR2 (50 CHAR)  NOT NULL , 
  minValorHora NUMBER  NOT NULL , 
  maxValorHora NUMBER  NOT NULL , 
  fechaLimite DATE 
) LOGGING;

CREATE TABLE Co_PlanPagos ( 
  planPagos NUMBER  NOT NULL , 
  nombre VARCHAR2 (150 CHAR)  NOT NULL , 
  periodoAcademico NUMBER  NOT NULL, 
  aplicaFechaLimite VARCHAR2 (1 CHAR)  
) LOGGING;

CREATE TABLE Co_PorcentajePagos ( 
  porcentajePagos NUMBER  NOT NULL , 
  posicion INTEGER  NOT NULL , 
  porcentaje NUMBER (8,3)  NOT NULL , 
  planPagos NUMBER  NOT NULL, 
  fecha DATE NOT NULL
) LOGGING;

CREATE TABLE Co_TextoFormatoConvenio ( 
  textoFormatoConvenio NUMBER  NOT NULL , 
  texto VARCHAR2 (4000 CHAR)  NOT NULL , 
  etiqueta VARCHAR2 (50 CHAR)  NOT NULL , 
  periodoAcademico NUMBER  NOT NULL 
) LOGGING;

CREATE TABLE Co_TipoLabor ( 
  tipoLabor NUMBER  NOT NULL , 
  descripcion VARCHAR2 (4000 CHAR)  NOT NULL , 
  nombre VARCHAR2 (200 CHAR)  NOT NULL , 
  tipoMonitor NUMBER  NOT NULL, 
  labor VARCHAR2 (4 CHAR)  NOT NULL 
) LOGGING;

CREATE TABLE Co_TipoMonitor ( 
  tipoMonitor NUMBER  NOT NULL , 
  nombre VARCHAR2 (150 CHAR)  NOT NULL , 
  minValorHora NUMBER , 
  maxValorHora NUMBER 
) LOGGING;

CREATE TABLE Co_TipoMonitorDependencia ( 
  dependencia NUMBER  NOT NULL , 
  tipoMonitor NUMBER  NOT NULL 
) LOGGING;

CREATE TABLE G_UsuarioObjetoCosto ( 
  modulo VARCHAR (16 CHAR) NOT NULL , 
  usuario VARCHAR (128 CHAR)  NOT NULL, 
  objetocosto VARCHAR (32 CHAR) NOT NULL , 
  descripcion VARCHAR (512 CHAR)  NOT NULL, 
  tipo VARCHAR (16 CHAR) NOT NULL , 
  estado VARCHAR (4 CHAR)  NOT NULL 
) LOGGING;

