CREATE INDEX BancoCuentaX ON Co_Cuenta ( 
  banco ASC 
);

CREATE INDEX ConvenioCuentaX ON Co_Cuenta ( 
  convenio ASC 
);

CREATE INDEX ConvenioEstudianteX ON Co_Convenio ( 
  estudiante ASC 
);

CREATE INDEX PeriodoAcademicoConvenioX ON Co_Convenio ( 
  periodoAcademico ASC 
);

CREATE INDEX TipoLaborConvenioX ON Co_Convenio ( 
  tipoLabor ASC 
);

CREATE INDEX TipoMonitorConvenioX ON Co_Convenio  ( 
  tipoMonitor ASC 
);

CREATE INDEX DependConvenioX ON Co_Convenio ( 
  dependencia ASC 
);

CREATE INDEX Depend_Depend_FKX ON Co_Dependencia ( 
  dependenciaPadre ASC 
);

CREATE INDEX DistribucionConvenioX ON Co_Distribucion ( 
  convenio ASC 
);

CREATE INDEX EstadoEstudianteX ON Co_Estudiante ( 
 estadoEstudiante ASC 
);

CREATE INDEX CiudadEstudianteX ON Co_Estudiante ( 
  ciudad ASC 
);

CREATE INDEX DeptoEstudianteX ON Co_Estudiante ( 
  departamento ASC 
);

CREATE INDEX PaisEstudianteX ON Co_Estudiante ( 
  pais ASC 
);

CREATE INDEX TipoDocEstudianteX ON Co_Estudiante ( 
  tipoDocumento ASC 
);

CREATE INDEX ConvenioMateriaX ON Co_Materia ( 
  convenio ASC 
);

CREATE INDEX PagoConvenioX ON Co_Pago ( 
  convenio ASC 
);

CREATE INDEX PagoPorcentajeX ON Co_Pago ( 
  porcentajePagos ASC 
);

CREATE INDEX PlanPagosPeriodoAcademicoX ON Co_PlanPagos ( 
  periodoAcademico ASC 
);

CREATE INDEX PorcentajesPlanPagosX ON Co_PorcentajePagos ( 
  planPagos ASC 
);

CREATE INDEX textoFormatoPeriodoX ON Co_TextoFormatoConvenio ( 
  periodoAcademico ASC 
);

CREATE INDEX TipoMonitorTipoLaborX ON Co_TipoLabor ( 
  tipoMonitor ASC 
);

CREATE INDEX FK_ASS_23X ON Co_TipoMonitorDependencia ( 
  dependencia ASC 
);

CREATE INDEX FK_ASS_24X ON Co_TipoMonitorDependencia ( 
  tipoMonitor ASC 
);

ALTER TABLE Co_Cuenta 
ADD CONSTRAINT BancoCuenta FOREIGN KEY ( banco ) 
REFERENCES Co_Banco ( banco ) 
NOT DEFERRABLE;

ALTER TABLE Co_Cuenta 
ADD CONSTRAINT ConvenioCuenta FOREIGN KEY ( convenio ) 
REFERENCES Co_Convenio ( convenio ) 
NOT DEFERRABLE;

ALTER TABLE Co_Estudiante 
ADD CONSTRAINT CDPEstudiante FOREIGN KEY ( ciudad, departamento, pais ) 
REFERENCES G_Ciudad ( ciudad, departamento, pais ) 
NOT DEFERRABLE;

ALTER TABLE Co_Convenio 
ADD CONSTRAINT ConvenioEstudiante FOREIGN KEY ( estudiante ) 
REFERENCES Co_Estudiante ( estudiante ) 
NOT DEFERRABLE;

ALTER TABLE Co_Materia 
ADD CONSTRAINT ConvenioMateria FOREIGN KEY ( convenio ) 
REFERENCES Co_Convenio ( convenio ) 
ON DELETE SET NULL 
NOT DEFERRABLE;

ALTER TABLE Co_Convenio 
ADD CONSTRAINT DependConvenio FOREIGN KEY ( dependencia ) 
REFERENCES Co_Dependencia ( dependencia ) 
NOT DEFERRABLE;

ALTER TABLE Co_Dependencia 
ADD CONSTRAINT Depend_Depend_FK FOREIGN KEY ( dependenciaPadre ) 
REFERENCES Co_Dependencia ( dependencia ) 
NOT DEFERRABLE;

ALTER TABLE Co_Distribucion 
ADD CONSTRAINT DistribucionConvenio FOREIGN KEY ( convenio ) 
REFERENCES Co_Convenio ( convenio ) 
NOT DEFERRABLE;

ALTER TABLE Co_Estudiante 
ADD CONSTRAINT EstadoEstudiante FOREIGN KEY ( estadoEstudiante ) 
REFERENCES Co_EstadoEstudiante ( estadoEstudiante ) 
ON DELETE SET NULL 
NOT DEFERRABLE;

ALTER TABLE Co_TipoMonitorDependencia 
ADD CONSTRAINT FK_ASS_23 FOREIGN KEY ( dependencia ) 
REFERENCES Co_Dependencia ( dependencia ) 
ON DELETE CASCADE 
NOT DEFERRABLE;

ALTER TABLE Co_TipoMonitorDependencia 
ADD CONSTRAINT FK_ASS_24 FOREIGN KEY ( tipoMonitor ) 
REFERENCES Co_TipoMonitor ( tipoMonitor ) 
ON DELETE CASCADE 
NOT DEFERRABLE;

ALTER TABLE Co_Pago 
ADD CONSTRAINT PagoConvenio FOREIGN KEY ( convenio ) 
REFERENCES Co_Convenio ( convenio ) 
NOT DEFERRABLE;

ALTER TABLE Co_Pago 
ADD CONSTRAINT PagoPorcentaje FOREIGN KEY ( porcentajePagos ) 
REFERENCES Co_PorcentajePagos ( porcentajePagos ) 
NOT DEFERRABLE;

ALTER TABLE Co_Convenio 
ADD CONSTRAINT PeriodoAcademicoConvenio FOREIGN KEY ( periodoAcademico ) 
REFERENCES Co_PeriodoAcademico ( periodoAcademico ) 
NOT DEFERRABLE;

ALTER TABLE Co_PlanPagos 
ADD CONSTRAINT PlanPagosPeriodoAcademico FOREIGN KEY ( periodoAcademico ) 
REFERENCES Co_PeriodoAcademico ( periodoAcademico ) 
NOT DEFERRABLE;

ALTER TABLE Co_PorcentajePagos 
ADD CONSTRAINT PorcentajesPlanPagos FOREIGN KEY ( planPagos ) 
REFERENCES Co_PlanPagos ( planPagos ) 
NOT DEFERRABLE;

ALTER TABLE Co_Estudiante 
ADD CONSTRAINT TipoDocEstudiante FOREIGN KEY ( tipoDocumento ) 
REFERENCES G_TipoDocumento ( tipoDocumento ) 
NOT DEFERRABLE;

ALTER TABLE Co_Convenio 
ADD CONSTRAINT TipoLaborConvenio FOREIGN KEY ( tipoLabor ) 
REFERENCES Co_TipoLabor ( tipoLabor ) 
NOT DEFERRABLE;

ALTER TABLE Co_Convenio 
ADD CONSTRAINT TipoMonitorConvenio FOREIGN KEY ( tipoMonitor ) 
REFERENCES Co_TipoMonitor ( tipoMonitor ) 
NOT DEFERRABLE;

ALTER TABLE Co_TipoLabor 
ADD CONSTRAINT TipoMonitorTipoLabor FOREIGN KEY ( tipoMonitor ) 
REFERENCES Co_TipoMonitor ( tipoMonitor ) 
NOT DEFERRABLE;

ALTER TABLE Co_TextoFormatoConvenio 
ADD CONSTRAINT textoFormatoPeriodo FOREIGN KEY ( periodoAcademico ) 
REFERENCES Co_PeriodoAcademico ( periodoAcademico ) 
NOT DEFERRABLE;
