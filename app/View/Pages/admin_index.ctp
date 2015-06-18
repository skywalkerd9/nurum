<script type="text/javascript">
	$(document).ready(function(){
		$('.submenu').click(function(event) {
			event.preventDefault();

			var i = $(this).parent().index();			
			var option = $(this).text();
			var url = $(this).attr('href');
			
			switch (option) {
				case 'Add Record':
					$.ajax({
						type: "POST",
						contentType: false,
						processData: false,
						url: url,
						success: function(data) {
							$('.body-record').html(data);
							$('#myModalRecord').modal('show');
						}
					});
					
					break;
				case 'List Records':
					$.ajax({
						type: "POST",
						contentType: false,
						processData: false,
						url: url,
						success: function(data) {
							$('.main').html(data);							
						}
					});
					
					break;
			}					

			return false;
		});
		
		$('.add-record').click(function(event){
			event.preventDefault();
			
			var form = $('#addRecord').serialize();
			var url = $('#addRecord').attr('action');			
			var expreg = /^[0-9\.]+$/;
			var record = $('.record').val();

			if(!expreg.test(record)){
				$('.help-block').hide();
				$('.error-block').text('Solo registros númericos para este campo.');
				return false;
			}
			
			$('.help-block').show();
			$('.error-block').hide();
			
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: url,
				data: form,
				success: function(data) {
					if(data['response'] == 'Correcto'){
						alert(data['message']);
						$('#myModalRecord').modal('hide');
						location.reload();
					}else if(data['response'] == 'Existe'){
						alert(data['message']);
						document.getElementById("addRecord").reset();
					}else{
						alert(data['response']);
						$('#myModalRecord').modal('hide');
						document.getElementById("addRecord").reset();
					}
				}
			});
			
			return false;
		});
		
		$('.delete-record').click(function(event){
			event.preventDefault();
			
			var url = $(this).attr("href");
			
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: url,				
				success: function(data) {
					if(data['response'] == 'ok'){
						alert(data['message']);						
						location.reload();	
					}else{
						alert(data['response']);						
					}
				}
			});
			
			return false;
		});
	});
</script>
<div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">NURUM ADMIN</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
							<a href="/Users/logout" onclick="if (confirm('¿Estás seguro de cerrar tu sesión?')) { return true; } return false;"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo $this->Html->url();?>"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Records<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li>
                                    <a href="<?php echo $this->Html->url(array('controller' => "Records", 'action' => "addRecord",'admin' => false));?>" class="submenu">Add Record</a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->Html->url(array('controller' => "Records", 'action' => "listRecords",'admin' => false));?>" class="submenu">List Records</a>
                                </li>                                                              
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ADMINISTRADOR ABC</h1>
                </div>
                <!-- /.col-lg-12 -->
			</div>
			<div id="main" class="row">
				<?php echo $this->element('admin/records/list-records')?>
            </div>           
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
	
	<!-- modal-Add -->
	<div class="modal fade" id="myModalRecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Alta de Registros</h4>
				</div>
				<div class="modal-body body-record">
					
				</div>
				<div class="modal-footer">					
					<button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-default add-record">Agregar Registro</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /#modal-Add -->
<script>
	$(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
</script>