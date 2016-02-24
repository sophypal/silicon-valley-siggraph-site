{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='event'}
{/block}
{block name=navigation_sub}
<ul>
	<li {if $type == 'next'}class="active"{/if}>
		<a href="{$smarty.config.WEB_ROOT}/index.php?action=event/index&type=next">Next Events</a>
	</li>
	<li {if $type == 'past'}class="active"{/if}>
		<a href="{$smarty.config.WEB_ROOT}/index.php?action=event/index&type=past">Past Events</a>
	</li>
    <li>
    	<a href="{$smarty.config.WEB_ROOT}/oldsite/past.html">History</a>
    </li>
</ul>
{/block}
{block name=content_document}
	<div class="section two-column">
    	<h1>Events</h1>
	{if isset($granted)}
	<a class="add" href="{$smarty.config.WEB_ROOT}/index.php?action=event/add">Add New Event</a>
	{/if}
    {foreach $events as $event}
		<div class="event-panel panel">
        	<div class="event-date">
            	<span class="day">{$event.start_date|date_format:"%d"}</span>
                <span class="month">{$event.start_date|date_format:"%b"}</span>
            </div>
            <div class="image-container">
            <img src="{$smarty.config.GALLERY_BASE_URL}{$event.photo_path}" />
            </div>
            <div class="description">
			<h2>{$event.name}</h2>
            <h3><span class="place">{$event.place_name}</span><span class="time">{$event.start_date|date_format:"%I:%M %p"}-{$event.end_date|date_format:"%I:%M %p"}</h3>
			<p>{$event.description|nl2br|truncate:60|stripslashes}</p>
            <a class="link" href="{$smarty.config.WEB_ROOT}/index.php?action=event/view&id={$event.id}">Read More</a>
			</div>
		</div>
	{/foreach}
    </div>
{/block}
{block name=content_side}
<div id="upcoming-events" class="section">
	<h1>Upcoming <span class="highlight">Events</span></h1>
	{foreach $future_events as $event}
		<div class="mini-event-panel panel">
        	<div class="event-date">
            	<span class="day">{$event.start_date|date_format:"%d"}</span>
                <span class="month">{$event.start_date|date_format:"%b"}</span>
            </div>
            <div class="description">
			<h2>{$event.name|truncate:25}</h2>
            <h3>{$event.place_name}</h3>
            <a class="link" href="{$smarty.config.WEB_ROOT}/index.php?action=event/view&id={$event.id}">Read More</a>
			</div>
		</div>
	{/foreach}
</div>
<div id="event-filter" class="section">
	<h1>FILTER <span class="highlight">EVENTS</span></h1>
    <ul class="list">
    {foreach $months as $month}
		<li><a href="{$smarty.config.WEB_ROOT}/index.php?action=event/index&type=past&from={$month}">{$month|date_format:"%B - %Y"}</a></li>
    {/foreach}
    </ul>
</div>   
{/block}