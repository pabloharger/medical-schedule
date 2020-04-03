<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
    		<div class="card">
          <div class="card-header"> register<br></div>
          <?php if( $error !== '' ){ ?>

          <div class="alert alert-danger" role="alert">
					  <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

					</div>
					<?php } ?>

    			<div class="card-body">
      			<div class="row">
        			<div class="col-md-12">
          			<form action="/register" method="POST" data-js="register-form-main">
            			<div class="form-group">
              				<label>Email address</label>
							        <input type="email" class="form-control" data-js="register-inp-email" placeholder="Email adress" name="email" value="<?php echo htmlspecialchars( $regVal["email"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              			<div class="invalid-feedback"> This field is required. </div>
            			</div>
        					<div class="form-group">
        						<label>Password</label>
        						<input type="password" class="form-control register-input" placeholder="Password" data-js="register-inp-password" name="password">
        						<div class="invalid-feedback"> This field is required. </div>
        					</div>

            			<div class="form-group">
              		  <label>Name</label>
							      <input type="text" class="form-control" data-js="register-inp-name" placeholder="Name" name="name" value="<?php echo htmlspecialchars( $regVal["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              		<div class="invalid-feedback"> This field is required. </div>
            		</div>

            		<button class="btn btn-success" data-js="register-btn-register">Register <br></button>
          		</form>
              </div>
            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>