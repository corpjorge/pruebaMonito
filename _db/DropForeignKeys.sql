DROP INDEX BancoCuentaX;

DROP INDEX ConvenioCuentaX;

DROP INDEX ConvenioEstudianteX;

DROP INDEX PeriodoAcademicoConvenioX;

DROP INDEX TipoLaborConvenioX;

DROP INDEX TipoMonitorConvenioX;

DROP INDEX DependConvenioX;

DROP INDEX Depend_Depend_FKX;

DROP INDEX DistribucionConvenioX;

DROP INDEX EstadoEstudianteX;

DROP INDEX CiudadEstudianteX;

DROP INDEX DeptoEstudianteX;

DROP INDEX PaisEstudianteX;

DROP INDEX TipoDocEstudianteX;

DROP INDEX ConvenioMateriaX;

DROP INDEX PagoConvenioX;

DROP INDEX PagoPorcentajeX;

DROP INDEX PlanPagosPeriodoAcademicoX;

DROP INDEX PorcentajesPlanPagosX;

DROP INDEX textoFormatoPeriodoX;

DROP INDEX TipoMonitorTipoLaborX;

DROP INDEX FK_ASS_23X;

DROP INDEX FK_ASS_24X;

ALTER TABLE Co_Cuenta
DROP CONSTRAINT BancoCuenta;

ALTER TABLE Co_Cuenta
DROP CONSTRAINT ConvenioCuenta;

ALTER TABLE Co_Estudiante 
DROP CONSTRAINT CDPEstudiante;

ALTER TABLE Co_Convenio 
DROP CONSTRAINT ConvenioEstudiante;

ALTER TABLE Co_Materia 
DROP CONSTRAINT ConvenioMateria;

ALTER TABLE Co_Convenio 
DROP CONSTRAINT DependConvenio;

ALTER TABLE Co_Dependencia 
DROP CONSTRAINT Depend_Depend_FK;

ALTER TABLE Co_Distribucion 
DROP CONSTRAINT DistribucionConvenio;

ALTER TABLE Co_Estudiante 
DROP CONSTRAINT EstadoEstudiante;

ALTER TABLE Co_TipoMonitorDependencia 
DROP CONSTRAINT FK_ASS_23;

ALTER TABLE Co_TipoMonitorDependencia 
DROP CONSTRAINT FK_ASS_24;

ALTER TABLE Co_Pago 
DROP CONSTRAINT PagoConvenio;

ALTER TABLE Co_Pago 
DROP CONSTRAINT PagoPorcentaje;

ALTER TABLE Co_Convenio 
DROP CONSTRAINT PeriodoAcademicoConvenio;

ALTER TABLE Co_PlanPagos 
DROP CONSTRAINT PlanPagosPeriodoAcademico;

ALTER TABLE Co_PorcentajePagos 
DROP CONSTRAINT PorcentajesPlanPagos;

ALTER TABLE Co_Estudiante 
DROP CONSTRAINT TipoDocEstudiante;

ALTER TABLE Co_Convenio 
DROP CONSTRAINT TipoLaborConvenio;

ALTER TABLE Co_Convenio 
DROP CONSTRAINT TipoMonitorConvenio;

ALTER TABLE Co_TipoLabor 
DROP CONSTRAINT TipoMonitorTipoLabor;

ALTER TABLE Co_TextoFormatoConvenio 
DROP CONSTRAINT textoFormatoPeriodo;
