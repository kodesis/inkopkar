<?php defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('parts/Admin/Header');
$this->load->view('parts/Admin/Sidebar');
$this->load->view('parts/Admin/TopNavbar');
$this->load->view($content);
// $this->load->view('layouts/_parts/nav_bottom');
$this->load->view('parts/Admin/Footer');
$this->load->view('parts/Admin/JS');
if (isset($content_js)) $this->load->view($content_js);
