<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class UPI
 * @property dashboard_model $dashboard_model
 */

class Upi extends MY_Controller {

	public function index()
	{
        echo 'Nothing Here';
	}
	public function upiCallBackRes()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: */*');
        $this->load->model('dashboard_model');
        $post = $this->input->post();
        $get = $this->input->get();

        $details = array(
            'dumpTxt' => json_encode($post),
            'dumpTxtGet' => json_encode($get),
            'insertedDateTime' => date('Y-m-d H:i:s')
        );
        $this->dashboard_model->saveUpiDump($details);
        echo 'Saved!';
    }
}
