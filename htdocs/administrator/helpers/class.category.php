<?php
include_once('class.dbobject.php');
class Category extends DBObject  {
	var $uses = "categories";

	function __construct($data=null)
	{
		parent::__construct($data,$this->uses);
	}
	
	function renderCategoriesAsOptions($sel_id=0)
	{
		$categories = $this->Find();
		foreach($categories as $category)
		{
			if($category->id == $sel_id)
			{
				echo "<option value=\"$category->id\" selected=\"selected\">$category->category_name</option>";
			}
			else
			{
				echo "<option value=\"$category->id\">$category->category_name</option>";
			}
		}
	}
}
?>