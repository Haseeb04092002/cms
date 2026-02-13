<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends CI_Model
{

    /* ===============================
       MAIN REPORT FUNCTION
    =============================== */
    public function get_student_report_rows($f)
    {
        if (empty($f['reportType'])) {
            return [
                'rows' => [],
                'period' => null
            ];
        }

        $type  = strtolower($f['reportType']);
        $month = !empty($f['month']) ? (int)$f['month'] : null;
        $year  = !empty($f['year'])  ? (int)$f['year']  : null;

        /* -----------------------------
       GET PERIOD RANGE (FROM DB)
    ----------------------------- */
        $period = $this->get_report_period($type, $month, $year);

        /* -----------------------------
       BASE STUDENTS
    ----------------------------- */
        $this->db->select("
        s.studentId,
        CONCAT(s.firstName,' ',s.lastName) AS studentName,
        c.className,
        c.sectionName
    ");
        $this->db->from('tbl_students s');
        $this->db->join('tbl_classes c', 'c.classId = s.classId', 'left');
        $this->db->where('s.isDeleted', 0);

        if (!empty($f['className'])) {
            $this->db->where('c.className', $f['className']);
        }
        if (!empty($f['sectionName'])) {
            $this->db->where('c.sectionName', $f['sectionName']);
        }

        $students = $this->db->get()->result_array();
        if (!$students) {
            return [
                'rows' => [],
                'period' => $period
            ];
        }

        $out = [];

        foreach ($students as $st) {

            if ($type === 'attendance') {
                $val = $this->attendance_summary($st['studentId'], $month, $year);
            } elseif ($type === 'academic') {
                $val = $this->exam_summary($st['studentId'], $month, $year);
            } elseif ($type === 'fee') {
                $val = $this->fee_summary($st['studentId'], $month, $year);
            } else {
                $val = 'Invalid report type';
            }

            $out[] = [
                'studentName' => $st['studentName'],
                'className'   => $st['className'],
                'sectionName' => $st['sectionName'],
                'value'       => $val
            ];
        }

        return [
            'rows'   => $out,
            'period' => $period
        ];
    }


    private function get_report_period($type, $month = null, $year = null)
    {
        if ($type === 'attendance') {
            $table = 'tbl_attendance';
            $dateField = 'attendanceDate';
        } elseif ($type === 'academic') {
            $table = 'tbl_exams';
            $dateField = 'examDate';
        } elseif ($type === 'fee') {
            $table = 'tbl_fees';
            $dateField = 'dueDate';
        } else {
            return null;
        }

        $this->db->select("
        MIN($dateField) AS startDate,
        MAX($dateField) AS endDate
    ");
        $this->db->from($table);
        $this->db->where('isDeleted', 0);

        if ($month !== null) {
            $this->db->where("MONTH($dateField)", $month);
        }
        if ($year !== null) {
            $this->db->where("YEAR($dateField)", $year);
        }

        $row = $this->db->get()->row_array();

        if (!$row || !$row['startDate']) {
            return null;
        }

        return [
            'start' => $row['startDate'],
            'end'   => $row['endDate']
        ];
    }



    /* ===============================
       ATTENDANCE SUMMARY
       (Month/Year OPTIONAL)
    =============================== */
    private function attendance_summary($studentId, $month = null, $year = null)
    {
        $this->db->select("status, COUNT(*) AS cnt");
        $this->db->from('tbl_attendance');
        $this->db->where('isDeleted', 0);
        $this->db->where('studentId', (int)$studentId);

        if ($month !== null) {
            $this->db->where("MONTH(attendanceDate)", $month);
        }
        if ($year !== null) {
            $this->db->where("YEAR(attendanceDate)", $year);
        }

        $this->db->group_by('status');
        $rows = $this->db->get()->result_array();

        if (!$rows) return "No attendance record";

        $present = $absent = $other = 0;

        foreach ($rows as $r) {
            $s = strtolower(trim($r['status']));
            if ($s === 'present') $present += (int)$r['cnt'];
            elseif ($s === 'absent') $absent += (int)$r['cnt'];
            else $other += (int)$r['cnt'];
        }

        return "Present: {$present}, Absent: {$absent}, Other: {$other}";
    }

    /* ===============================
       ACADEMIC SUMMARY
       (ALL exams if no month/year)
    =============================== */
    private function exam_summary($studentId, $month = null, $year = null)
    {
        $this->db->select("
            COUNT(*) AS total_exams,
            SUM(totalMarks) AS total_marks,
            SUM(obtainedMarks) AS obtained_marks
        ");
        $this->db->from('tbl_exams');
        $this->db->where('isDeleted', 0);
        $this->db->where('studentId', (int)$studentId);

        if ($month !== null) {
            $this->db->where("MONTH(examDate)", $month);
        }
        if ($year !== null) {
            $this->db->where("YEAR(examDate)", $year);
        }

        $row = $this->db->get()->row_array();
        if (!$row || $row['total_exams'] == 0) {
            return "No exam record";
        }

        $t = (float)$row['total_marks'];
        $o = (float)$row['obtained_marks'];
        $pct = ($t > 0) ? round(($o / $t) * 100, 1) : 0;

        return "Exams: {$row['total_exams']} | {$o}/{$t} ({$pct}%)";
    }

    /* ===============================
       FEE SUMMARY
       (FULL HISTORY if no month/year)
    =============================== */
    private function fee_summary($studentId, $month = null, $year = null)
    {
        $this->db->select("
            SUM(originalAmount) AS total_original,
            SUM(paidAmount)     AS total_paid,
            SUM(discountAmount) AS total_discount,
            SUM(dueAmount)      AS total_due
        ");
        $this->db->from('tbl_fees');
        $this->db->where('isDeleted', 0);
        $this->db->where('studentId', (int)$studentId);

        if ($month !== null) {
            $this->db->where("MONTH(dueDate)", $month);
        }
        if ($year !== null) {
            $this->db->where("YEAR(dueDate)", $year);
        }

        $row = $this->db->get()->row_array();
        if (!$row || $row['total_original'] === null) {
            return "No fee record";
        }

        return "Original: {$row['total_original']}, "
            . "Discount: {$row['total_discount']}, "
            . "Paid: {$row['total_paid']}, "
            . "Due: {$row['total_due']}";
    }
}
