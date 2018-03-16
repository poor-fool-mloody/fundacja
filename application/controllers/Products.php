<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 2017-12-05
 * Time: 17:11
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('products_model');
    }

    public function index(){
        $this->getAll();
    }

    public function getAll(){
        $data = $this->products_model->getAll();

        //Zwracanie JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}