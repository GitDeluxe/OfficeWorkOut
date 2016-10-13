<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
class DefaultController extends Controller
{


	public $client_id;
	public $client_secret;
	public $api_url;
	public $redirect_url;
	public $oauth_url;

	public function __construct
	(
			$client_id = 'jUetU3LgR7d5KxnBeWUvL8ZYx70suSsJ', #Client ID, get this by creating an app
			$client_secret = '65Wgq1qa8ABZn960Fr37gJVOBSPms5OIhD0115dTdNlFZ6f2Jto75KYFP71jK984', #Client Secret, get this by creating an app
			$redirect_url = '', #Callback URL for getting an access token
			$oauth_url = 'https://api.moves-app.com/oauth/v1/', $api_url = 'https://api.moves-app.com/api/1.1'
			) {
		$this->api_url = $api_url;
		$this->oauth_url = $oauth_url;
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->redirect_url = $redirect_url;
	}

    

    		#Validate access token
	public function validate_token($token) {
		$u = $this->oauth_url . 'tokeninfo?access_token=' . $token;
		$r = $this->get_http_response_code($u);
		if ($r === "200") {
			return json_decode($this->geturl($u), true);
		} else {
			return false;
		}
	}

		#Get access_token
	public function auth($request_token) {
		return $this->auth_refresh($request_token, "authorization_code");
	}

                #Refresh access_token

	public function refresh($refresh_token) {
		return $this->auth_refresh($refresh_token, "refresh_token");
	}

	private function auth_refresh($token, $type) {
		$u = $this->oauth_url . "access_token";
		$d = array('grant_type' => $type, 'client_id' => $this->client_id, 'client_secret' => $this->client_secret);
		if ($type === "authorization_code") {
			$d['code'] = $token;
			$d['redirect_uri'] = $this->redirect_url;
		} elseif ($type === "refresh_token") {
			$d['refresh_token'] = $token;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $u);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($d));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$token = json_decode($result, True);
		return array('access_token' => $token['access_token'], 'refresh_token' => $token['refresh_token']);
	}



                #Base request
	protected function get_info($parameters, $endpoint) {
		return json_decode($this->geturl($this->api_url . $endpoint . '?' . http_build_query($parameters)), true);
	}

		#/user/profile
	public function get_profile($token) {
		$root = '/user/profile';
		return $this->get_info(array('access_token' => $token), $root);
	}


		#Range requests
		#/user/summary/daily
		#/user/activities/daily
		#/user/places/daily
		#/user/storyline/daily
		#date: date in yyyyMMdd or yyyy-MM-dd format
	public function get_range($access_token, $endpoint, $start, $end, $otherParameters = array()) {
		$requiredParameters = array(
			'access_token' => $access_token,
			'from'         => $start,
			'to'           => $end
			);
		$parameters = array_merge($requiredParameters, $otherParameters);
		return $this->get_info($parameters, $endpoint);
	}

	private function get_http_response_code($url) {
		$headers = get_headers($url);
		return substr($headers[0], 9, 3);
	}

	private function geturl($url) {
		$session = curl_init($url);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($session);
		curl_close($session);
		return $data;
	}
	public function configAction()
	{
		//Set client_id provided when you registered your Moves Apps
		$client_id = "jUetU3LgR7d5KxnBeWUvL8ZYx70suSsJ";
    	//Set client_secret provided when you registered your Moves Apps
		$client_secret = "65Wgq1qa8ABZn960Fr37gJVOBSPms5OIhD0115dTdNlFZ6f2Jto75KYFP71jK984";
    	//Set your redirect url. For this demo it would be http://your-url/example/test.php  
    	//This is overridden by the url set for the App on the moves api interface
		$redirect_url = "http://www.officeworkout.fr/moves/test.php "; 

		$m = array('client_id '=> $client_id, 'client_secret' => $client_secret, 'redirect_url' => $redirect_url);

		return $m;
	}




	public function requestToken()
	{


		if (isset($_GET['code'])) {
			$request_token = $_GET['code'];
			$tokens = $this->auth($request_token);
		    //Save this token for all future request for this user
			$access_token = $tokens['access_token'];
		    //Save this token for refeshing the token in the future
			$refresh_token = $tokens['refresh_token'];
			$profile = json_encode($this>get_profile($access_token));
			return $profile;
		}else{return 0;}


	}
    #Generate an request URL
	public function requestURL() {
		$u = $this->oauth_url . 'authorize?response_type=code';
		$c = '&client_id=' . urlencode($this->client_id);
		$r = '&redirect_uri=' . urlencode($this->redirect_url);
			$s = '&scope=' . urlencode('activity location'); # Assuming we want both activity and locations
			$url = $u . $c . $s . $r;
			return $url;
		}

		#public function indexAction()
		#{
		#	$config = $this->configAction();
		#	echo $config;
		#	$requestURL = $this->requestURL();
		#	echo $requestURL;
		#	return $this->render('MovesBundle:Default:index.html.twig',array('requestURL' => $requestURL));
		#}

		public function profile($token) {
		$root = '/user/profile';
		return $this->get_info(array('access_token' => $token), $root);
		}

		public function dailySummary($token)
		{
			$root = "user/summary/daily";
			return $this->get_info(array('access_token' => $token), $root);
		}
		public function dailyActivities($token)
		{
			$root = "user/activities/daily";	
			return $this->get_info(array('access_token' => $token), $root);
		}
		public function dailyPlaces($token)
		{
			$root = "user/places/daily";
			return $this->get_info(array('access_token' => $token), $root);
		}
		public function dailyStoryline($token)
		{
			$root = "user/storyline/daily";
			return $this->get_info(array('access_token' => $token), $root);
		}




		public function indexAction($startup = "STARTUP",$prenom = "You", $requestURL = "okok")
    {

    	$config = $this->configAction();
			
		$requestURL = $this->requestURL();
		$profile = $this->requestToken();
		$date = date("Ymd");
		echo $date;
		echo $profile;
		echo $requestURL;



        return $this->render('HomeBundle:Default:index.html.twig',array('startup'=> $startup,'prenom'=>$prenom,'requestURL'=> $requestURL));
    }

}












