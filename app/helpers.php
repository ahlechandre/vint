<?php

/**
 * Define os atributos de elementos HTML.
 *
 * @param array $attrs
 * @return string
 */
function setAttributes($attrs)
{
    $htmlAttrs = '';
    $index = 0;
    $scaping = function ($index) {
        return $index === 0 ? '' : ' ';
    };

    foreach ($attrs as $attr => $value) {
        if ($value !== false) {
            $htmlAttrs .= $scaping($index) . $attr . '="' . $value . '"';
            $index++;
        }
    }
    
    echo $htmlAttrs;
}

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
 * Define as classes modificadoras de um componente HTML.
 *
 * @param array $modifiers
 * @return string
 */
function setModifiers($modifiers)
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
function setMaterialCells($cells)
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
function setMaterialCellsWhen($when)
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
function isActivePage($paths)
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
 * @param array $inputs
 * @return boolean
 */
function sanitize_is_active($inputs)
{
    return (
        isset($inputs['is_active']) && $inputs['is_active']
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
function api_response($status, $message = null, $data = null)
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
