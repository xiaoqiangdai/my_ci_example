<?php
/**
 * Created by PhpStorm.
 * User: daixiaoqiang
 * Date: 2015/3/11
 * Time: 22:24
 */
$config = array(
    //validation for sign_up form
    'user/sign_up' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|min_length[2]|max_length[12]|xss_clean|callback_username_exists'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' =>  'trim|required|matches[pass_confirm]|md5'
        ),
        array(
            'field' => 'pass_confirm',
            'label' => 'pass_confirm',
            'rules' => 'trim|required|md5'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|callback_email_exists'
        )
    ),
    //validation for log_in form
    'user/log_in' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|min_length[2]|max_length[12]|xss_clean|callback_username_check'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' =>  'trim|required|callback_password_check'
        )
    )

);