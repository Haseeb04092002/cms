<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('user_id')) {
            $this->session->sess_destroy();
            redirect('Login');
        }
    }

    function simplify_text($string)
    {
        // Convert to lowercase
        if(!empty($string)){
            $string = strtolower($string);
        }

        // Replace any non-alphanumeric characters (including spaces) with underscore
        // $string = preg_replace('/[^a-z0-9]+/', '_', $string);

        // Remove leading and trailing underscores
        // $string = trim($string, '_');

        return $string;
    }
}
