<?php
/*
  Plugin Name: ClickBank Ads
  Plugin URI: http://cbads.com/WordPressClickBankWithEbookCovers.html
  Description: This plugin creates a graphic banner in post and in widget areas to display ClickBank keyword-sensitive ads with ebook covers on your Wordpress blog. ClickBank clients have earned over 2 billion dollars. Now it's your turn. Graphic advertising and marketing is far better. Commissions of up to 75% - much higher than other affiliate networks. 
  Version: 1.2
  Author: ClickBank Ads
  Author URI: http://cbads.com/
*
License:     GNU General Public License
 *  This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

if (!class_exists("cbwec")) {
  class cbwec {
    var $cbwec_version="1.2"; 
    var $opts; 
    function cbwec() { $this->getOpts(); } 
    function getOpts() { 
      if (isset($this->opts) AND !empty($this->opts)) {return;} 
      $this->opts=get_option("ClickBankWEC3"); 
      if (!empty($this->opts)) {return;} 
      $this->opts=Array ('title' => 'Related eBooks', 'name' => '', 'keywordbytitle2' => 'Title', 'border' => '','homepage'=>'1','runplugin'=>'1', 'bordcolor' => 'CCCCCC', 'bordstyle' => '1', 'adformat' => '1', 'width' => '100%', 'height' => '100%', 'linkcolor' => '0000ff','pos' => 'Top');
    } 
    function sanitize_entries($options){ return $options; } 
    
    function get_field_name($fieldname){return "cbwec[".$fieldname."]";}
    function get_field_id($fieldname){return "cbwec-".$fieldname;}
   
    function admin_menu() {
      if (isset($_POST["cbwec_submit"])) { 
        $this->opts=$this->sanitize_entries($_POST['cbwec'], $sizes); 
        update_option('ClickBankWEC3',$this->opts); 
        echo '<div id="message" class="updated fade"><p><strong>Options Updated!</strong></p></div>'; 
      }

 ?>
 <div class="wrap">
    <h2>ClickBank Ads V <?php echo $this->cbwec_version; ?></h2>
    <p>For further Information visit the <a target=_blank href="http://cbads.com/">Plugin Site</a>.<br><br>To place a vertical banner or vertical carousel to <b style="color:#ff3333">widget area (sidebar)</b>, <br>go to the '<a href=widgets.php>Appearance -> Widgets</a>' SubPanel, <br>add the "ClickBank Ads" to your sidebar and configure it."</p>
    <form name="mainform" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" onsubmit="if(document.getElementById('<?php echo $this->get_field_id('name'); ?>').value.length<5){alert('Please enter your ClickBank Nickname!');return false;}">
        <script type="text/javascript" src="<?php echo plugins_url( '/jscolor/jscolor.js', __FILE__ );?>"></script>
			<style>
			.cbwecb10 {border: 1px solid #<?php echo $this->opts['bordcolor'];?>;}
			.cbwecb11 {color:#<?php echo $this->opts['linkcolor']; ?>;}
			</style>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label><br />
          <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $this->opts['title']; ?>" style="width:200px;" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('name'); ?>">Your ClickBank Nickname:</label><br /><a target="regs" href="http://artdhtml.reseller.hop.clickbank.net/"><font size=1>(Register here its FREE)</font></a><br/>
          <input type="text" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" value="<?php echo $this->opts['name']; ?>" style="width:200px;" required />
        </p>
        <p>
          <label><input type="radio" <?php if($this->opts['keywordbytitle2']=="Title") {echo 'checked';}?> onclick="fk1=document.getElementById('dthidti').style;if(this.value!='Key'){fk1.display='none';}" value="Title" id="<?php echo $this->get_field_id('keywordbytitle2'); ?>" name="<?php echo $this->get_field_name('keywordbytitle2'); ?>" style="border:0px;" /> Ads related to post Title & Category</label> <font size=1>(recommended)</font><br />
          <label><input type="radio" <?php if($this->opts['keywordbytitle2']=="TitleOnly") {echo 'checked';}?> onclick="fk1=document.getElementById('dthidti').style;if(this.value!='Key'){fk1.display='none';}" value="TitleOnly" id="<?php echo $this->get_field_id('keywordbytitle2'); ?>1" name="<?php echo $this->get_field_name('keywordbytitle2'); ?>" style="border:0px;" /> Ads related to post Title</label><br />
          <label><input type="radio" <?php if($this->opts['keywordbytitle2']=="Key") {echo 'checked';}?> onclick="fk1=document.getElementById('dthidti').style;if(this.value=='Key'){fk1.display='block';}" value="Key" id="<?php echo $this->get_field_id('keywordbytitle2'); ?>2" name="<?php echo $this->get_field_name('keywordbytitle2'); ?>" style="border:0px;" /> Ads related to Keywords:</label>
          <div id="dthidti" style="overflow:hidden;height:30px;display: <?php echo ($this->opts['keywordbytitle2']=="Key"?"block;":"none");?>">
            <input type="text" id="<?php echo $this->get_field_id('keywords'); ?>" name="<?php echo $this->get_field_name('keywords'); ?>" value="<?php echo ($this->opts['keywords']==""? "Enter Your Keywords" : $this->opts['keywords']); ?>" onblur="if(this.value==''){this.value='Enter Your Keywords'}" onfocus="if(this.value=='Enter Your Keywords'){this.value=''}" style="width:200px;" />
          </div>
        </p>

		    <table border=0 cellspacing=0 cellpadding=0>
		     <tr><td>Ad Formats:</td><td style="padding-left:5px;">Preview:</td></tr>
		     <tr><td>
		      <select onchange="f_ad_ch_ewc(this.value)" size="1" id="<?php echo $this->get_field_id('adformat'); ?>" name="<?php echo $this->get_field_name('adformat'); ?>" style="width:177px;">
		        <option value="1" <?php if($this->opts['adformat']=="1") {echo 'selected';}?>>Leaderboard </option>
		        <option value="2" <?php if($this->opts['adformat']=="2") {echo 'selected';}?>>Horizontal Carousel</option>
		        <option value="3" <?php if($this->opts['adformat']=="3") {echo 'selected';}?>>Vertical Banner</option>
		        <option value="4" <?php if($this->opts['adformat']=="4") {echo 'selected';}?>>Vertical Carousel</option>
		        <option value="5" <?php if($this->opts['adformat']=="5") {echo 'selected';}?>>Rectangle (360 x 420)</option>
		        <option value="6" <?php if($this->opts['adformat']=="6") {echo 'selected';}?>>Custom</option>		
		      </select></td>
		      <td valign=top style="padding-left:5px;">
		       <div class="cbwecb10" style="position:absolute;" id=d2bgewc><div id=dbgewc style="background: url(<?php echo plugins_url( 'prev.png', __FILE__ );?>) left top;"><img src=<?php echo plugins_url( '1.gif', __FILE__ );?> width=1 height=1></div></div>
		      </td>
		     </tr>
		    </table>

        <div id="dthids" style="overflow:hidden;visibility: <?php echo ($this->opts['adformat']=="6"?"visible;height:55px;":"hidden;height:0px;");?>">
		      <p>Width:<br />
		      <select onchange="document.getElementById('<?php echo $this->get_field_id('width'); ?>').value=this.value;xg_pre_ewc=this.value;f_pre_ewc(this.value,0);" size="1" id="<?php echo $this->get_field_id('width2'); ?>" name="<?php echo $this->get_field_name('width2'); ?>" style="width:100px;">
	        	<option value="100%" <?php if($this->opts['width']=="100%") {echo 'selected';}?>>100% (auto)</option>
	        	<option value="120" <?php if($this->opts['width']=="120") {echo 'selected';}?>>120 px</option>
	        	<option value="160" <?php if($this->opts['width']=="160") {echo 'selected';}?>>160 px</option>
	        	<option value="200" <?php if($this->opts['width']=="200") {echo 'selected';}?>>200 px</option>
	        	<option value="240" <?php if($this->opts['width']=="240") {echo 'selected';}?>>240 px</option>
	        	<option value="360" <?php if($this->opts['width']=="360") {echo 'selected';}?>>360 px</option>
	        	<option value="480" <?php if($this->opts['width']=="480") {echo 'selected';}?>>480 px</option>
	        	<option value="600" <?php if($this->opts['width']=="600") {echo 'selected';}?>>600 px</option>
	        	<option value="720" <?php if($this->opts['width']=="720") {echo 'selected';}?>>720 px</option>
	        	<option value="840" <?php if($this->opts['width']=="840") {echo 'selected';}?>>840 px</option>
	        	<option value="960" <?php if($this->opts['width']=="960") {echo 'selected';}?>>960 px</option>
		        <option value="1000" <?php if($this->opts['width']=="1000") {echo 'selected';}?>>1000 px</option>
		      </select>
		      OR
		      <input onchange="xg_pre_ewc=this.value;f_pre_ewc(this.value,0);" type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $this->opts['width']; ?>" style="width:50px;" />
	      </p>
	    </div>
	    
	    <div id="dthids2" style="overflow:hidden;visibility: <?php echo ($this->opts['adformat']=="6" or $this->opts['adformat']=="3" or $this->opts['adformat']=="4"?"visible;height:55px;":"hidden;height:0px;");?>">
		    <p>Height:<br />
		      <select onchange="document.getElementById('<?php echo $this->get_field_id('height'); ?>').value=this.value;yg_pre_ewc=this.value;f_pre_ewc(0,this.value);" size="1" id="<?php echo $this->get_field_id('height'); ?>2" name="<?php echo $this->get_field_name('height'); ?>2" style="width:100px;">
		        <option value="220" <?php if($this->opts['height']=="220") {echo 'selected';}?>>220 px</option>
		        <option value="440" <?php if($this->opts['height']=="440") {echo 'selected';}?>>440 px</option>
		        <option value="660" <?php if($this->opts['height']=="660") {echo 'selected';}?>>660 px</option>
		        <option value="880" <?php if($this->opts['height']=="880") {echo 'selected';}?>>880 px</option>
		        <option value="1000" <?php if($this->opts['height']=="1000") {echo 'selected';}?>>1000 px</option>
		        <option value="1200" <?php if($this->opts['height']=="1200") {echo 'selected';}?>>1200 px</option>
	        	<option value="1400" <?php if($this->opts['height']=="1400") {echo 'selected';}?>>1400 px</option>
	        	<option value="1600" <?php if($this->opts['height']=="1600") {echo 'selected';}?>>1600 px</option>
	      	</select>
		      OR 
		      <input onchange="yg_pre_ewc=this.value;f_pre_ewc(0,this.value);" type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $this->opts['height']; ?>" style="width:50px;" />
        </p>   
      </div>
      <p>
        <table border=0 cellspacing=0 cellpadding=0><tr><td><label for="<?php echo $this->get_field_id('pos'); ?>">Position on page:</label></td><td><div style="width:60px;" id=selpos><select style="width:60px;" id="<?php echo $this->get_field_id('pos'); ?>" name="<?php echo $this->get_field_name('pos'); ?>" size="1"><option<?php if($this->opts['pos']=="Top") echo(" selected"); ?>>Top</option><option<?php if($this->opts['pos']=="Right") echo(" selected"); ?>>Right</option><option<?php if($this->opts['pos']=="Left") echo(" selected"); ?>>Left</option><option<?php if($this->opts['pos']=="Bottom") echo(" selected"); ?>>Bottom</option></select></div></td></tr></table>
      </p>
      

      <script> 
        var bg_ewci;
        var bg_ewc=0;		
        var n_ad_ch_ewcg;   
        function f_car_ewc(n_ad_ch_ewc){
          p_ad_ch_ewc=document.getElementById('dbgewc');
          clearTimeout(bg_ewci);
          if(n_ad_ch_ewc=="2"){bg_ewci=setTimeout("if(bg_ewc<48){bg_ewc++;p_ad_ch_ewc.style.backgroundPosition=-bg_ewc+'px 0'}else{bg_ewc=0};f_car_ewc(n_ad_ch_ewcg)", 40);}
          if(n_ad_ch_ewc=="4"){bg_ewci=setTimeout("if(bg_ewc<60){bg_ewc++;p_ad_ch_ewc.style.backgroundPosition='0 '+bg_ewc+'px'}else{bg_ewc=0};f_car_ewc(n_ad_ch_ewcg)", 40);}
          if (n_ad_ch_ewc!="4" && n_ad_ch_ewc!="2"){p_ad_ch_ewc.style.backgroundPosition='0 0';}
        }
        
        <?php 
        if($this->opts['border']!="1") {echo "document.getElementById('d2bgewc').style.borderWidth='0px';";}

		if($this->opts['adformat']=="1") {echo 'var xg_pre_ewc="100%";var yg_pre_ewc="220";';}
		if($this->opts['adformat']=="2") {echo 'var xg_pre_ewc="100%";var yg_pre_ewc="220";';}
        if($this->opts['adformat']=="3") {echo 'var xg_pre_ewc="160";var yg_pre_ewc="1000";';}
        if($this->opts['adformat']=="4") {echo 'var xg_pre_ewc="160";var yg_pre_ewc="1000";';}
		if($this->opts['adformat']=="5") {echo 'var xg_pre_ewc="360";var yg_pre_ewc="440";';}
		if($this->opts['adformat']=="6") {echo 'var xg_pre_ewc="'.$this->opts['width'].'";var yg_pre_ewc="'.$this->opts['height'].'";';}
		?>
		    
        var selposFull=document.getElementById('selpos').innerHTML;
        function f_pre_ewc(x_pre_ewc,y_pre_ewc){
          p_ad_ch_ewc=document.getElementById('dbgewc').style;
          if(x_pre_ewc!=0){
            if(x_pre_ewc=="100%"){x_pre_ewc=480;}if(x_pre_ewc<121){x_pre_ewc=120;};x_pre_ewc=x_pre_ewc/10;p_ad_ch_ewc.width= Math.floor(x_pre_ewc/12)*12+'px';p_ad_ch_ewc.marginRight=p_ad_ch_ewc.marginLeft=Math.floor((x_pre_ewc-Math.floor(x_pre_ewc/12)*12)/2)+'px';
            if(x_pre_ewc<49){document.getElementById('d2bgewc').style.marginLeft=Math.floor(48-x_pre_ewc)+'px';}else{document.getElementById('d2bgewc').style.marginLeft='0px';}
          }
          if(y_pre_ewc!=0){if(y_pre_ewc=="100%"){y_pre_ewc=600;}if(y_pre_ewc<201){y_pre_ewc=200;};y_pre_ewc=y_pre_ewc/10;p_ad_ch_ewc.height=Math.floor(y_pre_ewc/20)*20+'px';p_ad_ch_ewc.marginTop=p_ad_ch_ewc.marginBottom=Math.floor((y_pre_ewc-Math.floor(y_pre_ewc/20)*20)/2)+'px';}
        }
        
        f_pre_ewc(xg_pre_ewc,yg_pre_ewc);
        
        function f_selpos(n_ad_ch_ewc){
          selposl=document.getElementById('selpos');
          if(n_ad_ch_ewc=="1" || n_ad_ch_ewc=="2"){selposl.innerHTML=selposFull.replace(/<option[^>]*>Left<\/option>/,"").replace(/<option[^>]*>Right<\/option>/,"")}
          if(n_ad_ch_ewc=="3" || n_ad_ch_ewc=="4"){selposl.innerHTML=selposFull.replace(/<option[^>]*>Bottom<\/option>/,"").replace(/<option[^>]*>Top<\/option>/,"")}
          if(n_ad_ch_ewc=="5" || n_ad_ch_ewc=="6"){selposl.innerHTML=selposFull}
        }
        function f_ad_ch_ewc(n_ad_ch_ewc){
          n_ad_ch_ewcg=n_ad_ch_ewc;
          h_ad_ch_ewc=document.getElementById('<?php echo $this->get_field_id('height'); ?>');
          h_ad_ch_ewc2=document.getElementById('<?php echo $this->get_field_id('height'); ?>2');
          w_ad_ch_ewc=document.getElementById('<?php echo $this->get_field_id('width'); ?>');
          w_ad_ch_ewc2=document.getElementById('<?php echo $this->get_field_id('width'); ?>2');
          p_ad_ch_ewc=document.getElementById('dbgewc').style;
          
          
          switch (n_ad_ch_ewc){
	        case "3":
            w_ad_ch_ewc.value=w_ad_ch_ewc2.value="160";
	          h_ad_ch_ewc.value=h_ad_ch_ewc2.value="1000";
            f_pre_ewc(160,"1000");
            break;
          case "4":
            w_ad_ch_ewc.value=w_ad_ch_ewc2.value="160";
	          h_ad_ch_ewc.value=h_ad_ch_ewc2.value="1000";
            f_pre_ewc(160,"1000");
            break;
	        case "1":
            w_ad_ch_ewc.value=w_ad_ch_ewc2.value="100%";
            h_ad_ch_ewc.value=h_ad_ch_ewc2.value="220";
            f_pre_ewc("100%",220);
            break;
	        case "2":
            w_ad_ch_ewc.value=w_ad_ch_ewc2.value="100%";
	          h_ad_ch_ewc.value=h_ad_ch_ewc2.value="220";
            f_pre_ewc("100%",220);
            break;
	        case "5":
            w_ad_ch_ewc.value=w_ad_ch_ewc2.value="360";
	          h_ad_ch_ewc.value=h_ad_ch_ewc2.value="440";
            f_pre_ewc(360,440);
            break;
          default :
            w_ad_ch_ewc.value=w_ad_ch_ewc2.value=xg_pre_ewc;
            h_ad_ch_ewc.value=h_ad_ch_ewc2.value=yg_pre_ewc;
            f_pre_ewc(xg_pre_ewc,yg_pre_ewc);
          }
          f_selpos(n_ad_ch_ewc)
          f_car_ewc(n_ad_ch_ewc);
          dthids=document.getElementById('dthids').style;
          dthids2=document.getElementById('dthids2').style;
          
          if(n_ad_ch_ewc==5 || n_ad_ch_ewc<3){dthids.visibility='hidden';dthids.height='0px';dthids2.visibility='hidden';dthids2.height='0px';}
          if(n_ad_ch_ewc==6){dthids.visibility='visible';dthids.height='55px';dthids2.visibility='visible';dthids2.height='55px';}
          if(n_ad_ch_ewc==3 || n_ad_ch_ewc==4){dthids2.visibility='visible';dthids2.height='55px';dthids.visibility='hidden';dthids.height='0px';}
        }
        f_ad_ch_ewc(<?php echo $this->opts['adformat']?>)
		    <?php echo 'clearTimeout(bg_ewci);n_ad_ch_ewcg="'.$this->opts['adformat'].'";f_car_ewc("'.$this->opts['adformat'].'")';?>  //start carousel     

      </script>
      
      <p>
      <label for="<?php echo $this->get_field_id('border'); ?>">Show Border:</label>
      <input 
	  onclick="dthidm=document.getElementById('dthid').style;if(this.checked){dthidm.visibility='visible';dthidm.height='88px';document.getElementById('d2bgewc').style.borderWidth='1px';}else{dthidm.visibility='hidden';dthidm.height='0px';document.getElementById('d2bgewc').style.borderWidth='0px';}" type="checkbox" <?php if($this->opts['border']=="1") {echo 'checked';}?> id="<?php echo $this->get_field_id('border'); ?>" name="<?php echo $this->get_field_name('border'); ?>" value="1" style="border:0px;" />
        <div id="dthid" style="overflow:hidden;visibility: <?php echo ($this->opts['border']=="1"?"visible;height:88px;":"hidden;height:0px;");?>">
         Border Style:
        <br />
        <table border=0 width=200 cellspacing=0 cellpadding=0>
	        <tr>
		        <td width=50% valign=top align=center style="padding:0 10px 10px 0;">
				
				<div class="cbwecb10" style="padding:3px;background:#ffffff; border-radius:5px 5px 5px 5px;">
				<table border=0 cellspacing=0 cellpadding=0><tr><td><label for="<?php echo $this->get_field_id('bordstyle'); ?>"><u class="cbwecb11">Style</u> 1 </label></td><td>&nbsp;<input type="radio" <?php if($this->opts['bordstyle']=="1") {echo 'checked';}?> value="1" id="<?php echo $this->get_field_id('bordstyle'); ?>"  name="<?php echo $this->get_field_name('bordstyle'); ?>" style="margin-top:3px;border:0px;" /></td></tr></table>
				</div>
				</td>
				<td width=50% valign=top align=center style="padding:0 0 10px 10px;"><div class="cbwecb10" style="padding:3px;background:#ffffff;"><table border=0 cellspacing=0 cellpadding=0><tr><td><label for="<?php echo $this->get_field_id('bordstyle'); ?>2"><u class="cbwecb11">Style</u> 2 </label></td><td><input type="radio" <?php if($this->opts['bordstyle']=="2") {echo 'checked';}?> value="2" id="<?php echo $this->get_field_id('bordstyle'); ?>2" name="<?php echo $this->get_field_name('bordstyle'); ?>" style="margin-top:3px;border:0px;" /></td></tr></table></div></td>
          </tr>
        </table>

	      <table border=0 cellspacing=0 cellpadding=0><tr><td width=90><label for="<?php echo $this->get_field_id('bordcolor'); ?>">Border Color: </label></td><td>#<input onblur="var e = document.getElementsByTagName('div');for(var i=0; i<e.length; i+=1) {if(e[i].className && e[i].className=='cbwecb10'){e[i].style.borderColor = '#'+this.value;}}" onmouseover="jscolor.bind()" class="color" type="text" id="<?php echo $this->get_field_id('bordcolor'); ?>" name="<?php echo $this->get_field_name('bordcolor'); ?>" value="<?php echo $this->opts['bordcolor']; ?>" style="width:70px;" /></td></tr></table>

      </div>

      <table border=0 cellspacing=0 cellpadding=0><tr><td width=90><label for="<?php echo $this->get_field_id('linkcolor'); ?>"><u class="cbwecb11">Link Color: </u></label></td><td>#</span><input onblur="var e = document.getElementsByTagName('u');for(var i=0; i<e.length; i+=1) {if(e[i].className && e[i].className=='cbwecb11') {e[i].style.color = '#'+this.value;}}" onmouseover="jscolor.bind()" class="color" type="text" id="<?php echo $this->get_field_id('linkcolor'); ?>" name="<?php echo $this->get_field_name('linkcolor'); ?>" value="<?php echo $this->opts['linkcolor']; ?>" style="width:70px;" /></td></tr></table>
      
      <p>
          <label for="<?php echo $this->get_field_id('runplugin'); ?>">Show Ads in Post area:</label>
          <input type="checkbox" <?php if($this->opts['runplugin']=="1") {echo 'checked';}?> id="<?php echo $this->get_field_id('runplugin'); ?>" name="<?php echo $this->get_field_name('runplugin'); ?>" value="1" style="border:0px;" />
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('homepage'); ?>">Show Ads on home page:</label>
          <input type="checkbox" <?php if($this->opts['homepage']=="1") {echo 'checked';}?> id="<?php echo $this->get_field_id('homepage'); ?>" name="<?php echo $this->get_field_name('homepage'); ?>" value="1" style="border:0px;" />
      </p>

      
      <div class="submit">
        <input type="submit" name="cbwec_submit" value="<?php _e('Save'); ?> &raquo;" />
      </div>
    </form>
</div>

<?php
 }  
 
function findNodes($str) { 
  $pattern='&\[gallery\]|\<\/p*\>|\<br\>|\<br\s\/\>|\<br\/\>&iU'; 
  return preg_split($pattern, $str, 0, PREG_SPLIT_OFFSET_CAPTURE); 
} 

function stopWords($term, $stopwords_file){
	$common = file($stopwords_file,FILE_IGNORE_NEW_LINES);//load list of common words
	//already all in lowercase   for ($x=0; $x<= count($common); $x++){$common[$x] = trim(strtolower($common[$x]));}  
	$terms = explode(" ", strtolower($term));//make array of search terms    
	$terms=array_unique ($terms);
	$clean_term="";
	foreach ($terms as $line){if (!in_array($line, $common)){$clean_term .= " ".$line;}}
	return $clean_term;    
}
    

var $num_cont_blocks=0;
function add_js($content) {
	global $num_cont_blocks;
	if($this->opts['runplugin']!="1"){return $content;}// exit if plugin blocked
	if(is_home() and $this->opts['homepage']!="1"){return $content;}// exit if homepage blocked

	if ($num_cont_blocks==1){return $content;}// exit for pages with multiple posts - show only in 1 post
	$num_cont_blocks=1;
  
	$title = $this->opts['title'];
	$user = $this->opts['name'];
    

	if($this->opts['border']=="1"){$bord = 1;}else{$bord = 0;}       
	if($this->opts['keywordbytitle2']=="Title") {
		$category = get_the_category(); 
		$cats= $category[0]->cat_name." ".$category[1]->cat_name;
		$keywords =  get_the_title()." ". $cats." ".get_bloginfo('name');
	}
	if($this->opts['keywordbytitle2']=="TitleOnly") {
		$keywords =  get_the_title()." ".get_bloginfo('name');
	}
	if($this->opts['keywordbytitle2']=="Key") {
		$keywords = $this->opts['keywords'];//key=from form
	}

	$keywords=trim(preg_replace("/\W+/"," ",preg_replace("/\d+/"," ",str_replace("Uncategorized"," ",str_replace("Enter Your Keywords"," ",$keywords)))));
	$keywords=trim($this->stopWords($keywords,plugin_dir_path( __FILE__ ).'stopwords.txt'));

	if($this->opts['bordstyle']=="1" and $this->opts['border']=="1"){
		$pre_div='<div  style="padding:10px;background:#ffffff;border: '. $this->opts['border'].'px solid #'.$this->opts['bordcolor'].'; '.($this->opts['bordstyle']=="1"?"border-radius:5px 5px 5px 5px;":"").';">';
		$aft_div="</div>";
		$width="190";
	}
	else{$st=0;$width="198";$pre_div="";$aft_div="";}
        
	if($this->opts['adformat']=="1" or $this->opts['adformat']=="2"){$height=220;$width="100%";}
	if($this->opts['adformat']=="3" or $this->opts['adformat']=="4"){$height=$this->opts['height'];}
	if($this->opts['adformat']=="6"){$this->opts['adformat']="5";}
	if($this->opts['adformat']=="5"){$height=$this->opts['height'];$width=$this->opts['width'];}
	if($width=="100%"){$width="97%";}

	$ourdiv="<iframe src=\"http://cbads.com/ads.php?a=".$user."&lc=".$this->opts['linkcolor']."&af=".$this->opts['adformat']."&f=1&key=".$keywords."&v=".$this->cbwec_version."\" marginwidth='0' marginheight='0' width='".$width."' height='".$height."' border='0' frameborder='0'  style='background:#ffffff;border: ".($pre_div==""?$bord."px solid #".$this->opts['bordcolor']."; padding:5px;":"0px;")."' scrolling='no'></iframe>"; 
	$pre_div=($title?"<b style='font-family:Arial'>".$title."</b><br>":"").$pre_div;
	if ($this->opts['pos'] == "Top") 	$content = '<!-- cbwec_ad_section_start --><div style="margin:10px auto;width:'.($width=="97%"?"100%":($width+12)."px").'">'.$pre_div.$ourdiv.$aft_div.'</div><!-- cbwec_ad_section_end -->'.$content;
	if ($this->opts['pos'] == "Bottom") $content = $content.'<!-- cbwec_ad_section_start --><div style="margin:10px auto;width:'.($width=="97%"?"100%":($width+12)."px").'">'.$pre_div.$ourdiv.$aft_div.'</div><!-- cbwec_ad_section_end -->';
	if ($this->opts['pos'] == "Right") 	$content = '<!-- cbwec_ad_section_start --><div style="margin:0 0 0 20px; float:right;width:'.($width=="97%"?"100%":($width+12)."px").'">'.$pre_div.$ourdiv.$aft_div.'</div><!-- cbwec_ad_section_end -->'.$content; 
	if ($this->opts['pos'] == "Left") 	$content = '<!-- cbwec_ad_section_start --><div style="margin:0 20px 0 0; float:left;width:'.($width=="97%"?"100%":($width+12)."px").'">'.$pre_div.$ourdiv.$aft_div.'</div><!-- cbwec_ad_section_end -->'.$content; 
								
	return $content;
}
 

}//class
}//if


$cbwec = new cbwec(); 

function cbwec_menu() {
  global $cbwec;
  if (function_exists('add_options_page')) {
    add_options_page('ClickBank Ads', 'ClickBank Ads', 'administrator', __FILE__, array(&$cbwec, 'admin_menu')); 
  } 
} 
add_action('admin_menu', 'cbwec_menu');
add_filter('the_content', array($cbwec, 'add_js')); //run script on page












//   -------    WIDGET -----------



add_action('widgets_init', 'ClickBank_Ads_widget');
function ClickBank_Ads_widget() {
    register_widget('ClickBank_Ads_W');
}

class ClickBank_Ads_W extends WP_Widget {
  var $cbwecw_version="1.2"; 
    function ClickBank_Ads_W() {
        $widget_ops = array('classname' => 'ClickBank', 'description' => __('Use this widget to display ClickBank contextual Ad with eBook Cover Images. For details, visit: http://cbads.com/', 'ClickBank'));
        $control_ops = array('width' => 200);
        $this->WP_Widget('ClickBank_Ads_Widget_version', __('ClickBank Ads', 'ClickBank'), $widget_ops, $control_ops);
    }
    function get_the_title() {
      return apply_filters( 'single_post_title', $title); 
    }

	function stopWords($term, $stopwords_file){
		$common = file($stopwords_file,FILE_IGNORE_NEW_LINES);//load list of common words
		//already all in lowercase   for ($x=0; $x<= count($common); $x++){$common[$x] = trim(strtolower($common[$x]));}  
		$terms = explode(" ", strtolower($term));//make array of search terms    
		$terms=array_unique ($terms);
		$clean_term="";
		foreach ($terms as $line){if (!in_array($line, $common)){$clean_term .= " ".$line;}}
		return $clean_term;    
	}

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
       
        if($instance['keywordbytitle2']=="Title") {
			$category = get_the_category(); 
			$cats= $category[0]->cat_name." ".$category[1]->cat_name;
          	$keywords =  $cats." ".get_the_title()." ". get_bloginfo('name');
        }
        if($instance['keywordbytitle2']=="TitleOnly") {
          	$keywords =  get_the_title()." ". get_bloginfo('name');
        }
		if($instance['keywordbytitle2']=="Key") {
			$keywords = $instance ['keywords'];//key=from form
        }
		$keywords=trim(preg_replace("/\W+/"," ",preg_replace("/\d+/"," ",str_replace("Uncategorized"," ",str_replace("Enter Your Keywords"," ",$keywords)))));
		$keywords=trim($this->stopWords($keywords,plugin_dir_path( __FILE__ ).'stopwords.txt'));

	
        $adformat=$instance['adformat'];
        if($adformat=="5"){$adformat="3";}
        
        echo $before_widget;
        if ($title) {echo $before_title . $title. $after_title;}
        $height=$instance ['height'];
        $width=$instance ['width'];
?>
<div  style="padding:10px;background:#ffffff;border: <?php echo $instance['border']; ?>px solid #<?php echo $instance['bordcolor']; ?>; <?echo ($instance['bordstyle']=="1"?"border-radius:5px 5px 5px 5px;":"");?>;">
<iframe src="http://cbads.com/ads.php?a=<?php echo $instance['cbid'] ?>&lc=<?php echo $instance['linkcolor']; ?>&af=<?php echo $adformat ?>&f=1&key=<?php echo $keywords ?>&v=<?php echo $this->cbwecw_version?>" marginwidth="0" marginheight="0" width="<?php echo ($width=="100%"?"100%":($width-2)."px")?>" height="<?php echo $height ?>px" border="0" frameborder="0"  style="background:#ffffff;" scrolling="no"></iframe>
</div>
<?
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['cbid'] = strip_tags($new_instance['cbid']);
        $instance['keywords'] = strip_tags($new_instance['keywords']);
        if($instance['keywords']=="Enter Your Keywords"){$instance['keywords']="";}
        $instance['keywordbytitle2'] = strip_tags($new_instance['keywordbytitle2']);
        $instance['border'] = strip_tags($new_instance['border']);
        $instance['bordcolor'] = strip_tags($new_instance['bordcolor']);
        $instance['bordstyle'] = strip_tags($new_instance['bordstyle']);
        $instance['linkcolor'] = strip_tags($new_instance['linkcolor']);
        $instance['adformat'] = strip_tags($new_instance['adformat']);
        $instance['height'] = strip_tags($new_instance['height']);
        $instance['width'] = strip_tags($new_instance['width']);
               
        return $instance;
    }

    function form($instance) {
        $defaults = array('title' => __('Related eBooks', 'ClickBank'), 'cbid' => __('', 'ClickBank'), 'keywordbytitle2' => __('Title', 'ClickBank'), 'border' => __('', 'ClickBank'), 'bordcolor' => __('CCCCCC', 'ClickBank'), 'bordstyle' => __('1', 'ClickBank'), 'width' => __('100%', 'ClickBank'), 'height' => __('800', 'ClickBank'), 'adformat' => __('3', 'ClickBank'), 'linkcolor' => __('0000ff', 'ClickBank'));
        $instance = wp_parse_args((array) $instance, $defaults); 
        $tmstmp_ewc=substr(microtime(),2,7);
        if($instance['adformat']=="5"){$instance['adformat']="3";}
        ?>
        <script type="text/javascript" src="<?php echo plugins_url( '/jscolor/jscolor.js', __FILE__ );?>"></script>

        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label><br />
          <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:200px;" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('cbid'); ?>">Your Clickbank Nickname:</label><br /><a target="regs" href="http://artdhtml.reseller.hop.clickbank.net/"><font size=1>(Register here its FREE)</font></a><br/>
          <input onmouseover="f_init_ewc()" onfocus="f_init_ewc()" type="text" id="<?php echo $this->get_field_id('cbid'); ?>" name="<?php echo $this->get_field_name('cbid'); ?>" value="<?php echo $instance['cbid']; ?>" style="width:200px;" required />
        </p>
        <p>
          <label><input type="radio" <?php if($instance['keywordbytitle2']=="Title") {echo 'checked';}?> onclick="fk1=document.getElementById('dthidti<?echo $tmstmp_ewc;?>').style;if(this.value!='Key'){fk1.display='none';}" value="Title" id="<?php echo $this->get_field_id('keywordbytitle2'); ?>" name="<?php echo $this->get_field_name('keywordbytitle2'); ?>" style="border:0px;" /> Ads related to post Title & Category</label><br />
          <label><input type="radio" <?php if($instance['keywordbytitle2']=="TitleOnly") {echo 'checked';}?> onclick="fk1=document.getElementById('dthidti<?echo $tmstmp_ewc;?>').style;if(this.value!='Key'){fk1.display='none';}" value="TitleOnly" id="<?php echo $this->get_field_id('keywordbytitle2'); ?>1" name="<?php echo $this->get_field_name('keywordbytitle2'); ?>" style="border:0px;" /> Ads related to post Title</label><br />
          <label><input type="radio" <?php if($instance['keywordbytitle2']=="Key") {echo 'checked';}?> onclick="fk1=document.getElementById('dthidti<?echo $tmstmp_ewc;?>').style;if(this.value=='Key'){fk1.display='block';}" value="Key" id="<?php echo $this->get_field_id('keywordbytitle2'); ?>2" name="<?php echo $this->get_field_name('keywordbytitle2'); ?>" style="border:0px;" /> Ads related to Keywords:</label>
          <div id="dthidti<?echo $tmstmp_ewc;?>" style="overflow:hidden;height:30px;display: <?php echo ($instance['keywordbytitle2']=="Key"?"block;":"none");?>">
            <input type="text" id="<?php echo $this->get_field_id('keywords'); ?>" name="<?php echo $this->get_field_name('keywords'); ?>" value="<?php echo ($instance['keywords']==""? "Enter Your Keywords" : $instance['keywords']); ?>" onblur="if(this.value==''){this.value='Enter Your Keywords'}" onfocus="if(this.value=='Enter Your Keywords'){this.value=''}" style="width:200px;" />
          </div>
        </p>
        
		    <p>Width:<br />
		      <select onchange="document.getElementById('<?php echo $this->get_field_id('width'); ?>').value=this.value;" size="1" id="<?php echo $this->get_field_id('width'); ?>2" name="<?php echo $this->get_field_name('width'); ?>2" style="width:100px;">
		        <option value="100%" <?php if($instance['width']=="100%") {echo 'selected';}?>>100%</option>
		        <option value="110" <?php if($instance['width']=="110") {echo 'selected';}?>>110 px</option>
		        <option value="120" <?php if($instance['width']=="120") {echo 'selected';}?>>120 px</option>
		        <option value="140" <?php if($instance['width']=="140") {echo 'selected';}?>>140 px</option>
		        <option value="160" <?php if($instance['width']=="160") {echo 'selected';}?>>160 px</option>
		        <option value="180" <?php if($instance['width']=="180") {echo 'selected';}?>>180 px</option>
		        <option value="200" <?php if($instance['width']=="200") {echo 'selected';}?>>200 px</option>
		        <option value="220" <?php if($instance['width']=="220") {echo 'selected';}?>>220 px</option>
	        	<option value="240" <?php if($instance['width']=="240") {echo 'selected';}?>>240 px</option>
	        	<option value="260" <?php if($instance['width']=="260") {echo 'selected';}?>>260 px</option>
		        <option value="280" <?php if($instance['width']=="280") {echo 'selected';}?>>280 px</option>
		        <option value="300" <?php if($instance['width']=="300") {echo 'selected';}?>>300 px</option>
		        <option value="320" <?php if($instance['width']=="320") {echo 'selected';}?>>320 px</option>
	        	<option value="340" <?php if($instance['width']=="340") {echo 'selected';}?>>340 px</option>
	        	<option value="360" <?php if($instance['width']=="360") {echo 'selected';}?>>360 px</option>
	      	</select>
		      OR 
		      <input  type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" style="width:50px;" />
        </p> 
 
 		    <p>Height:<br />
		      <select onchange="document.getElementById('<?php echo $this->get_field_id('height'); ?>').value=this.value;f_pre_ewc(0,this.value);yg_pre_ewc=this.value" size="1" id="<?php echo $this->get_field_id('height'); ?>2" name="<?php echo $this->get_field_name('height'); ?>2" style="width:100px;">
		        <option value="200" <?php if($instance['height']=="200") {echo 'selected';}?>>200 px</option>
		        <option value="400" <?php if($instance['height']=="400") {echo 'selected';}?>>400 px</option>
		        <option value="600" <?php if($instance['height']=="600") {echo 'selected';}?>>600 px</option>
		        <option value="800" <?php if($instance['height']=="800") {echo 'selected';}?>>800 px</option>
		        <option value="1000" <?php if($instance['height']=="1000") {echo 'selected';}?>>1000 px</option>
		        <option value="1200" <?php if($instance['height']=="1200") {echo 'selected';}?>>1200 px</option>
	        	<option value="1400" <?php if($instance['height']=="1400") {echo 'selected';}?>>1400 px</option>
	        	<option value="1600" <?php if($instance['height']=="1600") {echo 'selected';}?>>1600 px</option>
	      	</select>
		      OR 
		      <input onchange="f_pre_ewc(0,this.value);yg_pre_ewc=this.value" type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $instance['height']; ?>" style="width:50px;" />
        </p> 
        
        

			<style>
			.cbwecwb10 {border: 1px solid #<?php echo $instance['bordcolor'] ?>;}
			.cbwecwb11 {color:#<?php echo $instance['linkcolor']; ?>;}
			</style>
         
     		<table border=0 cellspacing=0 cellpadding=0>
		     <tr><td>Ad Formats:</td><td style="padding-left:5px;">Preview:</td></tr>
		     <tr><td>
		      <select onchange="f_ad_ch_ewc(this.value)" size="1" id="<?php echo $this->get_field_id('adformat'); ?>" name="<?php echo $this->get_field_name('adformat'); ?>" style="width:177px;">
		        <option value="3" <?php if($instance['adformat']=="3") {echo 'selected';}?>>Vertical Banner</option>
		        <option value="4" <?php if($instance['adformat']=="4") {echo 'selected';}?>>Vertical Carousel</option>
		        <option value="5">Horizontal Banner or Carousel</option>
		      </select></td>
		      <td valign=top style="padding-left:5px;">
			  
			  <div class="cbwecwb10" id="d2bgewc<?echo $tmstmp_ewc;?>" style="position:absolute;"><div id=dbgewc<?echo $tmstmp_ewc;?> style="background: url(<?php echo plugins_url( 'prev.png', __FILE__ );?>) left top;"><img src=<?php echo plugins_url( '1.gif', __FILE__ );?> width=1 height=1></div></div>
			  
			  </td>
		     </tr>
		    </table>
		    <div id="dthidti2<?echo $tmstmp_ewc;?>" style="overflow:hidden;visibility: hidden;height:0px;">Widgets allow only vertical banners. For horizontal leaderboard, horizontal carousel and rectangle, go to the '<a href="options-general.php?page=clickbank-ads/clickbank-ads.php">Settings -> ClickBank Ads</a>' SubPanel and configure plugin.</div>
        <br />

        <p>
          <label for="<?php echo $this->get_field_id('border'); ?>">Show Border:</label>
          <input onmouseover="f_init_ewc();" onclick="f_ch_br(this.checked)" type="checkbox" <?php if($instance['border']=="1") {echo 'checked';}?> id="<?php echo $this->get_field_id('border'); ?>" name="<?php echo $this->get_field_name('border'); ?>" value="1" style="border:0px;" />
        </p>
          <div id="dthid<?echo $tmstmp_ewc;?>" style="overflow:hidden;display: <?php echo ($instance['border']=="1"?"block":"none");?>">
          Border Style:
        <br>
        <table border=0 width=100% cellspacing=0 cellpadding=0>
	        <tr>
		        <td width=50% valign=top align=center style="padding:0 10px 10px 0;">
				
				<div class="cbwecwb10" style="padding:3px;background:#ffffff; border-radius:5px 5px 5px 5px;">
					<table border=0 cellspacing=0 cellpadding=0><tr><td><label for="<?php echo $this->get_field_id('bordstyle'); ?>"><u class="cbwecwb11">Style</u> 1 </label></td><td>&nbsp;<input type="radio" <?php if($instance['bordstyle']=="1") {echo 'checked';}?> value="1" id="<?php echo $this->get_field_id('bordstyle'); ?>"  name="<?php echo $this->get_field_name('bordstyle'); ?>" style="margin-top:3px;border:0px;" /></td></tr></table>
				</div>
				</td>
            <td width=50% valign=top align=center style="padding:0 0 10px 10px;"><div class="cbwecwb10" style="padding:3px;"><label for="<?php echo $this->get_field_id('bordstyle'); ?>2"><u class="cbwecwb11">Style</u> 2 </label><input type="radio" <?php if($instance['bordstyle']=="2") {echo 'checked';}?> value="2" id="<?php echo $this->get_field_id('bordstyle'); ?>2" name="<?php echo $this->get_field_name('bordstyle'); ?>" style="margin-top:3px;border:0px;" /></div></td>
          </tr>
        </table>
        <table border=0 cellspacing=0 cellpadding=0><tr><td width=90 height=20><label for="<?php echo $this->get_field_id('bordcolor'); ?>">Border Color: </label></td><td>#<input onblur="f_ch_clb(this.value);" onmouseover="jscolor.bind()" class="color" type="text" id="<?php echo $this->get_field_id('bordcolor'); ?>" name="<?php echo $this->get_field_name('bordcolor'); ?>" value="<?php echo $instance['bordcolor']; ?>" style="width:70px;" /></td></tr></table>
      </div>

      <table border=0 cellspacing=0 cellpadding=0><tr><td width=90 height=20><label for="<?php echo $this->get_field_id('linkcolor'); ?>"><u class="cbwecwb11">Link Color: </u></label></td><td>#</span><input onblur="f_ch_cll(this.value);" onmouseover="jscolor.bind()" class="color" type="text" id="<?php echo $this->get_field_id('linkcolor'); ?>" name="<?php echo $this->get_field_name('linkcolor'); ?>" value="<?php echo $instance['linkcolor']; ?>" style="width:70px;" /></td></tr></table>
		<br><br>
      <script> 
		function f_ch_br(br_ch){
			dthidm=document.getElementById('dthid<?echo $tmstmp_ewc;?>').style;
			if(br_ch){dthidm.display='block';document.getElementById('d2bgewc<?echo $tmstmp_ewc;?>').style.borderWidth='1px';}
			else{dthidm.display='none';document.getElementById('d2bgewc<?echo $tmstmp_ewc;?>').style.borderWidth='0px';}
		}
        function f_ch_clb(cl5){
			var e = document.getElementsByTagName('div');
			for(var i=0; i<e.length; i+=1) {if(e[i].className && e[i].className=='cbwecwb10'){e[i].style.borderColor = '#'+cl5;}}
		}
        function f_ch_cll(cl5){
			var e = document.getElementsByTagName('u');
			for(var i=0; i<e.length; i+=1) {if(e[i].className && e[i].className=='cbwecwb11'){e[i].style.color = '#'+cl5;}}
		}
		//function f_in_obj(o9){r9="";for (i9 in o9)r9+=i9+"="+(o9[i9].toString()=="[object Object]"?"\n"+f_in_obj(o9[i9]):o9[i9])+"\n";return(r9);}//просмотр объекта

		function f_init_ewc(){
			var v_ewc_e = document.getElementsByTagName('div');//rename duplicate div's for first load
			divs_cnt=0;
			for(var v_ewc_i=0; v_ewc_i<v_ewc_e.length; v_ewc_i+=1) {if(v_ewc_e[v_ewc_i].id=='dthidti<?echo $tmstmp_ewc;?>') {divs_cnt++;}}
			if(divs_cnt<2){return;}//return if only 1 copy of divs
			for(var v_ewc_i=0; v_ewc_i<v_ewc_e.length; v_ewc_i+=1) {if(v_ewc_e[v_ewc_i].id=='dthidti<?echo $tmstmp_ewc;?>') {v_ewc_e[v_ewc_i].id=v_ewc_e[v_ewc_i].id+'old';break;}}
			for(var v_ewc_i=0; v_ewc_i<v_ewc_e.length; v_ewc_i+=1) {if(v_ewc_e[v_ewc_i].id=='dthidti2<?echo $tmstmp_ewc;?>') {v_ewc_e[v_ewc_i].id=v_ewc_e[v_ewc_i].id+'old';break;}}
			for(var v_ewc_i=0; v_ewc_i<v_ewc_e.length; v_ewc_i+=1) {if(v_ewc_e[v_ewc_i].id=='dthid<?echo $tmstmp_ewc;?>') {v_ewc_e[v_ewc_i].id=v_ewc_e[v_ewc_i].id+'old';break;}}
			for(var v_ewc_i=0; v_ewc_i<v_ewc_e.length; v_ewc_i+=1) {if(v_ewc_e[v_ewc_i].id=='dbgewc<?echo $tmstmp_ewc;?>') {v_ewc_e[v_ewc_i].id=v_ewc_e[v_ewc_i].id+'old';break;}}
			for(var v_ewc_i=0; v_ewc_i<v_ewc_e.length; v_ewc_i+=1) {if(v_ewc_e[v_ewc_i].id=='d2bgewc<?echo $tmstmp_ewc;?>') {v_ewc_e[v_ewc_i].id=v_ewc_e[v_ewc_i].id+'old';break;}}
        }
        

        var bg_ewci;
        var bg_ewc=0;		
        var n_ad_ch_ewcg;   
        function f_car_ewc(n_ad_ch_ewc){
          p_ad_ch_ewc=document.getElementById('dbgewc<?echo $tmstmp_ewc;?>');
          if(n_ad_ch_ewc=="4"){bg_ewci=setTimeout("if(bg_ewc<60){bg_ewc++;p_ad_ch_ewc.style.backgroundPosition='0 '+bg_ewc+'px'}else{bg_ewc=0};f_car_ewc(n_ad_ch_ewcg)", 40);}
          else{clearTimeout(bg_ewci);p_ad_ch_ewc.style.backgroundPosition='0 0';}
        }
        
        <?php 
        if($instance['border']!="1") {echo "document.getElementById('d2bgewc".$tmstmp_ewc."').style.borderWidth='0px';";}
        if($instance['adformat']=="3") {echo 'var xg_pre_ewc="160";var yg_pre_ewc="1000";';}
		    if($instance['adformat']=="4") {echo 'var xg_pre_ewc="160";var yg_pre_ewc="1000";';}
		    echo "var yg_pre_ewc=\"".$instance['height']."\";";
		    ?>
        
        function f_pre_ewc(x_pre_ewc,y_pre_ewc){
          p_ad_ch_ewc=document.getElementById('dbgewc<?echo $tmstmp_ewc;?>').style;
          if(x_pre_ewc!=0){
            if(x_pre_ewc=="100%"){x_pre_ewc=480;}if(x_pre_ewc<121){x_pre_ewc=120;};x_pre_ewc=x_pre_ewc/10;p_ad_ch_ewc.width= Math.floor(x_pre_ewc/12)*12+'px';p_ad_ch_ewc.marginRight=p_ad_ch_ewc.marginLeft=Math.floor((x_pre_ewc-Math.floor(x_pre_ewc/12)*12)/2)+'px';
            if(x_pre_ewc<49){document.getElementById('d2bgewc<?echo $tmstmp_ewc;?>').style.marginLeft=Math.floor(48-x_pre_ewc)+'px';}else{document.getElementById('d2bgewc<?echo $tmstmp_ewc;?>').style.marginLeft='0px';}
          }
          if(y_pre_ewc!=0){if(y_pre_ewc=="100%"){y_pre_ewc=800;}if(y_pre_ewc<201){y_pre_ewc=200;};if(y_pre_ewc>1000){y_pre_ewc=1000;};y_pre_ewc=y_pre_ewc/10;p_ad_ch_ewc.height=Math.floor(y_pre_ewc/20)*20+'px';p_ad_ch_ewc.marginTop=p_ad_ch_ewc.marginBottom=Math.floor((y_pre_ewc-Math.floor(y_pre_ewc/20)*20)/2)+'px';}
        
        clearTimeout(bg_ewci);f_car_ewc(n_ad_ch_ewcg)
        }
        
        f_pre_ewc(xg_pre_ewc,yg_pre_ewc);
        
        function f_ad_ch_ewc(n_ad_ch_ewc){
          n_ad_ch_ewcg=n_ad_ch_ewc;
          if(n_ad_ch_ewc=="3"){f_pre_ewc(160,yg_pre_ewc);}
          if(n_ad_ch_ewc=="4"){f_pre_ewc(160,yg_pre_ewc);}
          
          dthidti2=document.getElementById('dthidti2<?echo $tmstmp_ewc;?>').style;
          if(n_ad_ch_ewc=="5"){f_pre_ewc("100%",200);dthidti2.visibility="visible";dthidti2.height='62px';}else{dthidti2.visibility="hidden";dthidti2.height='0px';}
          f_car_ewc(n_ad_ch_ewc);
        }
		    <?php echo 'clearTimeout(bg_ewci);n_ad_ch_ewcg="'.$instance['adformat'].'";f_car_ewc("'.$instance['adformat'].'")';?>  //start carousel     
      </script>
<?php
    }
}
?>