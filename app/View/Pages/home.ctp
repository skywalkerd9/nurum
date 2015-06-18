<script type="text/javascript">
	// Invoking the Login Dialog with the JavaScript SDK
		//Funcion para verificar si ya estamos logeados en Facebook
		function verifiedFb(request) {			
			if(request == 'register'){
				var pass = document.getElementById("user-pass").value;

				if (pass == "") {
					$(function() {
						alert('Porporciónanos el password con el que ingresaras al panel del Administrador Nurum.');										
					});
					return false;
				}
			}

			FB.login(function(response) {
				if (response.status === 'connected') {
					// Logged into your app and Facebook.
					if(request == 'register'){
						registerAPI();
					}else{
						loginAPI();
					}
				} else if (response.status === 'not_authorized') {
					// The person is logged into Facebook, but not your app.
					console.log('Please log into this app.');
					location.reload();
				} else {
					// The person is not logged into Facebook, so we're not sure if
					// they are logged into this app or not.
					console.log('Please log into Facebook.');
					location.reload();
				}
			}, {scope: 'public_profile,email'});
		}
		
		//Inicializamos la llamda ascincrona al Api de Facebook
		window.fbAsyncInit = function() {
		  FB.init({
			appId      : '938196706223260',
			xfbml      : true,
			cookie     : true,
            xfbml      : true,
			version    : 'v2.3'
		  });
		};

		(function(d, s, id){
		   var js, fjs = d.getElementsByTagName(s)[0];
		   if (d.getElementById(id)) {return;}
		   js = d.createElement(s); js.id = id;
		   js.src = "//connect.facebook.net/en_US/sdk.js";
		   fjs.parentNode.insertBefore(js, fjs);
		 }(document, 'script', 'facebook-jssdk'));
		 
		//Login de Facebook 
		function loginAPI() {			
			FB.api('/me', function(response) {
			  $(function() {
					var url = '/Users/login';					
					var email = response.email;					
					var formData = new FormData();					
					formData.append('data[User][email]', email);

					$.ajax({
						type: "POST",
						dataType: 'json',
						contentType: false,
						processData: false,
						url: url,
						data: formData,
						success: function(data) {
							if (data['response'] == 'ok') {
								document.location.href = data['redirect'];
							}else{
								alert(data['response']);
								$('.register').delay(3000).click();
							}
						}
					});

					return false;
			  });
			});
		}
		
		
		//Registro con Facebook
		function registerAPI() {
			FB.api('/me', function(response) {
				$(function() {
					var url = '/Users/register';
					var pass = $('#user-pass').val();
					var email = response.email;
					var name = response.name;
					var formData = new FormData();
					formData.append('data[User][name]', name);
					formData.append('data[User][email]', email);
					formData.append('data[User][password]', pass);

					$.ajax({
						type: "POST",
						dataType: 'json',
						contentType: false,
						processData: false,
						url: url,
						data: formData,
						success: function(data) {
							if (data['response'] == 'ok') {
								alert(data['message']);
								document.location.href = data['redirect'];								
							}else{
								alert(data['response']);
								location.reload();
							}
						}
					});

					return false;
				});
			});
		}
		
		$(document).ready(function(){
			$('#btn-login').click(function(){
				var url = $('#loginform').attr('action');
				var form = $('#loginform').serialize();
				var btn = $(this);
				btn.button('loading');
				
				

				$.ajax({
					type: "POST",
					dataType: 'json',
					url: url,
					data: form,
					success: function(data) {
						if(data['response'] == 'ok'){
							document.location.href = data['redirect'];					
						}else{
							alert(data['response']);
							$('#login-password').val("");
						}
					}
				}).always(function() {
					btn.button('reset')
				});

				return false;
			});
		});
</script>
<div class="container">    
	<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
		<div class="panel panel-info" >
			<div class="panel-heading">
				<div class="panel-title">Nurum Login</div>				
			</div>     
			<div style="padding-top:30px" class="panel-body" >
				<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
				<form id="loginform" method="post" action="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'login'));?>" class="form-horizontal" role="form">
								
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input id="login-username" type="text" class="form-control" name="data[User][email]" value="" placeholder="username or email">                                        
						</div>
							
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input id="login-password" type="password" class="form-control" name="data[User][password]" placeholder="password">
						</div>                                    					
						
						<div style="margin-top:10px" class="form-group">
							<!-- Button -->
							<div class="col-sm-12 controls">
							  <a id="btn-login" href="#" class="btn btn-success"  data-loading-text="logging...">Login  </a>
							  <span style="margin-left:8px;margin-right:8px;">or</span>  
							<button id="btn-fblogin" type="button" class="btn btn-primary" onclick="verifiedFb('login');"><i class="icon-facebook"></i>   Login with Facebook</button>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-12 control">
								<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
									Don't have an account! 
								<a href="#" class="register" onClick="$('#loginbox').hide(); $('#signupbox').show()">
									Sign Up Here
								</a>
								</div>
							</div>
						</div>  
						<input type="hidden" name="login" value="true">
					</form>     
				</div>                     
			</div>  
	</div>
	<div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Sign Up</div>
				<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
			</div>  
			<div class="panel-body" >
				<form id="signupform" method="post" action="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'register'));?>" class="form-horizontal" role="form">						
					<!--<div id="signupalert" style="display:none" class="alert alert-danger">
						<p>Error:</p>
						<span></span>
					</div>
					
					<div class="form-group">
						<label for="email" class="col-md-3 control-label">Email</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="email" placeholder="Email Address">
						</div>
					</div>
						
					<div class="form-group">
						<label for="firstname" class="col-md-3 control-label">First Name</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="firstname" placeholder="First Name">
						</div>
					</div>
					<div class="form-group">
						<label for="lastname" class="col-md-3 control-label">Last Name</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="lastname" placeholder="Last Name">
						</div>
					</div>-->
					
					<div class="form-group">
						<label for="password" class="col-md-3 control-label">Password</label>
						<div class="col-md-9">
							<input type="password" id="user-pass" class="form-control" name="password" placeholder="Password">
						</div>
					</div>
					
					<!--<div class="form-group">
						<label for="password" class="col-md-3 control-label">Confirm Password</label>
						<div class="col-md-9">
							<input type="password" class="form-control" name="passwordc" placeholder="Password">
						</div>
					</div>-->

					<div class="form-group">
						<!-- Button -->                                        
						<div class="col-md-offset-3 col-md-9">							
							<button id="btn-fbsignup" type="button" class="btn btn-primary" onclick="verifiedFb('register');"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
						</div>   
					</div>                                                                                                
				</form>
			 </div>
		</div>  
	 </div> 
</div>
    