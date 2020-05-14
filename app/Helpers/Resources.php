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
        $manifest = file_get_contents(public_path('/dist/manifest.json'));

        if ($manifest == false) {
            return false;
        }

        $json = json_decode($manifest, true);

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
