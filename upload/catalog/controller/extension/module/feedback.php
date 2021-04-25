<?php
class ControllerExtensionModuleFeedback extends Controller {
    public function index() {
        $this->load->language('extension/module/feedback');
        $this->load->model('extension/module/feedback');
        $data = array();
        $data['module_feedback_status'] = $this->model_extension_module_feedback->LoadSettings();
        return $this->load->view('extension/module/feedback', $data);
    }

    public function send_message() {
        $this->load->language('extension/module/feedback');
        $this->load->model('extension/module/feedback');

        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 25)) {
                $json['error'] = $this->language->get('error_name');
            }

            if ((utf8_strlen($this->request->post['email']) < 2) || (utf8_strlen($this->request->post['email']) > 60) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
                $json['error'] = $this->language->get('error_email');
            }

            if ((utf8_strlen($this->request->post['phone']) < 5) || (utf8_strlen($this->request->post['phone']) > 10)) {
                $json['error'] = $this->language->get('error_phone');
            }

            if (empty($this->session->data['captcha_contact_form']) || ($this->session->data['captcha_contact_form'] != $this->request->post['captcha'])) {
                $json['error'] = $this->language->get('error_verification');
            }

            unset($this->session->data['captcha_contact_form']);

            if (!isset($json['error'])) {
                $this->model_extension_module_feedback->saveTicket($this->request->post);
                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }


    public function captcha() {
        $num1=rand(2,6);
        $num2=rand(2,6);
        $this->session->data['captcha_contact_form'] = $num1+$num2;
        $image = imagecreatetruecolor(58, 22);
        $width = imagesx($image);
        $height = imagesy($image);
        $black = imagecolorallocate($image, 50, 50, 50);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, $width, $height, $white);
        imagestring($image, 4, 0, 3, "$num1"." + "."$num2"." =", $black);
        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}
?>