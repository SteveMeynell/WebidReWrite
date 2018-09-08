<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{L_5436} <i class="fa fa-angle-double-right"></i> {L_upload_data}</h2>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12">
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
						
						<input type="hidden" name="action" value="upload">
						<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
						<input type="submit" name="act" class="centre" value="{L_upload_data}">
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
<!-- INCLUDE footer.tpl -->
