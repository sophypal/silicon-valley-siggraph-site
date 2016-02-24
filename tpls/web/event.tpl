{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='event edit-page'}
{/block}

{block name=content_document}
	<div class="section">
		<h1>Events</h1>
		<div class="article">
			<h2>{$event.name}
				{if isset($granted)}
				<a class="edit" href="{$smarty.config.WEB_ROOT}/index.php?action=event/edit&id={$event.id}"></a>
   				<a class="delete" href="{$smarty.config.WEB_ROOT}/index.php?action=event/delete&id={$event.id}"></a>
				{/if}
			</h2>
			<h4>When</h4>
			<p>{$event.start_date|date_format:"%A %B %d, %Y - %r"}</p>
			<h4>Location:</h4>
			<p>
				<strong>{$place.name}</strong><br />
				{$place.address}<br />
				{$place.city},{$place.state} {$place.zip}<br />
			</p>
			<h4>DESCRIPTION</h4>
			<p>{$event.description|nl2br}</p>


            {if count($photos) > 0}
            <h2>Event Photos</h2>
            <div class="gallery">
            {foreach $photos as $photo}
            <div class="photo">
            <a href="{$smarty.config.GALLERY_BASE_URL}{$photo.path}">
            <img src="{$smarty.config.GALLERY_BASE_URL}{$photo.path}" />
            </a>
            </div>
            {/foreach}
            </div>
            {/if}
        
        </div>
	</div>
{/block}
{block name=content_side}
{/block}