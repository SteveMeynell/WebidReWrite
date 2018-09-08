    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2>{L_5142} <i class="fa fa-angle-double-right"></i> {L_25_0007}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-12">
                    <form name="currency_rates" action="" method="post">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                        <input type="submit" name="act" class="centre" value="{L_071}">
                    </form>
                        <table class="table table-bordered table-striped">
                            <caption>Currency Rates as of {RATEDATE} based on {DEFAULTCURRENCY}</caption>
                            <tr>
                                <th><b>{L_currencyCode}</b></th>
                                <th><b>{L_currency_name}</b></th>
                                <th><b>{L_currencyRate}</b></th>
                            </tr>
<!-- BEGIN rates -->
                            <tr>
                                <td>{rates.CCODE}</td>
                                <td>{rates.CNAME}</td>
                                <td>{rates.CRATE} <a href="currencytrends.php?id={rates.CCODE}"><button type="button" >Trend</button></a></td>
                            </tr>
<!-- END rates -->
                        </table>
                    
                </div>
            </div>
        </div>
    </div>
<!-- INCLUDE footer.tpl -->
