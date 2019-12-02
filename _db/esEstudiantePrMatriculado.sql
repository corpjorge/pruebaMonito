CREATE OR REPLACE FUNCTION esEstudiantePrMatriculado ( e_term_code IN VARCHAR2
                                          ,e_id        IN VARCHAR2 )
RETURN VARCHAR2
IS
    CURSOR matr_C IS
    SELECT DECODE(sfbetrm_ar_ind,'C','S','N')
      FROM SFBETRM
          ,SPRIDEN
          ,SORLCUR p1
     WHERE spriden_change_ind   IS NULL
       AND spriden_id           = E_ID
       AND spriden_pidm         = sfbetrm_pidm
       AND sfbetrm_term_code    = E_TERM_CODE
       AND p1.rowid             = f_get_program_1_rowid(sfbetrm_pidm,sfbetrm_term_code)
       AND p1.sorlcur_levl_code = 'PR';
    
    v_matr      VARCHAR2(1);
    
BEGIN
    OPEN  matr_C;
    FETCH matr_C INTO v_matr;
    CLOSE matr_C;
    
    RETURN NVL(v_matr,'N');
    
    EXCEPTION
    WHEN OTHERS THEN
        RETURN 'N';

END esEstudiantePrMatriculado;
/