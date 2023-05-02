<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

#require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Customers (CustomersController)
 * Customer Class to control all user related operations.
 * @author : Rajesh Gupta
 * @version : 1.1
 * @since : 15 November 2019
 */
//class Customers extends BaseController
class Customers extends MY_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('smarty_acl');
        $this->load->model('customer_model');
        #$this->isLoggedIn();
        $this->logged_in();
        $this->smarty_acl->authorized();
    }

    protected function logged_in()
    {
        if (!$this->smarty_acl->logged_in()) {
            return redirect('admin/login');
        }
    }

    /**
     * This function used to load the first screen of the Customer
     */
    public function index()
    {
        //$this->global['pageTitle'] = 'WorldTrack GPS : Dashboard';

        #$this->loadViews("back_end/dashboard", $this->global, NULL , NULL);
        $this->layout->loadViews('dashboard', NULL, NULL , NULL);
        #$this->load->view('dashboard', $data);
    }

    /**
     * This function is used to load the Customers list
     */
    function customerListing()
    {

        //$this->global['searchBody'] = 'Yes';

        $data['customerRecords'] = $this->customer_model->customerListing();

        //$this->global['pageTitle'] = 'WorldTrack GPS : Customer Listing';

        //$this->loadViews("back_end/customers/customers", $this->global, $data, NULL);
        //$this->layout->loadViews('customers', NULL, $data, NULL);

        # 符合 Layout 的 load view.
        $this->layout->set_layout('layout');
        $this->layout->view('customers', $data);
    }

}
