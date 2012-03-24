# What is the Gist Class
The `Gist` class provides an interface for easily

1. Embedding gists
2. Caching gists
3. Adding the gist's source to `<noscript>` tags in case JS is disabled

## How to Use it

```php
<?php
include 'gist.php';

$gist = new Gist('123456', 'some_file.php');

echo $gist->render();
?>
```

# Available Methods

## Gist::__construct

	Gist::__construct($gist_id[, $file_name = null[, $cache = true]])

Prepares the class for adding gists to the page

### Parameters

<table>
	<tr>
		<td>$gist_id</td>
		<td>string</td>
		<td>The ID of the gist to add</td>
	</tr>
	
	<tr>
		<td>$file_name</td>
		<td>string (optional)</td>
		<td>Which file to display; if empty it will embed all files</td>
	</tr>
	
	<tr>
		<td>$cache</td>
		<td>boolean (optional) (default=true)</td>
		<td>Cache the gist source in a file and display it in `&lt;noscript&gt;` tags</td>
	</tr>
</table>

## Gist::script\_tag()

	Gist::script_tag()

Creates the script tag for embedding gists

### Return

```
<script src="https://gist.github.com/123456.js"></script>
```

## Gist::noscript\_tag()

	Gist::noscript_tag()

If caching is enabled then download 
and display the gist content in
`<noscript>` tags

### Return

```
<noscript><pre><code>The source gist</code></pre></noscript>
```

## Gist::render()

Create the script and noscript tags
in one go

### Return

```
<script src="https://gist.github.com/123456.js"></script>
<noscript><pre><code>The source gist</code></pre></noscript>
```

## (private) Gist::download\_raw\_source()

Attempt to download a gist
and cache it into a file

### Return
{null}

## (private) Gist::get\_cache\_name()

Returns the path for where the file
should be cached

### Return

	./gists_cache/58abasdf4858asadf58


