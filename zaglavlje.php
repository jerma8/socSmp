<hr id="zaglavljeLinija" />
<div id="gornjiDio" class="row">
	<div class="large-4 small-6-centered columns">
		<img id="logokey" src="<?php echo $putanjaApp; ?>img/logo-key.png" alt=""/>
		<img id="logokey2" src="<?php echo $putanjaApp; ?>img/logo.png" alt=""/>
	</div>
	<div class="large-8 columns">
		<div id="formLogPanel" class="panel right">
			<div class="row">
				
				<?php
				if(!isset($_SESSION["operater"]) && !isset($_SESSION["korisnik"])
				&& !isset($_SESSION["donator"])
				&& !isset($_SESSION["tvrtka"])):
				?>
				
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="large-4 columns">
							<label for="korisnik">Korisničko Ime:</label>
							<input type="text" id="korisnik" name="korisnik" />
						</div>			
						<div class="large-4 columns">
							<label for="lozinka">Lozinka:</label>
							<input type="password" id="lozinka" name="lozinka" />
						</div>
						<div class="large-2 end columns">
							<input 
							id="autoriziraj" 
							type="submit" 
							class="button round" 
							value="Login" 
							data-reveal-id="myModal"
							/>
						</div>
				</form>
				
				<?php
				else:
				?>
				
				<div class="large-8 columns">
					<div class="row paddingLeft">
						<div class="large-12">
							Dobrodošli<br />
							
							<i class="fi-torso small"></i>&nbsp;&nbsp;<?php 
									//ispitaj tko je logiran			
									if (isset($_SESSION["operater"])) {
										echo $_SESSION["operater"]->ime ." ". $_SESSION["operater"]->prezime." (".$_SESSION["operater"]->korisnik.")";
									}else
									if (isset($_SESSION["korisnik"])) {
										echo $_SESSION["korisnik"]->ime ." ". $_SESSION["korisnik"]->prezime." (".$_SESSION["korisnik"]->korisnik.")";
									}else
									if (isset($_SESSION["donator"])) {
										echo $_SESSION["donator"]->ime ." ". $_SESSION["donator"]->prezime." (".$_SESSION["donator"]->korisnik.")";
									}else
									if (isset($_SESSION["tvrtka"])) {
										echo $_SESSION["tvrtka"]->ime ." ". $_SESSION["tvrtka"]->prezime." (".$_SESSION["tvrtka"]->korisnik.")";
									}?>
									
									
									
							<b>
								<br />
							<a href="<?php echo $putanjaApp; ?>privatno/	
								<?php 
		
									//ispitaj tko je logiran			
									if (isset($_SESSION["operater"])) {
										echo "operateri";
									}else
									if (isset($_SESSION["korisnik"])) {
										echo "korisnici";
									}else
									if (isset($_SESSION["donator"])) {
										echo "donatori";
									}else
									if (isset($_SESSION["tvrtka"])) {
										echo "tvrtke";
									}
							
								?>/index.php">Nadzorna ploča</a>
						</b>		
						</div>
						
						
						
					</div>
				</div>			
				<div class="large-4 columns">
					<a class="button round marginTopLogout" href="<?php echo $putanjaApp; ?>logout.php">Logout</a>
				</div>
				
				<?php
				endif;
				?>
			</div>
		</div>
	</div>
</div>
