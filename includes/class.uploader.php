<?php

/*********************************************************************************************

Author 	: SUMITH

Date	: 28-August-2013

Purpose	: Uploader class for image upload plugin

*********************************************************************************************/



class uploader extends UploadHandler

{

	protected $_properties;

	public $message;

	public $warning;

	//public $uploadfolder;

	//protected $category_id;

	protected $form_parameters	= array();

	

	function __construct($upload_folder)

	{

		$this->form_parameters['planning_id'] 				= isset($_SESSION['planning_id']) ? $_SESSION['planning_id'] : 0;
		$this->form_parameters['content_id'] 				= isset($_SESSION['content_id']) ? $_SESSION['content_id'] : 0;

		$this->form_parameters['upload_id'] 		= isset($_SESSION['upload_id'])? $_SESSION['upload_id']: 0;	

		$this->form_parameters['upload_type'] 		= isset($_SESSION['upload_type']) ? $_SESSION['upload_type']: '';

		$this->form_parameters['temp_timestamp'] 	= isset($_SESSION['temp_timestamp']) ?  $_SESSION['temp_timestamp']: '';

		if($upload_folder == 'planning_gallery')
		{
			$min_width	= PLANNING_GALLERY_MIN_WIDTH;
			$min_height = PLANNING_GALLERY_MIN_HEIGHT;		
		}
		
		if($upload_folder == 'content_gallery')
		{
			$min_width	= CONTENT_GALLERY_MIN_WIDTH;
			$min_height = CONTENT_GALLERY_MIN_HEIGHT;		
		}		

		parent::__construct($upload_folder, $min_width, $min_height);


		$this->_properties	= array();

		$this->message		= '';

		$this->warning		= false;

	}



	function __get($propertyName)
	{
		if (array_key_exists($propertyName, $this->_properties))
		{
			return $this->_properties[$propertyName];
		}

		return null;
	}

	public function __set($propertyName, $value)
	{
		return $this->_properties[$propertyName] = $value;
	}

	public function __destruct() 
	{
		unset($this->_properties);
	}

	protected function get_file_objects($iteration_method = 'get_file_object') {

		

        $upload_dir = $this->get_upload_path();

		

        if (!is_dir($upload_dir)) {

            return array();

        }


		

		if($this->upload_folder1 == 'planning_gallery')

		{
			$planning_gallery 		= new planning_gallery($this->form_parameters['upload_id']);
		   //$image_array		 =  $image_gallery->get_image_list_by_category($this->category_id);	

		   if(isset($_SESSION['upload_edit']) && $_SESSION['upload_edit'] == 1 && $this->form_parameters['upload_id'] > 0)

		   {

			   $planning_gallery 		= new planning_gallery($this->form_parameters['upload_id']);

			   $image_array 			= $planning_gallery->get_image_list_edit($planning_gallery->planning_gallery_id);

		   }

		   else

		   {	

		   		$image_array		 =  $planning_gallery->get_image_list_by_planning_gallery($this->form_parameters['planning_id']);	

		   }

		}
		
		if($this->upload_folder1 == 'content_gallery')

		{
			$content_gallery 		= new content_gallery($this->form_parameters['upload_id']);
		   //$image_array		 =  $image_gallery->get_image_list_by_category($this->category_id);	

		   if(isset($_SESSION['upload_edit']) && $_SESSION['upload_edit'] == 1 && $this->form_parameters['upload_id'] > 0)

		   {

			   $content_gallery 		= new content_gallery($this->form_parameters['upload_id']);

			   $image_array 			= $content_gallery->get_image_list_edit($content_gallery->content_gallery_id);

		   }

		   else

		   {	

		   		$image_array		 =  $content_gallery->get_image_list_by_content_gallery($this->form_parameters['content_id']);	

		   }

		}

        return array_values(array_filter(array_map(

            array($this, $iteration_method),

		    $image_array

            //scandir($upload_dir)

        )));

    }

	

	protected function handle_form_data($file, $index) {

        // Handle form data, e.g. $_REQUEST['description'][$index]

	   //return $_REQUEST['category_id'];

    }

	

	protected function handle_form_title($file, $index) {

        //$title= $_REQUEST['title'][$index];

       // return $title;

    }

	

	protected function handle_form_image_gallery_id($file, $index) {

        /*$image_gallery_id= $_REQUEST['image_gallery_id'][$index];

        return $image_gallery_id;*/

    }

	

	//Query execution

	public function query($query) {  		

		$database		= new database(); 

		$result			= $database->query($query);

		return $result;

	}  

	

	//Database entry for each image add

	public function add_img($whichimg)  

	{  


		if($this->upload_folder1 == 'planning_gallery')
		{
		   if(isset($_SESSION['upload_edit']) && $_SESSION['upload_edit'] == 1 && $this->form_parameters['upload_id'] > 0)
		   {
			   $planning_gallery 						= new planning_gallery($this->form_parameters['upload_id']);

			   $planning_gallery->image_name	 	    = $whichimg;

			   $planning_gallery->update_planning_gallery_image();
		   }
		   else
		   { 
		   		 $planning_gallery				 	   = new planning_gallery();

			     $planning_gallery->planning_id 	   		= $this->form_parameters['planning_id']; //$this->category_id;

		   		 //$image_gallery->title   		 = $title;

		   		 $planning_gallery->image_name	 	   = $whichimg;

		   		 $planning_gallery->save();
		   }
		}
		
		if($this->upload_folder1 == 'content_gallery')
		{
		   if(isset($_SESSION['upload_edit']) && $_SESSION['upload_edit'] == 1 && $this->form_parameters['upload_id'] > 0)
		   {
			   $content_gallery 						= new content_gallery($this->form_parameters['upload_id']);

			   $content_gallery->image_name	 	    = $whichimg;

			   $content_gallery->update_content_gallery_image();
		   }
		   else
		   { 
		   		 $content_gallery				 	   = new content_gallery();

			     $content_gallery->content_id 	   		= $this->form_parameters['content_id']; //$this->category_id;

		   		 //$image_gallery->title   		 = $title;

		   		 $content_gallery->image_name	 	   = $whichimg;

		   		 $content_gallery->save();
		   }
		}
	}

	

	//Delete from db for each delete

	public function delete_img($delimg)  

	{  		

		if($this->upload_folder1 == 'planning_gallery')
		{
		   if(isset($_SESSION['upload_edit']) && $_SESSION['upload_edit'] == 1 && $this->form_parameters['upload_id'] > 0)
		   {
			   $planning_gallery 						= new planning_gallery($this->form_parameters['upload_id']);
			   $planning_gallery->delete_planning_gallery_image($this->upload_folder1, $delimg);
		   }
		   else
		   {
			   $planning_gallery				 		= new planning_gallery();
			   $planning_gallery->remove_by_image($this->form_parameters['planning_id'],$delimg ); //$this->category_id  
		   }  
		}
		
		if($this->upload_folder1 == 'content_gallery')
		{
		   if(isset($_SESSION['upload_edit']) && $_SESSION['upload_edit'] == 1 && $this->form_parameters['upload_id'] > 0)
		   {
			   $content_gallery 						= new content_gallery($this->form_parameters['upload_id']);
			   $content_gallery->delete_content_gallery_image($this->upload_folder1, $delimg);
		   }
		   else
		   {
			   $content_gallery				 		= new content_gallery();
			   $content_gallery->remove_by_image($this->form_parameters['content_id'],$delimg ); //$this->category_id  
		   }  
		}
	}

	

	public static function delete_temp_upload()

	{

		/*$database		= new database(); 

		$sql 			= "SELECT * FROM upload_temp WHERE added_date < DATE(NOW())";

		$result			= $database->query($sql);

		if($result->num_rows > 0)

		{

			while($data 	= $result->fetch_object())

			{

				$folder 	= $data->folder;

				$path		= constant(strtoupper('DIR_'.$folder));

				

				if(file_exists($path . $data->image_name))

				{

					unlink($path . $data->image_name);

				}

				if(file_exists($path . 'thumbnail/' . $data->image_name))

				{

					unlink($path . 'thumbnail/' . $data->image_name);

				}

				if(file_exists($path . 'thumbnail/' . $data->image_name))

				{

					unlink($path . 'thumbnail/' . $data->image_name);

				}

				if(file_exists($path . 'thumbnail/thumbresize_' . $data->image_name))

				{

					unlink($path . 'thumbnail/thumbresize_' . $data->image_name);

				}

				if(file_exists($path . 'resize_' . $data->image_name))

				{

					unlink($path . 'resize_' . $data->image_name);

				}

				if(file_exists($path . 'thumb_' . $data->image_name))

				{

					unlink($path . 'thumb_' . $data->image_name);

				}

				 

			}

			

			$sql1 				= "DELETE FROM upload_temp WHERE added_date < DATE(NOW())";

			$result1			= $database->query($sql1);

		}	*/

	}



}

?>