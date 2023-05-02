<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends AdminController
{

	public function __construct()
	{
		parent::__construct();
		$this->logged_in();
        // $this->smarty_acl->authorized(); // Even do authorize check. 
        $this->smarty_acl->module_authorized('roles'); //  在 SmartACL 是 roles
		$this->load->model('role_model', 'model');
	}

	public function index()
	{
		$data = [
			'title' => 'Role'
		];
		$this->load->view('_layout/general/head', $data);
		$this->load->view('core/js', $data);
		$this->load->view('core/modals', $data);
		$this->load->view('index', $data);
	}

	function getLists()
	{
		$data = array();

		// Fetch member's records
		$role = $this->model->getRows($_POST);

		$i = $_POST['start'];
		foreach ($role as $d) {
			/*if ($this->session->userdata('role') != 1) {
				if ($d->id != 1) {
					$i++;
					$btn_edit = '<button type="button" class="btn btn-warning btn-xs edit" data-role="' . $d->name . '" data-id_role="' . $d->id . '"><i class="fas fa-fw fa-pen"></i> Edit</button>';
					$btn_hapus = '<button type="button" class="btn btn-danger btn-xs hapus"  data-id_role="' . $d->id . '"><i class="fas fa-fw fa-trash"></i> Hapus</button>';
					$data[] = array($i, $d->name, $btn_edit . ' ' . $btn_hapus);
				}
			} else {*/
				$i++;
				$btn_edit = '<button type="button" class="btn btn-warning btn-xs edit" data-role="' . $d->name . '" data-id_role="' . $d->id . '"><i class="fas fa-fw fa-pen"></i> Edit</button>';
				$btn_hapus = '<button type="button" class="btn btn-danger btn-xs hapus"  data-id_role="' . $d->id . '"><i class="fas fa-fw fa-trash"></i> Hapus</button>';
				$data[] = array($i, $d->name, $btn_edit . ' ' . $btn_hapus);
			//}
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
		if ($_POST['aksi'] == 'tambah') {
			$data = $this->model->tambah();
			echo json_encode($data);
		} else if ($_POST['aksi'] == 'edit') {
			$data = $this->model->edit();
			echo json_encode($data);
		} else if ($_POST['aksi'] == 'hapus') {
			$data = $this->model->hapus();
			echo json_encode($data);
		}
	}
}
