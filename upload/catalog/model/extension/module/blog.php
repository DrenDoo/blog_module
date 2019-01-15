<?php

class ModelExtensionModuleBlog extends Model {

    public function LoadSettings() {
        return $this->config->get('module_blog_status');
    }

    public function Save($user_id,$name,$description,$id_news = null){
        if(!$id_news){
            $query = $this->db->query("
            insert into " . DB_PREFIX . "blog_posts set user_id = {$user_id}, name = '{$name}', description = '{$description}';
            ");
        } else {
            $query = $this->db->query("
            update " . DB_PREFIX . "blog_posts set user_id = {$user_id}, name = '{$name}', description = '{$description}' where id_news = {$id_news};
            ");
        }
    }

    public function GetUserPosts($user_id = null){
        if (!$user_id){
            $query = $this->db->query("SELECT name, description, firstname, lastname, id_news, user_id FROM `" . DB_PREFIX . "blog_posts` as bp, `oc_customer` as c WHERE bp.user_id = c.customer_id;");
        } else {
            $query = $this->db->query("SELECT name, description, firstname, lastname, id_news, user_id FROM `" . DB_PREFIX . "blog_posts` as bp, `oc_customer` as c WHERE bp.user_id = c.customer_id and bp.user_id = {$user_id};");
        }

        return $query->rows;

    }

    public function GetPostById($id_news){
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_posts`  WHERE id_news = {$id_news};");
        return $query->rows;

    }

    public function DeletePostById($id_news){
        $query = $this->db->query("DELETE FROM `" . DB_PREFIX . "blog_posts` WHERE id_news ={$id_news};");
    }

}