<?php

class Layout
{

    function __construct($layout = 'layout2', $theme = 'AdminLTE')
    {
        if (is_array($layout)) {
            $this->layout = $layout['layout'];
            $this->theme = $layout['theme'];
            #$this->theme = $this->config->item('theme');
        } else {
            $this->layout = $layout;
            $this->theme = $theme;
        }
        $this->obj = &get_instance();
        $this->data = array();
    }

    function set_data($key, $value)
    {
        $this->data[$key] = $value;
    }

    function view($view, $data = array())
    {
        $data = array_merge($this->data, $data);
        #$data['content'] = $this->obj->load->view($this->theme . '/' . $view, $data, TRUE);
        $data['content'] = $this->obj->load->view($view, $data, TRUE);
        $this->obj->load->view($this->theme . '/' . $this->layout, $data);
    }

    /**
	 * This function used to load views
	 * @param {string} $viewName : This is view name
	 * @param {mixed} $headerInfo : This is array of header information
	 * @param {mixed} $pageInfo : This is array of page information
	 * @param {mixed} $footerInfo : This is array of footer information
	 * @return {null} $result : null
	 */
	function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL)
	{
		$this->obj->load->view($this->theme . '/includes/header', $headerInfo);
		$this->obj->load->view($viewName, $pageInfo);
		$this->obj->load->view($this->theme . '/includes/footer', $footerInfo);
	}

    function set_layout($layout)
    {
        $this->layout = $layout;
    }

    function get_theme()
    {
        return $this->theme;
    }
}
