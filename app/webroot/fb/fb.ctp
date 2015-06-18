<script type="text/javascript">
	// Invoking the Login Dialog with the JavaScript SDK
		function registerFb() {
			var pass = document.getElementById("customer-pass").value;

			if (pass == "") {
				$(function() {
					alert('Porporciónanos el password con el que ingresaras a VMT para continuar tu registro con Facebook.');
					$('#customer_register').validator('validate');					
				});
				return false;
			}

			FB.login(function(response) {
				if (response.status === 'connected') {
					// Logged into your app and Facebook.
					testAPI();
				} else if (response.status === 'not_authorized') {
					// The person is logged into Facebook, but not your app.
					console.log('Please log into this app.');
				} else {
					// The person is not logged into Facebook, so we're not sure if
					// they are logged into this app or not.
					console.log('Please log into Facebook.');
				}
			}, {scope: 'public_profile,email'});
		}

		window.fbAsyncInit = function() {
			FB.init({
				appId: '336793259857706',
				cookie: true, // enable cookies to allow the server to access 
				// the session
				xfbml: true, // parse social plugins on this page
				version: 'v2.2' // use version 2.1
			});
		};

// Load the SDK asynchronously
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {
				return;
			}
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/es_LA/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));


		function testAPI() {
			FB.api('/me', function(response) {
				$(function() {
					var url = '/Customers/addCustomer';
					var pass = $('#customer-pass').val();
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
							if (data['message'] == 'Correcto') {
								$('#UsersContactName').val(name);
								$('.code').val(data['data']);
								$('.close').delay(3000).click();
								$('.store_active').modal('show');
							}
						}
					});

					return false;
				});
			});
		}
	
	$(document).ready(function(){
		$('#customer_register').validator('validate');
		
		$('.main-products-content').on('click','a.send_cont',function(event){
			event.preventDefault();
			var url = $(this).attr('href');

			$.ajax({
				type: "POST",
				url: url,
				success: function(data) {					
				   $('.main-products-content').show( "slow" ).html(data);
				}
			});

			return false;
		});
		
		$('.main-products-content').on('click','a.close-detail',function(event){
			event.preventDefault();
			var url = $(this).attr('href');

			$.ajax({
				type: "POST",
				url: url,
				success: function(data) {
					$('.main-products-content').show("slow").html(data);
				}
			});

			return false;
		});
		
		$('.main-products-content').on('click','a.cart-product',function(){
			var form = $('#add_cart').serialize();
			var url = $('#add_cart').attr("action");
			
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: url,
				data: form,
				success: function(data) {
					if (data['message'] == 'Correcto') {
						if(data['add'] == 1){
							alert(data['response']);
						}else{
							$('.badge-cart').text(data['articles']);
							$('.body-cart').html($.parseHTML(data['html']));
							$('#viewCart').modal('show');
						}
					} else {
						alert(data['message']);
					}
				}
			});

			return false;
		});
		
		$('.main-products-content').on('click','a.add_cart',function(event){
			event.preventDefault();
			
			var url = $(this).attr('href');
			var str = url;
			var form = str.split("/");
			var id = form[3];
			var price = form[4];
			url = url.split("/"+id);
			url = url[0];
			var formData = new FormData();
			formData.append('data[Product][id]', id);
			formData.append('data[ProductVariant][price]', price);
			
			$.ajax({
				type: "POST",
				dataType: 'json',
				contentType: false,
				processData: false,
				url: url,
				data: formData,
				success: function(data) {
					if(data['message'] == 'Correcto'){
							$('.badge-cart').text(data['articles']);
							$('.body-cart').html($.parseHTML(data['html']));
							$('#viewCart').modal('show');
					}
				}
			});

			return false;
		});
		
		/*$('#viewCart').on('hidden.bs.modal', function (e) {
			var url = $('.shopping').attr('href');			
			document.location.href = url;
		});*/
		
		$('.btn-cart').click(function(){
			var url = $(this).attr("href");
			var value = $('.badge-cart').text();
			
			if(value == "" || value == 0){
				alert("Selecciona al menos un artículo para ver el carrito.");
				return false;
			}
			
			$.ajax({
				type: "POST",
				url: url,
				success: function(data) {
					$('input[name="login"]').val(1);
					$('.main-products-content').show("slow").html(data);
					$('#viewCart').modal('hide');
				}					
			});

			return false;
		});
		
		$('.cat').click(function(event){
			event.preventDefault();			
			var categorie_id = $(this).attr("data-catid");
			var store_id = $('#store_id').val();
			var url = $('input[name="action"]').val();
			
			$.ajax({
				type: "POST",
				url: url,
				data: {id: categorie_id,store:store_id},
				success: function(data) {
					$('input[name="login"]').val(0);
				    $('.main-products-content').html(data);
				}
			});

			return false;
		});
		
		$('.form-login').click(function(){ return false;});
		
		$('#login_customer').click(function(){
			var url = $('#customer_login').attr('action');
			var form = $('#customer_login').serialize();
		    var btn = $(this);
			btn.button('loading');

			$.ajax({
				type: "POST",
				dataType: 'json',
				url: url,
				data: form,
				success: function(data) {
					if(data['message'] == 'Ok'){
						location.reload();
					}else if(data['message'] == 'Correcto'){						
						$('.login').delay(3000).click();
						$('.li-login').html(data['html']);						
						dataCollection(data['data']);
					}else{
						alert(data['message']);
					}
				}
			}).always(function() {
				btn.button('reset')
			});

			return false;
		});
		
		$('.pages').click(function(event){
			event.preventDefault();
			
			var url = $(this).attr('href');

			$.ajax({
				type: "POST",
				url: url,
				success: function(data) {
					if(data == ""){
						alert("La página seleccionada no se encuentra disponible por el momento.");
					}else{
						$('.main-products-content').html(data);
					}					
				}
			});

			return false;
		});
		
		$('.add-customer').click(function() {
			var url = $('#customer_register').attr('action');
			var form = $('#customer_register').serialize();
			var btn = $(this);
			btn.button('loading');

			$.ajax({
				type: "POST",
				dataType: 'json',
				url: url,
				data: form,
				success: function(data) {
					if(data['message'] == 'Correcto'){
						alert(data['response']);
						$('#customerRegister').modal('hide');
						location.reload();
					}else{
						alert(data['message']);
						$('#customerRegister').modal('hide');
						document.getElementById("customer_register").reset();
					}
				}
			}).always(function() {
				btn.button('reset');
			});

			return false;
		});
		
		$('.account').click(function(){
			var url = $(this).attr('href');
	
			$.ajax({
				type: "POST",
				url: url,
				success: function(data) {
					if(data != 'Error'){
						$('.main-products-content').html(data);
					}else{
						alert('El perfil es invalido para ver esta infromación. Ponte en contacto con VMT si persiste el problema.');
					}					
				}
			});

			return false;
		});
	});
	
	function dataCollection(data) {
		$(function() {
			$.each(data,function(index,value){
				$('.'+index).val(value);
				$('.'+index).delay(3000).click();
			});
		});
	}
		
</script>

<header>
	<div class="container">
		<div class="header-middle" style="padding-bottom: 11px;">
			<div class="row" style="border-bottom: 1px solid #eee;">
				<div class="col-sm-4">
					<div class="pull-left">
						<a href="<?php echo $this->Html->url(array('controller' => 'Pages', 'action' => 'display', 'home', 'vivaadmin' => false));?>"><?php echo $this->Html->image('viva_mi_tienda_logo.png', array('alt' => 'Viva Mi Tienda', 'style' => 'width:28%')); ?></a>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="shop-menu pull-right">
						<ul class="nav navbar-nav">
							<li class="nav-dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									Pages <span class="caret"></span>
								</a>
								<ul class="dropdown-menu pages-store">									
									<?php foreach ($store_pages as $key => $value): ?>
										<li><a href="<?php echo $this->Html->url(array('controller' => 'StorePages', 'action' => 'viewPage', $store_pages[$key]['StorePage']['id'])); ?>" class="pages"><?php echo $store_pages[$key]['StorePage']['title']; ?></a></li>
									<?php endforeach; ?>
									<li><a href="<?php echo $this->Html->url(array('controller' => 'StorePages', 'action' => 'viewPage','Contacto'));?>" class="pages">Contacto</a></li>									
									<li><a href="<?php echo $this->Html->url(array('controller' => 'StorePages', 'action' => 'viewPage','FAQ´s'));?>" class="pages">FAQ'S</a></li>									
								</ul>
							</li>
							<li>
								<?php if($login):?>
								<a href="<?php echo $this->Html->url(array('controller'=>'Customers','action'=>'viewAccount',$customer_id));?>" class="account"><i class="fa fa-user"></i> Account</a>
								<?php else:?>
								<a style="cursor: pointer;" onclick="alert('Debes inciar sesión para ver esta información.'); return false;"><i class="fa fa-user"></i> Account</a>
								<?php endif;?>
							</li>
							<li><a class="active btn-cart" href="<?php echo $this->Html->url(array('controller' => 'Stores','action' => 'viewCart',$id));?>"><i class="fa fa-shopping-cart"></i> Cart<span class="badge bg-green badge-cart" style="font-size: 10px; margin: 5px;"><?php echo $this->Session->read('num_art');?></span></a></li>
							<li class="li-login">
							<?php if($login):?>
							<a href="<?php echo $this->Html->url(array('controller' => 'Users','action' => 'logout','vivaadmin' => false));?>" onclick="if (confirm('¿Estás seguro de cerrar tu sesión?')) { return true; } return false;"><i class="fa fa-lock"></i> Logout</a>
							<?php else:?>
							<a id="login" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-lock"></i> Login</a>
								<div class="dropdown-menu" role="menu" style="margin: 0px -196px 0;">
									<div class="login" align="center">
											<?php echo $this->Html->image('users.png', array('class' => 'profile-img', 'alt' => 'Inicio de Sesión', 'style' => "width: 50%;")); ?>
											<div class="account-wall">
												<?php echo $this->Form->create('Users', array('id' => 'customer_login', 'class' => 'form-signin', 'url' => array('controller' => 'Users', 'action' => 'customerLogin'), 'data-toggle' => 'validator', 'novalidate' => 'true')); ?>
												<div class="form-group">				  
													<?php echo $this->Form->input('username', array('type' => 'email', 'label' => FALSE, 'div' => false, 'class' => 'form-control form-login', 'placeholder' => __('Email'), 'data-error' => __('dirección de correo inválida'), 'required' => __('required'))); ?>
													<div class="help-block with-errors"></div>
												</div>
												<div class="form-group">
													<?php echo $this->Form->input('password', array('label' => FALSE, 'div' => false, 'class' => 'form-control form-login', 'placeholder' => __('Password'), 'required' => __('required'))); ?>
													<div class="help-block with-errors"></div>
												</div>
												<div class="form-group">
													<input type="hidden" name="login" value="0">
													<a class="recover-password" onclick="$('.close').delay(3000).click(); $('.forgot_passs').modal('show');" style="cursor: pointer;">													
													<small>¿Olvidaste tu contraseña?</small></a><br>
													<button type="submit" id="login_customer" class="btn btn-primary form-control saving login_customer" data-loading-text="logging...">Entrar</button>
												</div>
												<?php echo $this->Form->end(); ?>
											</div>
										<button class="text-center new-account btn btn-success"  data-toggle="modal" data-target="#customerRegister" onclick="$('.login').delay(3000).click();">Registrate</button>
									</div>
								</div>							
							<?php endif;?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12" id="header">
			<div id="menu-small">
				<div id="menu-settings">
					<ul class="nav nav-right nav-pills pull-right">
						<li data-toggle="tooltip" data-placement="bottom" data-original-title="Mi cuenta">
							<div class="dropdown-menu pull-right" role="menu">
								<div class="card login" align="center">
									<h3>Login</h3>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="image-cover" style="background-image: url('<?php echo $url.'img/'.$stores[0]['Store']['background'];?>');"></div>
				<div class="store-logo">
					<a href="">
						<img src="<?php echo $url.'img/'.$stores[0]['Store']['logo'];?>" width="160" height="160">
					</a>
				</div>  
				<div class="page-header">
					<a href=""><h1 id="store-title"><?php echo $stores[0]['Store']['name'];?></h1></a>
					<p id="store-description"><?php echo $stores[0]['Store']['description'];?></p>
				</div>
			</div>
			<div class="row cover-bottom">
				<img class="img-responsive">
			</div>
		</div>
	</div>
</header>
<article>
	<div class="main-container">
		<div class="container" id="middle"> 
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="row" id="navigation">
					<nav class="navbar navbar-inverse navbar-static-top" id="menu-shopping">
						<div class="container-fluid">
						</div>
					</nav>
				</div>								
				<div class="row" id="categories">
					<nav class="navbar navbar-default navbar-static-top" role="navigation">
						<div class="container-fluid">	
							<div class="frame" id="basic" style="overflow: hidden;">
								<ul class="nav nav-pills nav-justified clearfix" style="transform: translateZ(0px);">
									<li class="super active">
										<a class="cat" data-catid="all" href="#">TODOS</a>
									</li>
									<?php foreach ($categories as $key => $value):?>
									    <?php if($categories[$key]['name'] != 'Sin Categoría'):?>
										<li class="super">
											<a href="#" id="cat-<?php echo $key;?>" class="cat" data-catid="<?php echo $categories[$key]['id'];?>"><?php echo strtoupper($categories[$key]['name']);?></a>
										</li>
										<?php endif;?>
									<?php endforeach;?>
									<input type="hidden" name="action" value="<?php echo $this->Html->url(array('controller' => 'Products','action' => 'categorieProducts'));?>">
								</ul>
							</div>
						</div>
					</nav>
				</div>
				<div class="row main-products-content">
					<?php echo $this->element('store/list-products');?>
				</div>
				<input type="hidden" id="store_name" name="Store.name" value="<?php echo $stores[0]['Store']['name'];?>">
				<input type="hidden" id="store_id" name="Store.id" value="<?php echo $stores[0]['Store']['id'];?>">
			</div>
		</div>
	</div>
</article>
<div class="loading-img"></div>
<?php echo $this->element('store/modal-customer');?>
<?php echo $this->element('store/modal-cart');?>