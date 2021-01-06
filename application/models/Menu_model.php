<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getMenuList()
    {
        return $this->db->get('user_menus')->result_array();
    }

    public function getMenuListNonAdmin()
    {
        return $this->db->get_where('user_menus', 'id!=1')->result_array();
    }

    public function getMenuById($id)
    {
        return $this->db->get_where('user_menus', ['id' => $id])->row_array();
    }

    public function setMenu()
    {
        $this->db->insert('user_menus', ['menu' => htmlspecialchars($this->input->post('menuName', true))]);
    }

    public function getSubMenu()
    {
        return $this->db->query(
            "SELECT `" . $this->db->dbprefix('user_sub_menus') . "`.*, `" . $this->db->dbprefix('user_menus') . "`.`menu`
               FROM `" . $this->db->dbprefix('user_sub_menus') . "` JOIN `" . $this->db->dbprefix('user_menus') . "`
                 ON `" . $this->db->dbprefix('user_sub_menus') . "`.`menu_id` = `" . $this->db->dbprefix('user_menus') . "`.`id`"
        )->result_array();
    }

    public function getSubMenuById($id)
    {
        return $this->db->get_where('user_sub_menus', ['id' => $id])->row_array();
    }

    public function setSubMenu()
    {
        $this->db->insert('user_sub_menus', [
            'title' => htmlspecialchars($this->input->post('title', true)),
            'menu_id' => htmlspecialchars($this->input->post('menu_id', true)),
            'url' => htmlspecialchars($this->input->post('url', true)),
            'icon' => htmlspecialchars($this->input->post('icon', true)),
            'is_active' => htmlspecialchars($this->input->post('is_active', true)),
        ]);
    }

    public function menu($roleId)
    {
        $menu = $this->db->query(
            "SELECT `" . $this->db->dbprefix('user_menus') . "`.`id`, `menu`
               FROM `" . $this->db->dbprefix('user_menus') . "` JOIN `" . $this->db->dbprefix('user_access_menu') . "`
                 ON `" . $this->db->dbprefix('user_menus') . "`.`id` = `" . $this->db->dbprefix('user_access_menu') . "`.`menu_id`
              WHERE `" . $this->db->dbprefix('user_access_menu') . "`.`role_id` = $roleId
           ORDER BY `" . $this->db->dbprefix('user_access_menu') . "`.`menu_id` ASC"
        )->result_array();

        $fullMenu = [];
        $fullMenu = $menu;
        foreach ($menu as $k => $menuItem) {
            $fullMenu[$k]['subMenu'] = $this->db->query(
                "SELECT *
               FROM `" . $this->db->dbprefix('user_sub_menus') . "` JOIN `" . $this->db->dbprefix('user_menus') . "`
                 ON `" . $this->db->dbprefix('user_sub_menus') . "`.`menu_id` = `" . $this->db->dbprefix('user_menus') . "`.`id`
              WHERE `" . $this->db->dbprefix('user_sub_menus') . "`.`menu_id` = {$menuItem['id']}
                AND `" . $this->db->dbprefix('user_sub_menus') . "`.`is_active` = 1"
            )->result_array();
        }
        return $fullMenu;
    }


    public function resetMenu($id)
    {
        $menuName = htmlspecialchars($this->input->post('menuName', true));
        if ($menuName != 'Admin' && $menuName != 'Menu') {
            $this->db->update(
                'user_menus',
                ['menu' => $menuName],
                ['id' => $id],
            );
        } else {
            redirect('auth/blocked');
        }
    }

    public function deleteMenu($id)
    {
        return $this->db->delete('user_menus', ['id' => $id]);
    }

    public function resetSubMenu($id)
    {
        $this->db->update(
            'user_sub_menus',
            [
                'title' => htmlspecialchars($this->input->post('title', true)),
                'menu_id' => htmlspecialchars($this->input->post('menu_id', true)),
                'url' => htmlspecialchars($this->input->post('url', true)),
                'icon' => htmlspecialchars($this->input->post('icon', true)),
                'is_active' => htmlspecialchars($this->input->post('is_active', true)),
            ],
            ['id' => $id],
        );
    }

    public function deleteSubMenu($id)
    {
        return $this->db->delete('user_sub_menus', ['id' => $id]);
    }
}