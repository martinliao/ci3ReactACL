<?php
defined('BASEPATH') or exit('No direct script access allowed');

//class User extends MY_Controller
class User extends AdminController
{

	public function __construct()
	{
		
		parent::__construct();
		$this->logged_in();
        // $this->smarty_acl->authorized(); // Even do authorize check. 
        $this->smarty_acl->module_authorized('users'); //  在 SmartACL 是 users
		$this->load->model('user_model', 'model');
	}


	public function index()
	{
		$_admins = $this->smarty_acl->admins(false);
        #$this->role_id = $_admins[0]['role_id'];
		$data = [
			'title' => 'User',
			'roles' => $this->db->get('acl_roles')->result(),
			'admin_role_id' => $_admins[0]['role_id']
		];
		$this->load->view('_layout/general/head', $data);
		$this->load->view('core/js', $data);
		$this->load->view('core/modals', $data);
		$this->load->view('index', $data);
	}

	function getLists()
	{
		$data = array();
		$_admins = $this->smarty_acl->admins(false);
        $admin_role_id = $_admins[0]['role_id'];

		// Fetch member's records
		$users = $this->model->getRows($_POST);

		$i = $_POST['start'];
		foreach ($users as $user) {
			//if ($this->session->userdata('role') != 1) {
			if ($admin_role_id != 1) {
				if ($user->id != 1) {
					$i++;
					$disabled = '';
					if ($user->id_role == 1) {
						$disabled = 'disabled';
					}
					if ($user->status == 'active') {
						$active = '<input type="radio" ' . $disabled . ' name="active" class="form-control-sm"  data-id_user="' . $user->id . '" data-active="1" form-control-sm" id="active" checked>';
					} else {
						$active = '<input type="radio" ' . $disabled . ' name="active" class="form-control-sm"  data-id_user="' . $user->id . '" data-active="0" form-control-sm" id="active" >';
					}
					$btn_reset = '<button type="button" class="btn btn-info btn-xs reset" data-id_reset="' . $user->id . '"><i class="fas fa-fw fa-cog"></i> Reset Password</button>';
					$btn_edit = '<button type="button" class="btn btn-warning btn-xs edit"  data-user="' . $user->username . '" data-id_role="' . $user->role_id . '" data-id="' . $user->id . '"><i class="fas fa-fw fa-pen"></i> Edit</button>';
					$data[] = array($i, $user->username, $user->role, $active, $btn_reset . ' ' . $btn_edit);
				}
			} else {
				$i++;
				$disabled = '';
				if ($user->role_id == 1) {
					$disabled = 'disabled';
				}
				if ($user->status == 'active') {
					$active = '<input type="checkbox" ' . $disabled . ' name="active" class="form-control-sm" data-id_user="' . $user->id . '" data-active="1" form-control-sm" id="active" checked>';
				} else {
					$active = '<input type="checkbox" ' . $disabled . ' name="active" class="form-control-sm" data-id_user="' . $user->id . '" data-active="0" form-control-sm" id="active" >';
				}
				$btn_reset = '<button type="button" class="btn btn-info btn-xs reset" data-id_reset="' . $user->id . '"><i class="fas fa-fw fa-cog"></i> Reset Password</button>';
				$btn_edit = '<button type="button" class="btn btn-warning btn-xs edit"  data-user="' . $user->username . '" data-id_role="' . $user->role_id . '" data-id="' . $user->id . '"><i class="fas fa-fw fa-pen"></i> Edit</button>';
				$btn_hapus = '<button type="button" class="btn btn-danger btn-xs hapus"  data-id_hapus="' . $user->id . '"><i class="fas fa-fw fa-trash"></i> Hapus</button>';
				$data[] = array($i, $user->username, $user->role, $active, $btn_reset . ' ' . $btn_edit . ' ' . $btn_hapus);
			}
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->model->countAll(),
			"recordsFiltered" => $this->model->countFiltered($_POST),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function aksi()
	{
debugBreak();
		if ($_POST['aksi'] == 'tambah') {
			$data = $this->model->tambah();
			echo json_encode($data);
		} else if ($_POST['aksi'] == 'edit') {
			$data = $this->model->edit();
			echo json_encode($data);
		} else if ($_POST['aksi'] == 'hapus') {
			$data = $this->model->hapus();
			echo json_encode($data);
		} else if ($_POST['aksi'] == 'reset') {
			$data = $this->model->reset();
			echo json_encode($data);
		}
	}
	public function active()
	{
		$data = $this->model->active();
		echo json_encode($data);
	}
}
