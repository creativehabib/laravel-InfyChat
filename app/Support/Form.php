<?php

namespace App\Support;

use Illuminate\Support\Collection;
use function csrf_field;
use function route;
use function url;

class Form
{
    public static function open(array $options = []): string
    {
        $method = strtoupper($options['method'] ?? 'POST');
        $action = $options['action'] ?? null;

        if (isset($options['route'])) {
            $route = $options['route'];
            if (is_array($route)) {
                $name = array_shift($route);
                $action = route($name, $route);
            } else {
                $action = route($route);
            }
        } elseif (isset($options['url'])) {
            $action = url($options['url']);
        }

        $attributes = $options;
        unset($attributes['method'], $attributes['route'], $attributes['url'], $attributes['action']);

        if (!empty($attributes['files'])) {
            $attributes['enctype'] = 'multipart/form-data';
            unset($attributes['files']);
        }

        $attr = self::attributes($attributes);
        $hiddenMethod = '';
        $formMethod = $method;

        if (!in_array($method, ['GET', 'POST'])) {
            $hiddenMethod = '<input type="hidden" name="_method" value="'.$method.'">';
            $formMethod = 'POST';
        }

        $csrf = csrf_field();
        $actionAttr = $action ? ' action="'.$action.'"' : '';

        return '<form method="'.$formMethod.'"'.$actionAttr.$attr.'>' . "\n"
            .$csrf.$hiddenMethod;
    }

    public static function model($model, array $options = []): string
    {
        return self::open($options);
    }

    public static function close(): string
    {
        return '</form>';
    }

    public static function label(string $name, string $value, array $options = []): string
    {
        $attr = self::attributes($options);
        return '<label for="'.$name.'"'.$attr.'>'.$value.'</label>';
    }

    public static function text(string $name, $value = null, array $options = []): string
    {
        return self::input('text', $name, $value, $options);
    }

    public static function email(string $name, $value = null, array $options = []): string
    {
        return self::input('email', $name, $value, $options);
    }

    public static function password(string $name, array $options = []): string
    {
        return self::input('password', $name, '', $options);
    }

    public static function hidden(string $name, $value = null, array $options = []): string
    {
        return self::input('hidden', $name, $value, $options);
    }

    public static function file(string $name, array $options = []): string
    {
        return self::input('file', $name, null, $options);
    }

    public static function radio(string $name, $value = null, bool $checked = false, array $options = []): string
    {
        if ($checked) {
            $options['checked'] = 'checked';
        }
        return self::input('radio', $name, $value, $options);
    }

    public static function checkbox(string $name, $value = null, bool $checked = false, array $options = []): string
    {
        if ($checked) {
            $options['checked'] = 'checked';
        }
        return self::input('checkbox', $name, $value, $options);
    }

    public static function textarea(string $name, $value = null, array $options = []): string
    {
        $attr = self::attributes($options);
        return '<textarea name="'.$name.'"'.$attr.'>'
            .htmlspecialchars((string) ($value ?? ''), ENT_QUOTES)
            .'</textarea>';
    }

    public static function select(string $name, array|Collection $list = [], $selected = null, array $options = []): string
    {
        $attr = self::attributes($options);
        $multiple = isset($options['multiple']) || in_array('multiple', $options, true);
        $nameAttr = $name;
        if ($multiple && substr($name, -2) !== '[]') {
            $nameAttr .= '[]';
        }

        $html = '<select name="'.$nameAttr.'"'.$attr.'>';
        foreach ($list as $value => $display) {
            $isSelected = false;
            if (is_array($selected)) {
                $isSelected = in_array($value, $selected);
            } elseif ($selected !== null) {
                $isSelected = (string) $value === (string) $selected;
            }
            $html .= '<option value="'.htmlspecialchars((string) $value, ENT_QUOTES).'"'
                .($isSelected ? ' selected' : '').'>'
                .htmlspecialchars((string) $display, ENT_QUOTES).'</option>';
        }
        $html .= '</select>';

        return $html;
    }

    public static function button(?string $value = null, array $options = []): string
    {
        $attr = self::attributes($options);
        return '<button'.$attr.'>'.$value.'</button>';
    }

    protected static function input(string $type, string $name, $value = null, array $options = []): string
    {
        $attr = self::attributes($options);
        $valueAttr = $value !== null ? ' value="'.htmlspecialchars((string) $value, ENT_QUOTES).'"' : '';
        return '<input type="'.$type.'" name="'.$name.'"'.$valueAttr.$attr.'>';
    }

    protected static function attributes(array $attributes): string
    {
        $attr = '';
        foreach ($attributes as $key => $value) {
            if (is_int($key)) {
                $attr .= ' '.$value;
            } elseif ($value !== null) {
                $attr .= ' '.$key.'="'.htmlspecialchars((string) $value, ENT_QUOTES).'"';
            }
        }

        return $attr;
    }
}

