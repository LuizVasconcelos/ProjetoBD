<?php 
    $this->load->view('includes/header');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<?php 
    // $main_content is the name we set in $data['main_content']
    $this->load->view($main_content);  
?>
</section><!-- /.content -->

<?php 
    $this->load->view('includes/footer');
?>
