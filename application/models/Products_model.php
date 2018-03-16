<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 2017-12-05
 * Time: 17:11
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return Zwraca tablice wsztstkich produktów
     */
    public function getAll(){
        $query = $this->db->get('products');

        return $query->result_array();
    }

    /**
     * @param $id
     * @return Zwraca produkt
     */
    public function getById($id){
        $query = $this->db->get_where('products', array(
            'id' => $id
        ));

        return $query->row_array();
    }

    /**
     * @param $name
     * Dodaje produkt
     */
    public function add($name){
        $this->db->insert('products', array(
            'name' => $name,
            'admin_id' => $_SESSION['adminId']
        ));
    }

    /**
     * @param $id
     * Usuwa produkt
     */
    public function delete($id){
        //Usuwanie relacji
        $this->db->delete('prices', array(
           'product_id' => $id
        ));

        //Usuwanie produktu
        $this->db->delete('products', array(
           'id' => $id
        ));
    }

    /**
     * @param $id
     * @param $new_name
     * Edytuje produkt
     */
    public function edit($id, $new_name){
        $this->db->set('name', $new_name);
        $this->db->where('id', $id);

        $this->db->update('products');
    }
	
	public function getIdByName($product_name){
		$query = $this->db->get_where('products', array(
			'name' => $product_name
		));
		
		return $query->row_array()['id'];
	}

}