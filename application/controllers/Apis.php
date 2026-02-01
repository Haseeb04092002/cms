<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apis extends MY_Controller
{
    public function admission_form_data_fetch()
    {
        $date = new DateTime();
        $date = $date->format('His');
        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'gender'");
        $row = $query->row();
        $all_genders = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_genders = explode(",", $enum);
        }
        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'education_type'");
        $row = $query->row();
        $all_education_type = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_education_type = explode(",", $enum);
        }
        $all_classes = $this->db->where('stationId', '1001')->where('isDeleted', 0)->order_by('addedOn', 'DESC')->get('tbl_classes')->result();
        echo json_encode([
            'all_genders' => $all_genders,
            'all_classes' => $all_classes,
            'all_education_type' => $all_education_type,
            'admissionNo' => $date
        ]);
    }
}
