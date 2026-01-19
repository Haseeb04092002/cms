<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task_model extends CI_Model
{
    public function get_tasks_by_student($studentId = '', $classId = '')
    {
        $StationId = $this->session->userdata('station_id') ?? '';

        $all_tasks = $this->db
        ->where('isDeleted', 0)
        ->where('stationId', $StationId)
        ->where('studentId', $studentId)
        ->where('classId', $classId)
        ->order_by('addedOn', 'DESC')->get('tbl_tasks')->result();

        return $all_tasks;
    }
}
