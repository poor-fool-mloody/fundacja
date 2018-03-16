<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 2017-12-05
 * Time: 18:45
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Admin_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    public function checkUser($login, $password){
        $query = $this->db->get_where('users', array(
            'login' => $login
        ));

        $hash = $query->row_array()['password'];

        return password_verify($password, $hash);
    }

    public function getUserId($login){
        $query = $this->db->get_where('users', array(
            'login' => $login
        ));

        return $query->row_array()['id'];
    }

    public function addUser($login, $hash){
        $query = $this->db->insert('users', array(
            'login' => $login,
            'password' => $hash
        ));

        return $query;
    }

}