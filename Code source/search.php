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
		
	
		
		function mois($m)
{
		$month=0;
		if($m==1)$month="Janvier";
		else if($m==2) $month="Février";
		else if($m==3) $month="Mars";
		else if($m==4) $month="Avril";
		else if($m==5) $month="Mai";
		else if($m==6) $month="Juin";
		else if($m==7) $month="Juillet";
		else if($m==8) $month="août";
		else if($m==9) $month="Septembre";
		else if($m==10) $month="Octobre";
		else if($m==11) $month="Novembre";
		else if($m==12) $month="Décembre";
		return $month;
		}

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title> Recherche </title>';?>
				<link href="style.css" rel="stylesheet" type="text/css" media="screen" >
		</head>
		
		<body>
		<script language="JavaScript">
		
		
												<!--
												function Resize(id){
													var newheight;
													

													if(document.getElementById){
														newheight=document.getElementById(id).contentWindow.document .body.scrollHeight+40;
														
													}

													document.getElementById(id).height= (newheight) + "px";
													
												}
												//-->
												</script>
		<div id="all" >
		<div id="header">
		<?php
				echo'<div id="user_bar">';
					echo'<form action='.$_SERVER['PHP_SELF'].' method="POST">
											<input type="submit" name="logout" id="logout" title="logout" >
											</form>';
					echo'<p class="name">'.$D_user['last'].' '.$D_user['first'].' </p>';
					
					echo'<img src="'.$D_user['picture_user'].'" height=55 width=55>';
					echo'<div>';
					
					$R1=$db->query('SELECT COUNT(*) AS message FROM message ');
																						
																						
																						$number=$R1->fetch();
																						$resultat1=$number['message'];
																						
				
					$R3=$db->prepare('SELECT COUNT(*) AS m FROM message WHERE id_sender=:id_user ');
																						$R3->execute(array(
																									'id_user'=>$_SESSION['id']
																									)
																									);
																						
																						$number=$R3->fetch();
																						$resultat3=$number['m'];
																						
					$R3=$db->prepare('SELECT COUNT(*) AS a FROM read_message WHERE id_user=:id_user ');
																						$R3->execute(array(
																									'id_user'=>$_SESSION['id']
																									)
																									);
																						
																						$number=$R3->fetch();
																						$resultat4=$number['a'];
																						
					$resultat1=$resultat1-$resultat3-$resultat4;
																						
					$R2=$db->query('SELECT COUNT(*) AS request FROM request WHERE  statue_request=\'none\'');
																					
																						
																						$number=$R2->fetch();
																						$resultat2=$number['request'];
					
					
					
					echo'<p> Messages : '.$resultat1.'</p>';
					echo'<p> Demandes : '.$resultat2.'</p>';
					
					
				echo'</div></div>';
					
					
		
		?>
		
		</div> <!---------------- header -------------------->
<ul id="menu">
		
				<li><a href="administration.php"   >Demandes</a></li>
				<li><a href="item.php" >Articles</a></li>
				<li><a href="message_controle.php"> Messages</a></li>
				<li><a href="profile_controle.php">Utilisateurs</a></li>		
		</ul>
	
		
		<p class="clear"></p>
		
		<?php
		
				echo'<a id="search" href="search.php"> here </a>';
				
					

						echo'<form method="GET" action="search.php" >';
						echo'<div  class="search">';
										
						echo'<p class="first">Article : ' ;
						echo'<select name="article" id="arctile1" >';
						echo'<option value="-1*-1">choisir</option>';
						$R=$db->query('SELECT * FROM item GROUP BY type_item');
						while($D=$R->fetch())
						{
						
								echo'<optgroup label="'.$D['type_item'].'">';
												$R_category=$db->prepare('SELECT * FROM item WHERE type_item=:type_item ');
												 $R_category->execute(array(
														'type_item'=>$D['type_item']
														));
														
												while($D_category=$R_category->fetch())
												{
												
													echo'<option value="'.$D_category['category'].'*-1" class="category" >'.$D_category['category'].'</option>';
														
													$R_item=$db->prepare('SELECT * FROM item WHERE type_item=:type_item  AND category=:category');
													$R_item->execute(array(
														'type_item'=>$D['type_item'],
														'category'=>$D_category['category']
														));
													while($D_item=$R_item->fetch())
													{
															echo'<option value="'.$D_category['category'].'*'.$D_item['id_item'].'" >'.$D_item['name_item'].'</option>';
													
													}
												
												}
						
						
						
						}
						echo'</select></p>';
						
						echo'<p class="first"> Utilisateur ';
						echo'<select name="user" id="arctile" >';
						echo'<option value="-1">choisir</option>';
						$R2=$db->query('SELECT * FROM user ');
						while($D2=$R2->fetch())
						{
								echo'<option value="'.$D2['id_user'].'">'.$D2['last'].' '.$D2['first'].'</option>';
						
						}
						
						echo'</select></p>';
						
						echo'<p class="first"> Statue ';
						echo'<select name="statue" id="arctile" >';
						echo'<option value="-1">choisir</option>';
						
						echo'<option value="none"> Pas vu </option>';
						echo'<option value="seen"> Vu </option>';
						echo'<option value="accepted">  Accepté </option>';
						echo'<option value="rejected">  Refusé </option>';
						
						
						
						echo'</select></p>';
						
						echo'<input type="submit" name="search_main_botton"  id="search_main_botton" >';
						echo' <p class="date_search">  de :  ';
						echo' <select name="from_search_day" id="from_search" class="day" >
							';
						echo'<option value="1" selected> </option>';
							for($i=1;$i<=31;$i++)
							{
								
								echo'<option value="'.$i.'"';
								
								
								
								echo'>'.$i.'</option>';		
								
							}
						echo'</select>';
						
							echo'<select name="from_search_month" class="month">
							';
							echo'<option value="1" selected> </option>';
							for($i=0;$i<12;$i++)
							{
								$g=$i+1;
								echo'<option value="'.$g.'"';
								
								
								
								echo'>'.mois($g).'</option>';		
								
							}
						echo'</select>';
						echo'<select name="from_search_year" class="day">
							';
							echo'<option value="2007" selected> </option>';
							for($i=2009;$i<=date('Y');$i++)
							{
								
								echo'<option value="'.$i.'"';
								
							
								
								echo'>'.$i.'</option>';		
								
							}
						echo'</select>';
						
						
						echo' A : <select name="to_search_day" id="from_search" class="day">
							';
							echo'<option value="1" selected> </option>';
							for($i=1;$i<=31;$i++)
							{
								
								echo'<option value="'.$i.'"';
								
							
								
								echo'>'.$i.'</option>';		
								
							}
						echo'</select>';
						
							echo'<select name="to_search_month" class="month">
							';
							echo'<option value="1" selected> </option>';
							for($i=0;$i<12;$i++)
							{
								$g=$i+1;
								echo'<option value="'.$g.'"';
								
								
								
								echo'>'.mois($g).'</option>';		
								
							}
						echo'</select>';
						echo'<select name="to_search_year" class="day">
							';
							echo'<option value="2060" selected> </option>';
							for($i=2009;$i<=date('Y');$i++)
							{
								
								echo'<option value="'.$i.'"';
								
							 
								
								echo'>'.$i.'</option>';		
								
							}
						echo'</select></p>';
						
						
						
						
						echo'</div></form>';
							if(isset($_GET['search_main_botton']))
										
					ECHO'<iframe src="search_body.php?article='.$_GET['article'].'&statue='.$_GET['statue'].'&user='.$_GET['user'].'&from_search_day='.$_GET['from_search_day'].'&from_search_month='.$_GET['from_search_month'].'&from_search_year='.$_GET['from_search_year'].'&to_search_day='.$_GET['to_search_day'].'&to_search_month='.$_GET['to_search_month'].'&to_search_year='.$_GET['to_search_year'].'&search_main_botton=Submit+Query&limit=60&order=time_request&nature=DESC" height="300" marginheight="0" name="search_body" id="search_body" width="950" SCROLLING="no" NORESIZE FRAMEBORDER="0" onLoad="Resize(\'search_body\');"></iframe>';
						echo'<br>';
				
				
				
				
		
		
		?>
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>