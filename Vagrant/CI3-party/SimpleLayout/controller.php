<?php

class User extends MX_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function dashboard()
  {
    $this->layout->set_layout('layout');
    $this->layout->view('account/dashboard');
  }

  function dashboard2()
  {
    $this->layout->set_layout('layout2');
    $this->layout->view('account/dashboard2');
  }
}
