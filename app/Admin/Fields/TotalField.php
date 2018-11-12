<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/19
 * Time: 09:02
 */
namespace App\Admin\Fields ;

use Encore\Admin\Form\Field;

class TotalField extends Field\Text {


    protected $view = 'admin.form.input';

    public $mula;
    public $mulb;
    public function mul($mula,$mulb)
    {
        $this->mula = $mula;
        $this->mulb = $mulb;
        return $this;
    }

    protected $symbol = '$';

    protected static $js = [
        '/vendor/laravel-admin/AdminLTE/plugins/input-mask/jquery.inputmask.bundle.min.js',
    ];


    protected $options = [
        'alias'              => 'currency',
        'radixPoint'         => '.',
        'prefix'             => '',
        'removeMaskOnSubmit' => true,
    ];

    public function symbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function prepare($value)
    {
        return (float) $value;
    }


    public function render()
    {

        $options = json_encode($this->options);

        $this->script = <<<EOT
        
$('{$this->getElementClassSelector()}').inputmask($options);
$(document).on('click', "{$this->getElementClassSelector()}", function (e) {

    var mula = $(this).parent().parent().parent().parent().find('#{$this->mula}').inputmask('unmaskedvalue');
    var mulb = $(this).parent().parent().parent().parent().find('#{$this->mulb}').inputmask('unmaskedvalue');
    this.value = mula*mulb;
       
});


EOT;
        $this->prepend($this->symbol)
            ->defaultAttribute('style', 'width: 120px');
        return parent::render();
    }


}