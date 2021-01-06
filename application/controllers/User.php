<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLoggedIn();
        $this->load->model('Auth_model', 'auth');
        $this->load->model('User_model', 'user');
        $this->load->model('Menu_model', 'menu');
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));

        $this->form_validation->set_rules('name', 'Full name', 'required|trim');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            if ($_FILES['image']['name']) {
                $config['upload_path']          = './assets/img/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2000;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    sendMsg('danger', $this->upload->display_errors(), 'user');
                } else {
                    $oldImage = $data['user']['image'];

                    if ($oldImage != 'default.png') {
                        unlink(FCPATH . 'assets/img/' . $oldImage);
                    }
                    $this->user->setImage($this->upload->data('file_name'));
                }
            }
            $this->user->setNameByEmail($data['user']['email']);
            sendMsg('success', 'Your profile has been updated successfully!', 'user');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['menu'] = $this->menu->menu($this->session->userdata('role_id'));
        $data['user'] = $this->auth->getUserByEmail($this->session->userdata('email'));

        $this->form_validation->set_rules('currentPassword', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('newPassword', 'New Password', 'required|trim|min_length[3]|matches[retypeNewPassword]');
        $this->form_validation->set_rules('retypeNewPassword', 'Confirm Password', 'required|trim|min_length[3]|matches[newPassword]');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/change-password', $data);
            $this->load->view('templates/footer');
        } else {
            $currentPassword = $this->input->post('currentPassword');
            $newPassword = $this->input->post('newPassword');

            if (!password_verify($currentPassword, $data['user']['password'])) {
                sendMsg('danger', 'Wrong current password!', 'user/changepassword');
            } else {
                if ($currentPassword == $newPassword) {
                    sendMsg('danger', 'New password can\'t be the same as current password!', 'user/changepassword');
                } else {
                    $this->user->setPassword($newPassword);

                    sendMsg('success', 'Change password has been succesfully!', 'user/changepassword');
                }
            }
        }
    }
}
