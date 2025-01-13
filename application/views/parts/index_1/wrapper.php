<?php defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('parts/index_1/header');
$this->load->view('parts/index_1/navbar');
$this->load->view($content);
$this->load->view('parts/index_1/footer');
$this->load->view('parts/index_1/js');
if (isset($content_js)) $this->load->view($content_js);
