<?php
/*
 * @author: petereussen
 * @package: darionwm
 */

namespace Woppe\Wordpress\Iterator;

/**
 * Template Iterator for WP_Query instances.
 *
 * @see loop()
 * @package Woppe\Wordpress\Iterator
 */
class WPQueryIterator extends AbstractTemplateIterator
{
  protected $wp_query;

  public function __construct(\WP_Query $query)
  {
    $this->wp_query = $query;
  }

  public function apply($template, $variation = '')
  {
    global $post;

    $this->prepareLoop();

    while ($this->wp_query->have_posts()) {
      $this->prepareEntry($post,$this->wp_query->current_post);

      $this->eachApply('get_template_part',[$template,$variation]);
    }

    $this->endLoop();
  }

  public function each($callable, $args = [])
  {
    global $post;

    $this->prepareLoop();

    while ($this->wp_query->have_posts()) {
      $this->prepareEntry($post,$this->wp_query->current_post);

      $loopArg = $args;
      array_unshift($loopArg,$this->wp_query->current_post);
      array_unshift($loopArg,$post);

      $this->eachApply($callable,$loopArg);
    }

    $this->endLoop();
  }

  protected function prepareEntry($data,$key)
  {
    global $post;

    $this->wp_query->the_post();
    $this->needsReset = true;
    set_query_var('loop_entry',$post);
    set_query_var('loop_position',$key);
  }


  protected function prepareLoop()
  {
    $this->wp_query->rewind_posts();

    parent::prepareLoop();
  }


}