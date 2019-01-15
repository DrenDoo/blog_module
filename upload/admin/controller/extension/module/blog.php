<?php

class ControllerExtensionModuleBlog extends Controller {

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('extension/module/blog');
    }

    public function index() {

if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

$this->model_extension_module_blog->SaveSettings();

$this->session->data['success'] = 'Настройки сохранены';
$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
}


$data = array();
$data['module_blog_status'] = $this->model_extension_module_blog->LoadSettings();

$data += $this->load->language('extension/module/blog');

$data += $this->GetBreadCrumbs();


$data['action'] = $this->url->link('extension/module/blog', 'user_token=' . $this->session->data['user_token'], true);
$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

$data['header'] = $this->load->controller('common/header');
$data['column_left'] = $this->load->controller('common/column_left');
$data['footer'] = $this->load->controller('common/footer');


$this->response->setOutput($this->load->view('extension/module/blog', $data));

}

public function install(){
    $this->model_extension_module_blog->install();
}

public function uninstall(){
    $this->model_extension_module_blog->uninstall();

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
'text' => 'Пример модуля',
'href' => $this->url->link('extension/module/blog', 'token=' . $this->session->data['user_token'], true)
);
return $data;
}

}