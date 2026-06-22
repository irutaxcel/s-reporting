<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('AuthModel', 'auth');
    }



    public function index()
    {
        $title = 'Connexion';

        $this->load->view('v1/components/layout/auth-header', ['title' => $title]);
        $this->load->view('v1/components/auth/auth-signin');
        $this->load->view('v1/components/layout/auth-footer');
    }

    public function authlogin()
    {
        $email    = trim($this->input->post('email', TRUE));
        $password = $this->input->post('password', TRUE);

        if (empty($email) || empty($password)) {
            $this->session->set_flashdata('error', 'Veuillez remplir tous les champs.');
            redirect('sign-in');
        }

        $user = $this->auth->get_user_by_email($email);

        if (!$user) {
            $this->session->set_flashdata('error', 'Email ou mot de passe incorrect.');
            redirect('sign-in');
        }

        if (!password_verify($password, $user->password_hash)) {
            $this->session->set_flashdata('error', 'Email ou mot de passe incorrect.');
            redirect('sign-in');
        }

        $this->session->set_userdata([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'role_id'    => $user->role_id,
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'email'      => $user->email,
            'logged_in'  => TRUE
        ]);

        redirect('main-dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('sign-in');
    }
}