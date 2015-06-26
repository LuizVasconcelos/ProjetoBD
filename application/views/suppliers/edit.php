<div class="container top">
    <ul class="breadcrumb">
        <li>
            <a href="<?=site_url() . $this->uri->segment(1)?>">
                Fornecedores
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
            Atualizando Fornecedor
        </h2>
    </div>

    <?php
    if (isset($flash_message))
    {
        if ($flash_message == TRUE)
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Fornecedor atualizado com sucesso.';
            echo '</div>';
        }
        else
        {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Erro ao tentar atualizar Fornecedor.';
            echo '</div>';
        }
    }

    // form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    // form validation
    echo validation_errors();

    echo form_open('suppliers/update/' . $this->uri->segment(3), $attributes);
    ?>
    <fieldset>
        <div class="control-group">
          <label for="cnpj" class="control-label">CNPJ</label>
          <div class="controls">
            <input type="text" id="" name="cnpj" readonly value="<?=$supplier['cnpj']?>" >
          </div>
        </div>
        <div class="control-group">
          <label for="name" class="control-label">Nome</label>
          <div class="controls">
            <input type="text" id="" name="name" value="<?=$supplier['nome']?>" >
          </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Adicionar</button>
            <button class="btn" type="reset">Cancelar</button>
        </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>
