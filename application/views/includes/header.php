<!DOCTYPE html> 
<html lang="en-US">
<head>
  <title>CodeIgniter Admin Sample Project</title>
  <meta charset="utf-8">
  <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
	      <a class="brand">ProjetoBD</a>
	      <ul class="nav">
	        <li <?php if ($this->uri->segment(1) == 'reports') { echo 'class="active"'; } ?>>
	          <a href="<?php echo base_url(); ?>reports">Relatórios</a>
	        </li>
	        <li <?php if( $this->uri->segment(1) == 'manufacturers'){ echo 'class="active"'; } ?>>
	          <a href="<?php echo base_url(); ?>manufacturers">Manufacturers</a>
	        </li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li>
	              <a href="<?php echo base_url(); ?>logout">Logout</a>
	            </li>
	          </ul>
	        </li>
	      </ul>
	    </div>
	  </div>
	</div>	
