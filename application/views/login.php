<!DOCTYPE html> 
<html lang="en-US">
  <head>
    <title>ProjetoBD</title>
    <meta charset="utf-8">
    <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="container login">
      <?php 
      $attributes = array('class' => 'form-signin center');
      echo form_open('login/validate_credentials', $attributes);
      echo '<h2 class="form-signin-heading center">Login</h2>';
      echo form_input('user_name', '', 'placeholder="Usuário" class="center"');
      echo form_password('password', '', 'placeholder="Senha" class="center"');
      if (isset($message_error) && $message_error)
      {
          echo '<div class="alert alert-error">';
          echo '<a class="close" data-dismiss="alert">×</a>';
          echo '<strong>Nome de usuário ou senha inválidos. Tente novamente.';
          echo '</div>';             
      }
      echo "<br />";
      echo form_submit('submit', 'Login', 'class="btn btn-large btn-primary center"');
      echo form_close();
      ?>      
    </div>
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>    
    
