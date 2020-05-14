<?php

namespace App\Http\Helpers;

class Helpers {
  public static function load_resource($resource, $url = true) {
    $manifest = file_get_contents(public_path('/dist/manifest.json'));

    if ($manifest == false) {
      return false;
    }

    $json = json_decode($manifest, TRUE);

    foreach ($json as $key => $value) {

      $tmp = explode('/', $key);
      $path = end($tmp);

      if ($path == $resource) {
        if ($url) {
          $file = url('/admin/dist/'.$value);
        } else {
          $file = public_path('/dist/' . $value);
        }

        return $file;
      }
    }

    return false;
  }

  public static function load_critical_css($file = false) {
  
    if ($file == false) {
      return false;
    }

    $openFile = Helpers::load_resource($file, false);

    if ($openFile !== false) {
      $styles = file_get_contents($openFile);
      return $styles;  
    }
  }

  public static function load_svg($file) {
    $folder = '/dist/svg/';
    $filename = public_path($folder . $file . '.svg');

    if (file_exists($filename)) {
      return file_get_contents($filename, FILE_USE_INCLUDE_PATH);
    }

    return false;
  }

  private static function inlineStyles($text, $styles) {
    $return = $text;

    if (count($styles) > 0) {

      usort($styles, function($a, $b) {
        return -($a->offset <=>  $b->offset);
      });      
      
      foreach($styles as $style) {
        $tmp = '';
        $raw = substr($text, $style->offset, $style->length);

        switch ($style->style) {
          case 'BOLD':
            $tmp = '<b>' . $raw . '</b>';
          break;
          case 'UNDERLINE':
            $tmp = '<u>' . $raw . '</u>';
          break;     
          case 'ITALIC':
            $tmp = '<i>' . $raw . '</i>';
          break;                    
        }

        $return = substr_replace($return, $tmp, $style->offset, $style->length);
      }
    }

    return nl2br($return);
  }

  static public function draft2html($draftjs) {
    $json = json_decode($draftjs);
    $html = [];
    $is_listWrapper = false;
    
    foreach($json->blocks as $block) {
      
      if (in_array($block->type, array('unordered-list-item', 'ordered-list-item')) == false) {
        if ($is_listWrapper != false) {
          $html[] = $is_listWrapper;
          $is_listWrapper = false;
        }
      }

      $text = Helpers::inlineStyles($block->text, $block->inlineStyleRanges);

      if (nl2br($block->text) != '') {
        switch ($block->type) {
          case 'header-three':
            $html[] = '<h3>' . $text . '</h3>';  
          break;
          case 'header-four':
            $html[] = '<h4>' . $text . '</h4>';  
          break;
          case 'header-five':
            $html[] = '<h5>' . $text . '</h5>';  
          break;
          case 'header-six':
            $html[] = '<h6>' . $text . '</h6>';  
          break;   
          case 'blockquote':
            $html[] = '<blockquote>' . $text . '</blockquote>';  
          break;
          case 'unordered-list-item':
            if ($is_listWrapper == false) {
              $is_listWrapper = '</ul>';
              $html[] = '<ul>';
            }
            $html[] = '<li>' . $text . '</li>';  
          break;
          case 'ordered-list-item':
            if ($is_listWrapper == false) {
              $is_listWrapper = '</ol>';
              $html[] = '<ol>';
            }            
            $html[] = '<li>' . $text . '</li>';  
          break;
          default:
            $html[] = '<p>' . $text . '</p>';
        }
      } else {
        $html[] = '<br />';
      }

    }
    
    return implode('', $html);
    //return $draftjs;
  }
}