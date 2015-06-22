    <?php
    if ($this->session->flashdata('error')) {
    ?>
    <div class="well popup">
        <?=$this->session->flashdata('error')?>
    </div>
    <?php
    }
    ?>
    <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?=site_url() . $this->uri->segment(1)?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a>
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php echo ucfirst($this->uri->segment(1));?>
          <a href="<?php echo site_url() . $this->uri->segment(1); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
      </div>

      <div class="row">
        <div class="span12 columns">
          <div class="well">

            <?php

            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
            echo form_open('suppliers', $attributes);

              echo form_label('Buscar:', 'search_string');
              echo form_input('search_string', $search_string_selected, 'style="width: 160px;"');

              echo form_label('Ordenar por:', 'order');
              $keys = array_keys($suppliers[0]);
              $columns = array_combine($keys, $keys);
              echo form_dropdown('order', $columns, $order_selected, 'class="span2"');

              $options_order_type = array('ASC' => 'Crescente', 'DESC' => 'Decrescente');
              echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span2"');

              echo form_label('Submeter:', 'mysubmit');
              echo form_submit(array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go'));

            echo form_close();
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">CNPJ</th>
                <th class="yellow header">Nome</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($suppliers as $row)
              {
                echo '<tr>';
                echo '<td>' . $row['cnpj'] . '</td>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td class="crud-actions">
                  <a href="' . site_url() . 'suppliers/update/' . $row['cnpj'] . '" class="btn btn-info">visualizar e editar</a>
                  <a href="' . site_url() . 'suppliers/delete/' . $row['cnpj'] . '" class="btn btn-danger">remover</a>
                </td>';
                echo '</tr>';
              }
              ?>
            </tbody>
          </table>

      </div>
    </div>
