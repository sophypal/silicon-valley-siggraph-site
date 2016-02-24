{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='gallery edit-page'}
{/block}
{block name=content_document}
<div class="section">
<h1>Admin > Gallery</h1>
<div class="content">
<h2>Add Photos</h2>
<form action="{$smarty.config.WEB_ROOT}/index.php?action=Admin/upload" method="post" enctype="multipart/form-data">
<fieldset>
<p>
<label for="file">Upload your photo:</label>
<input type="file" name="file" id="file">
</p>
<p>
<label for="caption">Caption:</label>
<input type="text" name="caption" />
</p>
</p>
</fieldset>
<p>
<input type="submit" name="submit" value="Upload">
</p>
</form>
<h2>Gallery</h2>
<div class="gallery">
{foreach $photos as $photo}
<div class="photo">
<a href="{$smarty.config.WEB_ROOT}/index.php?action=Admin/editPhoto&id={$photo.id}">
<img src="{$gallery_base_url}{$photo.path}" />
</a>
</div>
{/foreach}
</div>
</div>
</div>
{/block}