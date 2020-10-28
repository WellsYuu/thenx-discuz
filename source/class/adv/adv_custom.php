<?php
/*
 *
 *  * Copyright 2012-2020 the original author or authors.
 *  *
 *  * Licensed under the Apache License, Version 2.0 (the "License");
 *  * you may not use this file except in compliance with the License.
 *  * You may obtain a copy of the License at
 *  *
 *  *      https://www.apache.org/licenses/LICENSE-2.0
 *  *
 *  * Unless required by applicable law or agreed to in writing, software
 *  * distributed under the License is distributed on an "AS IS" BASIS,
 *  * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  * See the License for the specific language governing permissions and
 *  * limitations under the License.
 *
 */

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: adv_custom.php 29605 2012-04-23 02:27:52Z liulanbo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class adv_custom {

	var $version = '1.0';
	var $name = 'custom_name';
	var $description = 'custom_desc';
	var $copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';
	var $targets = array('portal', 'home', 'member', 'forum', 'group', 'plugin', 'api');
	var $imagesizes = array('60x120', '60x250', '60x468', '120x60', '120x240', '120x60', '250x60', '100x100', '468x40', '468x60', '658x60', '728x90', '760x90', '950x90', '950x130');
	var $customname = '';

	function getsetting() {
		global $_G;
		$custom = C::t('common_advertisement_custom')->fetch($_GET['customid']);
		if(!$custom) {
			echo '<br >';cpmsg(lang('adv/custom', 'custom_id_notfound'));
		}
		$this->customname = $custom['name'];
	}

	function setsetting(&$advnew, &$parameters) {
		global $_G;
		$advnew['targets'] = implode("\t", $this->targets);
	}

	function evalcode($adv) {
		return array(
			'check' => '
			if($customid != $parameter[\'customid\']) {
				$checked = false;
			}',
			'create' => '$adcode = $codes[$adids[array_rand($adids)]];',
		);
	}

}

?>