{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='gallery edit-page'}
{/block}
{block name=content_document}
<div class="section">
<h1>Admin > Gallery > Photo</h1>
<div class="content">
<h2>Photo #{$photo.id}</h2>
<form action="{$smarty.config.WEB_ROOT}/index.php?action=Admin/editPhoto&id={$photo.id}" method="post">
<p>
<label for="caption">Caption:</label>
<input type="text" name="caption" value="{$photo.caption}" />
</p>
<div class="img-preview">
<img src="{$gallery_base_url}{$photo.path}"/>
</div>
<p>
<label for="delete">Delete photo</label>
<input type="checkbox" name="delete" value="Delete Photo" />
</p>
<p>
<input type="submit" name="submit" value="Submit">
</p>
</form>

</div>
</div>
</div>
{/block}