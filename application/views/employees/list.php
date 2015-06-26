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
            Funcionários
          </a>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php echo ucfirst('Funcionário');?>
          <a href="<?php echo site_url() . $this->uri->segment(1); ?>/add" class="btn btn-success">Adicionar</a>
        </h2>
      </div>

      <div class="row">
        <div class="span12 columns">
          <div class="well">

            <?php
            // remove 'funcao_id' and 'funcao_nome' from list for combobox
            $list = $employees;
            for ($i = 0; $i < count($list); $i++) {
                unset($list[$i]['funcao_id']);
                unset($list[$i]['funcao_nome']);
            }

            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
            echo form_open('employees', $attributes);

              echo form_label('Buscar:', 'search_string');
              echo form_input('search_string', $search_string_selected, 'style="width: 160px;"');

              echo form_label('Ordenar por:', 'order');
              $keys = array_keys($list[0]);
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
                <th class="header">CPF</th>
                <th class="yellow header headerSortDown">Nome</th>
                <th class="green header">Função</th>
                <th class="red header">Salário</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($employees as $row)
              {
                echo '<tr>';
                echo '<td>' . $row['cpf'] . '</td>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['funcao_nome'] . '</td>';
                echo '<td>' . $row['salario'] . '</td>';
				#adicionar aqui os goddamns telefones
                echo '<td class="crud-actions">
                  <a href="' . site_url() . 'employees/update/' . $row['cpf'] . '" class="btn btn-info">ver e editar</a>
                  <a href="' . site_url() . 'employees/delete/' . $row['cpf'] . '" class="btn btn-danger">remover</a>
                </td>';
                echo '</tr>';
              }
              ?>
            </tbody>
          </table>

      </div>
    </div>
