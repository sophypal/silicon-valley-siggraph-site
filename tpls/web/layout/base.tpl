{* this block is for any variable declarations needed *}
{block name=decl}
{assign var=title value='Silicon Valley ACM SIGGRAPH'}
{assign var=body_class value='home'}
{/block}
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=9, IE=8, chrome=1" />
<meta name="keywords" content="ILM, Pixar, PDI, Debevec, 3D, DeRose, Algorithm,
		Modeling, Rendering, Animation, Code, Programming, API, Art, Computer" />
<meta name="description" content="Silicon Valley ACM SIGGRAPH is a professional chapter of the ACM's special interest group in Computer Graphics (SIGGRAPH). The chapter was started in 1984 and is one of the oldest SIGGRAPH chapters." />
<script type="text/javascript" src="{$smarty.config.WEB_ROOT}/js/jquery-1.6.4.min.js">
</script>
<script type="text/javascript" src="{$smarty.config.WEB_ROOT}/js/jquery-ui-1.8.16.custom.min.js">
</script>
<script type="text/javascript" src="{$smarty.config.WEB_ROOT}/js/ui.datetimepicker.js">
</script>
<link rel="stylesheet" type="text/css" href="{$smarty.config.WEB_ROOT}/styles/black-tie/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="{$smarty.config.WEB_ROOT}/styles/datetimepicker/dark.datetimepicker.css" />
<link rel="stylesheet" type="text/css" href="{$smarty.config.WEB_ROOT}/styles/dark/style.css" />
<title>{$title}</title>
{block name=scripts}
{/block}
{block name=styles}
{/block}
</head>

<body class="{$body_class}">
{block name=body}
{/block}
</body>
</html>