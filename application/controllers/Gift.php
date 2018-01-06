<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Gift
 * @property dashboard_model $dashboard_model
 */

class Gift extends MY_Controller {

	public function index()
	{
        $data = array();
        $this->load->view('GiftView', $data);
	}

}
