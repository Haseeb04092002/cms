<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{

    public function get_all_students_by_class($StationId = '', $classId = ''){
        $this->db->select('
            s.*,
            s.education_type AS student_education_type,
            c.className,
            c.sectionName
        ');

        $this->db->from('tbl_students s');
        $this->db->join('tbl_classes c', 'c.classId = s.classId', 'left');
        /* Student profile image */
        $this->db->join(
            'tbl_documents d',
            's.admissionNo = d.referenceId
         AND d.referenceType = "student"
         AND d.documentTitle = "profile_img"
         AND d.isDeleted = 0
         AND d.stationId = ' . $this->db->escape($StationId),
            'left'
        );

        $this->db->where('s.stationId', $StationId);
        if (!empty($classId)) {
            $this->db->where('s.classId', $classId);
        }
        $this->db->where('s.isDeleted', 0);

        $this->db->order_by('s.addedOn', 'DESC');

        return $this->db->get()->result();
    }

    public function get_student_by_id($studentId = '')
    {
        $UserId    = $this->session->userdata('user_id') ?? '';
        $UserName  = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole  = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $this->db->select('
			s.*,
			s.education_type AS student_education_type,

			c.className,
			c.sectionName,

			d.documentPath
		');

        $this->db->from('tbl_students s');

        /* Class */
        $this->db->join(
            'tbl_classes c',
            'c.classId = s.classId',
            'left'
        );

        /* Student profile image */
        $this->db->join(
            'tbl_documents d',
            's.admissionNo = d.referenceId
         AND d.referenceType = "student"
         AND d.documentTitle = "profile_img"
         AND d.isDeleted = 0
         AND d.stationId = ' . $this->db->escape($StationId),
            'left'
        );

        $this->db->where('s.stationId', $StationId);
        $this->db->where('s.studentId', $studentId);
        $this->db->where('s.isDeleted', 0);

        $this->db->order_by('s.addedOn', 'DESC');

        $all_students = $this->db->get()->row();
        // $data['all_students'] = $all_students;
        return $all_students;
    }
}
