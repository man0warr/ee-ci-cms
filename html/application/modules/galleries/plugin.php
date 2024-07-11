<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Galleries_plugin extends Plugin
{
    public $images = array();

    // supported prettyPhoto options [http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/documentation]
    private $supported_prettyphoto_options = array(
        'animation_speed',
        'slideshow', 'autoplay_slideshow',
        'opacity',
        'show_title',
        'allow_resize',
        'default_width', 'default_height',
        'counter_separator_label',
        'theme',
        'horizontal_padding',
        'hideflash', 'wmode',
        'autoplay',
        'modal',
        'deeplinking',
        'overlay_gallery',
        'keyboard_shortcuts',
        'ie6_fallback',
        'social_tools'
    );

    // supported fancyBox options [http://fancyapps.com/fancybox/#docs]
    private $supported_fancybox_options = array(
        'padding', 'margin',
        'width', 'height', 'minWidth', 'minHeight', 'maxHeight', 'maxWidth',
        'autoSize', 'autoHeight', 'autoWidth', 'autoResize', 'autoCenter',
        'fitToView', 'aspectRatio', 'topRatio', 'leftRatio', 'scrolling',
        'wrapCSS', 'arrows', 'closeBtn', 'closeClick', 'nextClick', 'mouseWheel',
        'autoPlay', 'playSpeed',
        'preload', 'modal', 'loop', 'scrollOutside',
        'index', 'type', 'href', 'content', 'title',
        'openEffect', 'closeEffect', 'nextEffect', 'prevEffect',
        'openSpeed', 'closeSpeed', 'nextSpeed', 'prevSpeed',
        'openEasing', 'closeEasing', 'nextEasing', 'prevEasing',
        'openOpacity', 'closeOpacity',
        'openMethod', 'closeMethod', 'nextMethod', 'prevMethod'
    );


    /*
     * Gallery
     *
     * Builds array of images to use for custom content
     *
     * @return array
     */
    public function gallery()
    {
        $this->_build_image_array();

        return $this->images;
    }

    // ------------------------------------------------------------------------

    /*
     * Cycle
     *
     * Outputs a slider of the gallery images using jQuery Cycle
     *
     * @return string
     */
    public function cycle()
    {
        $this->_build_image_array();
        $data = array();

        // return $images;
        $data['images'] = $this->images;
        $data['Gallery'] = $this->Gallery;

        $data = array_merge($data, $this->attributes());

        return $this->load->view('galleries/cycle', $data, TRUE);
    }

    // ------------------------------------------------------------------------

    /*
     * prettyPhoto
     *
     * Outputs gallery images using jQuery prettyPhoto
     *
     * @return string
     */
    public function prettyphoto()
    {
        $data = array();

        // generate a unique id so that multple fancyBox instances can exist on the same page
        $data['unique_id'] = uniqid('gallery-');

        $data['gallery_id'] = $this->attribute('gallery_id');
        $data['thumb_height'] = $this->attribute('thumb_height', '150px');
        $data['thumb_width'] = $this->attribute('thumb_width', '150px');

        // use the specified gallery id to build an array of images
        $this->_build_image_array();

        $data['images'] = $this->images;
        $data['Gallery'] = $this->Gallery;

        // add prettyPhoto libraries
        $this->template->add_package('prettyPhoto');

        // prettyPhoto options: filter the attribues leaving only supported options
        $prettyphoto_options = array();
        $prettyphoto_options = array_intersect_key($this->attributes(), array_flip($this->supported_prettyphoto_options));

        // convert the string representation of the options into their proper types
        $data['options'] = $this->convert_attribute_strings($prettyphoto_options);

        // default view
        return $this->load->view('galleries/prettyphoto', $data, TRUE);
    }

    // ------------------------------------------------------------------------

    /*
     * Fancybox
     *
     * Outputs gallery images using jQuery Fancybox
     *
     * @return string
     */
    public function fancybox()
    {
        $data = array();

        // generate a unique id so that multple fancyBox instances can exist on the same page
        $data['unique_id'] = uniqid('gallery-');

        $data['gallery_id'] = $this->attribute('gallery_id');
        $data['thumb_height'] = $this->attribute('thumb_height', '150px');
        $data['thumb_width'] = $this->attribute('thumb_width', '150px');

        // use the specified gallery id to build an array of images
        $this->_build_image_array();

        $data['images'] = $this->images;
        $data['Gallery'] = $this->Gallery;

        // add fancyBox libraries
        $this->template->add_package('fancyBox');

        // these flags enable the view to include the required helper libraries
        $data['button_helper'] = $this->attribute('buttons', false);
        $data['thumbnail_helper'] = $this->attribute('thumbs', false);

        // fancyBox options: filter the attribues leaving only supported options
        $fancybox_options = array();
        $fancybox_options = array_intersect_key($this->attributes(), array_flip($this->supported_fancybox_options));

        // convert the string representation of the options into their proper types
        $data['options'] = $this->convert_attribute_strings($fancybox_options);

        // fancyBox options: title helper
        if ($this->attribute('title_style') && $this->attribute('title_style') == 'none')
        {
            $data['options']['helpers']['title'] = null;
        }
        else
        {
            $data['options']['helpers']['title']['type'] = $this->attribute('title_style', 'float');
        }

        // fancyBox options: buttons helper
        if ($data['button_helper'])
        {
            $this->template->add_stylesheet('application/themes/admin/assets/js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5');
            $this->template->add_javascript('application/themes/admin/assets/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5');

            $data['options']['helpers']['buttons']['position'] = $this->attribute('buttons');
        }

        // fancyBox options: thumbs helper
        if ($data['thumbnail_helper'])
        {
            $this->template->add_stylesheet('application/themes/admin/assets/js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7');
            $this->template->add_javascript('application/themes/admin/assets/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7');

            $data['options']['helpers']['thumbs']['position'] = $this->attribute('thumbs');
            $data['options']['helpers']['thumbs']['width'] = 50;
            $data['options']['helpers']['thumbs']['height'] = 50;
        }

        // display methods
        if ($this->attribute('single_thumb'))
        {
            $data['single_images'] = array();
            foreach($this->images as $image)
            {
                $data['single_images'][] = array('href' => $image['image'], 'title' => $image['title']);
            }

            // represent the gallery with a single thumbnail
            return $this->load->view('galleries/fancybox-single', $data, TRUE);
        }
        else
        {
            // default view
            return $this->load->view('galleries/fancybox', $data, TRUE);
        }
    }


    // ------------------------------------------------------------------------

    /*
     * Build Image Array
     *
     * Queries and builds array of gallery images and thumbs
     *
     * @access private
     * @return void
     */
    private function _build_image_array()
    {
        $this->Gallery = $this->load->model('galleries_model');

        $this->Gallery->get_by_id($this->attribute('gallery_id'));

        if ( ! $this->Gallery->exists())
        {
            return;
        }

        $Images = $this->Gallery->images->where('hide', 0)->order_by('sort', 'ASC')->get();
        $count = 0;

        foreach($Images as $Image)
        {
            $count++;

            $this->images[] = array(
                'title'       => $Image->title,
                'text_1'      => $Image->text_1,
                'text_2'      => $Image->text_2,
            	'text_3'      => $Image->text_3,
                'image'       => $Image->filename,
                'alt'         => $Image->alt,
            	'description' => $Image->description,
                'url'         => $Image->url,
                'target'      => $Image->target,
                'count'       => $count
            );
        }
    }


    // ------------------------------------------------------------------------

    /*
     * Convert Attribute Strings
     *
     * Converts the string representation of the options into their proper types.
     *
     * @access private
     * @return array
     */
    private function convert_attribute_strings($attributes)
    {
        $options = array();

        foreach ($attributes as $option => $string_value)
        {
            if (is_numeric($string_value))
            {
                // integer
                $value = floatval($string_value);
            }
            else
            {
                if ($string_value === "null")
                {
                    // null
                    $value = null;
                }
                elseif ($string_value === "true")
                {
                    // bool
                    $value = true;
                }
                elseif ($string_value === "false")
                {
                    // bool
                    $value = false;
                }
                else
                {
                    // string
                    $value = $string_value;
                }
            }

            // store the converted attribute as an option
            $options[$option] = $value;
        }

        return $options;
    }

}