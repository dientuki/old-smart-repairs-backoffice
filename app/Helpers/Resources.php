<?php

/**
 * https://tutsforweb.com/creating-helpers-laravel/
 */

if (! function_exists('load_resource')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param  string  $resource
     * @param  string  $mode
     * @return string
     *
     */
    function load_resource($resource, $mode = 'url')
    {
        $manifest = public_path('/dist/manifest.json');
        
        if (file_exists($manifest) == false) {
            return '';
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

        return '';
    }
}

if (! function_exists('load_critical_css')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param  string  $file
     * @return string
     *
     */
    function load_critical_css($file)
    {
        $openFile = load_resource($file, 'file');

        if ($openFile !== '') {
            $styles = file_get_contents($openFile);
            return $styles;
        }

        return '';
    }
}

if (! function_exists('load_svg')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param  string  $file
     * @return string
     *
     */
    function load_svg($file)
    {
        $folder = '/dist/svg/';
        $filename = public_path($folder . $file . '.svg');

        if (file_exists($filename)) {
            return file_get_contents($filename, true);
        }

        return '';
    }
}

if (! function_exists('selected_filter')) {
    /**
     * Return the filter string.
     *
     * @param  string  $param
     * @param  string  $value
     * @param  string  $default
     * @return string
     *
     */
    function selected_filter($param, $value, $default)
    {
        $request = request();
        $return = 'value="' . $value . '"';

        if ($request->has($param)) {
            if ($request->get($param) == $value) {
                return $return . ' selected';
            }
        }

        if ($value == $default) {
            return $return . ' selected';
        }

        return $return;
    }
}
