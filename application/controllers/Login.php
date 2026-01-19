<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        $this->load->view('login');
    }

    public function logout()
    {
        // Clear all session data properly
        $this->session->unset_userdata([
            'user_id',
            'user_name',
            'user_Email',
            'last_activity'
        ]);
        $this->session->sess_destroy();
        redirect('Pakhtoon');
    }

    public function login()
    {
        $Response['status']  = false;
        $Response['message']  = "Some Error Occured. Try Again";

        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        // $this->form_validation->set_rules('WarehouseId', 'Warehouse', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
        }

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        // $WarehouseId = $this->input->post('WarehouseId');

        // $data = array();
        $data['Email'] = $email;
        $data['Password'] = $password;
        // // $data['WarehouseId'] = $WarehouseId;
        $check = $this->db->get_where('tbl_users', $data)->row();
        // $check = true;
        if ($check) {
            $this->session->set_userdata([
                'user_id'       => $check->userId,
                'user_name'     => $check->username,
                'user_email'    => $check->email,
                'user_role'    => $check->role??'admin',
                // 'warehouse_id'  => $check->WarehouseId,
                'station_id'    => $check->stationId,
                // 'station_name'  => $check->StationName,
                'last_activity' => time()
            ]);
            // $this->session->set_userdata([
            //     'user_id'       => '1',
            //     'user_name'     => '1',
            //     'user_Email'    => '1',
            //     'warehouse_id'  => '1',
            //     'station_id'    => '1',
            //     'station_name'  => '1',
            //     'last_activity' => time()
            // ]);
            // echo "here";
            // print_r($this->session->userdata());
            // die();
            $Response['status']  = true;
            $Response['message']  = "Logged-in Successfully";
        }
        exit(json_encode($Response));
    }
}
