DROP INDEX "Banco PKX";

ALTER TABLE Co_Banco 
DROP CONSTRAINT "Banco PK";

DROP INDEX "Convenio PKX";

ALTER TABLE Co_Convenio 
DROP CONSTRAINT "Convenio PK";

DROP INDEX "Cuenta PKX";

ALTER TABLE Co_Cuenta 
DROP CONSTRAINT "Cuenta PK";

DROP INDEX "Dependencia PKX";

ALTER TABLE Co_Dependencia 
DROP CONSTRAINT "Dependencia PK";

DROP INDEX "Distribucion PKX";

ALTER TABLE Co_Distribucion 
DROP CONSTRAINT "Distribucion PK";

DROP INDEX "EstadoEstudiante PKX";

ALTER TABLE Co_EstadoEstudiante 
DROP CONSTRAINT "EstadoEstudiante PK";

DROP INDEX "Estudiante PKX";

ALTER TABLE Co_Estudiante 
DROP CONSTRAINT "Estudiante PK";

DROP INDEX "Materia PKX";

ALTER TABLE Co_Materia 
DROP CONSTRAINT "Materia PK";

DROP INDEX Pago_PKX;

ALTER TABLE Co_Pago 
DROP CONSTRAINT Pago_PK;

DROP INDEX "PeriodoAcademico PKX";

ALTER TABLE Co_PeriodoAcademico 
DROP CONSTRAINT "PeriodoAcademico PK";

DROP INDEX "PlanPagos PKX";

ALTER TABLE Co_PlanPagos 
DROP CONSTRAINT "PlanPagos PK";

DROP INDEX PorcentajePagos_PKX;

ALTER TABLE Co_PorcentajePagos 
DROP CONSTRAINT PorcentajePagos_PK;

DROP INDEX "textoFormatoConvenio PKX";

ALTER TABLE Co_TextoFormatoConvenio 
DROP CONSTRAINT "textoFormatoConvenio PK";

DROP INDEX "TipoLabor PKX";

ALTER TABLE Co_TipoLabor 
DROP CONSTRAINT "TipoLabor PK";

DROP INDEX "TipoMonitor PKX";

ALTER TABLE Co_TipoMonitor 
DROP CONSTRAINT "TipoMonitor PK";

DROP INDEX TipoMonitorDependencia__IDXX;

ALTER TABLE Co_TipoMonitorDependencia 
DROP CONSTRAINT TipoMonitorDependencia__IDX;

DROP SEQUENCE co_banco_seq ;

DROP TRIGGER co_banco_trg;

DROP SEQUENCE co_convenio_seq ;

DROP TRIGGER co_convenio_trg;

DROP SEQUENCE co_cuenta_seq ;

DROP TRIGGER co_cuenta_trg;

DROP SEQUENCE co_distribucion_seq ;

DROP TRIGGER co_distribucion_trg;

DROP SEQUENCE co_estudiante_seq ;

DROP TRIGGER co_estudiante_trg;

DROP SEQUENCE co_materia_seq ;

DROP TRIGGER co_materia_trg;

DROP SEQUENCE co_pago_seq ;

DROP TRIGGER co_pago_trg;

DROP SEQUENCE co_periodoAcademico_seq ;

DROP TRIGGER co_periodoAcademico_trg;

DROP SEQUENCE co_planPagos_seq ;

DROP TRIGGER co_planPagos_trg;

DROP SEQUENCE co_porcentajePagos_seq ;

DROP TRIGGER co_porcentajePagos_trg;

DROP SEQUENCE co_TextoFormatoConvenio_seq ;

DROP TRIGGER co_TextoFormatoConvenio_trg;

DROP SEQUENCE co_TipoLabor_seq ;

DROP TRIGGER co_TipoLabor_trg;

DROP SEQUENCE co_TipoMonitor_seq ;

DROP TRIGGER co_TipoMonitor_trg;

