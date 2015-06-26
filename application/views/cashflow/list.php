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
                Movimentações
            </a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst('Movimentações');?>
            <a href="<?php echo site_url() . $this->uri->segment(1); ?>/add" class="btn btn-success">Adicionar</a>
        </h2>
    </div>

    <div class="row">
        <div class="span12 columns">
            <div class="well">

            <?php

            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
            echo form_open('cashflow', $attributes);

                echo form_label('Buscar:', 'search_string');
                echo form_input('search_string', $search_string_selected, 'style="width: 100px;"');

                echo form_label('Ordenar:', 'order');
                $keys = array_keys($cashflows[0]);
                $columns = array_combine($keys, $keys);
                echo form_dropdown('order', $columns, $orderby, 'class="span2" style="width: 80px"');

                $options_order_type = array('ASC' => 'Crescente', 'DESC' => 'Decrescente');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span2" style="width: 100px"');

                echo form_label('Data inicial:', 'initial_date');
                echo form_input('initial_date', $initial_date, 'class="datepicker" style="width: 70px;"');

                echo form_label('Data final:', 'final_date');
                echo form_input('final_date', $final_date, 'class="datepicker" style="width: 70px;"');

                echo form_submit(array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go', 'style' => 'margin-left: 15px'));

            echo form_close();
            ?>

            </div>

            <h2>
            <?php
            if ($profit == NULL) {
            ?>
                Nenhuma movimentação no período
            <?php
            } else {
            ?>
                Caixa no período: R$ <?=number_format($profit, 2, ',', '')?>
            <?php
            }
            ?>
            </h2>
            <br />

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">ID</th>
                        <th class="red header">Descrição</th>
                        <th class="yellow header">Valor</th>
                        <th class="green header">Tipo</th>
                        <th class="red header">Data</th>
                        <th class="red header">CPF do funcionário</th>
                    </tr>
                </thead>
            <tbody>
                <?php
                foreach($cashflows as $row)
                {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . (empty($row['descricao']) ? '<i>SEM DESCRIÇÃO</i>' : $row['descricao']) . '</td>';
                echo '<td>R$ ' . number_format($row['valor'], 2, ',', '') . '</td>';
                echo '<td>' . ($row['tipo'] === 'c' ? 'Compra' : 'Venda') . '</td>';
                echo '<td>' . DateTime::createFromFormat('Y-m-d', $row['data_movimentacao'])->format('d/m/Y') . '</td>';
                echo '<td>' . $row['cpf'] . '</td>';
                echo '<td class="crud-actions">
                    <a href="' . site_url() . 'cashflow/update/' . $row['id'] . '" class="btn btn-info">ver e editar</a>
                    <a href="' . site_url() . 'cashflow/delete/' . $row['id'] . '" class="btn btn-danger">remover</a>
                    </td>';
                echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
