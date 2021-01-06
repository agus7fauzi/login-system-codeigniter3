<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function setImage($fileName)
    {
        $this->db->set('image', $fileName);
    }

    public function setNameByEmail($email)
    {
        $this->db->set('name', $this->input->post('name'));
        $this->db->where('email', $email);
        $this->db->update('users');
    }

    public function setPassword($newPassword)
    {
        $this->db->set('password', password_hash($newPassword, PASSWORD_DEFAULT));
        $this->db->where('email', $this->session->userdata('email'));
        $this->db->update('users');
    }
}
