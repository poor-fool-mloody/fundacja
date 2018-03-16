<?php
/**
 * Created by PhpStorm.
 * User: tomcio
 * Date: 02.01.18
 * Time: 18:24
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct() {
        parent::__construct();

        $this->load->model('admin_model');

        //Logowanie
        $this->load->library('logging');

        session_start();

        if( isset($_SESSION['isLogin']) && $_SESSION['isLogin'] === true ){
            redirect(base_url().'index.php/admin/', 'refresh');
        }

    }


    public function login(){
        $data['title'] = 'Logowanie do panelu';

        $this->load->helper('form');
        $this->load->library('form_validation');

        //Ustawianie wymaganych pół formularzy
        $this->form_validation->set_rules('login', 'Login', 'required');
        $this->form_validation->set_rules('password', 'Hasło', 'required');

        if($this->form_validation->run() === true){
            $login = $this->input->post('login');
            $password = $this->input->post('password');

            if($this->admin_model->checkUser($login, $password)){
                //Zalogowano pomyślnie!
                $_SESSION['isLogin'] = true;
                $_SESSION['adminId'] = $this->admin_model->getUserId($login);
                $_SESSION['adminLogin'] = $login;

                //Logowanie
                $logger = $this->logging->get_logger('info');
                $logger->info('Logowanie użytkownika: ' . $login);

                redirect("/admin/", 'refresh');
            }
            else{
                $data['login_failed'] = true;

                //Logowanie
                $logger = $this->logging->get_logger('info');
                $logger->info('Nieudane logowanie użytkownika (błędne hasło): ' . $login);

                $this->load->view('header', $data);
                $this->load->view('login/index', $data);
                $this->load->view('footer');
            }

        }
        else {
            $data['login_failed'] = false;

            $this->load->view('header', $data);
            $this->load->view('login/index', $data);
            $this->load->view('footer');
        }

    }
}