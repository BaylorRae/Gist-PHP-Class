<?php

namespace spec;
use PHPSpec2\ObjectBehavior;

require dirname(__FILE__) . '/../lib/gist.php';

class Gist extends ObjectBehavior {

  public function let($file_name = null, $cache = true) {
    $this->beConstructedWith('123456', $file_name, $cache);
  }

  public function it_should_create_url_from_gist_id() {
    $this->url->shouldBe('https://gist.github.com/123456.js');
  }

  public function it_should_create_url_from_gist_id_and_file_name() {
    $this->let('test_file.php');
    $this->url->shouldBe('https://gist.github.com/123456.js?file=test_file.php');
  }

  public function it_should_generate_the_script_tag() {
    $this->let(null, false);
    $this->script_tag()->shouldBe('<script src="https://gist.github.com/123456.js"></script>');
  }

  public function xit_should_download_the_source_file() {
    $source_file = dirname(__FILE__) . '/fixtures/source_file.php';
    $source = file_get_contents($source_file);

    // download the source file
    $this->cache_directory = '.';
    $this->source_url = $source_file;
    $this->noscript_tag();

    $this->source->shouldBe($source);
    unlink($this->cache_file_name);
  }

  /*
  public function it_should_download_the_source_file() {
    $source_file = dirname(__FILE__) . '/fixtures/source_file.php';
    $source = file_get_contents($source_file);

    $gist = new Gist('123456');

    // cache the file in the current directory
    $gist->cache_directory = '.';

    // stub the source_url
    $gist->source_url = $source_file;

    // make sure to try and download the source
    $gist->noscript_tag();

    // source should exist
    $this->spec($gist->source)->should->be($source);

    // should have created the file
    $this->spec(file_exists($gist->cache_file_name))->should->beTrue();

    // file should have the source's content
    $this->spec(file_get_contents($gist->cache_file_name))->should->be($source);

    // remove the cacheed file
    unlink($gist->cache_file_name);
  }
   */

  /*
   * Creates a new instance of Gist
   * and matches the generated url
   *
   * @param string $gist_id the id of the gist to use
   * @param string|null $file_name the file in the gist
   * @param string $expected_url the url that should be created
   */
  /*
  private function test_matching_url($gist_id, $file_name, $expected_url) {
    $gist = $this->spec(new Gist($gist_id, $file_name, false));

    $gist->url->should->be($expected_url);
  }

  public function it_should_generate_the_script_tag() {
    $gist = $this->spec(new Gist('123456', null, false));

    $gist->script_tag()->should->match('/123456.js"><\/script>$/');
  }
  public function it_should_generate_the_noscript_tag() {
    $source_file = dirname(__FILE__) . '/fixtures/source_file.php';
    $source = file_get_contents($source_file);

    $gist = new Gist('123456');

    // cache the file in the current directory
    $gist->cache_directory = '.';

    // stub the source_url
    $gist->source_url = $source_file;

    // was able to embed the source into <noscript> tags
    $this->spec($gist->noscript_tag())->should->match('/fun to read\.\n<\/code><\/pre><\/noscript>$/');

    // delete the cached file
    if( file_exists($gist->cache_file_name) ) {
      unlink($gist->cache_file_name);
    }
  }
   */
}
