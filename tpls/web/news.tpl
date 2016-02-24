{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='news'}
{/block}

{block name=content_document}
	<div class="section">
	<h1>News</h1>
    <div class="article">
        <h2>{$news.title}{if isset($granted)}<a class="edit" href="{$smarty.config.WEB_ROOT}/index.php?action=news/edit&id={$news.id}"></a>{/if}</h2>
        <h3><span class="user">{$news.username}</span><span class="date">{$news.create_date|date_format:"%B %d, %Y"}</span></h3>
        <div class="content">
        <p>{$news.article|nl2br|stripslashes}</p>
        </div>
    </div>
    </div>
{/block}
{block name=content_side}
{/block}