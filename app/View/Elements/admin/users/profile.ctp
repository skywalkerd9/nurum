<link href='http://fonts.googleapis.com/css?family=Raleway:400,200' rel='stylesheet' type='text/css'>
<link href="/css/admin/profile.css" rel="stylesheet" type="text/css">

<div class="container">
	<div class="row login_box">
	    <div class="col-md-12 col-xs-12" align="center">          
            <div class="outter"><img src="http://graph.facebook.com/<?php echo $user['User']['fbid'];?>/picture?type=square" class="image-circle"/></div>   
            <h1>Usuario</h1>
            <span><?php echo $user['User']['first_name'];?></span>
	    </div>
		
        <div class="col-md-6 col-xs-6 follow line" align="center">
            <h3>
                <span>REGISTROS</span>
            </h3>
        </div>
        <div class="col-md-6 col-xs-6 follow line" align="center">
            <h3>
                <span><?php echo count($user['Record']);?></span>
            </h3>
        </div>
        
        <div class="col-md-12 col-xs-12 login_control">
                
                <div class="control">
                    <div class="label">Email Address</div>
                    <input type="text" class="form-control" value="<?php echo $user['User']['email'];?>"/>
                </div>
                
                <div class="control">
                     <div class="label">Usuario desde</div>
					 <input type="datetime" class="form-control" value="<?php echo $user['User']['created'];?>"/>
                </div>                               
        </div>
        
        
            
    </div>
</div>