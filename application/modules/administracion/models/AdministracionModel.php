<?php
class AdministracionModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //Usuarios
    public function showUsuario()
    {
        $result = $this->db->query('SELECT U.USUA_ID, U.USUA_NOMBRE, U.USUA_NICK, U.USUA_MAIL, R.ROL_NOMBRE, U.ROL_ID, U.USUA_FECHA_REG, U.USUA_ESTADO, U.USUA_FOTO FROM USUARIOS U JOIN ROL R ON U.ROL_ID=R.ROL_ID ');
        return $result->result();

        if ($result->num_rows > 0) {
            $imgData = $result->fetch_assoc();

            //Render image
            header("Content-type: image/jpg");
            echo $imgData['image'];
        } else {
            echo 'Image not found...';
        }
    }

    public function saveUsuario()
    {

        $mailExiste = $this->db->query('SELECT * FROM USUARIOS WHERE USUA_MAIL=' . '"' . $this->input->post('mail') . '"');
        $nickExiste = $this->db->query('SELECT * FROM USUARIOS WHERE USUA_NICK=' . '"' . $this->input->post('nick') . '"');

        if ($nickExiste->num_rows() > 0 && $mailExiste->num_rows() > 0) {
            $result = 'Usuario con el Correo electrónico ' . $this->input->post('mail') . ' y el Nick ' . $this->input->post('nick') . ' ya existe.';
            return $result;
        } else if ($mailExiste->num_rows() > 0) {
            $result = 'Usuario con el Correo electrónico ' . $this->input->post('mail') . ' ya existe.';
            return $result;
        } else if ($nickExiste->num_rows() > 0) {
            $result = 'Usuario con el Nick ' . $this->input->post('nick') . ' ya existe.';
            return $result;
        }

        $data = array(
            'USUA_NOMBRE' => $this->input->post('nombre'),
            'USUA_MAIL' => $this->input->post('mail'),
            'USUA_NICK' => $this->input->post('nick'),
            'USUA_PASS' => md5($this->input->post('pass')),
            'USUA_FECHA_REG' => date('Y-m-d'),
            'USUA_FOTO' => $this->input->post('foto'),
            'USUA_ESTADO' => $this->input->post('estado'),
            'ROL_ID' => $this->input->post('rol'),
        );
        $result = $this->db->insert('USUARIOS', $data);
        return $result;

    }

    public function updateUsusario()
    {
        $this->form_validation->set_rules('mail', 'Mail', 'edit_unique[USUARIOS.USUA_MAIL.USUA_ID.' . $this->input->post('id') . ']');

        if ($this->form_validation->run() == false) {
            return 'El correo electrónico ' . $this->input->post('mail') . ' pertenece a otro usuario.';
        } else {

            $id = $this->input->post('id');
            $foto = $this->input->post('foto');
            $nombre = $this->input->post('nombre');
            //$nick = $this->input->post('nick');
            $mail = $this->input->post('mail');
            $estado = $this->input->post('estado');
            $rol = $this->input->post('rol');
            $pass = $this->input->post('pass');

            $this->db->set('USUA_NOMBRE', $nombre);
            $this->db->set('USUA_MAIL', $mail);
            //$this->db->set('USUA_NICK', $nick);
            $this->db->set('USUA_ESTADO', $estado);
            $this->db->set('USUA_FOTO', $foto);
            $this->db->set('ROL_ID', $rol);

            if ($pass != "") {
                $this->db->set('USUA_PASS', md5($pass));
                $this->db->where('USUA_ID', $id);
                $result = $this->db->update('USUARIOS');
                return $result;
            } else {
                $this->db->where('USUA_ID', $id);
                $result = $this->db->update('USUARIOS');
                return $result;
            }
        }

    }

    public function deleteUsuario()
    {
        $id = $this->input->post('id');
        $usuariosRol = $this->db->query('SELECT * FROM SITES WHERE SITE_SUPERVISOR=' . '"' . $id . '" OR SITE_ADMINISTRADOR=' . '"' . $id . '"');

        if ($usuariosRol->num_rows() > 0) {
            $result = 'No se puede eliminar, hay sites ligados a este usuario.';
            return $result;
        } else {
            $id = $this->input->post('id');
            $this->db->where('USUA_ID', $id);
            $result = $this->db->delete('USUARIOS');
            return $result;
        }

    }

    //Rol

    public function showGrupo()
    {
        $result = $this->db->query("SELECT R.ROL_ID, R.ROL_NOMBRE, COUNT(U.ROL_ID) AS NUM_USUARIOS FROM ROL R LEFT OUTER JOIN USUARIOS U ON R.ROL_ID = U.ROL_ID GROUP BY R.ROL_ID, R.ROL_NOMBRE ORDER BY 1");
        return $result->result();
    }
    public function showGrupoPermisos()
    {
        $result = $this->db->query("SELECT * FROM URL");
        return $result->result();
    }

    public function showGrupoPermisosShow()
    {
        $result = $this->db->query('SELECT U.URL_ID, U.URL_NOMBRE, (SELECT LOCATE(U.URL_ID, R.URL_IDS) FROM ROL R WHERE R.ROL_ID = ' . '"' . $this->input->post('id') . '") URL_ACT FROM URL U');
        return $result->result();
    }

    public function saveGrupoPermisos()
    {
        $urls = trim($this->input->post('urls'), ',');
        $rolExiste = $this->db->query('SELECT * FROM ROL WHERE ROL_NOMBRE=' . '"' . $this->input->post('nombre') . '"');

        if ($rolExiste->num_rows() > 0) {
            $result = 'Nombre del grupo ' . $this->input->post('nombre') . ' ya existe.';
            return $result;
        } else {
            $data = array(
                'ROL_NOMBRE' => $this->input->post('nombre'),
                'URL_IDS' => trim($this->input->post('urls'), ','),
            );
            $result = $this->db->insert('ROL', $data);

            return $result;
        }
    }

    public function editGrupoPermisos()
    {
        $nombre = $this->input->post('nombre');
        $urls = trim($this->input->post('urls'), ',');
        $id = $this->input->post('id');

        $this->form_validation->set_rules('nombre', 'Nombre', 'edit_unique[ROL.ROL_NOMBRE.ROL_ID.' . $id . ']');

        if ($this->form_validation->run() == false) {
            return 'Nombre del grupo ' . $this->input->post('nombre') . ' ya existe.';
        } else {

            $this->db->set('ROL_NOMBRE', $nombre);
            $this->db->set('URL_IDS', $urls);
            $this->db->where('ROL_ID', $id);
            $result = $this->db->update('ROL');

            return $result;
        }
    }

    public function deleteRol()
    {
        $id = $this->input->post('id');
        $usuariosRol = $this->db->query('SELECT * FROM USUARIOS WHERE ROL_ID=' . '"' . $id . '"');

        if ($usuariosRol->num_rows() > 0) {
            $result = 'No se puede eliminar, hay usuarios ligados a este grupo.';
            return $result;
        } else {
            $this->db->where('ROL_ID', $id);
            $result = $this->db->delete('ROL');
            return $result;
        }
    }

    //Sites
    public function showSites()
    {
        $result = $this->db->query("SELECT S.SITE_ID, S.SITE_CLIENTE, SITE_DIA_CORTE, SITE_ESTADO, (SELECT U.USUA_NOMBRE FROM USUARIOS U WHERE S.SITE_SUPERVISOR=U.USUA_ID) SITE_SUPERVISOR, S.SITE_SUPERVISOR SUP_ID, (SELECT U.USUA_NOMBRE FROM USUARIOS U WHERE S.SITE_ADMINISTRADOR=U.USUA_ID) SITE_ADMINISTRADOR, S.SITE_ADMINISTRADOR ADM_ID, SITE_REGISTRADO, (LENGTH(SITE_IMPRESORAS) - LENGTH(REPLACE(SITE_IMPRESORAS, ',', '')) + 1) NUM_IMPRESORAS, SITE_IMPRESORAS FROM SITES S");
        return $result->result();
    }
    public function showEquiposSite()
    {
        $imp = $this->db->query('SELECT GROUP_CONCAT(SITE_IMPRESORAS) IDS FROM SITES');
        $impA = '0';
        if ($imp->row()->IDS != ',') {$impA = trim($imp->row()->IDS, ',');}
        $result = $this->db->query('SELECT E.EQUI_ID, M.MODE_NOMBRE, E.EQUI_SERIE, E.EQUI_NOMBRE FROM EQUIPOS E JOIN MODELO M ON E.MODE_ID=M.MODE_ID WHERE E.EQUI_ID NOT IN (' . $impA . ')');
        return $result->result();
    }
    public function showEquiposSiteEdit()
    {
        $impIds = $this->input->post('imp');
        $imp = $this->db->query('SELECT GROUP_CONCAT(SITE_IMPRESORAS) IDS FROM SITES');

        if (!$impIds) {$impIds = '0';}

        $impA = '0';
        if ($imp->row()->IDS != ',') {$impA = trim($imp->row()->IDS, ',');}
        $result = $this->db->query('SELECT E.EQUI_ID, M.MODE_NOMBRE, E.EQUI_SERIE, E.EQUI_NOMBRE FROM EQUIPOS E JOIN MODELO M ON E.MODE_ID=M.MODE_ID WHERE E.EQUI_ID NOT IN (' . $impA . ') UNION SELECT E.EQUI_ID, M.MODE_NOMBRE, E.EQUI_SERIE, E.EQUI_NOMBRE FROM EQUIPOS E JOIN MODELO M ON E.MODE_ID=M.MODE_ID WHERE E.EQUI_ID IN (' . $impIds . ')');
        return $result->result();
    }

    public function saveSites()
    {
        $siteExiste = $this->db->query('SELECT * FROM SITES WHERE SITE_CLIENTE=' . '"' . $this->input->post('cliente') . '"');
        $impre = implode(",", $this->input->post('impre'));

        if ($siteExiste->num_rows() > 0) {
            $result = 'Nombre de Cliente ' . $this->input->post('cliente') . ' ya existe.';
            return $result;
        } else {
            $data = array(
                'SITE_CLIENTE' => $this->input->post('cliente'),
                'SITE_SUPERVISOR' => $this->input->post('superv'),
                'SITE_ADMINISTRADOR' => $this->input->post('admin'),
                'SITE_DIA_CORTE' => $this->input->post('dia'),
                'SITE_IMPRESORAS' => $impre,
                'SITE_REGISTRADO' => date('Y-m-d'),
            );
            $result = $this->db->insert('SITES', $data);

            return $result;
        }
    }

    public function updateSites()
    {
        $impre = '';
        $this->form_validation->set_rules('cliente', 'Cliente', 'edit_unique[SITES.SITE_CLIENTE.SITE_ID.' . $this->input->post('id') . ']');
        if ($this->input->post('impre')) {$impre = implode(",", $this->input->post('impre'));}

        if ($this->form_validation->run() == false) {
            return 'Nombre de Cliente ' . $this->input->post('cliente') . ' ya existe.';
        } else {

            $this->db->set('SITE_CLIENTE', $this->input->post('cliente'));
            $this->db->set('SITE_SUPERVISOR', $this->input->post('superv'));
            $this->db->set('SITE_ADMINISTRADOR', $this->input->post('admin'));
            $this->db->set('SITE_DIA_CORTE', $this->input->post('dia'));
            $this->db->set('SITE_ESTADO', $this->input->post('estado'));
            $this->db->set('SITE_IMPRESORAS', $impre);
            $this->db->where('SITE_ID', $this->input->post('id'));
            $result = $this->db->update('SITES');

            return $result;
        }
    }

    public function deleteSites()
    {
        $this->db->where('SITE_ID', $this->input->post('id'));
        $result = $this->db->delete('SITES');
        return $result;
    }

    //Modelos
    public function showModelos()
    {
        $result = $this->db->query("SELECT M.MODE_ID, M.MODE_NOMBRE, COUNT(E.MODE_ID) AS NUM_EQUIPOS FROM MODELO M LEFT OUTER JOIN EQUIPOS E ON E.MODE_ID=M.MODE_ID GROUP BY M.MODE_ID, M.MODE_NOMBRE");
        return $result->result();
    }

    public function saveModelos()
    {
        $modeloExiste = $this->db->query('SELECT * FROM MODELO WHERE MODE_NOMBRE=' . '"' . $this->input->post('nombre') . '"');

        if ($modeloExiste->num_rows() > 0) {
            $result = 'Nombre de Modelo ' . $this->input->post('nombre') . ' ya existe.';
            return $result;
        } else {
            $data = array(
                'MODE_NOMBRE' => $this->input->post('nombre'),
            );
            $result = $this->db->insert('MODELO', $data);

            return $result;
        }
    }

    public function updateModelos()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'edit_unique[MODELO.MODE_NOMBRE.MODE_ID.' . $this->input->post('id') . ']');

        if ($this->form_validation->run() == false) {
            return 'Nombre de Modelo ' . $this->input->post('nombre') . ' ya existe.';
        } else {
            $this->db->set('MODE_NOMBRE', $this->input->post('nombre'));
            $this->db->where('MODE_ID', $this->input->post('id'));
            $result = $this->db->update('MODELO');

            return $result;
        }
    }

    public function deleteModelos()
    {
        $id = $this->input->post('id');
        $equiposModelo = $this->db->query('SELECT * FROM EQUIPOS WHERE MODE_ID=' . '"' . $id . '"');

        if ($equiposModelo->num_rows() > 0) {
            $result = 'No se puede eliminar, hay impresoras ligadas a este modelo.';
            return $result;
        } else {
            $this->db->where('MODE_ID', $this->input->post('id'));
            $result = $this->db->delete('MODELO');
            return $result;
        }

    }

    //Equipos
    public function showEquipos()
    {
        $result = $this->db->query('SELECT E.EQUI_ID, E.EQUI_NOMBRE, M.MODE_NOMBRE, E.EQUI_SERIE, E.EQUI_IP, E.EQUI_CONTADOR, E.MODE_ID FROM EQUIPOS E JOIN MODELO M ON E.MODE_ID = M.MODE_ID');
        return $result->result();
    }

    public function saveEquipos()
    {
        $equipoExiste = $this->db->query('SELECT * FROM EQUIPOS WHERE EQUI_SERIE=' . '"' . $this->input->post('serie') . '"');

        if ($equipoExiste->num_rows() > 0) {
            $result = 'Impresora con serie ' . $this->input->post('serie') . ' ya existe.';
            return $result;
        } else {
            $data = array(
                'MODE_ID' => $this->input->post('modelo'),
                'EQUI_NOMBRE' => $this->input->post('nombre'),
                'EQUI_SERIE' => $this->input->post('serie'),
                'EQUI_IP' => $this->input->post('ip'),
                'EQUI_CONTADOR' => $this->input->post('contador'),
            );
            $result = $this->db->insert('EQUIPOS', $data);

            return $result;
        }
    }

    public function updateEquipos()
    {
        $this->form_validation->set_rules('serie', 'Serie', 'edit_unique[EQUIPOS.EQUI_SERIE.EQUI_ID.' . $this->input->post('id') . ']');

        if ($this->form_validation->run() == false) {
            return 'Serie de impresora ' . $this->input->post('serie') . ' ya existe.';
        } else {
            $this->db->set('MODE_ID', $this->input->post('modelo'));
            $this->db->set('EQUI_NOMBRE', $this->input->post('nombre'));
            $this->db->set('EQUI_SERIE', $this->input->post('serie'));
            $this->db->set('EQUI_IP', $this->input->post('ip'));
            $this->db->set('EQUI_CONTADOR', $this->input->post('contador'));
            $this->db->where('EQUI_ID', $this->input->post('id'));
            $result = $this->db->update('EQUIPOS');

            return $result;
        }
    }

    public function deleteEquipos()
    {
        $this->db->where('EQUI_ID', $this->input->post('id'));
        $result = $this->db->delete('EQUIPOS');
        return $result;
    }

    public function showEquiposEstado()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];
        $soapEquipos = array();
        $equipoNo = array();
        $listEquipos = array();
        $equipoInfo = array();
        //$resultAdmin = $this->db->query('SELECT GROUP_CONCAT(distinct SITE_IMPRESORAS) AS SITE_IMPRESORAS FROM SITES WHERE SITE_ADMINISTRADOR = ' . $idAdministrador . '');
        $resultAdmin = $this->db->query('SELECT SITE_IMPRESORAS, SITE_CLIENTE FROM SITES WHERE SITE_ADMINISTRADOR = ' . $idAdministrador . '');
        //$numEquipos = $resultAdmin->row()->SITE_IMPRESORAS;
        if ($resultAdmin->num_rows() > 0) {
            foreach ($resultAdmin->result() as $row) {
                $numEquipos = $resultAdmin->row()->SITE_IMPRESORAS;
                $nomSite = $resultAdmin->row()->SITE_CLIENTE;
                $result = $this->db->query('SELECT EQUI_ID, EQUI_NOMBRE, EQUI_IP, EQUI_SERIE FROM EQUIPOS WHERE EQUI_ID IN (' . $numEquipos . ')');
                if ($result->num_rows() > 0) {
                    foreach ($result->result() as $row) {
                        $id = $row->EQUI_ID;
                        $ip = $row->EQUI_IP;
                        $serie = $row->EQUI_SERIE;
                        $nombre = $row->EQUI_NOMBRE;
                        $soapEquipos = $this->soapEquipo($ip);
                        if ($soapEquipos) {
                            array_push($equipoInfo, $nombre, $nomSite, $id);
                            array_push($soapEquipos, $equipoInfo);
                            array_push($listEquipos, $soapEquipos);
                            $equipoInfo = array();
                        } else {
                            array_push($equipoNo, $nombre, $ip, $serie, $nomSite, $id);
                            array_push($listEquipos, $equipoNo);
                            $equipoNo = array();
                        }
                        
                    }
                }
            }
        }

        return $listEquipos;
    }

    //**********Systema****************/
    public function listGeneralSistema()
    {
        $result = $this->db->query('SELECT * FROM SIST_GENERAL');
        return $result->result();
    }

    public function listMenuSistema()
    {
        $session_data = $this->session->userdata('logged_in');
        $rolId = $session_data['ROL_ID'];

        $rolUrl = $this->db->query('SELECT URL_IDS FROM ROL WHERE ROL_ID=' . '"' . $rolId . '"');

        $result = $this->db->query('SELECT * FROM URL WHERE URL_ID IN (' . $rolUrl->row()->URL_IDS . ')');

        return $result->result();
    }

    public function saveGeneralSistema()
    {
        try {

            $temaServidor = $this->input->post('temaServidor');
            $colorServidor = $this->input->post('colorServidor');
            $menuServidor = $this->input->post('menuServidor');
            $tiempoServidor = $this->input->post('tiempoServidor');

            $this->db->set('GEN_TEMA', $temaServidor);
            $this->db->set('GEN_COLOR', $colorServidor);
            $this->db->set('GEN_LATERAL', $menuServidor);
            $this->db->set('GEN_TIME_SESION', $tiempoServidor);

            $this->db->where('GEN_ID', 1);

            $result = $this->db->update('SIST_GENERAL');

            return $result;
        } catch (Exception $e) {
            $result = 'Error: ' . $e;
            return $result;
        }
    }

    public function listMailSistema()
    {
        $result = $this->db->query('SELECT * FROM SIST_MAIL');
        return $result->result();
    }

    public function saveMailSistema()
    {
        try {

            $mailServidor = $this->input->post('mailServidor');
            $mailUsuario = $this->input->post('mailUsuario');
            $mailPass = $this->input->post('mailPass');
            $mailPuerto = $this->input->post('mailPuerto');
            $mailProtocolo = $this->input->post('mailProtocolo');
            $mailChartset = $this->input->post('mailChartset');

            $this->db->set('MAIL_SERVIDOR', $mailServidor);
            $this->db->set('MAIL_USUARIO', $mailUsuario);
            $this->db->set('MAIL_PASS', $mailPass);
            $this->db->set('MAIL_PUERTO', $mailPuerto);
            $this->db->set('MAIL_PROTOCOLO', $mailProtocolo);
            $this->db->set('MAIL_CHARTSET', $mailChartset);

            $this->db->where('MAIL_ID', 1);

            $result = $this->db->update('SIST_MAIL');

            return $result;
        } catch (Exception $e) {
            $result = 'Error: ' . $e;
            return $result;
        }

    }

    public function actualizarSistema()
    {
        exec('./upAppSu.sh', $result);
        foreach ($result as $line) {
            print($line . "\n");
        }
        //return $result;
    }

    //Suministros
    public function showSuministros()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $result = $this->db->query('SELECT SU.SUMI_ID, SU.SUMI_CODIGO, SU.SUMI_NOMBRE, SU.SUMI_STOCK, MO.MODE_ID, MO.MODE_NOMBRE FROM SUMINISTROS SU JOIN USUARIOS US ON US.USUA_ID = SU.USUA_ID JOIN MODELO MO ON SU.MODE_ID = MO.MODE_ID WHERE US.USUA_ID = ' . $idAdministrador . '');
        return $result->result();
    }

    public function showSitesSuministros()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $result = $this->db->query('SELECT SITE_ID, SITE_CLIENTE FROM SITES WHERE SITE_ADMINISTRADOR=' . $idAdministrador . '');
        return $result->result();
    }

    public function saveSuministros()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $suministroExiste = $this->db->query('SELECT * FROM SUMINISTROS WHERE SUMI_CODIGO=' . '"' . $this->input->post('codigo') . '" AND USUA_ID = ' . $idAdministrador . '');

        if ($suministroExiste->num_rows() > 0) {
            $result = 'Código de suministro ' . $this->input->post('codigo') . ' ya existe.';
            return $result;
        } else {
            $data = array(
                'SUMI_CODIGO' => $this->input->post('codigo'),
                'SUMI_NOMBRE' => $this->input->post('nombre'),
                'MODE_ID' => $this->input->post('modelo'),
                'USUA_ID' => $idAdministrador,
            );
            $result = $this->db->insert('SUMINISTROS', $data);

            return $result;
        }
    }

    public function updateSuministros()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $sumExiste = $this->db->query('SELECT * FROM SUMINISTROS WHERE SUMI_CODIGO = ' . '"' . $this->input->post('codigo') . '" AND USUA_ID = ' . $idAdministrador . ' AND SUMI_ID != ' . $this->input->post('id') . ' ');

        if ($sumExiste->num_rows() > 0) {
            return 'Código de suministro ' . $this->input->post('codigo') . ' ya existe.';
        } else {

            $this->db->set('SUMI_CODIGO', $this->input->post('codigo'));
            $this->db->set('SUMI_NOMBRE', $this->input->post('nombre'));
            $this->db->set('MODE_ID', $this->input->post('modelo'));
            $this->db->where('SUMI_ID', $this->input->post('id'));
            $result = $this->db->update('SUMINISTROS');

            return $result;
        }
    }

    public function deleteSuministros()
    {
        $this->db->where('SUMI_ID', $this->input->post('id'));
        $result = $this->db->delete('SUMINISTROS');
        return $result;
    }

    //Guias
    public function showGuias()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $result = $this->db->query('SELECT G.GUIA_ID, G.GUIA_NUMERO, G.GUIA_MOVIMIENTO, G.GUIA_FECHA, G.GUIA_CANTIDAD, G.GUIA_CANT_DISPONIBLE, G.SUMI_ID, SU.SUMI_CODIGO, G.SITE_ID, S.SITE_CLIENTE, G.GUIA_ESTADO FROM GUIAS G JOIN SITES S ON G.SITE_ID = S.SITE_ID JOIN SUMINISTROS SU ON SU.SUMI_ID = G.SUMI_ID WHERE SU.USUA_ID = ' . $idAdministrador . ' ORDER BY 4 DESC');
        return $result->result();
    }

    public function saveGuias()
    {
        $numero = $this->input->post('numero');
        $movimiento = $this->input->post('movimiento');
        $fecha = $this->input->post('fecha');
        $cantidad = $this->input->post('cantidad');
        $suministro = $this->input->post('suministro');
        $site = $this->input->post('site');

        $guiaExiste = $this->db->query('SELECT * FROM GUIAS WHERE GUIA_NUMERO=' . $numero . ' AND SUMI_ID= ' . $suministro . '');

        if ($guiaExiste->num_rows() > 0) {
            $result = 'Número de guía y suministro ya existe.';
        } else {
            $data = array(
                'GUIA_NUMERO' => $numero,
                'GUIA_MOVIMIENTO' => $movimiento,
                'GUIA_FECHA' => $fecha,
                'GUIA_CANTIDAD' => $cantidad,
                'GUIA_CANT_DISPONIBLE' => $cantidad,
                'SUMI_ID' => $suministro,
                'SITE_ID' => $site,
            );
            $result = $this->db->insert('GUIAS', $data);

            $result = $this->db->query('UPDATE SUMINISTROS SET SUMI_STOCK = (SUMI_STOCK + ' . $cantidad . ') WHERE SUMI_ID = ' . $suministro . ' ');
        }
        return $result;
    }

    public function updateGuias()
    {
        $id = $this->input->post('id');
        $numero = $this->input->post('numero');
        $movimiento = $this->input->post('movimiento');
        $fecha = $this->input->post('fecha');
        $cantidad = $this->input->post('cantidad');
        $suministro = $this->input->post('suministro');
        $site = $this->input->post('site');
        $cantidadU = 0;

        $cantidadActual = $this->db->query('SELECT GUIA_CANTIDAD FROM GUIAS WHERE GUIA_ID = ' . $id . '');
        $cantidadStock = $this->db->query('SELECT SUMI_STOCK FROM SUMINISTROS WHERE SUMI_ID = ' . $suministro . '');

        $cantidadActualA = $cantidadActual->row()->GUIA_CANTIDAD;
        $cantidadStockA = $cantidadStock->row()->SUMI_STOCK;

        if ($cantidadActualA != $cantidad) {
            $cantidadU = $cantidadStockA - $cantidadActualA + $cantidad;
            $updateStock = $this->db->query('UPDATE SUMINISTROS SET SUMI_STOCK = (' . $cantidadU . ') WHERE SUMI_ID = ' . $suministro . ' ');
        }

        $this->db->set('GUIA_NUMERO', $numero);
        $this->db->set('GUIA_MOVIMIENTO', $movimiento);
        $this->db->set('GUIA_FECHA', $fecha);
        $this->db->set('GUIA_CANTIDAD', $cantidad);
        $this->db->set('GUIA_CANT_DISPONIBLE', $cantidad);
        $this->db->set('SUMI_ID', $suministro);
        $this->db->set('SITE_ID', $site);
        $this->db->where('GUIA_ID', $id);

        $result = $this->db->update('GUIAS');

        return $result;
    }

    public function deleteGuias()
    {
        $this->db->where('GUIA_ID', $this->input->post('id'));
        $result = $this->db->delete('GUIAS');
        return $result;
    }

    //Registro papel usado

    public function showGuiasPapel()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $result = $this->db->query('SELECT G.GUIA_ID, G.GUIA_NUMERO, G.GUIA_CANT_DISPONIBLE, G.SITE_ID FROM GUIAS G JOIN SUMINISTROS S ON S.SUMI_ID = G.SUMI_ID WHERE S.SUMI_NOMBRE = "PAPEL" AND S.USUA_ID = ' . $idAdministrador . ' AND G.GUIA_CANT_DISPONIBLE != 0 ORDER BY 1 DESC');
        return $result->result();
    }
    public function showGuiasSuministros()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $result = $this->db->query('SELECT G.GUIA_ID, G.GUIA_NUMERO, G.GUIA_CANT_DISPONIBLE, S.SUMI_NOMBRE, M.MODE_NOMBRE, G.SITE_ID FROM GUIAS G JOIN SUMINISTROS S ON S.SUMI_ID = G.SUMI_ID JOIN MODELO M ON S.MODE_ID = M.MODE_ID WHERE S.SUMI_NOMBRE != "PAPEL" AND S.USUA_ID = ' . $idAdministrador . ' AND G.GUIA_CANT_DISPONIBLE != 0 ORDER BY 1 DESC');
        return $result->result();
    }

    public function showRegPapel()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $result = $this->db->query('SELECT R.REPA_ID, R.REPA_FECHA, R.REPA_RESMAS, R.GUIA_ID, G.GUIA_NUMERO, R.SITE_ID, S.SITE_CLIENTE  FROM REG_PAPEL R JOIN GUIAS G ON R.GUIA_ID = G.GUIA_ID JOIN SITES S ON R.SITE_ID = S.SITE_ID WHERE S.SITE_ADMINISTRADOR = ' . $idAdministrador . ' ');
        return $result->result();
    }

    public function saveRegPapel()
    {
        if ($this->input->post('guia') != null) {
            $data = array(
                'REPA_RESMAS' => $this->input->post('cantidad'),
                'REPA_FECHA' => $this->input->post('fecha'),
                'GUIA_ID' => $this->input->post('guia'),
                'SITE_ID' => $this->input->post('site'),
            );
            $result = $this->db->insert('REG_PAPEL', $data);

            $result = $this->db->query('UPDATE GUIAS G JOIN SUMINISTROS S ON G.SUMI_ID = S.SUMI_ID SET G.GUIA_CANT_DISPONIBLE = (G.GUIA_CANT_DISPONIBLE-' . $this->input->post('cantidad') . '), S.SUMI_STOCK= (S.SUMI_STOCK-' . $this->input->post('cantidad') . '), G.GUIA_ESTADO = 2 WHERE G.GUIA_ID = ' . $this->input->post('guia') . '');
            $stockGuia = $this->db->query('SELECT GUIA_CANT_DISPONIBLE FROM GUIAS WHERE GUIA_ID = ' . $this->input->post('guia') . '');

            if ($stockGuia->row()->GUIA_CANT_DISPONIBLE == 0) {
                $result = $this->db->query('UPDATE GUIAS SET GUIA_ESTADO = 0 WHERE GUIA_ID = ' . $this->input->post('guia') . '');
            }
            return $result;
        } else {
            return 'No existe guía.';
        }
    }

    public function deleteRegPapel()
    {
        $this->db->where('REPA_ID', $this->input->post('id'));
        $result = $this->db->delete('REG_PAPEL');

        $result = $this->db->query('UPDATE GUIAS G JOIN SUMINISTROS S ON G.SUMI_ID = S.SUMI_ID SET G.GUIA_CANT_DISPONIBLE = (G.GUIA_CANT_DISPONIBLE + ' . $this->input->post('resmas') . '), S.SUMI_STOCK= (S.SUMI_STOCK + ' . $this->input->post('resmas') . '), G.GUIA_ESTADO = 2 WHERE G.GUIA_ID = ' . $this->input->post('guia') . '');

        return $result;
    }

    //Registro suministros usados
    public function showEquiposSuministros()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $site = $this->db->query('SELECT SITE_ID, SITE_IMPRESORAS FROM SITES WHERE SITE_ADMINISTRADOR = ' . $idAdministrador . ' ');

        $result = array();
        $resultEquipo = array();
        foreach ($site->result() as $row) {
            $numEquipos = $row->SITE_IMPRESORAS;
            $siteId = $row->SITE_ID;
            $equipos = $this->db->query('SELECT EQUI_ID, EQUI_NOMBRE, EQUI_IP, EQUI_SERIE, "' . $siteId . '" AS SITE_ID FROM EQUIPOS WHERE EQUI_ID IN (' . $numEquipos . ') ORDER BY 2');
            $result = array_merge($result, $equipos->result_array());
        }

        return $result;
    }

    public function showRegSuministrosCont()
    {
        $contador = $this->soapEquipoContador($this->input->post('ip'));
        return $contador;
    }

    public function showRegSuministros()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $result = $this->db->query('SELECT R.RESU_ID, R.RESU_FECHA, R.RESU_CONTADOR, R.GUIA_ID, G.GUIA_NUMERO, R.EQUI_ID, E.EQUI_NOMBRE, R.SITE_ID, S.SITE_CLIENTE, SU.SUMI_NOMBRE FROM REG_SUMINISTRO R JOIN GUIAS G ON R.GUIA_ID = G.GUIA_ID JOIN SITES S ON R.SITE_ID = S.SITE_ID JOIN EQUIPOS E ON E.EQUI_ID = R.EQUI_ID JOIN SUMINISTROS SU ON SU.SUMI_ID = G.SUMI_ID WHERE S.SITE_ADMINISTRADOR = ' . $idAdministrador . ' ');
        return $result->result();
    }
    public function saveRegSuministros()
    {
        if ($this->input->post('guia') != null) {
            $data = array(
                'RESU_FECHA' => $this->input->post('fecha'),
                'RESU_CONTADOR' => $this->input->post('contador'),
                'EQUI_ID' => $this->input->post('impresora'),
                'GUIA_ID' => $this->input->post('guia'),
                'SITE_ID' => $this->input->post('site'),
            );
            $result = $this->db->insert('REG_SUMINISTRO', $data);

            $result = $this->db->query('UPDATE GUIAS G JOIN SUMINISTROS S ON G.SUMI_ID = S.SUMI_ID SET G.GUIA_CANT_DISPONIBLE = (G.GUIA_CANT_DISPONIBLE - 1 ), S.SUMI_STOCK= (S.SUMI_STOCK - 1 ), G.GUIA_ESTADO = 2 WHERE G.GUIA_ID = ' . $this->input->post('guia') . '');
            $stockGuia = $this->db->query('SELECT GUIA_CANT_DISPONIBLE FROM GUIAS WHERE GUIA_ID = ' . $this->input->post('guia') . '');

            if ($stockGuia->row()->GUIA_CANT_DISPONIBLE == 0) {
                $result = $this->db->query('UPDATE GUIAS SET GUIA_ESTADO = 0 WHERE GUIA_ID = ' . $this->input->post('guia') . '');
            }
            return $result;
        } else {
            return 'No existe guía.';
        }
    }

    public function deleteRegSuministros()
    {
        $this->db->where('RESU_ID', $this->input->post('id'));
        $result = $this->db->delete('REG_SUMINISTRO');

        $result = $this->db->query('UPDATE GUIAS G JOIN SUMINISTROS S ON G.SUMI_ID = S.SUMI_ID SET G.GUIA_CANT_DISPONIBLE = (G.GUIA_CANT_DISPONIBLE + 1), S.SUMI_STOCK= (S.SUMI_STOCK + 1), G.GUIA_ESTADO = 2 WHERE G.GUIA_ID = ' . $this->input->post('guia') . '');

        return $result;
    }

    //Registro contadores
    public function saveRegContSumi()
    {
        $data = array(
            'CONT_FECHA' => date('Y-m-d H:i:s'),
            'CONT_CONTADOR' => $this->input->post('contador'),
            'EQUI_ID' => $this->input->post('equipo'),
        );
        $result = $this->db->insert('CONTADORES', $data);

        return $result;
    }

    public function showRegContSumi()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $result = $this->db->query('SELECT EE.CONT_ID, EE.CONT_FECHA, EE.CONT_CONTADOR, E.EQUI_NOMBRE, S.SITE_CLIENTE FROM CONTADORES EE JOIN EQUIPOS E ON E.EQUI_ID = EE.EQUI_ID JOIN SITES S WHERE S.SITE_ADMINISTRADOR =' . $idAdministrador . ' ORDER BY 2 DESC');
        return $result->result();
    }
    public function deleteRegContSumi()
    {
        $id = $this->input->post('id');

        $this->db->where('CONT_ID', $id);
        $result = $this->db->delete('CONTADORES');

        return $result;
    }

    //TABLERO

    public function showRegSemana()
    {
        $session_data = $this->session->userdata('logged_in');
        $idAdministrador = $session_data['USUA_ID'];

        $result = $this->db->query('SELECT EE.EQES_FECHA, EE.EQES_CONTADOR, E.EQUI_NOMBRE FROM EQUIPO_ESTADO EE JOIN EQUIPOS E ON EE.EQUI_ID = E.EQUI_ID JOIN SITES S ON S.SITE_ADMINISTRADOR = ' . $idAdministrador . ' WHERE YEARWEEK(EE.EQES_FECHA)=YEARWEEK(NOW())');
        return $result->result();
    }
}
