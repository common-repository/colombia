<style>
.clmb-container {
        padding: 20px;
        padding-left: 0;
        width: 500px;
        font-size: 14px;
    }

 table td img {
        position: relative;
        top: 3px;
        margin-left: 5px;
    }

 table tr td:first-child {
        width: 110px;
    }
 table input {
        width: 100%;
    }
 input[type='text'] {
        border-radius: 3px;
    }
  hr {
        margin-top: 15px;
        margin-bottom: 15px;
        border-bottom: none;
    }
input[type='checkbox'] {

    }
input[type='submit']{
        float: right;
    }
  .checkbox {
        margin-bottom: 10px;
    }

  .tooltip div {
        background-color: black;
        color: white;
        border-radius: 5px;
        opacity: 0;
        position: absolute;
        -webkit-transition: opacity 0.5s;
        -moz-transition: opacity 0.5s;
        -ms-transition: opacity 0.5s;
        -o-transition: opacity 0.5s;
        transition: opacity 0.5s;
        width: 200px;
        padding: 10px;
        margin-left: 30px;
        margin-top: -45px;
    }
 table .tooltip:hover div {
        opacity:1;
    }
	
 .clmb_wrap {
	margin:20px 20px 0 2px !important;
}
.submit_btn{
        margin-top: 30px !important;
    }
.msg {
	margin-top: 30px !important;
}
.success {
	font-size: 15px;
	color: green;
}
.error {
	font-size: 15px;
	color: red;
	margin-top: 10px !important;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance:textfield;
}	
</style>
		<div class="clmb-container">	
			<div class="wrap clmb_wrap">
				<div class="row">
				 <img src='<?php echo CLMB_PLUGIN_URL.'/img/colombia_icon.png' ?>' style='width:200px;'/>
				<hr />
				<form method="post" class="validate form">
					<div class='checkbox'>
					<?php $isarticle_enabled = sanitize_text_field($this->getsettings['baticle_is_enabled']);
						  $post_article = sanitize_text_field($_POST['below_article_enabled']); 	
					?>
						<input id="below_article_enabled" type="checkbox" <?php echo $isarticle_enabled ? $isarticle_enabled : $post_article ? "checked='checked'" : "" ?> name="below_article_enabled"/>
						Below Article
					</div>
					<table>
						<tr>
							<td>Ad Slot ID</td>
							<?php $article_slot = sanitize_text_field($this->getsettings['baticle_slt_id']);
								  $post_slot = sanitize_text_field($_POST['below_article_slot_id']); 	
							?>
							<td>
								<input type="number" required maxlength="7" value="<?php echo $article_slot ? $article_slot : $post_slot ?>" name="below_article_slot_id" placeholder="Ad Slot ID" />
							</td>
							<td class='tooltip'>
								<img src='<?php echo CLMB_PLUGIN_URL.'/img/question-mark.png' ?>'/>
								<div>Please contact your Colombia representative to receive the Ad Slot ID</div>
							</td>
						</tr>
						<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td ><input class='button-secondary submit_btn' type="submit" value="Apply Changes" /></td>
						</tr>
						
			  </table>
			</form>
			</div>
			<div class="msg">
				<?php
					if($_SERVER['REQUEST_METHOD'] == 'POST' && count($errors) == 0){
						echo "<div class='success'>Your changes have been made! You can now see them on your site</div>";
					}
				if(count($errors) > 0){
					for($i = 0; $i < count($errors); $i++){
						echo "<div class='error'>".$errors[$i]."</div>";
					}
				}
			?>
			</div>
		</div>
	 </div>