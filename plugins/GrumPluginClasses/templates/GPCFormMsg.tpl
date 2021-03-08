<div id='iGpcFormMail'>
  <form>
    <input type="hidden" id="iToken" name="fToken" value="{$token}">
    <h2>{"Your email"|@translate}</h2>
    <input type="text" value="" id="iEmail" name="fEmail" >

    <h2>{"Subject"|@translate}</h2>
    <input type="text" value="" id="iSubject" name="fSubject">

    <h2>{"Message"|@translate}</h2>
    <textarea value="" id="iMessageContent" name="fMessageContent" rows="10"></textarea>

    <p>
      <input type="button" value="{'Submit'|translate}" id="iSubmit" name="fSubmit">
    </p>
  </form>
</div>