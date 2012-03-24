<?php

/*
 * Provides an easy interface for
 * - embedding gists
 * - caching gists
 * - displaying gists with JS disabled
 */
class Gist {

  // the urls for gists
  const EMBED_URL = 'https://gist.github.com/%s.js';
  const RAW_URL = 'https://gist.github.com/raw/%s/';

  // the url for displaying gists
  public $url = null,
         $source_url = null;

  // stores information about caching gists
  public $source = null,
         $cache = true,
         $attempted_to_download = false,
         $cache_directory = './gist_cache',
         $cache_file_name = null;

  /*
   * Prepares the class for adding gists to the page
   *
   * @param string $gist_id The ID of the gist to add
   * @param string $file_name Which file to display
   * @param boolean $cache Cache the gist source in a file and display it in <noscript> tags
   */
  function __construct($gist_id, $file_name = null, $cache = true) {
    // create the urls
    $this->url = sprintf(Gist::EMBED_URL, $gist_id);
    $this->source_url = sprintf(Gist::RAW_URL, $gist_id);

    // does this gist use caching
    $this->cache = $cache;

    // encode the gist id for where to save it
    $this->cache_file_name = sha1($gist_id);

    /*
     * if using a file_name
     * then update the urls
     */
    if( $file_name !== null ) {
      $this->url .= '?file=' . $file_name;
      $this->source_url .= $file_name;

      $this->cache_file_name .= '-' . sha1($file_name);
    }
  }

  /*
   * Creates the script tag for embedding gists
   *
   * @return string
   */
  public function script_tag() {
    return sprintf('<script src="%s"></script>', $this->url);
  }

  /*
   * If caching is enabled then download 
   * and display the gist content in
   * <noscript> tags
   *
   * @return string
   */
  public function noscript_tag() {
    // make sure caching is enabled
    if( $this->cache ) {

      // try to download the source
      $this->download_raw_source();
    }

    /*
     * If a gist was downloaded
     * then display it
     */
    if( $this->source !== null ) {
      return sprintf('<noscript><pre><code>%s</code></pre></noscript>', $this->source);
    }
  }

  /*
   * Create the script and noscrpt tags
   * in one go
   *
   * @return string
   */
  public function render() {
    return $this->script_tag() . "\n" .
           $this->noscript_tag();
  }

  /*
   * Attempt to download a gist
   * and cache it into a file
   *
   * @return void
   */
  private function download_raw_source() {
    // don't try more than once
    if( $this->attempted_to_download ) {
      return;
    }
    
    // the cache file exists, load it
    elseif( file_exists($this->get_cache_name()) ) {
      $this->source = file_get_contents($this->get_cache_name());

    // download the source from GitHub
    }else {
      $this->source = file_get_contents($this->source_url);

      // if successful then save it
      if( $this->source ) {
        file_put_contents($this->get_cache_name(), $this->source);
      }
    }

    $this->attempted_to_download = true;
  }

  /*
   * Where should the gist be cached
   *
   * @return string
   */
  private function get_cache_name() {
    return $this->cache_directory . DIRECTORY_SEPARATOR . $this->cache_file_name;
  }
}
