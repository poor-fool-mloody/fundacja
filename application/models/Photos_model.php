<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 12.02.2018
 * Time: 11:52
 */

class Photos_model extends CI_Model
{
    public function getActivePhoto(){
        $query = $this->db->get_where('products', array(
            'is_active' => 1
        ));

        return $query->row_array()['id'];
    }

    public function resetPhoto(){
        $this->db->update('products', array(
            'is_active' => 0
        ));
    }

    public function setPhoto($prodId){
        $this->resetPhoto();
        $this->db->set(array(
            'is_active' => 1
        ));
        $this->db->where('id', $prodId);

        $this->db->update('products');

    }
}