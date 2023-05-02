<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Access extends AdminController
{

	public function __construct()
	{
		parent::__construct();
		$this->logged_in();
        // $this->smarty_acl->authorized(); // Even do authorize check. 
        $this->smarty_acl->module_authorized('roles'); //  在 SmartACL 是 roles (roles是管理 role 及 Permission)
		$this->load->model('access_model', 'model');
	}

	public function index()
	{
		$_admins = $this->smarty_acl->admins(false);
        $admin_role_id = $_admins[0]['role_id'];
		if ($admin_role_id != 1) {
			$roles = $this->db->query('SELECT id as id_role, name as role FROM acl_roles WHERE id != 1')->result();
			$menus = $this->db->query('SELECT * FROM user_menu WHERE id_menu != 1 ORDER BY no_order ASC')->result();
		} else {
			//$roles = $this->db->get('acl_roles')->result();
			$roles = $this->db->query('SELECT id as id_role, name as role FROM acl_roles')->result();
			$menus = $this->db->get('user_menu')->result();
		}

		foreach($roles as $role) {
			$tmp[$role->id_role] = [];
			foreach($menus as $menu) {
				$_check_val= '';
				if ( $role->id_role == 1 && $menu->id_menu == 1) {
					$_check_val= 'disabled checked';
				} else {
					$cek = $this->db->get_where('user_access', ['id_role' => $role->id_role, 'id_menu' => $menu->id_menu])->row();
					$_check_val= ( $cek ) ? 'checked' : '';
				}
				$tmp[$role->id_role][$menu->id_menu] = $_check_val;
			}
		}

		$data = [
			'title' => 'Access Page',
			'roles' => $roles,
			'menus' => $menus,
			'permission' => $tmp
		];
		$this->load->view('_layout/general/head', $data);
		$this->load->view('core/js', $data);
		$this->load->view('index', $data);
	}
	public function aksi()
	{
		$data = $this->model->aksi();
		echo json_encode($data);
	}
}
