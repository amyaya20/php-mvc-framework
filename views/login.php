<?php

  $this-> title = 'Login';

?>

<h1>Login</h1> 

<?php use amohd12\phpmvc\form\Form; ?>

<?php $form = Form::begin('', "post"); ?>

  <?php echo $form-> field($model, 'email') ?>
  <?php echo $form-> field($model, 'password')->passwordField() ?>
  <button type="submit" class="btn btn-primary">Submit</button>


<?php Form::end(); ?>


