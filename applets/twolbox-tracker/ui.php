<?php
$CI =& get_instance();

$plugin_info = $plugin->getInfo();
$authId = PluginData::get('authId');
$authToken = PluginData::get('authToken');

$configure_path = $plugin_info['dir_name'];

$gaid = AppletInstance::getValue('gaid', '');
if (empty($gaid))
	$gaid = PluginData::get('defaultGaid');

if (empty($authId) || empty($authToken))
  	echo '<div style="margin-top:-10px;padding:10px 20px;color:#600;background:#fcc;border-bottom:2px solid #f00;font-size: 18px;font-weight:bold;">TwolBox Tracker must be <a href="'.base_url().'config/'.$configure_path.'">configured</a> before it will work.</div>';

?><div class="vbx-applet">
 <h2>Send information to Google Analytics via TwolBox.</h2>

 <h3>Page Path</h3>
 <div class="vbx-full-pane">
  <p>The URL path that will show up in Google Analytics. If you leave this blank you'll get the path to this applet instance which isn't very useful.</p>
  <fieldset class="vbx-input-container">
   <input type="text" name="path" class="medium" value="<?= AppletInstance::getValue('path', '') ?>"/>
  </fieldset>
 </div>

 <h3>Page Title</h3>
 <div class="vbx-full-pane">
  <p>The descriptive page title that will show up in Google Analytics. Optional but highly recommended.</p>
  <fieldset class="vbx-input-container">
   <input type="text" name="title" class="medium" value="<?= AppletInstance::getValue('title', '') ?>"/>
  </fieldset>
 </div>

 <h3>Google Analytics Profile ID</h3>
 <div class="vbx-full-pane">
  <p>Leave blank to use the default Profile ID defined in <a href="<?= base_url() ?>config/<?= $configure_path?>">settings</a>.</p>
  <fieldset class="vbx-input-container">
   <input type="text" name="gaid" class="medium" value="<?= $gaid ?>"/>
  </fieldset>
 </div>

 <h3>Next</h3>
 <div class="vbx-full-pane">
  <p>Continue to the next applet.</p>
  <?php echo AppletUI::DropZone('primary'); ?>
 </div>
</div>
