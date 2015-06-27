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
	$options_phonecodes = array('' => "DDD");
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
        <div id="phones">
            <div class="control-group">
                <label for="phone" class="control-label">Telefone</label>
                <div class="controls">
                    <?=form_dropdown('code[]', $options_phonecodes, set_value('code'), 'class="span2"')?>
                    <input type="text" name="phone[]" maxlength="9" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                </div>
            </div>
        </div>
        <div class="control-group">
            <label for="new-phone" class="control-label"></label>
            <div class="controls">
                <input type="button" name="new-phone" id="new-phone" class="btn" value="Adicionar telefone" />
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Adicionar</button>
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
