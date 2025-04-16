<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMIS | Log in</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">
        <img src="<?= base_url('assets/img/pasig.jpeg') ?>" width="30%">
        <br>Sign in to start your session
      </p>

      <?php $lockoutTime = $lockout ?? 0; ?>

      <?php if ($lockoutTime > 0): ?>
        <div class="alert alert-warning text-center" id="lockout-alert">
          <strong>Too many login attempts.</strong><br>
          Please wait <span id="lockout-timer"></span> before trying again.
        </div>
      <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <form action="<?= base_url('/auth') ?>" method="post">
        <?= csrf_field() ?>

        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Remember Me</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" id="signInBtn"
              <?= ($lockoutTime > 0) ? 'disabled' : '' ?>>
              <i class='fas fa-sign-in-alt'></i> Sign In
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>

<?php if ($lockoutTime > 0): ?>
<script>
  let secondsLeft = <?= $lockoutTime ?>;
  const timerDisplay = document.getElementById('lockout-timer');
  const signInBtn = document.getElementById('signInBtn');
  const alertBox = document.getElementById('lockout-alert');

  function updateTimer() {
    if (secondsLeft > 0) {
      let minutes = Math.floor(secondsLeft / 60);
      let seconds = secondsLeft % 60;
      timerDisplay.textContent = `${minutes} minute(s) and ${(seconds < 10 ? '0' : '')}${seconds} second(s)`;
      secondsLeft--;
      setTimeout(updateTimer, 1000);
    } else {
      signInBtn.disabled = false;
      alertBox.classList.remove('alert-warning');
      alertBox.classList.add('alert-success');
      alertBox.innerHTML = `<strong>You can now try again.</strong>`;
    }
  }

  updateTimer();
</script>
<?php endif; ?>
</body>
</html>
