<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{

    public function get_all_students_by_class($StationId = '', $classId = '')
    {
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

    public function find_students(
        $station_id     = '',
        $education_type = '',
        $class_id     = '',
        $section_id   = '',
        $student_name   = '',
        $batch_year     = ''
    ) {
        $this->db->select('
        s.studentId,
        s.admissionNo,
        s.addedOn,
        s.education_type AS student_education_type,
        s.firstName,
        s.lastName,
        s.status,
        s.stationId,

        c.classId,
        c.className,
        c.sectionName,

        d.documentPath
    ');

        $this->db->from('tbl_students s');

        $this->db->join(
            'tbl_classes c',
            'c.classId = s.classId',
            'left'
        );

        $this->db->join(
            'tbl_documents d',
            's.admissionNo = d.referenceId
         AND d.referenceType = "student"
         AND d.documentTitle = "profile_img"
         AND d.isDeleted = 0
         AND d.stationId = ' . $this->db->escape($station_id),
            'left'
        );

        /* ==========================
       OPTIONAL FILTERS
    ========================== */

        if (!empty($education_type)) {
            $this->db->where('s.education_type', $education_type);
        }

        if (!empty($class_id)) {
            $this->db->where('c.classId', $class_id);
        }

        if (!empty($section_id)) {
            $this->db->where('c.classId', $section_id);
        }

        if (!empty($batch_year)) {
            $this->db->where('s.batchYear', (int)$batch_year);
        }

        if (!empty($student_name)) {
            $this->db->group_start();
            $this->db->like('s.firstName', $student_name);
            $this->db->or_like('s.lastName', $student_name);
            $this->db->group_end();
        }

        if (!empty($station_id)) {
            $this->db->where('s.stationId', $station_id);
        }

        $this->db->order_by('s.addedOn', 'DESC');

        return $this->db->get()->result();
        
    }
}
