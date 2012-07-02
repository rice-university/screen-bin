<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');
App::import('Vendor', 'SimpleImage');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * Default helper
 *
 * @var array
 */
	public $helpers = array('Html', 'Session');

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Screenshot');

	private $hash_length = 5;

	private function getUploadDirectory() {
		return 'screenshots';
	}

	private function generateScreenshotHash() {
		return $this->gen_hash_with_length(null, null, $this->hash_length);
	}

	public function home() {
		$os = env('HTTP_USER_AGENT');

		$mac = strpos($os, 'Macintosh') ? true : false;
		$win = strpos($os, 'Windows') ? true : false;

		$instruction_1 = 'Take a screenshot.';
		$instruction_2 = 'Paste.';

		if ($mac) {
			$instruction_1 = 'Ctrl+Shift+Cmd+3.';
			$instruction_2 = 'Cmd+V.';
		} else if ($win) {
			$instruction_2 = 'Ctrl+V.';
		}

		$this->set('instruction_1', $instruction_1);
		$this->set('instruction_2', $instruction_2);

		$url = $this->here;
		if($url == '/') {
			$this->set('title_for_layout', 'Screen Bin');
			$this->layout = 'home';
		} else {
			$screenshot_hash = substr($url, 1, strlen($url));
			if(strlen($screenshot_hash) != $this->hash_length) {
				$this->redirect(array('controller' => 'pages', 'action' => 'home'));
			} else {
				$screenshotsQueryResult = $this->Screenshot->getScreenshot($screenshot_hash);
				if(count($screenshotsQueryResult) == 0) {
					$this->redirect(array('controller' => 'pages', 'action' => 'home'));
				} else {
					$screenshot = $screenshotsQueryResult[0];
					$screenshot_amazon_url = $screenshot['Screenshot']['storage_url'];
					$this->set('title_for_layout', 'Screen Bin');
					$this->set('screenshot_hash', $screenshot_hash);
					$this->set('screenshot_amazon_url', $screenshot_amazon_url);
					$this->layout = 'share';
				}
			}
		}
	}

	public function apiUploadScreenshot() {
		if ($this->request->isPost()) {
			$this->autoRender = false;

			$tmp_url = $this->data['Post']['file']['tmp_name'];
			$screenshot_hash = $this->generateScreenshotHash();
			$destination_path_and_filename = $this->getUploadDirectory().DS.$screenshot_hash;

			//upload photo to amazon s3
			$this->verifyDestination($destination_path_and_filename);
    		$this->saveScreenshot($tmp_url, $destination_path_and_filename);

    		//format uploaded amazon s3 url
    		$amazon_bucket_url = 'https://s3.amazonaws.com/'.'screenbin';
			$screenshot_url_amazon = $amazon_bucket_url.DS.$this->getUploadDirectory().DS.$screenshot_hash;

    		//add photo to database
			$this->Screenshot->addScreenshot($screenshot_hash, $screenshot_url_amazon);

    		//create screenshot url
			$screenshot_url = 'scrnb.in'.DS.$screenshot_hash;

			$response_array = array(
				'screenshot_url' => $screenshot_url,
				'screenshot_hash' => $screenshot_hash,
				'amazon_url' => $screenshot_url_amazon
			);
			$this->response->body(json_encode($response_array));
		} else {
			$this->redirect("/");
		}
	}

	/*
	 * Creates the directory for the file if none exists
	 */
	private function verifyDestination($filepath) {
		if(!file_exists(dirname($filepath))) {
			mkdir(dirname($filepath), 0775, true);
		}
	}

	/*
	 * Uses SimpleImage vendor library to load and save the screenshot
	 */
	private function saveScreenshot($source, $dest) {
		$image = new SimpleImage();
	    $image->load($source);
	    //$image->save($dest);
	    $image->upload_to_amazon($source, $dest);
	    return true;
	}

	private function gen_hash_with_length($id = NULL, $salt = NULL, $length = NULL) {
	    $id = ($id == NULL) ? uniqid(hash("sha512",rand()), TRUE) : $id;
	    $code = hash("sha512", $id.$salt);
	    return $length == NULL ? $code : substr($code, 0, $length);
	}
}