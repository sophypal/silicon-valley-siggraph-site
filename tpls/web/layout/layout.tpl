{extends file='layout/base.tpl'}
{block name=decl}
{$smarty.block.parent}
{/block}
{block name=scripts}
<script type="text/javascript">

var bg = new Image();
bg.src="{$smarty.config.WEB_ROOT}/styles/dark/img/strands.jpg"

$(document).ready(function() {
    
    $('#wrapper').before("<img style='position: fixed; top: 0; left: 0' src='" + bg.src + "' width='" + $(window).width() + "' height='" + $(window).height() + "'/>");
	
});

(function(i,s,o,g,r,a,m){
	i['GoogleAnalyticsObject']=r;
	i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)
	},i[r].l=1*new Date();
	a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];
	a.async=1;
	a.src=g;
	m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-39563102-1', 'siggraph.org');
ga('send', 'pageview');

</script>
{/block}
{block name=body}
<div id="wrapper">
<div id="container">
	<div id="page-header">
		<h1><a href="{$smarty.config.WEB_ROOT}/index.php"><span>Silicon Valley ACM SIGGRAPH</span></a></h1>
	</div>
	<div id="navigation-main">
		<ul>
			<li {if $body_class=="home"}class="active"{/if}><a href="{$smarty.config.WEB_ROOT}/index.php">Home</a></li>
			<li {if $body_class=="event"}class="active"{/if}><a href="{$smarty.config.WEB_ROOT}/index.php?action=event/index">Events</a></li>
			<li {if $body_class=="membership"}class="active"{/if}><a href="{$smarty.config.WEB_ROOT}/index.php?action=membership/index">Membership</a></li>
			<li {if $body_class=="organization"}class="active"{/if}><a href="{$smarty.config.WEB_ROOT}/index.php?action=organization/index">Organization</a></li>
			<li {if $body_class=="about"}class="active"{/if}><a href="{$smarty.config.WEB_ROOT}/index.php?action=about/index">About Us</a></li>
			<li {if $body_class=="contact"}class="active"{/if}><a href="{$smarty.config.WEB_ROOT}/index.php?action=contact/index">Contact Us</a></li>
		</ul>
	</div>
	<div id="navigation-sub">
	{block name=navigation_sub}{/block}
	</div>
	{block name=header_info}
	{info model='user' assign='username'}
		{if isset($username)}
        <div id="admin-links">
        	<ul>
            	<li><a href="{$smarty.config.WEB_ROOT}/index.php?action=Admin/gallery">Gallery</a></li>
            </ul>
        </div>
        <div id="header-info">
				Logged in as {$username}
				<a href="{$smarty.config.WEB_ROOT}/index.php?action=Login/cancel">Logout</a>
        </div>
		{/if}
    
	{/block}
	<div id="content-main">
       	{block name=content_optional}{/block}
		<div id="content-side">
			{block name=content_side}{/block}
		</div>
		<div id="content-document">
			{block name=content_document}{/block}
		</div>
	</div>
	<div id="footer">
    	<div id="footer-extra">
        	<div class="three-column">
            	<h1>SILICON VALLEY <span class="highlight">SIGGRAPH</span></h1>
                <p>Silicon Valley ACM SIGGRAPH is a professional chapter of the ACM's special interest group in Computer Graphics (SIGGRAPH). The chapter was started in 1984 and is one of the oldest SIGGRAPH chapters.</p>
            </div>
            <div class="three-column">
            	<h1>PHOTOS</h1>
                <div id="mini-photo-gallery">
                {info model='gallery' assign='gallery_photos'}
                {foreach $gallery_photos as $photo}
                	<div class="mini-photo">
                    	<a href="{$smarty.config.GALLERY_BASE_URL}{$photo.path}">
                    	<img src="{$smarty.config.GALLERY_BASE_URL}{$photo.path}" />
                        </a>
                    </div>
                {/foreach}
                </div>
            </div>
        </div>
		<div id="copyright">
			Copyright &copy; Silicon Valley ACM SIGGRAPH - All Rights Reserved
		</div>
	</div>
</div>
</div>
{/block}