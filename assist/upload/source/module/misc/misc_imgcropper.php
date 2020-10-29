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
 *      $Id: misc_imgcropper.php 36314 2016-12-19 08:02:23Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$_GET['img'] = htmlspecialchars($_GET['img']);
$_GET['bid'] = intval($_GET['bid']);
$_GET['picflag'] = intval($_GET['picflag']);
$_GET['ictype'] = !empty($_GET['ictype']) ? 'block' : '';
$_GET['width'] = intval($_GET['width']);
$_GET['height'] = intval($_GET['height']);

if(!submitcheck('imgcroppersubmit')) {
	if($_GET['op'] == 'loadcropper') {
		$cboxwidth = $_GET['width'] > 50 ? $_GET['width'] : 300;
		$cboxheight = $_GET['height'] > 50 ? $_GET['height'] : 300;

		$cbgboxwidth = $cboxwidth + 300;
		$cbgboxheight = $cboxheight + 300;
		$dragpl = ($cbgboxwidth - $cboxwidth)/2;
		$dragpt = ($cbgboxheight - $cboxheight)/2;
	} else {
		$prefix = $_GET['picflag'] == 2 ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl'];
	}
	include_once template("common/misc_imgcropper");
} else {
	$cropfile = md5($_GET['cutimg']).'.jpg';
	$ictype = $_GET['ictype'];

	if($ictype == 'block') {
		require_once libfile('function/block');
		$block = C::t('common_block')->fetch($_GET['bid']);
		$cropfile = block_thumbpath($block, array('picflag' => intval($_GET['picflag']), 'pic' => $_GET['cutimg']));
		$cutwidth = $block['picwidth'];
		$cutheight = $block['picheight'];
	} else {
		$cutwidth = $_GET['cutwidth'];
		$cutheight = $_GET['cutheight'];
	}
	$top = intval($_GET['cuttop'] < 0 ? 0 : $_GET['cuttop']);
	$left = intval($_GET['cutleft'] < 0 ? 0 : $_GET['cutleft']);
	$picwidth = $cutwidth > $_GET['picwidth'] ? $cutwidth : $_GET['picwidth'];
	$picheight = $cutheight > $_GET['picheight'] ? $cutheight : $_GET['picheight'];

	require_once libfile('class/image');
	$image = new image();
	$prefix = $_GET['picflag'] == 2 ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl'];
	if(!$image->Thumb($prefix.$_GET['cutimg'], $cropfile, $picwidth, $picheight)) {
		showmessage('imagepreview_errorcode_'.$image->errorcode, null, null, array('showdialog' => true, 'closetime' => true));
	}
	$image->Cropper($image->target, $cropfile, $cutwidth, $cutheight, $left, $top);
	showmessage('do_success', dreferer(), array('icurl' => $cropfile), array('showdialog' => true, 'closetime' => true));
}

?>