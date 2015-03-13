<?php
/**
 * Created by PhpStorm.
 * User: daixiaoqiang
 * Date: 2015/3/9
 * Time: 21:00
 */
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper(array('form','url'));
    }
    /**
     * Show the default user list to client;
     */
    public function index()
    {
       $this->retrieve();
    }

    /**
     * 注册用户
     */
    public function sign_up()
    {
        if ($this->form_validation->run() === FALSE)
        {
            //表单验证失败，返回注册页面
            $this->load->view('user/sign_up');
        }
        else
        {
            if($this->user_model->create_user())
            {
                //用户创建成功
                $this->load->helper('url');
                $this->user_model->log_in();
                redirect('user/retrieve', 'refresh');
            }
            else
            {
                //用户创建失败
                $this->load->view('user/sign_up');
            }
        }
    }


    /**
     * 用户登录
     */
    public function log_in()
    {
        if ($this->form_validation->run() === FALSE)
        {
            //表单验证失败(用户名-密码验证失败)，返回登录页面
            $this->load->view('user/log_in');
        }
        else
        {
            //用户名-密码验证成功
            //注册session,设定登录状态
            $this->user_model->log_in();
            redirect('user/retrieve', 'refresh');;
        }

    }

    /**
     * 用户退出
     */
    public function log_out()
    {
        if ($this->user_model->log_out() == TRUE)
        {
            $this->load->view('user/log_in');
        }
        else
        {
//            $this->load->view('user/');
        }
    }

    /**
     * 用户信息更新
     */
    public function update()
    {

    }

    /**
     * 获取默认用户列表
     */
    public function retrieve()
    {
        $this->load->library('session');
        $logged_username = $this->session->userdata('username');
        if(!empty($logged_username))
        {
            $data['logged_user'] = array("username" => $logged_username);
        }
        $data['users'] = $this->user_model->retrieve_user_by_off_set();
        $this->load->view('user/retrieve', $data);
    }

    /**
     * 删除用户，根据用户id
     * @param $id
     */
    public function delete($id)
    {
        if($id > 0) {
            $this->user_model->delete_user_by_id($id);
        }
        $this->load->helper('url');
        redirect('user/retrieve', 'refresh');

    }

    /**
     * 自定义Form_Validation callback function，
     * 用于log_in表单
     * 验证用户名是否合法（已经注册，在数据库已经经存在的）
     * @param $username
     * @return bool
     */
    public function username_check($username)
    {
        if ($this->user_model->retrieve_user_by_username($username))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('username_check','用户名 %s 不存在');
            return FALSE;
        }
    }

    /**
     * 自定义Form_Validation callback function，
     * 用于log_in表单
     * 验证用户名-密码是否正确
     * @param $password
     * @return bool
     */
    public function password_check($password)
    {
        if ($this->user_model->password_check())
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('password_check', '用户名或密码不正确');
            return FALSE;
        }
    }

    /**
     * 自定义Form_Validation callback function，
     * 用于sign_up表单
     * 验证用户名是否已经存在
     * @param $username
     * @return bool
     */
    function username_exists($username)
    {
        if ($this->user_model->retrieve_user_by_username($username))
        {
            $this->form_validation->set_message('username_exists', '用户名已被占用');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 自定义Form_Validation callback function，
     * 用于sign_up表单
     * 验证邮箱是否已经存在
     * @param $email
     * @return bool
     */
    function email_exists($email)
    {
        if ($this->user_model->email_exists($email))
        {
            $this->form_validation->set_message('email_exists', '邮箱已被占用');
            return FALSE;
        }
        return TRUE;
    }
}