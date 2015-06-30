<!DOCTYPE html>
<html lang="en-US">
<head>
  <title>ProjetoBD</title>
  <meta charset="utf-8">
  <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/css/jquery-ui.theme.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/css/jquery-ui.structure.min.css" rel="stylesheet" type="text/css">
  <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/admin.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript">
  $(function() {
      $(".datepicker").datepicker({
          dateFormat: "dd/mm/yy"
      })
  });
  </script>
</head>
<body>
	<div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
	      <a class="brand">AdminGas</a>
	      <ul class="nav">
            <li <?php if ($this->uri->segment(1) == 'cashflow') { echo 'class="active"'; } ?>>
              <a href="<?=base_url()?>cashflow">Movimentação</a>
            </li>
	        <li <?php if ($this->uri->segment(1) == 'products') { echo 'class="active"'; } ?>>
	          <a href="<?=base_url()?>products">Produtos</a>
	        </li>
            <?php if ($this->session->userdata('is_manager')) { ?>
	        <li <?php if ($this->uri->segment(1) == 'employees') { echo 'class="active"'; } ?>>
	          <a href="<?=base_url()?>employees">Funcionários</a>
	        </li>
            <?php } ?>
	        <li <?php if ($this->uri->segment(1) == 'suppliers') { echo 'class="active"'; } ?>>
	          <a href="<?=base_url()?>suppliers">Fornecedores</a>
	        </li>
	        <li>
	          <a href="<?=base_url(); ?>logout">Logout</a>
	        </li>
	      </ul>
	    </div>
	  </div>
	</div>
