<?php

$authId = PluginData::get('authId');
$authToken = PluginData::get('authToken');
$defaultGaid = PluginData::get('defaultGaid');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if(!function_exists('json_encode')) {
		include($plugin['plugin_path'].'/vendors/json.php');
	}

	$authId = $_POST['authId'];
	$authToken = $_POST['authToken'];
	$defaultGaid = $_POST['defaultGaid'];

	$response = array();

	$errors = array();

	if (empty($authId))
		$errors[] = array('message' => 'Auth ID is required.', 'field' => 'authId');

	if (empty($authToken))
		$errors[] = array('message' => 'Auth Token is required.', 'field' => 'authToken');

	if (!empty($defaultGaid) && !preg_match('/^UA-(\d+)-(\d+)$/i', $defaultGaid))
		$errors[] = array('message' => 'Google Analytics Profile ID is invalid', 'field' => 'defaultGaid');

	if (empty($errors)) {
		PluginData::set('authId', $authId);
		PluginData::set('authToken', $authToken);
		PluginData::set('defaultGaid', $defaultGaid);

		$response['message'] = 'Settings Saved!';
	}
	else {
		$response['errors'] = $errors;
	}

	ob_end_clean();
	header('Content-type: application/json');
	echo json_encode($response);
	exit;
}
else {

?>

<style>

#submit-button {
	margin-top: 2em;
	font-size: 150%;
	font-weight: bold;
}

.group-heading {
	margin-top: 1em;
}

#ajax-response {
	border-top: 2px solid #00f;
	background: #ccf;
	color: #006;
	font-size: 18px;
	font-weight: bold;
	padding: 10px 20px;
	display: none;
}

#ajax-response.error {
	border-top-color: #f00;
	background: #fcc;
	color: #600;
}

#ajax-response.error div {
	margin-top: .5em;
}

#ajax-response.error div.first {
	margin-top: 0;
}

</style>


<div class="vbx-content-menu vbx-content-menu-top">
 <h2 class="vbx-content-heading">TwolBox Tracker Settings</h2>
</div>

<div class="vbx-applet">
 <form method="post">

  <h2>TwolBox Credentials</h2>
  <p>Please enter your TwolBox credentials. You can find them on your <a href="http://www.twolbox.com/dashboard" target="twolbox">TwolBox Dashboard</a>.</p>
  <p>If you haven't signed up yet it's quick and easy. We like you so much we'll even give you a bunch of free tokens!  <a  class="submit-button" href="http://www.twolbox.com/dashboard" target="twolbox">Sign up now!</a></p>

  <div class="vbx-input-container">
   <label for="auth-id">Auth ID:</label>
   <input id="auth-id" name="authId" value="<?php echo $authId; ?>" class="medium"/>
  </div>

  <div class="vbx-input-container">
   <label for="auth-token">Auth Token:</label>
   <input type="password" id="auth-token" name="authToken" value="<?php echo $authToken; ?>" class="medium"/>
  </div>
 
  <h2 class="group-heading">Google Analytics</h2>
  <p>Your default Google Analytics Profile ID. This Profile ID will be used as the default in the TwolBox Tracker applet. We recommend creating a unique profile for tracking your phone calls and SMS messages so they don't get mixed in with your web analytics.</p>
  <p>If you don't already have a Google Analytics account you can <a href="http://www.google.com/analytics/" target="twolbox">sign up for free!</a></p>

  <div class="vbx-input-container">
   <label for="default-gaid">Default Profile ID (UA-XXXXX-X):</label>
   <input id="default-gaid" name="defaultGaid" value="<?php echo $defaultGaid; ?>" class="medium"/>
  </div>

  <button id="submit-button" class="submit-button"><span>Save</span></button>

 </form>
 
</div>

<div id="ajax-response"></div>

<script>
var base_url = '<?php echo base_url(); ?>';
</script>

<?

	OpenVBX::addJS('config.js');
}
?>
