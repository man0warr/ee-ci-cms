<?php

class Search_model extends CI_Model
{
    private $padding_characters = 10;


    public function __construct()
    {
        parent::__construct();

        $this->padding_characters = $this->settings->search_term_padding;
    }


    public function search_entries($search_term)
    {
        // Define character padding around search term in result
        $padding = $this->padding_characters;
        $double_padding = $padding * 2;

        // Generate parts of the query from an array of data fields containing text
        $data_fields = $this->get_data_fields();

        $field_list = $this->generate_field_list($data_fields);
        $where_clause = $this->generate_where_clause($data_fields, $search_term);

        // Define the query
        $query = $this->db->query("
            SELECT
                entry_title AS title,
                entry_slug AS slug,
                entry_modified_date AS modified_date,
                SUBSTRING(search_result, GREATEST((search_result_position - {$padding}), 1), LENGTH('{$search_term}') + {$double_padding}) AS snippet,
                ROUND ((LENGTH(search_result) - LENGTH(REPLACE(LOWER(search_result), LOWER('{$search_term}'), ''))) / LENGTH('{$search_term}')) AS occurances
            FROM (
                SELECT
                    e.title AS entry_title,
                    e.slug AS entry_slug,
                    e.modified_date AS entry_modified_date,
                    COALESCE({$field_list}) AS search_result,
                    LOCATE('{$search_term}', COALESCE({$field_list})) AS search_result_position
                FROM
                    entries_data ed
                    INNER JOIN entries e ON (ed.entry_id = e.id)
                WHERE
                    {$where_clause}
            ) AS t1
            ORDER BY
                occurances DESC
        ");

        if ($query->num_rows() < 1)
        {
           return false;
        }

        return $query->result();
    }


    private function get_data_fields()
    {
        // Define the query
        $this->db->select('cf.id AS field_id');
        $this->db->from('content_fields AS cf');
        $this->db->join('content_field_types AS cft', 'cf.content_field_type_id = cft.id', 'inner');
        $this->db->where('cft.datatype', 'text');

        // Run the query
        $query = $this->db->get();

        if ($query->num_rows() < 1)
        {
           return false;
        }

        return $query->result();
    }


    private function generate_field_list($data_fields)
    {
        $field_list = '';

        foreach ($data_fields as $data_field)
        {
            $field_list .= ($field_list) ? ', ' : '';
            $field_list .= "ed.field_id_{$data_field->field_id}";
        }

        return $field_list;
    }


    private function generate_where_clause($data_fields, $search_term)
    {
        $where_clause = '';

        foreach ($data_fields as $data_field)
        {
            $where_clause .= ($where_clause) ? ' OR ' : '';
            $where_clause .= "ed.field_id_{$data_field->field_id} LIKE '%{$search_term}%'";
        }

        return $where_clause;
    }

}