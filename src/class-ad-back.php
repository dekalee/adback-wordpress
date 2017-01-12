<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back
 */

class Ad_Back_Generic {

	public function get_contents($url) {
		if(function_exists('curl_version')) {
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			$data = curl_exec($curl);
			curl_close($curl);
			return $data;
		} else {
			return @file_get_contents($url);
		}
	}

	public function post_contents($url, $fields, $header=array()) {
		$header[] = 'Content-Type: application/x-www-form-urlencoded';

		if(function_exists('curl_version')) {
			if(is_array($fields)) {
				//url-ify the data for the POST
				foreach($fields as $key=>$value) {
					$fields_string .= $key.'='.urlencode($value).'&';
				}
				rtrim($fields_string, '&');
			}

			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch, CURLOPT_URL, $url);
			if(is_array($fields)) {
				curl_setopt($ch, CURLOPT_POST, count($fields));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			} else {
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			}
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
		} else {
			$options = array(
				'http' => array(
					'header'  => implode("\r\n", $header),
					'method'  => 'POST',
					'content' => is_array($fields) ? http_build_query($fields) : $fields
				)
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
		}

		return $result;
	}

	public function getMe() {
		global $wpdb; // this is how you get access to the database

		$token = $this->getToken();
		$json = $this->get_contents("https://adback.co/api/me?access_token=".$token->access_token);

		$me = json_decode($json, true);
		
		return $me;
	}

	public function getMyInfo() {
		global $wpdb; // this is how you get access to the database


		$table_name = $wpdb->prefix . 'adback_myinfo';
		$myinfo = $wpdb->get_row( "SELECT * FROM ".$table_name." WHERE id = 1" );

		if($myinfo->myinfo == "" || strtotime($myinfo->update_time) <  (time()-86400)) {

			$me = $this->getMe();
			$location = $this->getSlug();

			$mysite = null;
			if(is_array($me) && array_key_exists("sites", $me)) {
				foreach($me['sites'] as $site) {
					if(strtolower($site['slug']) == $location) {
						$mysite = $site;
						break;
					}
				}

				if($mysite == null) {
					$mysite = $me['sites'][0];
				}

				if($myinfo->myinfo == "" || strtotime($myinfo->update_time) <  (time()-86400)) {
					$wpdb->update(
						$table_name,
						array(
							'myinfo'=>json_encode($mysite),
							'update_time'=>current_time('mysql', 1)
						),
						array("id"=>1)
					);
				}
			} else if($myinfo->myinfo != "") {
				$mysite = json_decode($myinfo->myinfo, true);
			}
		} else {
			$mysite = json_decode($myinfo->myinfo, true);
		}

		return $mysite;
	}

	public function getCacheMessages() {
		global $wpdb; // this is how you get access to the database
		
		$table_name = $wpdb->prefix . 'adback_message';
		return stripslashes_deep($wpdb->get_row( "SELECT * FROM ".$table_name." WHERE id = 1" ));
	}

	public function saveCacheMessage($display, $message, $header_text, $close_text, $link = "") {
		global $wpdb; // this is how you get access to the database

		$fields = array(
			"message" => $message,
			"header_text" => $header_text,
			"close_text" => $close_text,
			"display" => filter_var($display, FILTER_VALIDATE_BOOLEAN),
			"update_time" => current_time('mysql', 1)
		);

		if($link != "") {
			$fields['link'] = $link;
		}

		$table_name = $wpdb->prefix . 'adback_message';
		$wpdb->update(
			$table_name, 
			$fields,
			array("id"=>1)
		);

	}

	public function getMessages() {
		global $wpdb; // this is how you get access to the database

		$token = $this->getToken();
		$url = "https://adback.co/api/custom-message?access_token=".$token->access_token."&site_slug=".$this->getSlug();

		$message = $this->getCacheMessages();
	
		$result = $this->get_contents($url);
		$result = json_decode($result, true);
		$result['display'] = $message->display;

		$this->saveCacheMessage($message->display, $result['custom_messages'][0]['message'], $result['custom_messages'][0]['header_text'], $result['custom_messages'][0]['close_text'], $result['custom_messages'][0]['links']['_self']);

		return stripslashes_deep($result);
	}

	public function saveMessage($display, $message, $header_text, $close_text) {
		$mess = $this->getCacheMessages();

		$token = $this->getToken();
		$url = $mess->link."?access_token=".$token->access_token;

		$fields = array(
			"message" => $message,
			"header_text" => $header_text,
			"close_text" => $close_text,
			"site_slug" => $this->getSlug()
 		);

 		$headers = array(
 			"Content-Type: application/json"
 		);

		$this->post_contents($url, json_encode($fields), $headers);

		$this->saveCacheMessage($display, $message, $header_text, $close_text);

		return true;
	}

	public function isConnected($token = null) {
		if($token == null) {
			$token = $this->getToken();
		}

		if(is_array($token)) {
			$token = (object)$token;
		}

		$url = "https://adback.co/api/test/normal?access_token=".$token->access_token;
		$result = json_decode($this->get_contents($url),true);
		return is_array($result) && array_key_exists("name", $result);
	}

	public function getToken() {
		global $wpdb; // this is how you get access to the database

		$table_name = $wpdb->prefix . 'adback_token';
		$token = $wpdb->get_row( "SELECT * FROM ".$table_name." WHERE id = 1" );
		if($token->access_token == "" || $token->refresh_token == "") {
			$token = (object)$this->askToken();
		} else if($this->isConnected($token) == false) {
			$token = (object)$this->askToken();
		}
		return $token;
	}

	public function askToken() {
		global $wpdb; // this is how you get access to the database

		$url = "https://adback.co/oauth/access_token?grant_type=bearer";
		$fields = array();
		$headers = array();

		$table_name = $wpdb->prefix . 'adback_account';

		$auth = $wpdb->get_row( "SELECT * FROM ".$table_name." WHERE id = 1" );
		if($auth->key != "" && $auth->secret != "") {
			$headers[] = "Authorization: Basic ".base64_encode($auth->key.":".$auth->secret);

			$result = json_decode($this->post_contents($url, $fields, $headers), true);

			$this->saveToken($result);
			
			return $result;
		}
		return null;
	}

	public function saveToken($token) {
		global $wpdb; // this is how you get access to the database

		if($token == null || array_key_exists("error", $token)) {
			return;
		}

		$table_name = $wpdb->prefix . 'adback_token';
		$wpdb->update(
			$table_name, 
			array(
				"access_token" => $token["access_token"],
				"refresh_token" => $token["refresh_token"]
			),
			array("id"=>1)
		);
	}

	public function saveSlug($slug) {
		global $wpdb; // this is how you get access to the database

		$table_name = $wpdb->prefix . 'adback_myinfo';
		$wpdb->update(
			$table_name, 
			array("slug"=>$slug),
			array("id"=>1)
		);
	}

	public function getSlug() {
		global $wpdb; // this is how you get access to the database

		$table_name = $wpdb->prefix . 'adback_myinfo';
		$myinfo = $wpdb->get_row( "SELECT slug FROM ".$table_name." WHERE id = 1" );
		return $myinfo->slug;
	}
}