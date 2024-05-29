$('pre').wrapInner('<code class="example_code">');

$('.example_code').each(function(){
  var text = $(this).html();
  text = text.replace(/(\[[a-z]+| )([a-z_]*)=([a-z0-9,]+)/gi, '$1<span class=p>$2</span>=<span class=v>$3</span>'); // params
  text = text.replace(/(\/\/.*)\n/gi, '<span class=c>$1</span>\n'); // comments
  text = text.replace(/(\[\/?[a-z-]+|\])/gi, '<span class=b>$1</span>'); // tags
  text = text.replace(/(&lt;!--[a-z-]+--&gt;)/gi, '<span class=b>$1</span>'); // tags
  text = text.replace(/(&lt;\/?[a-z]+.*?&gt;)/gi, '<span class=h>$1</span>'); // html
  $(this).html(text);
});