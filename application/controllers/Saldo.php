<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Saldo extends CI_Controller
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

	function __construct()
	{
		// require_once APPPATH . 'third_party/PhpSpreadsheet/src/Bootstrap.php';
		parent::__construct();
		$this->load->model('SaldoAkhir_m', 'saldoakhir');
		$this->load->model('nota_Management_m', 'nota_management');
		$this->load->helper(array('form', 'url'));
		$this->load->library('upload');
		// if (!$this->session->userdata('user_logged_in')) {
		// 	redirect('auth'); // Redirect to the 'autentic' page
		// }
	}

	public function index()
	{
		$data['anggota'] = $this->nota_management->get_anggota();
		$data['content']     = 'webview/admin/saldo/saldo_v';
		$data['content_js'] = 'webview/admin/saldo/saldo_js';
		$this->load->view('parts/admin/Wrapper', $data);
	}

	public function ajax_list()
	{
		$list = $this->saldoakhir->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $cat->nama;
			$row[] = number_format(($cat->saldo_simpanan_akhir == null ? 0 : $cat->saldo_simpanan_akhir), 0, '.', ',');
			$row[] = number_format(($cat->saldo_pinjaman_akhir == null ? 0 : $cat->saldo_pinjaman_akhir), 0, '.', ',');
			$row[] = $cat->tanggal_data;
			$row[] = '<center> <div class="list-icons d-inline-flex">
                <a title="Update User" onclick="onEdit(' . $cat->id . ')" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg></a>
                                        <a title="Delete User" onclick="onDelete(' . $cat->id . ')" class="btn btn-danger"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg></a>
            </div>
        </center>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->saldoakhir->count_all(),
			"recordsFiltered" => $this->saldoakhir->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function cat_list()
	{
		$items = $this->saldoakhir->get_category(); // Retrieve items from the model
		echo json_encode($items); // Return the items as JSON

	}

	public function save()
	{
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		$id_anggota = $this->input->post('id_anggota');
		$saldo_simpanan_akhir = $this->input->post('saldo_simpanan_akhir');
		$saldo_pinjaman_akhir = $this->input->post('saldo_pinjaman_akhir');

		// Check if a result was found
		// Access the uid

		// Cek Data di database
		$tanggal = $this->input->post('tanggal');

		$month = date('m', strtotime($tanggal)); // Get the month
		$year = date('Y', strtotime($tanggal));  // Get the year
		// Build the query
		$this->db->from('saldo'); // Your table name
		$this->db->where(
			'MONTH(tanggal_data)',
			$month
		); // Filter by month
		$this->db->where('YEAR(tanggal_data)', $year);   // Filter by year
		$this->db->where('id_anggota', $id_anggota);              // Filter by UID_User
		$cek_data = $this->db->get()->row(); // Execute the query

		// if ($cek_data != null) {
		if (!empty($cek_data)) {
			$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
			$data_update = [
				// 'updated'           => $date->format('Y-m-d H:i:s'),
				'saldo_simpanan_akhir' => floatval(str_replace(',', '', $saldo_simpanan_akhir)),
				'saldo_pinjaman_akhir' => floatval(str_replace(',', '', $saldo_pinjaman_akhir)),
				'tanggal_data' => $this->input->post('tanggal'),
			];

			$this->saldoakhir->update_user($data_update, array('id' => $cek_data->id));
			// $this->db->update('saldo', $data_update, array('id' => $id_anggota));

			echo json_encode(array("status" => 'Menimpa', "id" => $id_anggota, "Cek Data" => $cek_data));
		} else {
			$this->db->insert('saldo', [
				'id_anggota' => $id_anggota,
				'saldo_simpanan_akhir' => floatval(str_replace(',', '', $saldo_simpanan_akhir)),
				'saldo_pinjaman_akhir' => floatval(str_replace(',', '', $saldo_pinjaman_akhir)),
				'tanggal_data' => $this->input->post('tanggal'),
			]);
			echo json_encode(array("status" => TRUE));
		}
	}

	public function ajax_edit($id)
	{
		$data = $this->saldoakhir->get_id_edit($id);

		echo json_encode($data);
	}
	public function cari($bulan, $tahun)
	{
		$data = $this->saldoakhir->get_cari($bulan, $tahun);
		if (!empty($data)) {
			echo json_encode(array("status" => "Success", "data" => $data));
		} else {
			echo json_encode(array("status" => "No Data"));
		}
	}
	public function update()
	{
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		// $id_edit = $this->input->post('id');
		$saldo_simpanan_akhir = $this->input->post('saldo_simpanan_akhir');
		$saldo_pinjaman_akhir = $this->input->post('saldo_pinjaman_akhir');
		$tanggal_data = $this->input->post('tanggal');

		// Assuming $date is a DateTime object
		$data_update = [
			// 'updated'           => $date->format('Y-m-d H:i:s'),
			'saldo_simpanan_akhir' => floatval(str_replace(',', '', $saldo_simpanan_akhir)),
			'saldo_pinjaman_akhir' => floatval(str_replace(',', '', $saldo_pinjaman_akhir)),
			'tanggal_data'     => $tanggal_data
		];

		$this->saldoakhir->update_user($data_update, array('id' => $this->input->post('id_edit')));
		echo json_encode(array("status" => TRUE));
	}

	public function delete()
	{
		$this->db->delete('saldo', array('id' => $this->input->post('id_delete')));

		echo json_encode(array("status" => TRUE));
	}

	private function clean_input($value)
	{
		return str_replace([',', '.'], '', $value);
	}

	public function process_insert_excel()
	{
		// Set headers for Server-Sent Events
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache'); // Recommended for SSE
		header('Connection: keep-alive'); // Recommended for SSE

		set_time_limit(300); // 300 seconds = 5 minutes

		// Configure upload settings
		$config['upload_path'] = FCPATH . 'uploads/saldo/';
		$config['allowed_types'] = 'xls|xlsx|csv'; // Allowed file types

		// $this->load->library('upload', $config);
		$this->upload->initialize($config);
		// Debugging output


		if (!$this->upload->do_upload('file')) {
			// If the upload fails, show the error
			$error = array('error' => $this->upload->display_errors());
			echo json_encode(['status' => false, 'message' => $error]);
			exit;
		} else {
			// Get file info
			$this->load->library('upload');
			require APPPATH . 'third_party/autoload.php';
			require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';
			set_time_limit(300); // 300 seconds = 5 minutes

			$file_data = $this->upload->data();
			$file_path = $file_data['full_path'];

			try {
				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
				$worksheet = $spreadsheet->getActiveSheet();

				// Iterate over each row
				$rowCounterCekUser = 1; // Start at 1 since the first row (0) is the header
				$totalRows = iterator_count($worksheet->getRowIterator()); // Get the total rows for progress calculation
				$totalRows -= 2; // Adjust for headers
				$insertedRows = 0;

				foreach ($worksheet->getRowIterator() as $row) {
					// Increment the row counter
					$rowCounterCekUser++;

					// Initialize inserted rows counter
					// Skip the first row (header)
					if (
						$rowCounterCekUser === 2 || $rowCounterCekUser === 3
					) {
						continue; // Skip processing for the header row
					}

					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells, even empty ones

					$data = []; // Create an array to hold row data
					foreach ($cellIterator as $cell) {
						$data[] = $cell->getValue(); // Get cell value
					}

					// Assuming columns are: 'Nama' in column A, 'kd_peserta' in column B, etc.
					$nomor_anggota = isset($data[1]) ? $data[1] : null; // Column 

					$this->db->select('id'); // Select the uid column
					$this->db->from('anggota'); // Your table name
					$this->db->where('nomor_anggota', $nomor_anggota); // Filter by kd_peserta
					$result = $this->db->get()->row(); // Execute the query
					if (empty($result)) {
						echo json_encode(array("status" => "Data Peserta Tidak Ada", 'nomor_anggota' => $nomor_anggota));
						return;
					}
				}

				$rowCounter = 1; // Start at 1 since the first row (0) is the header
				// INPUT DATA USER
				$totalRows = iterator_count($worksheet->getRowIterator()); // Get the total rows for progress calculation
				$totalRows -= 2; // Adjust for headers
				$insertedRows = 0; // Initialize inserted rows counter

				foreach ($worksheet->getRowIterator() as $row) {
					// Increment the row counter
					$rowCounter++;

					// Skip the first row (header)
					if (
						$rowCounter === 2 || $rowCounter === 3
					) {
						continue; // Skip processing for the header row
					}

					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells, even empty ones

					$data = []; // Create an array to hold row data
					foreach ($cellIterator as $cell) {
						$data[] = $cell->getValue(); // Get cell value
					}

					// Assuming columns are: 'Nama' in column A, 'kd_peserta' in column B, etc.
					$kd_peserta = isset($data[1]) ? $data[1] : null; // Column 
					$saldo_simpanan_akhir = isset($data[2]) ? $data[2] : null; // Column 
					$saldo_pinjaman_akhir = isset($data[3]) ? $data[3] : null; // Column 
					// Cek Data di database
					$tanggal = $this->input->post('tanggal');
					// Extract the month and year from the input date
					$month = date('m', strtotime($tanggal)); // Get the month
					$year = date('Y', strtotime($tanggal));  // Get the year
					// Build the query
					// Get KD Peserta
					$this->db->select('id'); // Select the uid column
					$this->db->from('anggota'); // Your table name
					$this->db->where('nomor_anggota', $nomor_anggota); // Filter by kd_peserta
					$result = $this->db->get()->row(); // Execute the query
					$id = $result->id;

					$this->db->from('saldo'); // Your table name
					$this->db->where(
						'MONTH(tanggal_data)',
						$month
					); // Filter by month
					$this->db->where('YEAR(tanggal_data)', $year);   // Filter by year
					$this->db->where('id_anggota', $id);              // Filter by UID_User
					$cek_data = $this->db->get()->row(); // Execute the query

					if ($cek_data) { // If data exists, update it
						$this->db->where('id', $cek_data->id);
						$this->db->update('saldo', [
							'saldo_simpanan_akhir' => floatval(str_replace(',', '', $saldo_simpanan_akhir)),
							'saldo_pinjaman_akhir' => floatval(str_replace(',', '', $saldo_pinjaman_akhir)),
							'tanggal_data' => $this->input->post('tanggal'), // Keep the original date or update as needed
						]);
						// echo "data: " . json_encode(['message' => 'Updated existing data', 'id' => $id]) . "\n\n"; // Optional for debugging
					} else { // If no data exists, insert new
						$this->db->insert('saldo', [
							'id_anggota' => $id,
							'saldo_simpanan_akhir' => floatval(str_replace(',', '', $saldo_simpanan_akhir)),
							'saldo_pinjaman_akhir' => floatval(str_replace(',', '', $saldo_pinjaman_akhir)),
							'tanggal_data' => $this->input->post('tanggal'),
						]);
						// echo "data: " . json_encode(['message' => 'Inserted new data', 'id' => $id]) . "\n\n"; // Optional for debugging
					}

					// echo json_encode(array("status" => 'Menimpa', "uid" => $uid, "Cek Data" => $cek_data));

				}
				echo json_encode(array("status" => True));
				return;
			} catch (Exception $e) {
				// echo 'Error loading file: ', $e->getMessage();
				echo json_encode(array("status" => False));
			}
		}
		// echo json_encode(array("status" => TRUE));
	}
}
