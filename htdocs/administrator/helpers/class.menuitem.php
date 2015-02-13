<?php
include_once('class.dbobject.php');
class MenuItem extends DBObject  {
	var $uses = "menuitems";

	function __construct($data=null)
	{
		parent::__construct($data,$this->uses);
	}
	
	function Find($limit = null,$id = 'all',$field='id',$order='desc',$cols=array('id'))
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if(intval($id) > 0)
					{
						$sql = "select t.*,a.title as article_title from ".$this->_uses." t left outer join articles a on t.article = a.id where t.id = ".$id." order by $field $order limit 0,1";
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$item = $result->fetch();
					}
					else
					{
						if($id=='all')
						{
							$sql = "select * from ".$this->_uses." order by $field $order $limit";
						}else
						{
							$sql = "select ".join(',',$cols)." from ".$this->_uses." order by $field $order $limit";
						} 			  			
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						while($data = $result->fetch())
						{
							$item[] = $data;
						}
					}
				}
			catch(Exception $e)
				{
				 	  //exception $e->getMessage()
				}
		return $item;
	}
	
	function _getParent($child)
	{
		$parent_info = array('parent'=>-1,'child_count'-1);
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($child)>0)
		{
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$stmt = $conn->prepare("select parent,(select count(id) from $this->uses where parent = ?) as child_count from $this->uses where id = ? limit 1");
					$stmt->execute(array($child,$child));
					$parent_info = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			catch(Exception $e)
				{
				 	 // print $e->getMessage();
				}
		}
		return $parent_info;
	}
	
	function _dash($level)
	{
		for($i=0;$i<=$level;$i++)
		{
			$dash .= "&nbsp;";
		}
		$dash .="-";
		return $dash;
	}
	
	function renderMenuItemsAsList($menu_mod,$t,$id = 0,$level = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$stmt = $conn->prepare("select id,menuitem_name,parent,url,article,published from $this->uses where parent = $id and mod_menu_id = $menu_mod order by menuitem_order asc");
					//print "select id,menuitem_name,parent from $this->uses where parent = $id";
					$stmt->execute();
					while( $menuitem = $stmt->fetch(PDO::FETCH_OBJ) )
					{
						$actions = '&nbsp;&nbsp;<a href="edit_menuitem.php?menuitem='.$menuitem->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="process_menuitem.php?action=delete&menu='.$menu_mod.'&menuitem='.$menuitem->id.'" onclick="return confirmDelete(\''.trim(addslashes($menuitem->menuitem_name)).'\',\''.$menuitem->id.'\')">'.$t->translate('delete').'</a>';
						if(!empty($menuitem->url) || intval($menuitem->article) > 0){ $color = "green";}
						else{$color="red";}
						if($menuitem->published==1):
							$pub_image = '<img src="images/tick.png" />';
						else:
							$pub_image = '<img src="images/untick.png" />';
						endif;
						print "<li>$pub_image<font color=\"$color\">".$menuitem->menuitem_name."</font>".$actions;
						$p = $this->_getParent($menuitem->id);
						if(intval($p['child_count'])>0)
						{
							//this has submenus
							$level++;
							print "<ul>";
							$this->renderMenuItemsAsList($menu_mod,$t,$menuitem->id,$level);
							print "</ul>";
						}
						else
						{
							print "</li>";
						}
					}
				}
			catch(Exception $e)
				{
				 	  print $e->getMessage();
				}
	}
	
	function renderMenuItems($lang='jp',$menu_mod_name,$display="list",$id = 0,$level = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		$link = "#";
		$baseurl=BASEURL;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					//echo "select t.id,t.menuitem_name,t.parent,t.url,t.article from $this->uses t inner join mod_menu m on t.mod_menu_id = m.id inner join languages l on m.language_id = l.id where t.parent = $id and m.menu_unique_name = '$menu_mod_name' and m.published = 1 and t.published = 1 and l.abbr = '$lang' order by menuitem_order asc";
					$stmt = $conn->prepare("select t.id,t.menuitem_name,t.parent,t.url,t.article from $this->uses t inner join mod_menu m on t.mod_menu_id = m.id inner join languages l on m.language_id = l.id where t.parent = $id and m.menu_unique_name = '$menu_mod_name' and m.published = 1 and t.published = 1 and l.abbr = '$lang' order by id asc");
					//print "select id,menuitem_name,parent from $this->uses where parent = $id";
					$stmt->execute();
					while( $menuitem = $stmt->fetch(PDO::FETCH_OBJ) )
					{
						if(intval($menuitem->article)>0){
							$link = "page/".$menuitem->article;
						}else{
							$link = '';
						}
						if(!empty($menuitem->url)){
								$link = $menuitem->url;
						}
						$selected ="";
						if($link== $_GET['option'].".htm" ) { $selected ="selected"; }
						switch($display)
						{
							case 'footer-style':
									if($count==0){
										print "<a href=".$baseurl.$link."><span>".$menuitem->menuitem_name."</span></a> ";
									}else{
										print " | <a href=".$baseurl.$link."><span>".$menuitem->menuitem_name."</span></a>";
									}
									break;
							case 'list':
									if($count==0){
										print "<li class='first ". $selected ."'><a href='".$baseurl.$link."'><span>".$menuitem->menuitem_name."</span></a></li><li class='separator'>&nbsp;";
									}else{
										print "<li class=\"". $selected ."\"><a href='".$baseurl.$link."'><span>".$menuitem->menuitem_name."</span></a></li><li class='separator'>&nbsp;";
									}
									break;
						}
						$p = $this->_getParent($menuitem->id);
						if(intval($p['child_count'])>0)
						{
							//this has submenus
							$level++;
							switch($display)
							{
								case 'footer-style':
										$this->renderMenuItems($lang,$menu_mod_name,$display,$menuitem->id,$level);
										break;
								case 'list':
										print "<ul id='top_menu'>";
										$this->renderMenuItems($lang,$menu_mod_name,$display,$menuitem->id,$level);
										print "</ul>";
										break;
							}
							
						}
						else
						{
							switch($display)
							{
								case 'footer-style':
										//this is nothing
										break;
								case 'list':
										print "</li>";
										break;
							}
						}
						$count++;
					}
				}
			catch(Exception $e)
				{
				 	  print $e->getMessage();
				}
	}
	
	function getChildrens($parent)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$stmt = $conn->prepare("select id,parent from $this->uses where parent = $parent");
					$stmt->execute();
					while( $menuitem = $stmt->fetch(PDO::FETCH_OBJ) )
					{
						$children[] = $menuitem->id;
						$p = $this->_getParent($menuitem->id);
						if(intval($p['child_count'])>0)
						{
							$this->getChildrens($menuitem->id);
						}
					}
				}
			catch(Exception $e)
				{
				 	  print $e->getMessage();
				}	
		return $children;	
	}
	
	function renderMenuItemsAsOptions($menu_mod,$id = 0,$level = 0,$sel_id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$stmt = $conn->prepare("select id,menuitem_name,parent from $this->uses where parent = $id and mod_menu_id = $menu_mod order by menuitem_order asc");
					$stmt->execute();
					while( $menuitem = $stmt->fetch(PDO::FETCH_OBJ) )
					{
						if($menuitem->id == $sel_id)
						{
							print "<option value=\"$menuitem->id\" selected=\"selected\">".$this->_dash($level).$menuitem->menuitem_name."</option>";
						}
						else
						{
							print "<option value=\"$menuitem->id\">".$this->_dash($level).$menuitem->menuitem_name."</option>";
						}
						$p = $this->_getParent($menuitem->id);
						if(intval($p['child_count'])>0)
						{
							$level++;
							$this->renderMenuItemsAsOptions($menu_mod,$menuitem->id,$level,$sel_id);
							$level--;
						}
					}
				}
			catch(Exception $e)
				{
				 	  print $e->getMessage();
				}
	}
}

?>