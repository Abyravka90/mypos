<?php

class Auth extends CI_Controller {
	public function login()
	{
		check_already_login();
		$this->load->view('login');
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['login'])){
			//call the model here
			$this->load->model('User_m');
			$query = $this->User_m->login($post);
			if($query->num_rows() > 0){
				//bedanya result dan rows kalau result hanya satu kalau result di extract semua
				$row = $query->row();
				$params =  array(
					'userid' => $row->user_id,
					'level' => $row->level
				);
				$this->session->set_userdata($params);
				echo 
				'<script>
					alert("Selamat, login berhasil ");
					window.location="'.site_url('dashboard').'";
				</script>';
			} else {
				echo 
				'<script>
					alert("Login Gagal, Username / password salah ");
					window.location="'.site_url('auth/login').'";
				</script>';			}
		}
	}

	public function logout()
	{
		$params = array('userid', 'level');
		$this->session->unset_userdata($params);
		redirect('auth/login');
	}
}
