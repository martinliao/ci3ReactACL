<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter-HMVC
 *
 * @package    CodeIgniter-HMVC
 * @author     N3Cr0N (N3Cr0N@list.ru)
 * @copyright  2019 N3Cr0N
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       <URI> (description)
 * @version    GIT: $Id$
 * @since      Version 0.0.1
 * @filesource
 *
 */

class AdminController extends MY_Controller
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout, ....
     */
    protected $data = array();

    protected $theme = '_reactadmin/admin'; // default';

    protected $role_id;

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        // To inherit directly the attributes of the parent class.
        parent::__construct();

        // CI profiler
        $this->output->enable_profiler(false);

        // This function returns the main CodeIgniter object.
        // Normally, to call any of the available CodeIgniter object or pre defined library classes then you need to declare.
        $CI =& get_instance();

        $this->load->library('smarty_acl');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
#debugBreak();
        #$_admins = $this->smarty_acl->admins(false);
        #$this->role_id = $_admins[0]['role_id'];
        //Example data
        $this->data['sitename'] = 'CodeIgniter-HMVC';
        $this->data['site_title'] = ucfirst('Admin Dashboard');
        // for readtadmin
        $this->data = [
            'title' => "Admin",
            //'ss_settings' => $this->db->get_where('system_settings', ['id' => 1])->row(),
        ];
        $this->data['ss_settings'] = array(
            'id' => '1',
            'nama' => 'Click-React',
            'nohp' => '886436080088',
            'alamat' => 'MoodleTW ....',
            'logo' => 'noimage1.png',
            'footer_right' => 'Version 1.0',
            'footer_left' => 'Copyright @2023 Click-AP(MoodleTW) - All Rights Reserved.'
        );
    }

    protected function logged_in()
    {
        if (!$this->smarty_acl->logged_in()) {
            return redirect('Admins/login');
        }
    }


    /**
     * [render_page description]
     *
     * @method render_page
     *
     * @param  [type]      $view [description]
     * @param  [type]      $data [description]
     *
     * @return [type]            [description]
     */
    protected function render_page($view, $data)
    {
        $_theme = $this->theme; // views/_layout
        $data = array_merge($this->data, $data);

        $data['css'] = $this->load->view("{$_theme}/_css.php", $data, TRUE);
        $this->load->view("{$_theme}/header", $data);
        
        $data['navbar'] = $this->load->view("{$_theme}/navbar.php", $data, TRUE);
        $data['sidebar'] = $this->load->view("{$_theme}/sidebar.php", $data, TRUE);
        $data['view'] = $this->load->view($view, $data, true);
        $this->load->view("{$_theme}/index.php", $data); // navbar, sidebar, view

        $data['js'] = $this->load->view("{$_theme}/_js.php", $data, TRUE);
        $this->load->view("{$_theme}/footer", $data); // footer, js
    }
}
