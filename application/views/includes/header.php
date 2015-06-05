<!DOCTYPE html> 
<html lang="en-US">
<head>
  <title>ProjetoBD</title>
  <meta charset="utf-8">
  <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
	      <a class="brand">ProjetoBD</a>
	      <ul class="nav">
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
            <!--
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo base_url(); ?>logout">Logout</a>
                </li>
              </ul>
            </li>
            -->
	      </ul>
	    </div>
	  </div>
	</div>	
