<?php

class Template_plugin extends Plugin
{
    public function metadata()
    {
        return $this->template->metadata();
    }

    public function stylesheets()
    {
        return $this->template->stylesheets();
    }

    public function javascripts()
    {
        return $this->template->javascripts();
    }

    public function page_head()
    {
        return $this->template->page_head();
    }

    public function page_foot()
    {
        return $this->template->page_foot();
    }

    public function analytics()
    {
        return $this->template->analytics();
    }

    public function head()
    {
        return $this->template->head();
    }

    public function foot()
    {
        return $this->template->foot();
    }

    public function add_stylesheet()
    {
        $this->template->add_stylesheet($this->attribute('file'));
    }

    public function add_javascript()
    {
        $this->template->add_javascript($this->attribute('file'), $this->attribute('foot', FALSE));
    }

    public function xml_output()
    {
        return xml_output();
    }
}
