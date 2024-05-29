{combine_script id='jquery' path='themes/default/js/jquery.min.js'}
{combine_script id='jquery.cluetip' require='jquery' path='themes/default/js/plugins/jquery.cluetip.js'}

{html_head}
{$SCRIPT}
{/html_head}






<div class="instructions">
  <h2>{$CONCOURS_VERSION}</h2>
<fieldset style=" position:relative ; top:15px">
  <legend>{'concours_admin_help'|translate}</legend>




	<div id="instructionConcours" class="instructionBlock" >
 
	  <div id="Concours_header" class="instructionBlockHeaderCollapsed" onclick="blockToggleDisplay('Concours_header', 'Fonction')">
	    <span class="cluetip" title="{'ConcoursPhoto_Fonctionality'|translate}">{'ConcoursPhoto_Fonctionality'|translate}</span>
	  </div>
	  <div id="Fonction" class="instructionBlockContent" style="display:none">
			<fieldset>
          <ul>
            <li>
{'CC_Fcty_1'|translate}
            <br/>
{'CC_Fcty_2'|translate}
            </li>
            <li style="list-style-type: none;"><br/></li>
			<li ><span class="throw"> {'CC_Fcty_3_1'|translate}</span></li>
			<li style="list-style-type: none;"></li>
			<li style="list-style-type: none;">{'CC_Fcty_3_1_1'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_1_2'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_1_3'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_1_4'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_1_5'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_1_6'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_1_7'|translate}</li>
            <li style="list-style-type: none;"><br/></li>
			<li ><span class="throw"> {'CC_Fcty_3_2'|translate}</span></li>
			<li style="list-style-type: none;">{'CC_Fcty_3_2_1'|translate}</li>
			<li style="list-style-type: none;"></li>
			<li style="list-style-type: none;">{'CC_Fcty_3_2_2'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_2_3'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_2_4'|translate}</li>
            <li style="list-style-type: none;"><br/></li>
			<li ><span class="throw"> {'CC_Fcty_3_3'|translate}</span></li>
			<li style="list-style-type: none;"></li>
			<li style="list-style-type: none;">{'CC_Fcty_3_3_1'|translate}</li>
            <li style="list-style-type: none;"><br/></li>
			<li ><span class="throw"> {'CC_Fcty_3_4'|translate}</span></li>
			<li style="list-style-type: none;"></li>
			<li style="list-style-type: none;">{'CC_Fcty_3_4_1'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_4_2'|translate}</li>
			<li style="list-style-type: none;">{'CC_Fcty_3_4_3'|translate}</li>
            <li style="list-style-type: none;"><br/></li>
         </ul>

			  
			</fieldset>
	  </div> <!-- Fonction -->
	</div> <!-- instructionConcours -->

	<div id="instructionOPTION" class="instructionBlock">
	  <div id="USAGE_header" class="instructionBlockHeaderCollapsed" onclick="blockToggleDisplay('USAGE_header', 'USAGE_content')">
	    <span class="cluetip" title="{'ConcoursPhoto_Options'|translate}">{'ConcoursPhoto_Options'|translate}</span>
	  </div>
	  <div id="USAGE_content" class="instructionBlockContent" style="display:none" >
			<fieldset>
          <ul>
            <li>
            {'CC_Option_1'|translate}
            <br/>
            </li>
            <li style="list-style-type: none;"><br/></li>
 			<li ><span class="throw"> {'CC_Option_2'|translate}</span></li>
			<li style="list-style-type: none;">{'CC_Option_2_1'|translate}</li>
			<li style="list-style-type: none;">{'CC_Option_2_2'|translate}</li>
			<li style="list-style-type: none;">{'CC_Option_2_3'|translate}</li>
			<li style="list-style-type: none;">{'CC_Option_2_4'|translate}</li>
			<li style="list-style-type: none;">{'CC_Option_2_5'|translate}</li>
            <li style="list-style-type: none;"><br/></li>
 			<li ><span class="throw"> {'CC_Option_3'|translate}</span></li>
			<li style="list-style-type: none;">{'CC_Option_3_1'|translate}</li>
			<li style="list-style-type: none;">{'CC_Option_3_2'|translate}</li>
			<li style="list-style-type: none;">{'CC_Option_3_3'|translate}</li>
			<li style="list-style-type: none;">{'CC_Option_3_4'|translate}</li>
			<li style="list-style-type: none;">{'CC_Option_3_5'|translate}</li>
			<li style="list-style-type: none;"></li>
			<li style="list-style-type: none;"><i>{'CC_Option_3_6'|translate}</i></li>
            <li style="list-style-type: none;"><br/></li>
 			<li ><span class="throw"> {'CC_Option_4'|translate}</span></li>
			<li style="list-style-type: none;">{'CC_Option_4_1'|translate}</li>
			<li style="list-style-type: none;">{'CC_Option_4_2'|translate}</li>
            <li style="list-style-type: none;"><br/></li>
          </ul>			  
			  
			  
			</fieldset>

	  </div> <!-- USAGE_header -->
	</div> <!-- USAGE_content -->

 </fieldset>
 
 
 </div>