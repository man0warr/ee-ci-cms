<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Map_plugin extends Plugin
{

    /*
     * Map
     *
     * Outputs a google map in an iFrame.
     * https://developers.google.com/maps/documentation/embed/guide
     *
     * @return void
     */
    public function googlemaps()
    {
        $data = array();

        /* Get the address and define default address. */
        $address = $this->attribute('address', 'Texas, USA');

        /* Define the URL parameters. */
        $mode = 'place';
        $api_key = 'AIzaSyArIaSX56fdGsa87kxZsApeVWXykAh_v2Q';
        $q = urlencode($address);
        $zoom = $this->attribute('address') ? $this->attribute('zoom', 15) : 4;
        $maptype = $this->attribute('maptype', 'roadmap');

        /* Define the iframe attributes. */
        $data['id'] = $this->attribute('id', '');
        $data['class'] = $this->attribute('class', '');
        $data['width'] = $this->attribute('width', '450');
        $data['height'] = $this->attribute('height', '250');
        $data['src'] = "https://www.google.com/maps/embed/v1/{$mode}?key={$api_key}&q={$q}&zoom={$zoom}&maptype={$maptype}";

        /* Return an iframe populated with the parameters and attributes. */
        return $this->load->view('googlemaps', $data, TRUE);
    }

}
