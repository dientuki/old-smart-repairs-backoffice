<?php

/**
 * https://tutsforweb.com/creating-helpers-laravel/
 */
if (! function_exists('load_resource')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param  string  $resource
     * @param  boolean  $url
     * @return string
     *
     */
    function load_resource($resource, $mode = 'url')
    {
        $manifest = public_path('/dist/manifest.json');
        
        if (file_exists($manifest) == false) {
            return false;
        }
        
        $json = json_decode(file_get_contents($manifest), true);

        foreach ($json as $key => $value) {
            $tmp = explode('/', $key);
            $path = end($tmp);

            if ($path == $resource) {
                return $mode == 'url'
                    ? url('/admin/dist/'.$value)
                    : public_path('/dist/' . $value);
            }
        }

        return false;
    }
}

if (! function_exists('load_critical_css')) {
    function load_critical_css($file)
    {
        $openFile = load_resource($file, 'file');

        if ($openFile !== false) {
            $styles = file_get_contents($openFile);
            return $styles;
        }
    }
}

if (! function_exists('load_svg')) {
    function load_svg($file)
    {
        $folder = '/dist/svg/';
        $filename = public_path($folder . $file . '.svg');

        if (file_exists($filename)) {
            return file_get_contents($filename, FILE_USE_INCLUDE_PATH);
        }

        return false;
    }
}

if (! function_exists('selected_filter')) {
    function selected_filter($param, $value, $default = false)
    {
        $request = request();
        $return = 'value="' . $value . '"';

        if ($request->has($param)) {
            if ($request->get($param) == $value) {
            $return .= ' selected';
            } 
        } else {
            if ($default !== false) {
            if ($value == $default) {
                $return .= ' selected';
            }
            }
        }

        return $return;
    }
}