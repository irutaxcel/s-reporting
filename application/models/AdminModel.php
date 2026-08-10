<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminModel extends CI_Model
{
    private $userTable = 'users';
    private $roleTable = 'roles';

    public function __construct()
    {
        parent::__construct();
    }

    /*
    |--------------------------------------------------------------------------
    | LISTE DES UTILISATEURS
    |--------------------------------------------------------------------------
    */

    public function getAllUsers()
    {
        return $this->db
            ->select('
            users.id,
            users.company_id,
            users.role_id,
            users.first_name,
            users.last_name,
            users.email,
            users.status,
            users.created_at,
            roles.name AS role_name
        ')
            ->from('users')
            ->join(
                'roles',
                'roles.id = users.role_id',
                'left'
            )
            ->order_by('users.id', 'DESC')
            ->get()
            ->result();
    }

    /*
    |--------------------------------------------------------------------------
    | RÉCUPÉRER UN UTILISATEUR
    |--------------------------------------------------------------------------
    */

    public function getUserById($id)
    {
        return $this->db
            ->select('
                users.id,
                users.company_id,
                users.role_id,
                users.first_name,
                users.last_name,
                users.email,
                users.status,
                users.created_at,
                roles.name AS role_name
            ')
            ->from($this->userTable)
            ->join(
                $this->roleTable,
                'roles.id = users.role_id',
                'left'
            )
            ->where('users.id', (int) $id)
            ->get()
            ->row();
    }

    /*
    |--------------------------------------------------------------------------
    | INSÉRER UN UTILISATEUR
    |--------------------------------------------------------------------------
    */

    public function insertUser(array $data)
    {
        $this->db->insert($this->userTable, $data);

        if ($this->db->affected_rows() <= 0) {
            return false;
        }

        return $this->db->insert_id();
    }


    public function userExists($userId)
    {
        return $this->db
            ->from($this->userTable)
            ->where('id', (int) $userId)
            ->count_all_results() > 0;
    }

    public function emailExistsForOtherUser($email, $userId)
    {
        return $this->db
            ->from($this->userTable)
            ->where('email', trim($email))
            ->where('id !=', (int) $userId)
            ->count_all_results() > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | MODIFIER UN UTILISATEUR
    |--------------------------------------------------------------------------
    */

    public function updateUser($id, array $data)
    {
        return $this->db
            ->where('id', (int) $id)
            ->update($this->userTable, $data);
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER UN UTILISATEUR
    |--------------------------------------------------------------------------
    */

    public function deleteUser($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->delete($this->userTable);
    }

    /*
    |--------------------------------------------------------------------------
    | VÉRIFIER L’EMAIL
    |--------------------------------------------------------------------------
    */

    public function emailExists($email, $exceptId = null)
    {
        $this->db
            ->from($this->userTable)
            ->where('email', trim($email));

        if (!empty($exceptId)) {
            $this->db->where('id !=', (int) $exceptId);
        }

        return $this->db->count_all_results() > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | RÔLES
    |--------------------------------------------------------------------------
    */

    public function getAllRoles()
    {
        return $this->db
            ->select('id, name, code')
            ->from($this->roleTable)
            ->order_by('name', 'ASC')
            ->get()
            ->result();
    }

    public function roleExists($roleId)
    {
        return $this->db
            ->from($this->roleTable)
            ->where('id', (int) $roleId)
            ->count_all_results() > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | STATISTIQUES
    |--------------------------------------------------------------------------
    */

    public function countUsers()
    {
        return $this->db
            ->from($this->userTable)
            ->count_all_results();
    }

    public function countUsersByStatus($status)
    {
        return $this->db
            ->from($this->userTable)
            ->where('status', $status)
            ->count_all_results();
    }

    public function countAdministrators()
    {
        return $this->db
            ->from($this->userTable)
            ->where_in('role_id', [1, 2])
            ->count_all_results();
    }

    /*
    |--------------------------------------------------------------------------
    | CHANGER LE STATUT
    |--------------------------------------------------------------------------
    */

    public function changeUserStatus($id, $status)
    {
        return $this->db
            ->where('id', (int) $id)
            ->update($this->userTable, [
                'status' => $status
            ]);
    }
}
