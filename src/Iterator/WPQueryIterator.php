<?php
/*
 * @author: petereussen
 * @package: darionwm
 */

namespace HarperJones\Wordpress\Iterator;

/**
 * Template Iterator for WP_Query instances.
 *
 * @see loop()
 * @package HarperJones\Wordpress\Iterator
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
      $this->prepareEntry($post);

      $this->eachApply('get_template_part',[$template,$variation]);
    }

    $this->endLoop();
  }

  public function each($callable, $args = [])
  {
    global $post;

    $this->prepareLoop();

    while ($this->wp_query->have_posts()) {
      $this->prepareEntry($post);

      $this->eachApply('get_template_part',[$template,$variation]);
    }

    $this->endLoop();
  }

  protected function prepareEntry($data)
  {
    global $post;

    $this->wp_query->the_post();
    $this->needsReset = true;
    set_query_var('loop_entry',$post);
  }


  protected function prepareLoop()
  {
    $this->wp_query->rewind_posts();

    parent::prepareLoop(); // TODO: Change the autogenerated stub
  }


}