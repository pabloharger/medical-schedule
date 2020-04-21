<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"> <?php echo L('interface_signIn_signIn'); ?><br></div>
            <?php if( $error !== '' ){ ?>

              <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

              </div>
            <?php } ?>


            <?php if( $info !== '' ){ ?>

              <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars( $info, ENT_COMPAT, 'UTF-8', FALSE ); ?>

              </div>
            <?php } ?>


            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <form action="/account/signin" method="POST" data-js="login-form-main">
                    <div class="form-group">
                      <label><?php echo L('interface_label_email'); ?></label>
                      <input type="email" class="form-control" data-js="login-inp-email" placeholder="<?php echo L('interface_label_email'); ?>" name="email">
                    </div>
                    <div class="form-group">
                      <label><?php echo L('interface_label_password'); ?></label>
                      <input type="password" class="form-control login-input" placeholder="<?php echo L('interface_label_password'); ?>" data-js="login-inp-password" name="password">
                    </div>

                    <div class="form-group">
                      <div class="row ml-1">
                        <small class="form-text text-muted"><a href="/account/forgot"><?php echo L('interface_label_forgotPassword'); ?></a></small>
                        <div class="ml-auto mr-3">
                          <small class="form-text text-muted"><a href="/account/activate"><?php echo L('interface_label_resendActivationCode'); ?></a></small>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <button class="btn btn-success" data-js="login-btn-login"><?php echo L('interface_button_signIn'); ?> <br></button>
                        <a class="btn btn-info float-right" data-js="login-btn-signup" href="/account/signup"><?php echo L('interface_label_signUp'); ?></a>
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