<?php
class ControllerExtensionModuleFeedback extends Controller {

  public function index() {
    $this->load->model('extension/module/feedback');
    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      $this->model_extension_module_feedback->SaveSettings();
      $this->session->data['success'] = 'Настройки сохранены';
      $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
    }

    $data = array();
    $data['module_feedback_status'] = $this->model_extension_module_feedback->LoadSettings();
    $data += $this->load->language('extension/module/feedback');
    $data += $this->GetBreadCrumbs();

    $data['table'] = $this->model_extension_module_feedback->getData();

    $data['action'] = $this->url->link('extension/module/feedback', 'user_token=' . $this->session->data['user_token'], true);
    $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('extension/module/feedback', $data));

  }
    private function getTable() {
        $data = array();
        $data['module_feedback_status'] = $this->model_extension_module_feedback->LoadSettings();
    }

  private function GetBreadCrumbs() {
    $data = array(); $data['breadcrumbs'] = array();
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
    );
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_extension'),
      'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
    );
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $this->url->link('extension/module/feedback', 'user_token=' . $this->session->data['user_token'], true)
    );
    return $data;
  }

}
?>