{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='resource'}
{/block}

{block name=content_document}
<div class="section">
<h1>Resources</h1>
<div class="article">
<h2>Chapter Annoucement Email List</h2>
<div class="content">
<p>You can join our e-mail list to receive information on our upcoming events.</p>
<p>To subscribe to the Silicon Valley SIGGRAPH chapter announcements mailing list go to <a href="http://listserv.siggraph.org/scripts/wa-SIGGRAPH.exe?SUBED1=silicon-valley-announcements&A=1">Silicon Valley Announcements</a>. Joining this list will allow you to receive notifications describing upcoming Silicon Valley SIGGRAPH chapter events.</p>
<h2>SIGGRAPH Newsletter</h2>
<p>To subscribe to the free SIGGRAPHITTI NEWSLETTER, send email to: news@siggraph.org that includes the word "subscribe" (without the quotes) in the BODY of your message. To UNSUBSCRIBE, send mail to: remove@siggraph.org and include in the BODY of your message the email address that receives the newsletter.</p>
</div>
</div>
</div>
{/block}
