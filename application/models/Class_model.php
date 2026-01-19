<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Class_model extends CI_Model
{
    public function get_all_classes()
    {
        $all_classes = $this->db->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();
        return $all_classes;
    }

    public function get_all_classes_with_student_count($StationId)
    {
        $this->db->select('
        c.*,
        COUNT(s.studentId) AS total_students
    ');
        $this->db->from('tbl_classes c');
        $this->db->join(
            'tbl_students s',
            's.classId = c.classId 
         AND s.isDeleted = 0 
         AND s.stationId = ' . $this->db->escape($StationId),
            'left'
        );
        $this->db->where('c.isDeleted', 0);
        $this->db->group_by('c.classId');

        return $this->db->get()->result();
    }
}
