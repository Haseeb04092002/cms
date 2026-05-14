<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UpdateBatch extends CI_Controller {

    public function index() {
        $years = [];
        for ($i = 2010; $i <= 2030; $i++) {
            $next_year = substr((string)($i + 1), -2);
            $years[] = "'" . $i . "-" . $next_year . "'";
        }
        $enum_str = implode(',', $years);

        $tables = $this->db->query("SELECT TABLE_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND COLUMN_NAME = 'batchYear'")->result();

        foreach ($tables as $t) {
            $table = $t->TABLE_NAME;
            $sql = "ALTER TABLE $table MODIFY COLUMN batchYear ENUM($enum_str) DEFAULT NULL";
            if ($this->db->query($sql)) {
                echo "$table altered successfully.\n";
            } else {
                echo "Error altering $table.\n";
            }
        }
        echo "Done.\n";
    }
}
