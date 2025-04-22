<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		if ($this->session->userdata('user_logged_in') == True) {
			redirect('dashboard');
		}
		// $data['content'] = 'webview/auth/login_v';
		// $data['content_js'] = 'webview/auth/login_js';
		$data['content'] = 'webview/auth/kasir_v';
		$data['content_js'] = 'webview/auth/kasir_js';

		$this->load->view('parts/index_1/wrapper', $data);
	}
	// public function admin()
	// {
	// 	if ($this->session->userdata('user_logged_in') == True) {
	// 		redirect('dashboard');
	// 	}
	// 	$data['content'] = 'webview/auth/login_v';
	// 	$data['content_js'] = 'webview/auth/login_js';

	// 	$this->load->view('parts/index_1/wrapper', $data);
	// }
	// public function register()
	// {
	// 	if ($this->session->userdata('user_logged_in') == True) {
	// 		redirect('dashboard');
	// 	}
	// 	$data['content'] = 'webview/auth/register_v';
	// 	$data['content_js'] = 'webview/auth/register_js';
	// 	$this->load->view('parts/index_1/wrapper', $data);
	// }
	public function login_admin_process()
	{

		$this->load->model('Auth_m', 'login');

		$username = $this->input->post('email');
		$password = $this->input->post('password');
		$active     = 1;


		$user = $this->login->user_login($username, $password, $active);

		if (!empty($user)) {

			if ($user->role_id == 1) {
				$role = 'Admin';
			} else if ($user->role_id == 2) {
				$role = 'User';
			}
			$this->session->set_userdata([
				'user_user_id'   => $user->uid,
				'name'  => $user->nama,
				'role_id'      => $user->role_id,
				'role'      => $role,
				'id_toko'      => 1,
				'user_email'      => $user->email,
				// 'last_acces_time'      => $user->last_acces,
				'user_logged_in' => true
			]);

			if ($user->role_id == 1) {
				echo json_encode(array("status" => 'admin'));
			} else if ($user->role_id == 2) {
				echo json_encode(array("status" => 'user'));
			}
		} else {
			echo json_encode(array("status" => 'Gagal Cari'));
		}
	}
	public function login_process()
	{

		$this->load->model('Auth_m', 'login');

		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$active     = 1;


		$user = $this->login->user_kasir_login($username, $password, $active);

		if (!empty($user)) {

			// if ($user->role_id == 1) {
			// 	$role = 'Admin';
			// } else if ($user->role_id == 2) {
			// 	$role = 'User';
			// }
			if ($user->role == 1) {
				$role = 'Admin';
			} else if ($user->role == 2) {
				$role = 'Koperasi';
			} else if ($user->role == 3) {
				$role = 'Kasir';
			} else if ($user->role == 4) {
				$role = 'Anggota';
			}
			$this->session->set_userdata([
				'user_user_id'   => $user->id,
				'name'  => $user->nama,
				'username'      => $user->username,
				'id_toko'      => $user->id_toko,
				'id_koperasi'      => $user->id_koperasi,

				'role_id'      => $user->role,
				'role'      => $role,
				'user_logged_in' => true
			]);
			echo json_encode(array("status" => 'Success'));

			// if ($user->role_id == 1) {
			// 	echo json_encode(array("status" => 'admin'));
			// } else if ($user->role_id == 2) {
			// 	echo json_encode(array("status" => 'user'));
			// }
		} else {
			echo json_encode(array("status" => 'Gagal Cari'));
		}
	}
	public function register_process()
	{
		$this->load->model('Auth_m', 'regis');
		$email = $this->input->post('email');

		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $email);
		$user = $this->db->get()->row();

		if (empty($user)) {


			$enc_password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

			$this->load->helper('string');
			$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));

			$data = array(
				'created'         => $date->format('Y-m-d H:i:s'),
				'nama'           => $this->input->post('nama'),
				'email'           => $this->input->post('email'),
				'active'          => 1,
				'role_id'        => 2,
				'password'        => $enc_password,
			);
			$this->db->insert('user', $data);


			$data = array("status" => 'berhasil');
			echo json_encode($data);
		} else {

			$data = array("status" => 'Email Sudah Digunakan');
			echo json_encode($data);
		}
	}

	public function logout()
	{

		$this->session->unset_userdata('user_user_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('user_logged_in');
		// $this->session->unset_userdata('user_email');
		$this->session->sess_destroy();

		$url = base_url();
		redirect('auth');
	}

	public function check_email()
	{
		if ($this->session->userdata('user_logged_in') == 'true') {
			redirect('dashboard');
		}

		$data['content']  = 'webview/Auth/check_email/check_email_view';
		$data['content_js'] = 'webview/Auth/check_email/check_email_js';
		$this->load->view('_parts/Wrapper_auth', $data);
	}
	public function reset_password()
	{
		$this->load->model('Auth_m', 'user');

		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $this->input->post('email'));
		$user = $this->db->get()->result();

		if (!empty($user)) {
			$this->load->helper('string');
			$token_id = random_string('alnum', 32);

			$this->user->update(
				array(

					'token_reset'       => $token_id,

				),
				array('email' => $this->input->post('email'))
			);
			$url = 'auth/confirm_reset/' . $token_id;
			echo json_encode(array("status" => True, "url" => $url));
		} else {
			echo json_encode(array("status" => "Email Tidak Ada"));
		}
	}
}
