<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLoggedIn();
        $this->load->model('Auth_model', 'auth');
        $this->load->model('Admin_model', 'admin');
        $this->load->model('Menu_model', 'menu');
    }

    public function index()
    {

        $data['title'] = 'Dasboard';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function roles()
    {
        $data['title'] = 'Roles';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));
        $data['role'] = $this->admin->getUsersRole();

        $this->form_validation->set_rules('roleName', 'Role Name', 'required|trim');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/roles', $data);
            $this->load->view('templates/footer');
        } else {
            $this->admin->addRole();
            sendMsg('success', 'New Role has been saved successfuly!', 'admin/roles');
        }
    }

    public function rolesAccess($id)
    {
        $data['title'] = 'Roles Access';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));
        $data['role'] = $this->admin->getUserRoleById($id);
        $data['menuListNonAdmin'] = $this->menu->getMenuListNonAdmin();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/roles-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        if ($this->admin->getUserAccessMenu() < 1) {
            $this->admin->setUserAccessMenu();
        } else {
            $this->admin->unsetUserAccessMenu();
        }

        sendMsg('success', 'Access has been changed successfully!');
    }

    public function editRole($id)
    {
        $data['title'] = 'Roles';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));
        $data['role'] = $this->admin->getUsersRole();

        $this->form_validation->set_rules('roleName', 'Role Name', 'required|trim');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/roles', $data);
            $this->load->view('templates/footer');
        } else {
            $this->menu->resetRole($id);
            sendMsg('success', 'Role has been changed successfuly!', 'admin/roles');
        }
    }

    public function deleteRole($id)
    {
        if ($this->admin->getRoleById($id)['role'] != 'Administrator') {
            if (!$this->admin->deleteRole($id)) {
                sendMsg('danger', 'Error happen with database!', 'admin/roles');
            } else {
                sendMsg('success', 'Role has been delete successfully!', 'admin/roles');
            }
        } else {
            redirect('auth/blocked');
        }
    }
}
