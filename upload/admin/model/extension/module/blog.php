<?php

class ModelExtensionModuleBlog extends Model {


public function SaveSettings() {
$this->load->model('setting/setting');
$this->model_setting_setting->editSetting('module_blog', $this->request->post);
}


public function LoadSettings() {
return $this->config->get('module_blog_status');
}

public function install(){
    $this->db->query("CREATE TABLE " . DB_PREFIX . "blog_posts ( `id_news` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `name` VARCHAR(100) NOT NULL , `description` TEXT NOT NULL , PRIMARY KEY (`id_news`)) ENGINE = InnoDB;");
}

public function uninstall(){
    $this->db->query("drop table " . DB_PREFIX ."blog_posts");
}

}