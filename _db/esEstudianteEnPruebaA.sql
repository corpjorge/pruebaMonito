CREATE OR REPLACE FUNCTION esEstudianteEnPruebaA ( e_term_code IN VARCHAR2
                                        ,e_id        IN VARCHAR2 )
RETURN VARCHAR2
IS
    CURSOR prac_C IS
    SELECT sgbstdn_astd_code        stdn_astd
          ,sgbstdn_term_code_eff    term_eff
          ,sgbstdn_term_code_astd   term_astd
          ,tt_ttrm.astd_code        ttrm_astd
      FROM SPRIDEN
          ,SORLCUR p1
          ,SGBSTDN
          ,(SELECT shrttrm_pidm                   pidm
                  ,shrttrm_astd_code_end_of_term  astd_code
              FROM SHRTTRM t1
             WHERE shrttrm_term_code =
                   (SELECT MAX(shrttrm_term_code)
                      FROM SHRTTRM
                     WHERE shrttrm_pidm      = t1.shrttrm_pidm
                       AND shrttrm_term_code < E_TERM_CODE
                   )
           ) tt_ttrm
     WHERE spriden_change_ind   IS NULL
       AND spriden_id           = E_ID
       AND spriden_pidm         = sgbstdn_pidm
       AND sgbstdn_term_code_eff    =
           (SELECT max(sgbstdn_term_code_eff)
              FROM SGBSTDN
             WHERE sgbstdn_term_code_eff <= E_TERM_CODE
               AND sgbstdn_pidm          = spriden_pidm
           )
       AND spriden_pidm         = tt_ttrm.pidm (+)
       AND p1.rowid             = f_get_program_1_rowid(spriden_pidm,E_TERM_CODE)
       AND p1.sorlcur_levl_code = 'PR';
    
    v_prac      VARCHAR2(1);
    r_prac      prac_c%ROWTYPE;
    
BEGIN
    OPEN  prac_C;
    FETCH prac_C INTO r_prac;
    CLOSE prac_C;
    
    IF     r_prac.term_eff  = E_TERM_CODE 
       AND r_prac.term_astd = E_TERM_CODE
       AND r_prac.stdn_astd IN ('PA','PR','TR','PI') THEN
       
        v_prac := 'S';
        
    ELSIF r_prac.ttrm_astd = 'PA' THEN
        v_prac := 'S';
        
    ELSE
        v_prac := 'N';
    END IF;
    
    RETURN NVL(v_prac,'N');
    
    EXCEPTION
    WHEN OTHERS THEN
        RETURN 'N';

END esEstudianteEnPruebaA;
/