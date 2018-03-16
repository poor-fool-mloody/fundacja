<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 2017-12-05
 * Time: 17:17
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Prices extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('prices_model');
    }

    public function index($id = null){
        $this->getPrices($id);
    }

    /**
     * @param null $id - ID produktu
     */
    public function getPrices($id = null){
        if ($id === null)
            show_404();

        $data = $this->prices_model->getPrices($id);

        //Zwracanie JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}