<h1>ចូលប្រើ</h1>
<p>សូមវាយ email/username និងលេខសំងាត់ក្នុងប្រអប់ខាងក្រោម៖</p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("authorize/login");?>

  <p>
    <label for="identity">Email/Username:</label>
    <?php echo form_input($identity);?>
  </p>

  <p>
    <label for="password">លេខសំងាត់:</label>
    <?php echo form_input($password);?>
  </p>

  <p>
    <label for="remember">ចាំខ្ញុំ:</label>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <p><?php echo form_submit('submit', 'ចូល');?></p>

<?php echo form_close();?>

<p><a href="forgot_password">ភ្លេចលេខសំងាត់?</a></p>