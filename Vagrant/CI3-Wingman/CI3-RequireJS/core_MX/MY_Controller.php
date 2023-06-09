<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter-HMVC
 *
 * @package    CodeIgniter-HMVC
 * @author     Martin <martin@click-ap.com>
 * @copyright  2023 Click-AP {@link https://www.click-ap.com }
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @version    GIT: $Id$
 * @since      Version 0.0.1
 */

class MY_Controller extends MX_Controller
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */
    protected $data = array();

    /**
	 * Set the default layout.
	 *
	 * @access public
	 * @var string
	 */
	#public $layout = 'default';

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        // To inherit directly the attributes of the parent class.
        parent::__construct();

        // This function returns the main CodeIgniter object.
        // Normally, to call any of the available CodeIgniter object or pre defined library classes then you need to declare.
        $CI =& get_instance();

        // Load global css here.
		$this->load_css(array(
			'css/normalize.css',
			'css/global.css'
		));

		// Load global js here.
		$this->load_js(array(
			'js/libs/modernizr.js'
		));

        // Copyright year calculation for the footer
        $begin = 2019;
        $end =  date("Y");
        $date = "$begin - $end";

        // Copyright
        $this->data['copyright'] = $date;
    }

    /**
	 * Set page title.
	 *
	 * @access protected
	 * @param  string $page_title
	 */
	protected function set_page_title($page_title)
	{
		$this->load->vars(array('page_title' => $page_title));
	}

    /**
	 * Set meta description.
	 *
	 * @access protected
	 * @param  string $meta_description
	 */
	protected function set_meta_description($meta_description)
	{
		$this->load->vars(array('meta_description' => $meta_description));
	}

    /**
	 * Load css styles.
	 *
	 * @access protected
	 * @param  array $css
	 */
	protected function load_css(array $css)
	{
		// If globals exist - combine the globals with local
		if ($og_css = $this->load->get_var('site_css')) {
			// merge
			$css = array_merge($og_css, $css);
			// get rid of duplicates
			$css = array_unique($css);
		}

		$this->load->vars('site_css', $css);
	}

	/**
	 * Load javascript files.
	 *
	 * @access protected
	 * @param  array $js
	 */
	protected function load_js(array $js)
	{
		// If globals exist - combine the globals with local
		if ($og_js = $this->load->get_var('site_js')) {
			// merge
			$js = array_merge($og_js, $js);
			// get rid of duplicates
			$js = array_unique($js);
		}

		$this->load->vars('site_js', $js);
	}

	/**
	 * Return json data.
	 *
	 * @access protected
	 * @param  array $data
	 * @link http://ellislab.com/codeigniter/user-guide/libraries/output.html
	 *
	 */
	protected function return_json($data)
	{
		// destroy layout
		unset($this->layout);

		// Set content type and output
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
}

// Backend controller
require_once(APPPATH.'core/Backend_Controller.php');

// Frontend controller
require_once(APPPATH.'core/Frontend_Controller.php');
