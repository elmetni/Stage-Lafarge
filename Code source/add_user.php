<?php session_start();

			if(!isset($_SESSION['loged']) or $_SESSION['loged']!=1 )
				{
						header('location:login.php');
				
				
				}
				
		
			try
			{
				$db=new PDO('mysql:host='.$_SERVER['HTTP_HOST'].';dbname=intervention','root','');
			}
			catch(exception $e)
			{
				die('Error :'.$e->getmessage());
			}
		$R_user=$db->prepare('SELECT * FROM user WHERE id_user=:id');
		$R_user->execute(array(
							'id'=>$_SESSION['id']
							));
		$D_user=$R_user->fetch();
		
		if($D_user['statue_account']=="disable" OR $D_user==false)
		{
				session_destroy();
				header('location:login.php');
		}
		
		

	
		
		if(isset($_POST['logout']))
			{
		session_destroy();
		setcookie('login', $d['login'], $time -60*60*24*7,null, null,false,true);
		setcookie('password', $d['password'], $time -60*60*24*7,null, null,false,true);
		header('location:login.php');

			}
		if($D_user['type_account']=="user")
		header('location:home.php');
		

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title> Ajouter un utilisateur </title>';?>
				<link href="style.css" rel="stylesheet" type="text/css" media="screen" >
		</head>
		
		<body>
		<div id="all" >
		<div id="header">
		
		</div> <!---------------- header -------------------->
<ul id="menu">
		
				<li><a href="administration.php"  >Demandes</a></li>
				<li><a href="item.php" >Articles</a></li>
				<li><a href="message_controle.php"> Messages</a></li>
				<li><a href="profile_controle.php">Utilisateurs</a></li>	
		</ul>
	
		
		<p class="clear"></p>
		
		<?php
		
				echo'<a href="add_user.php" id="add_item"> add </a>';
				

							$error=0;
							
							echo'<div class="add_test">';
							echo'<form method="POST"  action="add_user.php"  enctype="multipart/form-data">';
							
								echo'<div class="add_test_title"><p  > Ajouter un Utilisateur </p></div>';
								
								
								
									
								echo'<p class="main">* Nom  : <input type="text" name="add_user_first" ';
								
								if(isset($_POST['add_user_first'])) echo 'value="'.$_POST['add_user_first'].'"';
								echo'>';
								
								
								 echo' </p>';
								if(isset($_POST['add_user']) && $_POST['add_user_first']=="")
										{
												echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
												$error=1;
												
										
										}
								 echo'<p class="main">* Prénom  : <input type="text" name="add_user_last"';
								
								if(isset($_POST['add_user_last'])) echo 'value="'.$_POST['add_user_last'].'"';
								echo'>';
								
								
								 echo' </p>';
								 if(isset($_POST['add_user']) && $_POST['add_user_last']=="")
										{
												echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
												$error=1;
												
										
										}
								  echo'<p class="main">* Identifiant (pour se connecter): <input type="text" name="add_user_login"';
								
								if(isset($_POST['add_user_login'])) echo 'value="'.$_POST['add_user_login'].'"';
								echo'>';
								
								
								 echo' </p>';
								 if(isset($_POST['add_user']) && $_POST['add_user_login']=="")
										{
												echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
												$error=1;
												
										
										}
								else if(isset($_POST['add_user']) && $_POST['add_user_login']!="")
										{
												$g=$db->prepare('SELECT * FROM user WHERE login=:login');
												$g->execute(array(
														'login'=>$_POST['add_user_login']
														));
												$t=$g->fetch();
												if($t!=false)
												{
												
												echo'<span class="error" ><img src="images/waring2.png"> Identifiant déja exist </span>' ;
												$error=1;
												
												}
												
												
												
										
										}
								  echo'<input type="submit" name="add_user" class="add_test" value="">';
								 
								  echo'<p class="main">* Mot de passe &nbsp; : &nbsp;&nbsp;<input type="password" name="add_user_password"';
								
								if(isset($_POST['add_user_password'])) echo 'value="'.$_POST['add_user_password'].'"';
								echo'></P>';
								  
								  if(isset($_POST['add_user']) && $_POST['add_user_password']=="")
										{
												echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
												$error=1;
												
										
										}
										else if(isset($_POST['add_user']) && strlen($_POST['add_user_password'])<8  && $_POST['add_user_password']!="")
										{
												echo'<span class="error" ><img src="images/waring2.png"> le mot de passe doit être de plus de 8 caractères</span>' ;
												$error=1;
												
										
										}
									echo'<p class="main">* Re-Mot de passe  : <input type="password" name="add_user_re_password"';
								
								if(isset($_POST['add_user_re_password'])) echo 'value="'.$_POST['add_user_re_password'].'"';
								echo'></P>';
								 if(isset($_POST['add_user']) && $_POST['add_user_re_password']!=$_POST['add_user_password'])
										{
												echo'<span class="error" ><img src="images/waring2.png">s\'il vous plaît confirmer le mot de passe</span>' ;
												$error=1;
												
										
										}
								
								  echo'<p class="main">* Type de compte  : ' ;
								  echo ' <select name="statue"><option value="user" ';
								  
								  if(isset($_POST['statue'])&& $_POST['statue']=="user") echo ' selected ';
								  
								  echo'> Utilisateur </option><option value="administrator" ';
								  
								  if(isset($_POST['statue'] )&& $_POST['statue']=="administrator") echo ' selected ';
								  echo '>administrateur  </option></select></p>';
							
								echo'<p class="main">Fonction : <input type="text" name="fonction"';
								
								if(isset($_POST['fonction'])) echo 'value="'.$_POST['fonction'].'"';
								echo'></p>';
							
							
								
								echo'<p class="main">Departement  : <input type="text" name="departement"';
								
								if(isset($_POST['departement'])) echo 'value="'.$_POST['departement'].'"';
								echo'></p>';
								
								
								echo'<p class="main">Télephone  : <input type="text" name="add_user_Telephone"';
								
								if(isset($_POST['add_user_Telephone'])) echo 'value="'.$_POST['add_user_Telephone'].'"';
								echo'></p>';
								echo'<p class="main">Email  : <input type="text" name="add_user_email"';
								
								if(isset($_POST['add_user_email'])) echo 'value="'.$_POST['add_user_email'].'"';
								echo'></p>';
								echo'<p class="main">Numéro de matricule  : <input type="text" name="add_user_nm"';
								
								if(isset($_POST['add_user_nm'])) echo 'value="'.$_POST['add_user_nm'].'"';
								echo'></p>';
								
								
								echo'<p class="main">Image : <input type="FILE" name="user_image"';
								
								
								echo'></p>';
					
					
					
					if(isset($_POST['add_user']) && $_FILES['user_image']['error']!=0 && $_FILES['user_image']['size']!=0)
						{

										echo'<span class="error" ><img src="images/waring2.png"> Erreur de Téléchargement .. essayer plus tard</span>' ;
												$error=1;


						}
					else if(isset($_POST['add_user']) && $_FILES['user_image']['error']==0 && $_FILES['user_image']['size']!=0)
					{
								if(isset($_POST['add_user']) && $_FILES['user_image']['error']!=0 && $_FILES['user_image']['size']> 4000000)
								{

												echo'<span class="error" ><img src="images/waring2.png">le size d\'image doit être inférieure à 4 mo</span>' ;
														$error=1;


								}
								else
								{
										$infosfichier = pathinfo($_FILES['user_image']['name']);
										$extension_upload = $infosfichier['extension'];
										$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png','flv','bmp','JPG','JPEG','GIF','PNG','FLV','BMP');
										if (in_array($extension_upload, $extensions_autorisees)==false)
										{
											echo'<span class="error" ><img src="images/waring2.png">incorrect extention </span>' ;
														$error=1;
								
								
								
										}
								}
						}
					

			
			
					if(isset($_POST['add_user']) && $error==0)
					{
					
							
							if($_FILES['user_image']['size']==0)
							$image="images/pic.png";
							else
							{
									
									
									$da=$_POST['add_user_first'].'_'.$_POST['add_user_last'].'_'.date('Y').'_'.date('m').'_'.date('d').'_'.date('h').'_'.date('i').'_'.$_POST['add_user_nm'];

									
									$infosfichier = pathinfo($_FILES['user_image']['name']);
									$extension_upload = $infosfichier['extension'];
									$image='user/'.$da.'.'.$extension_upload;
									move_uploaded_file($_FILES['user_image']['tmp_name'], $image);
							
							}
				
							$R1=$db->prepare('INSERT INTO user VALUES(\'\',:login,:password,:statue,\'enable\',:picture,:nm,:fonction,:departement,:first,:last,:telephone,:email)');
												
							$R1->execute(array(
											'login'=>$_POST['add_user_login'],
											'password'=>$_POST['add_user_password'],
											'statue'=>$_POST['statue'],
											'picture'=>$image,
											'nm'=>$_POST['add_user_nm'],
											'fonction'=>$_POST['fonction'],
											'departement'=>$_POST['departement'],
											'first'=>$_POST['add_user_first'],
											'last'=>$_POST['add_user_last'],
											'telephone'=>$_POST['add_user_Telephone'],
											'email'=>$_POST['add_user_email'],
											
										)
										);
							
							header('location:profile_controle.php');
					
					
					
					
					
					
					}
				echo'</div>';
				
				
				
				?>
			
			<br>
			
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>