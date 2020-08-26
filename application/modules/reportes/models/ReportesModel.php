<?php
class ReportesModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function idPersonaUsuario()
    {
        $session_data = $this->session->userdata('logged_in');
        $id = $session_data['ID_USUARIO'];

        $result = $this->db->query('SELECT P.ID_PERSONA FROM Persona P JOIN Usuario U ON P.ID_PERSONA = U.ID_PERSONA WHERE U.ID_USUARIO =' . '"' . $id . '"');

        $idPersona = $result->row()->ID_PERSONA;

        return $idPersona;
    }

    public function reporteHogar()
    {
        $idPersona = $this->idPersonaUsuario();

        $result = $this->db->query('SELECT H.ID_HOGAR, H.SUMINISTRO_ELEC, PO.NOMBRE nProvincia, PO.ID_PROVINCIA, CA.NOMBRE nCanton, CA.ID_CANTON, PA.NOMBRE nParroquia, PA.ID_PARROQUIA, U.DIRECCION, H.CALEFON, H.COCINA, H.SECADORA FROM Hogar H LEFT JOIN Rel_Hogar_Elec RHE ON H.ID_HOGAR = RHE.ID_HOGAR LEFT JOIN Rel_Hogar_Persona RHP ON RHP.ID_HOGAR = H.ID_HOGAR LEFT JOIN Ubicacion U ON H.ID_UBICACION = U.ID_UBICACION LEFT JOIN Canton CA ON U.CANTON = CA.ID_CANTON LEFT JOIN Provincia PO ON PO.ID_PROVINCIA = U.PROVINCIA LEFT JOIN Parroquia PA ON PA.ID_PARROQUIA = U.PARROQUIA WHERE RHP.ID_PERSONA = ' . '"' . $idPersona . '"' . ' UNION SELECT H.ID_HOGAR, H.SUMINISTRO_ELEC, PO.NOMBRE, PO.ID_PROVINCIA, CA.NOMBRE, CA.ID_CANTON, PA.NOMBRE, PA.ID_PARROQUIA, U.DIRECCION, H.CALEFON, H.COCINA, H.SECADORA FROM Hogar H RIGHT JOIN Rel_Hogar_Elec RHE ON H.ID_HOGAR = RHE.ID_HOGAR RIGHT JOIN Rel_Hogar_Persona RHP ON RHP.ID_HOGAR = H.ID_HOGAR RIGHT JOIN Ubicacion U ON H.ID_UBICACION = U.ID_UBICACION RIGHT JOIN Canton CA ON U.CANTON = CA.ID_CANTON RIGHT JOIN Provincia PO ON PO.ID_PROVINCIA = U.PROVINCIA RIGHT JOIN Parroquia PA ON PA.ID_PARROQUIA = U.PARROQUIA WHERE RHP.ID_PERSONA = ' . '"' . $idPersona . '"' . '');

        return $result->result();
    }

    public function reportePersonaActiva()
    {
        $idPersona = $this->idPersonaUsuario();

        $idHogarResult = $this->db->query('SELECT ID_HOGAR FROM Rel_Hogar_Persona WHERE ID_PERSONA = ' . $idPersona . '');

        $idHogar = $idHogarResult->row()->ID_HOGAR;

        $result = $this->db->query('SELECT P.ID_PERSONA, P.NOMBRE, P.IDENTIFICACION, P.FECHA_NACIMIENTO, T.DESCRIPCION, R.ESTADO, T.ID_TIPO_PERSONA, R.ID_HOGAR FROM Persona P JOIN Rel_Hogar_Persona R ON P.ID_PERSONA = R.ID_PERSONA JOIN Tipo_Persona T ON P.ID_TIPO_PERSONA = T.ID_TIPO_PERSONA WHERE R.ESTADO = 1 AND R.ID_HOGAR =' . '"' . $idHogar . '"');

        return $result->result();
    }

    public function reportePersonaInactiva()
    {
        $idPersona = $this->idPersonaUsuario();

        $idHogarResult = $this->db->query('SELECT ID_HOGAR FROM Rel_Hogar_Persona WHERE ID_PERSONA = ' . $idPersona . '');

        $idHogar = $idHogarResult->row()->ID_HOGAR;

        $result = $this->db->query('SELECT P.ID_PERSONA, P.NOMBRE, P.IDENTIFICACION, P.FECHA_NACIMIENTO, R.ESTADO, R.ID_HOGAR FROM Persona P JOIN Rel_Hogar_Persona R ON P.ID_PERSONA = R.ID_PERSONA WHERE R.ESTADO = 0 AND R.ID_HOGAR =' . '"' . $idHogar . '"');

        return $result->result();
    }

}
