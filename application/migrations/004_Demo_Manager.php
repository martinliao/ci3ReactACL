<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Demo_Manager extends CI_Migration
{
    /**
     * Config settings
     * @var array
     */
    private $settings;

    private function get_settings()
    {
        //Load configs
        $this->config->load('smarty_acl', TRUE);
        //Get tables array
        $tables = $this->config->item('tables', 'smarty_acl');
        //Tables prefix
        $this->settings['prefix'] = $tables['prefix'] ? $tables['prefix'].'_' : '';
        // Table names
        $this->settings['admins'] = $tables['admins'];
        $this->settings['user_access'] = 'user_access'; // ToDo: $tables['user_access'];
    }

    public function up()
    {
        //Load settings
        $this->get_settings();       
        /**************** Start Insert Data ****************/
        // Demo Manager(2)
        $this->db->insert($this->settings['admins'],[
            'username' => 'jack',
            'password' => '$2y$10$TmJKG3yV8o7kCycAdQI0/.7jJ5uhO3RC9pyJOMlbFHmbEzUk8JMfu',
            'name' => 'Jack',
            'email' => 'jack@click-ap.com',
            'role_id' => 2,
            'status' => 'active',
            'ip' => '172.19.0.1',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
       ]);

        // Demo access(permission)
        $this->db->insert($this->settings['user_access'],['id_menu' => 9, 'id_role' => 2]);
        $this->db->insert($this->settings['user_access'],['id_menu' => 10, 'id_role' => 2]);
        $this->db->insert($this->settings['user_access'],['id_menu' => 11, 'id_role' => 2]);

        /**************** End Insert Data ****************/
    }

    public function down()
    {
        //Load settings
        $this->get_settings();
    }
}