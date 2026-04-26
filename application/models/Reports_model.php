<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends CI_Model
{

    public function get_student_report_rows($f)
    {
        if (empty($f['reportType'])) {
            return ['rows' => [], 'period' => null];
        }

        $type = strtolower($f['reportType']);
        $classId   = $f['className'] ?? '';
        $sectionId = $f['sectionName'] ?? '';
        $stationId = $f['stationId'] ?? '';

        $range = $this->resolve_date_range($f, $type);

        if ($type === 'attendance') {

            $this->db->select("
                s.studentId,
                CONCAT(s.firstName,' ',s.lastName) AS studentName,
                c.className,
                c.sectionName
            ");
            $this->db->from('tbl_students s');
            $this->db->join('tbl_classes c', 'c.classId = s.classId', 'left');
            $this->db->where('s.isDeleted', 0);
            $this->db->where('s.stationId', $stationId);

            if (!empty($classId)) {
                $this->db->where('s.classId', $classId);
            }

            if (!empty($sectionId)) {
                $this->db->where('s.sectionId', $sectionId);
            }

            $students = $this->db->get()->result_array();

            $out = [];

            foreach ($students as $st) {
                $val = $this->attendance_summary($st['studentId'], $range);

                $out[] = [
                    'studentName' => $st['studentName'],
                    'className'   => $st['className'],
                    'sectionName' => $st['sectionName'],
                    'value'       => $val
                ];
            }

            return ['rows' => $out, 'period' => $range];
        }

        if ($type === 'academic') {

            $this->db->select("
                CONCAT(s.firstName,' ',s.lastName) AS studentName,
                c.className,
                c.sectionName,
                e.examTitle,
                e.examDate,
                e.totalMarks,
                e.obtainedMarks
            ");
            $this->db->from('tbl_exams e');
            $this->db->join('tbl_students s', 's.studentId = e.studentId');
            $this->db->join('tbl_classes c', 'c.classId = s.classId', 'left');

            $this->db->where('e.isDeleted', 0);
            $this->db->where('e.stationId', $stationId);
            $this->db->where('e.examDate >=', $range['start']);
            $this->db->where('e.examDate <=', $range['end']);

            if (!empty($classId)) {
                $this->db->where('s.classId', $classId);
            }

            if (!empty($sectionId)) {
                $this->db->where('s.sectionId', $sectionId);
            }

            $rows = $this->db->get()->result_array();

            return ['rows' => $rows, 'period' => $range];
        }


        if ($type === 'fee') {

            $this->db->select("
                CONCAT(s.firstName,' ',s.lastName) AS studentName,
                c.className,
                c.sectionName,
                f.feeType,
                fs.amount AS originalAmount,
                f.discountAmount,
                f.paidAmount,
                f.paymentDate,
                (fs.amount - IFNULL(f.discountAmount,0) - IFNULL(f.paidAmount,0)) AS balance
            ");

            $this->db->from('tbl_fees f');

            // Join student
            $this->db->join('tbl_students s', 's.studentId = f.studentId');

            // Join class
            $this->db->join('tbl_classes c', 'c.classId = s.classId', 'left');

            // 🔥 IMPORTANT JOIN WITH FEE STRUCTURE
            $this->db->join('tbl_fee_structure fs', '
                fs.classId = f.classId 
                AND fs.feeType = f.feeType
                AND fs.education_type = f.education_type
                AND fs.isDeleted = 0
            ', 'left');

            $this->db->where('f.isDeleted', 0);
            $this->db->where('f.stationId', $stationId);

            // Optional class filter
            if (!empty($classId)) {
                $this->db->where('s.classId', $classId);
            }

            if (!empty($sectionId)) {
                $this->db->where('s.sectionId', $sectionId);
            }

            // Date filter using paymentDate
            if (!empty($range['start']) && !empty($range['end'])) {
                $this->db->where('f.addedOn >=', $range['start']);
                $this->db->where('f.addedOn <=', $range['end']);
            }

            $rows = $this->db->get()->result_array();

            return [
                'rows'   => $rows,
                'period' => $range
            ];
        }



        return ['rows' => [], 'period' => $range];
    }


    private function resolve_date_range($f, $type)
    {
        $month     = !empty($f['month']) ? (int)$f['month'] : null;
        $year      = !empty($f['year'])  ? (int)$f['year']  : null;
        $startDate = !empty($f['startDate']) ? $f['startDate'] : null;
        $endDate   = !empty($f['endDate']) ? $f['endDate'] : null;

        // Priority 1 → Start + End date manually selected
        if ($startDate && $endDate) {
            return [
                'start' => $startDate,
                'end'   => $endDate
            ];
        }

        // Priority 2 → Month + Year selected
        if ($month && $year) {
            $start = date('Y-m-01', strtotime("$year-$month-01"));
            $end   = date('Y-m-t', strtotime($start));

            return [
                'start' => $start,
                'end'   => $end
            ];
        }

        // Priority 3 → Only Year selected
        if ($year && !$month) {
            return [
                'start' => "$year-01-01",
                'end'   => "$year-12-31"
            ];
        }

        // Priority 4 → Nothing selected
        // From beginning of records → till today
        return [
            'start' => '2000-01-01', // or your system start year
            'end'   => date('Y-m-d')
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

    private function attendance_summary($studentId, $range)
    {
        $this->db->select("status, COUNT(*) AS cnt");
        $this->db->from('tbl_attendance');
        $this->db->where('isDeleted', 0);
        $this->db->where('studentId', (int)$studentId);
        $this->db->where('attendanceDate >=', $range['start']);
        $this->db->where('attendanceDate <=', $range['end']);
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


    private function exam_summary($studentId, $range)
    {
        $this->db->select("
        COUNT(*) AS total_exams,
        SUM(totalMarks) AS total_marks,
        SUM(obtainedMarks) AS obtained_marks
    ");
        $this->db->from('tbl_exams');
        $this->db->where('isDeleted', 0);
        $this->db->where('studentId', (int)$studentId);
        $this->db->where('examDate >=', $range['start']);
        $this->db->where('examDate <=', $range['end']);

        $row = $this->db->get()->row_array();

        if (!$row || $row['total_exams'] == 0) {
            return "No exam record";
        }

        $t = (float)$row['total_marks'];
        $o = (float)$row['obtained_marks'];
        $pct = ($t > 0) ? round(($o / $t) * 100, 1) : 0;

        return "Exams: {$row['total_exams']} | {$o}/{$t} ({$pct}%)";
    }


    private function fee_summary($studentId, $range)
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
        $this->db->where('dueDate >=', $range['start']);
        $this->db->where('dueDate <=', $range['end']);

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
