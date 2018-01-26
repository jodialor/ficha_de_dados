<style>
@import "bourbon";

body {
	background: #eee !important;	
}

.wrapper {	
	margin-top: 80px;
	margin-bottom: 80px;
}

.form-signin {
  max-width: 380px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid rgba(0,0,0,0.1);  
  border-radius:25px;
  
  .form-signin-heading,
	.checkbox {
	  margin-bottom: 30px;
	}

	.checkbox {
	  font-weight: normal;
	}

	.form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
		@include box-sizing(border-box);

		&:focus {
		  z-index: 2;
		}
	}

	input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}

	input[type="password"] {
	  margin-bottom: 20px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
	
}
</style>

<div class="wrapper">
	<div style="text-align: center; color: #004b8d">
		<img src="../images/logoGOV.png" alt="Logo GOV/SRE"/><br><br>
		<p> DIREÇÃO DE SERVIÇOS DE EDUCAÇÃO ARTÍSTICA E MULTIMÉDIA </p>
	</div>
	<br><br>
	<div class="round">
		<form class="form-signin rr" method='POST' action='auth.php?a=1'>       
			
			<h2 class="form-signin-heading">Autenticação</h2>
			
			<div class='input-group'>
				<span class='input-group-addon' id='basic-addon1'> <span class='glyphicon glyphicon-user' aria-hidden='true'></span></span>
				<input type='text' class='form-control' placeholder='Utilizador' aria-describedby='basic-addon1' name='login'>
			</div>
			
			<div class='input-group' style="margin-top: 5%;">
				<span class='input-group-addon' id='basic-addon1'> <span class='glyphicon glyphicon-lock' aria-hidden='true'></span></span>
				<input type='Password' minlength=3 class='form-control' placeholder='Password' aria-describedby='basic-addon1' name='password'>
			</div>      
			<div style="margin-top: 5%;">
				<button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-sign-in"></i> Entrar</button>  
			</div>
		</form>
	</div>
</div>