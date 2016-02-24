{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='about'}
{/block}
{block name=content_document}
<div class="section">
<h1>About Us</h1>
<div class="article">
<h2>CHAPTER HISTORY</h2>
<div class="content">
<p>Silicon Valley ACM SIGGRAPH is a professional chapter of the ACM&apos;s special interest group in Computer Graphics (SIGGRAPH).  The chapter was started in 1984 and is one of the oldest SIGGRAPH chapters.</p>
<p>We are an entirely volunteer run organization focused on educating the community on the uses of computer graphics in entertainment and scientific applications.  We hold monthly meetings on various graphics topics.</p>
<h2>SILICON VALLEY ACM SIGGRAPH OFFICERS</h2>
<ul>
	<li>Karl Anderson, <span class="highlight">Chair</span></li>
   	<li>Alesh Jancarik, <span class="highlight">Vice Chair</span></li>
	<li>Ken Turkowski, <span class="highlight">Treasurer</span></li>
	<li>Sophy Pal, <span class="highlight">Webmaster</span></li>
</ul>
<h2>PROFESSIONAL AND STUDENT CHAPTERS COMMITTEE</h2>
<p>The ACM SIGGRAPH Chapters are chartered by ACM and ACM SIGGRAPH. ACM has delegated oversight of these chapters to ACM SIGGRAPH. In turn, ACM SIGGRAPH has a Chapters Committee Chair who acts as a liaison between the ACM SIGGRAPH Executive Committee (EC) and the chapters.  See: <a href="http://www.siggraph.org/chapters/pscc">Committee</a>.
</div>
</div>
</div>
{/block}