{extends file='layout/layout.tpl'}

{block name=decl}
{$smarty.block.parent}
{assign var=body_class value='membership'}
{/block}

{block name=content_document}
<div class="section">
<h1>CHAPTER MEMBERSHIP</h1>
<div class="article">
<h2>DETAILS</h2>
<div class="content">
<p>ACM SIGGRAPH Silicon Valley chapter requests a $5 donation per meeting for non-members, free for members and full-time students (with valid ID).</p>
<p>To become a Silicon Valley ACM SIGGRAPH member, please signup at our monthly meetings or <a href="https://campus.acm.org/public/qj/chapqj/chapqj_control.cfm?chap=46137">join here</a></p>
<p>Membership dues are $20 per year.</p>
<p>Please note, some mail systems may have junk mail filters which could prevent you from receiving the announcements that are sent for chapter events. Please make sure to setup your mail system (Hotmail, AOL, Yahoo, etc.) to allow these messages to be received. The mail will be sent from the address silicon-valley-announcements@siggraph.org and will contain [silicon-valley-siggraph] as the first part of the subject line. The traffic for our announcements list is approximately one message per month.</p>
</div>
</div>
</div>
{/block}