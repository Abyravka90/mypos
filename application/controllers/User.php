<?php

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('User_m');

    }
	public function index()
	{

        $data['row'] = $this->User_m->get();
		$this->template->load('template', 'user/user_data', $data);
	}

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fullname', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]', array('matches' => '%s tidak sesuai dengan password'));
        $this->form_validation->set_rules('level', 'Level', 'required');

        $this->form_validation->set_message('required', '%s masih kosong silahkan isi');
        $this->form_validation->set_message('min_length', '{field} minimal 5 karakter');
        $this->form_validation->set_message('is_unique', '{field} ini sudah dipakai silahkan ganti');

        $this->form_validation->set_error_delimiters('<span class="help-block">','</span>');
        if ($this->form_validation->run() == FALSE)
                {
                    $this->template->load('template', 'user/user_form_add');
                }
                else
                {
                        $post = $this->input->post(null, TRUE);
                        $this->User_m->add($post);
                        if($this->db->affected_rows() > 0 ){
                            echo '<script>alert("data berhasil disimpan")</script>';
                        }
                        echo '<script>window.location="'.site_url('user').'"</script>';
                }
       
    }
}
