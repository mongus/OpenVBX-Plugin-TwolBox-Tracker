<?php
require('twilio_tracker.php');

$response = new Response();

$authId = PluginData::get('authId');
$authToken = PluginData::get('authToken');
$gaid = AppletInstance::getValue('gaid');
$path = AppletInstance::getValue('path');
$title = AppletInstance::getValue('title');
$userAgent = 'OpenVBX/'.OpenVBX::version();

if (empty($gaid))
	$gaid = PluginData::get('defaultGaid');

if (!empty($authId) && !empty($authToken) && !empty($gaid))
	twilio_tracker($authId, $authToken, $gaid, $path, $title, $userAgent);

$next = AppletInstance::getDropZoneUrl('primary');

if (!empty($next))
	$response->addRedirect($next);

$response->Respond();
