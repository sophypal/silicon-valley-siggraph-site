{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='event-edit edit-page'}
{/block}
{block name=scripts}
{$smarty.block.parent}
<script type="text/javascript">
var places = {};
{foreach $places_options as $p}
places[{$p.id}] = {};
places[{$p.id}].name = "{$p.name}";
places[{$p.id}].address = "{$p.address}";
places[{$p.id}].city = "{$p.city}";
places[{$p.id}].state = "{$p.state}";
places[{$p.id}].zip = "{$p.zip}";
{/foreach}

	
function enableEditor(container) {
	$(container).find('input,textarea').removeAttr('disabled').val("");
}
function disableEditor(container) {
	$(container).find('input,textarea').attr('disabled', true).val("");
}
function populatePlace(id) {
	$('#place_name').val(places[id].name);
	$('#address').val(places[id].address);
	$('#city').val(places[id].city);
	$('#state').val(places[id].state);
	$('#zip').val(places[id].zip);	
}

$(function() {
	
	{if isset($event.place_id) && $event.place_id > 0}
	disableEditor('#location .new');
	populatePlace({$event.place_id});
	{/if}
	
	$('#place_select').change(function() {
		var place_id = $(this).val();
		populatePlace(place_id);
	});

	$('.datepicker').datetimepicker();
});
</script>
{/block}
{block name=content_document}
	<div class="section">
	<h1><span>Events</span></h1>
	<div class="content">
			<form method='post' action='{$smarty.config.WEB_ROOT}/index.php?action=event/add'>
				<fieldset>
				<p>
					<label for="name">Event Name:</label>
					<input type="text" class="text" name="name" value="{$event.name|default:''}" />
				</p>
				<p>
					<label for="start_date">Start Date:</label>
					<input type="text" class="text datepicker" name="start_date" value="{$event.start_date|default:"0000-00-00 00:00"|date_format:"%Y-%m-%d %H:%M"}" />
				</p>
                <p>
					<label for="end_date">End Date:</label>
					<input type="text" class="text datepicker" name="end_date" value="{$event.end_date|default:"0000-00-00 00:00"|date_format:"%Y-%m-%d %H:%M"}" />
				</p>
				<p>
				</fieldset>
				<fieldset id="photo">
                	<p>
                    	<label for="photo">Photo:</label>
                        <div class="photo-picker">
                        {foreach $photos as $photo}
                        <div class="photo">
                        <img src="{$smarty.config.GALLERY_BASE_URL}{$photo.path}" />
                        <input type="radio" name="photo" value="{$photo.id}"/>
                        </div>
                        {/foreach}
                        </div>
                    </p>
                </fieldset>
				<fieldset id="location">
					<p>
						<label>Location:</label>
						<select id="place_select" name="place_id">
							<option value="0">New</option>
							{foreach $places_options as $p}
							<option value="{$p.id}" {if isset($event.place_id) && $event.place_id == $p.id}selected{/if}>{$p.name}</option>
							{/foreach}
						</select>
					</p>
					<div class="new">
						<p>
							<label for="place_name">Name: </label>
							<input type="text" class="text" id="place_name" name="place_name" value="{$place.name|default:""}"/>
						</p>
						<p>
							<label>Address: </label>
							<input type="text" class="text" id="address" name="address" value="{$place.address|default:""}"/>
						</p>
						<p>
							<label for="city">City: </label>
							<input type="text" class="text" id="city" name="city" value="{$place.city|default:""}"/>
						</p>
						<p>
							<label for="state">State: </label>
							<input type="text" class="text" id="state" name="state" value="{$place.state|default:""}"/>
						</p>
						<p>
							<label for="zip">Zip: </label>
							<input type="text" class="text" id="zip" name="zip" value="{$place.zip|default:""}"/>
						</p>
					</div>
				</fieldset>
				<fieldset>
                <p>
                	<label>Excerpt:</label>
                    <input type="text" name="excerpt" />
                </p>
				<div id="description">
					<label>Event Description:</label>
					<textarea name="description">{$event.description|default:""|nl2br}</textarea>
				</div>
				<p>
					<input type="checkbox" name="published" {if $event.published}checked{/if} /> Public
				</p>
				</fieldset>
                <fieldset id="photos">
                	<p>
                    	<label for="photos">Photo:</label>
                        <div class="photo-picker">
                        {foreach $photos as $photo}
                        <div class="photo">
                        <img src="{$smarty.config.GALLERY_BASE_URL}{$photo.path}" />
                        <input type="checkbox" name="photos[]" value="{$photo.id}" />
                        </div>
                        {/foreach}
                        </div>
                    </p>
                </fieldset>
				<div style="text-align: center;">
				<input type="submit" class="submit" name="submit" value="Submit Changes" />
				</div>
			</form>
		</div>
	</div>
{/block}
{block name=content_side}
{/block}