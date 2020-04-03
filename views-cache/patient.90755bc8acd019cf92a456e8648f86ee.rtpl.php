<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header"> Patient
                  <br> 
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
                                        <label>Name</label>
                                        <input type="text" class="form-control patient-input" placeholder="Name" data-js="patient-inp-name">
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Document Number</label>
                                        <input type="text" class="form-control patient-input" placeholder="Document Number" data-js="patient-inp-doc-number">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control patient-input" placeholder="Phone Number" data-js="patient-inp-phone-number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile Phone Number</label>
                                        <input type="text" class="form-control patient-input" placeholder="Mobile Phone Number" data-js="patient-inp-cell-phone-number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control patient-input" placeholder="Email" data-js="patient-inp-email" type="email">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Street</label>
                                        <input type="text" class="form-control patient-input" placeholder="Street" data-js="patient-inp-street">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Number</label>
                                        <input type="text" class="form-control patient-input" placeholder="Number" data-js="patient-inp-number">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control patient-input" placeholder="City" data-js="patient-inp-city">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" class="form-control patient-input" placeholder="State" data-js="patient-inp-state">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Zip Code</label>
                                        <input type="text" class="form-control patient-input" placeholder="Zip Code" data-js="patient-inp-zip-code">
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-success" data-js="patient-btn-save">
                                Save
                                <br>
                            </button>
                            <button class="btn btn-primary" data-js="patient-btn-new">New
                              <br>
                            </button>
                            <button class="btn btn-primary" data-js="patient-btn-clear">Clear
                                <br>
                            </button>
                            <button class="btn btn-danger" data-js="patient-btn-del">Delete
                                <br>
                            </button>
                          </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script src="res/site/js/controller/patient.js"></script>
