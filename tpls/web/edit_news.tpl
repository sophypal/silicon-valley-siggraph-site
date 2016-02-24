{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='news-edit edit-page'}
{/block}
{block name=scripts}
{$smarty.block.parent}
{/block}
{block name=content_document}
	<div class="section">
	<h1><span>News</span></h1>
	<div class="content">
			<form method='post' action='{$smarty.config.WEB_ROOT}/index.php?action=news/edit'>
				<fieldset>
				<p>
					<label for="title">Title</label>
					<input type="text" class="text" name="title" {if isset($news)}value="{$news.title|escape:"htmlall"}"{/if} />
				</p>
				<p>
					<label for="excerpt">Excerpt</label>
					<textarea name="excerpt">{if isset($news)}{$news.excerpt|nl2br|stripslashes}{/if}</textarea>
				</p>
                <p>
                    	<label for="photo">Cover Photo</label>
                        <div class="photo-picker">
                        {foreach $photos as $photo}
                        <div class="photo">
                        <img src="{$smarty.config.GALLERY_BASE_URL}{$photo.path}" />
                        {if $news.photo_id == $photo.id}
                        <input type="radio" name="photo" value="{$photo.id}" checked />
                        {else}
                        <input type="radio" name="photo" value="{$photo.id}" />
                        {/if}
                        </div>
                        {/foreach}
                        </div>
                </p>
				<p>
					<label>Article</label>
					<textarea name="article">{if isset($news)}{$news.article|nl2br|stripslashes}{/if}</textarea>
                </p>
				<p>
				<input type="checkbox" name="published" {if isset($news) and $news.published}checked{/if} /> Public
				</p>
				</fieldset>
				<div style="text-align: center">
				<input type="submit" class="submit" name="submit" value="Submit Changes" />
                <input type="hidden" name="id" value="{$news.id}" />
				</div>
			</form>
		</div>
	</div>
{/block}
{block name=content_side}
{/block}