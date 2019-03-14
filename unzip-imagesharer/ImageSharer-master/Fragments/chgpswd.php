<form id="changePass"  action="../Process/chgpswd.php" method="post">
<span id="chgPassErr"></span>
<div id="pswdFrm" class="form-group">
<label id="curPassLab">Current Password:</label>
<input type="password"  class="form-control" id="curPass" name="curPass">
<br>
<label id="newPassLab">New Password:</label>
<input type="password" class="form-control" id="newPass" name="newPass">
<br>
<label id="conPassLab">Confirm Password:</label>
<input type="password" class="form-control" id="conPass" name="conPass">
<br>
<input type="submit"  id="chgPassBtn" name="chgPassBtn" value="Change Password">
</div>
</form>