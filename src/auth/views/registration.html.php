<form class="form-horizontal" id="registration-form">
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
        <label for="inputPassword2" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword2" placeholder="Повторите пароль" name="repeatedPassword" maxlength="20">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <div class="radio">
                <label>
                    <input type="radio" name="user_type" id="optionsRadios1" value="customer" checked>
                    Заказчик
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="user_type" id="optionsRadios2" value="performer">
                    Исполнитель
                </label>
            </div>
        </div>

    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" data-loading-text="Загрузка...">Зарегистрироваться</button>
        </div>
    </div>
</form>