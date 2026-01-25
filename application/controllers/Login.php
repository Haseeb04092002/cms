<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        $sql = "select roleName from tbl_user_roles where roleId in (25, 27, 28, 33)";
        $user_roles = $this->db->query($sql)->result();
        $data = array();
        $data['user_roles'] = $user_roles;
        $this->load->view('login', $data);
    }

    public function login()
    {
        // Default response
        $response = [
            'status'  => false,
            'message' => 'Some Error Occurred. Try Again'
        ];

        // Get input safely
        $userRole = $this->input->post('userRole') ?? '';
        $email    = $this->input->post('email') ?? '';
        $password = $this->input->post('password') ?? '';

        $check = null; // Initialize

        // ===== ADMIN LOGIN =====
        if ($userRole === 'Admin') {
            $check = $this->db
                ->get_where('tbl_users', ['Email' => $email, 'Password' => $password])
                ->row();

            if ($check) {
                $check->username = $check->Email ?? '';
                $check->userId   = $check->userId ?? '';
            }
        }

        // ===== COORDINATOR / TEACHER LOGIN =====
        elseif ($userRole === 'Coordinator' || $userRole === 'Teacher') {
            $check = $this->db
                ->get_where('tbl_staff', ['Password' => $password])
                ->row();

            if ($check) {
                $check->username = $check->firstName ?? '';
                $check->userId   = $check->staffId ?? '';
            }
        }

        // ===== STUDENT LOGIN =====
        elseif ($userRole === 'Student') {
            $check = $this->db
                ->get_where('tbl_students', ['Password' => $password])
                ->row();

            if ($check) {
                $check->username = $check->firstName ?? '';
                $check->userId   = $check->studentId ?? '';
            }
        }

        // ===== Set session if login success =====
        if ($check) {
            $this->session->set_userdata([
                'user_id'       => $check->userId ?? '',
                'user_name'     => $check->username ?? '',
                'user_email'    => $check->email ?? '',
                'user_role'     => $userRole ?? 'Admin',
                'station_id'    => $check->stationId ?? '',
                'last_activity' => time()
            ]);

            $response['status']  = true;
            $response['message'] = 'Logged-in Successfully';
        } else {
            $response['message'] = 'Invalid Username or Password!';
        }

        exit(json_encode($response));
    }



    public function logout()
    {
        // Clear all session data properly
        $this->session->unset_userdata([
            'user_id',
            'user_name',
            'user_email',
            'station_id',
            'last_activity'
        ]);
        $this->session->sess_destroy();
        redirect('Cms');
    }
}
