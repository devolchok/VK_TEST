<form class="form-horizontal" method="post" id="login-form">
    <div class="form-group">
        <label for="inputLogin" class="col-sm-2 control-label">Логин</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputLogin" placeholder="Логин" name="login" maxlength="20">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword" class="col-sm-2 control-label">Пароль</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Пароль" name="password" maxlength="20">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" data-loading-text="Загрузка...">Войти</button>
        </div>
    </div>
</form>