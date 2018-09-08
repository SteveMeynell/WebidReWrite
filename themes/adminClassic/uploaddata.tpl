		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5436}&nbsp;&gt;&gt;&nbsp;{L_upload_data}</h4>
				<form name="uploaddata" action="" method="post" enctype="multipart/form-data">
					<div class="container">
						<div class="col-md-3">
							<select name="table">
								<option value="countries">Country Table</option>
								<option value="currency_codes">Currency Code Table</option>
								<option value="city_codes">City Code Table</option>
								<option value="province_codes">Province Code Table</option>
								<option value="Reporting">Reporting Options</option>
							</select>
						</div>
						<div class="col-md-3">
							<input type="file" id="myFile" name="myFile" accept=".json,.cvs,.xml">
						</div>
						
						
					</div>
					<div class="container">
						<input type="radio" id="ftype" name="ftype" value="json" checked> JSON<br>
						<input type="radio" id="ftype" name="ftype" value="cvs"> CVS<br>
						<input type="radio" id="ftype" name="ftype" value="xml"> XML 
						<p>Need a radio button for file format.  ie JSON, XML, CVS</p>
						<p>Need a file input area</p>
						<p>Need a button to upload...</p>
					
						<input type="hidden" name="action" value="upload">
						<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
						<input type="submit" name="act" class="centre" value="{L_upload_data}">
					</div>
				</form>
			</div>
		</div>
