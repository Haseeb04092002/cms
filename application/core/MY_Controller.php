<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('user_agent');

        $is_logged_in = $this->session->userdata('user_id');
        $is_mobile    = $this->agent->is_mobile();

        // Get current controller
        $controller = strtolower($this->router->class);
        redirect('login');

        // Allow login controllers without redirect
        // $auth_controllers = ['login', 'pwa'];

        // if (!$is_logged_in && !in_array($controller, $auth_controllers)) {

        //     $this->session->sess_destroy();

        //     // if ($is_mobile) {
        //         // redirect('pwa/login');
        //     // } else {
        //         redirect('login');
        //     // }
        // }
    }

    // public function __construct()
    // {
    //     parent::__construct();

    //     // Allow manifest & service worker
    //     $uri = $_SERVER['REQUEST_URI'];
    //     if (
    //         strpos($uri, 'manifest.json') !== false ||
    //         strpos($uri, 'service-worker.js') !== false
    //     ) {
    //         return;
    //     }

    //     $this->load->library('user_agent');

    //     $is_logged_in = $this->session->userdata('user_id');
    //     $controller  = strtolower($this->router->class);

    //     $auth_controllers = ['login', 'pwa'];

    //     if (!$is_logged_in && !in_array($controller, $auth_controllers)) {
    //         redirect('pwa/login');
    //     }
    // }



    function simplify_text($string)
    {
        // Convert to lowercase
        if (!empty($string)) {
            $string = strtolower($string);
        }

        // Replace any non-alphanumeric characters (including spaces) with underscore
        // $string = preg_replace('/[^a-z0-9]+/', '_', $string);

        // Remove leading and trailing underscores
        // $string = trim($string, '_');

        return $string;
    }
}
