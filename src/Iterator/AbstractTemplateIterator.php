<?php
/*
 * @author: petereussen
 * @package: wordpress-extensions
 */

namespace Woppe\Wordpress\Iterator;


abstract class AbstractTemplateIterator implements TemplateIteratorInterface
{
  protected $needsReset = false;
  protected $restoreLoop= [];

  protected function eachApply($callable,$args)
  {
    if ( !is_callable($callable)) {
      if ( is_array($callable) && count($callable) == 2) {
        $callable = get_class($callable[0]) . '::' . $callable[1];
      }

      throw new \RuntimeException('No function or method named ' . $callable);
    }

    return call_user_func_array($callable,$args);
  }

  protected function prepareLoop()
  {
    $this->needsReset = false;
    $this->restoreLoop= [
      'position' => get_query_var('loop_position'),
      'entry'    => get_query_var('loop_entry')
    ];
  }

  protected function prepareEntry($data, $key)
  {
    global $post;

    if ( $data instanceof \WP_Post ) {
      setup_postdata($data);
      $this->needsReset = true;
    } else if ( is_integer($data) ) {
      $post = get_post($data);

      if ( $post ) {
        setup_postdata($post);
        $this->needsReset = true;
      }
    }
    set_query_var('loop_entry',$data);
    set_query_var('loop_position',$key);
  }

  protected function endLoop()
  {
    if ( $this->needsReset ) {
      wp_reset_postdata();
    }

    set_query_var('loop_position',$this->restoreLoop['position']);
    set_query_var('loop_entry',   $this->restoreLoop['entry']);
  }
}