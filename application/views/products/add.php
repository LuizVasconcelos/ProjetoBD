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
        <li class="active">New</li>
    </ul>

    <div class="page-header">
        <h2>
            Adding <?=ucfirst($this->uri->segment(1))?>
        </h2>
    </div>

    <?php
    if (isset($flash_message))
    {
        if ($flash_message == TRUE)
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Produto cadastrado com sucesso.';
            echo '</div>';       
        }
        else
        {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'Falha ao tentar cadastrar produto.';
            echo '</div>';          
        }
    }

    // form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    // form validation
    echo validation_errors();

    echo form_open('products/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
          <label for="name" class="control-label">Nome</label>
          <div class="controls">
            <input type="text" id="" name="name" value="<?=set_value('name')?>" >
          </div>
        </div>
        <div class="control-group">
          <label for="description" class="control-label">Descrição</label>
          <div class="controls">
            <input type="text" id="" name="description" value="<?=set_value('description')?>">
          </div>
        </div>
        <div class="control-group">
          <label for="price" class="control-label">Preço</label>
          <div class="controls">
            <input type="text" name="price" value="<?=set_value('price')?>">
            <span class="help-inline">Ex: 1200,00</span>
          </div>
        </div>
        <div class="control-group">
          <label for="amount" class="control-label">Quantidade</label>
          <div class="controls">
            <input type="text" name="amount" value="<?=set_value('amount')?>">
          </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Adicionar</button>
            <button class="btn" type="reset">Cancelar</button>
        </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>
