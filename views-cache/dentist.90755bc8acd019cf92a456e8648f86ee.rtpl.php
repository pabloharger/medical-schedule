<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"> Dentist<br></div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div data-js="dentist-form-main">
                    <div class="form-group">
                      <select data-js="dentist-sel-dentist"></select>
                    </div>
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control dentist-input" placeholder="Name" data-js="dentist-inp-name" required>
                      <div class="invalid-feedback"> This field is required. </div>
                    </div>
                    <div class="form-group">
                      <label>Document Number</label>
                      <input type="text" class="form-control dentist-input" placeholder="Document Number" data-js="dentist-inp-doc-number">
                    </div>
                  
                    <button class="btn btn-success" data-js="dentist-btn-save">Save <br></button>
                    <button class="btn btn-primary" data-js="dentist-btn-new">New <br></button>
                    <button class="btn btn-primary" data-js="dentist-btn-clear">Clear <br></button>
                    <button class="btn btn-danger" data-js="dentist-btn-del">Delete <br></button>
                  </div>
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