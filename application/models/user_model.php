<?php
/**
 * Created by PhpStorm.
 * User: daixiaoqiang
 * Date: 2015/3/9
 * Time: 21:03
 */

class User_model extends CI_Model
{
    /**
     *在constructor中加载数据库操作类库
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     *  创建用户到数据库表中
     */
    public function create_user()
    {
        $this->load->helper('url');

        $user_data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'email' => $this->input->post('email'),
            'sex' => $this->input->post('sex'),
            'age' => $this->input->post('age'),
        );
        return $this->db->insert('user', $user_data);
    }

    /**
     * 更新用户的信息
     */
    public function update_user()
    {
        $this->load->helper('url');

        $user_data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'email' => $this->input->post('email'),
            'sex' => $this->input->post('sex'),
            'age' => $this->input->post('age'),
        );
        $this->db->where('username', $this->input->post('username'));
        $this->db->update('user', $user_data);

    }

    /**
     * 查找特定用户
     * 以username为条件
     * @param string $username 用户名，默认值为false
     *
     */
    public function retrieve_user_by_username($username = FALSE)
    {
        if($username === FALSE)
        {
            retrieve_user_by_off_set();
        }
        else
        {
            $this->db->where('username', $username);
            $query =  $this->db->get('user');
            if($query->num_rows() == 1)
            {
                return $query->row_array();
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
     * 查找特定用户
     * 以用户id为条件
     * @param int $id 用户id，默认值为false
     */
    public function retrieve_user_by_id($id = FALSE)
    {
        if(!($id>0))
        {
            retrieve_user_by_off_set();
        }
        else
        {
            $this->db->where('id', $id);
            $query = $this->db->get('user');
            if($query->num_rows() == 1)
            {
                return $query->row_array();
            }
        }
    }

    /**
     * 获取一个或者多个用户
     * @param int $off_set 当前游标，默认为0
     * @param int $num 检索数据条数，默认为10条
     */
    public function retrieve_user_by_off_set($off_set = 0, $num = 10)
    {
        $this->db->where('id >', $off_set);
        $this->db->limit(10);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('user');
        return $query->result_array();
    }

    /**
     * 根据id删除user表中的记录
     * @param $ids 用户id，或者是包含多个id的数组，默认值为false
     * 当$ids是数组时，删除多条记录
     * 当$ids不是数组时，删除单条记录
     */
    public function delete_user_by_id($ids = FALSE)
    {
        if (!($ids === FALSE))
        {
            //参数是包含多个id的数组时，删除多条记录
            if (is_array($ids))
            {
                foreach ($ids as $id)
                {
                    $this->db->where('id', $id);
                    $this->db->delete('user');
                }
                return TRUE;
            } //参数不是数组时，删除单条记录
            else
            {
                $this->db->where('id', $ids);
                return $this->db->delete('user');
            }
        }
        return FALSE;
    }

    /**
     * 判断数据库中的用户名、密码与数据库中的是否一致
     * 当用户不存在是直接返回:FALSE
     * 当用户名存在时，验证密码是否正确，正确返回:TRUE,否则返回:FALSE
     * @param $username
     * @param $password
     * @return bool
     */
    public function password_check()
    {
        $this->load->helper('url');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user = $this->retrieve_user_by_username($username);
        if(!($user === FALSE))
        {
            return $user['password'] == md5($password) ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * 检查参数中提供的邮箱是否已存在与数据库中，
     * 已存在则返回TRUE,不存在则返回FALSE;
     * @param $email
     * @return bool
     */
    public function email_exists($email)
    {
        $this->load->helper('url');
        $this->db->where('email', $email);
        $query = $this->db->get('user');
        return ($query->num_rows())>0 ? TRUE : FALSE;
    }

    /**
     * 执行登录操作：保存用户数据到session中
     */
    public function log_in()
    {
        $this->load->library('session');
        $this->load->helper('url');
        $username = $this->input->post('username');
        $data = array('username'=>$username, 'logged_in'=>TRUE);
        $this->session->set_userdata($data);//添加session数据
    }

    /**
     * 执行退出操作：销毁所有session数据
     * @return bool
     */
    public function log_out()
    {
        $this->load->library('session');
        $this->session->sess_destroy();
        return TRUE;

    }
}