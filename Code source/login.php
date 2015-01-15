<?php 
					session_start();
					$error=0;
					if(isset($_SESSION['loged']) AND $_SESSION['loged']==1)
					{
							header('location:home.php');
					}
					if( isset($_COOKIE['login']) AND isset($_COOKIE['password']))
					{
					
						try
								{
										$bd=new PDO('mysql:host='.$_SERVER['HTTP_HOST'].';dbname=intervention','root','');
								}
								catch(exception $e)
								{
									die('error :'.$e->getmessage());
								}
								
								$R=$bd->prepare('SELECT * FROM user WHERE login= :login');
								$R->execute(array(
											'login'=>strtolower($_COOKIE['login'])
											));
								$d=$R->fetch();
								if($d==false OR $d['login']!=strtolower($_COOKIE['login']) OR $d['password']!=$_COOKIE['password'])
								{
										setcookie('login', $d['login'], $time -60*60*24*7,null, null,false,true);
										setcookie('password', $d['password'], $time -60*60*24*7,null, null,false,true);
										
										$error=1;
								}
								else if($d==true AND $d['login']==strtolower($_COOKIE['login']) AND $d['password']==$_COOKIE['password'])
								{
										$_SESSION['loged']=1;
										$_SESSION['login']=$d['login'];
										$_SESSION['id']=$d['id_user'];
									
										$R->closeCursor();
										header('location:home.php');
							
								}
					}
								
						else
						{
					
					
					
										
										if(isset($_POST['login_password']) &&  isset($_POST['login_login']) && $_POST['login_login']!="" && $_POST['login_password']!="")
											{
													try
													{
															$bd=new PDO('mysql:host='.$_SERVER['HTTP_HOST'].';dbname=intervention','root','');
													}
													catch(exception $e)
													{
														die('error :'.$e->getmessage());
													}
													
													$R=$bd->prepare('SELECT * FROM user WHERE login= :login');

													$R->execute(array(
																'login'=>strtolower($_POST['login_login'])
																));
													$d=$R->fetch();
													
													 if($d==true && $_POST['login_password']==$d['password'].'x97899137efzgt')
													{
														$F=$bd->prepare('UPDATE user SET statue_account=\'enable\' WHERE id_user=:id');
														$F->execute(array(
																'id'=>$d['id_user']
																));
														$error=3;
													
													}
													
													else if($d==false OR $d['login']!=strtolower($_POST['login_login']) OR $d['password']!=$_POST['login_password'] )
													{
															$error=1;
													}
													else if($d['statue_account']=="disable")
													{
														$error=2;
													}
													
													
													else if($d==true AND $d['login']==strtolower($_POST['login_login']) AND $d['password']==$_POST['login_password'] AND $d['statue_account']=="enable" )
													{
															$_SESSION['loged']=1;
															$_SESSION['login']=$d['login'];
															$_SESSION['id']=$d['id_user'];
															
																		if(isset($_POST['remember']) && $_POST['remember']=='yes')
																		{
																				
																				setcookie('login', $d['login'], time()+60*60*24*365);
																				setcookie('password', $d['password'], time()+ 60*60*24*365);
																		
																		}
																		
																
															$R->closeCursor();
															header('location:home.php');
															
													}
													
													
													
											}
									
									
							}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//FR"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html>
		<head>
				<title> Bienvenue </title>
				<link rel="stylesheet" type="text/css" href="style.css" media="screen">
		</head>
		
		<body id="login">
	
			<div id="all_login" >
								
									
								
					
					
			
						
															
						
										
										<?php if($error==1 OR (isset($_POST['login_email']) && $_POST['login_email']=="" &&  isset($_POST['login_password']) && $_POST['login_password']==""  ))
												echo' <p class="error"> <img src="images/waring.png"> incorrect mot de passe  ou identificateur </p>';
												else if($error==2)
												echo' <p class="error"> <img src="images/waring.png">Votre compte a été desactivé par l\'administration</p>';
												
												else if($error==3)
												echo' <p class="error"> <img src="images/waring.png">Votre compte a été activé ... Bienvenue!</p>';
										
										?>
										<div id="login" >
										<form action="login.php" method="post" >
												<div class="login_champ"><input type="text" name="login_login" id="login_email"  <?php if(isset($_POST['login_login'])) echo'value="'.htmlspecialchars($_POST['login_login']).'"';?>>
												<input type="password" name="login_password" id="login_password"  <?php if(isset($_POST['login_password'])) echo'value="'.htmlspecialchars($_POST['login_password']).'"';?>>
												</div>
												<div id="remember"><input type="checkbox" name="remember" id="remember_me" value="yes" > <label for="remember_me"> Mémorise-Moi </label></div>
												
												<input type="submit" name="login_botton" value="login" id="login_botton">
										</form>
				
				
						</div><!------------ login---------------->
				<p class="clear"></p>
					
				</div><!------ Alll ---------------------------->	
			</body>
	</html>