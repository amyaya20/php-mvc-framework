<?php
use amohd12\phpmvc\form\Form;
use amohd12\phpmvc\form\TextareaField;

  $this-> title = 'Contact';

?>

<h1>Contact us</h1> 

<?php $form = Form::begin('', 'post'); ?>



<?php echo $form-> field($model, 'subject'); ?>
<?php echo $form-> field($model, 'email'); ?>
<?php echo new TextareaField($model, 'body')  ?>

<button type="submit" class="btn btn-primary">Submit</button>

<?php Form::end(); ?>

<!-- <form action="" method="post">
  <div class="mb-3">
    <label >Subject</label>
    <input type="text" name="subject" class="form-control" >
  </div>

  <div class="mb-3">
    <label >Email</label>
    <input type="email" name="email" class="form-control" >
  </div>

  <div class="mb-3">
    <label >Body</label>
    <textarea  name="body" class="form-control" > </textarea>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form> -->