<?php
class ModelExtensionModuleFeedback extends Model {
    public function install() {
      $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "feedback` ( `id` INT NOT NULL AUTO_INCREMENT, `Name` varchar(255) NOT NULL DEFAULT, `Email` varchar(255) NOT NULL DEFAULT, `Phone` varchar(255) NOT NULL DEFAULT, `Date` date NOT NULL) ENGINE = InnoDB;");
    }

    public function uninstall() {
      $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "feedback`");
    }
    public function SaveSettings() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('module_feedback', $this->request->post);
    }

    public function LoadSettings() {
        return $this->config->get('module_feedback_status');
    }

    public function getData () {
        $sql = "SELECT * FROM `". DB_PREFIX . "feedback`";
        return $this->db->query($sql)->rows;
    }
}
?>