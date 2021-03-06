<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">{L_report_this_item}</div>
		<div class="titTable3">
			<a href="item.php?id={ID}">{L_138}</a>
		</div>
<!-- IF ITEMREPORTED eq '' -->
		<div align="center" class="padding">
			<p>
			<b>{L_017} : {TITLE}</b><br>
			<b>{L_auction_has_been_reported}</b>
			</p>
		</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<form name="item_report" action="item_report.php" method="post">
			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			<table width="90%" cellpadding="4" cellspacing="0">
			<tr>
				<td align="right" width="45%"><b>{L_017}</b></td>
				<td align="left">{TITLE}</td>
			</tr>
			<tr>
				<td align="right"><b>{L_reason_for_report}</b></td>
				<td align="left">
					<select id="reason" name="reason">
						<option value="">Select from the following</option>
<!-- BEGIN excuses -->
						<option value="{excuses.REASON_NUM}">{excuses.REASON}</option>
<!-- END excuses -->
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">{CAPCHA}</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="action" value="reportitem">
					<input type="submit" name="" value="{L_report_item}" class="button">
				</td>
			</tr>
			</table>
		</form>
<!-- ENDIF -->
	</div>
</div>