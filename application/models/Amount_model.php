<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 2017-12-05
 * Time: 16:49
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Amount_model extends CI_Model
{

    public function __construct() {
        parent::__construct();

        $this->load->model('products_model');
        $this->load->model('prices_model');
    }

    /**
     * @return int
     * Pobiera sumę maksymalnych cen produktów
     */
    public function getAmount(){
        $products = $this->products_model->getAll();
        $amount = 0;

        foreach ($products as $product){
            $id = intval($product['id']);
            $price = $this->prices_model->getMaxPrice($id);
            //var_dump($price);

            $amount += $price;
            //var_dump($amount);
        }

        return $amount;
    }

    /**
     * Wpisuje sumę cen do tablicy amount
     */
    public function setAmount(){
        $amount = $this->getAmount();

        $this->db->insert('amounts', array(
            'amount' => $amount
        ));
    }


}