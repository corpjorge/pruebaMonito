CREATE OR REPLACE FUNCTION esEstudianteEnPruebaD ( e_term_code IN VARCHAR2
                                            ,e_id        IN VARCHAR2 )
RETURN VARCHAR2
IS
    CURSOR prds_C IS
    SELECT 'S'
      FROM SPRHOLD
          ,SPRIDEN
          ,SORLCUR p1
     WHERE spriden_change_ind   IS NULL
       AND spriden_id           = E_ID
       AND sprhold_pidm         = spriden_pidm
       AND sprhold_hldd_code    IN ('01','02','17')
       AND sprhold_from_date    <= SYSDATE
       AND SYSDATE              <= sprhold_to_date
       AND p1.rowid             = f_get_program_1_rowid(spriden_pidm,E_TERM_CODE)
       AND p1.sorlcur_levl_code = 'PR';
    
    v_prds      VARCHAR2(1);
    
BEGIN
    OPEN  prds_C;
    FETCH prds_C INTO v_prds;
    CLOSE prds_C;
    
    RETURN NVL(v_prds,'N');
    
    EXCEPTION
    WHEN OTHERS THEN
        RETURN 'N';

END esEstudianteEnPruebaD;
/