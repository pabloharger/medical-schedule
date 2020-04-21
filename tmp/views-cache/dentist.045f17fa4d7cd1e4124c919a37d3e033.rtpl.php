<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"> <?php echo L('header_menu_dentist'); ?><br>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div data-js="dentist-form-main">
                  <div class="form-group">
                    <select data-js="dentist-sel-dentist"></select>
                  </div>
                  <div class="form-group">
                    <label><?php echo L('interface_label_firstName'); ?></label>
                    <input type="text" class="form-control dentist-input" placeholder="<?php echo L('interface_label_firstName'); ?>" data-js="dentist-inp-firstName" required>
                    <div class="invalid-feedback">
                      This field is required.
                    </div>
                  </div>
                  <div class="form-group">
                    <label><?php echo L('interface_label_lastName'); ?></label>
                    <input type="text" class="form-control dentist-input" placeholder="<?php echo L('interface_label_lastName'); ?>" data-js="dentist-inp-lastName" required>
                    <div class="invalid-feedback">
                      This field is required.
                    </div>
                  </div>
                  <div class="form-group">
                    <label><?php echo L('interface_label_docNumber'); ?></label>
                    <input type="text" class="form-control dentist-input" placeholder="<?php echo L('interface_label_docNumber'); ?>" data-js="dentist-inp-doc-number">
                  </div>
                  <button class="btn btn-success" data-js="dentist-btn-save"><?php echo L('interface_button_save'); ?> <br></button>
                  <button class="btn btn-primary" data-js="dentist-btn-new"><?php echo L('interface_button_new'); ?> <br></button>
                  <button class="btn btn-primary" data-js="dentist-btn-clear"><?php echo L('interface_button_clear'); ?> <br></button>
                  <button class="btn btn-danger" data-js="dentist-btn-del"><?php echo L('interface_button_delete'); ?> <br></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="res/site/js/controller/dentist.js"></script>