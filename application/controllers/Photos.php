<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 12.02.2018
 * Time: 11:51
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Photos extends CI_Controller
{
    public function __construct() {
        parent::__construct();

        $this->load->model('photos_model');
    }

    public function getPhoto(){
        $data['img'] = $this->photos_model->getActivePhoto();

        //$data['img'] = $data['img'] . '.jpg';

        //Zwracanie JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function resetPhoto(){
        $this->photos_model->resetPhoto();

        redirect("/admin/", 'refresh');
    }

    public function setPhoto($prodId = null){
        if($prodId === null){
            show_404();
        }

        $this->photos_model->setPhoto($prodId);
        redirect("/admin/product/" . $prodId, 'refresh');
    }

}