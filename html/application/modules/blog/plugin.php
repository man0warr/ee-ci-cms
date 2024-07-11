<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_plugin extends Plugin
{
    public $blog_posts = array();

    /*
     * Posts
     *
     * Builds an array of blog posts to use in a blog
     *
     * @return html
     */
    public function posts()
    {
        $CI =& get_instance();
        $CI->load->library('parser');

        // Get the posts from the blog module.
        $this->_build_posts_array();

        // Build an unordered list around the blog posts.
        $blog_post_html = '';
        $blog_post_html .= '<ul id="blog-posts">';

        foreach($this->blog_posts as $blog_post_data)
        {
            $blog_post_html .= '<li class="blog-post">';
            $blog_post_html .= '<time datetime="'.$blog_post_data['date_stamp'].'"></time>';
            $blog_post_html .= $CI->parser->parse_string($this->content(), $blog_post_data, true);
            $blog_post_html .= '</li>';
        }

        $blog_post_html .= '</ul>';

        return $blog_post_html;
    }

    // ------------------------------------------------------------------------

    /*
     * Archives
     *
     * Outputs archive links
     *
     * @return view
     */
    public function archives()
    {
        $data['archive_links'] = $this->_build_archives();

        return $this->load->view('archive_links', $data, TRUE);
    }

    // ------------------------------------------------------------------------

    /*
     * Build Posts Array
     *
     * Queries and builds array of blog posts
     *
     * @access private
     * @arguments sort, limit, date_format
     * @return void
     */
    private function _build_posts_array()
    {
        $this->load->helper('custom_functions');
        $this->Blog_posts_model = $this->load->model('blog_posts_model');

        // The 'sort' attribute allows the order of the posts to be specified. Defaults to most recent post first.
        $sort = ($this->attribute('sort') == 'asc') ? 'ASC' : 'DESC';

        // The 'limit' attribute allows the number of posts to be specified. Defaults to unlimited.
        if ($this->attribute('limit')) {
            $Blog_posts = $this->Blog_posts_model->order_by('posted_date', $sort)->limit($this->attribute('limit'))->get();
        } else {
            $Blog_posts = $this->Blog_posts_model->order_by('posted_date', $sort)->get();
        }

        // The 'date_format' attribute allows the date to be returned as a textual phrase, ie: 2 hours ago.
        $date_format = $this->attribute('date_format');

        $count = 0;

        foreach($Blog_posts as $blog_post)
        {
            $count++;

            $this->blog_posts[] = array(
                'post_title'    => $blog_post->title,
                'url'           => "/blog/post/view/{$blog_post->id}",
                'content'       => $blog_post->content,
                'by'            => $blog_post->posted_by,
                'date'          => ($date_format == 'x_ago') ? time_elapsed_string($blog_post->posted_date) : $blog_post->posted_date,
                'date_stamp'    => date('Y-m-d\TH:i:s.0P', strtotime($blog_post->posted_date)),
                'image'         => $blog_post->image_filename,
                'alt'           => $blog_post->image_alt,
                'comment_count' => $blog_post->comments->where('activated', 'YES')->where('approved', 'YES')->count(),
                'count'         => $count
            );
        }
    }

    // ------------------------------------------------------------------------

    /*
     * Build Archives Array
     *
     * Queries and builds an array of archives
     *
     * @access private
     * @arguments sort, limit, totals, month_order, year_order
     * @return array
     */
    private function _build_archives()
    {
        $archive_links = array();

        // The 'sort' attribute allows the archives to be built from a sorted collection of blog posts. Defaults to most recent post first.
        $sort = ($this->attribute('sort') == 'asc') ? 'ASC' : 'DESC';

        // The 'limit' attribute allows the archives to be built from a limited collection of blog posts. Defaults to unlimited.
        $limit = ($this->attribute('limit')) ? "LIMIT {$this->attribute('limit')}" : '';

        // The 'month_order', 'year_order' attributes allow the archive list to be ordered as desired. Defaults to most recent first.
        $month_order = ($this->attribute('month_order') == 'asc') ? 'ASC' : 'DESC';
        $year_order = ($this->attribute('year_order') == 'asc') ? 'ASC' : 'DESC';

        // The sub-query is a derived table. This allows any limit/sort attributes used to get archives to match the ones used to get posts.
        // The main query extracts and groups the month and year from the reamining blog posts.
        $query = $this->db->query("
            SELECT
                MONTHNAME(posted_date) as monthname,
                MONTH(posted_date) as month,
                YEAR(posted_date) as year,
                COUNT(*) AS total
            FROM
                (
                    SELECT *
                    FROM blog_posts
                    ORDER BY posted_date {$sort}
                    {$limit}
                ) AS filtered_blog_posts
            GROUP BY
                year, month
            ORDER BY
                year {$year_order}, month {$month_order}
        ");

        // The 'totals' attribute shows the number of blog posts in each archive title.
        foreach ($query->result() as $row)
        {
            $archive_links[] = array(
                'title' => ($this->attribute('totals') == 'true') ? "{$row->monthname} {$row->year} ({$row->total})" : "{$row->monthname} {$row->year}",
                'month' => $row->month,
                'year'  => $row->year
            );
        }

        return $archive_links;
    }

}
