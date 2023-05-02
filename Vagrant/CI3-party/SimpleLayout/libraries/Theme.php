<?php

class Theme
{

    function __construct($layout = 'highlight', $theme = 'AdminLTE')
    {
        //debugBreak();
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
        $data['content'] = $this->obj->load->view($this->theme . '/' . $view, $data, TRUE);
        $this->obj->load->view($this->theme . '/' . $this->layout, $data);
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
