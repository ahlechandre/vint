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
 * Define as classes adicionais de um componente HTML.
 *
 * @param string $classes
 * @return string
 */
function setClasses($classes)
{

    if (!$classes) {
        return '';
    }

    return " {$classes}";
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
        $classes .= " {$prefix}{$cols}-{$device}";
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
        $classes .= " {$prefix}{$cols}-{$device}";
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
 * Retorna o nome do ícone, dado o seu indexador.
 *
 * @param  string  $name
 * @return null|string
 */
function material_icon($name)
{
    $icons = [
        'users' => 'person',
        'user' => 'person',
        'roles' => 'account_circle',
        'role' => 'account_circle',
        'name' => 'text_format',
        'is_active' => 'check_circle_outline',
        'description' => 'description',
        'created_at' => 'add_box',
        'updated_at' => 'edit',
        'forward' => 'arrow_forward',
        'cities' => 'location_city',
        'city' => 'location_city',
        'places' => 'place',
        'place_origin' => 'place',
        'place_destination' => 'place',
        'addresses' => 'directions',
        'phones' => 'phone',
        'clients' => 'people',
        'client' => 'people',
        'affiliates' => 'domain',
        'affiliate' => 'domain',
        'drivers' => 'drive_eta',
        'vehicle_body_types' => 'panorama_horizontal',
        'vehicle_body_type' => 'panorama_horizontal',
        'vehicle_types' => 'drive_eta',
        'vehicle_type' => 'drive_eta',
        'password' => 'vpn_key',
        'identification_number' => 'perm_identity',
        'email' => 'mail_outline',
        'points' => 'timeline',
        'plate' => 'local_activity',
        'freights' => 'local_shipping',
        'freight' => 'local_shipping',
        'id' => 'details',
        'itinerary' => 'directions',
        'travels' => 'map',
        'travel' => 'map',
        'fare_price' => 'money',
        'driver' => 'drive_eta',
        'travel_status' => 'pin_drop',
        'localizations' => 'beenhere',
        'localization' => 'beenhere',
    ];

    return isset($icons[$name]) ? $icons[$name] : null;
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
