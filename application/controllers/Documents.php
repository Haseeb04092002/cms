<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends MY_Controller
{
    public function UploadDocuments($Reference = '', $ReferenceId = 0, $upload_type = 'both')
    {
        $Reference = 'Student';

        $Response['status']  = false;
        $Response['message']  = "Some Error Occured. Try Again";

        $image_upload = false;
        $video_upload = false;

        switch ($upload_type) {
            case 'image':
                $image_upload = $this->ImageUpload($Reference, $ReferenceId);
                if ($image_upload) {
                    $Response['Status'] = true;
                    $Response['Message'] = 'Files uploaded successfully';
                }
                break;
            case 'video':
                $video_upload = $this->VideoUpload($Reference, $ReferenceId);
                if ($video_upload) {
                    $Response['Status'] = true;
                    $Response['Message'] = 'Files uploaded successfully';
                }
                break;
            case 'both':
                $image_upload = $this->ImageUpload($Reference, $ReferenceId);
                $video_upload = $this->VideoUpload($Reference, $ReferenceId);
                if ($image_upload && $video_upload) {
                    $Response['Status'] = true;
                    $Response['Message'] = 'Files uploaded successfully';
                }
                break;
        }

        exit(json_encode($Response));
    }

    public function ImageUpload($Reference = '', $ReferenceId = 0): bool
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

        $ImagePath = "uploads/$Reference/$ReferenceId/images";
        $uploadDir = FCPATH . $ImagePath;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!is_writable($uploadDir)) {
            return false;
        }

        $this->load->library('upload');
        $image_upload = true;

        $images_count = count($_FILES['images']['name']);

        for ($i = 0; $i < $images_count; $i++) {
            $_FILES['file']['name']     = $_FILES['images']['name'][$i];
            $_FILES['file']['type']     = $_FILES['images']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['images']['error'][$i];
            $_FILES['file']['size']     = $_FILES['images']['size'][$i];

            $config = [
                'upload_path'   => $uploadDir,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 30000,
                'encrypt_name'  => true,
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileData = $this->upload->data();
                $this->db->insert('tbl_documents', [
                    'stationId'     => $StationId,
                    'userId'     => $UserId,
                    'referenceId'   => $ReferenceId,
                    'referenceType'   => $Reference,
                    'documentTitle'   => $_FILES['file']['name'],
                    'addedOn'    => date('Y-m-d H:i:s'),
                    'addedBy'    => $UserId
                ]);
            } else {
                $image_upload = false;
            }
        }

        return $image_upload;
    }



    function VideoUpload($Reference = 'Properties', $ReferenceId = 0): bool
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
