<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'auth');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if (!$this->form_validation->run()) {
            $data['title'] = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $user = $this->auth->getUserByEmail(htmlspecialchars($this->input->post('email', true)));

        if (!$user) {
            sendMsg('danger', 'Email is not registered!', 'auth');
        } else {
            if ($user['is_active'] != 1) {
                sendMsg('danger', 'This Email has not been activated!', 'auth');
            } else {
                if (!password_verify($this->input->post('password'), $user['password'])) {
                    sendMsg('danger', 'Wrong password!', 'auth');
                } else {
                    $this->session->set_userdata([
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ]);

                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                }
            }
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('repeatPassword', 'Password', 'required|trim|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'Email has been alrady exists!',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[repeatPassword]', [
            'matches' => 'The Password don\'t match!',
            'min_length' => 'The Password too short!',
        ]);

        if (!$this->form_validation->run()) {
            $data['title'] = 'Registration';

            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {

            // $token = base64_encode(openssl_random_pseudo_bytes(32));
            $token = base64_encode(random_bytes((32)));
            $this->_sendEmail($token, 'verify');
            $this->auth->setUserToken($token);
            $this->auth->setUser();

            sendMsg('success', 'Congratulation! your account has been created! Please activate your account.', 'auth');
        }
    }

    public function verify()
    {
        $email = htmlspecialchars($this->input->get('email'));
        $token = htmlspecialchars($this->input->get('email'));

        if (!$this->auth->getUserTokenByEmail($email)) {
            sendMsg('danger', 'Account activation failed! Wrong email.', 'auth');
        } else {
            if (!$token = $this->auth->getUserTokenByToken($token)) {
                sendMsg('danger', 'Account activation failed! Wrong token.', 'auth');
            } else {
                if (!time() - $token['date_created'] >= 60 * 60 * 24) {
                    $this->auth->unsetUserTokenByEmail($email);

                    sendMsg('danger', 'Account activation failed! Token is expired.', 'auth');
                } else {
                    $this->auth->setUserActiveByEmail($email);

                    sendMsg('success', $email . ' has been activated! Please login.', 'auth');
                }
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        sendMsg('success', 'You has been logout!', 'auth');
    }

    public function blocked()
    {
        $data['title'] = 'Access Forbidden';

        $this->load->view('templates/header', $data);
        $this->load->view('auth/blocked');
        $this->load->view('templates/footer');
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if (!$this->form_validation->run()) {
            $data['title'] = 'Forgot Password';

            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $user = $this->auth->getUserActiveByEmail();

            if (!$user) {
                sendMsg('danger', 'Email is not registered or activated!', 'auth/forgotpassword');
            } else {
                $token = base64_encode(random_bytes(32));

                $this->auth->setUserToken($token);
                $this->_sendEMail($token, 'forgot');
                sendMsg('success', 'Please check your email to reset password!', 'auth/forgotpassword');
            }
        }
    }

    public function resetPassword()
    {
        $email = htmlspecialchars($this->input->get('email'));
        $token = $this->input->get('token');

        $user = $this->auth->getUserByEmail($email);

        if (!$user) {
            sendMsg('danger', 'Reset password failed! Wrong email.', 'auth');
        } else {
            if (!$this->auth->getUserTokenByToken($token)) {
                sendMsg('danger', 'Reset password failed! Wrong token.', 'auth');
            } else {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            }
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('newPassword', 'Password', 'required|trim|min_length[3]|matches[retypeNewPassword]');
        $this->form_validation->set_rules('retypeNewPassword', 'Retype Password', 'required|trim|min_length[3]|matches[newPassword]');
        if (!$this->form_validation->run()) {
            $data['title'] = 'Change Password';

            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            $this->auth->setUserPassword();
            $this->session->unset_userdata('reset_email');
            sendMsg('success', 'Password has been changed! Pleas login.', 'auth');
        }
    }

    // Private method
    private function _sendEMail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://mail.agus7fauzi-live.my.id',
            'smtp_user' => '',
            'smtp_pass' => '12345678X0',
            'smtp_port' => 587,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('<no-reply>@agus7fauzi-live.my.id', 'Agus7fauzi Admin');
        $this->email->to($this->input->post('email'));

        $email = htmlspecialchars($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Vertification');
            $this->email->message('Click this link to reset yout password: <a href="' . base_url() . 'auth/verify?email=' . $email . '&token=' . urlencode($token) . '">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to verify you account: <a href="' . base_url() . 'auth/resetpassword?email=' . $email . '&token=' . urlencode($token) . '">Reset Password</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
}
