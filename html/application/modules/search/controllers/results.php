<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Results extends Public_Controller
{

    public function index()
    {
        $data = array();

        // Ensure a search term is submitted
        if ( ! isset($_GET['s']))
        {
            redirect( site_url() );
        }

        // Sanitize the search term
        $data['search_term'] = $search_term = filter_var($_GET['s'], FILTER_SANITIZE_SPECIAL_CHARS);

        // Get all the data fields that contain text
        $this->load->model('search_model');
        $Search_results = $this->search_model->search_entries($search_term);

        $data['results'] = array();

        if ($Search_results) {
            foreach($Search_results as $Search_result) {

                $data['results'][] = array(
                    'title'         => $Search_result->title,
                    'snippet'       => $this->parse_content($search_term, $Search_result->snippet),
                    'url'           => site_url($Search_result->slug),
                    'occurances'    => ($Search_result->occurances == 1) ? "<strong>{$Search_result->occurances}</strong> occurance" : "<strong>{$Search_result->occurances}</strong> occurances",
                    'modified_date' => date('F j, Y', strtotime($Search_result->modified_date))
                );
            }
        }

        // Load the search results view
        $this->template->view('resultlist', $data);
    }


    private function parse_content($search_term, $entry_html)
    {
        // Strip Lex tags and HTML tags
        $entry_html = preg_replace("/{{.*?}}/", "", $entry_html);
        $entry_text = strip_tags($entry_html);

        // Find the position of the $search_term in the $entry_text
        $positionInText = stripos($entry_text, $search_term);

        if ($positionInText === false)
        {
            return false;
        }

        // Highlight the $search_term in the $entry_text
        $highlighted_search_term = "<strong class='search-term'>" . substr($entry_text, $positionInText, strlen($search_term)) . "</strong>";
        $search_result = trim(str_ireplace($search_term, $highlighted_search_term, $entry_text));
        $formatted_search_result = "...{$search_result}...";

        return $formatted_search_result;
    }

}
