<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page404 extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    /**
     * Class Page404
     * @property locations_model $locations_model
     */
	public function index()
	{
	    $this->load->model('locations_model');
        if(strpos($_SERVER['REQUEST_URI'],'jukebox') && !strpos($_SERVER['REQUEST_URI'],'?page'))
        {
            $uriParts = explode('/',$_SERVER['REQUEST_URI']);
            $locName = str_replace('jukebox','',$uriParts[count($uriParts)-1]);
            $jukeId = $this->locations_model->getJukeboxId($locName);
            if(isset($jukeId['jukeboxSlug']) && $jukeId['jukeboxSlug'] != '')
            {
                redirect(base_url().'?page/taprom/'.$jukeId['jukeboxSlug']);
                /*if($this->mobile_detect->isMobile())
                {

                }
                else
                {
                    redirect(base_url());
                }*/
            }
            else
            {
                redirect(base_url());
            }
        }
        elseif(strpos($_SERVER['REQUEST_URI'],'events') && !strpos($_SERVER['REQUEST_URI'],'?page'))
        {
            $uriParts = explode('/',$_SERVER['REQUEST_URI']);
            $locName = str_replace('events','',$uriParts[count($uriParts)-1]);
            $locData = $this->locations_model->checkForValidLoc($locName);
            if( isset($locData) && myIsArray($locData) )
            {
                redirect(base_url().'?page/filter_events/'.$locName);
            }
            else
            {
                redirect(base_url());
            }
        }
		$this->load->view('Page404View');
	}
}
