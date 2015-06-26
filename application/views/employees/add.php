<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?=site_url() . $this->uri->segment(1)?>">
                Funcionários
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
            Adicionando Funcionário
        </h2>
    </div>

    <?php
    // flash messages
    if (isset($flash_message))
    {
        if ($flash_message == TRUE)
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Funcionário cadastrado com sucesso.';
            echo '</div>';
        }
        else
        {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Falha ao tentar cadastrar funcionário.';
            echo '</div>';
        }
    }

    // form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    $options_functions = array('' => "Selecionar");
    foreach ($functions as $row)
        $options_functions[$row['id']] = $row['nome'];

    // form validation
    echo validation_errors();

    echo form_open('employees/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
          <label for="cpf" class="control-label">CPF</label>
          <div class="controls">
            <input type="text" id="" name="cpf" value="<?=set_value('cpf')?>" >
          </div>
        </div>
        <div class="control-group">
          <label for="name" class="control-label">Nome</label>
          <div class="controls">
            <input type="text" id="" name="name" value="<?=set_value('name')?>">
          </div>
        </div>
        <?php
            echo '<div class="control-group">';
            echo '<label for="function" class="control-label">Função</label>';
            echo '<div class="controls">';
            echo form_dropdown('function', $options_functions, set_value('function'), 'class="span2"');
            echo '</div>';
            echo '</div>';
        ?>
        <div class="control-group">
          <label for="salary" class="control-label">Salário</label>
          <div class="controls">
            <input type="text" name="salary" value="<?=set_value('salary')?>">
            <span class="help-inline">Ex: 1200,00</span>
          </div>
        </div>
        <div class="control-group">
          <label for="password" class="control-label">Senha</label>
          <div class="controls">
            <input type="password" name="password" value="<?=set_value('password')?>">
          </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Adicionar</button>
            <button class="btn" type="reset">Cancelar</button>
        </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>
