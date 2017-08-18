<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dataformatinghtml_library
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
    }

    public function getGlobalStyleHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/GlobalstyleView', $data, true);
        return $htmlPage;
    }
    public function getDesktopStyleHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/DesktopstyleView', $data, true);
        return $htmlPage;
    }
    public function getMobileStyleHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/MobilestyleView', $data, true);
        return $htmlPage;
    }
    /*public function getAndroidStyleHtml($data)
    {
        $htmlPage = $this->CI->load->view('mobile/android/AndroidstyleView', $data, true);
        return $htmlPage;
    }
    public function getAndroidJsHtml($data)
    {
        $htmlPage = $this->CI->load->view('mobile/android/AndroidjsView', $data, true);
        return $htmlPage;
    }*/
    public function getIosStyleHtml($data)
    {
        $htmlPage = $this->CI->load->view('IosstyleView', $data, true);
        return $htmlPage;
    }
    public function getIosJsHtml($data)
    {
        $htmlPage = $this->CI->load->view('IosjsView', $data, true);
        return $htmlPage;
    }

    public function getGlobalJsHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/GlobaljsView', $data, true);
        return $htmlPage;
    }
    public function getDesktopJsHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/DesktopjsView', $data, true);
        return $htmlPage;
    }
    public function getMobileJsHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/MobilejsView', $data, true);
        return $htmlPage;
    }
    public function getHeaderHtml($data)
    {
        $htmlPage = $this->CI->load->view('HeaderView', $data, true);
        return $htmlPage;
    }
    public function getFooterHtml($data)
    {
        $htmlPage = $this->CI->load->view('FooterView', $data, true);
        return $htmlPage;
    }
    public function getWeeklyCalHtml($data)
    {
        $this->CI->load->model('dashboard_model');

        $oldDates = array();
        $weekEvents = $this->CI->dashboard_model->getWeeklyEvents();
        // $data['weekEvents']
        foreach($weekEvents as $key => $row)
        {
            $oldDates[] = $row['eventDate'];
        }
        $begin = new DateTime( date('Y-m-d') );
        $end = new DateTime( date('Y-m-d', strtotime('+1 week')) );
        $end = $end->modify( '+1 day' );

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);

        foreach($daterange as $date){
            if(!myInArray($date->format('Y-m-d'),$oldDates))
            {
                $indx = count($weekEvents);
                $weekEvents[$indx]['eventDate'] = $date->format('Y-m-d');
                $weekEvents[$indx]['error'] = 'No Events';
            }
        }
        $data['weekEvents'] = $weekEvents;
        $htmlPage = $this->CI->load->view('desktop/WeeklyCalView', $data, true);
        return $htmlPage;
    }
    public function getFnbSideHtml($data)
    {
        $this->CI->load->model('dashboard_model');
        $this->CI->load->model('locations_model');

        $data['mainLocs'] = $this->CI->locations_model->getAllLocations();
        $data['fnbItems'] = $this->CI->dashboard_model->getAllActiveFnB();
        $htmlPage = $this->CI->load->view('desktop/FnbSideView', $data, true);
        return $htmlPage;
    }
    public function getDeskHeaderHtml($data)
    {
        $this->CI->load->model('locations_model');

        $data['mainLocs'] = $this->CI->locations_model->getAllLocations();
        $htmlPage = $this->CI->load->view('desktop/DeskHeaderView', $data, true);
        return $htmlPage;
    }
}
/* End of file */