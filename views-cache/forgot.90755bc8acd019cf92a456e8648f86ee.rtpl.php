<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Forgot the password?<br></div>
                        <?php if( $error !== '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                          <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="/forgot" method="POST" data-js="login-form-main">
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <input type="email" class="form-control" data-js="login-inp-email" placeholder="Email adress" name="email">
                                        </div>

                                        <button class="btn btn-success" data-js="login-btn-login">Send <br></button>
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
