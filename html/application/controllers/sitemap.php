<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Sitemap extends Public_Controller
{
    public function index()
    {
		$output  = '<?xml version="1.0" encoding="UTF-8"?>';
		$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

		$this->load->model('content/entries_model');
		$Entries = $this->entries_model->where('status', 'published')->where('slug !=', '')->order_by('id', 'ASC')->get();

		foreach ($Entries as $Entry) {
			$output .= '<url>';
			$output .= '<loc>' . site_url($Entry->slug) . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>1.0</priority>';
			$output .= '</url>';
		}

		$output .= '</urlset>';

		$this->output->set_content_type('application/xml');
		$this->output->set_output($output);
    }

}
