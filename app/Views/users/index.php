<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">User Accounts</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of User Accounts</h3>
              <div class="float-right">
                <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#AddNewModal">
                  <i class="fa fa-plus-circle fa fw"></i> Add New
                </button>
              </div>
            </div>
            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Phone</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ✅ Add New Modal -->
    <div class="modal fade" id="AddNewModal" tabindex="-1" role="dialog" aria-labelledby="AddNewModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form id="addUserForm">
          <?= csrf_field() ?>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="fa fa-plus-circle fa fw"></i>  Add New</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required />
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required />
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required />
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role">
                      <option value="Admin">Admin</option>
                      <option value="User">User</option>
                      <option value="Guest">Guest</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                 <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                    <option value="Active">Active</option>
                    <option value="In Active">In Active</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" name="phone" class="form-control" required />
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fas fa-times-circle'></i> Cancel</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel"><i class="far fa-edit fa fw"></i> Edit Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editUserForm">
           <?= csrf_field() ?>
          <div class="modal-body">

            <input type="hidden" id="userId" name="id">

             <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id="name" class="form-control" required />
              </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>  

             <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role" id="role">
                      <option value="Admin">Admin</option>
                      <option value="User">User</option>
                      <option value="Guest">Guest</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                 <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="Active">Active</option>
                    <option value="In Active">In Active</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" name="phone" id="phone" class="form-control" required />
            </div>        

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fas fa-times-circle'></i> Cancel</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
</div>
<div class="toasts-top-right fixed" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;"></div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script> const baseUrl = "<?= base_url() ?>"; </script>
<script src="<?= base_url('js/users/users.js') ?>"></script>
<?= $this->endSection() ?>
