<?php

require dirname(__FILE__) . '/../lib/gist.php';

class DescribeGist extends \PHPSpec\Context {

  /*
   * Creates a new instance of Gist
   * and matches the generated url
   *
   * @param string $gist_id the id of the gist to use
   * @param string|null $file_name the file in the gist
   * @param string $expected_url the url that should be created
   */
  private function test_matching_url($gist_id, $file_name, $expected_url) {
    $gist = $this->spec(new Gist($gist_id, $file_name, false));

    $gist->url->should->be($expected_url);
  }

  public function itShouldCreateUrlFromGistId() {
    $this->test_matching_url('123456', null, 'https://gist.github.com/123456.js');
  }

  public function itShouldCreateUrlFromGistIdAndFileName() {
    $this->test_matching_url('123456', 'test_file.php', 'https://gist.github.com/123456.js?file=test_file.php');
  }

  public function itShouldGenerateTheScriptTag() {
    $gist = $this->spec(new Gist('123456', null, false));

    $gist->script_tag()->should->match('/123456.js"><\/script>$/');
  }

  public function itShouldDownloadTheSourceFile() {
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

  public function itShouldGenerateTheNoscriptTag() {
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
}
