//javascript for index.php
$(document).ready(function(){
	  
		//listens for click of login button to retrieve login form via ajax
	  $(document).on('click', '#logBtn', function(){
		  $.ajax({
			  type : 'POST',
			  url: 'Fragments/login.php',
			  data: $("form").serialize(),
			  success: function(msg) {
				  $("#bottom").html(msg)
			  },
			  error: function() {
				  alert("failure");
			  }
		  });
	  });
	  //end of login form retrieval
	  
	  //listens for clicks of signup button to retrieve the signup form
	  $(document).on('click', '#signBtn', function(){
		  $.ajax({
			  type: 'POST',
			  url: 'Fragments/signup.php',
			  data: $("form").serialize(),
			  success: function(msg) {
				  $("#bottom").html(msg)
			  },
			  error: function() {
				  alert("failure");
			  }
		  });
	  });
	  //end of retrieval of signup form
	  
	  
	  //sends login form via ajax for processing
	  $(document).on('submit', '#lgFrm', function(e){
		  e.preventDefault();
		  var username = $("#username").val();
		  var pswd = $("#pswd").val();
		  
	  $.post("Process/login.php", {username:username, pswd:pswd}, function(data, status){
		  if(data == 1){
			  window.location.href = "Users/profile.php";
		  } else
			  $("#err").html(data);
	  });
	  
	});
	  //end of ajax login
	  
	  //sends data for sign up form via ajax for processing
	  $(document).on("submit", "#signFrm", function(e){
		  e.preventDefault();
		  var newUsername = $("#newUsername").val();
		  var email = $("#email").val();
		  var pass = $("#pass").val();
		  var conPswd = $("#conPswd").val();
		  
		  $.post("Process/signup.php", {newUsername:newUsername, email:email, pass:pass, conPswd:conPswd}, function(data, status){
			  if(data == 1){
				  window.location.href = "index.php";
			  } else 
				  $("#err").html(data);
		  });
		  
	  });
		  
	  //end of signup form ajax
		  
   
   //functions for buttons shown if user is logged in
   function logout(){
	   window.location.href = "Process/logout.php";
   }
   function profile(){
	   window.location.href = "Users/profile.php";
   }
   //end of index.php
   
   //start of javascript for viewImg.php
   
  //places the id of the comment to be deleted in the form 
	$(document).on("mouseenter", ".delFrm", function(){
			var cmterid = $(this).find("#cmtid").text();
			$(".cmtid").val(cmterid);
	});
	//end of viewImg.php
	
	//start of javascript for profile.php
	
	//ajax for editing avatar
	$(document).on("click", "#editAva", function(){
		$.ajax({
			type : 'POST',
			url: '../Fragments/editavatar.php',
			data: $("#editAvaForm").serialize(),
			success: function(msg) {
				$("#profileMain").html(msg);
			},
			error: function() {
				  alert("failure");
			  }
		});
	});
	
	$(document).on("submit", "#editAvaForm", function(e){
		e.preventDefault();
		var ourFile = $("#ourFile").val();
		$.post("../Process/editavatar.php", {ourFile:ourFile}, function(data, status){
			$("#avaErr").html(data);
		});
	});
	//end of ajax for editing avatar
	
	//ajax for uploading images
	$(document).on("click", "#fileUp", function(){
		$.ajax({
			type : 'POST',
			url: '../Fragments/uploadImg.php',
			data: $("#uploadImg").serialize(),
			success: function(msg) {
				$("#profileMain").html(msg);
			},
			error: function() {
				  alert("could not retrieve form for uploading a new photo. Please try again.");
			}
		});
	});
	
	$(document).on("submit", "#uploadImg", function(e){
		e.preventDefault();
		var ourFile = $("#ourFile").val();
		var setter = $("input[name*=setter").val();
		$.post("../Process/uploadimg.php", {ourFile:ourFile, setter:setter}, function(data, status){
			$("#uploadErr").html(data);
		});
		
	});
	//end of upload image ajax
	
	//start of "change password" ajax
	$(document).on("click", "#pswdChg", function(){
		$.ajax({
			type : 'POST',
			url: '../Fragments/chgpswd.php',
			data: $("#changePass").serialize(),
			success: function(msg){
				$("#profileMain").html(msg);
			},
			error: function(){
				alert("Could not retrieve password change form. Please try again.");
			}
		});
	});
	
	$(document).on("submit", "#changePass", function(e){
		e.preventDefault();
		var curPass = $("#curPass").val();
		var newPass = $("#newPass").val();
		var conPass = $("#conPass").val();
		
		$.post("../Process/chgpswd.php", {curPass:curPass, newPass:newPass, conPass:conPass}, function(data){
			$("#chgPassErr").html(data);
		});
	});
	//end of "change password" ajax 
	
	
	//start of animation for the "links" section
	$(document).on("mouseleave", "#links", function(){
		$("#editAva").slideUp(700);
		$("#fileUp").slideUp(700);
		$("#index").slideUp(700);
		$("#pswdChg").slideUp(700);
		$("#logout").slideUp(700);
		$("#editAva2").show(800);
		$("#fileUp2").show(800);
		$("#index2").show(800);
		$("#pswdChg2").show(800);
		$("#logout2").show(800);
	});
	
	$(document).on("mouseenter", "#links", function(){
		$("#editAva2").hide(700);
		$("#fileUp2").hide(700);
		$("#index2").hide(700);
		$("#pswdChg2").hide(700);
		$("#logout2").hide(700);
		$("#logout").slideDown(800);
		$("#pswdChg").slideDown(800);
		$("#index").slideDown(800);
		$("#fileUp").slideDown(800);
		$("#editAva").slideDown(800);
	});
	//end of animation

	//end of profile.php
	
	//start of javascript for editImg.php
	function priClick() {
	if(document.getElementById("pub").checked){
		document.getElementById("pub").checked = false;
		document.getElementById("pri").checked = true;
	} else {
		document.getElementById("pri").checked = true;
	}	
}
	
function pubClick() {
	if(document.getElementById("pri").checked){
		document.getElementById("pri").checked = false;
		document.getElementById("pub").checked = true;
	} else {
		document.getElementById("pub").checked = true;
	}
}
	
	//end of editIimg.php


});