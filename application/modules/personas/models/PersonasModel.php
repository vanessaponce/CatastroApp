<?php
class PersonasModel extends CI_Model
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

    public function showCuenta()
    {
        $session_data = $this->session->userdata('logged_in');
        $id = $session_data['ID_USUARIO'];

        $result = $this->db->query('SELECT * FROM Persona P JOIN Usuario U ON P.ID_PERSONA = U.ID_PERSONA WHERE U.ID_USUARIO = ' . $id . '');

        return $result->result();
    }

    public function updatePass()
    {
        $session_data = $this->session->userdata('logged_in');
        $id = $session_data['ID_USUARIO'];

        $result = $this->db->query('SELECT * FROM Persona P JOIN Usuario U ON P.ID_PERSONA = U.ID_PERSONA WHERE U.ID_USUARIO = ' . $id . '');

        return $result->result();
    }

    public function showPersonas()
    {
        $idPersona = $this->idPersonaUsuario();

        $idHogarResult = $this->db->query('SELECT ID_HOGAR FROM Rel_Hogar_Persona WHERE ID_PERSONA = ' . $idPersona . '');

        $idHogar = $idHogarResult->row()->ID_HOGAR;

        $result = $this->db->query('SELECT P.ID_PERSONA, P.NOMBRE, P.IDENTIFICACION, T.DESCRIPCION, R.ESTADO, T.ID_TIPO_PERSONA, R.ID_HOGAR FROM Persona P JOIN Rel_Hogar_Persona R ON P.ID_PERSONA = R.ID_PERSONA JOIN Tipo_Persona T ON P.ID_TIPO_PERSONA = T.ID_TIPO_PERSONA WHERE R.ESTADO = 1 AND R.ID_HOGAR =' . '"' . $idHogar . '"');

        return $result->result();
    }

    public function buscarPersona()
    {
        $cedula = $this->input->post('cedula');
        $result = json_decode(file_get_contents(base_url('/ws/ws.php?id=') . $cedula), true);

        return $result;
    }

    public function tipoPersona()
    {
        $result = $this->db->query('SELECT * FROM Tipo_Persona WHERE ID_TIPO_PERSONA <> 100');
        return $result->result();
    }

    public function registrarPariente()
    {
        $id = $this->input->post('id');
        $tipoPersona = $this->input->post('tipoPersona');
        $idHogar = $this->input->post('idHogar');
        $discapacidad = $this->input->post('discapacidad');

        $result = $this->db->query('UPDATE Persona SET ID_TIPO_PERSONA =' . $tipoPersona . ', DISCAPACIDAD =' . $discapacidad . ' WHERE ID_PERSONA = ' . $id . '');
        $result = $this->db->query('INSERT INTO Rel_Hogar_Persona (ID_PERSONA, 	ID_HOGAR, ESTADO) VALUES (' . $id . ', ' . $idHogar . ', 1)');

        return $result;
    }

    public function bajaPersona()
    {
        $idPersona = $this->input->post('idPersona');
        $result = $this->db->query('UPDATE Rel_Hogar_Persona SET ESTADO = 0 WHERE ID_PERSONA = ' . $idPersona . '');
        $result = $this->db->query('UPDATE Persona SET ID_TIPO_PERSONA = 0, DISCAPACIDAD = 0  WHERE ID_PERSONA = ' . $idPersona . '');

        return $result;
    }

}
