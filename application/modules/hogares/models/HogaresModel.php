<?php
class HogaresModel extends CI_Model
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

    public function idHogar()
    {
        $session_data = $this->session->userdata('logged_in');
        $id = $session_data['ID_USUARIO'];

        $result = $this->db->query('SELECT R.ID_HOGAR FROM Persona P JOIN Usuario U ON P.ID_PERSONA = U.ID_PERSONA JOIN Rel_Hogar_Persona R ON R.ID_PERSONA = P.ID_PERSONA WHERE R.ESTADO = 1 AND U.ID_USUARIO =' . '"' . $id . '"');

        $idHogar = $result->row()->ID_HOGAR;

        return $idHogar;
    }

    public function showHogar()
    {
        $idPersona = $this->idPersonaUsuario();

        $result = $this->db->query('SELECT H.ID_HOGAR, H.SUMINISTRO_ELEC, PO.NOMBRE nProvincia, PO.ID_PROVINCIA, CA.NOMBRE nCanton, CA.ID_CANTON, PA.NOMBRE nParroquia, PA.ID_PARROQUIA, U.DIRECCION, H.CALEFON, H.COCINA, H.SECADORA FROM Hogar H LEFT JOIN Rel_Hogar_Elec RHE ON H.ID_HOGAR = RHE.ID_HOGAR LEFT JOIN Rel_Hogar_Persona RHP ON RHP.ID_HOGAR = H.ID_HOGAR LEFT JOIN Ubicacion U ON H.ID_UBICACION = U.ID_UBICACION LEFT JOIN Canton CA ON U.CANTON = CA.ID_CANTON LEFT JOIN Provincia PO ON PO.ID_PROVINCIA = U.PROVINCIA LEFT JOIN Parroquia PA ON PA.ID_PARROQUIA = U.PARROQUIA WHERE RHP.ID_PERSONA = ' . '"' . $idPersona . '"' . ' UNION SELECT H.ID_HOGAR, H.SUMINISTRO_ELEC, PO.NOMBRE, PO.ID_PROVINCIA, CA.NOMBRE, CA.ID_CANTON, PA.NOMBRE, PA.ID_PARROQUIA, U.DIRECCION, H.CALEFON, H.COCINA, H.SECADORA FROM Hogar H RIGHT JOIN Rel_Hogar_Elec RHE ON H.ID_HOGAR = RHE.ID_HOGAR RIGHT JOIN Rel_Hogar_Persona RHP ON RHP.ID_HOGAR = H.ID_HOGAR RIGHT JOIN Ubicacion U ON H.ID_UBICACION = U.ID_UBICACION RIGHT JOIN Canton CA ON U.CANTON = CA.ID_CANTON RIGHT JOIN Provincia PO ON PO.ID_PROVINCIA = U.PROVINCIA RIGHT JOIN Parroquia PA ON PA.ID_PARROQUIA = U.PARROQUIA WHERE RHP.ID_PERSONA = ' . '"' . $idPersona . '"' . '');

        return $result->result();
    }

    public function showProvincia()
    {
        $result = $this->db->query('SELECT * FROM Provincia');

        return $result->result();
    }
    public function showCanton()
    {
        $idProvincia = $this->input->post('provincia');

        $result = $this->db->query('SELECT * FROM Canton WHERE ID_PROVINCIA =' . $idProvincia . ' ');

        return $result->result();
    }
    public function showParroquia()
    {
        $idCanton = $this->input->post('canton');

        $result = $this->db->query('SELECT * FROM Parroquia WHERE ID_CANTON =' . $idCanton . ' ');

        return $result->result();
    }
    public function showCanton1()
    {
        $result = $this->db->query('SELECT * FROM Canton');
        return $result->result();
    }
    public function showParroquia1()
    {
        $result = $this->db->query('SELECT * FROM Parroquia');

        return $result->result();
    }

    public function registrarHogar()
    {
        $hogar = $this->input->post('hogar');
        $suministro = $this->input->post('suministro');
        $provincia = $this->input->post('provincia');
        $canton = $this->input->post('canton');
        $parroquia = $this->input->post('parroquia');
        $direccion = $this->input->post('direccion');
        $calefon = $this->input->post('calefon');
        $cocina = $this->input->post('cocina');
        $secadora = $this->input->post('secadora');

        $ubicacionResult = $this->db->query('SELECT ID_UBICACION FROM Hogar WHERE ID_HOGAR = '.$hogar.' ');
        $idUbicacion = $ubicacionResult->row()->ID_UBICACION;
        $result = $this->db->query('UPDATE Hogar SET SUMINISTRO_ELEC = ' . '"' . $suministro . '", CALEFON = ' . '"' . $calefon . '", COCINA = ' . '"' . $cocina . '", SECADORA = ' . '"' . $secadora . '"  WHERE ID_HOGAR = '.$hogar.' ');
        $result = $this->db->query('UPDATE Ubicacion SET PROVINCIA = ' . '"' . $provincia . '", CANTON = ' . '"' . $canton . '",PARROQUIA = ' . '"' . $parroquia . '", DIRECCION = ' . '"' . $direccion . '" WHERE ID_UBICACION = '.$idUbicacion.' ');
        
        return $result;
    }

}
