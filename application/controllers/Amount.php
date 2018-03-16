<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 2017-12-05
 * Time: 16:45
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Amount extends CI_Controller
{

    public function __construct() {
        parent::__construct();

        $this->load->model('amount_model');
    }

    public function index(){
        $data['amount'] = $this->amount_model->getAmount();


        //Zwracanie JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}