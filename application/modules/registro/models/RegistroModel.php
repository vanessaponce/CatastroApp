<?php
class RegistroModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function validarUsuario()
    {
        $cedula = $this->input->post('cedula');
        $result = json_decode(file_get_contents(base_url('/ws/ws.php?id=') . $cedula), true);

        return $result;
    }

    public function enviarMail($mail, $pass, $dni)
    {

        $this->load->library('email');
        try {
            $config['protocol'] = 'SMTP';
            $config["smtp_host"] = 'mail.app.ecuacode.com';
            $config["smtp_user"] = 'admin@app.ecuacode.com';
            $config["smtp_pass"] = 'Fecz0807042205';
            $config["smtp_port"] = '587';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = true;
            $config['validate'] = true;

            $this->email->initialize($config);
            $this->email->from('admin@app.ecuacode.com', 'Catastro App');
            $this->email->to($mail, 'Usuario');
            $this->email->subject("Registro exitoso Catastro App.");

            $message = "Gracias por su registro. ";
            $message .= "Su usuario es: " . $dni;
            $message .= ", y su contraseña: " . $pass;

            $this->email->message($message);

            if ($this->email->send()) {
                log_message('error', "Email enviado: " . $mail . " usuario: " . $dni);
            } else {
                log_message('error', $this->email->print_debugger());
            }
            return true;

        } catch (Exception $e) {
            log_message('error', $e);
        }

    }

    public function generar_password()
    {
        $cadena_base = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $cadena_base .= '0123456789';
        $cadena_base .= '!@#%&?+';

        $password = '';
        $limite = strlen($cadena_base) - 1;

        for ($i = 0; $i < 8; $i++) {
            $password .= $cadena_base[rand(0, $limite)];
        }

        return $password;
    }

    public function registrarUsuario()
    {
        $password = $this->generar_password();
        $mail = $this->input->post('mail');
        $dni = $this->input->post('identificacion');
        $id = $this->input->post('id');

        $this->enviarMail($mail, $password, $dni);

        $usu = array(
            'USUARIO' => $dni,
            'ID_PERSONA' => $id,
            'MAIL' => $mail,
            'CONTRASENIA' => md5($password),
        );

        $result = $this->db->query('INSERT INTO Rel_Hogar_Persona (ID_PERSONA, ID_HOGAR, ESTADO) VALUES (' . '"' . $id . '", (SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "Catastro" AND TABLE_NAME = "Hogar"), 1);');
        $result = $this->db->query('INSERT INTO Hogar (ID_HOGAR, ID_UBICACION, SUMINISTRO_ELEC, ESTADO) VALUES (NULL, (SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "Catastro" AND TABLE_NAME = "Ubicacion"), "", 1);');
        $result = $this->db->query('INSERT INTO Ubicacion (PROVINCIA, CANTON, PARROQUIA, DIRECCION) VALUES (0,0,0,"")');
        $result = $this->db->query('UPDATE Persona SET ID_TIPO_PERSONA=100 WHERE ID_PERSONA=' . '"' . $id . '"');

        $result = $this->db->insert('Usuario', $usu);

        return $result;
    }

}
