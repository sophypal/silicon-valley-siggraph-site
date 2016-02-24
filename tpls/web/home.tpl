{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='home'}
{/block}
{block name=scripts}
{$smarty.block.parent}
<script type="text/javascript">
$(function() {
	
	var carousel = new Transition('#slider');
	setTimeout(function() { carousel.fade(); }, 5000);
});

var Transition = function(el) {
	var panels = [];
	var currentPanel = 0;
	
	var self = this;
	
	var init = function() {
		if ($(el).find('.trans').length < 2)
			return;
		
		$(el).find('.trans').each(function() {
			panels[panels.length] = $(this);
			$(this).hide();
		});
		panels[0].show();
	};
	
	this.swipe = function() {
		
		// position the panels in the right sequence
		var startPanel = currentPanel;
		for (var i = 0; i < panels.length - 1; ++i) {
			
			var nextPanel = (startPanel+1)%panels.length;
		
			// position the next panel right after this one
			panels[nextPanel].css('left', panels[startPanel].position().left + panels[startPanel].width());
			panels[nextPanel].show();
			
			startPanel = nextPanel;
		}
		currentPanel = (currentPanel + 1)%panels.length;
		
		// begin the animation
		$(el).find('.slider').each(function() {
			$(this).animate(
				{ left: '-=' + $(this).width() },
				{ duration: 1000, easing: 'easeInExpo'});
		});
		
		setTimeout(self.swipe, 10000);
	};
	
	this.fade = function() {
		
		var nextPanel = (currentPanel + 1) % panels.length;	
		// fade out current panel
		panels[currentPanel].fadeOut(2000);
		// fade in next panel
		panels[nextPanel].fadeIn(2000);
		
		currentPanel = nextPanel;
		
		setTimeout(self.fade, 5000);
	}
	
	init();
}

</script>
{/block}
{block name=content_document}
	<div id="news" class="section two-column">
	<h1>Latest <span class="highlight">News</span></h1>
	{if isset($granted)}
	<a class="add" href="{$smarty.config.WEB_ROOT}/index.php?action=news/add">Add News</a>
	{/if}
	{foreach $news as $new}
		<div class="news-panel panel">
        	<div class="image-container">
        	<img src="{$smarty.config.GALLERY_BASE_URL}{$new.photo_path}" />
            </div>
			<h2>{$new.title}</h2>
            <h3><span class="user">{$new.username}</span><span class="date">{$new.create_date|date_format:"%B %d, %Y"}</span></h3>
			<div class="content">
			<p>
				{$new.excerpt|truncate:120}
			</p>
            <a href="{$smarty.config.WEB_ROOT}/index.php?action=news/view&id={$new.id}">Read More</a>
			</div>
		</div>
	{/foreach}
    </div>
{/block}
{block name=content_side}
{info model='user' assign='username'}
{if !isset($username)}
<div id="login" class="section">
<h1><span>Member <span class="highlight">Login</span></span></h1>
<div class="content">
<form method="post" action="{$smarty.config.WEB_ROOT}/index.php?action=Login/submit">
<p>
    <label>Username: </label>
    <input type="text" name="username" class="text" />
</p>
<p>
    <label>Password: </label>
    <input type="password" name="password" class="text" />
</p>
<p>
    <label></label>
    <input type="submit" class="submit" value="Log In" />
</p>
</form>
</div>
</div>
{/if}
<div id="upcoming-events" class="section">
	<h1>Upcoming <span class="highlight">Events</span></h1>
	{foreach $events as $event}
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
<div id="conferences" class="section">
	<h1>Conferences</h1>
    <div class="conference-panel"><a title="SIGGRAPH Conference"
	href="http://www.siggraph.org/current-conference">
	<img style="border: none;" src="http://media.siggraph.org/promo/siggraph-badge.gif" alt="SIGGRAPH" />
	</a></div>
		
	<div class="conference-panel"><a title="SIGGRAPH Asia Conference"
	href="http://www.siggraph.org/current-asia-conference">
	<img style="border: none;" src="http://media.siggraph.org/promo/siggraph-asia-badge.gif" alt="SIGGRAPH Asia" />
	</a>
    </div>
</div>
{/block}
{block name=content_optional}
{if isset($events) && count($events) > 0}
<div id="optional">
<div id="slider">
{foreach $events as $event}
<div class="event-flash trans">
<img src="{$smarty.config.GALLERY_BASE_URL}{$event.photo_path}" />
<blockquote>
	<h2>{$event.name}</h2>
	<p>{$event.excerpt|nl2br|truncate:120}...<br /></p>
    <a class="link" href="{$smarty.config.WEB_ROOT}/index.php?action=event/view&id={$event.id}">Read More</a>
</blockquote>
</div>
{/foreach}
</div>
</div>
{/if}
{/block}