<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function getUsersRole()
    {
        return $this->db->get('user_roles')->result_array();
    }

    public function getUserRoleById($id)
    {
        return $this->db->get_where('user_roles', ['id' => $id])->row_array();
    }

    public function getUserAccessMenu()
    {
        return $this->db->get_where('user_access_menu', [
            'role_id' => htmlspecialchars($this->input->post('roleId', true)),
            'menu_id' => htmlspecialchars($this->input->post('menuId', true)),
        ])->num_rows();
    }

    public function setUserAccessMenu()
    {
        $this->db->insert('user_access_menu', [
            'role_id' => htmlspecialchars($this->input->post('roleId', true)),
            'menu_id' => htmlspecialchars($this->input->post('menuId', true)),
        ]);
    }

    public function unsetUserAccessMenu()
    {
        $this->db->delete('user_access_menu', [
            'role_id' => htmlspecialchars($this->input->post('roleId', true)),
            'menu_id' => htmlspecialchars($this->input->post('menuId', true)),
        ]);
    }

    public function getRoleById($id)
    {
        return $this->db->get_where('user_roles', ['id' => $id])->row_array();
    }
    public function addRole()
    {
        $this->db->insert('user_roles', ['role' => htmlspecialchars($this->input->post('roleName'))]);
    }

    public function resetRole($id)
    {
        $roleName = htmlspecialchars($this->input->post('roleName', true));
        if ($roleName != 'Administrator') {
            $this->db->update(
                'user_roles',
                ['role' => $roleName],
                ['id' => $id],
            );
        } else {
            redirect('auth/blocked');
        }
    }

    public function deleteRole($id)
    {
        return $this->db->delete('user_roles', ['id' => $id]);
    }
}
