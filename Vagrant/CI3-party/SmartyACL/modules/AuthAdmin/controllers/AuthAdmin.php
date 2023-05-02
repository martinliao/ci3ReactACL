<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthAdmin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('smarty_acl');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    /**
     * Login page
     */
    public function index()
    {
        if ($this->smarty_acl->logged_in()) {
            return redirect('admin');
        }
        //Rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        //Validate
        if ($this->form_validation->run() === TRUE) {
            //Login user
            $login = $this->smarty_acl->login(
                $this->input->post('username', true),
                $this->input->post('password', true),
                $this->input->post('remember', true)
            );
            //User logged in
            if ($login) {
                $this->session->set_flashdata('success_msg', 'User logged in successfully!');
                return redirect('/admin');
            }

            $this->session->set_flashdata('error_msg', $this->smarty_acl->errors());
            return redirect(current_url());
        }
        //Load view
        $this->admin_views('auth/login');
    }

    //Logout
    public function logout()
    {
        $this->smarty_acl->logout();
        return redirect('admin/login');
    }

    /**
     * Register
     */
    public function register()
    {
        if ($this->smarty_acl->logged_in()) {
            return redirect('admin');
        }
        //Rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[admins.username]|alpha_dash');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admins.email]');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[' . $this->config->item('min_password_length', 'smarty_acl') . ']');

        //Validate
        if ($this->form_validation->run() === TRUE) {
            //Register user
            $register = $this->smarty_acl->register(
                $this->input->post('username', true),
                $this->input->post('password', true),
                $this->input->post('email', true),
                [
                    'name' => $this->input->post('name', true)
                ]
            );
            //User registered
            if ($register) {
                $this->session->set_flashdata('success_msg', 'User created successfully!');
                return redirect(current_url());
            }

            $this->session->set_flashdata('error_msg', $this->smarty_acl->errors());
            return redirect(current_url());
        }
        //Load view
        $this->admin_views('auth/register');
    }

    /**
     * Activate account
     * @param integer $user_id
     * @param string $code
     */
    public function activate($user_id, $code)
    {
        if (!$user_id || !$code) {
            $this->session->set_flashdata('error_msg', 'Empty or invalid activation link!');
            return redirect('login');
        }
        //Activate user
        $activate = $this->smarty_acl->activate($user_id, $code);
        //Activation success
        if ($activate) {
            $this->session->set_flashdata('success_msg', 'Email confirmed successfully!');
            return redirect('login');
        }
        //Activation error
        $this->session->set_flashdata('error_msg', $this->smarty_acl->errors());
        return redirect('login');
    }

    /**
     * Resend Activation Link
     */
    public function resend_activation()
    {
        if ($this->smarty_acl->logged_in()) {
            return redirect('admin');
        }
        //Rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        //Validate
        if ($this->form_validation->run() === TRUE) {
            $activation = $this->smarty_acl->resend_activation($this->input->post('email', true));
            if ($activation) {
                $this->session->set_flashdata('success_msg', 'A fresh verification link has been sent to your email address!');
                return redirect(current_url());
            }

            $this->session->set_flashdata('error_msg', $this->smarty_acl->errors());
            return redirect(current_url());
        }
        //Load view
        $this->admin_views('auth/passwords/activation');
    }

    /**
     * Forgot Password
     */
    public function forgot_password()
    {
        if ($this->smarty_acl->logged_in()) {
            return redirect('admin');
        }
        //Rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        //Validate
        if ($this->form_validation->run() === TRUE) {
            $forgotten = $this->smarty_acl->forgotten_password($this->input->post('email', true));
            if ($forgotten) {
                $this->session->set_flashdata('success_msg', 'Password Reset Email Sent!');
                return redirect(current_url());
            }

            $this->session->set_flashdata('error_msg', $this->smarty_acl->errors());
            return redirect(current_url());
        }
        //Load view
        $this->admin_views('auth/passwords/forgot');
    }

    /**
     * Reset Password
     * @param string $code
     */
    public function reset_password($code)
    {
        if ($this->smarty_acl->logged_in()) {
            return redirect('admin');
        }
        //Validate code
        $user = $this->smarty_acl->forgotten_password_check($code);
        if (!$user) {
            $this->session->set_flashdata('error_msg', $this->smarty_acl->errors());
            return redirect('forgot_password');
        }
        //Rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admins.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password_confirmation]|min_length[' . $this->config->item('min_password_length', 'smarty_acl') . ']');
        $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required');

        //Validate
        if ($this->form_validation->run() === TRUE) {
            $reset = $this->smarty_acl->reset_password(
                $user,
                $this->input->post('email', true),
                $this->input->post('password', true),
            );
            if ($reset) {
                $this->session->set_flashdata('success_msg', 'Password Updated successfully!');
                return redirect('login');
            }

            $this->session->set_flashdata('error_msg', $this->smarty_acl->errors());
            return redirect(current_url());
        }
        //Load view
        $this->admin_views('auth/passwords/reset', ['code' => $code]);
    }

    /**
     * Load views from admin views path
     * @param $view
     * @param null $data
     */
    protected function admin_views($view, $data = null)
    {
        $this->load->view('' . $view, $data);
    }
}
