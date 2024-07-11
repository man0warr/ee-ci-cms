<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_plugin extends Plugin
{

    public function site_name()
    {
        $CI =& get_instance();
        return $CI->settings->site_name;
    }

    public function notification_email()
    {
        $CI = & get_instance();

        if (ENVIRONMENT != 'production' && $CI->settings->use_developers_email)
        {
        	return $CI->settings->developers_email;
        }
        else
        {
        	return $CI->settings->notification_email;
        }
    }

    public function phone()
    {
        $CI = & get_instance();
        return $CI->settings->phone;
    }

    public function fax()
    {
        $CI = & get_instance();
        return $CI->settings->fax;
    }

    public function address()
    {
        $CI = & get_instance();

        if ($this->attribute('singleline')) {

            // replace any new lines with commas
            return str_replace("\n", ", ", $CI->settings->address);

        } else {

            // replace any new lines with HTML <br>
            return nl2br($CI->settings->address);
        }
    }

}
