<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
    			<div class="card">
          			<div class="card-header"> Login<br></div>
            			<?php if( $error !== '' ){ ?>

	          			<div class="alert alert-danger" role="alert">
						  <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

						</div>
						<?php } ?>

            			<div class="card-body">
              				<div class="row">
                				<div class="col-md-12">
                  					<form action="/login" method="POST" data-js="login-form-main">
                    					<div class="form-group">
                      						<label>Email address</label>
											<input type="email" class="form-control" data-js="login-inp-email" placeholder="Email adress" name="email">
                    					</div>
                    					<div class="form-group">
                      						<label>Password</label>
                      						<input type="password" class="form-control login-input" placeholder="Password" data-js="login-inp-password" name="password">
                    					</div>

                    					<div class="form-group">
                    						<small class="form-text text-muted"><a href="/forgot">Forgot your password?</a></small>
                    					</div>

                    					<div class="row">
	                    					<div class="col-md-12">
						                    	<button class="btn btn-success" data-js="login-btn-login">Login <br></button>
						                    	<a class="btn btn-info float-right" data-js="login-btn-register" href="/register">Register</a>
	                    					</div>
	                    				</div>
                  					</form>
				                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>