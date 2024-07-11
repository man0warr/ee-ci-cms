<?php

class Helper_plugin extends Plugin
{

    public function site_url()
    {
        return site_url($this->attribute('path', ''));
    }

    public function current_url()
    {
        return current_url();
    }

    public function uri_segment()
    {
        $CI = & get_instance();
        return $CI->uri->segment($this->attribute('segment'));
    }

    public function date()
    {
        if ( $this->attribute('date') != '' )
        {
            return date($this->attribute('format', 'm/d/Y'), strtotime($this->attribute('date')));
        }
        else
        {
            return date($this->attribute('format', 'm/d/Y'));
        }
    }

    public function str_replace()
    {
        $search = $this->attribute('search');
        $replace = $this->attribute('replace');
        $subject = $this->attribute('subject');

        return str_replace($search, $replace, $subject);
    }

    public function ellipsis($data)
    {
        // Recieve inherited data passed to plugin from parent plugin
        $CI = & get_instance();
        $CI->load->library('parser');
        $CI->load->helper('text');

        $content = $this->content();
        $parsed_content = $CI->parser->parse_string($content, $data, TRUE);
        return ellipsize($parsed_content, $this->attribute('length'));
    }

    public function image_thumb()
    {
        return image_thumb($this->attribute('image'), $this->attribute('width', 0), $this->attribute('height', 0), $this->attribute('crop', FALSE));
    }

    public function mailto_link()
    {
        if ($this->attribute('text') != '')
            $text = $this->attribute('text');
        else
            $text = "";

        if ($this->attribute('class') != '')
            $class = 'safe-mail '.$this->attribute('class');
        else
            $class =  'safe-mail';

        $e = $this->attribute('email');
        $e = explode("@",$e);
        $href = $e[0];
        $domain = $e[1];
        $safe_href = "";
        $safe_domain = "";

        for ( $i = 0; $i < strlen($href); $i++ )
        {
            $safe_href .= '&#' . ord($href[$i]) . ';';
        }

        for ( $i = 0; $i < strlen($domain); $i++ )
        {
            $safe_domain .= '&#' . ord($domain[$i]) . ';';
        }

        if(empty($text)) $text = $safe_href.'&#'.ord('@').';'.$safe_domain;

        $output = '<a class="'.$class.'" href="'.$safe_href.'" domain="'.$safe_domain.'">'.$text.'</a>';

        return $output;
    }

    public function mailto_link_script()
    {
        return '<script type="text/javascript">
                $(".safe-mail").each(function(){
                    $(this).attr("href","mailto:"+$(this).attr("href")+"@"+$(this).attr("domain"));
                })
                </script>';
    }

    public function mung_email()
    {
        $e = $this->attribute('email');
        $output = '';

        for ( $i = 0; $i < strlen($e); $i++ )
        {
            $output .= '&#' . ord($e[$i]) . ';';
        }
        return $output;
    }

}
