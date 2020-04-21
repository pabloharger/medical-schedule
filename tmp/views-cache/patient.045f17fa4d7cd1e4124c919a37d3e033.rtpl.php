<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"><?php echo L('header_menu_patient'); ?> <br> 
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div data-js="patient-form-main">
                  <div class="form-group">
                    <select data-js="patient-sel-patient"></select>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?php echo L('interface_label_firstName'); ?></label>
                        <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_label_firstName'); ?>" data-js="patient-inp-first-name">
                        <div class="invalid-feedback">
                          This field is required.
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?php echo L('interface_label_lastName'); ?></label>
                        <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_label_lastName'); ?>" data-js="patient-inp-last-name">
                        <div class="invalid-feedback">
                          This field is required.
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label><?php echo L('interface_label_docNumber'); ?></label>
                        <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_label_docNumber'); ?>" data-js="patient-inp-doc-number">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?php echo L('interface_patient_phoneNumber'); ?></label>
                        <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_patient_phoneNumber'); ?>" data-js="patient-inp-phone-number">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?php echo L('interface_patient_mobileNumber'); ?></label>
                        <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_patient_mobileNumber'); ?>" data-js="patient-inp-mobile-number">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label><?php echo L('interface_label_email'); ?></label>
                    <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_label_email'); ?>" data-js="patient-inp-email" type="email">
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label><?php echo L('interface_patient_address'); ?></label>
                        <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_patient_address'); ?>" data-js="patient-inp-address">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label><?php echo L('interface_patient_city'); ?></label>
                        <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_patient_city'); ?>" data-js="patient-inp-city">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label><?php echo L('interface_patient_state'); ?></label>
                        <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_patient_state'); ?>" data-js="patient-inp-state">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label><?php echo L('interface_patient_zipCode'); ?></label>
                        <input type="text" class="form-control patient-input" placeholder="<?php echo L('interface_patient_zipCode'); ?>" data-js="patient-inp-zip-code">
                      </div>
                    </div>
                  </div>

                  <button class="btn btn-success" data-js="patient-btn-save"><?php echo L('interface_button_save'); ?><br></button>
                  <button class="btn btn-primary" data-js="patient-btn-new"><?php echo L('interface_button_new'); ?><br></button>
                  <button class="btn btn-primary" data-js="patient-btn-clear"><?php echo L('interface_button_clear'); ?><br></button>
                  <button class="btn btn-danger" data-js="patient-btn-del"><?php echo L('interface_button_delete'); ?><br></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="res/site/js/controller/patient.js"></script>
