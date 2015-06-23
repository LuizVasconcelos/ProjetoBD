<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?=site_url() . $this->uri->segment(1)?>">
                <?=ucfirst($this->uri->segment(1))?>
            </a>
                <span class="divider">/</span>
        </li>
        <li>
            <a href="<?=site_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2)?>">
                <?=ucfirst($this->uri->segment(2))?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">Novo</li>
    </ul>

    <div class="page-header">
        <h2>
            Adicionando Movimentação
        </h2>
    </div>

    <?php
    if (isset($flash_message))
    {
        if ($flash_message == TRUE)
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Movimentação cadastrada com sucesso.';
            echo '</div>';
        }
        else
        {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Erro ao tentar cadastrar movimentação.';
            echo '</div>';
        }
    }

    // form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    // form validation
    echo validation_errors();

    echo form_open('cashflow/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <div class="control-group">
                <label for="description" class="control-label">Descrição</label>
                <div class="controls">
                    <input type="text" id="" name="description" value="<?=set_value('description')?>">
                </div>
            </div>
            <div class="control-group">
                <label for="price" class="control-label">Valor</label>
                <div class="controls">
                    <input type="text" name="price" value="<?=set_value('price')?>">
                    <span class="help-inline">Ex: 1200,00</span>
                </div>
            </div>
            <div class="control-group">
                <label for="type" class="control-label">Tipo</label>
                <div class="controls">
                    <?=form_dropdown('type', array('' => 'Selecionar', 'c' => 'Compra', 'v' => 'Venda'), '', 'class="span2"')?>
                </div>
            </div>
            <input type="hidden" name="cpf" value="<?=$this->session->userdata('user_name')?>" />
            <input type="hidden" name="date" value="<?=date('Y-m-d')?>" />
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Adicionar</button>
                <button class="btn" type="reset">Cancelar</button>
            </div>
        </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>
