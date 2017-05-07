<h2>Zaloguj się do serwisu</h2>
<hr />
<div class="row">
    <div class="col-md-6 col-md-offset-3 well well-md animated fadeIn">
         <form class="form-horizontal" method="POST" action="index.php?con=3&page=3">
		 
			<div class="form-group animated pulse" style="padding-top:20px; padding-bottom:10px;" >
                <div class="col-sm-8 col-sm-offset-2 text-center">
                    <img src="Content\images\als.png" alt="..." width="220px" class="img-thumbnail">
                </div>
            </div>
		 
            <div class="form-group" style="">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Wprowadź adres email..." required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Hasło:</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="pwd" placeholder="Wprowadź hasło..." required>
                </div>
            </div>
			
			<div class="form-group">
				<div class="checkbox col-sm-4 col-sm-offset-2">
					<label><input type="checkbox" name="remember">Zapamiętaj mnie</label>
				</div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success btn-default">Zaloguj się</button>
                </div>
            </div>
        </form>
    </div>
</div>