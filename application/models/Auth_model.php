<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function getUserByEmail($email)
    {
        return $this->db->get_where('users', [
            'email' => $email,
        ])->row_array();
    }

    public function setUserToken($token)
    {
        $email = htmlspecialchars($this->input->post('email', true));

        $this->db->insert('users_token', [
            'email' => $email,
            'token' => $token,
            'date_created' => time(),
        ]);
    }

    public function setUser()
    {
        $this->db->insert('users', [
            'name' => htmlspecialchars($this->input->post('name', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'image' => 'default.png',
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 0,
            'date_created' => time(),
        ]);
    }

    public function getUserTokenByEmail($email)
    {
        return $this->db->get_where('users_token', ['email' => $email])->row_array();
    }

    public function getUserTokenByToken($token)
    {
        return $this->db->get_where('users_token', ['token' => $token])->row_array();
    }

    public function unsetUserByEmail($email)
    {
        $this->db->delete('users', ['email' => $email]);
    }

    public function unsetUserTokenByEmail($email)
    {
        $this->db->delete('users_token', ['email' => $email]);
    }

    public function setUserActiveByEmail($email)
    {
        $this->db->update('users', ['is_active' => 1], ['email' => $email]);
        $this->db->delete('users_token', ['email' => $email]);
    }

    public function getUserActiveByEmail($email)
    {
        return $this->db->get_where('users', ['email' => $email, 'is_active' => 1])->row_array();
    }

    public function setUserPassword()
    {
        $this->db->update(
            'users',
            ['password' => password_hash($this->input->post('newPassword'), PASSWORD_DEFAULT)],
            ['email', $this->session->userdata('reset_email')],
        );
    }
}