<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 2017-12-05
 * Time: 17:17
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Prices_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $id - id produktu
     * @return Tablica cen dla produktu
     */
    public function getPrices($id){
        $this->db->order_by('price');
        //$this->db->select(array('bidder_id', 'price'));
        $query = $this->db->get_where('prices', array(
            'product_id' => $id
        ));

        return $query->result_array();
    }

    /**
     * @param $id - id produktu
     * @return Maksymalna kwota danego produktu
     */
    public function getMaxPrice($id){
        $this->db->select_max('price');
        $query = $this->db->get_where('prices', array('product_id' => $id));

        //print_r($query->row_array()['price']);
        return $query->row_array()['price'];
    }


    /**
     * @param $id - id produktu
     * @param $bidder_id - id licytujacego
     * @param $price - kwota do zapisania
     * Dodaje kwote do danego produktu
     */
    public function addPrice($id, $bidder_id, $price){
        $this->db->insert('prices', array(
            'product_id' => $id,
            'bidder_id' => $bidder_id,
            'price' => $price,
            'admin_id' => $_SESSION['adminId']
        ));
    }

    /**
     * @param $bidId - id 'ceny'
     * Usuwa 'cene produktu'
     */
    public function deletePrice($bidId){
        $this->db->delete('prices', array(
           'id' => $bidId
        ));
    }

    public function getPrice($bidId){
        $data = array(
          'id' => $bidId
        );

        $query = $this->db->get_where('prices', $data);

        return $query->row_array()['price'];
    }

    public function editPrice($id, $bidderId, $bidPrice){
        $data = array(
          'bidder_id' => $bidderId,
          'price' => $bidPrice
        );

        $this->db->where('id', $id);
        return $this->db->update('prices', $data);
    }

}