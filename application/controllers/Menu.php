<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLoggedIn();
        $this->load->model('Auth_model', 'auth');
        $this->load->model('Menu_model', 'menu');
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));
        $data['menuList'] = $this->menu->getMenuList();

        $this->form_validation->set_rules('menuName', 'Menu name', 'required');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->menu->setMenu();
            sendMsg('success', 'New menu has been saved successfuly!', 'menu');
        }
    }

    public function subMenu()
    {
        $data['title'] = 'Sub Menu Management';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));
        $data['subMenu'] = $this->menu->getSubMenu();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/sub-menu', $data);
            $this->load->view('templates/footer');
        } else {
            $this->menu->setSubMenu();
            sendMsg('success', 'New sub menu has been saved successfuly!', 'menu/submenu');
        }
    }

    public function editMenu($id)
    {
        $data['title'] = 'Menu Management';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));
        $data['menuList'] = $this->menu->getMenuList();

        $this->form_validation->set_rules('menuName', 'Menu name', 'required');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->menu->resetMenu($id);
            sendMsg('success', 'Menu has been changed successfuly!', 'menu');
        }
    }

    public function editSubMenu($id)
    {
        $data['title'] = 'Sub Menu Management';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));
        $data['subMenu'] = $this->menu->getSubMenu();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/sub-menu', $data);
            $this->load->view('templates/footer');
        } else {
            $this->menu->resetSubMenu($id);
            sendMsg('success', 'Sub Menu has been changed successfuly!', 'menu/submenu');
        }
    }

    public function deleteMenu($id)
    {
        $menu = $this->menu->getMenuById($id);
        if ($menu['menu'] != 'Admin' && $menu['menu'] != 'Menu') {
            if (!$this->menu->deleteMenu($id)) {
                sendMsg('danger', 'Error happen with database!', 'menu');
            } else {
                sendMsg('success', 'Menu has been delete successfully!', 'menu');
            }
        } else {
            redirect('auth/blocked');
        }
    }

    public function deleteSubMenu($id)
    {
        $subMenu = $this->menu->getSubMenuById($id);
        if ($subMenu['title'] != 'Menu Management' && $subMenu['title'] != 'Sub Menu Management') {
            if (!$this->menu->deleteSubMenu($id)) {
                sendMsg('danger', 'Error happen with database!', 'menu/submenu');
            } else {
                sendMsg('success', 'Sub Menu has been delete successfully!', 'menu/submenu');
            }
        } else {
            redirect('auth/blocked');
        }
    }
}
