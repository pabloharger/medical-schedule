<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"><?php echo L('interface_label_resendActivationCode'); ?><br></div>
            <?php if( $error !== '' ){ ?>

            <div class="alert alert-danger" role="alert">
              <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

            </div>
            <?php } ?>

            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <form action="/account/activate" method="POST" data-js="login-form-main">
                    <div class="form-group">
                      <label><?php echo L('interface_label_email'); ?></label>
                      <input type="email" class="form-control signup-input" placeholder="<?php echo L('interface_label_email'); ?>" data-js="activation-inp-email" name="email">
                    </div>
                    <div class="invalid-feedback">
                      This field is required.
                    </div>
                    <button class="btn btn-success" data-js="forgot-btn-save"><?php echo L('interface_button_resend'); ?><br></button>
                    <a href="/account/signin" class="btn btn-primary pull-right" role="button" aria-pressed="true"><?php echo L('interface_button_signIn'); ?></a>
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