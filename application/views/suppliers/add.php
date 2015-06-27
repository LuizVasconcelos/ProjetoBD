<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?=site_url() . $this->uri->segment(1)?>">
                Fornecedores
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?=site_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2)?>">
                Adicionar
            </a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adicionando Fornecedor
        </h2>
    </div>

    <?php
    if (isset($flash_message))
    {
        if ($flash_message == TRUE)
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Fornecedor cadastrado com sucesso.';
            echo '</div>';
        }
        else
        {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Erro ao tentar cadastrar fornecedor.';
            echo '</div>';
        }
    }

    // form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');
	$options_phonecodes = array('' => "Código");
    foreach ($phonecodes as $row)
        $options_phonecodes[$row['id']] = $row['codigo'];
	
    // form validation
    echo validation_errors();

    echo form_open('suppliers/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
          <label for="cnpj" class="control-label">CNPJ</label>
          <div class="controls">
            <input type="text" id="" name="cnpj" value="<?=set_value('cnpj')?>" >
          </div>
        </div>
        <div class="control-group">
          <label for="name" class="control-label">Nome</label>
          <div class="controls">
            <input type="text" id="" name="name" value="<?=set_value('name')?>" >
          </div>
        </div>
		<?php
            echo '<div class="control-group">';
            echo '<label for="phone" class="control-label">Telefone</label>';
            echo '<div class="controls">';
            echo form_dropdown('code', $options_phonecodes, set_value('code'), 'class="span2"');
			echo '<input type="text" name="phone" maxlength="9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">';
            echo '</div>';
            echo '</div>';
        ?>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Adicionar</button>
            <button class="btn" type="reset">Cancelar</button>
        </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>
