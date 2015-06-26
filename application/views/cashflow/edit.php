<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?=site_url() . $this->uri->segment(1)?>">
                Movimentações
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?=site_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2)?>">
                Editar
            </a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Atualizando Movimentação
        </h2>
    </div>

    <?php
    if (isset($flash_message))
    {
        if ($flash_message == TRUE)
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Movimentação atualizada com sucesso.';
            echo '</div>';
        }
        else
        {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Erro ao tentar atualizar movimentação.';
            echo '</div>';
        }
    }

    // form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    // form validation
    echo validation_errors();

    // form open
    echo form_open('cashflow/update/' . $this->uri->segment(3), $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <div class="control-group">
                <label for="description" class="control-label">Descrição</label>
                <div class="controls">
                    <input type="text" id="" name="description" value="<?=$cashflow['descricao']?>">
                </div>
            </div>
            <div class="control-group">
                <label for="price" class="control-label">Valor</label>
                <div class="controls">
                    <input type="text" name="price" value="<?=$cashflow['valor']?>">
                    <span class="help-inline">Ex: 1200,00</span>
                </div>
            </div>
            <div class="control-group">
                <label for="type" class="control-label">Tipo</label>
                <div class="controls">
                    <?=form_dropdown('type', array('' => 'Selecionar', 'c' => 'Compra', 'v' => 'Venda'), $cashflow['tipo'], 'class="span2"')?>
                </div>
            </div>
            <div class="control-group">
                <label for="cpf" class="control-label">CPF do funcionário</label>
                <div class="controls">
                    <input type="text" name="cpf" readonly value="<?=$cashflow['cpf']?>">
                </div>
            </div>
            <div class="control-group">
                <label for="date" class="control-label">Data</label>
                <div class="controls">
                    <input type="text" name="date" readonly value="<?=$cashflow['data_movimentacao']?>">
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Adicionar</button>
                <button class="btn" type="reset">Cancelar</button>
            </div>
        </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>
