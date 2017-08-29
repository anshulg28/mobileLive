<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Main
 * @property cron_model $cron_model
 * @property dashboard_model $dashboard_model
 * @property locations_model $locations_model
 * @property login_model $login_model
 * @property users_model $users_model
 * @property mugclub_model $mugclub_model
*/

class Main extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('cron_model');
        $this->load->model('dashboard_model');
        $this->load->model('locations_model');
        $this->load->model('mugclub_model');
        $this->load->model('users_model');
    }

    public function index()
    {
        $data = array();
        //Twitter share for twitterbot
        if (stripos($_SERVER['HTTP_USER_AGENT'], 'twitterbot') !== false) {
            if (isStringSet($_SERVER['QUERY_STRING'])) {
                $query = explode('/', $_SERVER['QUERY_STRING']);
                if (isset($query[1]) && $query[1] == 'events')
                {
                    if (isset($query[2]))
                    {
                        if (strpos($query[2], 'EV-') != -1 && isset($query[3]))
                        {
                            $event = explode('-', $query[2]);
                            $eventData = $this->dashboard_model->getFullEventInfoById($event[1]);
                            if (!myIsArray($eventData))
                            {
                                $eventData = $this->dashboard_model->getCompEventInfoById($event[1]);
                            }
                            //$eventAtt = $this->dashboard_model->getEventAttById($event[1]);
                            $data['meta']['title'] = $eventData[0]['eventName'];
                            $d = date_create($eventData[0]['eventDate']);
                            $st = date_create($eventData[0]['startTime']);
                            $et = date_create($eventData[0]['endTime']);
                            $forDescription = date_format($d, DATE_FORMAT_SHARE) . ", " . date_format($st, 'g:ia');
                            if ($eventData[0]['isEventEverywhere'] == '1') {
                                $forDescription .= " @ All Taprooms";
                            } else {
                                $forDescription .= " @ " . $eventData[0]['locName'] . " Taproom";
                            }
                            $truncated_RestaurantName = (strlen(strip_tags($eventData[0]['eventDescription'])) > 140) ? substr(strip_tags($eventData[0]['eventDescription']), 0, 140) . '..' : strip_tags($eventData[0]['eventDescription']);
                            $data['meta']['description'] = $forDescription;
                            $data['meta']['link'] = $eventData[0]['eventShareLink'];
                            $imgLink = base_url() . EVENT_PATH_THUMB . $eventData[0]['filename'];
                            if ($eventData[0]['hasShareImg'] == ACTIVE) {
                                $shareImg = $this->dashboard_model->getShareImg($eventData[0]['eventId']);
                                if (isset($shareImg) && myIsArray($shareImg)) {
                                    $imgLink = base_url() . EVENT_PATH_THUMB . $shareImg['filename'];
                                }
                            }
                            $data['meta']['img'] = $imgLink;
                        }
                        else
                        {
                            //$event = explode('-',$query[2]);
                            $eventData = $this->dashboard_model->getFullEventInfoBySlug($query[2]);
                            if (!myIsArray($eventData)) {
                                $eventData = $this->dashboard_model->getCompEventInfoBySlug($query[2]);
                            }
                            //$eventAtt = $this->dashboard_model->getEventAttById($event[1]);
                            $data['meta']['title'] = $eventData[0]['eventName'];
                            $d = date_create($eventData[0]['eventDate']);
                            $st = date_create($eventData[0]['startTime']);
                            $et = date_create($eventData[0]['endTime']);
                            $forDescription = date_format($d, DATE_FORMAT_SHARE) . ", " . date_format($st, 'g:ia');
                            if ($eventData[0]['isEventEverywhere'] == '1') {
                                $forDescription .= " @ All Taprooms";
                            } else {
                                $forDescription .= " @ " . $eventData[0]['locName'] . " Taproom";
                            }
                            $truncated_RestaurantName = (strlen(strip_tags($eventData[0]['eventDescription'])) > 140) ? substr(strip_tags($eventData[0]['eventDescription']), 0, 140) . '..' : strip_tags($eventData[0]['eventDescription']);
                            $data['meta']['description'] = $forDescription;
                            $data['meta']['link'] = $eventData[0]['eventShareLink'];
                            $imgLink = base_url() . EVENT_PATH_THUMB . $eventData[0]['filename'];
                            if ($eventData[0]['hasShareImg'] == ACTIVE) {
                                $shareImg = $this->dashboard_model->getShareImg($eventData[0]['eventId']);
                                if (isset($shareImg) && myIsArray($shareImg)) {
                                    $imgLink = base_url() . EVENT_PATH_THUMB . $shareImg['filename'];
                                }
                            }
                            $data['meta']['img'] = $imgLink;
                        }
                    }
                    else
                    {
                        $metaTags = $this->dashboard_model->getRecentMeta();
                        if (isset($metaTags) && myIsArray($metaTags)) {
                            $data['meta1']['title'] = $metaTags['metaTitle'];
                            $data['meta1']['description'] = $metaTags['metaDescription'];
                            $data['meta1']['img'] = base_url() . 'asset/images/thumb/' . $metaTags['metaImg'];
                        } else {
                            $data['meta1']['title'] = 'Ways to kill your time';
                            $data['meta1']['description'] = "Browse through the fun stuff that's going down at our taprooms.";
                            $data['meta1']['img'] = base_url() . 'asset/images/thumb/doolally-app-icon.png';
                        }
                        $data['meta1']['link'] = base_url();
                    }
                } elseif (isset($query[1]) && $query[1] == 'fnbshare') {
                    if (isset($query[2])) {
                        $fnb = explode('-', $query[2]);
                        $fnbData = $this->dashboard_model->getFnBById($fnb[1]);
                        $fnbAtt = $this->dashboard_model->getFnbAttById($fnb[1]);
                        $data['meta']['title'] = $fnbData[0]['itemName'];
                        if (isset($fnbData[0]['itemHeadline'])) {
                            $truncated_RestaurantName = $fnbData[0]['itemHeadline'];
                        } else {
                            $truncated_RestaurantName = $fnbData[0]['itemDescription'];
                        }
                        $data['meta']['description'] = $truncated_RestaurantName;
                        $data['meta']['link'] = base_url() . '?page/fnbshare/fnb-' . $fnbData[0]['fnbId'];
                        if ($fnbData[0]['itemType'] == '1') {
                            $data['meta']['img'] = base_url() . FOOD_PATH_THUMB . $fnbAtt[0]['filename'];
                        } else {
                            $data['meta']['img'] = base_url() . BEVERAGE_PATH_THUMB . $fnbAtt[0]['filename'];
                        }

                    }
                }
            }
            $this->load->view('ForTwitterView', $data);
        } //checking if device is mobile
        elseif ($this->mobile_detect->isMobile()) {
            $get = $this->input->get();

            //EventsHigh Payment handle
            if (isset($get['bookingid']) && isset($get['eid'])) {
                if (isset($get['status']) && $get['status'] == 'success'
                    && isset($get['userName']) && isset($get['userEmail']) && isset($get['userMobile'])
                    && isset($get['nTickets'])
                ) {
                    $ehArray = array(
                        'bookingid' => $get['bookingid'],
                        'userName' => urldecode($get['userName']),
                        'userEmail' => $get['userEmail'],
                        'userMobile' => $get['userMobile'],
                        'nTickets' => $get['nTickets']
                    );
                    $this->thankYou1($get['eid'], $ehArray);
                }
            }

            if(isset($get['event']) && isStringSet($get['event']) && isset($get['hash']) && isStringSet($get['hash']))
            {
                if(hash_compare(encrypt_data('EV-'.$get['event']),$get['hash']))
                {
                    if(isset($get['status']) && $get['status'] == 'success' && isset($get['payment_id']))
                    {
                        $this->thankYou($get['event'],$get['payment_id']);
                    }
                }
            }
            if(isSessionVariableSet($this->instaMojoStatus) && $this->instaMojoStatus == '1')
            {
                $this->generalfunction_library->setSessionVariable('instaMojoStatus','0');
                $this->instaMojoStatus = '0';
                $data['MojoStatus'] = 1;
            }
            elseif(isSessionVariableSet($this->instaMojoStatus) && $this->instaMojoStatus == '2')
            {
                $this->generalfunction_library->setSessionVariable('instaMojoStatus','0');
                $this->instaMojoStatus = '0';
                $data['MojoStatus'] = 2;
            }
            else
            {
                $data['MojoStatus'] = 0;
            }

            //EventsHigh payment session
            if (isSessionVariableSet($this->paymentStatus) && $this->paymentStatus == '1') {
                $this->generalfunction_library->setSessionVariable('paymentStatus', '0');
                $this->paymentStatus = '0';
                $data['PaymentStatus'] = 1;
            } elseif (isSessionVariableSet($this->paymentStatus) && $this->paymentStatus == '2') {
                $this->generalfunction_library->setSessionVariable('paymentStatus', '0');
                $this->paymentStatus = '0';
                $data['PaymentStatus'] = 2;
            } else {
                $data['PaymentStatus'] = 0;
            }

            $data['mobileStyle'] = $this->dataformatinghtml_library->getMobileStyleHtml($data);
            $data['mobileJs'] = $this->dataformatinghtml_library->getMobileJsHtml($data);

            $myFeeds = $this->cron_model->getAllSortedFeeds();

            if (isset($myFeeds) && myIsMultiArray($myFeeds)) {
                $data['myFeeds'] = $myFeeds;// json_decode($myFeeds[0]['feedText'], true);
            }

            $data['fnbItems'] = $this->dashboard_model->getAllActiveFnB();

            //$data['beerCount'] = $this->dashboard_model->getBeersCount();

            $data['mainLocs'] = $this->locations_model->getAllLocations();

            $data['weekEvents'] = $this->dashboard_model->getWeeklyEvents();

            $events = $this->dashboard_model->getAllApprovedEvents();
            usort($events,
                function ($a, $b) {
                    $ts_a = strtotime($a['eventDate']);
                    $ts_b = strtotime($b['eventDate']);

                    return $ts_a > $ts_b;
                }
            );

            $data['eventDetails'] = $events;

            if (isStringSet($_SERVER['QUERY_STRING'])) {
                $query = explode('/', $_SERVER['QUERY_STRING']);
                if (isset($query[1]) && $query[1] == 'events') {
                    if (isset($query[2])) {
                        if (strpos($query[2], 'EV-') != -1 && isset($query[3])) {
                            $event = explode('-', $query[2]);
                            $eventData = $this->dashboard_model->getFullEventInfoById($event[1]);
                            if (!myIsArray($eventData)) {
                                $eventData = $this->dashboard_model->getCompEventInfoBySlug($query[2]);
                            }
                            //$eventAtt = $this->dashboard_model->getEventAttById($event[1]);
                            $data['meta']['title'] = $eventData[0]['eventName'];
                            $d = date_create($eventData[0]['eventDate']);
                            $st = date_create($eventData[0]['startTime']);
                            $et = date_create($eventData[0]['endTime']);
                            $forDescription = date_format($d, DATE_FORMAT_SHARE) . ", " . date_format($st, 'g:ia');
                            if ($eventData[0]['isEventEverywhere'] == '1') {
                                $forDescription .= " @ All Taprooms";
                            } else {
                                $forDescription .= " @ " . $eventData[0]['locName'] . " Taproom";
                            }
                            $truncated_RestaurantName = (strlen(strip_tags($eventData[0]['eventDescription'])) > 140) ? substr(strip_tags($eventData[0]['eventDescription']), 0, 140) . '..' : strip_tags($eventData[0]['eventDescription']);
                            $data['meta']['description'] = $forDescription;
                            $data['meta']['link'] = $eventData[0]['eventShareLink'];
                            $imgLink = base_url() . EVENT_PATH_THUMB . $eventData[0]['filename'];
                            if ($eventData[0]['hasShareImg'] == ACTIVE) {
                                $shareImg = $this->dashboard_model->getShareImg($eventData[0]['eventId']);
                                if (isset($shareImg) && myIsArray($shareImg)) {
                                    $imgLink = base_url() . EVENT_PATH_THUMB . $shareImg['filename'];
                                }
                            }
                            $data['meta']['img'] = $imgLink;
                        }
                        else
                        {
                            //$event = explode('-',$query[2]);
                            $eventData = $this->dashboard_model->getFullEventInfoBySlug($query[2]);
                            if(!myIsArray($eventData))
                            {
                                $eventData = $this->dashboard_model->getCompEventInfoBySlug($query[2]);
                            }
                            //$eventAtt = $this->dashboard_model->getEventAttById($event[1]);
                            $data['meta']['title'] = $eventData[0]['eventName'];
                            $d = date_create($eventData[0]['eventDate']);
                            $st = date_create($eventData[0]['startTime']);
                            $et = date_create($eventData[0]['endTime']);
                            $forDescription = date_format($d, DATE_FORMAT_SHARE) . ", " . date_format($st, 'g:ia');
                            if ($eventData[0]['isEventEverywhere'] == '1') {
                                $forDescription .= " @ All Taprooms";
                            } else {
                                $forDescription .= " @ " . $eventData[0]['locName'] . " Taproom";
                            }
                            $truncated_RestaurantName = (strlen(strip_tags($eventData[0]['eventDescription'])) > 140) ? substr(strip_tags($eventData[0]['eventDescription']), 0, 140) . '..' : strip_tags($eventData[0]['eventDescription']);
                            $data['meta']['description'] = $forDescription;
                            $data['meta']['link'] = $eventData[0]['eventShareLink'];
                            $imgLink = base_url() . EVENT_PATH_THUMB . $eventData[0]['filename'];
                            if ($eventData[0]['hasShareImg'] == ACTIVE) {
                                $shareImg = $this->dashboard_model->getShareImg($eventData[0]['eventId']);
                                if (isset($shareImg) && myIsArray($shareImg)) {
                                    $imgLink = base_url() . EVENT_PATH_THUMB . $shareImg['filename'];
                                }
                            }
                            $data['meta']['img'] = $imgLink;
                        }
                    } else {
                        $metaTags = $this->dashboard_model->getRecentMeta();
                        if (isset($metaTags) && myIsArray($metaTags)) {
                            $data['meta1']['title'] = $metaTags['metaTitle'];
                            $data['meta1']['description'] = $metaTags['metaDescription'];
                            $data['meta1']['img'] = base_url() . 'asset/images/thumb/' . $metaTags['metaImg'];
                        } else {
                            $data['meta1']['title'] = 'Ways to kill your time';
                            $data['meta1']['description'] = "Browse through the fun stuff that's going down at our taprooms.";
                            $data['meta1']['img'] = base_url() . 'asset/images/thumb/doolally-app-icon.png';
                        }
                        $data['meta1']['link'] = base_url();
                    }
                } elseif (isset($query[1]) && $query[1] == 'fnbshare') {
                    if (isset($query[2])) {
                        $fnb = explode('-', $query[2]);
                        $fnbData = $this->dashboard_model->getFnBById($fnb[1]);
                        $fnbAtt = $this->dashboard_model->getFnbAttById($fnb[1]);
                        $data['fnbShareId'] = $fnbData[0]['fnbId'];
                        $data['meta']['title'] = $fnbData[0]['itemName'];
                        if (isset($fnbData[0]['itemHeadline'])) {
                            $truncated_RestaurantName = $fnbData[0]['itemHeadline'];
                        } else {
                            $truncated_RestaurantName = $fnbData[0]['itemDescription'];
                        }
                        $data['meta']['description'] = $truncated_RestaurantName;
                        $data['meta']['link'] = base_url() . '?page/fnbshare/fnb-' . $fnbData[0]['fnbId'];
                        if ($fnbData[0]['itemType'] == '1') {
                            $data['meta']['img'] = base_url() . FOOD_PATH_THUMB . $fnbAtt[0]['filename'];
                        } else {
                            $data['meta']['img'] = base_url() . BEVERAGE_PATH_NORMAL . $fnbAtt[0]['filename'];
                        }

                    }
                }
            }

            $data['currentUrl'] = $_SERVER['REQUEST_URI'];
            $data['iosStyle'] = $this->dataformatinghtml_library->getIosStyleHtml($data);
            $data['iosJs'] = $this->dataformatinghtml_library->getIosJsHtml($data);
            $this->load->view('MobileHomeView', $data);
        }
        else
        {
            $get = $this->input->get();

            //EventsHigh Payment handle
            if (isset($get['bookingid']) && isset($get['eid'])) {
                if (isset($get['status']) && $get['status'] == 'success'
                    && isset($get['userName']) && isset($get['userEmail']) && isset($get['userMobile'])
                    && isset($get['nTickets'])
                ) {
                    $ehArray = array(
                        'bookingid' => $get['bookingid'],
                        'userName' => urldecode($get['userName']),
                        'userEmail' => $get['userEmail'],
                        'userMobile' => $get['userMobile'],
                        'nTickets' => $get['nTickets']
                    );
                    $this->thankYou1($get['eid'], $ehArray);
                }
            }
            if(isset($get['event']) && isStringSet($get['event']) && isset($get['hash']) && isStringSet($get['hash']))
            {
                if(hash_compare(encrypt_data('EV-'.$get['event']),$get['hash']))
                {
                    if(isset($get['status']) && $get['status'] == 'success' && isset($get['payment_id']))
                    {
                        $this->thankYou($get['event'],$get['payment_id']);
                    }
                }
            }
            if(isSessionVariableSet($this->instaMojoStatus) && $this->instaMojoStatus == '1')
            {
                $this->generalfunction_library->setSessionVariable('instaMojoStatus','0');
                $this->instaMojoStatus = '0';
                $data['MojoStatus'] = 1;
            }
            elseif(isSessionVariableSet($this->instaMojoStatus) && $this->instaMojoStatus == '2')
            {
                $this->generalfunction_library->setSessionVariable('instaMojoStatus','0');
                $this->instaMojoStatus = '0';
                $data['MojoStatus'] = 2;
            }
            else
            {
                $data['MojoStatus'] = 0;
            }

            //EventsHigh payment session
            if (isSessionVariableSet($this->paymentStatus) && $this->paymentStatus == '1') {
                $this->generalfunction_library->setSessionVariable('paymentStatus', '0');
                $this->paymentStatus = '0';
                $data['PaymentStatus'] = 1;
            } elseif (isSessionVariableSet($this->paymentStatus) && $this->paymentStatus == '2') {
                $this->generalfunction_library->setSessionVariable('paymentStatus', '0');
                $this->paymentStatus = '0';
                $data['PaymentStatus'] = 2;
            } else {
                $data['PaymentStatus'] = 0;
            }
            if (isStringSet($_SERVER['QUERY_STRING'])) {
                $query = explode('/', $_SERVER['QUERY_STRING']);

                if (isset($query[1])) {
                    $data['pageName'] = $query[1];
                    $data['pageUrl'] = explode('?page/', $_SERVER['REQUEST_URI'])[1];
                    if ($query[1] == 'events') {
                        if (isset($query[2]) && isStringSet($query[2])) {
                            if (strpos($query[2], 'EV-') != -1 && isset($query[3]))
                            {
                                $event = explode('-', $query[2]);
                                $eventData = $this->dashboard_model->getFullEventInfoById($event[1]);
                                if (!myIsArray($eventData)) {
                                    $eventData = $this->dashboard_model->getCompEventInfoById($event[1]);
                                }
                                //$eventAtt = $this->dashboard_model->getEventAttById($event[1]);
                                $data['meta']['title'] = $eventData[0]['eventName'];
                                $d = date_create($eventData[0]['eventDate']);
                                $st = date_create($eventData[0]['startTime']);
                                $et = date_create($eventData[0]['endTime']);
                                $forDescription = date_format($d, DATE_FORMAT_SHARE) . ", " . date_format($st, 'g:ia');
                                if ($eventData[0]['isEventEverywhere'] == '1') {
                                    $forDescription .= " @ All Taprooms";
                                } else {
                                    $forDescription .= " @ " . $eventData[0]['locName'] . " Taproom";
                                }
                                $truncated_RestaurantName = (strlen(strip_tags($eventData[0]['eventDescription'])) > 140) ? substr(strip_tags($eventData[0]['eventDescription']), 0, 140) . '..' : strip_tags($eventData[0]['eventDescription']);
                                $data['meta']['description'] = $forDescription;
                                $data['meta']['link'] = $eventData[0]['eventShareLink'];
                                $imgLink = base_url() . EVENT_PATH_THUMB . $eventData[0]['filename'];
                                if ($eventData[0]['hasShareImg'] == ACTIVE) {
                                    $shareImg = $this->dashboard_model->getShareImg($eventData[0]['eventId']);
                                    if (isset($shareImg) && myIsArray($shareImg)) {
                                        $imgLink = base_url() . EVENT_PATH_THUMB . $shareImg['filename'];
                                    }
                                }
                                $data['meta']['img'] = $imgLink;
                            }
                            else
                            {
                                //$event = explode('-',$query[2]);
                                $eventData = $this->dashboard_model->getFullEventInfoBySlug($query[2]);
                                if(!myIsArray($eventData))
                                {
                                    $eventData = $this->dashboard_model->getCompEventInfoBySlug($query[2]);
                                }
                                //$eventAtt = $this->dashboard_model->getEventAttById($event[1]);
                                $data['meta']['title'] = $eventData[0]['eventName'];
                                $d = date_create($eventData[0]['eventDate']);
                                $st = date_create($eventData[0]['startTime']);
                                $et = date_create($eventData[0]['endTime']);
                                $forDescription = date_format($d, DATE_FORMAT_SHARE) . ", " . date_format($st, 'g:ia');
                                if ($eventData[0]['isEventEverywhere'] == '1') {
                                    $forDescription .= " @ All Taprooms";
                                } else {
                                    $forDescription .= " @ " . $eventData[0]['locName'] . " Taproom";
                                }
                                $truncated_RestaurantName = (strlen(strip_tags($eventData[0]['eventDescription'])) > 140) ? substr(strip_tags($eventData[0]['eventDescription']), 0, 140) . '..' : strip_tags($eventData[0]['eventDescription']);
                                $data['meta']['description'] = $forDescription;
                                $data['meta']['link'] = $eventData[0]['eventShareLink'];
                                $imgLink = base_url() . EVENT_PATH_THUMB . $eventData[0]['filename'];
                                if ($eventData[0]['hasShareImg'] == ACTIVE) {
                                    $shareImg = $this->dashboard_model->getShareImg($eventData[0]['eventId']);
                                    if (isset($shareImg) && myIsArray($shareImg)) {
                                        $imgLink = base_url() . EVENT_PATH_THUMB . $shareImg['filename'];
                                    }
                                }
                                $data['meta']['img'] = $imgLink;
                            }
                        } else {
                            $metaTags = $this->dashboard_model->getRecentMeta();
                            if (isset($metaTags) && myIsArray($metaTags)) {
                                $data['meta1']['title'] = $metaTags['metaTitle'];
                                $data['meta1']['description'] = $metaTags['metaDescription'];
                                $data['meta1']['img'] = base_url() . 'asset/images/thumb/' . $metaTags['metaImg'];
                            } else {
                                $data['meta1']['title'] = 'Ways to kill your time';
                                $data['meta1']['description'] = "Browse through the fun stuff that's going down at our taprooms.";
                                $data['meta1']['img'] = base_url() . 'asset/images/thumb/doolally-app-icon.png';
                            }
                            $data['meta1']['link'] = base_url();
                        }
                    } elseif ($query[1] == 'fnbshare') {
                        if (isset($query[2])) {
                            $fnb = explode('-', $query[2]);
                            $fnbData = $this->dashboard_model->getFnBById($fnb[1]);
                            $fnbAtt = $this->dashboard_model->getFnbAttById($fnb[1]);
                            if (myIsMultiArray($fnbData)) {
                                $data['meta']['title'] = $fnbData[0]['itemName'];
                                if (isset($fnbData[0]['itemHeadline'])) {
                                    $truncated_RestaurantName = $fnbData[0]['itemHeadline'];
                                } else {
                                    $truncated_RestaurantName = $fnbData[0]['itemDescription'];
                                }
                                $data['meta']['description'] = $truncated_RestaurantName;
                                $data['meta']['link'] = base_url() . '?page/fnbshare/fnb-' . $fnbData[0]['fnbId'];
                                if (isset($fnbAtt) && myIsArray($fnbAtt)) {
                                    if ($fnbData[0]['itemType'] == '1') {
                                        $data['meta']['img'] = base_url() . FOOD_PATH_THUMB . $fnbAtt[0]['filename'];
                                    } else {
                                        $data['meta']['img'] = base_url() . BEVERAGE_PATH_NORMAL . $fnbAtt[0]['filename'];
                                    }
                                } else {
                                    $data['meta']['img'] = '';
                                }
                            }
                        }
                    }
                }
            }

            /*$events = $this->dashboard_model->getAllApprovedEvents();
            usort($events,
                function($a, $b) {
                    $ts_a = strtotime($a['eventDate']);
                    $ts_b = strtotime($b['eventDate']);

                    return $ts_a > $ts_b;
                }
            );

            $data['eventDetails'] = $events;

            $this->load->view('ComingSoonView', $data);
            return true;*/

            $myFeeds = $this->cron_model->getAllSortedFeeds();
            if (isset($myFeeds) && myIsMultiArray($myFeeds)) {
                $data['myFeeds'] = $myFeeds; //json_decode($myFeeds[0]['feedText'], true);
            }

            //$data['fnbItems'] = $this->dashboard_model->getAllActiveFnB();

            //$data['beerCount'] = $this->dashboard_model->getBeersCount();

            $data['mainLocs'] = $this->locations_model->getAllLocations();

            //$data['weekEvents'] = $this->dashboard_model->getWeeklyEvents();

            $events = $this->dashboard_model->getAllApprovedEvents();
            usort($events,
                function ($a, $b) {
                    $ts_a = strtotime($a['eventDate']);
                    $ts_b = strtotime($b['eventDate']);

                    return $ts_a > $ts_b;
                }
            );

            $data['eventDetails'] = $events;

            $data['currentUrl'] = $_SERVER['REQUEST_URI'];
            $data['desktopStyle'] = $this->dataformatinghtml_library->getDesktopStyleHtml($data);
            $data['desktopJs'] = $this->dataformatinghtml_library->getDesktopJsHtml($data);
            $data['leftSideCal'] = $this->dataformatinghtml_library->getWeeklyCalHtml($data);
            $data['rightSideFnb'] = $this->dataformatinghtml_library->getFnbSideHtml($data);
            $data['deskHeader'] = $this->dataformatinghtml_library->getDeskHeaderHtml($data);

            $this->load->view('desktop/DesktopHomeView', $data);
        }
    }

    public function about()
    {
        $data = array();

        if ($this->session->userdata('osType') == 'android') {
            $aboutView = $this->load->view('AboutUsView', $data);
        } else {
            $aboutView = $this->load->view('AboutUsView', $data);
        }
        echo json_encode($aboutView);
    }

    //done
    public function eventFetch($eventSlug)
    {
        $post = $this->input->post();
        $data = array();

        /*$decodedS = explode('-',$eventId);
        $eventId = $decodedS[count($decodedS)-1];*/
        $events = $this->dashboard_model->getFullEventInfoBySlug($eventSlug);
        if(!myIsArray($events))
        {
            $events = $this->dashboard_model->getCompEventInfoBySlug($eventSlug);
            $data['eventCompleted'] = true;
        }

        $data['meta']['title'] = $events[0]['eventName'];
        $data['eventDetails'] = $events;
        if (isSessionVariableSet($this->userMobId)) {
            $userCreated = $this->dashboard_model->checkUserCreated($this->userMobId, $events[0]['eventId']);
            if ($userCreated['status'] === TRUE) {
                $data['userCreated'] = TRUE;
            } else {
                $data['userCreated'] = FALSE;
            }
            $userBooked = $this->dashboard_model->checkUserBooked($this->userMobId, $events[0]['eventId']);
            if ($userBooked['status'] === TRUE) {
                $data['userBooked'] = TRUE;
            } else {
                $data['userBooked'] = FALSE;
            }
        }

        //Checking if event under review
        $eventReview = $this->dashboard_model->getEditRecord($events[0]['eventId']);
        if(isset($eventReview) && myIsArray($eventReview))
        {
            $data['isUnderReview'] = true;
        }

        $data['eventBookTc'] = $this->config->item('eventBookTc');;
        if (isset($post['isAjax']) && $post['isAjax'] == '1') {
            $aboutView = $this->load->view('desktop/EventView', $data);
            echo json_encode($aboutView);
        } else {
            $aboutView = $this->load->view('EventView', $data);
            echo json_encode($aboutView);
        }
    }

    //done
    public function editEvent($eventSlug)
    {
        $post = $this->input->post();
        $data = array();

        if (isSessionVariableSet($this->isMobUserSession) === FALSE) {
            $data['status'] = FALSE;
        } else {
            $data['status'] = TRUE;
            //if(hash_compare(encrypt_data($eventId),$evenHash))
            //{
            /* $decodedS = explode('-',$eventId);
             $eventId = $decodedS[count($decodedS)-1];*/
            $data['eventDetails'] = $this->dashboard_model->getFullEventInfoBySlug($eventSlug);
            $data['eventTc'] = $this->config->item('eventTc');
            $data['locData'] = $this->locations_model->getAllLocations();

            //}
            /*else
            {
                $pgError = $this->load->view('mobile/ios/EventEditView', $data);
                echo json_encode($pgError);
            }*/
        }
        if (isset($post['isAjax']) && $post['isAjax'] == '1') {
            $aboutView = $this->load->view('desktop/EventEditView', $data);
        } else {
            $aboutView = $this->load->view('EventEditView', $data);
        }

        echo json_encode($aboutView);

    }

    public function createEvent()
    {
        $post = $this->input->post();
        $data = array();

        $data['eventTc'] = $this->config->item('eventTc');// $this->load->view('mobile/ios/EventTcView', $data);
        $data['locData'] = $this->locations_model->getAllLocations();

        if (isset($post['isAjax']) && $post['isAjax'] == '1') {
            $aboutView = $this->load->view('desktop/EventAddView', $data);
        } else {
            $aboutView = $this->load->view('EventAddView', $data);
        }

        echo json_encode($aboutView);
    }

    public function myEvents()
    {
        $this->load->model('login_model');
        $post = $this->input->post();
        $data = array();
        if (isSessionVariableSet($this->isMobUserSession) === FALSE) {
            $data['status'] = FALSE;
        } else {
            if (isSessionVariableSet($this->isMobUserSession) && isSessionVariableSet($this->userMobId)) {
                $data['status'] = TRUE;
                $data['registeredEvents'] = $this->dashboard_model->getEventsRegisteredByUser($this->userMobId);
                $data['userEvents'] = $this->dashboard_model->getEventsByUserId($this->userMobId);
            } elseif (isSessionVariableSet($this->jukeboxToken) && isSessionVariableSet($this->userMobEmail)) {
                $userId = '';
                $userExists = $this->users_model->getUserDetailsByEmail($this->userMobEmail);
                if ($userExists['status'] === TRUE) {
                    $userId = $userExists['userData'][0]['userId'];
                } else {
                    $details = array(
                        'userName' => $this->userMobEmail,
                        'firstName' => '',
                        'lastName' => '',
                        'password' => '',
                        'plain_pass' => '',
                        'LoginPin' => null,
                        'emailId' => $this->userMobEmail,
                        'mobNum' => null,
                        'userType' => '4'
                    );
                    $userId = $this->users_model->saveMobUserRecord($details);
                }
                if (isset($userId) && isStringSet($userId)) {
                    $this->login_model->setLastLogin($userId);
                    $this->generalfunction_library->setMobUserSession($userId);
                    $data['status'] = TRUE;
                } else {
                    $data['status'] = FALSE;
                    $data['errorMsg'] = 'Error User Creation, Try later';
                }
                $data['status'] = TRUE;
                $data['registeredEvents'] = $this->dashboard_model->getEventsRegisteredByUser($this->userMobId);
                $data['userEvents'] = $this->dashboard_model->getEventsByUserId($this->userMobId);
            } else {
                $data['status'] = FALSE;
            }

        }

        if (isset($post['isAjax']) && $post['isAjax'] == '1') {
            $eventView = $this->load->view('desktop/MyEventsView', $data);
        } else {
            $eventView = $this->load->view('MyEventsView', $data);
        }

        echo json_encode($eventView);

    }

    public function eventCancel()
    {
        $post = $this->input->post();
        $data = array();

        if (isset($post['bId'])) {
            $cancelInfo = $this->dashboard_model->getEventCancelInfo($post['bId']);
            $this->dashboard_model->cancelUserEventBooking($post['bId']);
            if (isset($cancelInfo['eventId']) && isset($cancelInfo['eventPrice']) &&
                $cancelInfo['eventPrice'] != 0 && isset($cancelInfo['paymentId']) && isStringSet($cancelInfo['paymentId'])
            )
            {
                $this->dashboard_model->cancelEventOffers($cancelInfo['eventId'], $cancelInfo['paymentId'], $cancelInfo['offerType']);
            }
            if (myIsArray($cancelInfo) && stripos($cancelInfo['paymentId'], 'MOJO') !== FALSE)
            {
                if ($cancelInfo['eventPrice'] != '0') {
                    $details = array(
                        'payment_id' => $cancelInfo['paymentId'],
                        'type' => 'TAN',
                        'body' => 'Not Attending Event'
                    );
                    $refundStats = $this->curl_library->refundInstaPayment($details);
                }

                if (isset($refundStats) && myIsArray($refundStats)) {
                    if ($refundStats['success'] === TRUE && isset($refundStats['refund'])) {
                        $cancelInfo['refundId'] = $refundStats['refund']['id'];
                    }
                }
                if (isSessionVariableSet($this->instaEventId)) {
                    $this->generalfunction_library->unSetSessionVariable('instaEventId');
                    $this->instaEventId = 0;
                    $this->generalfunction_library->unSetSessionVariable('instaMojoStatus');
                    $this->instaMojoStatus = '0';
                }
                $cancelInfo['refundAmt'] = $cancelInfo['eventPrice'];
                $this->sendemail_library->attendeeMojoCancelMail($cancelInfo);
                $this->sendemail_library->eventCancelSendMail($cancelInfo);
                $data['status'] = TRUE;
            }
            elseif (myIsArray($cancelInfo))
            {
                $couponArr = $this->dashboard_model->getEventCouponInfo($cancelInfo['eventId'], $cancelInfo['paymentId']);
                $couponAmt = 0;
                if (isset($couponArr) && myIsArray($couponArr)) {
                    foreach ($couponArr as $key => $row) {
                        if (isset($row['offerType'])) {
                            if ($row['offerType'] == 'Workshop') {
                                if ($row['isRedeemed'] == '1') {
                                    $couponAmt += (int)NEW_DOOLALLY_FEE;
                                }
                            } else {
                                if (stripos($row['offerType'], 'Rs') !== false) {
                                    if ($row['isRedeemed'] == '1') {
                                        $offer = (int)trim(str_replace('Rs', '', $row['offerType']));
                                        $couponAmt += $offer;
                                    }
                                }
                            }
                        }
                    }
                }

                $actualRefundAmt = ((int)$cancelInfo['eventPrice'] * (int)$cancelInfo['quantity']);
                if($cancelInfo['isDirectlyRegistered'] == '1') //Doolally signup
                {
                    $totalPrice = (int)((int)$cancelInfo['eventPrice'] * (int)$cancelInfo['quantity']);
                    $commision = ((float)DOOLALLY_GATEWAY_CHARGE / 100) * (int)$totalPrice;
                    $actualRefundAmt = (($totalPrice - $commision) - $couponAmt);
                }
                else // EventsHigh Signup
                {
                    $totalPrice = ((int)$cancelInfo['eventPrice'] * (int)$cancelInfo['quantity']);
                    $commision = ((float)EH_GATEWAY_CHARGE / 100) * (int)$totalPrice;
                    $actualRefundAmt = (($totalPrice - $commision) - $couponAmt);
                }
                $details = array(
                    'event_id' => $cancelInfo['highId'],
                    'booking_id' => $cancelInfo['paymentId'],
                    'charge_commission_to_user' => false,
                    'refund_amount' => $actualRefundAmt
                );

                $ehRefund = $this->curl_library->refundEventsHigh($details);

                if ($ehRefund['status'] == 'success')
                {
                    if (isset($ehRefund['refund_info']['id']))
                    {
                        $refDetails = array(
                            'eventId' => $cancelInfo['eventId'],
                            'transType' => 'Paid',
                            'refundId' => $ehRefund['refund_info']['id'],
                            'refundAmount' => $ehRefund['refund_info']['refundAmount'],
                            'refundReason' => $ehRefund['refund_info']['refundReason'],
                            'refundGateway' => $ehRefund['refund_info']['refundGateway'],
                            'bookingId' => $cancelInfo['paymentId'],
                            'pgRefundId' => $ehRefund['refund_info']['paymentGatewayRefundId'],
                            'transStatus' => 'Success',
                            'refundError' => null,
                            'refundDateTime' => date('Y-m-d H:i:s')
                        );
                        $cancelInfo['refundId'] = $ehRefund['refund_info']['id'];
                    }
                    else
                    {
                        $refDetails = array(
                            'eventId' => $cancelInfo['eventId'],
                            'transType' => 'Free',
                            'refundId' => null,
                            'refundAmount' => 0,
                            'refundReason' => null,
                            'refundGateway' => null,
                            'bookingId' => $cancelInfo['paymentId'],
                            'pgRefundId' => null,
                            'transStatus' => 'Success',
                            'refundError' => null,
                            'refundDateTime' => date('Y-m-d H:i:s')
                        );
                    }

                }
                else
                {
                    $errorTxt = '';
                    if (isset($ehRefund['message'])) {
                        $errr = json_decode($ehRefund['message'], true);
                        $errorTxt = $errr['type'];
                    }
                    $refDetails = array(
                        'eventId' => $cancelInfo['eventId'],
                        'transType' => 'Failed',
                        'refundId' => null,
                        'refundAmount' => 0,
                        'refundReason' => null,
                        'refundGateway' => null,
                        'bookingId' => $cancelInfo['paymentId'],
                        'pgRefundId' => null,
                        'transStatus' => 'Failed',
                        'refundError' => $errorTxt,
                        'refundDateTime' => date('Y-m-d H:i:s')
                    );
                    if ($errorTxt != '') {
                        $mailTxt = array(
                            'eventName' => $cancelInfo['eventName'],
                            'bookingId' => $cancelInfo['paymentId'],
                            'errorTxt' => $errorTxt,
                            'refundDateTime' => date('Y-m-d H:i:s')
                        );
                        $this->sendemail_library->refundFailSendMail($mailTxt);
                    }
                }
                $this->dashboard_model->saveEhRefundDetails($refDetails);
                if (isSessionVariableSet($this->paymentEventId)) {
                    $this->generalfunction_library->unSetSessionVariable('paymentEventId');
                    $this->paymentEventId = 0;
                    $this->generalfunction_library->unSetSessionVariable('paymentStatus');
                    $this->paymentStatus = '0';
                }
                $refAmt = $actualRefundAmt;
                $cancelInfo['refundAmt'] = $refAmt;
                $cancelInfo['couponAmt'] = $couponAmt;
                $this->sendemail_library->attendeeCancelMail($cancelInfo);
                $this->sendemail_library->eventCancelSendMail($cancelInfo);
                $data['status'] = TRUE;
            }
            else
            {
                $data['status'] = FALSE;
                $data['errorMsg'] = 'Invalid Booking Id';
            }
        } else {
            $data['status'] = FALSE;
            $data['errorMsg'] = 'Missing Booking Id';
        }

        echo json_encode($data);
    }

    public function requestSong()
    {
        $data = array();
        if (isSessionVariableSet($this->isMobUserSession) === FALSE) {
            $data['status'] = FALSE;
        } else {
            $data['status'] = TRUE;
        }

        $eventView = $this->load->view('MyEventsView', $data);

        echo json_encode($eventView);

    }

    public function contactUs()
    {
        $post = $this->input->post();
        $data = array();

        $data['locData'] = $this->locations_model->getAllLocations();

        if (isset($post['isAjax']) && $post['isAjax'] == '1') {
            $eventView = $this->load->view('desktop/ContactUsView', $data);
        } else {
            $eventView = $this->load->view('ContactUsView', $data);
        }

        echo json_encode($eventView);

    }

    public function jukeBox()
    {
        $post = $this->input->post();
        $data = array();

        $data['taprooms'] = $this->curl_library->getJukeboxTaprooms();

        if (isset($post['isAjax']) && $post['isAjax'] == '1') {
            $eventView = $this->load->view('desktop/JukeboxView', $data);
        } else {
            $eventView = $this->load->view('JukeboxView', $data);
        }

        echo json_encode($eventView);

    }

    //done
    public function taproomInfo($jukeSlug)
    {
        $post = $this->input->post();
        $data = array();

        $locData = $this->locations_model->getLocByJukeboxSlug($jukeSlug);

        if (isset($locData) && myIsArray($locData)) {
            $data['taproomId'] = $locData['jukeboxId'];
            $data['taproomInfo'] = $this->curl_library->getTaproomInfo($locData['jukeboxId']);
        } else {
            $data['error'] = 'No Taproom Found!';
        }

        if (isset($post['isAjax']) && $post['isAjax'] == '1') {
            $eventView = $this->load->view('desktop/TaproomView', $data);
        } else {
            $eventView = $this->load->view('TaproomView', $data);
        }

        echo json_encode($eventView);
    }

    //done
    public function eventDetails($eventSlug)
    {
        $post = $this->input->post();
        $data = array();
        if (isSessionVariableSet($this->isMobUserSession) === FALSE)
        {
            $data['status'] = FALSE;
        }
        else
        {
            $data['status'] = TRUE;
            //if(hash_compare(encrypt_data($eventId),$evenHash))
            //{
            /*$decodedS = explode('-',$eventId);
            $eventId = $decodedS[count($decodedS)-1];*/
            $events = $this->dashboard_model->getDashboardEventDetails($eventSlug);
            $comDetails = $this->dashboard_model->getCommDetails($events[0]['eventPlace']);
            $data['commDetails'] = $comDetails;
            /*$shortDWName = $this->googleurlapi->shorten($events[0]['eventShareLink']);
            if($shortDWName !== false)
            {
                $events[0]['eventShareLink'] = $shortDWName;
            }*/
            $data['meta']['title'] = $events[0]['eventName'];
            $data['eventDetails'] = $events;

            //}
            /*else
            {
                $pgError = $this->load->view('mobile/ios/EventView', $data);
                echo json_encode($pgError);
            }*/
            /*$eventHighRecord = $this->dashboard_model->getEventHighRecord($events[0]['eventId']);
            if (isset($eventHighRecord) && myIsArray($eventHighRecord)) {
                $EHAtendees = $this->curl_library->attendeeEventsHigh($eventHighRecord['highId']);
                if (isset($EHAtendees) && myIsArray($EHAtendees)) {
                    $data['EHData'] = $EHAtendees;
                    $data['EHTotal'] = array_sum(array_map(function ($foo) {
                        return $foo['numTickets'];
                    }, $EHAtendees));
                }
            }*/
        }

        if (isset($post['isAjax']) && $post['isAjax'] == '1') {
            $eventAtt = $this->dashboard_model->getEventAttById($events[0]['eventId']);
            if (isset($eventAtt) && myIsArray($eventAtt))
            {
                $data['eventDetails'][0]['filename'] = $eventAtt[0]['filename'];
            }
            $data['EhSignupList'] = $this->dashboard_model->fetchEhSignupList($eventSlug);
            $data['DoolallySignupList'] = $this->dashboard_model->fetchDoolallySignupList($eventSlug);
            $aboutView = $this->load->view('desktop/EventSingleView', $data);
        } else {
            $aboutView = $this->load->view('EventSingleView', $data);
        }

        echo json_encode($aboutView);
    }

    public function signupList($eventId, $evenHash)
    {
        $data = array();
        if (isSessionVariableSet($this->isMobUserSession) === FALSE) {
            $data['status'] = FALSE;
        } else {
            $data['status'] = TRUE;
            if (hash_compare(encrypt_data($eventId), $evenHash)) {
                $decodedS = explode('-', $eventId);
                $eventId = $decodedS[count($decodedS) - 1];
                $data['doolallyJoiners'] = $this->dashboard_model->getDoolallyJoinersInfo($eventId);
                $data['ehJoiners'] = $this->dashboard_model->getEhJoinersInfo($eventId);

                //$data['meta']['title'] = $events[0]['eventName'];
                /*$eventHighRecord = $this->dashboard_model->getEventHighRecord($eventId);
                if (isset($eventHighRecord) && myIsArray($eventHighRecord)) {
                    $EHAtendees = $this->curl_library->attendeeEventsHigh($eventHighRecord['highId']);
                    if (isset($EHAtendees) && myIsArray($EHAtendees)) {
                        $data['EHData'] = $EHAtendees;
                    }
                }*/
            }
        }

        $aboutView = $this->load->view('signUpListView', $data);

        echo json_encode($aboutView);
    }

    function thankYou($eventId, $mojoId)
    {
        $sessionDone = FALSE;
        if (isSessionVariableSet($this->instaEventId)) {
            if ($this->instaEventId != $eventId) {
                $this->generalfunction_library->setSessionVariable('instaEventId', $eventId);
                $this->instaEventId = $eventId;
                $this->generalfunction_library->setSessionVariable('instaMojoStatus', '1');
                $this->instaMojoStatus = '1';
                $sessionDone = TRUE;
                //redirect(base_url().'mobile');
            }
        } else {
            $this->generalfunction_library->setSessionVariable('instaEventId', $eventId);
            $this->instaEventId = $eventId;
            $this->generalfunction_library->setSessionVariable('instaMojoStatus', '1');
            $this->instaMojoStatus = '1';
            $sessionDone = TRUE;
            //redirect(base_url().'mobile');
        }
        if ($sessionDone === TRUE) {
            $this->load->model('login_model');
            $userId = '';

            $requiredInfo = array();
            $mojoDetails = $this->curl_library->getInstaMojoRecord($mojoId);
            if (isset($mojoDetails) && myIsMultiArray($mojoDetails) && isset($mojoDetails['payment'])) {
                $mojoNumber = $this->clearMobNumber($mojoDetails['payment']['buyer_phone']);
                $userStatus = $this->checkPublicUser($mojoDetails['payment']['buyer_email'], $mojoNumber);
                $isSavedAlready = false;
                if ($userStatus['status'] === FALSE) {
                    $userId = $userStatus['userData']['userId'];
                    $checkUserAlreadyReg = $this->dashboard_model->checkUserBookedWithMojo($userId, $eventId, $mojoId);
                    if ($checkUserAlreadyReg['status'] === false) {
                        $userName = explode(' ', $mojoDetails['payment']['buyer_name']);
                        if (count($userName) < 2) {
                            $userName[1] = '';
                        }
                        if ($userStatus['userData']['firstName'] == '' && $userStatus['userData']['lastName'] == '') {
                            $detail = array(
                                'firstName' => $userName[0],
                                'lastName' => $userName[1],
                                'userId' => $userId
                            );
                            $this->users_model->updatePublicUser($detail);
                        }
                        $eventData = $this->dashboard_model->getEventById($eventId);
                        $mailData = array(
                            'creatorName' => $mojoDetails['payment']['buyer_name'],
                            'creatorEmail' => $mojoDetails['payment']['buyer_email'],
                            'creatorPhone' => $mojoDetails['payment']['buyer_phone'],
                            'eventName' => $eventData[0]['eventName'],
                            'eventDate' => $eventData[0]['eventDate'],
                            'startTime' => $eventData[0]['startTime'],
                            'endTime' => $eventData[0]['endTime'],
                            'hostEmail' => $eventData[0]['creatorEmail'],
                            'hostName' => $eventData[0]['creatorName'],
                            'eventDescrip' => $eventData[0]['eventDescription'],
                            'eventCost' => $eventData[0]['costType'],
                            'eventId' => $eventData[0]['eventId'],
                            'buyQuantity' => $mojoDetails['payment']['quantity'],
                            'doolallyFee' => $eventData[0]['doolallyFee'],
                            'bookerId' => $mojoId
                        );
                        $this->sendemail_library->eventRegSuccessMail($mailData, $eventData[0]['eventPlace']);
                        $this->sendemail_library->eventHostSuccessMail($mailData, $eventData[0]['eventPlace']);
                    } else {
                        $isSavedAlready = true;
                    }
                } else {
                    $userName = explode(' ', $mojoDetails['payment']['buyer_name']);
                    if (count($userName) < 2) {
                        $userName[1] = '';
                    }

                    $user = array(
                        'userName' => $mojoDetails['payment']['buyer_email'],
                        'firstName' => $userName[0],
                        'lastName' => $userName[1],
                        'password' => md5($mojoNumber),
                        'LoginPin' => null,
                        'isPinChanged' => null,
                        'emailId' => $mojoDetails['payment']['buyer_email'],
                        'mobNum' => $mojoNumber,
                        'userType' => '4',
                        'assignedLoc' => null,
                        'ifActive' => '1',
                        'insertedDate' => date('Y-m-d H:i:s'),
                        'updateDate' => date('Y-m-d H:i:s'),
                        'updatedBy' => $mojoDetails['payment']['buyer_name'],
                        'lastLogin' => date('Y-m-d H:i:s')
                    );

                    $userId = $this->users_model->savePublicUser($user);
                    $checkUserAlreadyReg = $this->dashboard_model->checkUserBookedWithMojo($userId, $eventId, $mojoId);
                    if ($checkUserAlreadyReg['status'] === false) {
                        $eventData = $this->dashboard_model->getEventById($eventId);
                        $mailData = array(
                            'creatorName' => $mojoDetails['payment']['buyer_name'],
                            'creatorEmail' => $mojoDetails['payment']['buyer_email'],
                            'creatorPhone' => $mojoDetails['payment']['buyer_phone'],
                            'eventName' => $eventData[0]['eventName'],
                            'eventDate' => $eventData[0]['eventDate'],
                            'startTime' => $eventData[0]['startTime'],
                            'endTime' => $eventData[0]['endTime'],
                            'hostEmail' => $eventData[0]['creatorEmail'],
                            'hostName' => $eventData[0]['creatorName'],
                            'eventDescrip' => $eventData[0]['eventDescription'],
                            'eventCost' => $eventData[0]['costType'],
                            'eventId' => $eventData[0]['eventId'],
                            'buyQuantity' => $mojoDetails['payment']['quantity'],
                            'doolallyFee' => $eventData[0]['doolallyFee'],
                            'bookerId' => $mojoId
                        );
                        $this->sendemail_library->memberWelcomeMail($mailData, $eventData[0]['eventPlace']);
                        $this->sendemail_library->eventHostSuccessMail($mailData, $eventData[0]['eventPlace']);
                    } else {
                        $isSavedAlready = true;
                    }
                }

                //Save Booking Details

                if (!$isSavedAlready) {
                    $requiredInfo = array(
                        'bookerUserId' => $userId,
                        'eventId' => $eventId,
                        'quantity' => $mojoDetails['payment']['quantity'],
                        'paymentId' => $mojoId
                    );

                    $this->dashboard_model->saveEventRegis($requiredInfo);
                    //$this->sendemail_library->newEventMail($mailEvent);
                    if (isSessionVariableSet($this->isMobUserSession) === FALSE) {
                        $this->login_model->setLastLogin($userId);
                        $this->generalfunction_library->setMobUserSession($userId);
                    }
                }
            } else {
                $this->generalfunction_library->setSessionVariable('instaMojoStatus', '2');
                $this->instaMojoStatus = '2';
            }

        }
        return TRUE;
    }

    //For EH Payment Gateway
    function thankYou1($eventId, $ehArray, $isDirect = 1)
    {
        $sessionDone = TRUE;
        $this->generalfunction_library->setSessionVariable('paymentEventId', $eventId);
        $this->paymentEventId = $eventId;
        $this->generalfunction_library->setSessionVariable('paymentStatus', '1');
        $this->paymentStatus = '1';
        /*if(isSessionVariableSet($this->paymentEventId))
        {
            if($this->paymentEventId != $eventId)
            {
                $this->generalfunction_library->setSessionVariable('paymentEventId',$eventId);
                $this->paymentEventId= $eventId;
                $this->generalfunction_library->setSessionVariable('paymentStatus','1');
                $this->paymentStatus = '1';
                $sessionDone = TRUE;
                //redirect(base_url().'mobile');
            }
        }
        else
        {
            $this->generalfunction_library->setSessionVariable('paymentEventId',$eventId);
            $this->paymentEventId= $eventId;
            $this->generalfunction_library->setSessionVariable('paymentStatus','1');
            $this->paymentStatus = '1';
            $sessionDone = TRUE;
            //redirect(base_url().'mobile');
        }*/
        if ($sessionDone === TRUE) {
            $this->load->model('login_model');
            $userId = '';

            $requiredInfo = array();
            $ehDetails = $this->dashboard_model->getEventInfoByEhId($eventId);
            if (isset($ehDetails) && myIsMultiArray($ehDetails)) {
                $mojoNumber = $this->clearMobNumber($ehArray['userMobile']);
                $userStatus = $this->checkPublicUser($ehArray['userEmail'], $mojoNumber);
                $isSavedAlready = false;
                if ($userStatus['status'] === FALSE) {
                    $userId = $userStatus['userData']['userId'];
                    $checkUserAlreadyReg = $this->dashboard_model->checkUserBookedWithMojo($userId, $ehDetails['eventId'], $ehArray['bookingid']);
                    if ($checkUserAlreadyReg['status'] === false)
                    {
                        $userName = explode(' ', $ehArray['userName']);
                        if (count($userName) < 2) {
                            $userName[1] = '';
                        }
                        if ($userStatus['userData']['firstName'] == '' && $userStatus['userData']['lastName'] == '') {
                            $detail = array(
                                'firstName' => $userName[0],
                                'lastName' => $userName[1],
                                'userId' => $userId
                            );
                            $this->users_model->updatePublicUser($detail);
                        }
                        $eventData = $this->dashboard_model->getEventById($ehDetails['eventId']);
                        $mailData = array(
                            'creatorName' => $ehArray['userName'],
                            'creatorEmail' => $ehArray['userEmail'],
                            'creatorPhone' => $ehArray['userMobile'],
                            'eventName' => $eventData[0]['eventName'],
                            'eventDate' => $eventData[0]['eventDate'],
                            'startTime' => $eventData[0]['startTime'],
                            'endTime' => $eventData[0]['endTime'],
                            'hostEmail' => $eventData[0]['creatorEmail'],
                            'hostName' => $eventData[0]['creatorName'],
                            'eventDescrip' => $eventData[0]['eventDescription'],
                            'eventCost' => $eventData[0]['costType'],
                            'eventId' => $eventData[0]['eventId'],
                            'buyQuantity' => $ehArray['nTickets'],
                            'doolallyFee' => $eventData[0]['doolallyFee'],
                            'bookerId' => $ehArray['bookingid']
                        );
                        $this->sendemail_library->eventRegSuccessMail($mailData, $eventData[0]['eventPlace']);
                        $this->sendemail_library->eventHostSuccessMail($mailData, $eventData[0]['eventPlace']);
                    }
                    else {
                        $isSavedAlready = true;
                    }
                }
                else {
                    $userName = explode(' ', $ehArray['userName']);
                    if (count($userName) < 2) {
                        $userName[1] = '';
                    }

                    $user = array(
                        'userName' => $ehArray['userEmail'],
                        'firstName' => $userName[0],
                        'lastName' => $userName[1],
                        'password' => md5($mojoNumber),
                        'LoginPin' => null,
                        'isPinChanged' => null,
                        'emailId' => $ehArray['userEmail'],
                        'mobNum' => $mojoNumber,
                        'userType' => '4',
                        'assignedLoc' => null,
                        'ifActive' => '1',
                        'insertedDate' => date('Y-m-d H:i:s'),
                        'updateDate' => date('Y-m-d H:i:s'),
                        'updatedBy' => $ehArray['userName'],
                        'lastLogin' => date('Y-m-d H:i:s')
                    );

                    $userId = $this->users_model->savePublicUser($user);
                    $checkUserAlreadyReg = $this->dashboard_model->checkUserBookedWithMojo($userId, $ehDetails['eventId'], $ehArray['bookingid']);
                    if ($checkUserAlreadyReg['status'] === false) {
                        $eventData = $this->dashboard_model->getEventById($ehDetails['eventId']);
                        $mailData = array(
                            'creatorName' => $ehArray['userName'],
                            'creatorEmail' => $ehArray['userEmail'],
                            'creatorPhone' => $ehArray['userMobile'],
                            'eventName' => $eventData[0]['eventName'],
                            'eventDate' => $eventData[0]['eventDate'],
                            'startTime' => $eventData[0]['startTime'],
                            'endTime' => $eventData[0]['endTime'],
                            'hostEmail' => $eventData[0]['creatorEmail'],
                            'hostName' => $eventData[0]['creatorName'],
                            'eventDescrip' => $eventData[0]['eventDescription'],
                            'eventCost' => $eventData[0]['costType'],
                            'eventId' => $eventData[0]['eventId'],
                            'buyQuantity' => $ehArray['nTickets'],
                            'doolallyFee' => $eventData[0]['doolallyFee'],
                            'bookerId' => $ehArray['bookingid']
                        );
                        $this->sendemail_library->memberWelcomeMail($mailData, $eventData[0]['eventPlace']);
                        $this->sendemail_library->eventHostSuccessMail($mailData, $eventData[0]['eventPlace']);
                    } else {
                        $isSavedAlready = true;
                    }
                }

                //Save Booking Details

                if (!$isSavedAlready) {
                    $requiredInfo = array(
                        'bookerUserId' => $userId,
                        'eventId' => $ehDetails['eventId'],
                        'quantity' => $ehArray['nTickets'],
                        'paymentId' => $ehArray['bookingid'],
                        'isDirectlyRegistered' => $isDirect
                    );

                    $this->dashboard_model->saveEventRegis($requiredInfo);
                    //$this->sendemail_library->newEventMail($mailEvent);
                    if (isSessionVariableSet($this->isMobUserSession) === FALSE) {
                        $this->login_model->setLastLogin($userId);
                        $this->generalfunction_library->setMobUserSession($userId);
                    }
                }
            } else {
                $this->generalfunction_library->setSessionVariable('paymentStatus', '2');
                $this->paymentStatus = '2';
            }

        }
        return TRUE;
    }

    function clearMobNumber($mobNum)
    {
        $tempMob = $mobNum;
        if (strlen($mobNum) != 10) {
            $extensionClear = str_replace('+91', '', $mobNum);
            $tempMob = ltrim($extensionClear, '0');
        }
        return $tempMob;
    }

    public function eventsHighCallback()
    {
        $get = $this->input->get();

        //EventsHigh Payment handle
        if(isset($get['bookingid']) && isset($get['eid']))
        {
            if(isset($get['status']) && $get['status'] == 'success'
                && isset($get['userName']) && isset($get['userEmail']) && isset($get['userMobile'])
                && isset($get['nTickets']))
            {
                $ehArray = array(
                    'bookingid' => $get['bookingid'],
                    'userName' => urldecode($get['userName']),
                    'userEmail' => $get['userEmail'],
                    'userMobile' => $get['userMobile'],
                    'nTickets' => $get['nTickets']
                );
                $this->thankYou1($get['eid'],$ehArray,0);
            }
        }
    }

    public function checkJukeboxUser()
    {
        $post = $this->input->post();

        $data = array();

        if(isset($post['fbId']))
        {
            $details = array(
                'username'=> $post['fbId'],
                'email' => $post['email']
            );
        }
        else
        {
            $details = array(
                'email'=> $post['email']
            );
        }

        $this->curl_library->verifyThirdPartyUser($details);

        $juke_token = encrypt_jukebx_data($post['email']);

        $data['status'] = true;
        $this->generalfunction_library->setSessionVariable('jukebox_token',$juke_token);
        $this->jukeboxToken = $juke_token;
        $this->generalfunction_library->setSessionVariable('user_mob_email', $post['email']);
        $this->userMobEmail = $post['email'];

        echo json_encode($data);
    }

    public function checkUser()
    {
        $this->load->model('login_model');
        $post = $this->input->post();

        $data = array();
        $userInfo = $this->login_model->checkAppUser($post['username'], $post['mobNum']);

        if($userInfo['status'] === TRUE)
        {
            if($userInfo['userData']['ifActive'] == NOT_ACTIVE)
            {
                $data['status'] = FALSE;
                $data['errorMsg'] = 'User Account is Disabled!';
            }
            else
            {
                $data['status'] = TRUE;
                $userId = $userInfo['userData']['userId'];
                $this->login_model->setLastLogin($userId);
                $this->generalfunction_library->setMobUserSession($userId);
            }
        }
        else
        {
            $data['status'] = FALSE;
            $data['errorMsg'] = 'User Account Does not Exists!';
        }
        echo json_encode($data);
    }

    public function requestTapSong($id)
    {
        $post = $this->input->post();
        $data = array();

        $data['tapId'] = '';
        if(isSessionVariableSet($this->isMobUserSession) === FALSE)
        {
            $data['status'] = FALSE;
        }
        else
        {
            if(isSessionVariableSet($this->jukeboxToken))
            {
                $data['status'] = TRUE;
            }
            else
            {
                if(isSessionVariableSet($this->userMobEmail))
                {
                    $details = array(
                        'email'=> $this->userMobEmail
                    );

                    $this->curl_library->verifyThirdPartyUser($details);

                    $juke_token = encrypt_jukebx_data($this->userMobEmail);

                    $data['status'] = TRUE;
                    $this->generalfunction_library->setSessionVariable('jukebox_token',$juke_token);
                    $this->jukeboxToken = $juke_token;
                }
                else
                {
                    $data['status'] = FALSE;
                }
            }

        }

        if($data['status'] === TRUE && isSessionVariableSet($this->jukeboxToken))
        {
            $data['tapId'] = $id;
            $data['tapSongs'] = $this->dashboard_model->getTapSongs($id);
        }

        if(isset($post['isAjax']) && $post['isAjax'] == '1')
        {
            $eventView = $this->load->view('desktop/RequestSongView', $data);
        }
        else
        {
            $eventView = $this->load->view('RequestSongView', $data);
        }

        echo json_encode($eventView);
    }

    public function untappd()
    {
        $data = array();

        $eventView = $this->load->view('UntappdView', $data);

        echo json_encode($eventView);
    }
    function getAccessFromJukebox($email, $pwd)
    {
        $checkUser = $this->curl_library->checkJukeboxUser($email, $pwd);
        $data = array();

        if(isset($checkUser) && isset($checkUser['email']))
        {
            $logUser = $this->curl_library->loginJukeboxUser($email,$pwd);
            if(isset($logUser['error']))
            {
                $data['status'] = FALSE;
                $data['errorMsg'] = 'Invalid Email or Password!';
            }
            elseif(isset($logUser['access_token']))
            {
                $data['status'] = TRUE;
                $data['token'] = $logUser['access_token'];
            }
        }
        elseif(isset($checkUser['access_token']))
        {
            $data['status'] = TRUE;
            $data['token'] = $checkUser['access_token'];
        }

        return $data;
    }
    public function checkJukeUser()
    {
        $this->load->model('login_model');
        $post = $this->input->post();

        $data = array();
        $userInfo = $this->login_model->checkAppUser($post['username'], md5($post['password']));

        if($userInfo['status'] === TRUE)
        {
            if($userInfo['userData']['ifActive'] == NOT_ACTIVE)
            {
                $data['status'] = FALSE;
                $data['errorMsg'] = 'User Account is Disabled!';
            }
            else
            {
                $token = $this->getAccessFromJukebox($post['username'], $post['password']);
                if($token['status'] === TRUE)
                {
                    $this->generalfunction_library->setSessionVariable('jukebox_token',$token['token']);
                    $this->jukeboxToken = $token['token'];
                    $userId = $userInfo['userData']['userId'];
                    $this->login_model->setLastLogin($userId);
                    $this->generalfunction_library->setMobUserSession($userId);
                    $data['status'] = TRUE;
                }
                else
                {
                    $data['status'] = FALSE;
                    $data['errorMsg'] = 'Email or Password is wrong!';
                }
            }
        }
        else
        {
            $data['status'] = FALSE;
            $data['errorMsg'] = 'Email or Password is wrong!';
        }
        echo json_encode($data);
    }
    public function saveUser()
    {
        $this->load->model('users_model');
        $this->load->model('login_model');
        $post = $this->input->post();

        if(isset($post['hasjukebox']))
        {
            $loginJuke = $this->getAccessFromJukebox($post['username'], $post['jukepass']);
        }
        else
        {
            $loginJuke = $this->getAccessFromJukebox($post['username'], $post['mobNum']);
        }


        if(isset($loginJuke['status']) && $loginJuke['status'] === TRUE)
        {
            $this->generalfunction_library->setSessionVariable('jukebox_token',$loginJuke['token']);
            $this->jukeboxToken = $loginJuke['token'];
            $userInfo = $this->users_model->checkUserDetails($post['username'], $post['mobNum']);

            if($userInfo['status'] === TRUE)
            {
                if($userInfo['userData']['ifActive'] == NOT_ACTIVE)
                {
                    $data['status'] = FALSE;
                    $data['errorMsg'] = 'User Account is Disabled!';
                }
                else
                {
                    $data['status'] = TRUE;
                    $userId = $userInfo['userData']['userId'];
                    $this->login_model->setLastLogin($userId);
                    $this->generalfunction_library->setMobUserSession($userId);
                }
            }
            else
            {
                $pss = $post['mobNum'];
                if(isset($post['jukepass']))
                {
                    $pss = $post['jukepass'];
                }
                $details = array(
                    'userName' => $post['username'],
                    'firstName' => '',
                    'lastName' => '',
                    'password' => md5($pss),
                    'plain_pass' => $pss,
                    'LoginPin' => null,
                    'emailId' => $post['username'],
                    'mobNum' => $post['mobNum'],
                    'userType' => '4'
                );
                $userId = $this->users_model->saveMobUserRecord($details);
                if(isset($userId) && isStringSet($userId))
                {
                    $this->login_model->setLastLogin($userId);
                    $this->generalfunction_library->setMobUserSession($userId);
                    $data['status'] = TRUE;
                }
                else
                {
                    $data['status'] = FALSE;
                    $data['errorMsg'] = 'Error Saving User';
                }
            }
        }
        else
        {
            $data['status'] = FALSE;
            $data['errorMsg'] = 'Please use the jukebox password for login!';
        }

        echo json_encode($data);
    }

    public function playTapSong()
    {
        $post = $this->input->post();
        $data = array();

        if(isSessionVariableSet($this->jukeboxToken))
        {
            $post['Auth'] = $this->jukeboxToken;
            if(isSessionVariableSet($this->userMobEmail))
            {
                $post['email'] = $this->userMobEmail;
            }
            $songStatus = $this->curl_library->requestThirdPartySong($post);
            if(isset($songStatus['error']))
            {
                $data['status'] = FALSE;
                $data['errorNum'] = 2;
                $data['errorMsg'] = $songStatus['error'];
            }
            elseif(isset($songStatus['detail']))
            {
                $data['status'] = FALSE;
                $data['errorNum'] = 2;
                $data['errorMsg'] = $songStatus['detail'];
            }
            elseif(isset($songStatus['is_requested']))
            {
                $data['status'] = TRUE;
            }
        }
        else
        {
            $data['status'] = FALSE;
            $data['errorNum'] = 1;
            $data['errorMsg'] = 'Invalid Login/Session';
        }

        echo json_encode($data);
    }
    public function appLogout()
    {
        $this->session->unset_userdata('user_mob_id');
        $this->session->unset_userdata('user_mob_type');
        $this->session->unset_userdata('user_mob_name');
        $this->session->unset_userdata('user_mob_email');
        $this->session->unset_userdata('user_mob_number');
        $this->session->unset_userdata('user_mob_firstname');
        $this->session->unset_userdata('jukebox_token');
        $this->isMobUserSession = '';
        $this->userMobType = '';
        $this->userMobId = '';
        $this->userMobName = '';
        $this->userMobFirstName = '';
        $this->userMobEmail = '';
        $this->userMobNumber = '';
        $this->jukeboxToken = '';

        $data['status'] = TRUE;
        echo json_encode($data);
    }
    public function checkEventSpace()
    {
        $post = $this->input->post();
        $Edetails = array(
            "startTime" => date('H:i', strtotime($post['startTime'])),
            "endTime" => date('H:i', strtotime($post['endTime'])),
            "eventPlace" => $post['eventPlace'],
            "eventDate" => $post['eventDate']
        );
        $eventSpace = $this->dashboard_model->checkEventSpace($Edetails);
        if($eventSpace['status'] === TRUE)
        {
            $data['status'] = FALSE;
            $data['errorMsg'] = 'Sorry, This time slot is already booked!';
        }
        else
        {
            $data['status'] = TRUE;
        }
        echo json_encode($data);
    }

    //done
    public function saveEvent()
    {
        $isUserCreated = FALSE;
        $this->load->model('login_model');
        $post = $this->input->post();
        $userId = '';

        //Check if space is available for event to save
        $Edetails = array(
            "startTime" => date('H:i', strtotime($post['startTime'])),
            "endTime" => date('H:i', strtotime($post['endTime'])),
            "eventPlace" => $post['eventPlace'],
            "eventDate" => $post['eventDate']
        );
        $eventSpace = $this->dashboard_model->checkEventSpace($Edetails);
        $isEventExists = $this->dashboard_model->isExistingEvent($Edetails);
        $existEveNames = '';
        if($isEventExists['status'] === TRUE)
        {
            $existEveNames = $isEventExists['eveData'][0]['eventNames'];
        }

        //Event space is empty
        if($eventSpace['status'] === FALSE)
        {
            //Check if user logged in?
            if(isset($post['creatorPhone']) && isset($post['creatorEmail']))
            {
                $userStatus = $this->checkPublicUser($post['creatorEmail'],$post['creatorPhone']);

                if($userStatus['status'] === FALSE)
                {
                    $userId = $userStatus['userData']['userId'];
                }
                else
                {
                    $userName = explode(' ',$post['creatorName']);
                    if(count($userName)< 2)
                    {
                        $userName[1] = '';
                    }

                    $user = array(
                        'userName' => $post['creatorEmail'],
                        'firstName' => $userName[0],
                        'lastName' => $userName[1],
                        'password' => md5($post['creatorPhone']),
                        'LoginPin' => null,
                        'isPinChanged' => null,
                        'emailId' => $post['creatorEmail'],
                        'mobNum' => $post['creatorPhone'],
                        'userType' => '4',
                        'assignedLoc' => null,
                        'ifActive' => '1',
                        'insertedDate' => date('Y-m-d H:i:s'),
                        'updateDate' => date('Y-m-d H:i:s'),
                        'updatedBy' => $post['creatorName'],
                        'lastLogin' => date('Y-m-d H:i:s')
                    );

                    $userId = $this->users_model->savePublicUser($user);
                    /*$mailData= array(
                        'creatorName' => $post['creatorName'],
                        'creatorEmail' => $post['creatorEmail']
                    );*/
                    $isUserCreated = true;
                    //$this->sendemail_library->memberWelcomeMail($mailData);
                }

                //Save event
                if(isset($post['attachment']))
                {
                    $attachement = $post['attachment'];
                    unset($post['attachment']);
                }
                $post['userId'] = $userId;
                if(isset($post['ifMicRequired']) && myIsArray($post['ifMicRequired']))
                {
                    $post['ifMicRequired'] = $post['ifMicRequired'][0];
                }
                if(isset($post['ifProjectorRequired']) && myIsArray($post['ifProjectorRequired']))
                {
                    $post['ifProjectorRequired'] = $post['ifProjectorRequired'][0];
                }
                $post['startTime'] = date('H:i', strtotime($post['startTime']));
                $post['endTime'] = date('H:i', strtotime($post['endTime']));
                $eveSlug = slugify($post['eventName']);
                $post['eventSlug'] = $eveSlug;
                $post['eventShareLink'] = base_url().'?page/events/'.$eveSlug;
                $post['shortUrl'] = null;
                $eventId = $this->dashboard_model->saveEventRecord($post);

                // Adding event slug to new table
                $newSlugTab = array(
                    'eventId' => $eventId,
                    'eventSlug' => $eveSlug,
                    'insertedDateTime' => date('Y-m-d H:i:s')
                );
                $this->dashboard_model->saveEventSlug($newSlugTab);

                $shortDWName = $this->googleurlapi->shorten(base_url().'?page/events/'.$eveSlug);
                if($shortDWName !== FALSE)
                {
                    $details['shortUrl'] = $shortDWName;
                    $this->dashboard_model->updateEventRecord($details,$eventId);
                }

                $img_names = array();
                if(isset($attachement))
                {
                    $img_names = explode(',',$attachement);
                    for($i=0;$i<count($img_names);$i++)
                    {
                        $attArr = array(
                            'eventId' => $eventId,
                            'filename'=> $img_names[$i],
                            'attachmentType' => '1'
                        );
                        $this->dashboard_model->saveEventAttachment($attArr);
                    }
                }

                //Sending mail confirmation
                $mailEvent= array(
                    'creatorName' => $post['creatorName'],
                    'creatorEmail' => $post['creatorEmail'],
                    'eventName' => $post['eventName'],
                    'eventPlace' => $post['eventPlace']
                );
                if($isUserCreated === TRUE)
                {
                    $mailEvent['creatorPhone'] = $post['creatorPhone'];
                }
                $loc = $this->locations_model->getLocationDetailsById($post['eventPlace']);
                $mailVerify = $this->dashboard_model->getEventById($eventId);
                $mailVerify[0]['locData'] = $loc['locData'];
                $mailVerify[0]['attachment'] = $img_names[0];
                $post['locData'] = $loc['locData'];
                $mailVerify['isEventExists'] = $isEventExists['status'];
                $mailVerify['eveNames'] = $existEveNames;
                $this->sendemail_library->newEventMail($mailEvent);
                $this->sendemail_library->eventVerifyMail($mailVerify);
                $data['status'] = TRUE;
                $this->login_model->setLastLogin($userId);
                $this->generalfunction_library->setMobUserSession($userId);
                echo json_encode($data);
            }
            //Or user logged in
            elseif(isSessionVariableSet($this->userMobId))
            {
                $userId = $this->userMobId;
                $userD = $this->users_model->getUserDetailsById($userId);
                if($userD['status'] === true)
                {
                    if(isStringSet($userD['userData'][0]['firstName']))
                    {
                        $post['creatorName'] = $userD['userData'][0]['firstName'] . ' ' . $userD['userData'][0]['lastName'];
                    }
                    $post['creatorEmail'] = $userD['userData'][0]['emailId'];
                    $post['creatorPhone'] = $userD['userData'][0]['mobNum'];
                }
                else
                {
                    $post['creatorName'] = '';
                    $post['creatorEmail'] = '';
                    $post['creatorPhone'] = '';
                }
                //Save event
                if(isset($post['attachment']))
                {
                    $attachement = $post['attachment'];
                    unset($post['attachment']);
                }
                $post['userId'] = $userId;
                if(isset($post['ifMicRequired']) && myIsArray($post['ifMicRequired']))
                {
                    $post['ifMicRequired'] = $post['ifMicRequired'][0];
                }
                if(isset($post['ifProjectorRequired']) && myIsArray($post['ifProjectorRequired']))
                {
                    $post['ifProjectorRequired'] = $post['ifProjectorRequired'][0];
                }
                $post['startTime'] = date('H:i', strtotime($post['startTime']));
                $post['endTime'] = date('H:i', strtotime($post['endTime']));
                $eveSlug = slugify($post['eventName']);
                $post['eventSlug'] = $eveSlug;
                $post['eventShareLink'] = base_url().'?page/events/'.$eveSlug;
                $post['shortUrl'] = null;
                $eventId = $this->dashboard_model->saveEventRecord($post);

                // Adding event slug to new table
                $newSlugTab = array(
                    'eventId' => $eventId,
                    'eventSlug' => $eveSlug,
                    'insertedDateTime' => date('Y-m-d H:i:s')
                );
                $this->dashboard_model->saveEventSlug($newSlugTab);

                $shortDWName = $this->googleurlapi->shorten(base_url().'?page/events/'.$eveSlug);
                if($shortDWName !== false)
                {
                    $details['shortUrl'] = $shortDWName;
                    $this->dashboard_model->updateEventRecord($details,$eventId);
                }

                //Saving attachments
                $img_names = array();
                if(isset($attachement))
                {
                    $img_names = explode(',',$attachement);
                    for($i=0;$i<count($img_names);$i++)
                    {
                        $attArr = array(
                            'eventId' => $eventId,
                            'filename'=> $img_names[$i],
                            'attachmentType' => '1'
                        );
                        $this->dashboard_model->saveEventAttachment($attArr);
                    }
                }

                //Sending mail
                $mailEvent= array(
                    'creatorName' => $post['creatorName'],
                    'creatorEmail' => $post['creatorEmail'],
                    'eventName' => $post['eventName'],
                    'eventPlace' => $post['eventPlace']
                );
                $loc = $this->locations_model->getLocationDetailsById($post['eventPlace']);
                $mailVerify = $this->dashboard_model->getEventById($eventId);
                $mailVerify[0]['locData'] = $loc['locData'];
                $mailVerify[0]['attachment'] = $img_names[0];
                $mailVerify['isEventExists'] = $isEventExists['status'];
                $mailVerify['eveNames'] = $existEveNames;
                $this->sendemail_library->newEventMail($mailEvent);
                $this->sendemail_library->eventVerifyMail($mailVerify);
                $data['status'] = true;
                //creating a session for user
                $this->login_model->setLastLogin($userId);
                $this->generalfunction_library->setMobUserSession($userId);
                echo json_encode($data);
            }
            else
            {
                $data['status'] = FALSE;
                $data['errorMsg'] = 'Error in Account Creation';
                echo json_encode($data);
            }
        }
        else // Event already exists
        {
            $data['status'] = FALSE;
            $data['errorMsg'] = 'Sorry, This time slot is already booked!';
            echo json_encode($data);
        }

    }

    public function updateEvent()
    {
        $this->load->model('login_model');
        $post = $this->input->post();
        $userId = '';
        $data = array();
        $impChanges = array('eventName','eventDescription','eventDate','startTime','endTime','costType',
            'eventPrice','eventPlace');
        $changeCheck = array();
        $changesMade = array();
        $changesRecord = array();

        if(isSessionVariableSet($this->userMobId))
        {
            $userId = $this->userMobId;
        }
        elseif(isset($post['userId']) && $post['userId'] != '')
        {
            $userId = $post['userId'];
        }
        else
        {
            $data['status'] = FALSE;
            $data['errorMsg'] = 'Error in Account Creation';
            echo json_encode($data);
        }
        if(isStringSet($userId))
        {
            $eventOldInfo = $this->dashboard_model->getFullEventInfoById($post['eventId']);
            //Save event
            //$oldAttach = $this->dashboard_model->getEventAttById($post['eventId']);
            if(isset($post['attachment']))
            {
                if($eventOldInfo[0]['filename'] != $post['attachment'])
                {
                    $changesMade['attachment'] = $eventOldInfo[0]['filename'].';#;'.$post['attachment'];
                }
                $attachement = $post['attachment'];
                unset($post['attachment']);
            }
            if(isset($post['ifMicRequired']) && myIsArray($post['ifMicRequired']))
            {
                $post['ifMicRequired'] = $post['ifMicRequired'][0];
            }
            if(isset($post['ifProjectorRequired']) && myIsArray($post['ifProjectorRequired']))
            {
                $post['ifProjectorRequired'] = $post['ifProjectorRequired'][0];
            }
            $post['startTime'] = date('H:i', strtotime($post['startTime']));
            $post['endTime'] = date('H:i', strtotime($post['endTime']));
            $eventOldInfo = $eventOldInfo[0];
            foreach($eventOldInfo as $key => $row)
            {
                if(isset($post[$key]))
                {
                    if($post[$key] != $row)
                    {
                        if(myInArray($key,$impChanges))
                        {
                            $changeCheck[] = $key;
                            $changesRecord[$key] = $row;
                        }
                        if($key == 'eventPlace')
                        {
                            $oldLoc = $this->locations_model->getLocationDetailsById($row);
                            $newLoc = $this->locations_model->getLocationDetailsById($post[$key]);
                            $changesMade[$key] = $oldLoc['locData'][0]['locName'].';#;'.$newLoc['locData'][0]['locName'];
                        }
                        else
                        {
                            $changesMade[$key] = $row.';#;'.$post[$key];
                        }
                    }
                }
            }

            if(myIsArray($changesMade))
            {
                //Creating new Instamojo link also
                /*if(isset($eventOldInfo['instaSlug']) && isStringSet($eventOldInfo['instaSlug']))
                {
                    //Deleting old link
                    $this->curl_library->archiveInstaLink($eventOldInfo['instaSlug']);
                }*/
                //Get location info
                //$locInfo = $this->locations_model->getLocationDetailsById($post['eventPlace']);

                // Getting image upload url from api;
                //$instaImgLink = $this->curl_library->getInstaImageLink();
                //$donePost = array();
                /*if($instaImgLink['success'] === TRUE)
                {
                    if(isset($attachement) && isStringSet($attachement))
                    {
                        $coverImg =  $this->curl_library->uploadInstaImage($instaImgLink['upload_url'],$attachement);
                    }
                    else
                    {
                        $coverImg =  $this->curl_library->uploadInstaImage($instaImgLink['upload_url'],$eventOldInfo['filename']);
                    }
                    if(isset($coverImg) && myIsMultiArray($coverImg) && isset($coverImg['url']))
                    {
                        $postData = array(
                            'title' => $post['eventName'],
                            'description' => $post['eventDescription'],
                            'currency' => 'INR',
                            'base_price' => $post['eventPrice'],
                            'start_date' => $post['eventDate'].' '.date("H:i", strtotime($post['startTime'])),
                            'end_date' => $post['eventDate'].' '.date("H:i", strtotime($post['endTime'])),
                            'venue' => $locInfo['locData'][0]['locName'].', Doolally Taproom',
                            'redirect_url' => MOBILE_URL.'?event='.$post['eventId'].'&hash='.encrypt_data('EV-'.$post['eventId']),
                            'cover_image_json' => json_encode($coverImg),
                            'timezone' => 'Asia/Kolkata'
                        );
                        $donePost = $this->curl_library->createInstaLink($postData);
                    }
                }
                if(!myIsMultiArray($donePost)) //Creating event without image
                {
                    if($post['costType'] == EVENT_FREE)
                    {
                        $postData = array(
                            'title' => $post['eventName'],
                            'description' => $post['eventDescription'],
                            'currency' => 'INR',
                            'base_price' => '0',
                            'start_date' => $post['eventDate'].' '.date("H:i", strtotime($post['startTime'])),
                            'end_date' => $post['eventDate'].' '.date("H:i", strtotime($post['endTime'])),
                            'venue' => $locInfo['locData'][0]['locName'].', Doolally Taproom',
                            'redirect_url' => MOBILE_URL.'?event='.$post['eventId'].'&hash='.encrypt_data('EV-'.$post['eventId']),
                            'timezone' => 'Asia/Kolkata'
                        );
                    }
                    else
                    {
                        $postData = array(
                            'title' => $post['eventName'],
                            'description' => $post['eventDescription'],
                            'currency' => 'INR',
                            'base_price' => $post['eventPrice'],
                            'start_date' => $post['eventDate'].' '.date("H:i", strtotime($post['startTime'])),
                            'end_date' => $post['eventDate'].' '.date("H:i", strtotime($post['endTime'])),
                            'venue' => $locInfo['locData'][0]['locName'].', Doolally Taproom',
                            'redirect_url' => MOBILE_URL.'?event='.$post['eventId'].'&hash='.encrypt_data('EV-'.$post['eventId']),
                            'timezone' => 'Asia/Kolkata'
                        );
                    }
                    $donePost = $this->curl_library->createInstaLink($postData);
                }*/

                /*if(isset($donePost['link']))
                {
                    if(isset($donePost['link']['shorturl']))
                    {
                        $post['eventPaymentLink'] = $donePost['link']['shorturl'];
                        $post['instaSlug'] = $donePost['link']['slug'];
                    }
                    else
                    {
                        $post['eventPaymentLink'] = $donePost['link']['url'];
                        $post['instaSlug'] = $donePost['link']['slug'];
                    }
                }*/

                if(myInArray('eventName', $changeCheck))
                {
                    $eveSlug = slugify($post['eventName']);
                    $post['eventSlug'] = $eveSlug;
                    $post['eventShareLink'] = base_url().'?page/events/'.$eveSlug;
                    $post['shortUrl'] = null;

                    // Adding event slug to new table
                    $newSlugTab = array(
                        'eventId' => $post['eventId'],
                        'eventSlug' => $eveSlug,
                        'insertedDateTime' => date('Y-m-d H:i:s')
                    );
                    $this->dashboard_model->saveEventSlug($newSlugTab);
                    $shortDWName = $this->googleurlapi->shorten(base_url().'?page/events/'.$eveSlug);
                    if($shortDWName !== FALSE)
                    {
                        $post['shortUrl'] = $shortDWName;
                    }
                }

                $post['ifActive'] = '0';
                $post['ifApproved'] = '0';
                $this->dashboard_model->updateEventRecord($post,$post['eventId']);

                $img_names = array();
                if(isset($attachement))
                {
                    $img_names = explode(',',$attachement);
                    for($i=0;$i<count($img_names);$i++)
                    {
                        $attArr = array(
                            'filename'=> $img_names[$i],
                        );
                        $this->dashboard_model->updateEventAttachment($attArr,$post['eventId']);
                    }
                }

                $mailVerify = $changesMade;
                $mailVerify['eventId'] = $post['eventId'];
                $commPlace = $eventOldInfo['eventPlace'];
                $this->sendemail_library->eventEditMail($mailVerify,$commPlace);

                $changesRecord['eventId'] = $post['eventId'];
                $changesRecord['fromWhere'] = 'Host';
                $changesRecord['insertedDT'] = date('Y-m-d H:i:s');
                $changesRecord['isPending'] = 0;

                $this->dashboard_model->saveEventChangeRecord($changesRecord);

                //Pause Event listing on EventsHigh and Meetup
                $meetupRecord = $this->dashboard_model->getMeetupRecord($post['eventId']);
                if(isset($meetupRecord) && myIsArray($meetupRecord))
                {
                    $meetupResponse = $this->meetMeUp($meetupRecord['meetupId']);
                }

                //Checking any eventsHigh record in DB for corresponding event
                $eventHighRecord = $this->dashboard_model->getEventHighRecord($post['eventId']);
                if(isset($eventHighRecord) && myIsArray($eventHighRecord))
                {
                    $this->curl_library->disableEventsHigh($eventHighRecord['highId']);
                }

                $data['status'] = TRUE;
            }
            else
            {
                $data['status'] = TRUE;
                $data['noChange'] = TRUE;
            }

            echo json_encode($data);
        }

    }

    public function meetMeUp($meetupId = '')
    {
        $meetData = array();

        //Meetup Event On Pause
        try
        {
            $meetUpPost = array(
                'announce' => false
            );
            $meetupCreate = $this->meetup->updateEvent($meetUpPost,$meetupId);
            $meetData['status'] = true;

        }
        catch(Exception $ex)
        {
            $meetData['status'] = false;
            $meetData['errorMsg'] = $ex->getMessage();
            $this->saveAPIError($ex->getMessage(),'Meetup');
        }

        return $meetData;
    }

    public function saveAPIError($errorText,$fromWhere)
    {
        $data['fromWhere'] = $fromWhere;
        $data['errorTxt'] = $errorText;
        $this->dashboard_model->saveAPIErrorLog($data);
        return true;
    }

    public function getMoreFeeds($postCount)
    {
        $data = array();
        $topCount = array();
        if($postCount == 1)
        {
            $topCount = $this->cron_model->getTopFeedCount();
            $allFeeds = $this->cron_model->getMoreLatestFeeds($postCount);
            if(isset($topCount['postsCount']) && $topCount['postsCount'] < 145)
            {
                $newFeeds = json_decode($allFeeds['feedText'], TRUE);
                $finalFeeds = array_slice($newFeeds,(count($newFeeds) - $topCount['postsCount']),count($newFeeds));
            }
            else
            {
                $finalFeeds = json_decode($allFeeds['feedText'],TRUE);
            }
            if(myIsArray($finalFeeds))
            {
                $data['status'] = TRUE;
                $data['moreFeeds'] = $finalFeeds;
            }
            else
            {
                $data['status'] = FALSE;
            }
        }
        else
        {
            $allFeeds = $this->cron_model->getMoreLatestFeeds($postCount);

            if(myIsArray($allFeeds))
            {
                $data['status'] = TRUE;
                $data['moreFeeds'] = json_decode($allFeeds['feedText'],TRUE);
            }
            else
            {
                $data['status'] = FALSE;
            }
        }

        echo json_encode($data);

    }
    public function returnAllFeeds($responseType = RESPONSE_RETURN)
    {
        $myFeeds = $this->cron_model->getAllSortedFeeds();

        $newfeeds = array();

        if(isset($myFeeds) && myIsMultiArray($myFeeds))
        {
            $newfeeds = $myFeeds;//  json_decode($myFeeds[0]['feedText'], true);
        }
        /*$feedData = $this->cron_model->getAllFeeds();
        $facebook = array();
        $twitter = array();
        $instagram = array();

        $allFeeds = null;

        if($feedData['status'] === true)
        {
            foreach($feedData['feedData'] as $key => $row)
            {
                switch($row['feedType'])
                {
                    case "1":
                        $facebook = json_decode($row['feedText'],true);
                        break;
                    case "2":
                        $twitter = json_decode($row['feedText'],true);
                        break;
                    case "3":
                        $instagram  = json_decode($row['feedText'],true);
                        break;
                }
            }

            $allFeeds = $this->sortNjoin($twitter,$instagram, $facebook);
        }*/

        //die();
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($newfeeds);
        }
        else
        {
            return $newfeeds;
        }
    }

    function sortNjoin($arr1 = array(), $arr2 = array(), $arr3 = array())
    {
        $all = array();
        $arrs[] = $arr1;
        $arrs[] = $arr2;
        $arrs[] = $arr3;
        foreach($arrs as $arr) {
            if(is_array($arr)) {
                $all = array_merge($all, $arr);
            }
        }
        //$all = array_merge($arr1, $arr2,$arr3);

        $sortedArray = array_map(function($fb) {
            $arr = $fb;
            if(isset($arr['updated_time']))
            {
                $arr['socialType'] = 'f';
                $arr['created_at'] = $arr['updated_time'];
                unset($arr['updated_time']);
            }
            elseif (isset($arr['external_created_at']))
            {
                $arr['socialType'] = 'i';
                $arr['created_at'] = $arr['external_created_at'];
                unset($arr['external_created_at']);
            }
            elseif (isset($arr['created_at']))
            {
                $arr['socialType'] = 't';
            }
            return $arr;
        },$all);

        usort($sortedArray,
            function($a, $b) {
                $ts_a = strtotime($a['created_at']);
                $ts_b = strtotime($b['created_at']);

                return $ts_a < $ts_b;
            }
        );
        return $sortedArray;

    }

    public function renderLink()
    {
        $this->load->library('OpenGraph');
        $post = $this->input->post();
        $graph = OpenGraph::fetch($post['url']);
        $array = array();

        foreach($graph as $key => $value) {
            $array[$key] = $value;
        }

        echo json_encode($array);
    }

    public function checkPublicUser($email, $mob)
    {
        $uData = array();
        $userExists = $this->users_model->checkUserDetails($email, $mob);

        if($userExists['status'] === TRUE)
        {
            $uData['status'] = FALSE;
            $uData['userData'] = $userExists['userData'];
        }
        else
        {
            $uData['status'] = TRUE;
        }
        return $uData;
    }

    public function newMugForm()
    {
        $data = array();

        $data['locData'] = $this->locations_model->getAllLocations();

        $data['desktopStyle'] = $this->dataformatinghtml_library->getDesktopStyleHtml($data);
        $data['desktopJs'] = $this->dataformatinghtml_library->getDesktopJsHtml($data);

        $this->load->view('NewMugMemberView', $data);
    }

    public function verifyMember()
    {
        $data = array();
        $post = $this->input->post();

        if(isset($post['mugId']))
        {
            $firstName = $post['firstName'];
            $lastName= $post['lastName'];
            $mugTag = '';
            if(isset($post['tagName']))
            {
                $mugTag = $post['tagName'];
            }

            $instaDetails = array(
                'amount' => '3000',
                'purpose' => 'New Mug #'.$post['mugId'],
                'buyer_name' => $firstName.' '.$lastName,
                'email' => $post['email'],
                'phone' => $post['mobNum'],
                'send_email' => true,
                'send_sms' => true,
                'allow_repeated_payments' => false,
                'redirect_url' => base_url().'thank-you',
            );
            $linkGot = $this->curl_library->createInstaMugLink($instaDetails);

            if(myIsArray($linkGot) && $linkGot['success'] === true)
            {
                if(isset($linkGot['payment_request']['id']))
                {
                    $payReqId = $linkGot['payment_request']['id'];
                    $payReqUrl = $linkGot['payment_request']['longurl'].'?embed=form';

                    $details = array(
                        'mugId' => $post['mugId'],
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'emailId' => $post['email'],
                        'mobileNo' => $post['mobNum'],
                        'homeBase' => $post['homebase'],
                        'mugTag' => $mugTag,
                        'birthDate' => date('Y-m-d',strtotime($post['dob'])),
                        'invoiceDate' => date('Y-m-d'),
                        'invoiceAmt' => '3000.00',
                        'paymentId' => $payReqId,
                        'status' => '0',
                        'isApproved' => '0',
                        'insertedDT' => date('Y-m-d H:i:s')
                    );

                    $this->dashboard_model->saveInstamojoMug($details);

                    $data['status'] = true;
                    $data['payUrl'] = $payReqUrl;
                }
                else
                {
                    $data['status'] = false;
                    $data['errorMsg'] = "Error Connecting To Payment Server";
                }
            }
            else
            {
                $data['status'] = false;
                $data['errorMsg'] = "Error Connecting To Payment Server";
            }

        }
        else
        {
            $data['status'] = false;
            $data['errorMsg'] = "All Fields Are Required!";
        }

        echo json_encode($data);
    }
    public function thankYouMug()
    {
        $data = array();
        $get = $this->input->get();
        if(isset($get['payment_request_id']))
        {
            $instaRecord = $this->dashboard_model->getMugInstaByReqId($get['payment_request_id']);
            if(isset($instaRecord) && myIsArray($instaRecord))
            {
                $details = array(
                    'invoiceNo' => $get['payment_id'],
                    'status' => '1'
                );
                $this->dashboard_model->updateInstaMug($details,$instaRecord['id']);
            }
        }

        $data['desktopStyle'] = $this->dataformatinghtml_library->getDesktopStyleHtml($data);
        $data['desktopJs'] = $this->dataformatinghtml_library->getDesktopJsHtml($data);

        $this->load->view('ThankYouMemberView', $data);
    }

    function getAllUnusedMugs($mugId, $op, $searchCap, $holdMugs = array())
    {
        $rangeEnd = $mugId + $searchCap;

        switch($op)
        {
            case 'plus':
                $rangeEnd = $mugId + $searchCap;
                if($rangeEnd > 9998)
                {
                    $rangeEnd = $mugId - $searchCap;
                }
                break;
            case 'minus':
                $rangeEnd = $mugId - $searchCap;
                if($rangeEnd < 0)
                {
                    $rangeEnd = $mugId + $searchCap;
                }
                break;
        }

        $result = $this->mugclub_model->getMugRange($mugId, $rangeEnd);

        $allMugs = range(($mugId-$searchCap),$mugId);
        switch($op)
        {
            case 'plus':
                $allMugs = range($mugId,($mugId+$searchCap));
                if(($mugId+$searchCap) > 9998)
                {
                    $allMugs = range(($mugId-$searchCap),$mugId);
                }
                break;
            case 'minus':
                $allMugs = range(($mugId-$searchCap),$mugId);
                if(($mugId-$searchCap) < 0)
                {
                    $allMugs = range($mugId,($mugId+$searchCap));
                }
                break;
        }

        if(myIsArray($result))
        {
            $availMugs = array_diff($allMugs, $result);
        }
        else
        {
            $availMugs = $allMugs;
        }

        $availMugs = array_values($availMugs);
        $blockedNums = range(0,100);
        $availMugs = array_diff($availMugs,$blockedNums);
        if(myIsMultiArray($holdMugs))
        {
            //$holdMugs['mugList'] = array_merge($holdMugs['mugList'],$blockedNums);
            foreach($holdMugs['mugList'] as $key => $row)
            {
                $aKey = array_search($row['mugId'],$availMugs);
                if($aKey)
                {
                    unset($availMugs[$aKey]);
                }
            }
        }

        return $availMugs;
    }

    public function MugAvailability($mugid)
    {
        $data = array();
        $op = 'minus';
        //Initial search Capping limit
        $searchCap = 50;
        $opFlag = 1;
        if(!in_array($mugid,range(0,100)))
        {
            //Getting mug number data if exists
            $result = $this->mugclub_model->getMugDataById($mugid);
            // Mug Data exists
            if($result['status'] === true)
            {
                $holdMugs = $this->mugclub_model->getAllMugHolds();
                $mugResult = $this->getAllUnusedMugs($mugid, $op, $searchCap, $holdMugs);
                if(count($mugResult) < 1)
                {
                    while(count($mugResult) < 1 && $searchCap != 500)
                    {
                        if($opFlag == 1)
                        {
                            $opFlag = 2;
                            $op = 'minus';
                        }
                        else
                        {
                            $opFlag = 1;
                            $op = 'plus';
                            $searchCap += 50;
                        }

                        $mugResult = $this->getAllUnusedMugs($mugid, $op, $searchCap,$holdMugs);
                    }
                    $data['availMugs'] = $mugResult;
                }
                else
                {
                    $data['availMugs'] = $mugResult;
                }

                $data['status'] = false;
                $data['errorMsg'] = 'Mug Number Already Exists';
            }
            else // Mug Data not found
            {
                //Check if mug number is not on hold
                $holdMug = $this->mugclub_model->getMugHoldById($mugid);
                if($holdMug['status'] === true) //Mug Number on hold search new
                {
                    $mugResult = $this->getAllUnusedMugs($mugid, $op, $searchCap, array($mugid));
                    if(count($mugResult) < 1)
                    {
                        while(count($mugResult) < 1 && $searchCap != 500)
                        {
                            if($opFlag == 1)
                            {
                                $opFlag = 2;
                                $op = 'minus';
                            }
                            else
                            {
                                $opFlag = 1;
                                $op = 'plus';
                                $searchCap += 50;
                            }

                            $mugResult = $this->getAllUnusedMugs($mugid, $op, $searchCap, array($mugid));
                        }
                        $data['availMugs'] = $mugResult;
                    }
                    else
                    {
                        $data['availMugs'] = $mugResult;
                    }

                    $data['status'] = false;
                    $data['errorMsg'] = 'Mug Number Already Exists';
                }
                else // Mug Not on hold and available
                {
                    $data['status'] = true;
                }
            }
        }
        else
        {
            $data['status'] = false;
            $data['errorMsg'] = 'Mug Number Not Available';
        }

        echo json_encode($data);
    }

    public function filterEvents($locName)
    {
        $data = array();

        $locData = $this->locations_model->checkForValidLoc($locName);
        if(isset($locData) && myIsArray($locData))
        {
            $data['status'] = true;
            $data['locId'] = $locData['id'];
        }
        else
        {
            $data['status'] = false;
        }

        echo json_encode($data);

    }
    public function getEventPage()
    {
        $data = array();
        $post = $this->input->post();

        if(isset($post['isAjax']) && $post['isAjax'] == '1')
        {
            $events = $this->dashboard_model->getAllApprovedEvents();
            usort($events,
                function($a, $b) {
                    $ts_a = strtotime($a['eventDate']);
                    $ts_b = strtotime($b['eventDate']);

                    return $ts_a > $ts_b;
                }
            );

            $data['eventDetails'] = $events;
            $aboutView = $this->load->view('desktop/EventsPageView', $data);
            echo json_encode($aboutView);
        }
        else
        {
            redirect(base_url().'?page/events');
        }

    }

    public function getFnbPage()
    {
        $data = array();
        $post = $this->input->post();

        $data['fnbItems'] = $this->dashboard_model->getAllActiveFnB();

        if(isset($post['isAjax']) && $post['isAjax'] == '1')
        {
            $aboutView = $this->load->view('desktop/FnbPageView', $data);
            echo json_encode($aboutView);
        }
        else
        {
            redirect(base_url());
        }
    }
    public function saveErrorLog()
    {
        $post = $this->input->post();

        if(isset($post['errorTxt']))
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $post['refUrl'] = $_SERVER['HTTP_REFERER'];
            }
            $this->dashboard_model->saveErrorLog($post);
        }
        return true;
    }

    public function saveMusicSearch()
    {
        $post = $this->input->post();

        if(isset($post['searchText']))
        {
            $musicData = array(
                'searchText' => $post['searchText'],
                'taproomId' => $post['tapId'],
                'fromWhere' => $post['fromWhere'],
                'userEmail' => $this->userMobEmail,
                'insertedDateTime' => date('Y-m-d H:i:s')
            );
            $this->dashboard_model->saveMusicSearch($musicData);
        }
    }
}
