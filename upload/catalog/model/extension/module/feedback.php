<?php
class ModelExtensionModuleFeedback extends Model {
    public function LoadSettings() {
        return $this->config->get('module_feedback_status');
    }
    public function saveTicket($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "feedback SET Name = '" . $this->db->escape($data['name']) . "', Email = '" .
            $this->db->escape($data['email']) . "', Phone = '" . $this->db->escape($data['phone']) . "', Date = '" . date('Y-m-d') ."'");
    }
}
?>