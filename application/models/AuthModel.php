<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthModel extends CI_Model
{
    public function get_user_by_email($email)
    {
        return $this->db
            ->where('email', $email)
            ->where('status', 'active')
            ->get('users')
            ->row();
    }

    public function getRoleName($id_role)
    {
        return $this->db
            ->where('id', $id_role)
            ->get('roles')
            ->row()->name;
    }
}
