  public function importdatabase()
	{
		$this->load->library('migration');

		if ($this->migration->latest() === FALSE)
		{
			echo $this->migration->error_string();
		}
    $this->session->set_flashdata('success_msg','Database migrated successfully!');
		return redirect('/');
	}