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
		
		<link href="frame.css" rel="stylesheet" type="text/css" media="screen" >
		</head>
		
		<body>
<div id="all" >

<?php

if(isset($_GET['search_main_botton']))
{

											 
							$tab=explode('*',$_GET['article']);
							$inf=$_GET['from_search_year'].'-'.$_GET['from_search_month'].'-'.$_GET['from_search_day'].' 00:00:00';
							$sub=$_GET['to_search_year'].'-'.$_GET['to_search_month'].'-'.$_GET['to_search_day'].' 00:00:00';
							
							
							
						
							
											 echo'<table class="search_body"><tr class="th"><th></th>';
											 
											echo' <th> <a href="search_body.php?article='.$_GET['article'].'&statue='.$_GET['statue'].'&user='.$_GET['user'].'&from_search_day='.$_GET['from_search_day'].'&from_search_month='.$_GET['from_search_month'].'&from_search_year='.$_GET['from_search_year'].'&to_search_day='.$_GET['to_search_day'].'&to_search_month='.$_GET['to_search_month'].'&to_search_year='.$_GET['to_search_year'].'&search_main_botton=Submit+Query&limit=60&order=name_item';
											if($_GET['nature']=="DESC") echo'&nature=ESC';
											else if($_GET['nature']=="ESC") echo'&nature=DESC';
											echo '"> Article ';
											if($_GET['order']=="name_item" && $_GET['nature']=="ESC") echo '<img src="images/esc.png">';
											else if($_GET['order']=="name_item" && $_GET['nature']=="DESC") echo '<img src="images/desc.png" >';
											echo'</a> </th>';
											
											
											
											echo' <th> <a href="search_body.php?article='.$_GET['article'].'&statue='.$_GET['statue'].'&user='.$_GET['user'].'&from_search_day='.$_GET['from_search_day'].'&from_search_month='.$_GET['from_search_month'].'&from_search_year='.$_GET['from_search_year'].'&to_search_day='.$_GET['to_search_day'].'&to_search_month='.$_GET['to_search_month'].'&to_search_year='.$_GET['to_search_year'].'&search_main_botton=Submit+Query&limit=60&order=type_item';
											if($_GET['nature']=="DESC") echo'&nature=ESC';
											else if($_GET['nature']=="ESC") echo'&nature=DESC';
											echo '"> type ';
											if($_GET['order']=="type_item" && $_GET['nature']=="ESC") echo '<img src="images/esc.png">';
											else if($_GET['order']=="type_item" && $_GET['nature']=="DESC") echo '<img src="images/desc.png" >';
											echo'</a> </th>';
											
											
											
											echo' <th> <a href="search_body.php?article='.$_GET['article'].'&statue='.$_GET['statue'].'&user='.$_GET['user'].'&from_search_day='.$_GET['from_search_day'].'&from_search_month='.$_GET['from_search_month'].'&from_search_year='.$_GET['from_search_year'].'&to_search_day='.$_GET['to_search_day'].'&to_search_month='.$_GET['to_search_month'].'&to_search_year='.$_GET['to_search_year'].'&search_main_botton=Submit+Query&limit=60&order=category';
											if($_GET['nature']=="DESC") echo'&nature=ESC';
											else if($_GET['nature']=="ESC") echo'&nature=DESC';
											echo '"> Category ';
											if($_GET['order']=="category" && $_GET['nature']=="ESC") echo '<img src="images/esc.png">';
											else if($_GET['order']=="category" && $_GET['nature']=="DESC") echo '<img src="images/desc.png" >';
											echo'</a> </th>';
											
											
											echo' <th> <a href="search_body.php?article='.$_GET['article'].'&statue='.$_GET['statue'].'&user='.$_GET['user'].'&from_search_day='.$_GET['from_search_day'].'&from_search_month='.$_GET['from_search_month'].'&from_search_year='.$_GET['from_search_year'].'&to_search_day='.$_GET['to_search_day'].'&to_search_month='.$_GET['to_search_month'].'&to_search_year='.$_GET['to_search_year'].'&search_main_botton=Submit+Query&limit=60&order=id_user';
											if($_GET['nature']=="DESC") echo'&nature=ESC';
											else if($_GET['nature']=="ESC") echo'&nature=DESC';
											echo '"> Utilisateur ';
											if($_GET['order']=="id_user" && $_GET['nature']=="ESC") echo '<img src="images/esc.png">';
											else if($_GET['order']=="id_user" && $_GET['nature']=="DESC") echo '<img src="images/desc.png" >';
											echo'</a> </th>';
											
											
											echo' <th> <a href="search_body.php?article='.$_GET['article'].'&statue='.$_GET['statue'].'&user='.$_GET['user'].'&from_search_day='.$_GET['from_search_day'].'&from_search_month='.$_GET['from_search_month'].'&from_search_year='.$_GET['from_search_year'].'&to_search_day='.$_GET['to_search_day'].'&to_search_month='.$_GET['to_search_month'].'&to_search_year='.$_GET['to_search_year'].'&search_main_botton=Submit+Query&limit=60&order=time_request';
											if($_GET['nature']=="DESC") echo'&nature=ESC';
											else if($_GET['nature']=="ESC") echo'&nature=DESC';
											echo '"> Date ';
											if($_GET['order']=="time_request" && $_GET['nature']=="ESC") echo '<img src="images/esc.png">';
											else if($_GET['order']=="time_request" && $_GET['nature']=="DESC") echo '<img src="images/desc.png" >';
											echo'</a> </th>';
											
											echo' <th> <a href="search_body.php?article='.$_GET['article'].'&statue='.$_GET['statue'].'&user='.$_GET['user'].'&from_search_day='.$_GET['from_search_day'].'&from_search_month='.$_GET['from_search_month'].'&from_search_year='.$_GET['from_search_year'].'&to_search_day='.$_GET['to_search_day'].'&to_search_month='.$_GET['to_search_month'].'&to_search_year='.$_GET['to_search_year'].'&search_main_botton=Submit+Query&limit=60&order=quantity_request';
											if($_GET['nature']=="DESC") echo'&nature=ESC';
											else if($_GET['nature']=="ESC") echo'&nature=DESC';
											echo '"> Quantité ';
											if($_GET['order']=="quantity_request" && $_GET['nature']=="ESC") echo '<img src="images/esc.png">';
											else if($_GET['order']=="quantity_request" && $_GET['nature']=="DESC") echo '<img src="images/desc.png" >';
											echo'</a> </th>';
											
											echo' <th> <a href="search_body.php?article='.$_GET['article'].'&statue='.$_GET['statue'].'&user='.$_GET['user'].'&from_search_day='.$_GET['from_search_day'].'&from_search_month='.$_GET['from_search_month'].'&from_search_year='.$_GET['from_search_year'].'&to_search_day='.$_GET['to_search_day'].'&to_search_month='.$_GET['to_search_month'].'&to_search_year='.$_GET['to_search_year'].'&search_main_botton=Submit+Query&limit=60&order=statue_request';
											if($_GET['nature']=="DESC") echo'&nature=ESC';
											else if($_GET['nature']=="ESC") echo'&nature=DESC';
											echo '"> Statue ';
											if($_GET['order']=="statue_request" && $_GET['nature']=="ESC") echo '<img src="images/esc.png">';
											else if($_GET['order']=="statue_request" && $_GET['nature']=="DESC") echo '<img src="images/desc.png" >';
											echo'</a> </th>';
											
											
											
											
											
											
											
											
											if($_GET['nature']=="ESC") $nature=" ";
											else if($_GET['nature']=="DESC") $nature="DESC";
												
									if($_GET['order']=="name_item" OR $_GET['order']=="type_item" OR $_GET['order']=="category")
											{
											
																				
												if($tab[0]==-1 && $tab[1]==-1)
												$Q=$db->query('SELECT * FROM item ORDER BY '.$_GET['order'].' '.$nature.'');
									
												else if($tab[0]!=-1 && $tab[1]==-1)
												{
												$Q=$db->prepare('SELECT * FROM item WHERE category=:category ORDER BY '.$_GET['order'].' '.$nature.'');
												$Q->execute(array(
														'category'=>$tab[0]
														));
												}
												else
												{
													$Q=$db->prepare('SELECT * FROM item WHERE id_item=:id ORDER BY '.$_GET['order'].' '.$nature.'');
													$Q->execute(array(
														'id'=>$tab[1]
														));
												
												
												}
												$i=1;
												while($G=$Q->fetch())
												{
														
														if($_GET['user']==-1 && $_GET['statue']==-1 )
														{
															$Q3=$db->prepare('SELECT * FROM request WHERE id_item=:id AND time_request>=:inf AND time_request<=:sub ');
															$Q3->execute(array(
															'id'=>$G['id_item'],															
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
															
														else if($_GET['user']!=-1 && $_GET['statue']==-1 )
														{
															$Q3=$db->prepare('SELECT * FROM request WHERE id_item=:id AND id_user=:id_user AND  time_request>=:inf AND time_request<=:sub ');
															$Q3->execute(array(
															'id'=>$G['id_item'],
															'id_user'=>$_GET['user'],
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
															
														else if($_GET['user']==-1 && $_GET['statue']!=-1 )
														{
															$Q3=$db->prepare('SELECT * FROM request WHERE id_item=:id AND statue_request=:statue AND  time_request>=:inf AND time_request<=:sub ');
															$Q3->execute(array(
															'id'=>$G['id_item'],
															'statue'=>$_GET['statue'],
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
														
														else
														{
														
															$Q3=$db->prepare('SELECT * FROM request WHERE id_item=:id AND statue_request=:statue AND id_user=:id_user AND  time_request>=:inf AND time_request<=:sub ');
															$Q3->execute(array(
															'id'=>$G['id_item'],
															'statue'=>$_GET['statue'],
															'id_user'=>$_GET['user'],
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
														
														
														
														
															
														
					
														
														
														
														while($G3=$Q3->fetch())
														{
																$R_request=$db->prepare('SELECT * FROM user WHERE id_user=:id ');
																$R_request->execute(array(
																					'id'=>$G3['id_user']
																					));
																$D_sender=$R_request->fetch();
																					
														
																echo '<tr> <td>'.$i.' </td><td><a  target="_top" href="request_controle.php?id='.$G3['id_request'].'&type=show" class="name_item" ><img src="'.$G['image_item'].'" width="40" height="40">'.$G['name_item'].'</a></td><td>'.$G['type_item'].'</td><td>'.$G['category'].'</td><td class="name_item"><a   target="_top" href="show_user.php?operation=show&id='.$D_sender['id_user'].'"><img  src="'.$D_sender['picture_user'].'" width="40" height="40"></a>'.$D_sender['first'].' '.$D_sender['last'].'<a id="send_mini2" href="send_controle.php?id='.$D_sender['id_user'].'"> SEND </a></td><td>'.$G3['time_request'].'</td><td>'.$G3['quantity_request'].'</td>';
																 echo'<td> ';
																 if($G3['statue_request']=="none") echo'<a target="_top" href="request_controle.php?id='.$G3['id_request'].'&type=show" class="none">  </a> Pas vu';
																 else if($G3['statue_request']=="seen") echo'<a target="_top" href="request_controle.php?id='.$G3['id_request'].'&type=show" class="seen"> seen </a> vu  ';
																 else if($G3['statue_request']=="rejected") echo'<a target="_top" href="request_controle.php?id='.$G3['id_request'].'&type=show" class="rejected"> seen </a> Refusé ';
																 else if($G3['statue_request']=="accepted") echo'<a target="_top" href="request_controle.php?id='.$G3['id_request'].'&type=show" class="accepted"> seen </a> accepté ';

																 
																 
																 echo'</tr>';
															
																
																
																$i++;
														}
													}
												
											}
											else if($_GET['order']=="id_user" OR $_GET['order']=="time_request"  OR $_GET['order']=="quantity_request" OR $_GET['order']=="statue_request"   )
											{
												if($tab[1]==-1 )
												{
												
														if($_GET['user']==-1 && $_GET['statue']==-1 )
														{
															$Q3=$db->prepare('SELECT * FROM request WHERE  time_request>=:inf AND time_request<=:sub  ORDER BY '.$_GET['order'].' '.$nature.' ');
															$Q3->execute(array(
																													
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
															
														else if($_GET['user']!=-1 && $_GET['statue']==-1 )
														{
															$Q3=$db->prepare('SELECT * FROM request WHERE id_user=:id_user AND  time_request>=:inf AND time_request<=:sub ORDER BY '.$_GET['order'].' '.$nature.' ');
															$Q3->execute(array(
													
															'id_user'=>$_GET['user'],
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
															
														else if($_GET['user']==-1 && $_GET['statue']!=-1 )
														{
															$Q3=$db->prepare('SELECT * FROM request WHERE statue_request=:statue AND  time_request>=:inf AND time_request<=:sub ORDER BY '.$_GET['order'].' '.$nature.'');
															$Q3->execute(array(
															
															'statue'=>$_GET['statue'],
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
														
														else
														{
														
															$Q3=$db->prepare('SELECT * FROM request WHERE statue_request=:statue AND id_user=:id_user AND  time_request>=:inf AND time_request<=:sub ORDER BY '.$_GET['order'].' '.$nature.' ');
															$Q3->execute(array(
															
															'statue'=>$_GET['statue'],
															'id_user'=>$_GET['user'],
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
															
												
												}
												else 
												{
													
														if($_GET['user']==-1 && $_GET['statue']==-1 )
														{
															$Q3=$db->prepare('SELECT * FROM request WHERE  id_item=:id AND time_request>=:inf AND time_request<=:sub  ORDER BY '.$_GET['order'].' '.$nature.' ');
															$Q3->execute(array(
															'id'=>$tab[1],													
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
															
														else if($_GET['user']!=-1 && $_GET['statue']==-1 )
														{
															$Q3=$db->prepare('SELECT * FROM request WHERE  id_item=:id AND  id_user=:id_user AND  time_request>=:inf AND time_request<=:sub ORDER BY '.$_GET['order'].' '.$nature.' ');
															$Q3->execute(array(
															'id'=>$tab[1],	
															'id_user'=>$_GET['user'],
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
															
														else if($_GET['user']==-1 && $_GET['statue']!=-1 )
														{
															$Q3=$db->prepare('SELECT * FROM request WHERE  id_item=:id AND  statue_request=:statue AND  time_request>=:inf AND time_request<=:sub ORDER BY '.$_GET['order'].' '.$nature.'');
															$Q3->execute(array(
															'id'=>$tab[1],
															'statue'=>$_GET['statue'],
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
														
														else
														{
														
															$Q3=$db->prepare('SELECT * FROM request WHERE id_item=:id AND statue_request=:statue AND id_user=:id_user AND  time_request>=:inf AND time_request<=:sub ORDER BY '.$_GET['order'].' '.$nature.' ');
															$Q3->execute(array(
															'id'=>$tab[1],
															'statue'=>$_GET['statue'],
															'id_user'=>$_GET['user'],
															'inf'=>$inf,
															'sub'=>$sub
															
															));
															
															}
															
												
												}
												$i=1;
												while($G3=$Q3->fetch())
														{
																$R_request=$db->prepare('SELECT * FROM user WHERE id_user=:id ');
																$R_request->execute(array(
																					'id'=>$G3['id_user']
																					));
																$D_sender=$R_request->fetch();
																
																if($tab[0]==-1)
																{
																	$Q=$db->prepare('SELECT * FROM item WHERE id_item=:id');
																	$Q->execute(array(
																			'id'=>$G3['id_item']
																			));
																	$G=$Q->fetch();																
																
																
																}
																else
																{	
																	$Q=$db->prepare('SELECt * FROM item WHERE id_item=:id AND category=:category');
																	$Q->execute(array(
																			
																			'id'=>$G3['id_item'],
																			'category'=>$tab[0]
																			));
																	$G=$Q->fetch();									
																
																
																
																}
																if($G)
																{
																
																echo '<tr> <td>'.$i.' </td><td class="name_item"><a target="_top" href="request_controle.php?id='.$G3['id_request'].'&type=show" ><img src="'.$G['image_item'].'" width="40" height="40">'.$G['name_item'].'</a></td><td>'.$G['type_item'].'</td><td>'.$G['category'].'</td><td class="name_item"><a  target="_top"  href="show_user.php?operation=show&id='.$D_sender['id_user'].'"><img  src="'.$D_sender['picture_user'].'" width="40" height="40"></a>'.$D_sender['first'].' '.$D_sender['last'].'<a id="send_mini2" href="send_controle.php?id='.$D_sender['id_user'].'"> SEND </a></td><td>'.$G3['time_request'].'</td><td>'.$G3['quantity_request'].'</td>';
																 echo'<td> ';
																 if($G3['statue_request']=="none") echo'<a target="_top" href="request_controle.php?id='.$G3['id_request'].'&type=show" class="none">  </a> Pas vu';
																 else if($G3['statue_request']=="seen") echo'<a target="_top" href="request_controle.php?id='.$G3['id_request'].'&type=show" class="seen"> seen </a> vu  ';
																 else if($G3['statue_request']=="rejected") echo'<a target="_top"  href="request_controle.php?id='.$G3['id_request'].'&type=show" class="rejected"> seen </a> Refusé ';
																 else if($G3['statue_request']=="accepted") echo'<a target="_top"  href="request_controle.php?id='.$G3['id_request'].'&type=show" class="accepted"> seen </a> accepté ';

																 
																 
																 echo'</tr>';
															
																
																
																$i++;						
																
																
																}
																					
																					
																					
																					
																					}
												
											
												
											}
												
											
											
							echo' </table>';
							
}
?>
<p class="clear"></p>
</div>
</body>
</html>