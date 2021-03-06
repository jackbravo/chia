<?php

class axaiWidgetFormJQuerySelect extends sfWidgetFormDoctrineChoice
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('url');
    $this->addRequiredOption('parent');

    parent::configure($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if (false !== $empty = $this->getOption('add_empty'))
    {
      $label = true === $empty ? '' : $empty;
      $first_option = '<option value="">' . $label . '</option>';
    }
    else
    {
      $first_option = '';
    }

    return parent::render($name, $value, $attributes, $errors).
           sprintf("
<script type='text/javascript'>
\$(function(){
  \$('#%s').change(function(){
    \$.getJSON('%s', { id: \$(this).val() }, function(data){
      var options = '%s';
      for (key in data) {
        options += '<option value=\"' + key + '\">' + data[key] + '</option>';
      }
      \$('#%s').html(options);
    })
  })
})
</script>
"
      ,
      $this->generateId($this->getOption('parent')),
      $this->getOption('url'),
      $first_option,
      $this->generateId($name)
    );
  }
}
