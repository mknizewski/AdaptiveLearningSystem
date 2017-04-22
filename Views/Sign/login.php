<h2>Zaloguj się do serwisu</h2>
<hr />
<div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
         <form class="form-horizontal" method="POST" action="index.php?con=3&page=3">
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Wprowadź adres email">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Hasło:</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="pwd" placeholder="Wprowadź hasło">
                </div>
            </div>

            <div class="checkbox">
                <label><input type="checkbox" name="remember">Zapamiętaj mnie</label>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Zaloguj się</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
    </div>
</div>