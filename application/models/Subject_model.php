<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subject_model extends CI_Model
{
    public function get_all_subjects()
    {
        // $query = $this->db->query("SHOW COLUMNS FROM tbl_subjects LIKE 'subjectName'");
		// $row = $query->row();

		// $all_subjects = [];

		// if ($row) {
		// 	$enum = str_replace(["enum(", ")", "'"], "", $row->Type);
		// 	$all_subjects = explode(",", $enum);
		// }

        $all_subjects = $this->db->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_subjects')->result();

        return $all_subjects;
    }
}
