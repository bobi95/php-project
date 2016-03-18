<?php namespace App\Helpers;


use App\Core\HttpContext;

class Html {
    private static function esc($output) {
        if (isset($output)) {
            return htmlspecialchars($output);
        }
        return '';
    }

    private static function buildLink($action, $controller = null, $params = []) {
        return HttpContext::instance()->getRoute()->getUrlForAction($action, $controller, $params);
    }

    private static function printAttr($attr) {
        $result = '';
        if(!empty($attr)) {

            foreach ($attr as $k => $v) {
                $result .= escape(" {$k}=\"{$v}\"");
            }
        }

        return $result;
    }

    public function url($action, $controller = null, $params = []) {
        return self::buildLink($action, $controller, $params);
    }

    public function link($text, $action, $controller = null, $params = [], $attr = []) { ?>
        <a href="<?=self::buildLink($action, $controller, $params)?>"<?=self::printAttr($attr)?>><?=self::esc($text)?></a>
    <?php
    }

    public function label($text, $for, $attr = []) { ?>
        <label for="<?=escape($for)?>"<?=self::printAttr($attr)?>><?=escape($text)?></label>
<?php }

    public function textField($name, $type = 'text', $value = null, $id = null, $attr = []) { ?>
      <input type="<?=escape($type)?>" name="<?=escape($name)?>" id="<?=(isset($id) ? escape($id) : escape($name))
      ?>"<?=(isset($value) ? " value=\"" . escape($value) . "\"" : '')
      ?><?=self::printAttr($attr)?>>
<?php }

    public function formError($text) {
        if ($text) { ?>
            <span class="help-block"><?= $text ?></span>
        <?php }
    }
}