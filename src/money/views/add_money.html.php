<form class="form-horizontal" method="post" id="add-money-form">
    <div class="form-group">
        <label for="inputMoney" class="col-sm-2 control-label">Сумма</label>
        <div class="col-sm-10">
            <div class="input-group">
                <input type="text" class="form-control" id="inputMoney" placeholder="0" name="money" maxlength="7">
                <div class="input-group-addon">.00</div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" data-loading-text="Загрузка...">Пополнить</button>
        </div>
    </div>
</form>