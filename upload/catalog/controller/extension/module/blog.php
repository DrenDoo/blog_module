<?php

class ControllerExtensionModuleBlog extends Controller {

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->load->model('extension/module/blog');
    }

    private function load_data(){
        $data = array();

        $data += $this->load->language('extension/module/blog');

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $data['heading_title_blog'],
            'href' => $this->url->link('extension/module/blog')
        );

        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        return $data;
    }

    public function index() {
        $data = $this->load_data();

        if ($_POST){
            $this->model_extension_module_blog->Save($this->session->data['customer_id'], $_POST['title-post'], $_POST['post-text'],isset($_POST['id_news'])?$_POST['id_news']:null);
            $this->response->redirect($this->url->link('extension/module/blog'));
        }

        $data['edit_link'] = $this->url->link('extension/module/blog/edit&id_news=','', true);
        $data['delete_link'] = $this->url->link('extension/module/blog/delete&id_news=','', true);
        $data['customer_id'] = isset($this->session->data['customer_id'])? $this->session->data['customer_id'] : null;
        $data['posts'] = $this->model_extension_module_blog->GetUserPosts($data['customer_id']);

        $this->response->setOutput($this->load->view('extension/module/blog/blog', $data));
    }

    public function add() {
        if (!($this->model_extension_module_blog->LoadSettings() && isset($this->session->data['customer_id']))){
            $this->session->data['redirect'] = $this->url->link('account/edit', '', true);
            $this->response->redirect($this->url->link('account/login', '', true));
        }

        $data = $this->load_data();
        $data['action'] = $this->url->link('extension/module/blog','', true);
        $this->response->setOutput($this->load->view('extension/module/blog/add', $data));
    }

    public function edit() {
        if (!($this->model_extension_module_blog->LoadSettings() && isset($this->session->data['customer_id']))){
            $this->session->data['redirect'] = $this->url->link('account/edit', '', true);
            $this->response->redirect($this->url->link('account/login', '', true));
        }
        $id_news = isset($this->request->get['id_news'])?$this->request->get['id_news']:null;
        if (!$id_news){
            $this->response->redirect($this->url->link('extension/module/blog', '', true));
        }
        $data = $this->load_data();
        $data['post'] = $this->model_extension_module_blog->GetPostById($id_news)[0];
        $data['action'] = $this->url->link('extension/module/blog','', true);

        $this->response->setOutput($this->load->view('extension/module/blog/edit', $data));
    }

    public function delete() {
        if (!($this->model_extension_module_blog->LoadSettings() && isset($this->session->data['customer_id']))){
            $this->session->data['redirect'] = $this->url->link('account/edit', '', true);
            $this->response->redirect($this->url->link('account/login', '', true));
        }
        $id_news = isset($this->request->get['id_news'])?$this->request->get['id_news']:null;
        if (!$id_news){
            $this->response->redirect($this->url->link('extension/module/blog', '', true));
        }
        $this->model_extension_module_blog->DeletePostById($id_news);
        $this->response->redirect($this->url->link('extension/module/blog', '', true));
    }

    public function news() {
        $data = $this->load_data();
        if (!$this->model_extension_module_blog->LoadSettings() ){
            $this->response->redirect($this->url->link('common/home', '', true));
        }



        $data['edit_link'] = $this->url->link('extension/module/blog/edit&id_news=','', true);
        $data['delete_link'] = $this->url->link('extension/module/blog/delete&id_news=','', true);
        $data['customer_id'] = isset($this->session->data['customer_id'])? $this->session->data['customer_id'] : null;
        $data['posts'] = $this->model_extension_module_blog->GetUserPosts();


        $this->response->setOutput($this->load->view('extension/module/blog/blog', $data));
    }


}