<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2>{L_5142} <i class="fa fa-angle-double-right"></i> {L_25_0007}</h2>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <caption>Currency Rate Changes over Time for {CCODE} {CNAME}</caption>
                    <tr>
                        <th><b>{L_currency_date}</b></th>
                        <th><b>{L_currencyRate}</b></th>
                    </tr>
<!-- BEGIN rates -->
                    <tr>
                        <td>{rates.CDATE}</td>
                        <td>{rates.CRATE}</td>
                    </tr>
<!-- END rates -->
                </table>
                <div class="clearfix"></div>
                {CHART}
                    
            </div>
        </div>
    </div>
</div>

<!-- INCLUDE footer.tpl -->