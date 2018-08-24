<?php

/**
 * Define os atributos de elementos HTML.
 *
 * @param array $attrs
 * @return string
 */
function set_attrs($attrs)
{
    $htmlAttrs = '';

    foreach ($attrs as $attr => $value) {

        if ($value !== false) {
            $htmlAttrs .= " {$attr}=\"{$value}\"";
        }
    }
    
    echo $htmlAttrs;
}

/**
 *
 * @param array $modifiers
 * @return string
 */
function set_classes($modifiers)
{

    if (!$modifiers) {
        return '';
    }
    $classes = '';

    foreach ($modifiers as $modifier) {
        $classes .= ' ' . $modifier;
    }

    return $classes;
}

/**
 * Define as classes de células responsivas do componente.
 *
 * @param  null|string  $cells
 * @return string
 */
function set_mdc_cells($cells)
{
    if (!$cells) {
        return '';
    }
  
    $prefix = 'mdc-layout-grid__cell--span-';
    $classes = isset($cells['default']) ?
      " {$prefix}{$cells['default']}" : '';

    unset($cells['default']);
  
    foreach ($cells as $device => $cols) {
        $deviceTrans = $device === 'd' ? 'desktop' : (
            $device === 't' ? 'tablet' : (
                $device === 'p' ? 'phone' : $device
            )
        );
        $classes .= " {$prefix}{$cols}-{$deviceTrans}";
    }
  
    return $classes;
}
  
/**
 * Define as classes de células responsivas do componente.
 *
 * @param  null|string  $when
 * @return string
 */
function set_mdc_cells_when($when)
{
    if (!$when) {
        return '';
    }
  
    $prefix = 'mdc-layout-grid__cell--span-';
    $classes = isset($when['default']) ?
      " {$prefix}{$when['default']}" : '';
    
    unset($when['default']);
  
    foreach ($when as $device => $cols) {
        $deviceTrans = $device === 'd' ? 'desktop' : (
            $device === 't' ? 'tablet' : (
                $device === 'p' ? 'phone' : $device
            )
        );
        $classes .= " {$prefix}{$cols}-{$deviceTrans}";
    }
  
    return $classes;
}

/**
 * Verifica se a página atual corresponde a alguma dos
 * pathanames indicados.
 *
 * @param  string|array  $paths
 * @return bool
 */
function is_active_page($paths)
{
    $requested = request()->path();

    if (is_string($paths)) {
        return $requested === $paths;
    }

    foreach ($paths as $path) {
        if (substr($requested, 0, strlen($path)) === $path) {
            return true;
        }
    }

    return false;
}

/**
 *
 * @param  array  $inputs
 * @param  string  $field
 * @return boolean
 */
function sanitize_bool_input($inputs, $field)
{
    return (
        isset($inputs[$field]) && $inputs[$field]
    ) ? true : false;
}

/**
 * Monta uma mensagem de resposta personalizada para API.
 *
 * @param  int  $status
 * @param  null|string  $message
 * @param  null|array  $data
 * @return stdClass
 */
function repository_response($status, $message = null, $data = null)
{
    switch ($status) {
        case 200: {
            return (object) [
                'success' => true,
                'status' => $status,
                'message' => $message ?? 'Requisição processada com sucesso',
                'data' => $data ?? [],
            ];
        }
        case 403: {
            return (object) [
                'success' => false,
                'status' => $status,
                'message' => $message ?? 'Permissão negada',
                'data' => $data ?? [],
            ];
        }
        default: {
            return (object) [
                'success' => false,
                'status' => $status,
                'message' => $message ?? 'Ops, algo deu errado',
                'data' => $data ?? [],
            ];
        } 
    }
}

/**
 *
 * @param array $componentProps
 * @param array $classes
 * @return array
 */
function component_with_classes($componentProps, $classes)
{
    return array_merge_recursive($componentProps, [
        'classes' => $classes
    ]);
}

/**
 *
 * @param array $componentProps
 * @param array $attrs
 * @return array
 */
function component_with_attrs($componentProps, $attrs)
{
    return array_merge_recursive($componentProps, [
        'attrs' => $attrs
    ]);
}

/**
 *
 * @param array $componentProps
 * @param array $props
 * @return array
 */
function component_with_props($componentProps, $props)
{
    return array_merge($componentProps, $props);
}