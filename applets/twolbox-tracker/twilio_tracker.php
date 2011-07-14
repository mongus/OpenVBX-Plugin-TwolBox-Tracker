<?php
function twilio_tracker($authId, $authToken, $gaid, $path, $title, $userAgent) {
    $voice = !empty($_REQUEST['CallSid']);
    $sms = !empty($_REQUEST['SmsSid']);
    $oldApi = $voice && $_REQUEST['ApiVersion'] == '2008-08-01';
    $newApi = !$oldApi;
    // For the old API we'll guess inbound because there's no way to tell :-(
    $inbound = $oldApi || $sms || $_REQUEST['Direction'] == 'inbound';
    $outbound = !$inbound;

    $params = array();

    $params['authId'] = $authId;
    $params['authToken'] = $authToken;

    $params['gaid'] = $gaid;
    if ($oldApi && $inbound)
        $params['zip'] = $_REQUEST['CallerZip'];
    if ($oldApi && $outbound)
        $params['zip'] = $_REQUEST['CalledZip'];
    if ($newApi && $inbound)
        $params['zip'] = $_REQUEST['FromZip'];
    if ($newApi && $outbound)
        $params['zip'] = $_REQUEST['ToZip'];
    $params['hostname'] = $_SERVER['HTTP_HOST'];
    $params['path'] = empty($path) ? $_SERVER['REQUEST_URI'] : $path;
    if ($sms)
        $params['visitorId'] = $_REQUEST['SmsSid'];
    if ($voice)
        $params['visitorId'] = $_REQUEST['CallSid'];
    if (!empty($title))
        $params['title'] = $title;
    $params['referrer'] = $_SERVER['HTTP_REFERER'];
    $params['userAgent'] = !empty($userAgent) ? $userAgent : $_SERVER['HTTP_USER_AGENT'];
    if ($oldApi && $inbound)
        $params['city'] = $_REQUEST['CallerCity'];
    if ($oldApi && $outbound)
        $params['city'] = $_REQUEST['CalledCity'];
    if ($newApi && $inbound)
        $params['city'] = $_REQUEST['FromCity'];
    if ($newApi && $outbound)
        $params['city'] = $_REQUEST['ToCity'];
    if ($oldApi && $inbound)
        $params['state'] = $_REQUEST['CallerState'];
    if ($oldApi && $outbound)
        $params['state'] = $_REQUEST['CalledState'];
    if ($newApi && $inbound)
        $params['state'] = $_REQUEST['FromState'];
    if ($newApi && $outbound)
        $params['state'] = $_REQUEST['ToState'];
    if ($oldApi && $inbound)
        $params['country'] = $_REQUEST['CallerCountry'];
    if ($oldApi && $outbound)
        $params['country'] = $_REQUEST['CalledCountry'];
    if ($newApi && $inbound)
        $params['country'] = $_REQUEST['FromCountry'];
    if ($newApi && $outbound)
        $params['country'] = $_REQUEST['ToCountry'];
    if ($oldApi && $inbound)
        $params['c.name'] = $_REQUEST['Called'];
    if ($oldApi && $outbound)
        $params['c.name'] = $_REQUEST['Caller'];
    if ($newApi && $inbound)
        $params['c.name'] = $_REQUEST['To'];
    if ($newApi && $outbound)
        $params['c.name'] = $_REQUEST['From'];
    $params['c.source'] = 'Twilio';
    if ($voice)
        $params['c.medium'] = 'Phone';
    if ($sms)
        $params['c.medium'] = 'SMS';

    $url = 'http://api.twolbox.com/2011-1-1/twilio-tracker?'.http_build_query($params);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if(curl_errno($ch))
        error_log('Error while calling TwilioTracker: '.curl_error($ch));
    curl_close($ch);
    
    return json_decode($response);
}
?>
