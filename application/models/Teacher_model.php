<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher_model extends CI_Model
{
    public function get_all_teachers()
    {
        $UserId    = $this->session->userdata('user_id') ?? '';
        $UserName  = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole  = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $this->db->select('*')->where('isDeleted', 0)->where('stationId', $StationId)->order_by('addedOn', 'DESC');
        $all_teachers = $this->db->get('tbl_staff')->result();

        return $all_teachers;
    }

    public function get_all_subject()
    {
        $UserId    = $this->session->userdata('user_id') ?? '';
        $UserName  = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole  = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $this->db->select('*')->where('isDeleted', 0)->where('stationId', $StationId)->order_by('addedOn', 'DESC');
        $all_subjects = $this->db->get('tbl_subjects')->result();

        return $all_subjects;
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
