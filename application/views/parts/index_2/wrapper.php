<?php defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('parts/index_2/header');
$this->load->view('parts/index_2/navbar');
$this->load->view($content);
$this->load->view('parts/index_2/footer');
$this->load->view('parts/index_2/js');
if (isset($content_js)) $this->load->view($content_js);
