<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Document_upload extends CI_Model
{
    public function UploadDocuments($file = '', $Reference = '', $ReferenceId = 0, $upload_type = 'both')
    {
        // $Reference = 'Student';

        $Response['status']  = false;
        $Response['message']  = "Some Error Occured. Try Again";

        $image_upload = false;
        $video_upload = false;

        switch ($upload_type) {
            case 'image':
                $image_upload = $this->ImageUpload($file, $Reference, $ReferenceId);
                if ($image_upload) {
                    $Response['Status'] = true;
                    $Response['Message'] = 'Files uploaded successfully';
                }
                break;
            case 'video':
                $video_upload = $this->VideoUpload($file, $Reference, $ReferenceId);
                if ($video_upload) {
                    $Response['Status'] = true;
                    $Response['Message'] = 'Files uploaded successfully';
                }
                break;
            case 'both':
                $image_upload = $this->ImageUpload($file, $Reference, $ReferenceId);
                $video_upload = $this->VideoUpload($file, $Reference, $ReferenceId);
                if ($image_upload && $video_upload) {
                    $Response['Status'] = true;
                    $Response['Message'] = 'Files uploaded successfully';
                }
                break;
        }

        // exit(json_encode($Response));
        return $Response;
    }


    public function task_doc_upload($file = '', $Reference = '', $ReferenceId = 0, $upload_type = 'both')
    {
        $Response['status']  = false;
        $Response['message']  = "Some Error Occured. Try Again";

        $image_upload = false;

        $image_upload = $this->task_upload($file, $Reference, $ReferenceId, 'task_doc', 'all_files');
        if ($image_upload) {
            $Response['Status'] = true;
            $Response['Message'] = 'Files uploaded successfully';
        }

        // exit(json_encode($Response));
        return $Response;
    }



    public function ImageUpload($file, $Reference = '', $ReferenceId = 0, $newFileName = 'profile_img', $lastFolder = 'images'): bool
    {
        $StationId = $this->session->userdata('station_id') ?? '';
        $UserId    = $this->session->userdata('user_id') ?? '';

        $uploadDir = FCPATH . "uploads/$Reference/$ReferenceId/$lastFolder/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // 🔹 Get file extension
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = $newFileName . strtolower($ext);
        $fullPath = $uploadDir . $fileName;

        // 🔴 Delete old file (if exists)
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // 🔴 Delete old DB record
        $this->db->where([
            'referenceId'   => $ReferenceId,
            'referenceType' => $Reference,
            'documentTitle' => $newFileName
        ])->delete('tbl_documents');

        $this->load->library('upload');

        $_FILES['file'] = [
            'name'     => $fileName,
            'type'     => $file['type'],
            'tmp_name' => $file['tmp_name'],
            'error'    => $file['error'],
            'size'     => $file['size']
        ];

        $config = [
            'upload_path'   => $uploadDir,
            'allowed_types' => '*',
            'max_size'      => 9999999999999,
            'overwrite'     => true,
            'file_name'     => $fileName
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            log_message('error', $this->upload->display_errors());
            return false;
        }

        // 🔹 Save DB record
        $this->db->insert('tbl_documents', [
            'stationId'     => $StationId,
            'userId'        => $UserId,
            'referenceId'   => $ReferenceId,
            'referenceType' => $Reference,
            'documentTitle' => $newFileName,
            'documentPath'  => "uploads/$Reference/$ReferenceId/$lastFolder/$fileName",
            'addedOn'       => date('Y-m-d H:i:s'),
            'addedBy'       => $UserId
        ]);

        return true;
    }


    public function task_upload($file, $Reference = '', $ReferenceId = 0, $newFileName = '', $lastFolder = ''): bool
    {
        $StationId = $this->session->userdata('station_id');
        $UserId    = $this->session->userdata('user_id');

        $uploadDir = FCPATH . "uploads/$Reference/$ReferenceId/$lastFolder/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = $newFileName . '_' . time() . '.' . strtolower($ext);

        $this->load->library('upload');

        $_FILES['file'] = [
            'name'     => $fileName,
            'type'     => $file['type'],
            'tmp_name' => $file['tmp_name'],
            'error'    => $file['error'],
            'size'     => $file['size']
        ];

        $config = [
            'upload_path'   => $uploadDir,
            'allowed_types' => '*',
            'max_size'      => 0,
            'overwrite'     => false
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            log_message('error', $this->upload->display_errors());
            return false;
        }

        $this->db->insert('tbl_documents', [
            'stationId'     => $StationId,
            'userId'        => $UserId,
            'referenceId'   => $ReferenceId,
            'referenceType' => $Reference,
            'documentTitle' => $fileName,
            'documentPath'  => "uploads/$Reference/$ReferenceId/$lastFolder/$fileName",
            'addedOn'       => date('Y-m-d H:i:s'),
            'addedBy'       => $UserId
        ]);

        return true;
    }



    public function getProfileImage($Reference, $ReferenceId)
    {
        return $this->db
            ->where([
                'referenceType' => $Reference,
                'referenceId'   => $ReferenceId,
                'documentTitle' => 'profile_img'
            ])
            ->get('tbl_documents')
            ->row();
    }


    function allUpload($file, $Reference = '', $ReferenceId = 0): bool
    {
        $StationId = $this->session->userdata('station_id') ?? '';
        $UserId    = $this->session->userdata('user_id') ?? '';

        $uploadDir = FCPATH . "uploads/$Reference/$ReferenceId/images/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // 🔹 Get file extension
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = 'profile_img.' . strtolower($ext);
        $fullPath = $uploadDir . $fileName;

        // 🔴 Delete old file (if exists)
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // 🔴 Delete old DB record
        $this->db->where([
            'referenceId'   => $ReferenceId,
            'referenceType' => $Reference,
            'documentTitle' => 'profile_img'
        ])->delete('tbl_documents');

        $this->load->library('upload');

        $_FILES['file'] = [
            'name'     => $fileName,
            'type'     => $file['type'],
            'tmp_name' => $file['tmp_name'],
            'error'    => $file['error'],
            'size'     => $file['size']
        ];

        $config = [
            'upload_path'   => $uploadDir,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 30000,
            'overwrite'     => true,
            'file_name'     => $fileName
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            log_message('error', $this->upload->display_errors());
            return false;
        }

        // 🔹 Save DB record
        $this->db->insert('tbl_documents', [
            'stationId'     => $StationId,
            'userId'        => $UserId,
            'referenceId'   => $ReferenceId,
            'referenceType' => $Reference,
            'documentTitle' => 'profile_img',
            'documentPath'  => "uploads/$Reference/$ReferenceId/images/$fileName",
            'addedOn'       => date('Y-m-d H:i:s'),
            'addedBy'       => $UserId
        ]);

        return true;
    }



    function VideoUpload($file, $Reference = 'Properties', $ReferenceId = 0): bool
    {
        $Reference      = ($Reference) ? $Reference : $this->input->post('txtReferenceType');
        $ReferenceName  = 'Properties';
        $ReferenceId    = ($ReferenceId) ? $ReferenceId : $this->input->post('txtReferenceId');
        $varNow         = date('Y-m-d H:i:s');
        $AdminId        = $this->session->userdata('user_id');
        $AdminName      = $this->session->userdata('user_name');
        $StationId      = $this->session->userdata('user_station') ?? '9';
        $VideoPath = "uploads/$Reference/$ReferenceId/videos";
        $uploadDir = FCPATH . $VideoPath;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!is_writable($uploadDir)) {
            return false;
        }

        $this->load->library('upload');
        $video_upload = true;

        $videos_count = count($_FILES['videos']['name']);

        for ($i = 0; $i < $videos_count; $i++) {
            $_FILES['file']['name']     = $_FILES['videos']['name'][$i];
            $_FILES['file']['type']     = $_FILES['videos']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['videos']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['videos']['error'][$i];
            $_FILES['file']['size']     = $_FILES['videos']['size'][$i];

            $config = [
                'upload_path'   => $uploadDir,
                'allowed_types' => '*',
                'max_size'      => 50000000000, // in KB
                'encrypt_name'  => true,
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileData = $this->upload->data();
                $this->db->insert('tbl_documents', [
                    'ReferenceId'   => $ReferenceId,
                    'Reference'     => ucwords(str_replace("_", " ", $Reference)),
                    'ReferenceName' => $ReferenceName,
                    'StationId'     => $StationId,
                    'FileName'      => $fileData['file_name'],
                    'FileSize'      => $fileData['file_size'],
                    // 'DocumentTitle' => $files['name'][$i],
                    'UploadedBy'    => $AdminId,
                    'UploadTime'    => $varNow
                ]);
            } else {
                $video_upload = false;
            }
        }

        return $video_upload;
    }
}
