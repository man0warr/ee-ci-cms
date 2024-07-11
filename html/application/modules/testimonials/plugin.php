<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonials_plugin extends Plugin
{
    public $testimonials = array();

    /*
     * Testimonials
     *
     * Builds an array of testimonials
     *
     * @return array
     */
    public function testimonials()
    {
        $this->_build_testimonials_array();

        return $this->testimonials;
    }

    // ------------------------------------------------------------------------

    /*
     * Initialize
     *
     * Queries and builds array of testimonials
     *
     * @access private
     * @return void
     */
    private function _build_testimonials_array()
    {
        $this->Testimonials_model = $this->load->model('testimonials_model');

        // If a limit is posted, apply it to the query.
        if ($this->attribute('limit')) {
            $Testimonials = $this->Testimonials_model->order_by('sort', 'ASC')->limit($this->attribute('limit'))->get();
        } else {
            $Testimonials = $this->Testimonials_model->order_by('sort', 'ASC')->get();
        }

        $count = 0;

        foreach($Testimonials as $testimonial)
        {
            $count++;

            $this->testimonials[] = array(
                'by'        => $testimonial->by,
                'quotation' => $testimonial->quotation,
                'count'     => $count
            );
        }
    }

}
