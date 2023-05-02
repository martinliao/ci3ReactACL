<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        // $this->smarty_acl->authorized(); // Even do authorize check. 
        $this->smarty_acl->module_authorized('admins'); // 在 SmartACL 是 admins(reactadmin是dashboard)
        $this->load->model('admin_model', 'model');
    }

    /*
    * Index
    */
    public function index()
    {
        //react_admin('index'); // react_helper
        $this->render_page('dashboard', $this->data);
    }

    public function dashboard()
    {
        $this->load->view('_layout/general/head');
        $this->load->view('dashboard');
    }

    public function menu()
    {
        // Menu NO-Need authorized.
        //$tmp  = $this->smarty_acl->authorized();
        //$tmp  = $this->smarty_acl->has_permission('index');
        $_admins = $this->smarty_acl->admins(false);
        $role_id = $_admins[0]['role_id'];
        $data = $this->model->menu($role_id);
        echo json_encode($data);
    }
}
