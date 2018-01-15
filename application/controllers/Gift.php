<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Gift
 * @property dashboard_model $dashboard_model
 * @property locations_model $locations_model
 */

class Gift extends MY_Controller {

	public function index()
	{
	    /*redirect(base_url().PAGE_404);
	    die();*/
        $data = array();
        $data['locData'] = $this->locations_model->getAllLocations();
        $this->load->view('GiftView', $data);
	}

}
