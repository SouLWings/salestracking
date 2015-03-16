<?php
require "core/core.php";

$errormsg = '';
if(isset($_POST['username']))
{
  $result = $db->select("SELECT * FROM $_POST[usertype] WHERE username = '$_POST[username]' AND password = '$_POST[password]'");
  if(sizeof($result) == 1)
  {
    $_SESSION['usertype'] = $_POST['usertype'];
    $_SESSION['id'] = $result[0]['id'];
    $_SESSION['username'] = $result[0]['username'];
    printr($_SESSION);
    if($_POST['usertype'] == 'admin')
      header('location: admin.php');
    else if($_POST['usertype'] == 'clerk')
      header('location: clerk.php');
    else if($_POST['usertype'] == 'vehicle')
      header('location: vehicle.php');
  }
  else
    $errormsg = '<h3><span class="label label-danger">Incorrect username or password!</span></h3>';
}


//after all logics before start output html, include this:
require "core/header.php";
//and the footer right before the file ends
?>
<style>
h2,legend,label{color:white}
</style>
<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; width: 100%; height: 100%;z-index: -999999; position: fixed;">
<img style="position: absolute; margin: 0px; padding: 0px; border: none; width: 100%; height: 100%; max-width: none; z-index: -999999; left: 0px;" src="img/indexbg.jpg" >

</div>

<?php echo $errormsg ?>
<form id='signinform' action='index.php' method='post' class='form-horizontal' style='width:450px;margin:auto;margin-top:100px;background:rgba(255,255,255,0.3);padding:30px;border-radius:10px;'>
  <h2>Welcome to bla bla system</h2><fieldset>
    <legend>Sign in</legend>
    <div id='signinfail' class='text-danger hide' ><h4>Incorrect username or password</h4></div>
    <div class='form-group'>
      <label class='col-lg-3 control-label'>Username:</label>
      <div class='col-lg-8'>
        <input required type='text' class='form-control' name='username'/>
      </div>
    </div>
    <div class='form-group'>
      <label class='col-lg-3 control-label'>Password:</label>
      <div class='col-lg-8'>
        <input required type='password' class='form-control' name='password'/>
      </div>
    </div>
    <div class='form-group'>
      <label class='col-lg-3 control-label'>Usertype:</label>
      <div class='col-lg-8'>
        <select name='usertype' class='form-control'>
          <option value='admin'>Admin</option>
          <option value='vehicle'>Driver</option>
          <option value='clerk'>Clerk</option>
          <option value='collector'>Collector</option>
          <option value='salesperson'>Sales Person</option>
        </select>
      </div>
    </div>
    <div class='submit-group pull-right'>
      <input type='submit' class='btn btn-primary' value='Sign in'/>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
  </fieldset>
</form>

<?php 
require "core/footer.php"; 