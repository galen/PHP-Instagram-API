<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Instagram Examples<?php if( isset( $_GET['example'] ) ): ?> - <?php echo ucwords( str_replace( '_', ' ', basename( $_GET['example'], '.php' ) ) ) ?><?php endif; ?></title>
	<style type="text/css">
		* { margin:0; padding:0 }
		body { font-family: arial, verdana, sans-serif; padding-bottom: 100px; background:#f9f6f1 }
		h1 { background: #675548; color:#fff; padding: 6px; font-size: 18px; }
		h1 a { font-size: 10px; color: #00ff00; }
		#breadcrumbs { background: #d9d1c2; padding: 6px; font-size: 14px; }
		#breadcrumbs a { color: #aa0000;text-decoration:none }
		#breadcrumbs a:hover { text-decoration:underline; }
		#content { padding: 6px; width:900px; position:relative; }
		a { color: #aa0000;text-decoration:none }
		a:hover { text-decoration:underline; }
		h2, h3, h4 { margin: 10px 0 }
		.next_page { font-size:12px }
		.media_list { overflow:auto; list-style:none }
		.media_list li { float:left; margin: 0 4px 4px 0 }
		.media_list img { width:50px; height:50px; border: 1px solid #aaa; padding: 2px; }
		.media_list img:hover { border: 1px solid #000 }
		dl { overflow:auto }
		dt, dd { float:left; width: 450px; margin-bottom: 6px}
		dt { clear:left; width:150px }
		#caption { margin-bottom: 15px }
		pre { font-family: courier; width:600px; overflow:auto }
		.more_examples { position:absolute; right: 0; }
		#like { padding: 8px 0; text-align:center; width: 612px; background: #eee; margin-bottom: 10px }
		#comment_form{ margin-top: 20px; }
		#comment_text { width: 400px }
		.map {width:300px;height:200px}
		.map_wrapper { position:relative;width: 300px }
		.map_wrapper .crosshairs {position:absolute;z-index: 999;top: 90px;left:140px;}
		#search_results { position:absolute; top:0;right:0; width: 500px; }
		#search_results .list { margin-left: 20px}
		#search_forms { width:350px; }
		.search_form_wrapper { padding:10px;border-bottom: 1px solid #d9d1c2; }
		.search_form_wrapper.active { background: #f5f0e7; }
		.search_form_wrapper h2 { margin:0; }
		#error { color: #aa0000; font-weight: bold; margin-bottom: 10px; }
	</style>
</head>
<body>

<h1>Instagram PHP Wrapper Examples</h1>
<?php if( isset( $_GET['example'] ) ): ?>
<p id="breadcrumbs"><a href="./">Home</a> \ <?php echo ucwords( str_replace( '_', ' ', basename( $_GET['example'], '.php' ) ) ) ?> Example</p>
<?php endif; ?>

<div id="content">

<?php if( isset( $error ) ): ?><p id="error"><?php echo htmlspecialchars( $error ) ?></p><?php endif; ?>
