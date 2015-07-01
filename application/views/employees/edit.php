<div class="container top">
    <ul class="breadcrumb">
        <li>
            <a href="<?=site_url() . $this->uri->segment(1)?>">
                Funcionários
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?=site_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3)?>">
                Editar
            </a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Atualizando Funcionário
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
            echo 'Funcionário atualizado com sucesso.';
            echo '</div>';
        }
        else
        {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Falha ao tentar atualizar funcionário.';
            echo '</div>';
        }
    }

    // form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    $options_functions = array('' => "Selecionar");
    foreach ($functions as $row)
        $options_functions[$row['id']] = $row['nome'];

	$options_phonecodes = array('' => "DDD");
    foreach ($phonecodes as $row)
        $options_phonecodes[$row['id']] = $row['codigo'];
		
    // form validation
    echo validation_errors();

    echo form_open('employees/update/' . $this->uri->segment(3), $attributes);
    ?>
    <fieldset>
        <div class="control-group">
          <label for="cpf" class="control-label">CPF</label>
          <div class="controls">
            <input type="text" id="" name="cpf" readonly value="<?=$employee['cpf']?>" >
          </div>
        </div>
        <div class="control-group">
          <label for="name" class="control-label">Nome</label>
          <div class="controls">
            <input type="text" id="" name="name" value="<?=$employee['nome']?>">
          </div>
        </div>
        <?php
            echo '<div class="control-group">';
            echo '<label for="function" class="control-label">Função</label>';
            echo '<div class="controls">';
            echo form_dropdown('function', $options_functions, $employee['funcao'], 'class="span2"');
            echo '</div>';
            echo '</div>';
        ?>
        <div class="control-group">
          <label for="salary" class="control-label">Salário</label>
          <div class="controls">
            <input type="text" name="salary" value="<?=$employee['salario']?>">
            <span class="help-inline">Ex: 1200,00</span>
          </div>
        </div>
        <div class="control-group">
          <label for="password" class="control-label">Senha</label>
          <div class="controls">
            <input type="password" name="password" readonly value="<?=$employee['senha']?>">
          </div>
        </div>
        <div id="phones">
    <?php foreach ($phones as $phone) : ?>
            <div class="control-group">
                <label for="phone" class="control-label">Telefone</label>
                <div class="controls">
                    <?=form_dropdown('code[]', $options_phonecodes, intval($phone['codigo']), 'class="span2"')?>
                    <input type="text" name="phone[]" maxlength="9" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?=$phone['numero']?>" />
                </div>
            </div>
    <?php endforeach; ?>
        </div>
        <div class="control-group">
            <label for="new-phone" class="control-label"></label>
            <div class="controls">
                <input type="button" name="new-phone" id="new-phone" class="btn" value="Adicionar telefone" />
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Atualizar</button>
            <button class="btn" type="reset">Cancelar</button>
        </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    $(function() {
        $('#new-phone').click(function() {
            var html = '<div class="control-group">' +
                    '<label for="phone" class="control-label"></label>' +
                    '<div class="controls">' +
                    '<?=preg_replace('/\n/', '', form_dropdown('code[]', $options_phonecodes, '', 'class="span2"'))?>' +
                    '<input type="text" name="phone[]" maxlength="9" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />' +
                    '</div>' +
                    '</div>';
            $('#phones').append(html);
        });
    });
</script>
