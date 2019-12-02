CREATE UNIQUE INDEX "Banco PKX" ON Co_Banco ( 
  banco ASC 
);

ALTER TABLE Co_Banco 
ADD CONSTRAINT "Banco PK" PRIMARY KEY ( banco ) ;

CREATE UNIQUE INDEX "Convenio PKX" ON Co_Convenio ( 
  convenio ASC 
);

ALTER TABLE Co_Convenio 
ADD CONSTRAINT "Convenio PK" PRIMARY KEY ( convenio ) ;

CREATE UNIQUE INDEX "Cuenta PKX" ON Co_Cuenta ( 
  cuenta ASC 
);

ALTER TABLE Co_Cuenta 
ADD CONSTRAINT "Cuenta PK" PRIMARY KEY ( cuenta ) ;

CREATE UNIQUE INDEX "Dependencia PKX" ON Co_Dependencia ( 
  dependencia ASC 
);

ALTER TABLE Co_Dependencia 
ADD CONSTRAINT "Dependencia PK" PRIMARY KEY ( dependencia ) ;


CREATE UNIQUE INDEX "Distribucion PKX" ON Co_Distribucion ( 
  distribucion ASC 
);

ALTER TABLE Co_Distribucion 
ADD CONSTRAINT "Distribucion PK" PRIMARY KEY ( distribucion ) ;

CREATE UNIQUE INDEX "EstadoEstudiante PKX" ON Co_EstadoEstudiante ( 
  estadoEstudiante ASC 
);

ALTER TABLE Co_EstadoEstudiante 
ADD CONSTRAINT "EstadoEstudiante PK" PRIMARY KEY ( estadoEstudiante ) ;

CREATE UNIQUE INDEX "Estudiante PKX" ON Co_Estudiante ( 
  estudiante ASC 
);

ALTER TABLE Co_Estudiante 
ADD CONSTRAINT "Estudiante PK" PRIMARY KEY ( estudiante ) ;

CREATE UNIQUE INDEX "Materia PKX" ON Co_Materia ( 
  materia ASC 
);

ALTER TABLE Co_Materia 
ADD CONSTRAINT "Materia PK" PRIMARY KEY ( materia ) ;

CREATE UNIQUE INDEX Pago_PKX ON Co_Pago ( 
 pago ASC 
);

ALTER TABLE Co_Pago 
ADD CONSTRAINT Pago_PK PRIMARY KEY ( pago ) ;

CREATE UNIQUE INDEX Parametro_PKX ON Co_Parametro ( 
 parametro ASC 
);

ALTER TABLE Co_Parametro 
ADD CONSTRAINT Parametro_PK PRIMARY KEY ( parametro ) ;

CREATE UNIQUE INDEX "PeriodoAcademico PKX" ON Co_PeriodoAcademico ( 
  periodoAcademico ASC 
);

ALTER TABLE Co_PeriodoAcademico 
ADD CONSTRAINT "PeriodoAcademico PK" PRIMARY KEY ( periodoAcademico ) ;

CREATE UNIQUE INDEX "PlanPagos PKX" ON Co_PlanPagos ( 
  planPagos ASC 
);

ALTER TABLE Co_PlanPagos 
ADD CONSTRAINT "PlanPagos PK" PRIMARY KEY ( planPagos ) ;

CREATE UNIQUE INDEX PorcentajePagos_PKX ON Co_PorcentajePagos ( 
  porcentajePagos ASC 
);

ALTER TABLE Co_PorcentajePagos 
ADD CONSTRAINT PorcentajePagos_PK PRIMARY KEY ( porcentajePagos ) ;

CREATE UNIQUE INDEX "textoFormatoConvenio PKX" ON Co_TextoFormatoConvenio ( 
  textoFormatoConvenio ASC 
);

ALTER TABLE Co_TextoFormatoConvenio 
ADD CONSTRAINT "textoFormatoConvenio PK" PRIMARY KEY ( textoFormatoConvenio ) ;

CREATE UNIQUE INDEX "TipoLabor PKX" ON Co_TipoLabor ( 
  tipoLabor ASC 
);

ALTER TABLE Co_TipoLabor 
ADD CONSTRAINT "TipoLabor PK" PRIMARY KEY ( tipoLabor ) ;

CREATE UNIQUE INDEX "TipoMonitor PKX" ON Co_TipoMonitor ( 
  tipoMonitor ASC 
);

ALTER TABLE Co_TipoMonitor 
ADD CONSTRAINT "TipoMonitor PK" PRIMARY KEY ( tipoMonitor ) ;

CREATE UNIQUE INDEX TipoMonitorDependencia__IDXX ON Co_TipoMonitorDependencia ( 
  dependencia ASC , 
  tipoMonitor ASC 
);

ALTER TABLE Co_TipoMonitorDependencia 
ADD CONSTRAINT TipoMonitorDependencia__IDX PRIMARY KEY ( dependencia, tipoMonitor ) ;

CREATE SEQUENCE co_banco_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_banco_trg
  BEFORE INSERT ON co_banco FOR EACH ROW
BEGIN
  IF :NEW.banco IS NULL THEN
    SELECT co_banco_seq.NEXTVAL INTO :NEW.banco FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_convenio_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_convenio_trg
  BEFORE INSERT ON co_convenio FOR EACH ROW
BEGIN
  IF :NEW.convenio IS NULL THEN
    SELECT co_convenio_seq.NEXTVAL INTO :NEW.convenio FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_cuenta_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_cuenta_trg
  BEFORE INSERT ON co_cuenta FOR EACH ROW
BEGIN
  IF :NEW.cuenta IS NULL THEN
    SELECT co_cuenta_seq.NEXTVAL INTO :NEW.cuenta FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_distribucion_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_distribucion_trg
  BEFORE INSERT ON co_distribucion FOR EACH ROW
BEGIN
  IF :NEW.Distribucion IS NULL THEN
    SELECT co_distribucion_seq.NEXTVAL INTO :NEW.Distribucion FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_estudiante_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_estudiante_trg
  BEFORE INSERT ON co_estudiante FOR EACH ROW
BEGIN
  IF :NEW.Estudiante IS NULL THEN
    SELECT co_estudiante_seq.NEXTVAL INTO :NEW.Estudiante FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_materia_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_materia_trg
  BEFORE INSERT ON co_materia FOR EACH ROW
BEGIN
  IF :NEW.materia IS NULL THEN
    SELECT co_materia_seq.NEXTVAL INTO :NEW.materia FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_pago_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_pago_trg
  BEFORE INSERT ON co_pago FOR EACH ROW
BEGIN
  IF :NEW.pago IS NULL THEN
    SELECT co_pago_seq.NEXTVAL INTO :NEW.pago FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_parametro_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_parametro_trg
  BEFORE INSERT ON co_parametro FOR EACH ROW
BEGIN
  IF :NEW.parametro IS NULL THEN
    SELECT co_parametro_seq.NEXTVAL INTO :NEW.parametro FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_periodoAcademico_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_periodoAcademico_trg
  BEFORE INSERT ON co_periodoAcademico FOR EACH ROW
BEGIN
  IF :NEW.periodoAcademico IS NULL THEN
    SELECT co_periodoAcademico_seq.NEXTVAL INTO :NEW.periodoAcademico FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_planPagos_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_planPagos_trg
  BEFORE INSERT ON co_planPagos FOR EACH ROW
BEGIN
  IF :NEW.planPagos IS NULL THEN
    SELECT co_planPagos_seq.NEXTVAL INTO :NEW.planPagos FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_porcentajePagos_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_porcentajePagos_trg
  BEFORE INSERT ON co_porcentajePagos FOR EACH ROW
BEGIN
  IF :NEW.porcentajePagos IS NULL THEN
    SELECT co_porcentajePagos_seq.NEXTVAL INTO :NEW.porcentajePagos FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_TextoFormatoConvenio_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_TextoFormatoConvenio_trg
  BEFORE INSERT ON co_TextoFormatoConvenio FOR EACH ROW
BEGIN
  IF :NEW.TextoFormatoConvenio IS NULL THEN
    SELECT co_TextoFormatoConvenio_seq.NEXTVAL INTO :NEW.TextoFormatoConvenio FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_TipoLabor_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_TipoLabor_trg
  BEFORE INSERT ON co_TipoLabor FOR EACH ROW
BEGIN
  IF :NEW.TipoLabor IS NULL THEN
    SELECT co_TipoLabor_seq.NEXTVAL INTO :NEW.TipoLabor FROM DUAL;
  END IF;
END;
/

CREATE SEQUENCE co_TipoMonitor_seq START WITH 100 INCREMENT BY 1 NOCACHE;

CREATE OR REPLACE TRIGGER co_TipoMonitor_trg
  BEFORE INSERT ON co_TipoMonitor FOR EACH ROW
BEGIN
  IF :NEW.TipoMonitor IS NULL THEN
    SELECT co_TipoMonitor_seq.NEXTVAL INTO :NEW.TipoMonitor FROM DUAL;
  END IF;
END;
/
