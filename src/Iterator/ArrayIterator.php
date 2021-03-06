<?php
/*
 * @author: petereussen
 * @package: darionwm
 */

namespace Woppe\Wordpress\Iterator;

/**
 * Template Iterator for arrays or arrays of posts
 *
 * @see loop()
 * @package Woppe\Wordpress\Iterator
 */
class ArrayIterator extends AbstractTemplateIterator
{
  protected $data;

  public function __construct(array $data)
  {
    $this->data = $data;
  }


  public function apply($template, $variation = '')
  {
    if (empty($this->data)) {
      return;
    }

    $this->prepareLoop();

    foreach( $this->data as $key => $postEntry ) {
      $this->prepareEntry($postEntry,$key);

      $this->eachApply('get_template_part',[$template,$variation]);
    }

    wp_reset_postdata();
  }

  public function each($callable, $args = [])
  {
    if (empty($this->data)) {
      return;
    }

    $this->prepareLoop();

    foreach( $this->data as $key => $postEntry ) {
      $this->prepareEntry($postEntry,$key);

      $loopArgs = $args;
      array_unshift($loopArgs,$key);
      array_unshift($loopArgs,$postEntry);
      $this->eachApply($callable,$loopArgs);
    }

    $this->endLoop();
  }

  protected function prepareLoop()
  {
    reset($this->data);
    parent::prepareLoop();
  }

}