<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Fee extends MY_Controller
{
    public function index()
    {
        $this->output->set_header('X-Page-Title: Fee Management');
        $this->load->view('pages/fee/dashboard');
    }

    public function heads()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $data['heads'] = $this->db
            ->where('stationId', $StationId)
            ->where('isDeleted', 0)
            ->order_by('feeHeadId', 'DESC')
            ->get('tbl_fee_heads')
            ->result();

        $this->output->set_header('X-Page-Title: Fee Heads');
        $this->load->view('pages/fee/heads', $data);
    }


    public function structure()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $classes = $this->db->select('classId, className')->where(['stationId' => $StationId, 'isDeleted' => 0])->get('tbl_classes')->result();
        $data = array();
        $data['classes'] = $classes;
        $this->output->set_header('X-Page-Title: Fee Structures');
        $this->load->view('pages/fee/structure', $data);
    }


    public function services()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $services = $this->db->select('serviceId, serviceName, billingType, defaultAmount')->where(['stationId' => $StationId, 'isDeleted' => 0])->order_by('addedOn', 'ASC')->get('tbl_services')->result();
        $data = array();
        $data['services'] = $services ?? '';
        $this->output->set_header('X-Page-Title: Services');
        $this->load->view('pages/fee/services', $data);
    }

    public function discounts()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $discounts = $this->db->select('discountId, discountName, discountType, discountValue, ApplyScope')->where(['stationId' => $StationId, 'isDeleted' => 0])->order_by('addedOn', 'ASC')->get('tbl_discounts')->result();
        $data = array();
        $data['discounts'] = $discounts ?? '';
        $this->output->set_header('X-Page-Title: Discounts');
        $this->load->view('pages/fee/discounts', $data);
    }


    public function vouchers()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $discounts = $this->db->select('discountId, discountName, discountType, discountValue, ApplyScope')->where(['stationId' => $StationId, 'isDeleted' => 0])->order_by('addedOn', 'ASC')->get('tbl_discounts')->result();
        $data = array();
        $data['discounts'] = $discounts ?? '';
        $this->output->set_header('X-Page-Title: Discounts');
        $this->load->view('pages/fee/vouchers', $data);
    }

    public function challans()
    {
        $StationId = $this->session->userdata('station_id');

        $data['classes'] = $this->db
            ->where(['stationId' => $StationId, 'isDeleted' => 0])
            ->get('tbl_classes')
            ->result();

        $this->load->view('pages/fee/challans', $data);
    }


    public function get_echallans()
    {
        $StationId = $this->session->userdata('station_id');

        $student   = $this->input->post('student');
        $classId   = $this->input->post('classId');
        $batchYear = $this->input->post('batchYear');
        $month     = date('n');

        $this->db->select('
            s.studentId,
            CONCAT(s.firstName," ",s.lastName) as studentName,
            s.education_type,
            s.batchYear,
            s.classId,
            c.className,
            c.sectionName,
            fc.feeChallanId,
            fc.challanNo,
            fc.status as challanStatus
        ')
            ->from('tbl_students s')

            // LEFT JOIN CHALLAN (Important)
            ->join(
                'tbl_fee_challans fc',
                'fc.studentId = s.studentId 
                 
                AND fc.isDeleted = 0',
                'left'
            )

            ->join('tbl_classes c', 'c.classId=s.classId', 'left')

            ->where('s.stationId', $StationId)
            ->where('s.isDeleted', 0);

        if ($student)
            $this->db->group_start()
                ->like('s.firstName', $student)
                ->or_like('s.lastName', $student)
                ->group_end();

        if ($classId)
            $this->db->where('s.classId', $classId);

        if ($batchYear)
            $this->db->where('s.batchYear', $batchYear);

        $result = $this->db->get()->result();

        // print_r($result);
        // die();

        echo json_encode([
            'status' => true,
            'data'   => $result
        ]);

        exit;
    }


    public function get_student_fee_summary()
    {

        $stationId = $this->session->userdata('station_id');
        $studentId = $this->input->post('studentId');

        $startMonth = $this->input->post('startMonth') ?: 1;
        $endMonth   = $this->input->post('endMonth') ?: date('n');

        $this->db->select('
            s.studentId, 
            CONCAT(s.firstName, " ", s.lastName) as studentName, 
            s.admissionNo,
            fh.feeHeadId, 
            fh.headName, 
            fs.amount as originalAmount,
            sd.startMonth as discStart, 
            d.discountValue,
            d.discountType, 
            sd.endMonth as discEnd
            ');
        $this->db->from('tbl_students s');

        $this->db->join(
            'tbl_fee_structure fs',
            'TRIM(fs.classId) = TRIM(s.classId) 
            AND TRIM(s.batchYear) = TRIM(fs.batchYear) 
            AND fs.stationId = s.stationId 
            AND fs.isDeleted = 0',
            'inner'
        );

        $this->db->join('tbl_fee_heads fh', 'fh.feeHeadId = fs.feeHeadId AND fh.isDeleted = 0', 'inner');

        // Left Join Discounts (might not exist for every head)
        $this->db->join('tbl_student_discounts sd', 'sd.studentId = s.studentId 
        AND sd.feeHeadId = fs.feeHeadId 
        AND sd.isDeleted = 0', 'left');

        $this->db->join('tbl_discounts d', 'd.discountId = sd.discountId 
        AND d.isDeleted = 0', 'left');

        $this->db->where([
            's.studentId' => $studentId,
            's.stationId' => $stationId,
            's.isDeleted' => 0
        ]);

        $queryRows = $this->db->get()->result();

        // print_r($this->db->last_query());
        // die();

        if (empty($queryRows)) {
            echo json_encode(['status' => false, 'message' => 'No fee structure assigned to this student\'s class/batch.']);
            exit;
        }

        $finalData = [];
        $grandTotalNet = 0;

        // 2. Loop through months to calculate applicable amounts
        for ($m = $startMonth; $m <= $endMonth; $m++) {
            $monthName = date('F', mktime(0, 0, 0, $m, 1));

            foreach ($queryRows as $row) {
                $baseAmount = (float)$row->originalAmount;
                $calculatedDiscount = 0;

                // Apply discount ONLY if month is within the discount's valid range
                if (!empty($row->discountValue)) {
                    $mStart = (int)$row->discStart;
                    $mEnd   = (int)$row->discEnd;

                    // If range is set, check it. If not set (0), assume it applies.
                    $isWithinRange = true;
                    if ($mStart > 0 && $m < $mStart) $isWithinRange = false;
                    if ($mEnd > 0 && $m > $mEnd) $isWithinRange = false;

                    if ($isWithinRange) {
                        if ($row->discountType == 'Percentage') {
                            $calculatedDiscount = ($baseAmount * (float)$row->discountValue) / 100;
                        } else {
                            $calculatedDiscount = (float)$row->discountValue;
                        }
                    }
                }

                $netAmount = $baseAmount - $calculatedDiscount;
                $grandTotalNet += $netAmount;

                $finalData[] = [
                    'month'          => $monthName,
                    'feeHead'        => $row->headName,
                    'originalAmount' => $baseAmount,
                    'discount'       => $calculatedDiscount,
                    'netAmount'      => $netAmount
                ];
            }
        }

        // 3. Output Response
        echo json_encode([
            'status'     => true,
            'student'    => $queryRows[0]->studentName . " [" . $queryRows[0]->admissionNo . "]",
            'range'      => date('F', mktime(0, 0, 0, $startMonth)) . " - " . date('F', mktime(0, 0, 0, $endMonth)),
            'data'       => $finalData,
            'grandTotal' => $grandTotalNet
        ]);
        exit;
    }

    public function generate_echallan()
    {
        $stationId = $this->session->userdata('station_id');
        $roleId    = $this->session->userdata('role_id');
        $userId    = $this->session->userdata('user_id');

        $studentId = $this->input->post('studentId');
        // Using filters from front-end if provided, otherwise current month
        $month     = $this->input->post('month') ?: date('n');
        $year      = $this->input->post('year') ?: date('Y');

        // 1. Get Student Details
        $student = $this->db->where(['studentId' => $studentId, 'stationId' => $stationId, 'isDeleted' => 0])
            ->get('tbl_students')
            ->row();

        if (!$student) {
            echo json_encode(['status' => false, 'message' => 'Student not found']);
            return;
        }

        // 2. Fetch Structured Data (Reusing logic similar to summary)
        $this->db->select('
            s.studentId, s.classId, s.batchYear,
            fs.feeHeadId, fh.headName, fs.amount,
            d.discountType, d.discountValue,
            sd.startMonth as discStart, sd.endMonth as discEnd
        ');
        $this->db->from('tbl_students s');
        // $this->db->join('tbl_fee_structure fs', 'fs.classId = s.classId AND fs.batchYear = s.batchYear AND fs.stationId = s.stationId AND fs.isDeleted = 0', 'inner');
        $this->db->join(
            'tbl_fee_structure fs',
            'TRIM(fs.classId) = TRIM(s.classId) 
            AND TRIM(s.batchYear) = TRIM(fs.batchYear) 
            AND fs.stationId = s.stationId 
            AND fs.isDeleted = 0',
            'inner'
        );
        $this->db->join('tbl_fee_heads fh', 'fh.feeHeadId = fs.feeHeadId AND fh.isDeleted = 0', 'inner');
        $this->db->join('tbl_student_discounts sd', 'sd.studentId = s.studentId AND sd.feeHeadId = fs.feeHeadId AND sd.isDeleted = 0', 'left');
        $this->db->join('tbl_discounts d', 'd.discountId = sd.discountId AND d.isDeleted = 0', 'left');
        $this->db->where(['s.studentId' => $studentId, 's.stationId' => $stationId, 's.isDeleted' => 0]);

        $feeItems = $this->db->get()->result();

        if (empty($feeItems)) {
            echo json_encode(['status' => false, 'message' => 'No fee structure found for student.']);
            return;
        }

        $this->db->trans_start();

        // 3. Create Challan Master
        $challanNo = 'CH-' . $stationId . '-' . $studentId . '-' . time();
        $challanData = [
            'stationId'    => $stationId,
            'roleId'       => $roleId,
            'challanNo'    => $challanNo,
            'studentId'    => $studentId,
            'batchId'      => $student->batchYear,
            'classId'      => $student->classId,
            'challanMonth' => $month,
            'issueDate'    => date('Y-m-d'),
            'dueDate'      => date('Y-m-d', strtotime('+10 days')),
            'status'       => 'Unpaid',
            'createdAt'    => date('Y-m-d H:i:s'),
            'addedBy'      => $userId,
        ];
        $this->db->insert('tbl_fee_challans', $challanData);
        $feeChallanId = $this->db->insert_id();

        // 4. Calculate and Insert Items
        $totalAmount = 0;
        $discountTotal = 0;

        foreach ($feeItems as $row) {
            $baseAmount = (float)$row->amount;
            $calculatedDiscount = 0;

            // Apply discount check for the specific challan month
            if (!empty($row->discountValue)) {
                $mStart = (int)$row->discStart;
                $mEnd   = (int)$row->discEnd;
                $isWithinRange = true;
                if ($mStart > 0 && $month < $mStart) $isWithinRange = false;
                if ($mEnd > 0 && $month > $mEnd) $isWithinRange = false;

                if ($isWithinRange) {
                    if ($row->discountType == 'Percentage') {
                        $calculatedDiscount = ($baseAmount * (float)$row->discountValue) / 100;
                    } else {
                        $calculatedDiscount = (float)$row->discountValue;
                    }
                }
            }

            $netAmount = $baseAmount - $calculatedDiscount;
            $totalAmount += $baseAmount;
            $discountTotal += $calculatedDiscount;

            // Insert Item
            $this->db->insert('tbl_fee_challan_items', [
                'stationId'    => $stationId,
                'feeChallanId' => $feeChallanId,
                'itemType'     => 'Head',
                'referenceId'  => $row->feeHeadId,
                'description'  => $row->headName,
                'amount'       => $baseAmount,
                'discount'     => $calculatedDiscount,
                'netAmount'    => $netAmount,
                'addedBy'      => $userId
            ]);
        }

        $finalNet = $totalAmount - $discountTotal;

        // 5. Update Totals
        $this->db->where('feeChallanId', $feeChallanId)
            ->update('tbl_fee_challans', [
                'totalAmount'   => $totalAmount,
                'discountTotal' => $discountTotal,
                'netAmount'     => $finalNet
            ]);

        // 6. Ledger Entry
        $this->db->insert('tbl_fee_ledger', [
            'stationId'    => $stationId,
            'studentId'    => $studentId,
            'feeChallanId' => $feeChallanId,
            'entryDate'    => date('Y-m-d'),
            'entryType'    => 'Debit',
            'amount'       => $finalNet,
            'narration'    => 'Fee Challan Generated for ' . date('F', mktime(0, 0, 0, $month, 1)),
            'addedBy'      => $userId
        ]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false, 'message' => 'Failed to generate challan']);
            return;
        }

        // Generate PDF data
        $pdfBase64 = $this->generate_pdf($feeChallanId);

        echo json_encode([
            'status'  => true,
            'message' => 'Challan generated successfully',
            'pdfData' => $pdfBase64, // Send the base64 string
            'filename' => 'Challan_' . $challanNo . '.pdf'
        ]);
        exit;
    }

    // ================= PDF GENERATION HELPER =================

    private function generate_pdf($feeChallanId)
    {
        // Load DomPDF library
        require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

        // 1. Fetch Master Challan Data
        $challan = $this->db->where('feeChallanId', $feeChallanId)->get('tbl_fee_challans')->row();

        // 2. Fetch Student Data (Joined with class to get className)
        $student = $this->db->select('s.*, c.className')
            ->from('tbl_students s')
            ->join('tbl_classes c', 'c.classId = s.classId', 'left')
            ->where('s.studentId', $challan->studentId)
            ->get()
            ->row();

        // 3. Fetch Items
        $items = $this->db->where('feeChallanId', $feeChallanId)->get('tbl_fee_challan_items')->result();

        // 4. Fetch Station Data for bank details
        // $station = $this->db->where('stationId', $challan->stationId)->get('tbl_stations')->row();

        $data = [
            'challan' => $challan,
            'student' => $student,
            'items'   => $items,
            'station' => $station ?? ''
        ];

        $html = $this->load->view('pages/fee/challan_templates/inklings_1001', $data, TRUE);
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true); // Recommended
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        // $dompdf->setPaper('A4', 'portrait');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Return the base64 encoded string
        return base64_encode($dompdf->output());
    }




    public function select_class()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $data = array();

        switch ($UserRole) {
            case 'Admin':
                $data['classes'] = $this->Class_model->get_all_classes_with_student_count($StationId);
                $this->output->set_header('X-Page-Title: Select Class For Services');
                $this->load->view('pages/fee/select_class', $data);
                break;

            case 'Teacher':
                // $this->db->select('
                // c.className,
                // c.sectionName,
                // c.classId
                // ');
                // $this->db->from('tbl_class_subject_assignment c');
                // $this->db->join('tbl_classes', 'tb');
                $headClassIds = $this->db->select('headClassId')->where(['teacherId' => $UserId, 'stationId' => $StationId, 'isDeleted' => 0])->get('tbl_class_subject_assignment')->result();
                $headClasses = $this->db->select('classId', 'className', 'sectionName')->where(['classId' => $headClassIds, 'stationId' => $StationId, 'isDeleted' => 0])->get('tbl_classes')->result();
                // print_r($headClasses);
                // die();
                $this->output->set_header('X-Page-Title: Select Class For Services');
                $this->load->view('pages/fee/select_class', $data);
                break;
        }
        // echo "<br>";
        // echo "<pre>";
        // print_r($data['classes']);
        // die();
    }

    public function student_services_dashboard()
    {
        $StationId = $this->session->userdata('station_id');

        /* =============================
       GET CLASSES WITH TOTAL STUDENTS
    ============================== */
        $query = $this->db->select('
        c.classId,
        c.className,
        c.sectionName,
        COUNT(s.studentId) AS total_students
    ')
            ->from('tbl_classes c')
            ->join(
                'tbl_students s',
                's.classId = c.classId 
         AND s.isDeleted = 0 
         AND s.stationId = ' . $this->db->escape($StationId),
                'left'
            )
            ->where('c.isDeleted', 0)
            ->group_by('c.classId')
            ->get();

        if (!$query) {
            echo $this->db->last_query();
            echo "<br><br>";
            print_r($this->db->error());
            die;
        }

        $classes = $query->result();

        /* =============================
       GET SERVICE COUNTS PER CLASS
    ============================== */

        $serviceData = $this->db->select('
            st.classId,
            ss.serviceId,
            srv.serviceName,
            COUNT(ss.studentServiceId) AS assigned_count
        ')
            ->from('tbl_student_services ss')
            ->join('tbl_students st', 'st.studentId = ss.studentId')
            ->join('tbl_services srv', 'srv.serviceId = ss.serviceId')
            ->where([
                'ss.isDeleted' => 0,
                'ss.status' => 'Active',
                'st.isDeleted' => 0
            ])
            ->group_by(['st.classId', 'ss.serviceId'])
            ->get()
            ->result();

        /* =============================
       ORGANIZE SERVICE DATA
    ============================== */

        $servicesByClass = [];

        foreach ($serviceData as $row) {
            $servicesByClass[$row->classId][] = [
                'serviceName'   => $row->serviceName,
                'assignedCount' => $row->assigned_count
            ];
        }

        $data['classes'] = $classes;
        $data['servicesByClass'] = $servicesByClass;

        $this->load->view('pages/fee/select_class', $data);
    }


    public function student_services($classId = '', $className = '', $sectionName = '')
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $services = $this->db->select('serviceId, serviceName, billingType, defaultAmount')->where(['stationId' => $StationId, 'isDeleted' => 0])->order_by('addedOn', 'ASC')->get('tbl_services')->result();
        $students = $this->db->select('studentId, admissionNo, education_type, firstName, lastName')->where(['classId' => $classId, 'stationId' => $StationId, 'isDeleted' => 0])->order_by('addedOn', 'ASC')->get('tbl_students')->result();
        $data = array();
        $data['services'] = $services ?? '';
        $data['students'] = $students ?? '';
        $data['className'] = $className ?? '';
        $data['sectionName'] = $sectionName ?? '';
        $this->output->set_header('X-Page-Title: Student Services');
        $this->load->view('pages/fee/student_services', $data);
    }



    public function add_head()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $UserRoleId = $this->session->userdata('user_role_id') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $Response['status']  = false;
        $Response['message']  = "Some Error Occured. Try Again";

        $this->form_validation->set_rules('headName', 'Head Name', 'required');
        $this->form_validation->set_rules('headType', 'Head Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        } else {

            $headName = $this->input->post('headName') ?? '';
            $headType = $this->input->post('headType') ?? '';

            $headName = $this->simplify_text($headName);
            $headType = $this->simplify_text($headType);

            $IsDuplicate = $this->db
                ->where('headName', $headName)
                ->where('headType', $headType)
                ->where('stationId', $StationId)
                ->where('isDeleted', 0)
                ->get('tbl_fee_heads')
                ->row();

            if ($IsDuplicate) {
                $Response['message']  = 'Duplicate Record';
                exit(json_encode($Response));
                return;
            }

            $data['headName'] = $headName;
            $data['headType'] = $headType;
            $data['stationId'] = $StationId;
            $data['roleId'] = $UserRoleId;
            $data['addedOn'] = date('Y-m-d H:i:s');
            $data['addedBy'] = $UserId;

            $this->db->insert('tbl_fee_heads', $data);
            // print_r($this->db->last_query());
            // die();
            if ($this->db->affected_rows() > 0) {

                $Response['status']  = true;
                $Response['message']  = "Fee Head Added Successfully";
                exit(json_encode($Response));
                return;
            }
        }
        $this->output->set_header('X-Page-Title: Fee Heads');
        exit(json_encode($Response));
    }


    public function edit_head()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $UserRoleId = $this->session->userdata('user_role_id') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $Response['status']  = false;
        $Response['message']  = "Some Error Occured. Try Again";

        $this->form_validation->set_rules('headName', 'Head Name', 'required');
        $this->form_validation->set_rules('headType', 'Head Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        } else {

            $feeHeadId = $this->input->post('feeHeadId') ?? '';
            $headName = $this->input->post('headName') ?? '';
            $headType = $this->input->post('headType') ?? '';

            $headName = $this->simplify_text($headName);
            $headType = $this->simplify_text($headType);

            $data['headName'] = $headName;
            $data['headType'] = $headType;
            $data['roleId'] = $UserRoleId;
            $data['addedOn'] = date('Y-m-d H:i:s');
            $data['addedBy'] = $UserId;

            $this->db->where([
                'feeHeadId' => $feeHeadId,
                'stationId' => $StationId,
                'isDeleted' => 0
            ])->update('tbl_fee_heads', $data);
            // print_r($this->db->last_query());
            // die();
            if ($this->db->affected_rows() > 0) {

                $Response['status']  = true;
                $Response['message']  = "Fee Head Updated Successfully";
                exit(json_encode($Response));
                return;
            }
        }
        $this->output->set_header('X-Page-Title: Fee Heads');
        exit(json_encode($Response));
    }


    public function delete_head()
    {
        $UserId = '';
        $UserName = '';
        $UserEmail = '';
        $UserRole = '';
        $StationId = '';
        $UserId = $this->session->userdata('user_id') ?? '';
        $UserName = $this->session->userdata('user_name') ?? '';
        $UserEmail = $this->session->userdata('user_email') ?? '';
        $UserRole = $this->session->userdata('user_role') ?? '';
        $UserRoleId = $this->session->userdata('user_role_id') ?? '';
        $StationId = $this->session->userdata('station_id') ?? '';

        $Response['status']  = false;
        $Response['message']  = "Some Error Occured. Try Again";

        $feeHeadId = $this->input->post('feeHeadId') ?? '';

        $this->db->where([
            'feeHeadId' => $feeHeadId,
            'stationId' => $StationId,
            'isDeleted' => 0
        ])->update('tbl_fee_heads', ['isDeleted' => 1]);
        // print_r($this->db->last_query());
        // die();
        if ($this->db->affected_rows() > 0) {

            $Response['status']  = true;
            $Response['message']  = "Fee Head Deleted Successfully";
            exit(json_encode($Response));
            return;
        }

        $this->output->set_header('X-Page-Title: Fee Heads');
        exit(json_encode($Response));
    }



    public function add_discount()
    {
        $Response = ['status' => false, 'message' => 'Something went wrong'];

        $UserId    = $this->session->userdata('user_id');
        $UserRoleId = $this->session->userdata('user_role_id');
        $StationId = $this->session->userdata('station_id');

        $this->form_validation->set_rules('discount_name', 'Discount Name', 'required');
        $this->form_validation->set_rules('discount_type', 'Discount Type', 'required');
        $this->form_validation->set_rules('value', 'Discount Value', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $Response['message'] = validation_errors();
            exit(json_encode($Response));
        }

        $name  = $this->input->post('discount_name');
        $type  = $this->input->post('discount_type');
        $value = $this->input->post('value');

        // Duplicate Check
        $dup = $this->db->where([
            'discountName' => $name,
            'stationId' => $StationId,
            'isDeleted' => 0
        ])->get('tbl_discounts')->row();

        if ($dup) {
            $Response['message'] = 'Duplicate Discount';
            exit(json_encode($Response));
        }

        $this->db->insert('tbl_discounts', [
            'discountName' => $name,
            'discountType' => $type,
            'discountValue' => $value,
            'stationId' => $StationId,
            'roleId' => $UserRoleId,
            'addedBy' => $UserId,
            'addedOn' => date('Y-m-d H:i:s')
        ]);

        if ($this->db->affected_rows() > 0) {
            $Response['status'] = true;
            $Response['message'] = 'Discount Added Successfully';
        }

        exit(json_encode($Response));
    }


    public function edit_discount()
    {
        $Response = ['status' => false, 'message' => 'Something went wrong'];

        $UserId    = $this->session->userdata('user_id');
        $UserRoleId = $this->session->userdata('user_role_id');
        $StationId = $this->session->userdata('station_id');

        $this->form_validation->set_rules('discountId', 'ID', 'required');
        $this->form_validation->set_rules('discount_name', 'Discount Name', 'required');
        $this->form_validation->set_rules('discount_type', 'Discount Type', 'required');
        $this->form_validation->set_rules('value', 'Discount Value', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $Response['message'] = validation_errors();
            exit(json_encode($Response));
        }

        $id    = $this->input->post('discountId');
        $name  = $this->input->post('discount_name');
        $type  = $this->input->post('discount_type');
        $value = $this->input->post('value');

        $this->db->where([
            'discountId' => $id,
            'stationId' => $StationId,
            'isDeleted' => 0
        ])->update('tbl_discounts', [
            'discountName' => $name,
            'discountType' => $type,
            'discountValue' => $value,
            'roleId' => $UserRoleId,
            'addedBy' => $UserId,
            'addedOn' => date('Y-m-d H:i:s')
        ]);

        if ($this->db->affected_rows() > 0) {
            $Response['status'] = true;
            $Response['message'] = 'Discount Updated Successfully';
        }

        exit(json_encode($Response));
    }



    public function delete_discount()
    {
        $Response = ['status' => false, 'message' => 'Something went wrong'];

        $StationId = $this->session->userdata('station_id');
        $id = $this->input->post('discountId');

        $this->db->where([
            'discountId' => $id,
            'stationId' => $StationId,
            'isDeleted' => 0
        ])->update('tbl_discounts', ['isDeleted' => 1]);

        if ($this->db->affected_rows() > 0) {
            $Response['status'] = true;
            $Response['message'] = 'Discount Deleted Successfully';
        }

        exit(json_encode($Response));
    }


    public function structure_filter()
    {
        $StationId = $this->session->userdata('station_id');

        $batchYear = $this->input->post('batchYear');
        $classId   = $this->input->post('classId');

        $response = [
            'status' => false,
            'html'   => ''
        ];

        if (!$batchYear || !$classId) {
            echo json_encode($response);
            return;
        }

        $this->db->select("
            h.feeHeadId,
            h.headName,
            h.headType,
            s.feeStructureId,
            s.amount
        ");

        $this->db->from('tbl_fee_heads h');

        $this->db->join(
            'tbl_fee_structure s',
            "s.feeHeadId = h.feeHeadId
            AND s.batchYear = " . $this->db->escape($batchYear) . "
            AND s.classId = " . $this->db->escape($classId) . "
            AND s.stationId = " . $this->db->escape($StationId) . "
            AND s.isDeleted = 0",
            'left'
        );

        $this->db->where([
            'h.stationId' => $StationId,
            'h.isDeleted' => 0
        ]);

        $this->db->order_by('h.feeHeadId', 'ASC');

        $heads = $this->db->get()->result();

        ob_start();
?>

        <form id="FormSaveStructure">
            <input type="hidden" name="batchYear" value="<?= $batchYear ?>">
            <input type="hidden" name="classId" value="<?= $classId ?>">

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Head</th>
                        <th>Type</th>
                        <th width="200">Amount</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($heads as $h): ?>

                        <tr>
                            <td><?= $h->feeHeadId ?></td>
                            <td><?= htmlspecialchars($h->headName) ?></td>
                            <td><?= $h->headType ?></td>
                            <td>
                                <input type="hidden" name="feeHeadId[]" value="<?= $h->feeHeadId ?>">

                                <input type="hidden" name="feeStructureId[]"
                                    value="<?= $h->feeStructureId ?? '' ?>">

                                <input type="number"
                                    step="0.01"
                                    class="form-control form-control-sm"
                                    name="amount[]"
                                    value="<?= $h->amount ?? '' ?>">
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

            <div class="text-end">
                <button class="btn btn-primary">Save Structure</button>
            </div>
        </form>

<?php
        $html = ob_get_clean();

        $response['status'] = true;
        $response['html']   = $html;

        echo json_encode($response);
        exit;
    }


    public function save_structure()
    {
        $StationId  = $this->session->userdata('station_id');
        $UserId     = $this->session->userdata('user_id');
        $UserRoleId = $this->session->userdata('user_role_id');

        $Response = [
            'status'  => false,
            'message' => 'Something went wrong'
        ];

        $batchYear = $this->input->post('batchYear');
        $classId   = $this->input->post('classId');

        $feeHeadIds       = $this->input->post('feeHeadId');
        $feeStructureIds  = $this->input->post('feeStructureId');
        $amounts          = $this->input->post('amount');

        if (!$batchYear || !$classId) {
            $Response['message'] = "Invalid Request";
            echo json_encode($Response);
            return;
        }

        if (!empty($feeHeadIds)) {

            for ($i = 0; $i < count($feeHeadIds); $i++) {

                $feeHeadId      = $feeHeadIds[$i];
                $feeStructureId = $feeStructureIds[$i] ?? '';
                $amount         = trim($amounts[$i]);

                // Skip if empty amount
                if ($amount === '' || $amount == 0) {
                    continue;
                }

                $data = [
                    'stationId'     => $StationId,
                    'roleId'        => $UserRoleId,
                    'batchYear'     => $batchYear,
                    'classId'       => $classId,
                    'feeHeadId'     => $feeHeadId,
                    'amount'        => $amount,
                    'effectiveFrom' => date('Y-m-d'),
                    'effectiveTo'   => null,
                    'isActive'      => 1,
                    'isDeleted'     => 0,
                    'addedBy'       => $UserId,
                    'addedOn'       => date('Y-m-d H:i:s')
                ];

                if ($feeStructureId) {

                    // UPDATE
                    $this->db->where([
                        'feeStructureId' => $feeStructureId,
                        'stationId'      => $StationId,
                        'isDeleted'      => 0
                    ]);

                    $this->db->update('tbl_fee_structure', [
                        'amount'   => $amount,
                        'addedBy'  => $UserId,
                        'addedOn'  => date('Y-m-d H:i:s')
                    ]);
                } else {

                    // INSERT
                    $this->db->insert('tbl_fee_structure', $data);
                }
            }

            $Response['status']  = true;
            $Response['message'] = "Fee Structure Saved Successfully";
        }

        echo json_encode($Response);
    }

    public function save_service()
    {
        $StationId  = $this->session->userdata('station_id');
        $UserId     = $this->session->userdata('user_id');
        $UserRoleId = $this->session->userdata('user_role_id');

        $Response = [
            'status'  => false,
            'message' => 'Something went wrong'
        ];

        $service_name = $this->input->post('service_name') ?? '';
        $billing_type = $this->input->post('billing_type') ?? '';
        $default_amount = $this->input->post('default_amount') ?? '';

        $this->form_validation->set_rules('service_name', 'Service Name', 'required');
        $this->form_validation->set_rules('billing_type', 'Billing Type', 'required');
        $this->form_validation->set_rules('default_amount', 'Default Amount', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message']  = validation_errors();
            exit(json_encode($Response));
            return;
        }

        $service_name = $this->simplify_text($service_name);
        $billing_type = $this->simplify_text($billing_type);
        $default_amount = $this->simplify_text($default_amount);

        $IsDuplicate = $this->db
            ->where('serviceName', $service_name)
            ->where('billingType', $billing_type)
            ->where('stationId', $StationId)
            ->where('isDeleted', 0)
            ->get('tbl_services')
            ->row();

        if ($IsDuplicate) {
            $Response['message']  = 'Duplicate Record';
            exit(json_encode($Response));
            return;
        }

        $data['serviceName'] = $service_name;
        $data['billingType'] = $billing_type;
        $data['defaultAmount'] = $default_amount;
        $data['stationId'] = $StationId;
        $data['roleId'] = $UserRoleId;
        $data['addedOn'] = date('Y-m-d H:i:s');
        $data['addedBy'] = $UserId;

        $this->db->insert('tbl_services', $data);
        // print_r($this->db->last_query());
        // die();
        if ($this->db->affected_rows() > 0) {

            $Response['status']  = true;
            $Response['message']  = "Service Added Successfully";
            exit(json_encode($Response));
            return;
            // $services = $this->db->select('serviceId, serviceName, billingType, defaultAmount')->where(['stationId' => $StationId, 'isDeleted' => 0])->get('tbl_services')->result();
            // $data = array();
            // $data['services'] = $services ?? '';
            // $this->output->set_header('X-Page-Title: Services');
            // $this->load->view('pages/fee/services', $data);
        }
    }



    public function edit_service()
    {
        $StationId  = $this->session->userdata('station_id');
        $UserId     = $this->session->userdata('user_id');
        $UserRoleId = $this->session->userdata('user_role_id');

        $Response = [
            'status'  => false,
            'message' => 'Something went wrong'
        ];

        $serviceId     = $this->input->post('serviceId') ?? '';
        $service_name  = $this->input->post('service_name') ?? '';
        $billing_type  = $this->input->post('billing_type') ?? '';
        $default_amount = $this->input->post('default_amount') ?? '';

        $this->form_validation->set_rules('serviceId', 'Service ID', 'required');
        $this->form_validation->set_rules('service_name', 'Service Name', 'required');
        $this->form_validation->set_rules('billing_type', 'Billing Type', 'required');
        $this->form_validation->set_rules('default_amount', 'Default Amount', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message'] = validation_errors();
            exit(json_encode($Response));
        }

        $serviceId      = (int)$serviceId;
        $service_name   = $this->simplify_text($service_name);
        $billing_type   = $this->simplify_text($billing_type);
        $default_amount = $this->simplify_text($default_amount);

        // Check if record exists
        $Existing = $this->db
            ->where('serviceId', $serviceId)
            ->where('stationId', $StationId)
            ->where('isDeleted', 0)
            ->get('tbl_services')
            ->row();

        if (!$Existing) {
            $Response['message'] = 'Service not found';
            exit(json_encode($Response));
        }

        $data = [
            'serviceName'  => $service_name,
            'billingType'  => $billing_type,
            'defaultAmount' => $default_amount,
            'addedOn'    => date('Y-m-d H:i:s'),
            'addedBy'    => $UserId
        ];

        $this->db->where('serviceId', $serviceId);
        $this->db->where('stationId', $StationId);
        $this->db->update('tbl_services', $data);

        if ($this->db->affected_rows() >= 0) {
            $Response['status']  = true;
            $Response['message'] = 'Service Updated Successfully';
        }

        exit(json_encode($Response));
    }


    public function delete_service()
    {
        $StationId  = $this->session->userdata('station_id');
        $UserId     = $this->session->userdata('user_id');

        $Response = [
            'status'  => false,
            'message' => 'Something went wrong'
        ];

        $serviceId = $this->input->post('serviceId') ?? '';

        $this->form_validation->set_rules('serviceId', 'Service ID', 'required');

        if ($this->form_validation->run() == FALSE) {
            $Response['message'] = validation_errors();
            exit(json_encode($Response));
        }

        $serviceId = (int)$serviceId;

        // Check if exists
        $Existing = $this->db
            ->where('serviceId', $serviceId)
            ->where('stationId', $StationId)
            ->where('isDeleted', 0)
            ->get('tbl_services')
            ->row();

        if (!$Existing) {
            $Response['message'] = 'Service not found';
            exit(json_encode($Response));
        }

        $this->db->where('serviceId', $serviceId);
        $this->db->where('stationId', $StationId);
        $this->db->update('tbl_services', [
            'isDeleted' => 1
        ]);

        if ($this->db->affected_rows() > 0) {
            $Response['status']  = true;
            $Response['message'] = 'Service Deleted Successfully';
        }

        exit(json_encode($Response));
    }


    public function save_bulk_services()
    {
        $this->output->set_content_type('application/json');

        $stationId = $this->session->userdata('station_id');
        $roleId    = $this->session->userdata('user_role_id');
        $userId    = $this->session->userdata('user_id');

        $serviceId  = (int)$this->input->post('serviceId');
        $startMonth = (int)$this->input->post('startMonth');
        $endMonth   = (int)$this->input->post('endMonth');
        $students   = $this->input->post('students');

        if (empty($serviceId) || empty($students)) {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid data'
            ]);
            return;
        }

        $insertCount = 0;

        foreach ($students as $studentId) {

            // Prevent duplicate active service
            $exists = $this->db
                ->where([
                    'studentId' => $studentId,
                    'serviceId' => $serviceId,
                    'isDeleted' => 0,
                    'status' => 'Active'
                ])
                ->get('tbl_student_services')
                ->row();

            if ($exists) {
                continue;
            }

            $this->db->insert('tbl_student_services', [
                'stationId'  => $stationId,
                'roleId'     => $roleId,
                'studentId'  => $studentId,
                'serviceId'  => $serviceId,
                'startMonth' => $startMonth,
                'endMonth'   => $endMonth,
                'status'     => 'Active',
                'isDeleted'  => 0,
                'addedBy'    => $userId,
                'addedOn'    => date('Y-m-d H:i:s')
            ]);

            $insertCount++;
        }

        echo json_encode([
            'status' => true,
            'message' => "$insertCount services assigned successfully."
        ]);
    }



    public function all_students()
    {
        $StationId = $this->session->userdata('station_id') ?? '';

        /* ================= MAIN QUERY ================= */

        $this->db->select('
            s.*,
            s.education_type AS student_education_type,

            c.className,
            c.sectionName,

            sd.studentDiscountId,
            sd.startMonth,
            sd.endMonth,
            sd.status AS discount_status,

            d.discountId,
            d.discountName,
            d.discountType,
            d.discountValue,
            d.applyScope,

            fh.feeHeadId,
            fh.headName,

            fs.feeStructureId,
            fs.amount
        ');

        $this->db->from('tbl_students s');

        /* Class */
        $this->db->join(
            'tbl_classes c',
            'c.classId = s.classId',
            'left'
        );

        /* Fee Structure (FIXED JOIN) */
        $this->db->join(
            'tbl_fee_structure fs',
            'TRIM(fs.classId) = TRIM(s.classId) 
    AND TRIM(fs.batchYear) = TRIM(s.batchYear) 
    AND fs.stationId = s.stationId 
    AND fs.isDeleted = 0',
            'left'
        );

        /* Fee Heads */
        $this->db->join(
            'tbl_fee_heads fh',
            'fh.feeHeadId = fs.feeHeadId
            AND fh.isDeleted = 0',
            'left'
        );

        /* Student Discounts (OPTIONAL) */
        $this->db->join(
            'tbl_student_discounts sd',
            'sd.studentId = s.studentId
            AND sd.feeHeadId = fs.feeHeadId
            AND sd.isDeleted = 0',
            'left'
        );

        /* Discount Master */
        $this->db->join(
            'tbl_discounts d',
            'd.discountId = sd.discountId
            AND d.isDeleted = 0',
            'left'
        );

        $this->db->where('s.stationId', $StationId);
        $this->db->where('s.status', 'approved');
        $this->db->where('s.isDeleted', 0);
        $this->db->order_by('s.addedOn', 'DESC');

        $all_students = $this->db->get()->result();

        // print($this->db->last_query());
        // die();

        /* ================= GROUPING ================= */

        $grouped = [];

        foreach ($all_students as $row) {

            $sid = $row->studentId;

            if (!isset($grouped[$sid])) {

                $grouped[$sid] = [
                    'student'       => $row,
                    'fee_structure' => []
                ];
            }

            if (!empty($row->feeStructureId)) {

                $originalAmount = (float)$row->amount;
                $discountAmount = 0;

                if (!empty($row->discountId)) {

                    if ($row->discountType == 'Percentage') {
                        $discountAmount = ($originalAmount * $row->discountValue) / 100;
                    } else {
                        $discountAmount = $row->discountValue;
                    }
                }

                $finalAmount = $originalAmount - $discountAmount;

                $grouped[$sid]['fee_structure'][$row->feeHeadId] = [
                    'feeHeadId'      => $row->feeHeadId,
                    'headName'       => $row->headName,
                    'originalAmount' => $originalAmount,
                    'discountAmount' => $discountAmount,
                    'finalAmount'    => $finalAmount
                ];
            }
        }

        /* ================= ENUM EXTRACTION ================= */

        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'education_type'");
        $row = $query->row();
        $all_education_type = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_education_type = explode(",", $enum);
        }

        $query = $this->db->query("SHOW COLUMNS FROM tbl_students LIKE 'batchYear'");
        $row = $query->row();
        $all_batch_year = [];
        if ($row) {
            $enum = str_replace(["enum(", ")", "'"], "", $row->Type);
            $all_batch_year = explode(",", $enum);
        }

        /* ================= SUPPORT DATA ================= */

        $all_classes = $this->db->select('classId, className, sectionName')
            ->where('stationId', $StationId)
            ->where('isDeleted', 0)
            ->order_by('addedOn', 'DESC')
            ->get('tbl_classes')
            ->result();

        $all_discounts = $this->db->select('discountId, discountName, discountType, discountValue')
            ->where('stationId', $StationId)
            ->where('isDeleted', 0)
            ->order_by('addedOn', 'DESC')
            ->get('tbl_discounts')
            ->result();

        $all_feeHeads = $this->db->select('feeHeadId, headName, headType')
            ->where('stationId', $StationId)
            ->where('isDeleted', 0)
            ->order_by('addedOn', 'DESC')
            ->get('tbl_fee_heads')
            ->result();

        /* ================= PASS DATA ================= */

        $data['grouped']            = $grouped;
        $data['all_education_type'] = $all_education_type;
        $data['all_batch_year']     = $all_batch_year;
        $data['all_classes']        = $all_classes;
        $data['all_discounts']      = $all_discounts;
        $data['all_fee_heads']      = $all_feeHeads;

        // print_r($data['grouped']);
        // die();

        $this->output->set_header('X-Page-Title: Assign Discounts To Students');
        $this->load->view('pages/fee/all_students', $data);
    }


    public function save_student_discount()
    {
        $StationId = $this->session->userdata('station_id');
        $roleId    = $this->session->userdata('role_id');
        $userId    = $this->session->userdata('user_id');

        $studentId  = (int)$this->input->post('studentId');
        $discountId = (int)$this->input->post('discountId');
        $feeHeadId  = (int)$this->input->post('feeHeadId');
        $startMonth = $this->input->post('startMonth');
        $endMonth   = $this->input->post('endMonth');

        if (!$studentId || !$discountId || !$feeHeadId) {
            echo json_encode([
                'status'  => false,
                'message' => 'Invalid request data'
            ]);
            exit;   // VERY IMPORTANT
        }

        $exists = $this->db
            ->where([
                'stationId'  => $StationId,
                'studentId'  => $studentId,
                'feeHeadId'  => $feeHeadId,
                'isDeleted'  => 0
            ])
            ->get('tbl_student_discounts')
            ->row();

        if ($exists) {
            echo json_encode([
                'status'  => false,
                'message' => 'Discount already assigned to this fee head'
            ]);
            exit;   // VERY IMPORTANT
        }

        $insert = [
            'stationId'  => $StationId,
            'roleId'     => $roleId,
            'studentId'  => $studentId,
            'discountId' => $discountId,
            'feeHeadId'  => $feeHeadId,
            'startMonth' => $startMonth ?: null,
            'endMonth'   => $endMonth ?: null,
            'status'     => 'Active',
            'isDeleted'  => 0,
            'addedBy'    => $userId,
            'addedOn'    => date('Y-m-d H:i:s')
        ];

        $this->db->insert('tbl_student_discounts', $insert);

        if ($this->db->affected_rows() > 0) {
            echo json_encode([
                'status'  => true,
                'message' => 'Discount assigned successfully'
            ]);
        } else {
            echo json_encode([
                'status'  => false,
                'message' => 'Insert failed'
            ]);
        }

        exit;  // VERY IMPORTANT
    }



    public function delete_student_discount()
    {
        $StationId = $this->session->userdata('station_id');
        // Change these to match the AJAX 'data' object
        $studentId = (int)$this->input->post('studentId');
        $feeHeadId = (int)$this->input->post('feeHeadId');

        if (!$studentId || !$feeHeadId) {
            echo json_encode([
                'status'  => false,
                'message' => 'Invalid request'
            ]);
            return;
        }

        // Find the record using the composite keys
        $row = $this->db
            ->where([
                'studentId' => $studentId,
                'feeHeadId' => $feeHeadId,
                'stationId' => $StationId,
                'isDeleted' => 0
            ])
            ->get('tbl_student_discounts')
            ->row();

        if (!$row) {
            echo json_encode([
                'status'  => false,
                'message' => 'Record not found'
            ]);
            return;
        }

        // Update using the primary key found in the row
        $this->db->where('studentDiscountId', $row->studentDiscountId)
            ->update('tbl_student_discounts', [
                'isDeleted' => 1,
                'status'    => 'Inactive'
            ]);

        echo json_encode([
            'status'  => true,
            'message' => 'Discount removed successfully'
        ]);
        exit;
    }
}
